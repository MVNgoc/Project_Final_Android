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

	if(isset($_POST["user-delete"])){

		$user = $_POST["user-delete"];
		$sql = "DELETE FROM account WHERE username = '$user'";
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->execute();
	}
	$nameStaff = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
?>
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
						else if ($_SESSION['positionid'] == 1 || $_SESSION['positionid'] == 2) {
                            if($_SESSION['positionid'] == 1) {
                                echo '<li class="nav-item day-off-header">
                                        <a class="nav-link" href="#">Nghỉ phép</a>
                                        <ul class="navbar-nav day-off-tag">
											<li class="nav-item">
                                            	<a class="nav-link" href="dayoffform.php">Tạo đơn xin nghỉ phép</a>
                                            </li>
                                            <li class="nav-item">
                                            	<a class="nav-link" href="duyetdon.php">Duyệt đơn nghỉ phép</a>
                                            </li>
											<li class="nav-item">
                                            	<a class="nav-link" href="dayoffhistory.php">Lịch sử nghỉ phép</a>
                                            </li>
                                        </ul>
                                    </li>';
                            }
                            else {
								echo '<li class="nav-item day-off-header">
                                        <a class="nav-link" href="#">Nghỉ phép</a>
                                        <ul class="navbar-nav day-off-tag">
											<li class="nav-item">
                                            	<a class="nav-link" href="dayoffform.php">Tạo đơn xin nghỉ phép</a>
                                            </li>
											<li class="nav-item">
                                            	<a class="nav-link" href="dayoffhistory.php">Lịch sử nghỉ phép</a>
                                            </li>
                                        </ul>
                                    </li>';
                            }
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
							<h3 class="user-list-header" style="margin-bottom:0">Danh sách nhân viên</h3>
							<form class="add-staff-form" action="addstaff.php">
								<button class="add-staff text-white" type="submit">+ Thêm nhân viên</button>
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
									<th  class="text-center">Tên</th>
									<th  class="text-center">Chức vụ</th>
									<th  class="text-center">Phòng ban</th>
									<th  class="text-center">Email</th>
									<th  class="text-center">Hoạt động</th>
								</tr>
							</thead>
							<tbody> '
								?><?php
									selectAlluser();
								?> <?php '
							</tbody>
						</table>
					</div>';
			}
			else if($_SESSION['positionid'] == 1) {
				echo '<div class="body">
					<div class="header-body">
						<h3 class="task-list-header" style="margin-bottom:0">Danh sách task đã giao</h3>
						<form class="create-task-form" action="createtask.php">
							<button class="add-staff text-white" type="submit">+ Tạo task mới</button>
						</form>	
					</div>
					<table id="staff-table" class="table table-striped">
						<thead>
							<tr>
								<th  class="text-center">STT</th>
								<th  class="text-center">Tên task</th>
								<th  class="text-center">Người thực hiện</th>
								<th  class="text-center">Trạng thái</th>
								<th  class="text-center">Hoạt động</th>
							</tr>
						</thead>
						<tbody>'?> 
							<?php
								selectallTask($_SESSION['username']);
							?> <?php '
						</tbody>
					</table>
				</div>';
			}
			else {
				echo '<div class="body">
					<div class="header-body">
						<h3 class="task-list-header" style="margin-bottom:0">Danh sách task</h3>
					</div>
					<table id="staff-table" class="table table-striped">
						<thead>
							<tr>
								<th  class="text-center">STT</th>
								<th  class="text-center">Tên task</th>
								<th  class="text-center">Deadline</th>
								<th  class="text-center">Trạng thái</th>
								<th  class="text-center">Hoạt động</th>
							</tr>
						</thead>
						<tbody>'?> 
							<?php
								selectallTaskStaff($nameStaff);
							?> <?php '
						</tbody>
					</table>
				</div>';
			}
		?>
			<div class="body">
				<div class="header-body">
					<h3 class="task-list-header" style="margin-bottom:0">Danh sách task đã giao</h3>
					<form class="create-task-form" action="createtask.php">
						<button class="add-staff text-white" type="submit">+ Tạo task mới</button>
					</form>	
				</div>
				<table id="staff-table" class="table table-striped">
					<thead>
						<tr>
							<th  class="text-center">STT</th>
							<th  class="text-center">Tên task</th>
							<th  class="text-center">Người thực hiện</th>
							<th  class="text-center">Trạng thái</th>
						</tr>
					</thead>
					<tbody> 

					</tbody>
				</table>
			</div>

		<footer class="footer">
			
		</footer>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>