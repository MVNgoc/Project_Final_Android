<?php 
	// kiểm tra nếu chưa đăng nhập thì sẽ không truy cập được vào trang addstaff mà sẽ bị chuyển hướng vế trang login
	session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    require_once('./admin/db.php');

    $error = '';
    $success = '';
    $npass = '';
    $cfpass = '';

    if (isset($_POST['newpass']) && isset($_POST['comfirmpass'])) {
        $npass = $_POST['newpass'];
        $cfpass = $_POST['comfirmpass'];
        $user = $_SESSION['username'];
 
        if (empty($npass)) {
            $error = 'Vui lòng nhập mật khẩu mới';
        }
        else if (strlen($npass) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 kí tự';
        }
        else if (empty($cfpass)) {
            $error = 'Vui lòng nhập lại mật khẩu để xác nhận';
        }
        else if ($npass != $cfpass) {
            $error = 'Mật khẩu xác nhận không khớp với mật khẩu mới. Vui lòng nhập lại';
        }
        else {
            $data = changepass($cfpass, $user);
            if($data['code'] == 0) {
                $success = $data['error'];
                $npass = false;
                $cfpass = false;
                $_SESSION['pwd'] = $cfpass;
            }
            else {
                $error = $data['error'];
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
	<title>Change Password Page</title>
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
						<a class="nav-link" href="logout.php">Đăng xuất</a>
					</li>		
				</ul>
			</nav>

			<div class="btn-showlist">
				<button class="btn-list-item"></button>
			</div>
		</header>

        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Change Password</h3>
                </div>
                <div class="card-body">
                    <form id="loginForm" action="" method="post">
                            
                            <label class="label-username text-white" for="username">Mật khẩu:</label>
                            <div class="input-group form-group">
                                <input value="<?= $npass ?>" id="newpass" name="newpass" type="password" class="form-control" placeholder="password">
                                
                            </div>

                            <label class="label-pwd text-white" for="pwd">Xác nhận mật khẩu:</label>
                            <div class="input-group form-group">
                                <input value="<?= $cfpass ?>" id="comfirmpass" name="comfirmpass" type="password" class="form-control" placeholder="comfirm password">
                            </div>
    
                            <div id="errorMessage" class="errorMessage my-3">
                                <?php 
                                    if (!empty($error)) {
                                        echo "<div class='alert alert-danger'>$error</div>";
                                    }
                                    if(!empty($success)) {
                                        echo "<div class='alert alert-success'>$success "?> <a href="index.php" class=""> Click here</a> to return Homepage <?php echo "</div>"; 
                                    }
                                ?>
                            </div>
    
                            <div class="form-group">
                                <button class="btn btn-success px-5 float-right">Change</button>
                            </div>
                            <br>           
                    </form>
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