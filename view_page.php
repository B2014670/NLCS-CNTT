<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    // header('location:login.php');
};
if (isset($_POST['add_to_cart'])) {
    if (!isset($user_id)) {
        header('location:login.php');
    };
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];
    $product_unit = $_POST['unit'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `carts` WHERE pid = '$product_id' AND user_id = '$user_id' AND unit = '$product_unit'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Đã thêm vào giỏ hàng';
    } else {
        mysqli_query($conn, "INSERT INTO `carts`(user_id, pid,  quantity, unit) VALUES('$user_id', '$product_id',  '$product_quantity', '$product_unit')") or die('query failed');
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
                    <div class="card col-lg-10 mx-auto">
                        <!-- <div class=" text-center  mx-auto my-5">
                            <h1>Chi tiết sản phẩm</h1>
                        </div> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 my-auto text-center">
                                    <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image" style="width: 100%">
                                </div>
                                <div class="col">
                                    <h2 class="card-title name"><?php echo $fetch_products['name']; ?></h2>
                                    <h2 class="mt">
                                        <?php
                                        if (isset($_POST['unit']) && $_POST['unit'] === 'bó') {
                                            $unit =$_POST['unit'];
                                            if ($fetch_products['sale_price'] != 0) {
                                                echo '<div class="row">
                                                        <p class="price col-md-2 col-sm-3 text-decoration-line-through text-right" >' . number_format($fetch_products['price'], 0, ",", ".") . 'đ</p>
                                                        <p class="price col text-danger text-left text-left">' . number_format((100 - $fetch_products['sale_price']) * $fetch_products['price'] / 100, 0, ",", ".") . 'đ</p>
                                                    </div>';
                                            } else {
                                                echo '<div class="row">
                                                        <p class="price col">' . number_format($fetch_products['price'], 0, ",", ".") . 'đ</p>   
                                                    </div>';
                                            }
                                        }else if(isset($_POST['unit']) && $_POST['unit'] === 'cành'){//canh
                                            $unit =$_POST['unit'];
                                            echo '<div class="row">
                                            <p class="price col">' . number_format($fetch_products['giacanh'], 0, ",", ".") . 'đ</p>   
                                                </div>';
                                        }                                    
                                        ?>
                                        <!-- <h1><?php echo number_format($fetch_products['sale_price'] != 0 ? $fetch_products['sale_price'] : $fetch_products['price'], 0, ",", ".") . "đ" ?></h1> -->
                                    </h2>
                                    <form method="POST" id="choseunit" >
                                            <div class="row">
                                                <div class="col-md-2 col-sm-3">
                                                    Đơn vị:
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="radio1" name="unit" value="bó" <?php if (isset($_POST['unit']) && $_POST['unit'] === 'bó') echo 'checked'; ?>>
                                                        <label class="form-check-label" for="radio1">Bó</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="radio2" name="unit" value="cành" <?php if (isset($_POST['unit']) && $_POST['unit'] === 'cành') echo 'checked'; ?>>
                                                        <label class="form-check-label" for="radio2">Cành</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <form action="" method="POST">
                                        
                                        <input type="hidden" name="unit" value="<?php echo $unit?>">
                                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">

                                        <div class="row ">
                                            <span class="col-md-2 my-auto"> Số lượng: </span><input type="number" name="product_quantity" value="1" min="1" class="form-control col-md-1  text-center py-3 w-25" style="font-size: large;">
                                        </div>
                                        <input type="submit" value="add to cart" name="add_to_cart" class="btn col-lg-3 col-md-4">
                                    </form>
                                    <h2 class="box-title mt-5">Mô tả sản phẩm</h2>
                                    <div class="details"><?php echo $fetch_products['details']; ?></div>

                                    <div class="border mt-3 p-3">
                                        <h4>Lưu ý</h4>
                                        <p class="font-italic">Sản phẩm bạn đang chọn là sản phẩm được thiết kế đặc biệt!</p>
                                        <p class="font-italic">Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <?php
                }
            } else {
                echo '<p class="empty">không có chi tiết sản phẩm có sẵn!</p>';
            }
        }
        ?>
    </section>
    <section>
        <div class="col-md-10 mx-auto accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Đánh giá
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse " aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body mt-3">
                    <?php

                    $sql = "SELECT * FROM comments a JOIN users b ON a.id_user=b.id  WHERE a.pid='$pid'";
                    $binhluan = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($binhluan)) {
                    ?>
                        <div class="card-comment">
                            <div class="d-flex">
                                <div>
                                    <img src="uploaded_img/<?php echo $row['avatar'] ?>" width="40" class="rounded-circle mt-2">
                                </div>
                                <div class="col-10">
                                    <div class="comment-box">
                                        <h6><?php echo $row['name'] ?></h6>
                                        <div class="rating-other-user  d-inline-block w-100">
                                            <?php for ($i = 0; $i < $row['vote']; $i++) { ?>
                                                <i class="fa-solid fa-star" style="color: #ff0000;"></i>
                                            <?php } ?>
                                            <?php for ($i = 0; $i < 5 - $row['vote']; $i++) { ?>
                                                <i class="fa-sharp fa-regular fa-star" style="color: #ff0000;"></i>
                                            <?php } ?>
                                        </div>
                                        <p class="mb-0"><?php echo $row['time'] ?></p>
                                        <p class="mb-0"><?php echo $row['content'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <form action="function_comment.php?pid=<?php echo $pid ?>" method="POST">
                        <div class="card-comment">
                            <div class="d-flex">
                                <?php

                                ?>
                                <!-- nguoi khong dang nhapj dx bl hay khong ? -->
                                <div>
                                    <img src="uploaded_img/<?php
                                                            // neu khong co hinh anh (khong dang nhap thi hien thi hinh anh mac dinh)
                                                            if (isset($user_id)) {
                                                                $sql2 = "SELECT * FROM users where id='$user_id'";
                                                                $sth = mysqli_query($conn, $sql2);
                                                                $row2 = mysqli_fetch_array($sth);
                                                                echo $row2['avatar'];
                                                            } else echo 'avtDefault.png' ?>" width="70" class="rounded-circle mt-2">
                                </div>
                                <div class="col-10">
                                    <div class="comment-box ml-2">
                                        <h4>Thêm bình luận</h4>
                                        <div class="rating">
                                            <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                                            <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                            <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                            <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                            <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                        </div>
                                        <div class="comment-area">
                                            <textarea class="form-control" name="content" placeholder="Bạn cảm thấy sản phẩm này thế nào?" rows="3"></textarea>
                                        </div>
                                        <div class="comment-btns mt-2">

                                            <div class="text-left">
                                                <button class="btn btn-success" name="thembinhluan" type="submit">GỬI</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php @include 'modules/same_product.php'; ?>

    <?php @include 'modules/footer.php'; ?>
    <script src="js/jQuery.js"></script>
    <script src="js/script.js"></script>
    <script>
        $('input[type=radio][name=unit]').change(function() {
            alert('aaaaaaa')
            $("form[id=choseunit]").submit();
        })
    </script>
</body>

</html>