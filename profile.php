<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};
// if (isset($_POST['update_product'])) {

//     $update_p_id = $_POST['update_p_id'];
//     $name = mysqli_real_escape_string($conn, $_POST['name']);
//     $price = mysqli_real_escape_string($conn, $_POST['price']);
//     $details = mysqli_real_escape_string($conn, $_POST['details']);

//     mysqli_query($conn, "UPDATE `products` SET name = '$name', details = '$details', price = '$price' WHERE id = '$update_p_id'") or die('query failed');

//     $image = $_FILES['image']['name'];
//     $image_size = $_FILES['image']['size'];
//     $image_tmp_name = $_FILES['image']['tmp_name'];
//     $image_folter = 'uploaded_img/' . $image;
//     $old_image = $_POST['update_p_image'];
//     $image_new = rand(1, 10000) . time() . $_FILES['image']['name'];
//     if (!empty($image)) {
//         if ($image_size > 2000000) {
//             $message[] = 'image file size is too large!';
//         } else {
//             mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
//             move_uploaded_file($image_tmp_name, $image_folter);
//             unlink('uploaded_img/' . $old_image);
//             $message[] = 'image updated successfully!';
//         }
//     }

//     $message[] = 'product updated successfully!';
// }

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

        if (!empty($row['avatar']) && file_exists('uploaded_img/' . $row['avatar']) && $row['avatar']!='avtDefault.png') {
            unlink('uploaded_img/' . $row['avatar']);
        }
        $sql = "UPDATE users SET name='$hoten', email='$email',phone='$phone',address='$diachi',avatar='$avatar' WHERE id='$user_id'";
        
    } else {

        $sql = "UPDATE users SET name='$hoten', email='$email',phone='$phone',address='$diachi' WHERE id='$user_id'";
    }
    echo "<script>alert('thanhcong');</script>";
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
</head>

<body>
    <?php
    @include 'modules/header.php';

    ?>
    <div class="container my-2 profile" style="padding-top: 100px;">
        <h3 class="text-center text-uppercase">Thông tin cá nhân </h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- <div class="col-4 d-flex justify-content-center align-items-center"> -->
                <div class="col-4 text-center">
                    <img class="rounded-circle w-100" src="uploaded_img/<?php echo $row['avatar'];   ?>" alt="">
                    <label for="avatar" class="text-center bg-success text-white p-2 rounded mt-1">Tải ảnh lên</label>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" id="avatar" name="avatar" class="d-none">
                </div>

                <div class="col-8 box">

                    <div class="form-group">
                        <label for="">Họ và tên</label>
                        <input type="text" class="form-control" value="<?php echo $row['name'] ?>" name="hoten" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" value="<?php echo  $row['email'] ?>" name="email" id="">
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <div class="input-group border">
                            <input id="password-input-matkhau" value="<?php echo $row['password'] ?>" name='matkhau' type="password" class="form-control border-0" placeholder="Nhập mật khẩu của bạn">
                            <i onclick="ShowPassword(document.querySelector('#password-input-matkhau'))" class="fa-sharp fa-solid fa-eye border-0 bg-white px-2 my-auto"></i>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control" value="<?php echo $row['phone'] ?>" placeholder="chưa có số điện thoại" name="phone" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ nhận hàng</label>
                        <input type="text" class="form-control" value="<?php echo $row['address'] ?>" placeholder="chưa có địa chỉ" name="diachi" id="">
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn w-100  bg-success text-white" name="capnhatthongtin" type="submit">Cập nhật</button>
                    </div>
        </form>
    </div>
    </div>
    </div>
    <script src="js/jQuery.js"></script>
    <script src="js/script.js"></script>
</body>

</html>