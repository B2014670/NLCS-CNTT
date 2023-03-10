<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>
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
        <h3>Đơn hàng của bạn</h3>
        <p> <a href="home.php">Trang chủ</a> / Đơn hàng </p>
    </section>

    <section class="placed-orders ">

        <h1 class="title text-center text-uppercase">Đặt hàng</h1>

        <div class="box-container">

            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="box">
                        <p> ngày đặt : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                        <p> tên : <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <p> số điện thoại : <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> đại chỉ : <span><?php echo $fetch_orders['address']; ?></span> </p>                       
                        <p> đơn hàng : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                        <p> tổng giá : <span><?php echo number_format($fetch_orders['total_price'], 0, ",", ".")?>đ</span> </p>
                        <p> phương thức thanh toán : <span><?php echo $fetch_orders['method']; ?></span> </p>
                        <p> trạng thái : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                    echo 'tomato';
                                                                } else {
                                                                    echo 'green';
                                                                } ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có đơn đặt hàng!</p>';
            }
            ?>
        </div>

    </section>

    <?php @include 'modules/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>