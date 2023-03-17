<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

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
   <section>
   <h1 class="title">Sản phẩm</h1>
      <div class="container-fluid">
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3 row">
               <h1 class="col m-0 font-weight-bold text-primary">DataTables Product</h1>
               <a href="admin_add_product.php" class="col-lg-1 btn btn-primary ">
                  <i class="fa fa-plus"></i> Thêm sản phẩm</a>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col" class="col-md-1">id sp</th>
                           <th scope="col" class="col-md-1">id chủ đề</th>
                           <th scope="col" class="col-md-1">id loại </th>
                           <th scope="col" class="col-md-2">tên </th>
                           <th scope="col" class="col-md-1">giá</th>
                           <th scope="col" class="col-md-1">giá sale</th>
                           <th scope="col">mô tả</th>
                           <th scope="col" class="col-md-1">ảnh</th>
                           <th scope="col" style="width:100px;">thao tác</th>
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
                                    <span><?php echo $fetch_products['details']; ?></span>
                                 </td>

                                 <td>
                                    <span class="text-center "><img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image" height="100px"></span>
                                 </td>

                                 <td>
                                    <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn btn-lg">cập nhật</a>
                                    <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn btn-lg" onclick="return confirm('delete this product?');">xóa</a>
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