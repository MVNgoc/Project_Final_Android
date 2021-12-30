<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

	//nếu chưa thay đổi pass thì sẽ không truy cập được vào trang addstaff mà sẽ bị chuyển hướng vế trang đổi mật khẩu
	if($_SESSION['pwd'] == $_SESSION['username']) {
		header('Location: changepassword.php');
		exit();; // Chuyển đến trang thay đổi mật khẩu
	}

	// không phải Admin thì không truy cập vào được
	if ($_SESSION['positionid'] != 3) {
        header('Location: index.php');
        exit();
    }

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
    

	<?php	
		
	?>
	<header class="header">
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
					<a class="nav-link" href="#">Hồ sơ</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Quản lý phòng ban</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Đăng xuất</a>
				</li>		
			</ul>
		</nav>

		<div class="btn-showlist">
			<button class="btn-list-item"></button>
		</div>
	</header>
	
	<div class="container">
        <div class="row justify-content-center ">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3 addstaffform">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Thêm nhân viên</h3>
                <form method="post" action="" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">Họ</label>
                            <input value="<?= $first ?>" name="first" required class="form-control" type="text" placeholder="First name" id="firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Tên</label>
                            <input value="<?= $last ?>" name="last" required class="form-control" type="text" placeholder="Last name" id="lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?= $email ?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="user">Tài khoản</label>
                        <input value="<?= $user ?>" name="user" required class="form-control" type="text" placeholder="Username" id="user">
                    </div>
					<div class="form-group">
                        <label for="id">Mã nhân viên</label>
                        <input value="<?= $id ?>" name="id" required class="form-control" type="text" placeholder="Mã nhân viên" id="id">
                    </div>
					<div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input value="<?= $phone ?>" name="phone" required class="form-control" type="text" placeholder="Số điện thoại" id="phone">
                    </div>
					<div class="form-group">
                        <label for="department">Phòng ban</label>
                        <input value="<?= $department ?>" name="department" required class="form-control" type="text" placeholder="Tên phòng ban" id="department">
                    </div>
					<div class="form-group">
						<label for="sex">Giới Tính</label>
						<div class="form-row">
							<div class="form-check">
								<input type="radio" class="form-check-input" id="radio1" name="sex" value="Nam" checked>Nam
								<label class="form-check-label" for="radio1"></label>
							</div>	  
							<div class="form-check">
								<input type="radio" class="form-check-input" id="radio1" name="sex" value="Nữ" checked>Nữ
								<label class="form-check-label" for="radio1"></label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="position">Chọn chức vụ</label>
						<select class="form-control" id="position" name="position">
						<option value="1">Trưởng phòng</option>
						<option value="2">Nhân viên</option>
						</select>
					</div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-register-js btn-success px-5 mt-3 mr-2">Register</button>
                        <button type="reset" class="btn btn-success px-5 mt-3 mr-2">Reset</button>
                    </div>
                </form>

            </div>
        </div>
		<?php
			if (!empty($success)) {
				echo "<div class='notification'>
						<div class='notification_success'>$success</div>
					</div>";
			}
		?>
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>