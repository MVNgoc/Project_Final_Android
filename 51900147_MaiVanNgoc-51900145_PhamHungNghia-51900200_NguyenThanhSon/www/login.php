<?php 
	// kiểm tra nếu đã đăng nhập thì không thể truy cập lại trang login
	session_start();
    if (isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

	require_once('./admin/db.php');

	if(isset($_COOKIE['username']) && isset($_COOKIE['pwd'])) {
		$user = $_COOKIE['username'];
    	$pass = $_COOKIE['pwd'];
	}
	else {
		$user = '';
		$pass = '';
	}

	$error = '';

	if (isset($_POST['username']) && isset($_POST['pwd'])) {
        $user = $_POST['username'];
        $pass = $_POST['pwd'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else {
            $data = login($user, $pass);
            if($data['code'] == 0) {

				//chỉ lưu cookie khi user chọn rememberme
				if(isset($_POST['remember'])) {
					//set cookie for 1 day
					setcookie('username', $user, time() + 3600 * 24);
					setcookie('pwd', $pass, time() + 3600 * 24);
				}

                $_SESSION['username'] = $user;
				$_SESSION['pwd'] = $pass;
				if($_SESSION['pwd'] == $_SESSION['username']) {
					die('please change password'); // Chuyển đến trang thay đổi mật khẩu
				}
				else {
					header('Location: index.php');
					exit();
				}
            }
            else {
                $error = $data['error'];
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
			</div>
			<div class="card-body">
				<form id="loginForm" action="" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input id="username" name="username" value="<?= $user ?>" type="text" class="form-control" placeholder="username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input id="pwd" name="pwd" value="<?= $pass ?>" type="password" class="form-control" placeholder="password">
					</div>
					<div class="row align-items-center remember">
						<input id="remember" name="remember" type="checkbox">Remember Me
					</div>
					<div class="form-group">
						<button class="btn btn-success px-5 float-right">Login</button>
					</div>
					<br>
					<div id="errorMessage" class="errorMessage my-3">
						<?php 
							if (!empty($error)) {
								echo "<div class='alert alert-danger'>$error</div>";
							}
						?>
					</div>		
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>