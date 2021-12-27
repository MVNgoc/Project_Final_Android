<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Đăng xuất</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
    <script src="main.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 mt-5 mx-auto p-3 border rounded text-black logout-form">
            <h4>Đăng xuất thành công</h4>
            <p>Tài khoản của bạn đã được đăng xuất khỏi hệ thống.</p>
            <p>Nhấn <a href="login.php" class="">vào đây</a> để trở về trang đăng nhập, hoặc trang web sẽ tự động chuyển hướng sau <span id="counter" class="text-danger">10</span> giây nữa.</p>
            <a class="btn btn-success px-5" href="login.php">Đăng nhập</a>
        </div>
      </div>
    </div>
  </body>
</html>
