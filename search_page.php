<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

// if (!isset($user_id)) {
//     header('location:login.php');
// }

if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `carts` WHERE pid = '$product_id' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Đã thêm vào giỏ hàng';
    } else {
        mysqli_query($conn, "INSERT INTO `carts`(user_id, pid, quantity) VALUES('$user_id', '$product_id',  '$product_quantity')") or die('query failed');
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
    <title>search page</title>
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
        <h3>Trang tìm kiếm</h3>
        <p> <a href="home.php">Trang chủ</a> / Tìm kiếm </p>
    </section>

    <section class="search-form">
        <form action="" method="GET">
            <input type="text" class="box" placeholder="Tìm sản phẩm..." name="search_box">
            <input type="submit" class="btn" value="Tìm" name="search_btn">
        </form>
    </section>

    <section class="products" style="padding-top: 0;">

        <div class="box-container">

            <?php
            if (isset($_GET['search_box'])) {
                $search_box = mysqli_real_escape_string($conn, $_GET['search_box']);
                $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'") or die('query failed');
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
                            <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn">
                        </form>
            <?php
                    }
                } else {
                    echo '<p class="empty">Không tìm thấy kết quả nào!</p>';
                }
            } else {
                echo '<p class="empty">Hãy nhập gì đó!</p>';
            }
            ?>

        </div>

    </section>





    <?php @include 'modules/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>