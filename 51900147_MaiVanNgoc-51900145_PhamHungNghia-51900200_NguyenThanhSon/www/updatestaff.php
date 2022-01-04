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

	if(isset($_POST["user-edit"])){
		$name = $_POST["user-edit"];
		$_SESSION['user-name'] = $name;
		$sql = "SELECT * FROM account WHERE username = '$name' ";
		$conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
		$first = $row["firstname"];
		$last = $row["lastname"];
		$phone = $row["phone_number"];
		$email = $row["email"];
		$user = $row["username"];
		$department = $row["department_name"];
		$sex = $row["sex"];
		$position = $row["positionid"];
		$id = $row["id"];
		$avatar = $row["avatar"];
		$dayoff = $row["day_off"];
	}
	else {
		$name = $_SESSION['user-name'];
		$sql = "SELECT * FROM account WHERE username = '$name' ";
		$conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
		$first = $row["firstname"];
		$last = $row["lastname"];
		$phone = $row["phone_number"];
		$email = $row["email"];
		$user = $row["username"];
		$department = $row["department_name"];
		$sex = $row["sex"];
		$position = $row["positionid"];
		$id = $row["id"];
		$avatar = $row["avatar"];
		$dayoff = $row["day_off"];
	}


	if(isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) && isset($_POST['user']) 
	&& isset($_POST['id']) && isset($_POST['phone']) && isset($_POST['department']) && 
	isset($_POST['department']) ){

		$first = $_POST['first'];
		$last = $_POST['last'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$user = $_POST['user'];
		$id = $_POST['id'];
		$department = $_POST['department'];
		$sex = $_POST['sex'];
		$position = $_POST['position'];
		$positionid='';
		$day_off='';
		$avatar='';

		if($position == "Nhân viên"){
			$positionid = 2;
			$day_off = 12;
		}else{
			$positionid = 1;
			$day_off = 15;
		}


		if(empty($first)){
			$error = 'Hãy nhập họ';
		}
		elseif(empty($last)){
			$error = "Hãy nhập tên";
		}
		elseif(empty($email)){
			$error = "Hãy nhập email";
		}
		elseif(empty($user)){
			$error = "Hãy nhập tên user";
		}
		elseif(empty($id)){
			$error = "Hãy nhập mã nhân viên";
		}
		elseif(empty($phone)){
			$error = "Hãy nhập số điện thoại";
		}
		else{
			$result = updatestaff($user,$sex,$first,$last,$positionid,$department,$email,$phone,$day_off,$avatar,$id);
			if($result['code'] == 0){
                $success = 'Cập nhật thành công .';
			}if($result['code'] == 1){
				$error = 'Phòng ban này đã có trưởng phòng';
			}else {
                $error = 'Đã có lỗi xảy ra. Vui lòng thử lại sau';
            }
		}
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
					<a class="nav-link" href="profile.php">Hồ sơ</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="phongban.php">Quản lý phòng ban</a>
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
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Chỉnh sửa thông tin nhân viên</h3>
                <form method="post" action="" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">Họ</label>
                            <input value="<?php echo $first;  ?>" name="first" required class="form-control" type="text" placeholder="First name" id="firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Tên</label>
                            <input value="<?php echo $last;  ?>" name="last" required class="form-control" type="text" placeholder="Last name" id="lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?php echo $email;  ?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="user">Tài khoản</label>
                        <input value="<?php echo $user;  ?>" name="user" required class="form-control" type="text" placeholder="Username" id="user" readonly>
                    </div>
					<div class="form-group">
                        <label for="id">Mã nhân viên</label>
                        <input value="<?php echo $id;  ?>" name="id" required class="form-control" type="text" placeholder="Mã nhân viên" id="id">
                    </div>
					<div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input value="<?php echo $phone; ?>" name="phone" required class="form-control" type="text" placeholder="Số điện thoại" id="phone">
                    </div>
					
					<div class="form-group">
                        <label for="department">Phòng ban</label>
                        <?php 
							$sql = 'SELECT department_name FROM department';
							$conn = open_database();
        					$result = $conn-> query($sql);
							$dbselected = $department;
							echo '<select required class="form-control" name="department">';
								if($result->num_rows > 0){
									while($row = $result->fetch_array()){
										if($row["department_name"] != $dbselected){
											echo '<option value="'.$row["department_name"].'">'.$row["department_name"].'</option>';
										}else{
											echo '<option value="'.$row["department_name"].'"selected>'.$row["department_name"].'</option>';
										}
										
									}
								}
							echo '</select>';
						?>
                    </div>

					<div class="form-group">
						<label for="sex">Giới Tính</label>
						<div class="form-row">
							<div class="form-check">
								<input type="radio" class="form-check-input" id="radio1" name="sex" value="Nam" <?php if($sex=="Nam") echo "checked='checked'"; ?> >Nam
								<label class="form-check-label" for="radio1"></label>
							</div>	  
							<div class="form-check">
								<input type="radio" class="form-check-input" id="radio1" name="sex" value="Nữ" <?php if($sex=="Nữ") echo "checked='checked'"; ?> >Nữ
								<label class="form-check-label" for="radio1"></label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="position">Chức vụ</label>

						<?php 
							if($position=="2"){
								echo '<input value="Nhân viên" id="position" name="position" required class="form-control" readonly>';
							}else{
								echo '<input value="Trưởng phòng" id="position" name="position" required class="form-control" readonly>';
							}
						?>
					</div>

                    <div class="form-group">
						<div class="col text-center">
							<?php
								if (!empty($error)) {
									echo "<div class='alert alert-danger'>$error</div>";
								}
							?>
							<button name="update" type="submit" class="btn btn-register-js btn-success px-5 mt-3 mr-2">Update</button>
						</div>
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