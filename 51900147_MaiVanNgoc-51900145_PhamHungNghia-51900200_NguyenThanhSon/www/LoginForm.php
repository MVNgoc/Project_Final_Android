<?php 
	session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

	require_once('./admin/db.php');

	$error = '';
	$user = '';
    $pass = '';

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
            if($data) {
                $_SESSION['username'] = $user;
                $_SESSION['id'] = $data['id'];
    
                header('Location: index.php');
                exit();
            }
            else {
                $error = 'Invalid username or password';
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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
    <script src="main.js"></script>	
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
						<input type="checkbox">Remember Me
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