<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

// if (!isset($user_id)) {
//     header('location:login.php');
// }


if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart';
    } else {

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart';
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
    <link rel="stylesheet" href="css/style1.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</head>

<body>
    <?php @include 'header.php'; ?>

    <section class="p-0" style="margin-top: 60px;">
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
        <div class="container-lg" style="width: 75%;">
            <div class="row pt-0 mt-0 pb-3 text-center">
                <h1 class="title p-0">SẢN PHẨM MỚI NHẤT</h1>
            </div>
            <div class="row gy-3 my-3 ">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card">
                                <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye text-center justify-content-center"></a>
                                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top px-3 py-3" alt="#" style="height: 30rem;width: 100%;object-fit: cover;">
                                <div class="card-body text-center">
                                    <h4 class="card-title"><?php echo $fetch_products['name']; ?></h4>
                                    <p class="card-text"><?php echo $fetch_products['price']; ?>VNĐ</p>
                                    <form action="" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                        <!-- <input type="number" name="product_quantity" value="1" min="0" class="form-control w-100 mx-auto py-3 font-weight-bold border-dark border-1" style="font-size:large"> -->
                                        <!-- <button class="submit btn w-100 px-0" name="add_to_cart">
                                            <p class="p-0 m-0">Thêm vào giỏ</p>
                                        </button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">no products added yet!</p>';
                }
                ?>
            </div>
        </div>

        <div class="more-btn">
            <a href="product.php" class="option-btn">Xem thêm</a>
        </div>

    </section>
    
    <div class="accordion" id="accordionPayment">
                    <div>
                        <div class="form-group" id="headingOne">
                        <input class="form-check-input" type="checkbox" id="checkboxOne" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapseOne">
                        <label class="form-check-label" for="checkboxOne">Hình thức thanh toán</label>
                        </div>

                        <div id="collapsetwo" class="collapse p-3 bg-light" aria-labelledby="headingOne" data-parent="#accordionPayment">
                        <div>
                            <div class="form-group" id="headingTwo">
                            <input class="form-check-input" value="khi nhận hàng" type="radio" name="paymentMethod" id="checkboxTwo">
                            <label class="form-check-label" for="checkboxTwo">Thanh toán khi nhận hàng</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-group" id="headingThree">
                            <input class="form-check-input" value="trực tuyến" type="radio" name="paymentMethod" id="checkboxThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"> 
                            <label class="form-check-label" for="checkboxThree">Thanh toán online</label>
                            </div>
                            <div id="collapseThree" class="collapse p-3 bg-light">
                            <p>Thông tin tài khoản thụ hưởng của Pet shop. Sau khi chuyển khoản, xin vui lòng thông báo cho chúng tôi qua số điên thoại 0925 086 811 để được phục vụ nhanh nhất.</p>
                            <p>Ngân hàng: <b>Agribank</b></p>
                            <p>Số tài khoản: <b>076582640</b></p>
                            <p>Tên tài khoản: <b>NGUYỄN QUỐC TRUNG</b></p>
                            <div class="text-center">
                            <img  src="img/thanhtoan/qr.jpg" alt="">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
    <section class="home-contact">

        <div class="content">
            <h3>Nếu có bất kì câu hỏi nào?</h3>
            <p>Xin vui lòng liên hệ với chúng tôi để được giải đáp thắc mắc sớm nhất chỉ với nút ấn ngay bên dưới</p>
            <a href="contact.php" class="btn">liên hệ</a>
        </div>

    </section>

    <section>
        <select name="calc_shipping_provinces" required="">
        <option value="">Tỉnh / Thành phố</option>
        </select>
        <select name="calc_shipping_district" required="">
        <option value="">Quận / Huyện</option>
        </select>
        <input class="billing_address_1" name="" type="hidden" value="">
        <input class="billing_address_2" name="" type="hidden" value="">
    </section>

    <?php @include 'footer.php'; ?>
</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'/>
<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'/>
<script>//<![CDATA[
if (address_2 = localStorage.getItem('address_2_saved')) {
  $('select[name="calc_shipping_district"] option').each(function() {
    if ($(this).text() == address_2) {
      $(this).attr('selected', '')
    }
  })
  $('input.billing_address_2').attr('value', address_2)
}
if (district = localStorage.getItem('district')) {
  $('select[name="calc_shipping_district"]').html(district)
  $('select[name="calc_shipping_district"]').on('change', function() {
    var target = $(this).children('option:selected')
    target.attr('selected', '')
    $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
    address_2 = target.text()
    $('input.billing_address_2').attr('value', address_2)
    district = $('select[name="calc_shipping_district"]').html()
    localStorage.setItem('district', district)
    localStorage.setItem('address_2_saved', address_2)
  })
}
$('select[name="calc_shipping_provinces"]').each(function() {
  var $this = $(this),
    stc = ''
  c.forEach(function(i, e) {
    e += +1
    stc += '<option value=' + e + '>' + i + '</option>'
    $this.html('<option value="">Tỉnh / Thành phố</option>' + stc)
    if (address_1 = localStorage.getItem('address_1_saved')) {
      $('select[name="calc_shipping_provinces"] option').each(function() {
        if ($(this).text() == address_1) {
          $(this).attr('selected', '')
        }
      })
      $('input.billing_address_1').attr('value', address_1)
    }
    $this.on('change', function(i) {
      i = $this.children('option:selected').index() - 1
      var str = '',
        r = $this.val()
      if (r != '') {
        arr[i].forEach(function(el) {
          str += '<option value="' + el + '">' + el + '</option>'
          $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>' + str)
        })
        var address_1 = $this.children('option:selected').text()
        var district = $('select[name="calc_shipping_district"]').html()
        localStorage.setItem('address_1_saved', address_1)
        localStorage.setItem('district', district)
        $('select[name="calc_shipping_district"]').on('change', function() {
          var target = $(this).children('option:selected')
          target.attr('selected', '')
          $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
          var address_2 = target.text()
          $('input.billing_address_2').attr('value', address_2)
          district = $('select[name="calc_shipping_district"]').html()
          localStorage.setItem('district', district)
          localStorage.setItem('address_2_saved', address_2)
        })
      } else {
        $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>')
        district = $('select[name="calc_shipping_district"]').html()
        localStorage.setItem('district', district)
        localStorage.removeItem('address_1_saved', address_1)
      }
    })
  })
})
//]]></script>
<script src="js/jQuery.js"></script>
<script src="js/script.js"></script>

</html>