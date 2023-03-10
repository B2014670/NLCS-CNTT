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
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
    <div class="container row bg-primary mx-auto">
        <section class="checkout col-md-8">

            <form action="" method="POST">

                <h3>Thông tin thanh toán</h3>

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
                        <p>Thông tin tài khoản thụ hưởng của Pet shop. Sau khi chuyển khoản, xin vui lòng thông báo cho chúng tôi qua số điên thoại 0925 086 811 để được phục vụ nhanh nhất.</p>
                        <p>Ngân hàng: <b>Agribank</b></p>
                        <p>Số tài khoản: <b>076582640</b></p>
                        <p>Tên tài khoản: <b>NGUYỄN QUỐC TRUNG</b></p>
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
        <section class="display-order col-md-4">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT id_cart, user_id, pid, name, quantity, price, image  FROM cart JOIN products ON cart.pid= products.id  WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                    $grand_total += $total_price;
            ?>
                    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo  $fetch_cart['price'] . 'đ' . ' x ' . $fetch_cart['quantity']  ?>)</span> </p>
            <?php
                }
            } else {
                echo '<p class="empty">Giỏ của bạn trống!</p>';
            }
            ?>
            <div class="grand-total">Tổng cộng : <span><?php echo number_format($grand_total, 0, ",", ".") . "đ" ?></span></div>
        </section>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Product name</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$12</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Second product</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$8</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Third item</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">-$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$20</strong>
                    </li>
                </ul>

                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation was-validated" novalidate="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" id="username" placeholder="Username" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select class="custom-select d-block w-100" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state">State</label>
                            <select class="custom-select d-block w-100" id="state" required="">
                                <option value="">Choose...</option>
                                <option>California</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" id="zip" placeholder="" required="">
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="same-address">
                        <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="save-info">
                        <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div>
                    <hr class="mb-4">

                    <h4 class="mb-3">Payment</h4>

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                            <label class="custom-control-label" for="credit">Credit card</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                            <label class="custom-control-label" for="debit">Debit card</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Name on card</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback">
                                Name on card is required
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">Credit card number</label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                            <div class="invalid-feedback">
                                Credit card number is required
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">Expiration</label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                            <div class="invalid-feedback">
                                Expiration date required
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                            <div class="invalid-feedback">
                                Security code required
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                </form>
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