<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE pid = '$product_id' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Đã thêm vào giỏ hàng';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid,  quantity) VALUES('$user_id', '$product_id',  '$product_quantity')") or die('query failed');
        $message[] = 'Thêm vào giỏ hàng thành công';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home_page</title>
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

    <section class="p-0">
        <div class="carousel">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="csl carousel-inner">
                    <div class="carousel-item active">
                        <img src="./images/bia2.jpg" height="700px" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/bia1.jpg" height="700px" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/bia3.jpg" height="700px" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section class="products">
        <div class="row pt-0 mt-0 pb-3 text-center">
            <h1 class="title p-0">SẢN PHẨM MỚI NHẤT</h1>
        </div>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="POST" class="box">
                        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>">
                            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                            <div class="name"><?php echo $fetch_products['name']; ?></div>                                                    
                            <div class="price"><?php echo number_format($fetch_products['sale_price'] != 0 ? $fetch_products['sale_price'] : $fetch_products['price'], 0, ",", ".") . "đ" ?></div>
                        </a>
                        <input type="hidden" name="product_quantity" value="1" min="0" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <!-- <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn"> -->
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
            }
            ?>

        </div>

        <div class="more-btn">
            <a href="product.php" class="option-btn">Xem thêm</a>
        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>Nếu có bất kì câu hỏi nào?</h3>
            <p>Xin vui lòng liên hệ với chúng tôi để được giải đáp thắc mắc sớm nhất chỉ với nút ấn ngay bên dưới</p>
            <a href="contact.php" class="btn">liên hệ</a>
        </div>

    </section>


    <?php @include 'modules/footer.php'; ?>
</body>
<script src="js/jQuery.js"></script>
<script src="js/script.js"></script>

</html>