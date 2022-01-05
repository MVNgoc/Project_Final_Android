<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    if($_SESSION['pwd'] == $_SESSION['username']) {
		header('Location: changepassword.php');
		exit();; // Chuyển đến trang thay đổi mật khẩu
	}

    if ($_SESSION['positionid'] != 3) {
        header('Location: index.php');
        exit();
    }

    $position = '';

    require_once('./admin/db.php');

    if(isset($_POST['room-view'])) {
        $id = $_POST['room-view'];
        $_SESSION['id_room'] = $id;
        $sql = "SELECT * FROM department WHERE id = '$id' ";
        $conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
        $department_name = $row['department_name'];
        $manager_name = $row['manager_name'];
        $department_description = $row['department_description'];
        $room_number = $row['room_number'];
    }
    else {
        $id = $_SESSION['id_room'];
        $sql = "SELECT * FROM department WHERE id = '$id' ";
        $conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
        $department_name = $row['department_name'];
        $manager_name = $row['manager_name'];
        $department_description = $row['department_description'];
        $room_number = $row['room_number'];
    }   
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="main.js"></script>
	<title>Add Staff Page</title>
</head>

<body>
	<header class="header-user">
		<nav class="navbar navbar-expand-sm bg-light">
			<div class="tdtu-img">
				<img src="/images/tdt-logo.png" alt="TDTU Image" class="tdtu-picture">
			</div>
			<!-- Links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Trang chủ</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="profile.php">Hồ sơ</a>
				</li>
				<?php
                    if($_SESSION['positionid'] == 3) {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="phongban.php">Quản lý phòng ban</a>
                            </li>
                            <li class="nav-item day-off-header">
                                <a class="nav-link" href="#">Nghỉ phép</a>
                                <ul class="navbar-nav">
                                    <li class="nav-item day-off-tag">
                                    <a class="nav-link" href="duyetdon.php">Duyệt đơn nghỉ phép</a>
                                    </li>
                                </ul>
                            </li>';
                    }   
				?>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Đăng xuất</a>
				</li>		
			</ul>
		</nav>

		<div class="btn-showlist">
			<button class="btn-list-item"></button>
		</div>
	</header>
	
	<div class="container profileform">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card-user h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="position">
                                <h5 class="font-weight-bold">Phòng Ban</h5>
                                <p class="font-size-m"><?= $department_name ?></p>
                                        
                                <h5 class="font-weight-bold">Mô tả</h5>
                                <p class="font-size-m"><?= $department_description ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card-user h-100">
                    <div class="card-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary font-weight-bold">Thông tin phòng ban</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Trưởng phòng:</label> 
                                    <p class="font-size-s"> <?= $manager_name ?> </p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Số phòng:</label>  
                                    <p class="font-size-s"> <?= $room_number ?> </p>    
                                </div>
                            </div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary font-weight-bold">Danh sách nhân viên của phòng ban</h6>                          
                            </div>
        
                            <?php selectAllNameUser($department_name) ?>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>