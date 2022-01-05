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
            'email' => $data['email'], 'phone_number' => $data['phone_number'], 'avatar' => $data['avatar'] , 'day_off' => $data['day_off']);
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
        $sql = 'SELECT * FROM account WHERE positionid  = "1" or positionid = "2" ORDER BY department_name DESC,positionid ASC';
        $conn = open_database();
        $result = $conn-> query($sql);
        $position = '';
        $stt = 1;
        if($result->num_rows >0){
            foreach($result as $row) {
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
						    echo '<button type="submit" name="user-delete" class="btn-delete text-white deletebtn" value="'. $row["username"] .'">Xóa</button>';
                        echo '</form>';
					echo '</td>';
				echo '</tr>';
                $stt++;
            }
        }
        $conn->close();
    }

    function is_exist_managername($department_name,$username){
        $sql = 'SELECT *
                FROM account,department
                WHERE account.department_name = department.department_name AND account.department_name = ? AND username != ?';
        $conn = open_database();
        $stm = $conn->prepare($sql);

        $stm->bind_param('ss',$department_name,$username);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }

        $result = $stm->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row["manager_name"] == null){
                    return false;
                }
                return true;
            }
        }

    }

    function updatestaff($username, $sex, $first, $last, $position, $department, $email, $phone, $day_off, $avatar,$id){

        if(is_exist_managername($department,$username)){
            return array('code' => 1,  'error' => 'Phòng ban này đã có trưởng phòng');
        }

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
            foreach($result as $row) {
                echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>". $row["department_name"]."</td>";
                        echo "<td>" . $row["manager_name"]. "</td>";
                        echo "<td>". $row["room_number"] ."</td>";
                        echo "<td>". $row["department_description"] ."</td>";
                        echo '<td class="list-btn">';
                            echo '<form action="department_view.php" method="POST">';
                                echo '<button class="btn-view text-white" name="room-view" value="'. $row["id"] .'">Xem</button>';
                            echo '</form>';
                            echo '<form action="department_edit.php" method="POST">';
                                echo '<button type="submit" name="room-edit" class="btn-edit text-white" value="'. $row["id"] .'">Chỉnh sửa</button>';
                            echo '</form>';
                            echo '<form action="" method="POST">';
                                echo '<button type="submit" name="room-delete" class="btn-delete text-white deletebtn" value="'. $row["id"] .'">Xóa</button>';
                            echo '</form>';
                        echo '</td>';
                echo '</tr>';
                $stt++;
            }
        }
        $conn->close();
    }

    function is_roomname_exists($department_name){
        $sql = "select department_name from department where department_name = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$department_name);
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

    function is_roomnumber_exists($room_number){
        $sql = "select room_number from department where room_number = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$room_number);
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


    function createRoom($department_name, $department_description, $room_number){
        if(is_roomname_exists($department_name)){
            return array('code' => 3,  'error' => 'Tên phòng ban đã tồn tại');
        }
        if(is_roomnumber_exists($room_number)){
            return array('code' => 1,  'error' => 'Số phòng bị trùng');
        }

        $sql = 'INSERT INTO department (department_name, room_number,department_description) values(?,?,?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('sss',$department_name, $department_description, $room_number);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Thêm phòng ban thành công');

    }

    function selectAllNameUser($department_name){
        $sql = 'SELECT * FROM account WHERE department_name = ? ORDER BY department_name DESC';
        $conn = open_database();
        
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$department_name);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        
        $result = $stm->get_result();
        if($result-> num_rows > 0){
            foreach($result as $row) {
                echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <p>'. $row["firstname"] . ' ' . $row["lastname"] .'</p>                              
                        </div>
                    </div>';
            }
        }
        $conn->close();
    }

    function updatePosition($positionid ,$day_off, $firstname, $lastname) {
        $sql = 'UPDATE account SET positionid = ?, day_off = ? WHERE firstname = ? AND lastname = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('siss',$positionid ,$day_off, $firstname, $lastname);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Chỉnh sửa account thành công');
    }

    function updateDepartment($department_name, $manager_name, $department_description, $room_number, $id) {
        $sql = 'UPDATE department SET department_name = ?, manager_name = ?, department_description = ?, room_number = ? WHERE id = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('sssss',$department_name, $manager_name, $department_description, $room_number, $id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Chỉnh sửa thành công');
    }

    function department_is($username,$department_name){
        $sql = 'SELECT * FROM account WHERE username = ? and department_name = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm ->bind_param('ss',$username,$department_name);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        
        $result = $stm->get_result();
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }

    function inserttask($task_title, $task_description, $start_time, $deadline, $staff_assign, $task_status, $task_deliver) {
        $sql = 'INSERT INTO task (task_title, task_description, start_time, deadline, staff_assign, task_status, task_deliver) values(?,?,?,?,?,?,?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('sssssss',$task_title, $task_description, $start_time, $deadline, $staff_assign, $task_status, $task_deliver);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Tạo Task ban thành công');
    }

    function insertfiletask($name_task_file) {
        $sql = 'INSERT INTO taskfile values(?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('s',$name_task_file);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Thêm file thành công');
    }

    function selectallTask($taskdeliver) {
        $sql = 'SELECT * FROM task WHERE task_deliver = ?';
        $conn = open_database();
        
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$taskdeliver);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        
        $result = $stm->get_result();
        $stt = 1;
        if($result-> num_rows > 0){
            foreach($result as $row) {
                echo "<tr>";
					echo "<td>" . $stt . "</td>";
					echo "<td>". $row["task_title"] . "</td>";
					echo "<td>". $row["staff_assign"] ."</td>";
					echo "<td>". $row["task_status"] ."</td>";
					echo '<td class="list-btn">';
                        if($row["task_status"] != "Canceled") {
                            echo '<form action="viewtask.php" method="POST">';
                            echo '<button class="btn-view text-white" name="task-view" value="'. $row["id"] .'">Xem</button>';
                            echo '</form>';
                            if($row["task_status"] == "New" || $row["task_status"] == "Waiting") {
                                echo '<form action="updatetask.php" method="POST">';
                                    echo '<button type="submit" name="task-edit" class="btn-edit text-white deletebtn" value="'. $row["id"] .'">Tùy chỉnh</button>';
                                echo '</form>';
                                echo '<form action="" method="POST">';
                                    echo '<button type="submit" name="task-delete" class="btn-delete text-white deletebtn" value="'. $row["id"] .'">Hủy bỏ</button>';
                                echo '</form>';
                            }
                        }
					echo '</td>';
				echo '</tr>';
                $stt++;
            }
        }
        $conn->close();
    }

    function selectallTaskStaff($staff_assign) {
        $sql = "SELECT id, task_title, task_status, DATE_FORMAT(deadline, '%d/%m/%Y %h:%i:%s') AS deadline FROM task WHERE staff_assign = ? AND task_status != 'Canceled'";
        $conn = open_database();
        
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$staff_assign);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        
        $result = $stm->get_result();
        $stt = 1;
        if($result-> num_rows > 0){
            foreach($result as $row) {
                echo "<tr>";
					echo "<td>" . $stt . "</td>";
					echo "<td>". $row["task_title"] . "</td>";
					echo "<td>". $row["deadline"] ."</td>";
					echo "<td>". $row["task_status"] ."</td>";
					echo '<td class="list-btn">';
                        echo '<form action="viewtask.php" method="POST">';
                            echo '<button class="btn-view text-white" name="task-view" value="'. $row["id"] .'">Xem</button>';
                        echo '</form>';
					echo '</td>';
				echo '</tr>';
                $stt++;
            }
        }
        $conn->close();
    }

    function updateStatus($status, $id) {
        $sql = 'UPDATE task SET task_status = ? WHERE id = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('ss',$status, $id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Thành công');
    }

    function updatetask($task_title, $task_description, $start_time, $deadline, $staff_assign , $id) { 
        $sql = 'UPDATE task SET task_title = ?, task_description = ?, start_time = ?, deadline = ?, staff_assign = ? WHERE id = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);

        $stm->bind_param('ssssss',$task_title, $task_description, $start_time, $deadline, $staff_assign , $id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Thành công');
    }

    function insertleave($username,$leavetype,$leavereason,$star_date,$end_date,$date_apply,$uploadfile,$date_num){
        $sql = 'INSERT INTO leaveform(username,leavetype,leavereson,star_date,end_date,date_applied,
            uploadd_file,date_num) VALUES(?,?,?,?,?,?,?,?)';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssssi',$username,$leavetype,$leavereason,$star_date,$end_date,$date_apply,$uploadfile,$date_num);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Tạo đơn xin nghỉ thành công');
    }

    function displayleaveofUser($username){
        $sql = 'SELECT * FROM leaveform WHERE username = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$username);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        
        $result = $stm->get_result();
        $stt = 1;
        if($result-> num_rows > 0){
            foreach($result as $row) {
                echo "<tr>";
					echo "<td>" . $stt . "</td>";
					echo "<td>". $row["leavetype"] . "</td>";
					echo "<td>". $row["date_applied"] ."</td>";
                    echo "<td>". $row["date_num"] ."</td>";
					echo "<td>". $row["leave_status"] ."</td>";
					echo '<td class="list-btn">';
                        echo '<form action="duyetdon.php" method="POST">';
                            echo '<button class="btn-view text-white" name="leave-view" value="'. $row["username"] .'">Xem</button>';
                        echo '</form>';
					echo '</td>';
				echo '</tr>';
                $stt++;
            }
        }
        $conn->close();

    }

?>