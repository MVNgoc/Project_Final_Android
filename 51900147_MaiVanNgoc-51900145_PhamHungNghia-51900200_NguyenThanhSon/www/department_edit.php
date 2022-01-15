<?php 
	// kiểm tra nếu chưa đăng nhập thì sẽ không truy cập được vào trang addstaff mà sẽ bị chuyển hướng vế trang login
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

	if ($_SESSION['positionid'] != 3) {
        header('Location: index.php');
        exit();
    }
	
	require_once('./admin/db.php');

    $name = '';
	$room = '';
	$desciption = '';
    
    if(isset($_POST["room-edit"])){
		$id = $_POST["room-edit"];
        $_SESSION['id_room'] = $id;
	}
    else {
        $id = $_SESSION['id_room'];
    }

    $sql = "SELECT * FROM department WHERE id = '$id' ";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $result = $conn-> query($sql);
    $row = $result->fetch_assoc();
    $name = $row['department_name'];

    $_SESSION['department_name'] = $name;

    $room = $row['room_number'];
    $desciption = $row['department_description'];
    if($row['manager_name'] != null) {
        $manager_name = $row['manager_name'];
    }
    else {
        $manager_name = "Không có";
    }

	$success = '';
	$error = '';

    if(isset($_POST['manager-list'])) {
        $_SESSION['temp'] = '';
        $_SESSION['temp'] = $manager_name; // Tên trưởng phòng củ
        $manager_name_select = $_POST['manager-list']; // Tên trưởng phòng mới
        if($manager_name == "Không có" || $manager_name_select == $manager_name) {
            $manager_name = $manager_name_select;
        }
        else {
            $manager_name = $manager_name_select;
            $error = 'Phòng ban này đang có ' . $_SESSION['temp'] . ' làm trưởng phòng. Bấm Update để thay đổi trưởng phòng hoặc thoát.';
        }  
    }

    if(isset($_POST['btn-reset-manager'])) {
        $_SESSION['temp'] = $manager_name;

        $sql = 'SELECT * FROM account WHERE department_name = ? ORDER BY department_name DESC';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$_SESSION['department_name']);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        $result = $stm->get_result();
        if($result-> num_rows > 0){
            foreach($result as $row) {
                $fullname = $row["firstname"]. ' ' .$row["lastname"];

                if($fullname == $_SESSION['temp']) {
                    $fist = $row["firstname"];
                    $last = $row["lastname"];
                    $user_name = $row["username"];
                    $positionid = 2;
                    $day_off = 12;
                    $result = updatePosition($positionid ,$day_off, $fist, $last);
                    $result = updateLeaverequest($day_off, $user_name);
                }
            }
        }
        $conn->close();

        $manager_name = '';
        $sql = "UPDATE department SET manager_name = '' WHERE department_name = ?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$_SESSION['department_name']);  
        if(!$stm->execute()){
            echo 'error';
        }  
    }

    if(isset($_POST['name']) && isset($_POST['room']) && isset($_POST['description']) && isset($_POST['managername'])){

		$name = $_POST['name'];
		$room = $_POST['room'];
		$desciption = $_POST['description'];
        $managername = $_POST['managername']; // Tên trưởng phòng mới
        $oldmanager = $_SESSION['temp']; // Tên trưởng phòng cũ

		if(empty($name)){
			$error = 'Hãy nhập tên phòng ban';
		}else if(empty($room)){
			$error = 'Hãy nhập số phòng';
		}else if(empty($desciption)){
			$error = 'Hãy nhập mô tả';
		}else{
            $id = $_SESSION['id_room'];
			$data = updateDepartment($name, $managername, $desciption, $room, $id);

            // Update account table
            $sql = 'SELECT * FROM account WHERE department_name = ? ORDER BY department_name DESC';
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('s',$_SESSION['department_name']);
            if(!$stm->execute()){
                die('Query error: ' . $stm->error);
            }
            $result = $stm->get_result();
            if($result-> num_rows > 0){
                foreach($result as $row) {
                    $fullname = $row["firstname"]. ' ' .$row["lastname"];

                    if($fullname == $oldmanager) {
                        $fist = $row["firstname"];
                        $last = $row["lastname"];
                        $user_name = $row["username"];
                        $positionid = 2;
                        $day_off = 12;
                        $result = updatePosition($positionid ,$day_off, $fist, $last);
                        $result = updateLeaverequest($day_off, $user_name);
                    }
        
                    if($fullname == $managername) {
                        $fist = $row["firstname"];
                        $last = $row["lastname"];
                        $user_name = $row["username"];
                        $positionid = 1;
                        $day_off = 15;
                        $result = updatePosition($positionid ,$day_off, $fist, $last);
                        $result = updateLeaverequest($day_off, $user_name);
                    }
                }
            }
            $conn->close();
            // End Update account table

			if($data['code'] == 0)
            {
                $manager_name = $managername;
                $success = $data['error'];
            }
            else 
            {
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
                <li class="nav-item day-off-header">
                    <a class="nav-link" href="#">Nghỉ phép</a>
                    <ul class="navbar-nav">
                        <li class="nav-item day-off-tag">
                        <a class="nav-link" href="duyetdon.php">Duyệt đơn nghỉ phép</a>
                        </li>
                    </ul>
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
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Chỉnh sửa phòng ban</h3>
                <form method="post" action="" novalidate>
                    <div class="form-group">
                        <label for="name">Tên phòng ban</label>
                        <input value="<?php echo $name; ?>" name="name" required class="form-control" type="name" placeholder="Phòng ban" id="name">
                    </div>
                    <div class="form-group">
                        <label for="room">Số phòng</label>
                        <input value="<?php echo $room; ?>" name="room" required class="form-control" type="text" placeholder="Số phòng" id="room">
                    </div>
					<div class="form-group">
                        <label for="description">Mô tả</label>
                        <input value="<?php echo $desciption; ?>" name="description" required class="form-control" type="text" placeholder="Mô tả" id="description">
                    </div>

                    <div class="form-group">
                        <label for="">Trưởng phòng</label>
                        <input value="<?php echo $manager_name; ?>" name="managername" required class="form-control" type="text" placeholder="Không có" id="" readonly>
                    </div>
					

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                                echo '<button type="button" class="btn btn-update-manager btn-success btn-register-js px-5 mt-3 mr-2" data-toggle="modal" data-target="#exampletest">Update</button>';
                            }else if($manager_name == 'Không có'){
                                echo '<button type="submit" class="btn btn-update-manager btn-register-js btn-success px-5 mt-3 mr-2">Update</button>';
                            }
                            else if(!is_manager_exist($manager_name)){
                                echo '<button type="button" class="btn btn-update-manager btn-success btn-register-js px-5 mt-3 mr-2" data-toggle="modal" data-target="#exampletest">Update</button>';
                            }
                            else{
                                echo '<button type="submit" class="btn btn-update-manager btn-register-js btn-success px-5 mt-3 mr-2">Update</button>';
                            }
                            

                        ?>
                        <div class="modal fade" id="exampletest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">

                                <!-- Modal content-->
                                <div class="modal-content ">
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title w-100">Bổ nhiệm trưởng phòng</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Xác nhận chọn <?php echo $manager_name; ?> làm trưởng phòng</h4>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-danger px-5 mt-3 mr-2" data-dismiss="modal">Đóng</button>
                                        <button type="submit"  class="btn btn-success px-5 mt-3 mr-2">Xác nhận</button>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>	
                        <!--
                        <button type="submit" class="btn btn-update-manager btn-register-js btn-success px-5 mt-3 mr-2">Update</button>
                        <button type="button" name="room-delete" class="btn btn-success" data-toggle="modal" data-target="#exampletest">Xóa</button>
                        -->
                    </div>
                </form>
                <div class="row gutters form-btn-submit">   
                    <button class="btn btn-add-manager btn-placeholder-submit btn-success px-5 mt-3 mr-2">Chọn trưởng phòng</button>
                    <button type="button" data-toggle="modal" data-target="#exampledelete"  class="btn btn-reset-manager btn-placeholder-submit btn-success px-5 mt-3 mr-2">Xóa trưởng phòng</button>
                    <!-- Delete trưởng phòng confimr dialog -->
                    <div class="modal fade" id="exampledelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content ">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100">Xóa trưởng phòng</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Xác nhận xóa trưởng phòng <?php echo $manager_name; ?></h4>                                      
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="POST">
                                        <button type="button" class="btn btn-danger px-5 mt-3 mr-2" data-dismiss="modal">Đóng</button>
                                        <button type="submit" name="btn-reset-manager"  class="btn btn-success px-5 mt-3 mr-2">Xác nhận</button>     
                                    </form>                                 
                                </div>
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



    </div>

    <div class='notification_chooseManager'>
        <form action="" method="POST" class='chooseManager_form'>
            <div class='notification_exit'>X</div>
            <h4 class="font-weight-bold chooseManager_title">Chọn trưởng phòng</h4>
            <div class="chooseManager_body">
                <div class="info">
                    <div class="depart">
                        <h5 class="font-weight-bold text-color-blue">Phòng ban</h5>
                        <p><?= $name ?></p>
                    </div>
                    <div class="num_room">
                        <h5 class="font-weight-bold text-color-blue">Số phòng</h5>
                        <p><?= $room ?></p>
                    </div>
                    <div class="manager_pre">
                        <h5 class="font-weight-bold text-color-blue">Trưởng Phòng hiện tại</h5>
                        <p><?= $manager_name ?></p>
                    </div>
                </div>
    
                <div class="choose-manager">
                    <h5 class="font-weight-bold text-color-blue">Chọn trưởng phòng mới</h5>
                    <?php 
                        $sql = 'SELECT * FROM account WHERE department_name = ? and positionid !="3" and positionid !="1"';
                        $conn = open_database();
                        
                        $stm = $conn->prepare($sql);
                        $stm->bind_param('s',$name);
                        if(!$stm->execute()){
                            die('Query error: ' . $stm->error);
                        }

                        $result = $stm->get_result();
                        if($result-> num_rows > 0){
                            echo '<select required name="manager-list" class="form-control" id="">';
                            while($row = $result->fetch_array()){
                                $name = $row["firstname"].' '.$row["lastname"];
                                if($manager_name == $name){
                                    echo '<option value="'.$row["firstname"].' '.$row["lastname"].'"selected>'.$row["firstname"].' '.$row["lastname"].'</option>';
                                }
                                echo '<option value="'.$row["firstname"].' '.$row["lastname"].'">'.$row["firstname"].' '.$row["lastname"].'</option>';
                            }
                            echo '</select>';
                        }
                        else {
                            echo 'Phòng ban này chưa có nhân viên.';
                        }
                        $conn->close();
					?>
                </div>
            </div>
            <button type="submit" class="btn btn-add-manager-form btn-placeholder-submit btn-success px-5 mt-3 mr-2">Lưu</button>


        </form>
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>