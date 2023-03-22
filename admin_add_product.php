<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['add_product'])) {
   $topic = mysqli_real_escape_string($conn, $_POST['topic']);
   $type = mysqli_real_escape_string($conn, $_POST['type']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $sale_price = mysqli_real_escape_string($conn, $_POST['sale_price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'tên sản phẩm đã tồn tại!';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `products`(id_topic, id_type, name, details, price, sale_price, image) VALUES('$topic','$type','$name', '$details', '$price', '$sale_price', '$image')") or die('query failed');

      if ($insert_product) {
         if ($image_size > 2000000) {
            $message[] = 'kích thước ảnh quá lớn!';
         } else {
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'sản phẩm thêm thành công!';
            // header('location:admin_products.php');
         }
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="add-products">

      <form action="" method="POST" enctype="multipart/form-data">
         <h3>thêm sản phẩm mới</h3>

         <select class="box" name="topic" required >
            <option value="" selected> Chọn chủ đề </option>

            <?php
            $select_topics = mysqli_query($conn, "SELECT * FROM topics ") or die('query failed');
            if (mysqli_num_rows($select_topics) > 0) {
               while ($fetch_topics = mysqli_fetch_assoc($select_topics)) {
            ?>
                  <option value=" <?php echo $fetch_topics['id_topic']; ?> "> <?php echo $fetch_topics['name_topic']; ?> </option>
            <?php
               }
            }
            ?>
         </select>

         <select class="box" name="type" required>
            <option value="" selected> Chọn loại</option>
            <?php
            $select_type = mysqli_query($conn, "SELECT * FROM types ") or die('query failed');
            if (mysqli_num_rows($select_type) > 0) {
               while ($fecth_types = mysqli_fetch_assoc($select_type)) {
            ?>
                  <option value=" <?php echo $fecth_types['id_type']; ?> "> <?php echo $fecth_types['name_type']; ?> </option>
            <?php
               }
            }
            ?>
         </select>


         <input type="text" class="box" required placeholder="nhập tên sản phẩm" name="name">
         <input type="number" min="0" class="box" required placeholder="nhập giá sản phẩm" name="price">
         <input type="number" min="0" class="box" placeholder="nhập giá sale" name="sale_price">
         <textarea name="details" class="box" required placeholder="nhập mô tả sản phẩm" cols="30" rows="10"></textarea>
         <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
         <input type="submit" value="thêm sản phẩm" name="add_product" class="option-btn">
      </form>

   </section>

   <script src="js/admin_script.js"></script>

</body>

</html>