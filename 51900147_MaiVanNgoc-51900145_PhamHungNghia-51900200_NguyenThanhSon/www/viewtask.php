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
        
        $sql = "SELECT task_title, task_description, staff_assign, task_status FROM task WHERE id = '$id_task' ";
        $conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
        $taskdeliver = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
        $task_title = $row['task_title'];
        $task_description = $row['task_description'];
        $staff_assign = $row['staff_assign'];
        $task_status = $row['task_status'];

        $sql = "SELECT DATE_FORMAT(start_time, '%d/%m/%Y %h:%i:%s') AS start_time FROM task WHERE id = '$id_task'" ;
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

    }
    else {
        $id_task = $_SESSION['id_task'];
        $sql = "SELECT task_title, task_description, staff_assign, task_status FROM task WHERE id = '$id_task' ";
        $conn = open_database();
		$stm = $conn -> prepare($sql);
		$result = $conn-> query($sql);
		$row = $result->fetch_assoc();
        $taskdeliver = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
        $task_title = $row['task_title'];
        $task_description = $row['task_description'];
        $staff_assign = $row['staff_assign'];
        $task_status = $row['task_status'];

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
                        </div>

                        <?php 
                            if($_SESSION['positionid'] == 2) {
                                echo '<div class="row gutters btn-start-form">
                                        <form action="" method="post">
                                            <button type="submit" name="btnstarttask" class="btn btn-start-task btn-success px-5 mt-3 mr-2">Start</button>
                                            '?> <?php 
                                            if($task_status != 'New') {
                                                echo '<button type="submit" name="btnsubmittask" class="btn btn-submit-task btn-success px-5 mt-3 mr-2">Submit</button>';
                                            }
                                            ?> <?php
                                            '
                                        </form>
                                    </div>';
                            }
                        ?>
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