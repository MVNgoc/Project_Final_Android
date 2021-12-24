<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
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
						<a class="nav-link" href="#">Hồ sơ</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Quản lý phòng ban</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Đăng xuất</a>
					</li>		
				</ul>
			</nav>

			<div class="btn-showlist">
				<button class="btn-list-item"></button>
			</div>
		</header>

		<div class="body">
			<div class="header-body">
				<h3 style="margin-bottom:0">Danh sách nhân viên</h3>
				<button class="add-staff text-white">+ Thêm nhân viên</button>
				<div class="search">
					<label for="search-staff" class="search-lable">Tìm kiếm:</label>
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
				<tbody>
					<tr>
						<td>1</td>
						<td>Mai Văn Ngọc</td>
						<td>Trường phòng</td>
						<td>Kế toán</td>
						<td>user@gmail.com</td>
						<td class="list-btn">
							<div class="btn-view text-white">Xem</div>
							<div class="btn-edit text-white">Chỉnh sửa</div>
							<div class="btn-delete text-white">Xóa</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td>Phạm Hùng Nghĩa</td>
						<td>Trường phòng</td>
						<td>Kế toán</td>
						<td>user@gmail.com</td>
						<td class="list-btn">
						<div class="btn-view text-white">Xem</div>
							<div class="btn-edit text-white">Chỉnh sửa</div>
							<div class="btn-delete text-white">Xóa</div>
						</td>
					</tr>
					<tr>
						<td>3</td>
						<td>Nguyễn Thanh Sơn</td>
						<td>Trường phòng</td>
						<td>Kế toán</td>
						<td>user@gmail.com</td>
						<td class="list-btn">
						<div class="btn-view text-white">Xem</div>
							<div class="btn-edit text-white">Chỉnh sửa</div>
							<div class="btn-delete text-white">Xóa</div>
						</td>
					</tr>
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