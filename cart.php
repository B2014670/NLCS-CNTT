<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
};

if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $select_item_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE id_cart = '$cart_id' AND quantity <> '$cart_quantity' ") or die('query failed');
    if (mysqli_num_rows($select_item_cart) > 0) {
        mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id_cart = '$cart_id'") or die('query failed');
        $message[] = 'số lượng giỏ hàng được cập nhật!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="js/jQuery.js"></script>

</head>

<body>

    <?php @include 'modules/header.php'; ?>

    <section class="heading text-center justify-content-center align-items-center">
        <h3>Giỏ hàng</h3>
        <p> <a href="home.php">Trang chủ</a> / Giỏ hàng </p>
    </section>

    <section class="shopping-cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center border bg-light rounded my-5">
                    <h1>Sản phẩm đã thêm</h1>
                </div>


                <div class="col-lg-12 col-md-12 mx-auto">
                    <table class="table table-bordered">
                        <thead class="text-center bg-light">
                            <tr>
                                <th scope="col" colspan="2">Sản phẩm</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Số tiền</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $grand_total = 0;
                            $select_cart = mysqli_query($conn, "SELECT id_cart, user_id, pid, name, quantity, price, sale_price, image  FROM cart JOIN products ON cart.pid= products.id  WHERE user_id = '$user_id'") or die('query failed');
                            if (mysqli_num_rows($select_cart) > 0) {
                                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            ?>
                                    <tr>
                                        <td>
                                            <div class="text-center "><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image" height="80px"> </div>
                                        </td>
                                        <td>
                                            <div class="mt-5">
                                                <a class=" text-center  text-dark" href="view_page.php?pid=<?php echo $fetch_cart['pid']; ?>"><?php echo $fetch_cart['name']; ?></a>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="mt-5"><?php echo number_format($fetch_cart['sale_price'] != 0 ? $fetch_cart['sale_price'] : $fetch_cart['price'], 0, ",", ".") . "đ" ?></div>
                                        </td>
                                        <td class="">
                                            <form class="mt-2 p-0" method="POST">
                                                <input type="hidden" value="<?php echo $fetch_cart['id_cart']; ?>" name="cart_id">

                                                <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty text-center border p-2 m-0" style="width:50px">

                                                <input type="submit" value="Cập nhật" class="option-btn p-2" name="update_quantity">
                                            </form>
                                        </td>
                                        <td class="">
                                            <div class="mt-5">
                                                <?php
                                                $price = $fetch_cart['sale_price'] != 0 ? $fetch_cart['sale_price'] : $fetch_cart['price'];
                                                $sub_total = ($price  * $fetch_cart['quantity']);
                                                echo number_format($sub_total, 0, ",", ".") . "đ";
                                                ?>
                                            </div>
                                        </td>
                                        <td>

                                            <a href="cart.php?delete=<?php echo $fetch_cart['pid']; ?>" class="fas fa-trash text-light bg-danger p-3 mt-4 rounded" onclick="return confirm('delete this from cart?');"></a>
                                        </td>

                                    </tr>
                            <?php
                                    $grand_total += $sub_total;
                                }
                            } else {
                                echo '<p class="empty">Giỏ hàng của bạn rỗng</p>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6 offset-6">
                    <div>
                        <h3 class="text-end">Tổng thanh toán: <span><?php echo number_format($grand_total, 0, ",", ".") . "đ" ?></span></h3>
                        <div class="row">
                            <a href="product.php" class="col btn option-btn px-2">Tiếp tục mua hàng</a>
                            <a href="checkout.php" class="col btn px-2 <?php echo ($grand_total > 1) ? '' : 'disabled' ?>">Thanh toán</a>
                        </div>
                    </div>
                </div>


            </div>


            <div class="more-btn">

                <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>" onclick="return confirm('delete all from cart?');">Xóa tất cả</a>
            </div>

    </section>





    <?php @include 'modules/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>