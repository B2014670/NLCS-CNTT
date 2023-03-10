<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'Tin nhắn đã tồn tại!';
    } else {
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'Gửi tin nhắn thành công!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</head>

<body>

    <?php @include 'modules/header.php'; ?>

    <section class="heading text-center justify-content-center align-items-center">
        <h3>Liên hệ với chúng tôi</h3>
        <p> <a href="home.php">Trang chủ</a> / Liên hệ </p>
    </section>

    <section class="contact">

        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center ">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong rounded">
                        <div class="card-body p-5 text-center">

                        <form action="" method="post">
                            <h1 class="mb-2 text-uppercase">gửi tin nhắn cho chúng tôi!</h1>
                            <div class="form-outline mb-3 ">
                                <input type="text" name="name" class="form-control form-control-lg py-3" placeholder="nhập tên của bạn" required />
                            </div>
                            <div class="form-outline mb-3 ">
                                <input type="email" name="email" class="form-control form-control-lg py-3" placeholder="nhập email của bạn" required />
                            </div>
                            <div class="form-outline mb-3 ">
                                <input type="number" name="number" class="form-control form-control-lg py-3" placeholder="nhập số điện thoại" required />
                            </div>
                            <div class="form-outline mb-3">
                                <textarea name="message" class="form-control form-control-lg py-3" placeholder="nhập tin nhắn của bạn" required cols="30" rows="10"></textarea>
                            </div>
                            <div class="pt-2">
                                <input type="submit" value="gửi tin nhắn" name="send" class="btn">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <?php @include 'modules/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>