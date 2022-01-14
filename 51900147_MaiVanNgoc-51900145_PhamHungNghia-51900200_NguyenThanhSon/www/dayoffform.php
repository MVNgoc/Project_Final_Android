<?php 
	// kiểm tra nếu chưa đăng nhập thì sẽ không truy cập được vào trang index mà sẽ bị chuyển hướng vế trang login
	session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

	//nếu chưa thay đổi pass thì sẽ không truy cập được vào trang index mà sẽ bị chuyển hướng vế trang đổi mật khẩu
	if($_SESSION['pwd'] == $_SESSION['username']) {
		header('Location: changepassword.php');
		exit(); // Chuyển đến trang thay đổi mật khẩu
	}

    if ($_SESSION['positionid'] == 3) {
        header('Location: index.php');
        exit();
    }


	require_once('./admin/db.php');


	$error = '';
	$success = '';
	$leavetype = '';
	$star_date = '';
	$end_date = '';
	$date_number = '';
	$leavereason = '';
	$upload ='';

	if(isset($_POST['leavetype']) && isset($_POST['star_date']) &&
	isset($_POST['date_number']) && isset($_POST['leavereson'])){

		$leavetype = $_POST['leavetype'];
		$star_date = $_POST['star_date'];
		$date_number = $_POST['date_number'];
		$leavereason = $_POST['leavereson'];


		$upload = $_FILES['attachfile']['name'];
		$targer = 'files_upload/' . $upload;

		$extension = pathinfo($upload,PATHINFO_EXTENSION);
		$file = $_FILES['attachfile']['tmp_name'];
		$size = $_FILES['attachfile']['size'];	
		


		if(empty($leavetype)){
			$error = "Hãy nhập tiêu đề";
		}
		else if(empty($star_date)){
			$error = "Hãy chọn ngày bắt đầu nghỉ";
		}
		else if(empty($leavereason)){
			$error = "Hãy nhập lí do nghỉ";
		}
		else if(!in_array($extension,['png','jpg','jpeg','gif','ppt','zip','rar','pptx','doc','docx','xls','xlsx','pdf']) && !empty($upload)){
			$error = "File bạn gửi không đúng định dạng yêu cầu";
		}
		else if($_FILES['attachfile']['size'] == 0 && !empty($upload) ){
			$error = "Kích thước file phải nhỏ hơn 2mb";
		}
		else if(!empty($star_date)){

			$username = $_SESSION["username"];

			$sql = "SELECT * FROM leaverequest WHERE username = '$username'";
			$conn = open_database();
			$stm = $conn->prepare($sql);
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$datecheckold = $row['day_left']; 

			$currenttime = date('Y-m-d');
			$start = strtotime($star_date);
			$now = strtotime($currenttime);
			$interval2 = $start - $now;
			$date_check = floor($interval2 / (60*60*24));

			if($date_check <= 0){
				$error = 'Thời gian bắt đầu không hợp lệ';
			}
            else if($date_number > $datecheckold){
				$error = 'Số ngày nghỉ không hợp lệ';
			}
			else{
				$username = $_SESSION['username'];
				if(!empty($upload)) {
					if(move_uploaded_file($file, $targer)) {
						$data = insertleave($username,$leavetype,$leavereason,$star_date,$currenttime,$upload,$date_number);
					}
					else {
						$data['code'] = 2;
					}
				}
				else {
					$data = insertleave($username,$leavetype,$leavereason,$star_date,$currenttime,$upload,$date_number);
				}
				if($data['code']==3){
					$error = 'Ngày bắt đầu nghỉ bị trùng';
				}
				else if($data['code']==0){
					$leavetype = false;
					$leavereason = false;
					$star_date = false;
					$date_number = false;
					$success = 'Tạo đơn xin nghỉ thành công';
					
				}else{
					$error = 'Đã có lỗi xảy ra. Vui lòng thử lại sau';
				}
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
												<a class="nav-link" id="showday" type="button"	>Xem ngày nghỉ phép</a>
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

		<div class="container">
			<div class="row justify-content-center ">
				<div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3 addstaffform">
					<h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đơn xin nghỉ phép</h3>
					<form method="post" action="" novalidate enctype="multipart/form-data">
						<div class="form-group">
							<label for="leavetype">Tiêu đề</label>
							<input value="<?= $leavetype ?>" name="leavetype" required class="form-control" type="leavetype" placeholder="Nhập tiêu đề" id="leavetype">
						</div>

						<div class="form-group">
							<label for="star_date">Thời gian bắt đầu</label>
							<input value="<?= $star_date ?>" name="star_date" required class="form-control" type="date" id="star_date">
						</div>

						<div class="form-group">
							<label for="date_number">Số ngày nghỉ</label>
							<?php 
								$username = $_SESSION["username"];
								$sql = "SELECT * FROM leaverequest WHERE username = '$username'";
								$conn = open_database();
								$result = $conn-> query($sql);
								echo '<select required class="form-control" name="date_number">';
									if($result->num_rows > 0){
										while($row = $result->fetch_array()){
											for($i = 1; $i <= $row["day_left"]; $i++){
												echo '<option id="date_number" name="date_number" value="'.$i.'">'.$i.'</option>';										
											}
										}
									}
								echo '</select>';
							?>
						</div>

						<div class="form-group">
							<label for="leavereson">Lí do nghỉ phép</label>
							<input value="<?= $leavereason ?>" name="leavereson" required class="form-control" type="text" placeholder="Nhập lí do nghỉ" id="leavereson">
						</div>

						<div class="form-group">
                        	<label for="attachfile">File đính kèm</label>
                        	<input value="" name="attachfile" type="file" id="attachfile" style="display: block">
                    	</div>


						<div class="form-group">
							<?php
								if (!empty($error)) {
									echo "<div class='alert alert-danger'>$error</div>";
								}
							?>

							<?php
								$sql = "SELECT * FROM leaveform WHERE username = '$username' ORDER BY date_applied ASC";
								$conn = open_database();
								$stm = $conn->prepare($sql);
								if(!$stm->execute()){
									die('Query error: ' . $stm->error);
								}
								$result = $stm->get_result();
								if($result->num_rows > 0){
									while($row = $result->fetch_assoc()){
										$test = $row['date_applied']; 
									}
									$currenttime = date('Y-m-d');
									$now = strtotime($currenttime);
									$applied = strtotime($test);
									$inter = $now - $applied;
									$date_checkforbtn = floor($inter / (60*60*24));
									if($date_checkforbtn<7){
										$check_dayleftuse = 7 - $date_checkforbtn;
										echo'
											<div class="alert alert-danger">Còn '.$check_dayleftuse.' ngày nữa để thực hiện chức năng này tiếp</div>
											<button type="submit" id="myform" class="btn btn-register-js btn-success px-5 mt-3 mr-2 btn_submit" disabled>Nộp form</button>
											<button id="test" type="reset" class="btn btn-success px-5 mt-3 mr-2" disabled>Reset</button>
										';
									}else{
										echo'
										<button type="submit" id="myform" class="btn btn-register-js btn-success px-5 mt-3 mr-2 btn_submit">Nộp form</button>
										<button id="test" type="reset" class="btn btn-success px-5 mt-3 mr-2">Reset</button>
									
									';
									}
								}else{
									echo'
										<button type="submit" id="myform" class="btn btn-register-js btn-success px-5 mt-3 mr-2 btn_submit">Nộp form</button>
										<button id="test" type="reset" class="btn btn-success px-5 mt-3 mr-2">Reset</button>
									
									';
								}
								
							?>
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
		
		<footer class="footer">	
		</footer>


		<!--This is modal show day -->	
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content ">
					<div class="modal-header text-center">
						<h4 class="modal-title w-100">Xem ngày nghỉ</h4>
					</div>
					<div class="modal-body">
						<h4>Số ngày nghỉ có: <?php echo $_SESSION["day_off"]." ngày"; ?> ngày</h4>
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