<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['capnhatthongtin'])) {
    $hoten = $_POST['hoten'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $diachi = $_POST['diachi'] ?? '';

    $avatar = $_FILES['avatar']['name'] ?? '';
    $avatar_tmp = $_FILES['avatar']['tmp_name'] ?? '';
    move_uploaded_file($avatar_tmp, 'uploaded_img/' . $avatar);

    if ($avatar != '') {
        $sql2 = "SELECT avatar FROM users WHERE id='$user_id'";
        $sql_taikhoan = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($sql_taikhoan);

        if (!empty($row['avatar']) && file_exists('uploaded_img/' . $row['avatar']) && $row['avatar'] != 'avtDefault.png') {
            unlink('uploaded_img/' . $row['avatar']);
        }
        $sql = "UPDATE users SET name='$hoten', email='$email',phone='$phone',address='$diachi',avatar='$avatar' WHERE id='$user_id'";
    } else {

        $sql = "UPDATE users SET name='$hoten', email='$email',phone='$phone',address='$diachi' WHERE id='$user_id'";
    }
    echo "<script>alert('cập nhật thành công');</script>";
    mysqli_query($conn, $sql);

    // Xóa session hiện tại
    session_destroy();

    // Tạo session mới để lưu trữ thông tin tài khoản mới của người dùng
    session_start();

    // Cập nhật biến session mới với thông tin tài khoản mới của người dùng
    $_SESSION['user_name'] = $hoten;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_id'] = $user_id;
}
$sql = "SELECT * FROM users where id='$user_id'";
$sth = mysqli_query($conn, "SELECT * FROM users where id='$user_id'");
$row = mysqli_fetch_array($sth);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <style>
        .taikhoan-nav li {
            list-style: none;
            padding: 12px;
        }

        .taikhoan-nav li:hover {
            background-color: pink;
        }
    </style>
</head>

<body>
    <?php
    @include 'modules/header.php';

    ?>
    <div class="container mt-3" style="padding-top: 100px;">
        <ul class="taikhoan-nav navbar navbar-expand-lg navbar-light bg-light p-0 mx-auto">
            <li class="col text-center"><a class="text-dark" href="profile.php?query=taikhoan">THÔNG TIN</a></li>
            <li class="col text-center"><a class="text-dark" href="profile.php?query=tatca">TẤT CẢ ĐƠN</a></li>
            <li class="col text-center"><a class="text-dark" href="profile.php?query=choxacnhan">ĐƠN CHỜ XÁC NHẬN</a></li>            
            <li class="col text-center"><a class="text-dark" href="profile.php?query=hoanthanh">LỊCH SỬ MUA HÀNG</a></li>
        </ul>
    </div>
    <?php
    if ($_GET['query'] == 'taikhoan')
        @include 'quanlytaikhoan/thongtin.php';
    if ($_GET['query'] == 'choxacnhan')
        @include 'quanlytaikhoan/choxacnhan.php';
    if ($_GET['query'] == 'hoanthanh')
        @include 'quanlytaikhoan/hoanthanh.php';
    if ($_GET['query'] == 'tatca')
        @include 'quanlytaikhoan/tatca.php'
    ?>
    

    <script src="js/jQuery.js"></script>
    <script src="js/script.js"></script>
</body>

</html>