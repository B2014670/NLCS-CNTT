<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_type'])){

   
   $id = mysqli_real_escape_string($conn, $_POST['id_type']);
   $name = mysqli_real_escape_string($conn, $_POST['name_type']);
   

   mysqli_query($conn, "UPDATE `types` SET name_type = '$name' WHERE id_type = '$id'");   

   $message[] = 'tên loại cập nhật thành công!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update type</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php

   $id_km = $_GET['update_type'];
   $select_kms = mysqli_query($conn, "SELECT * FROM types WHERE id_type = '$id_km'") or die('query failed');
   if(mysqli_num_rows($select_kms) > 0){
      while($fetch_km = mysqli_fetch_assoc($select_kms)){
?>

<form action="" method="post" enctype="multipart/form-data">
  
   <input type="hidden" value="<?php echo $fetch_km['id_type']; ?>" name="id_type">     
   <p class="text-bold float-left ">Cập nhật tên loại</p>
   <input type="text" class="box" value="<?php echo $fetch_km['name_type']; ?>" required placeholder="cập nhật tên loại" name="name_type">
   
   <input type="submit" value="cập nhật" name="update_type" class="btn">
   <a href="admin_category.php" class="btn option-btn">trở về</a>
</form>

<?php
      }
   }else{
      echo '<p class="empty">no update product select</p>';
   }
?>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>