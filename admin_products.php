<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['add_product'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'tên sản phẩm đã tồn tại!';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, details, price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');

      if ($insert_product) {
         if ($image_size > 2000000) {
            $message[] = 'kích thước ảnh quá lớn!';
         } else {
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'sản phẩm thêm thành công!';
         }
      }
   }
}

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- bootstrap cdn link -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <!-- Custom styles for this template -->
   <link href="css/sb-admin-2.min.css" rel="stylesheet">
   <!-- Custom styles for this page -->
   <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="add-products">

      <form action="" method="POST" enctype="multipart/form-data">
         <h3>thêm sản phẩm mới</h3>
         <input type="text" class="box" required placeholder="nhập tên chủ đề" name="type">
         <input type="text" class="box" required placeholder="nhập tên loại" name="topic">
         <input type="text" class="box" required placeholder="nhập tên sản phẩm" name="name">
         <input type="number" min="0" class="box" required placeholder="nhập giá sản phẩm" name="price">
         <textarea name="details" class="box" required placeholder="nhập mô tả sản phẩm" cols="30" rows="10"></textarea>
         <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
         <input type="submit" value="thêm sản phẩm" name="add_product" class="btn">
      </form>

   </section>

      
      <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Tables</h1>

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                  <tr>
                     <th scope="col">id sp</th>
                     <th scope="col">id chủ đề</th>
                     <th scope="col">id loại </th>
                     <th scope="col" style="width:200px;">tên </th>
                     <th scope="col">giá</th>
                     <th scope="col">giá hiện tại</th>
                     <th scope="col"style="width:200px;">mô tả</th>
                     <th scope="col">ảnh</th>
                     <th scope="col">thao tác</th>
                  </tr>
                  </thead>
                  <!-- <tfoot>
                     <tr>
                        <th scope="col">id người dùng</th>
                        <th scope="col">tên tài khoản</th>
                        <th scope="col">email </th>
                        <th scope="col">tin nhắn</th>
                        <th scope="col">Thao tác</th>
                     </tr>
                  </tfoot> -->
                  <tbody>
                  <?php
                  $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                  if (mysqli_num_rows($select_products) > 0) {
                     while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                  ?>
                        <tr>
                           <td>
                              <div>
                                 <span><?php echo $fetch_products['id']; ?></span>
                              </div>
                           </td>

                           <td>
                              <div>
                                 <span><?php echo $fetch_products['id_topic']; ?></span>
                              </div>
                           </td>

                           <td>
                              <span><?php echo $fetch_products['id_type']; ?></span>
                           </td>

                           <td>
                              <span><?php echo $fetch_products['name']; ?></span>
                           </td>

                           <td>
                              <span><?php echo $fetch_products['price']; ?></span>
                           </td>

                           <td>
                              <span><?php echo $fetch_products['price']; ?></span>
                           </td>

                           <td>
                              <span ><?php echo $fetch_products['details']; ?></span>
                           </td>

                           <td>
                              <span class="text-center "><img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>"  alt="" class="image" height="80px"></span>
                           </td>

                           <td>
                              <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">cập nhật</a>
                              <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">xóa</a>
                           </td>
                        </tr>
                  <?php
                     }
                  }
                  ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>

   </div>

   </section>
   <script src="js/admin_script.js"></script>
                     <!-- Bootstrap core JavaScript-->
   <script src="vendor/jquery/jquery.min.js"></script>
   <!-- Page level plugins -->
   <script src="vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
   <!-- Page level custom scripts -->
   <script src="js/demo/datatables-demo.js"></script>
   
</body>

</html>