<?php 
	// kiểm tra nếu chưa đăng nhập thì sẽ không truy cập được vào trang index mà sẽ bị chuyển hướng vế trang login
	session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

	require_once('./admin/db.php');

	//nếu chưa thay đổi pass thì sẽ không truy cập được vào trang index mà sẽ bị chuyển hướng vế trang đổi mật khẩu
	if($_SESSION['pwd'] == $_SESSION['username']) {
		header('Location: changepassword.php');
		exit(); // Chuyển đến trang thay đổi mật khẩu
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
	<title>Home Page</title>
</head>

<body>
	<div class="main">
		<header class="header">
			<nav class="navbar navbar-expand-sm bg-light">
				<div class="tdtu-img">
					<img src="/images/tdt-logo.png" alt="TDTU Image" class="tdtu-picture">
				</div>
				<!-- Links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="#">Trang chủ</a>
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

		<?php
			if($_SESSION['positionid'] == 3) {
				echo '<div class="body">
						<div class="header-body">
							<h3 class="user-list-header" style="margin-bottom:0">Danh sách phòng ban</h3>
							<form class="add-staff-form" action="addroom.php">
								<button class="add-staff text-white" type="submit">+ Thêm phòng ban</button>
							</form>
							<div class="search">
								<label for="search-staff" class="search-lable">Tìm kiếm</label>
								<input type="search" name="search-staff" id="search-staff" placeholder="Search...">
							</div>
						</div>
						<table id="staff-table" class="table table-striped">
							<thead>
								<tr>
									<th  class="text-center">STT</th>
									<th  class="text-center">Tên phòng ban</th>
									<th  class="text-center">Số phòng</th>
									<th  class="text-center">Mô tả</th>
									<th  class="text-center">Hoạt động</th>
								</tr>
							</thead>
							<tbody> '
								?><?php
									selectAllRoom();
								?> <?php '
							</tbody>
						</table>
					</div>';
			}
		?>
		<footer class="footer">
			
		</footer>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>