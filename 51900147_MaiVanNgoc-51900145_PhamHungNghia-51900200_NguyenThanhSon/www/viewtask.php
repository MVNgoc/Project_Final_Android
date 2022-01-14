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

    if ($_SESSION['positionid'] != 1 && $_SESSION['positionid'] != 2) {
        header('Location: index.php');
        exit();
    }

    $position = '';

    require_once('./admin/db.php');

    if(isset($_POST['task-view'])) {
        $id_task = $_POST['task-view'];
        $_SESSION['id_task'] = $id_task;
    }
    else {
        $id_task = $_SESSION['id_task'];
    }

    $sql = "SELECT task_title, task_description, staff_assign, task_status, message_task,completion_level FROM task WHERE id = '$id_task' ";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $result = $conn-> query($sql);
    $row = $result->fetch_assoc();
    $taskdeliver = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
    $task_title = $row['task_title'];
    $task_description = $row['task_description'];
    $staff_assign = $row['staff_assign'];
    $task_status = $row['task_status'];
    $message_task = $row['message_task'];
    $completion_level = $row['completion_level'];

    $sql = "SELECT DATE_FORMAT(start_time, '%d/%m/%Y %h:%i:%s') AS start_time FROM task WHERE id = '$id_task'";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $result = $conn-> query($sql);
    $row = $result->fetch_assoc();
    $start_time = $row['start_time'];

    $sql = "SELECT DATE_FORMAT(deadline, '%d/%m/%Y %h:%i:%s') AS deadline FROM task WHERE id = '$id_task'";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $result = $conn-> query($sql);
    $row = $result->fetch_assoc();
    $deadline = $row['deadline'];

    $sql = "SELECT DATE_FORMAT(deadline, '%Y-%m-%dT%h:%i') AS deadline FROM task WHERE id = '$id_task'";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $result = $conn-> query($sql);
    $row = $result->fetch_assoc();
    $extend_deadline = $row["deadline"];

    if(isset($_POST['btnstarttask'])) {
        $task_status = 'In progress';
        updateStatus($task_status, $id_task);
    }

    $error = '';
    $success = '';
    if(isset($_POST['meesagetask'])) {
        $d = new DateTime('', new DateTimeZone('Asia/Ho_Chi_Minh')); 
        $a = $d->format('Y-m-d h:i');
        $h_m = explode(':', $a); //Tách giờ phút hiện tại
        $time_submit = $a;

        $upload = $_FILES['attachfile']['name'];
        $targer = 'files_upload/' . $upload;

		$extension = pathinfo($upload,PATHINFO_EXTENSION);
		$file_name = $_FILES['attachfile']['tmp_name'];
		$file_size = $_FILES['attachfile']['size'];

        $message_task = $_POST['meesagetask'];

        if(empty($message_task)) {
            $error = 'Vui lòng nhập nội dung trước khi submit task';
        }
        else if(empty($upload)) {
            $error = 'Vui lòng đính kèm file trước khi submit';
        }
        else if(!in_array($extension,['png','jpg','jpeg','gif','ppt','zip','pptx','doc','docx','xls','xlsx','pdf']) && !empty($upload)){
			$error = "File bạn gửi không đúng định dạng yêu cầu";
		}
		else if($_FILES['attachfile']['size'] > 1000000 && !empty($upload)){
			$error = "Kích thước file quá lớn";
		}
        else {
            if(move_uploaded_file($file_name, $targer)) {
                $data = updateMessageTask($message_task, $time_submit, $upload, $id_task);
            }
            else {
                $data['code'] = 1;
            }
            if($data['code'] == 0) {
                $task_status = 'Waiting';
                updateStatus($task_status, $id_task);
                $success = $data['error'];
            }
            else {
                $error = 'Có lỗi xảy ra vui lòng thử lại';
            }
        }
    }

    if(isset($_POST['btnrejectedtask'])) {
        $error = 'Hãy nhập ghi chú trước khi Rejected Task và gia hạn Deadline nếu muốn';    
    }

    if(isset($_POST['notetask']) && isset($_POST['deadline'])) {
        $notetask = $_POST['notetask'];
        $deadline = $_POST['deadline'];

        $upload = $_FILES['attachfile']['name'];
        $targer = 'files_upload/' . $upload;

        $extension = pathinfo($upload,PATHINFO_EXTENSION);
        $file_name = $_FILES['attachfile']['tmp_name'];
        $file_size = $_FILES['attachfile']['size'];

        if(empty($notetask)) {
        $error = 'Vui lòng nhập ghi chú trước khi Rejected Task';
        }
        else if(!in_array($extension,['png','jpg','jpeg','gif','ppt','zip','pptx','doc','docx','xls','xlsx','pdf']) && !empty($upload)){
        $error = "File bạn gửi không đúng định dạng yêu cầu";
		}
		else if($_FILES['attachfile']['size'] > 1000000 && !empty($upload)){
			$error = "Kích thước file quá lớn";
		}
        else {
            if(!empty($upload)) {
                if(move_uploaded_file($file_name, $targer)) {
                    $data = updateRejectedTaskFile($notetask, $deadline, $upload, $id_task);
                }
                else {
                    $data['code'] = 1;
                }
            }
            else {
                $data = updateRejectedTask($notetask, $deadline, $id_task);
            }
            if($data['code'] == 0) {
                $task_status = 'Rejected';
                updateStatus($task_status, $id_task);
                $success = $data['error'];
                $error = '';
            }
            else {
                $error = 'Có lỗi xảy ra vui lòng thử lại';
            }
        }
    }

    if(isset($_POST['btncompletetask'])) {
        $error = 'Vui lòng đánh giá mức độ hoàn thành Task của nhân viên trước khi Duyệt';;    
    }

    if(isset($_POST['level_complete'])) {
        $time_complete = $_SESSION['time_complete'];
        $completion_level = $_POST['level_complete'];
        $data = updateCompleteLevel($completion_level, $time_complete , $id_task);
        if($data['code'] == 0) {
            $task_status = 'Completed';
            updateStatus($task_status, $id_task);
            $sql = "SELECT message_task FROM task WHERE id = '$id_task' ";
            $conn = open_database();
            $stm = $conn -> prepare($sql);
            $result = $conn-> query($sql);
            $row = $result->fetch_assoc();
            $message_task = $row['message_task'];
            $success = $data['error'];
            $error = '';
        }
        else {
            $error = 'Có lỗi xảy ra vui lòng thử lại';
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
                    if ($_SESSION['positionid'] == 1 || $_SESSION['positionid'] == 2) {
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
                            <div class="position">
                                <h5 class="font-weight-bold">Tên Task</h5>
                                <p class="font-size-m"><?= $task_title ?></p>
                                        
                                <h5 class="font-weight-bold">Mô tả</h5>
                                <p class="font-size-m"><?= $task_description ?></p>

                                <?php
                                    if (!empty($error)) {
                                        echo "<div class='alert alert-danger'>$error</div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card-user h-100">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary font-weight-bold"></h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Người giao task:</label> 
                                        <p class="font-size-s"> <?= $taskdeliver ?>  </p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Người nhận task:</label> 
                                        <p class="font-size-s"> <?= $staff_assign ?>  </p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Thời gian tạo task:</label> 
                                        <p class="font-size-s"> <?= $start_time ?> </p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Deadline:</label>   
                                        <p class="font-size-s"> <?= $deadline ?> </p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Trạng thái:</label> 
                                        <p class="font-size-s"> <?= $task_status ?> </p>
                                    </div>
                                </div>

                                <?php 
                                    if($_SESSION['positionid'] == 1 || $_SESSION['positionid'] == 2) {
                                        if($task_status == 'Completed') {
                                            echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Đánh giá mức độ hoàn thành:</label> 
                                                        <p class="font-size-s">'.$completion_level.'</p>
                                                    </div>
                                                </div>
                
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Tiến độ hoàn thành:</label> 
                                                        <p class="font-size-s">' . $message_task . '</p>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                ?>

                                <?php 
                                    if($_SESSION['positionid'] == 2) {                             
                                        if($task_status == 'Rejected') {
                                            echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Ghi chú của trưởng phòng:</label> 
                                                        <p class="font-size-s">'. $message_task. '</p>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                ?>

                                <?php 
                                    if($_SESSION['positionid'] == 1 || $_SESSION['positionid'] == 2) {     
                                        if($task_status == 'Waiting') {
                                            echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Nội dung tin nhắn:</label> 
                                                        <p class="font-size-s">' . $message_task . '</p>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                ?>

                                <?php
                                    if(isset($_POST['btncompletetask'])) {
                                        if($task_status == 'Waiting') {                  
                                            checkDeadline($deadline, $id_task);
                                        }
                                    }
                                ?>
                                
                                <?php
                                    if(isset($_POST['btnrejectedtask'])) {
                                        if($task_status == 'Waiting') {
                                            echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Ghi chú:</label> 
                                                        <input value="" name="notetask" required class="meesagetask form-control" type="text" placeholder="Ghi chú" id="starttime">
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold" for="attachfile">File đính kèm</label>
                                                        <input name="attachfile" type="file" id="attachfile" style="display: block">
                                                    </div>
                                                </div>
                
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="deadline" class="font-weight-bold">Gia hạn deadline:</label>
                                                        <input value="'.  $extend_deadline .'" name="deadline" required class="form-control" type="datetime-local" placeholder="Thời gian kết thúc" id="deadline">
                                                    </div>
                                                </div> ';
                                        }
                                    }
                                ?>
                                                      
                                <?php 
                                    if($_SESSION['positionid'] == 2) {
                                        
                                        if($task_status == 'In progress' || $task_status == 'Rejected') {
                                            echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Nội dung:</label> 
                                                        <input value="" name="meesagetask" required class="meesagetask form-control" type="text" placeholder="Nội dung" id="starttime">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold" for="attachfile">File đính kèm</label>
                                                        <input name="attachfile" type="file" required id="attachfile" style="display: block">
                                                    </div>
                                                </div>';
                                        }
                                    }
                                ?>
                            </div>
    
                            <?php 
                                if($_SESSION['positionid'] == 2) {
                                    echo '<div class="row gutters btn-start-form">
                                            '?> <?php 
                                            if($task_status == 'New') {
                                                echo '<button type="submit" name="btnstarttask" class="btn btn-start-task btn-success px-5 mt-3 mr-2">Start</button>';
                                            }
                                            ?> <?php
                                            '
                                            '?> <?php 
                                            if($task_status == 'In progress' || $task_status == 'Rejected') {
                                                echo '<button type="submit" name="btnsubmittask" class="btn-register-js btn btn-submit-task btn-success px-5 mt-3 mr-2">Submit</button>';
                                            }
                                            ?> <?php
                                            '
                                        </div>';
                                }
                                if($_SESSION['positionid'] == 1) {
                                        
                                    if($task_status == 'Waiting') {
                                        echo '<div class="row gutters btn-start-form">';
                                        echo '<button type="submit" name="btncompletetask" class="btn btn-start-task btn-success px-5 mt-3 mr-2">Duyệt Task</button>';
                                        echo '<button type="submit" name="btnrejectedtask" class="btn-register-js btn btn-submit-task btn-success px-5 mt-3 mr-2">Gửi trả Task</button>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </form>
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