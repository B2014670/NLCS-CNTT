<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    
    // header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

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

    <section class="heading text-center justify-content-center align-items-centers">
        <h3>Giới thiệu</h3>
        <p> <a href="home.php">Trang chủ</a> / Giới thiệu </p>
    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="img/about-img-1.png" alt="">
            </div>

            <div class="content">
                <h3>Tại sao nên chọn shop chúng tôi?</h3>
                <p>Shop hoa tươi chúng tôi là một tên gọi đại diện cho một trong những vườn hoa tươi của thị trường hoa online.
                    Tại đây chúng tôi có thể giúp bạn mang đến cho người thân, bạn bè, cũng như người mà bạn dành những tình cảm thương mến nhưng món quà hết sức đặc biệt và đầy ý nghĩa.</p>
                <a href="product.php" class="btn">Mua ngay</a>
            </div>

        </div>

        <div class="flex">

            <div class="content">
                <h3>Những gì chúng tôi cung cấp?</h3>
                <ul class="text-start">
                    <li>Hoa tươi các loại …</li>
                    <li>Phụ kiện ngành hoa.</li>
                    <li>Điện hoa, hoa cưới, hoa chúc mừng … hoa các ngày lễ.</li>
                    <li>Giao hoa tận nơi tại các quận, huyện và địa bàn thành phố Cần Thơ</li>
                    <li>Đặc biệt vào các ngày lễ giao hoa 24/24</li>
                </ul>
                <a href="contact.php" class="btn">Liên hệ</a>
            </div>

            <div class="image">
                <img src="img/about-img-2.jpg" alt="">
            </div>

        </div>

        <div class="flex">

            <div class="image">
                <img src="img/about-img-3.jpg" alt="">
            </div>

            <div class="content">
                <h3>Cam kết?</h3>
                <p>Hội tụ các loại hoa tươi từ Đà Lạt, cùng những thợ cấm hoa chuyên nghiệp, có kinh nghiệm trên mười năm cấm hoa: Shohoacantho.com khẳng định và đảm bảo tiêu chí hoa tươi – đẹp – chất lượng sẽ luôn mạng đến sự hài long cho khách hàng khi mua hoa tại shop của chúng tôi.</p>
                <p>Hãy đến với Shop Hoa Cần Thơ .com để mang về những món quà đầy ý nghĩa.</p>
                <a href="#reviews" class="btn">Xem đánh giá</a>
            </div>

        </div>

    </section>

    <?php @include 'modules/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>