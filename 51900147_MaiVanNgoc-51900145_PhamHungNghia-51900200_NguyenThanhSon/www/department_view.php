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
                                <h5>Phòng Ban</h5>
                                <p>Marketing</p>
                                        
                                <h5>Mô tả</h5>
                                <p>Tính toán thu chi cho công ty</p>
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
                                <h6 class="mb-2 text-primary">Thông tin phòng ban</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trưởng phòng:</label> 
                                    
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số phòng:</label>  
                                                        
                                </div>
                            </div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Danh sách nhân viên</h6>
                            </div>
                            
                            

                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <?php
        if (!empty($success)) {
            echo "<div class='notification'>
                    <div class='notification_success'>$success</div>
                </div>";
        }
	?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>