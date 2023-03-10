<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};
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
// if (isset($_POST['add_to_cart'])) {

//     $product_id = $_POST['product_id'];
// ;
//     $product_quantity = $_POST['product_quantity'];

//     $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

//     if (mysqli_num_rows($check_cart_numbers) > 0) {
//         $message[] = 'Đã thêm vào giỏ hàng';
//     } else {
//         mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
//         $message[] = 'Thêm vào giỏ hàng thành công';
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quick view</title>

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

    <section style="padding-top: 100px;">
        <?php
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>

                    <div class="container">
                        <div class="col-lg-10 text-center border bg-light rounded mx-auto my-5">
                            <h1>Chi tiết sản phẩm</h1>
                        </div>
                        <div class="card col-lg-10 mx-auto">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col my-auto text-center">
                                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                                    </div>
                                    <div class="col">
                                        <h2 class="card-title name"><?php echo $fetch_products['name']; ?></h2>
                                        <h2 class="mt">
                                            <!-- <span class="text-decoration-line-through"><?php echo $fetch_products['price']; ?> </span>  -->
                                            <h1 ><?php echo $fetch_products['price']; ?> đ</h1>
                                        </h2>
                                        <form action="" method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                                           
                                            <div class="row ">
                                               <span class="col-3 my-auto"> Số lượng: </span><input type="number" name="product_quantity" value="1" min="1" class="form-control col-9 text-center py-3 w-25" style="font-size: large;">
                                            </div>
                                            <input type="submit" value="add to cart" name="add_to_cart" class="btn w-50">
                                        </form>
                                        <h2 class="box-title mt-5">Mô tả sản phẩm</h2>
                                        <div class="details"><?php echo $fetch_products['details']; ?></div>
                                        
                                        <div class="border mt-3">
                                            <h4>Lưu ý</h4>
                                            <p class="font-italic">Sản phẩm bạn đang chọn là sản phẩm được thiết kế đặc biệt!</p>
                                            <p class="font-italic">Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-5 mb-5">

                    </div>
        <?php
                }
            } else {
                echo '<p class="empty">không có chi tiết sản phẩm có sẵn!</p>';
            }
        }
        ?>
    </section>

    <?php @include 'modules/same_product.php'; ?>
       



    <?php @include 'modules/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>