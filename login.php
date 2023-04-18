<?php
@include "config.php";
session_start();
if (isset($_POST['submit'])) {
    $filter_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = mysqli_real_escape_string($conn, $filter_pass); // md5($filter_pass)

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email' AND password='$pass'") or die("query_fail");

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        } else if ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        } else {
            $message[] = 'Không tìm thấy người dùng!';
        }
    } else {
        $message[] = 'Email hoặc mật khẩu không chính xác!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>
    <section class="vh-100" style="background-image: url('images/home-bg.png');
    background-repeat: no-repeat;
    background-attachment: scroll;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong rounded">
                        <div class="card-body p-5 text-center">

                            <form action="" method="post">
                                <h1 class="mb-2 text-uppercase">Đăng Nhập</h1>

                                <div class="form-outline mb-3 ">
                                    <input type="email" name="email" class="form-control form-control-lg py-3" placeholder="Email" required />
                                </div>

                                <div class="form-outline ">
                                    <input type="password" name="pass" class="form-control form-control-lg py-3" placeholder="Mật khẩu" required />
                                </div>
                                <div class="pt-2">
                                    <button class="btn btn-lg btn-block" name="submit" type="submit" style="background-color: 	#E84393; color:white">Đăng nhập</button>
                                </div>
                                <div class="pt-2">
                                    <p>Bạn chưa có tài khoản? Đăng ký <a href="register.php" style="color: #E84393">Tại đây</a></p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>