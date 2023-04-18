<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $type = mysqli_real_escape_string($conn, $_POST['type']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $giacanh = mysqli_real_escape_string($conn, $_POST['giacanh']);
   $sale_price = mysqli_real_escape_string($conn, $_POST['sale_price']);
   $soluongkho = mysqli_real_escape_string($conn, $_POST['soluongkho']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);

   mysqli_query($conn, "UPDATE `products` SET name = '$name', id_type = '$type', giacanh = '$giacanh', soluongkho = '$soluongkho', details = '$details', price = '$price', sale_price = '$sale_price' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];
   // $image_new = rand(1,10000) .time() .$_FILES['image']['name'] ;
   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'kích thước file ảnh quá lớn!';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter);
         unlink('uploaded_img/'.$old_image);
         $message[] = 'Ảnh đã được cập nhật!';
      }
   }

   $message[] = 'sản phẩm đã được cập nhật!';

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

<section class="update-product">

<?php

   $update_id = $_GET['update'];
   $select_products = mysqli_query($conn, "SELECT * FROM `products` JOIN types ON products.id_type = types.id_type WHERE id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>

<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="image"  alt="">
   <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
   <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
   <select class="box" name="type" required>
            <option value="<?php echo $fetch_products['id_type']; ?>" selected> <?php echo $fetch_products['name_type']; ?></option>
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
   <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="cập nhật tên" name="name">
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="cập nhật giá bó" name="price">
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['giacanh']; ?>"  placeholder="cập nhật giá cành" name="giacanh">
   <input type="number" min="0" max="100" class="box" value="<?php echo $fetch_products['sale_price']; ?>"  placeholder="cập nhật giá sale" name="sale_price">
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['soluongkho']; ?>"  placeholder="cập nhật giá sale" name="soluongkho">
   <textarea name="details" class="box" required placeholder="update product details" cols="30" rows="10"><?php echo $fetch_products['details']; ?></textarea>
   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
   <input type="submit" value="cập nhật" name="update_product" class="btn">
   <a href="admin_products.php" class="option-btn">trở về</a>
</form>

<?php
      }
   }else{
      echo '<p class="empty">không có sản phẩm nào</p>';
   }
?>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>