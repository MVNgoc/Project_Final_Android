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

    require_once('./admin/db.php');

    $msg = "";
    $css_class = "";
    $user_name = $_SESSION['username'];


    if(isset($_POST['submit-avatar'])) {    
        // echo "<pre>", print_r($_FILES['file']['name']) ,"</pre>";
        $profileImageName = time() . '_' . $_FILES['file']['name'];
        $split_file_name = explode(".", $profileImageName);
        $file_name_explode = strtolower($split_file_name[1]);

        $targer = 'images/' . $profileImageName;
        $file_name = $_FILES['file']['tmp_name'];

        if($file_name_explode != 'png' && $file_name_explode != 'jpeg' && $file_name_explode != 'jpg') {
            $msg = "File hình ảnh không hợp lệ! Bạn chỉ có thể dùng các file có đuôi png, jpg, jpeg để làm ảnh đại diện của mình.";
            $css_class = "alert-danger";
        }
        else {
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
    }

    $user = $_SESSION['username'];
    $pass = $_SESSION['pwd'];
    $data = login($user, $pass);
    if($data['code'] == 0) {
        $avatar = $data['avatar'];
    }
    else {
        $error = $data['error'];
    }

    $position = '';

    if($_SESSION['positionid'] == 1)
    {
        $position = 'Trưởng phòng';
    }else if($_SESSION['positionid'] == 2)
    {
        $position = 'Nhân viên';
    }
    else {
        $position = 'Giám đốc';
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
				<img src="/images/tdt-logo.png" alt="TDTU Image" class="tdtu-picture" >
			</div>
			<!-- Links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Trang chủ</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="#">Hồ sơ</a>
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
                                            <a class="nav-link" id="showday" type="button">Xem ngày nghỉ phép</a>
                                        </li>
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
												<a class="nav-link" id="showday" type="button">Xem ngày nghỉ phép</a>
											</li>
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
                                    <input type="file" name="file" class="avatar" onchange="displayImage(this)" accept="image/png, image/jpeg, image/jpg" style="display:none">   
                                    <button type="submit" name="submit-avatar" class="btn btn-submit btn-success px-5 mt-3 mr-2" style="display:none">Lưu</button>                           
                                </form> 
                                <h5 class="user-name"><?= $_SESSION["username"] ?></h5>
                            </div>
                            <div class="position">
                                <h5 class="font-weight-bold">Chức vụ</h5>
                                
                                <p class="font-size-s"><?= $position ?></p>
                                        
                                <h5 class="font-weight-bold">Phòng ban</h5>
                                <p class="font-size-s"><?= $_SESSION['department_name'] ?></p>

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
                                <h6 class="mb-2 text-primary font-weight-bold">Thông tin cá nhân</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">ID:</label> 
                                    <p class="font-size-s"><?= $_SESSION['id'] ?></p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Họ và tên:</label>  
                                    <p class="font-size-s"><?= $_SESSION['firstname']." ". $_SESSION['lastname'] ?></p>                    
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Giới tính:</label>
                                    <p class="font-size-s"><?= $_SESSION['sex'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary font-weight-bold">Địa chỉ liên lạc</h6>
                            </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email:</label>
                                        <p class="font-size-s"><?= $_SESSION['email'] ?></p>                          
                                    </div>                                 
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">SĐT:</label> 
                                        <p class="font-size-s"><?= $_SESSION['phone_number'] ?></p>                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters form-btn-submit">   
                            <button type="submit" name="submit-avatar" class="btn btn-placeholder-submit btn-success px-5 mt-3 mr-2">Lưu</button>                          
                            <form action="changepassword.php" class="changepass-form">
                                <button type="submit" class="btn btn-changepass btn-success px-5 mt-3 mr-2">Đổi mật khẩu</button>
                            </form>                                                                       
                        </div>
                    </div>                   
                </div>
            </div>
            
        </div>


        <div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content ">
					<div class="modal-header text-center">
						<h4 class="modal-title w-100">Xem ngày nghỉ</h4>
					</div>
					<div class="modal-body">
						<h4>Số ngày nghỉ có: <?php echo $_SESSION["day_off"]." ngày"; ?></h4>
						<?php displaydayleftuse($_SESSION["username"]) ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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