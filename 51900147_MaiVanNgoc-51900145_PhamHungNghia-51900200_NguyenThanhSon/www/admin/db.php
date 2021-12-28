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
            return array('code' => 1, 'error' => 'User does not exist'); // khong co user ton tai
        }

        $data = $result->fetch_assoc();

        $hashed_password = $data['password'];   
        if(!password_verify($pass, $hashed_password)) {
            return array('code' => 2, 'error' => 'Invalid password'); 
        }
        else {
            return array('code' => 0, 'error' => '', 'data' => $data);
        }
	}

    function is_username_exists($username){
        $sql = 'select username from account where username=?';
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
?>
