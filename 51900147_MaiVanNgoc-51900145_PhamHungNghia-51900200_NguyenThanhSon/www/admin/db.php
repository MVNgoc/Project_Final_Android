<?php

	#  https://www.w3schools.com/php/php_mysql_select.asp
 
    // $conn = new mysqli($host, $user, $pass, $db);
    // $conn->set_charset("utf8");
    // if ($conn->connect_error) {
    //     die('Không thể kết nối database: ' . $conn->connect_error);
    // }
	// echo "";

    function open_database() {
        $host = 'mysql-server'; // tên mysql server
        $user = 'root';
        $pass = 'root';
        $db = 'user'; // tên databse

        $cont = new mysqli($host, $user, $pass, $db);
        if($cont -> connect_error) {
            die('Connect error: ' . $cont->connect_error);
        }
        return $cont;
    }

	function login($user, $pass) {
		$sql = "SELECT * FROM account WHERE username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if(!$stm->execute()) {
            return null;
        }

        $result = $stm->get_result();

        if($result->num_rows == 0) {
            return array('code' => 1, 'error' => 'Tài khoản không tồn tại'); // khong co user ton tai
        }

        $data = $result->fetch_assoc();

        $hashed_password = $data['pass'];   
        if(!password_verify($pass, $hashed_password)) {
            return array('code' => 2, 'error' => 'Sai mật khẩu'); 
        }
        else {
            return array('code' => 0, 'error' => '', 'data' => $data, 'positionid' => $data['positionid'], 'id' => $data['id'], 'sex' => $data['sex'],
            'firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'department_name' => $data['department_name'], 
            'email' => $data['email'], 'phone_number' => $data['phone_number'], 'avatar' => $data['avatar']);
        }
	}

    function changepass($cfpass, $user) {
        $hash = password_hash($cfpass, PASSWORD_BCRYPT);
        $sql = "UPDATE account SET pass = ? WHERE username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$hash , $user);

        if(!$stm->execute()) {
            return array('code' => 2, 'error' => 'Can not execute command.');
        }

        return array('code' => 0, 'error' => 'Thay đổi mật khẩu thành công!.');
    }

    function is_username_exists($username){
        $sql = "select username from account where username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$username);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }

        $result = $stm->get_result();
        if($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    function is_email_exists($email){
        $sql = "select email from account where email = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$email);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }

        $result = $stm->get_result();
        if($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    function register($id,$username, $pass, $sex, $first, $last, $position, $department, $email, $phone, $day_off, $avatar){

        $hash = password_hash($pass, PASSWORD_BCRYPT);

        if(is_email_exists($email)){
            return array('code' => 3,  'error' => 'Email đã tồn tại');
        }

        if(is_username_exists($username)){
            return array('code' => 1,  'error' => 'Tài khoản đã tồn tại');
        }

        $sql = 'INSERT INTO account (id,username, pass, sex, firstname, lastname, positionid, 
        department_name, email, phone_number, day_off, avatar) values(?,?,?,?,?,?,?,?,?,?,?,?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('isssssisssis',$id ,$username, $hash, $sex, $first, $last, $position, $department, $email, $phone, $day_off, $avatar);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Thêm nhân viên thành công');
    }

    function selectAlluser(){
        $sql = 'SELECT * FROM account WHERE positionid  = "1" or positionid = "2" ORDER BY department_name DESC';
        $conn = open_database();
        $result = $conn-> query($sql);
        $position = '';
        $stt = 1;
        if($result->num_rows >0){
            while($row = $result-> fetch_assoc()){
                if($row["positionid"] == 1){
                    $position = 'Trưởng phòng';
                }else if($row["positionid"] == 2){
                    $position = 'Nhân viên';
                }
                else {
                    $position = 'Giám đốc';
                }
                echo "<tr>";
					echo "<td>" . $stt . "</td>";
					echo "<td>". $row["firstname"]." ".$row["lastname"] ."</td>";
					echo "<td>". $position ."</td>";
					echo "<td>". $row["department_name"] ."</td>";
					echo "<td>". $row["email"] ."</td>";
					echo '<td class="list-btn">';
                        echo '<form action="viewprofile.php" method="POST">';
                            echo '<button class="btn-view text-white" name="user-view" value="'. $row["username"] .'">Xem</button>';
                        echo '</form>';
                        echo '<form action="updatestaff.php" method="POST">';
                            echo '<button type="submit" name="user-edit" class="btn-edit text-white" value="'. $row["username"] .'">Chỉnh sửa</button>';
                        echo '</form>';
                        echo '<form action="" method="POST">';
						    echo '<button type="submit" name="user-delete" class="btn-delete text-white" value="'. $row["username"] .'">Xóa</button>';
                        echo '</form>';
					echo '</td>';
				echo '</tr>';
                $stt++;
            }
        }
        $conn->close();
    }

    function updatestaff($username, $sex, $first, $last, $position, $department, $email, $phone, $day_off, $avatar,$id){

        $sql = 'UPDATE account SET id= ?, sex= ?, firstname= ?, lastname= ?, positionid= ? ,department_name= ?,
            email =  ? ,phone_number= ? ,day_off= ? ,avatar= ?  WHERE username= ? ';

        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('ssssisssiss',$id,$sex,$first,$last,$position,$department,$email,$phone,$day_off,$avatar,$username);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Cập nhật nhân viên thành công');

    }

    function selectAllRoom(){
        $sql = 'SELECT * FROM department';
        $conn = open_database();
        $result = $conn-> query($sql);
        $stt = 1;

        if($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
                echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>". $row["department_name"]."</td>";
                        echo "<td>". $row["room_number"] ."</td>";
                        echo "<td>". $row["department_description"] ."</td>";
                        echo '<td class="list-btn">';
                            echo '<form action="" method="POST">';
                                echo '<button class="btn-view text-white" name="user-view" value="'. $row["id"] .'">Xem</button>';
                            echo '</form>';
                            echo '<form action="" method="POST">';
                                echo '<button type="submit" name="user-edit" class="btn-edit text-white" value="'. $row["id"] .'">Chỉnh sửa</button>';
                            echo '</form>';
                            echo '<form action="" method="POST">';
                                echo '<button type="submit" name="user-delete" class="btn-delete text-white" value="'. $row["id"] .'">Xóa</button>';
                            echo '</form>';
                        echo '</td>';
                echo '</tr>';
                $stt++;

            }
        }
        $conn->close();
    }
?>