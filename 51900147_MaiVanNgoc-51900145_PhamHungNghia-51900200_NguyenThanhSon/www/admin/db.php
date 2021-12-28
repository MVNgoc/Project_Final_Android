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
            return array('code' => 0, 'error' => '', 'data' => $data);
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
        $sql = 'select username from account where username = ?';
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

    function register($id, $username, $password, $sex, $first, $last, $position, $department, $email, $phone, $day_off){

        $hash = password_hash($password, PASSWORD_BCRYPT);

        if(is_username_exists($username)){
            return array('code' => 1,  'error' => 'Tài khoản đã tồn tại');
        }

        $sql = 'INSERT INTO account VALUES (id, username, pass, sex, firstname, lastname, positionid, department_name, email, phone_number, day_off)';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param($id, $username, $hash, $sex, $first, $last, $position, $department, $email, $phone, $day_off);

        //if(!$stm->execute()){
        //    return array('code' => 2, 'error' => 'Can not excute command');
        //}
        //return array('code' => 0,'error' => 'Thêm nhân viên thành công');
        if (mysqli_query($conn, $sql)) {
            echo "Thêm thành công một nhân viên mới!";
       }
       else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
       }
    }
?>