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
    <title>product</title>
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
        <h3>Sản phẩm</h3>
        <p class="mb-0"> <a href="home.php">Trang chủ</a> / Sản phẩm</p>
    </section>
    <section class="products">
        <div class="row pt-0 mt-0 pb-3 text-center">
            <h1 class="title p-0">
                <?php 
                $danhmuc = $_GET['id_topic'] ?? $_GET['id_type'] ?? '';

                if(isset($_GET['id_topic'])){
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id_topic = '$danhmuc' ") or die('query failed');
                    $name_topic =  mysqli_query($conn, "SELECT name_topic FROM `topics` WHERE id_topic = '$danhmuc' LIMIT 1;") or die('query failed');
                    $name_topic = mysqli_fetch_assoc($name_topic);
                    echo $name_topic['name_topic'];
                } else if (isset($_GET['id_type'])){
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id_type = '$danhmuc' ") or die('query failed');
                    $name_type =  mysqli_query($conn, "SELECT name_type FROM `types` WHERE id_type = '$danhmuc' LIMIT 1") or die('query failed');
                    $name_type = mysqli_fetch_assoc($name_type);
                    echo $name_type['name_type'];
                } else {
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` ") or die('query failed');
                    echo "Tất cả sản phẩm";
                }
                ?>
            </h1>
        </div>

        <div class="box-container">

            <?php
           
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="POST" class="box">
                        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>">
                            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                            <div class="name"><?php echo $fetch_products['name']; ?></div>
                            <div class="price"><?php echo $fetch_products['price']; ?> đ</div>
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
    </section>


    <?php @include 'modules/footer.php'; ?>
</body>
<script src="js/jQuery.js"></script>   
<script src="js/script.js"></script>

</html>