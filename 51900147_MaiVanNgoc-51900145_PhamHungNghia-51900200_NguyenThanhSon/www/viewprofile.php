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

    $msg = "";
    $css_class = "";
    $user_name = $_SESSION['username'];


    if(isset($_POST['submit-avatar'])) {    
        // echo "<pre>", print_r($_FILES['file']['name']) ,"</pre>";
        $profileImageName = time() . '_' . $_FILES['file']['name'];

        $targer = 'images/' . $profileImageName;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targer)) {
            $sql = "UPDATE account SET avatar = '$profileImageName' WHERE username = '$user_name'";
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->execute();

            $msg = "Thay đổi ảnh đại diện thành công.";
            $css_class = "alert-success";
        } 
        else {
            $msg = "Thay đổi ảnh đại diện không thành công! Vui lòng thử lại.";
            $css_class = "alert-danger";
        }
    }

    if(isset($_POST["user-view"])){     
		$name = $_POST["user-view"];
        $_SESSION['username_view'] = $name;
		$sql = "SELECT * FROM account WHERE username = '$name' ";
		$conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
        $name = $row["firstname"] . " " . $row["lastname"];
		$phone = $row["phone_number"];
		$email = $row["email"];
		$user = $row["username"];
		$department = $row["department_name"];
		$sex = $row["sex"];
		$positionid = $row["positionid"];
		$id = $row["id"];
		$avatar = $row["avatar"];
	}
    else {
        $name = $_SESSION['username_view'];
        $sql = "SELECT * FROM account WHERE username = '$name' ";
        $conn = open_database();
        $stm = $conn -> prepare($sql);
        $result = $conn-> query($sql);
        $row = $result->fetch_assoc();
        $name = $row["firstname"] . " " . $row["lastname"];
        $phone = $row["phone_number"];
        $email = $row["email"];
        $user = $row["username"];
        $department = $row["department_name"];
        $sex = $row["sex"];
        $positionid = $row["positionid"];
        $id = $row["id"];
        $avatar = $row["avatar"];
    }


    if($positionid == 1)
    {
        $position = 'Trưởng phòng';
    }else if($positionid == 2)
    {
        $position = 'Nhân viên';
    }
    else {
        $position = 'Giám đốc';
    }

    if(isset($_POST["reset-pass"])){
        $cfpass = $user;
        $data = changepass($cfpass, $user);
        if($data['code'] == 0) {
            $success = 'Reset thành công mật khẩu của ' . $position . ' ' . $name;  
        }
        else {
            $error = 'Reset mật khẩu không thành công';
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
                            <div class="user-profile">
                                <form action="" class="user-avatar" method="post" enctype="multipart/form-data">
                                    <?php
                                        if($avatar == '') {
                                            echo '<img src="./images/avatar_placeholder.jpg" alt="avatar" id="avatar_placeholder">';
                                        }
                                        else {
                                            echo '<img src="./images/'.$avatar.'" alt="avatar" id="avatar_placeholder">';
                                        }
                                    ?>
                                    <input type="file" name="file" class="avatar" onchange="displayImage(this)" accept="image/png, image/jpeg" style="display:none">   
                                    <button type="submit" name="submit-avatar" class="btn btn-submit btn-success px-5 mt-3 mr-2" style="display:none">Lưu</button>                           
                                </form>
                                <h5 class="user-name"><?= $user ?></h5>
                            </div>
                            <div class="position">
                                <h5>Chức vụ</h5>
                                
                                <p><?= $position ?></p>

                                <h5>Phòng ban</h5>
                                <p><?= $department ?></p>

                                <?php
                                    if (!empty($error)) {
                                        echo "<div class='alert alert-danger'>$error</div>";
                                    }
                                ?>
                                <?php if(!empty($msg)): ?>
                                    <div class="alert <?php echo  $css_class;?>">
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
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
                                <h6 class="mb-2 text-primary">Thông tin cá nhân</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>ID:</label> 
                                    <p class="font-size-s"><?= $id ?></p> 
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Họ và tên:</label>  
                                    <p class="font-size-s"><?= $name ?></p>                      
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giới tính:</label>
                                    <p class="font-size-s"><?= $sex ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary">Địa chỉ liên lạc</h6>
                            </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <p class="font-size-s"><?= $email ?></p>                          
                                    </div>                                 
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>SĐT:</label> 
                                        <p class="font-size-s"><?= $phone ?></p>                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters form-btn-submit">   
                            <form action=" " method="POST">
                                <button type="submit" name="reset-pass" class="btn btn-placeholder-submit btn-success px-5 mt-3 mr-2">Reset Password</button>                                                                                                                                             
                            </form>
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