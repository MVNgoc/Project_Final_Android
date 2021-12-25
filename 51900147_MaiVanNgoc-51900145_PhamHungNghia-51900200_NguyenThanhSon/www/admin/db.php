<?php

	#  https://www.w3schools.com/php/php_mysql_select.asp
 
    $host = 'mysql-server'; // tên mysql server
    $user = 'root';
    $pass = 'root';
    $db = 'user'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die('Không thể kết nối database: ' . $conn->connect_error);
    }

	echo "Kết nối thành công tới database<br><br>";

	$sql = "SELECT * from account";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) 
		{
			echo json_encode($row);
			echo "<br>";
		}
	}
	else {
		echo "Bảng chưa có dữ liệu";
	}
?>
