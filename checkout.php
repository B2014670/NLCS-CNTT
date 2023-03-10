<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['order'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['specific_address']);
    $name_receive = mysqli_real_escape_string($conn, $_POST['name_receive']);
    $number_receive = mysqli_real_escape_string($conn, $_POST['number_receive']);
    $message_card = mysqli_real_escape_string($conn, $_POST['message_card']);

    $placed_on = date('d-m-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if ($cart_total == 0) {
        $message[] = 'Giỏ của bạn trống!';
    } elseif (mysqli_num_rows($order_query) > 0) {
        $message[] = 'Đơn đặt hàng đã được đặt!';
    } else {
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on,name_receive,number_receive,message_card) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on','$name_receive','$number_receive','$message_card')") or die('query failed');
        // mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'Đặt hàng thành công!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>
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

    <section class="heading text-center justify-content-center">
        <h3>THANH TOÁN ĐẶT HÀNG</h3>
        <p> <a href="home.php">Trang chủ</a> / Thanh toán </p>
    </section>
    <div class="container row  mx-auto">
        <section class="checkout col-md-8">
            <h3>Thông tin thanh toán</h3>
            <form action="" method="POST">

                <div class="flex">
                    <div class="inputBox">
                        <span>Tên người đặt:</span>
                        <input type="text" name="name" placeholder="Họ tên người đặt" required>
                    </div>
                    <div class="inputBox">
                        <span>Số điện thoại :</span>
                        <input type="text" name="number" min="0" placeholder="Số điện thọai" required>
                    </div>
                    <div class="inputBox">
                        <span>email :</span>
                        <input type="email" name="email" placeholder="nhập email của bạn" required>
                    </div>

                    <!-- <div class="inputBox">
            <span>Tỉnh :</span>
            <select id="city" name="city">
                <option value="" selected>Chọn tỉnh thành</option>
            </select>
        </div>
        <div class="inputBox">
            <span>Huyện :</span>
            <select id="district" name="district">
                <option value="" selected>Chọn quận huyện</option>
            </select>
        </div>
        <div class="inputBox">
            <span>Xã :</span>
            <select id="ward" name="ward">
                <option value="" selected>Chọn phường xã</option>
            </select>
        </div> -->
                    <div class="inputBox">
                        <span>Địa chỉ giao hàng :</span>
                        <input type="text" name="specific_address" placeholder="thôn, khóm, số nhà,...">
                    </div>
                    <div class="inputBox">
                        <span>phương thức thanh toán :</span>
                        <select name="method" class="pay">
                            <option value="thanh toán khi giao hàng" default>thanh toán khi giao hàng (COD)</option>
                            <option value="credit card">
                                chuyển khoản
                            </option>
                        </select>
                    </div>
                    <div id="a">
                        <p>Thông tin tài khoản thụ hưởng của Flower shop. Sau khi chuyển khoản, xin vui lòng thông báo cho chúng tôi qua số điên thoại 1234556 để được phục vụ nhanh nhất.</p>
                        <p>Ngân hàng: <b>Agribank</b></p>
                        <p>Số tài khoản: <b>123456789</b></p>
                        <p>Người thụ hưởng: <b>NGUYỄN THÀNH LUÂN</b></p>
                    </div>
                    <div class="form-check my-auto w-100">
                        <input class="form-check-input" type="checkbox" value="" id="present" data-bs-toggle="collapse" data-bs-target=".input_present" aria-expanded="true">
                        <label class="form-check-label" for="present">Gửi tặng người khác?</label>
                    </div>

                    <div class="inputBox input_present collapse ">
                        <span>Tên người nhận:</span>
                        <input class="input_present" type="text" name="name_receive" placeholder="Họ tên người nhận">
                    </div>
                    <div class="inputBox input_present collapse">
                        <span>Số điện thoại người nhận :</span>
                        <input class="input_present" type="text" name="number_receive" min="0" placeholder="Số điện thọai người nhận">
                    </div>


                    <div class="inputBox ">
                        <span>Thông điệp ghi banner / thiệp đính kèm</span>
                        <textarea class="form-control form-control-lg " name="message_card" id="" cols="30" rows="10"></textarea>
                    </div>

                </div>

                <input type="submit" name="order" value="Đặt hàng" class="btn">

            </form>

        </section>
        <section class="display-order col-md-4 ">
            <h3>Đơn hàng</h3>
            <ul col-12>
                <?php
                $grand_total = 0;
                $select_cart = mysqli_query($conn, "SELECT id_cart, user_id, pid, name, quantity, price, image  FROM cart JOIN products ON cart.pid= products.id  WHERE user_id = '$user_id'") or die('query failed');
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                        $grand_total += $total_price;
                ?>
                        <li><?php echo $fetch_cart['name'] ?> <span><?php echo  $fetch_cart['price'] . 'đ' . ' x ' . $fetch_cart['quantity']  ?></span></li>

                <?php
                    }
                } else {
                    echo '<p class="empty">Giỏ của bạn trống!</p>';
                }
                ?>
                <div class="grand-total">Tổng cộng : <span class=""><?php echo number_format($grand_total, 0, ",", ".") . "đ" ?></span></div>

            </ul>

        </section>

    </div>

    </div>
    </div>





    <?php @include 'modules/footer.php'; ?>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");
        var Parameter = {
            url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
            method: "GET",
            responseType: "application/json",
        };
        var promise = axios(Parameter);
        promise.then(function(result) {
            renderCity(result.data);
            console.log(result.data);
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Id);
            }
            citis.onchange = function() {
                district.length = 1;
                ward.length = 1;
                if (this.value != "") {
                    const result = data.filter(n => n.Id === this.value);

                    for (const k of result[0].Districts) {
                        district.options[district.options.length] = new Option(k.Name, k.Id);
                    }
                }
            };
            district.onchange = function() {
                ward.length = 1;
                const dataCity = data.filter((n) => n.Id === citis.value);
                if (this.value != "") {
                    const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

                    for (const w of dataWards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Id);
                    }
                }
            };
        }
    </script> -->
    <script src="js/jQuery.js"></script>
    <script src="js/script.js"></script>
    <script>
        $(function() {
            $('#a').hide();
            $('.pay').on('change', function() {
                if ($('.pay').val() == 'credit card')
                    $('#a').show();
                else
                    $('#a').hide();
            });
        });
    </script>
</body>

</html>