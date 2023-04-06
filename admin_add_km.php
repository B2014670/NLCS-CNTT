<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['add_km'])) {
   $id = mysqli_real_escape_string($conn, $_POST['id_km']);
   $sale_price = mysqli_real_escape_string($conn, $_POST['sale_price']);

   $insert_product = mysqli_query($conn, "UPDATE `products` SET sale_price = $sale_price WHERE id = $id") or die('query failed');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thêm khuyến mãi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- Custom styles for this template -->
   <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

   <?php @include 'admin_header.php'; ?>  

   <section>
      <div class="container">
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3 row">
               <h1 class="col m-0 font-weight-bold text-primary">Sản phẩm chưa khuyến mãi</h1>
               <div class="col-md-4">
                  <a href="admin_category.php" class="col-md-4 offset-md-8 col-sm-6 offset-sm-6 btn btn-primary ">
                     <i class="fa fa-arrow-left"></i> Quay lại</a>
               </div>

            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">tên </th>
                           <th scope="col">đơn giá bó cũ</th>
                           <th scope="col">giá cành</th>
                           <th scope="col">giảm %</th>
                        </tr>
                     </thead>

                     <tbody class="text-center">
                        <?php
                        $fetch_products = mysqli_query($conn, "SELECT id,name,price,sale_price,giacanh FROM products WHERE sale_price = 0  ") or die('query failed');
                        if (mysqli_num_rows($fetch_products) > 0) {
                           while ($fetch_product = mysqli_fetch_assoc($fetch_products)) {
                        ?>
                              <tr>
                                 <td>
                                    <div>
                                       <span><?php echo $fetch_product['id']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_product['name']; ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_product['price']; ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_product['giacanh'];?></span>
                                 </td>

                                 <td>
                                    <form class="mt-2 p-0" method="POST">
                                       <input type="hidden" value=" <?php echo $fetch_product['id'] ?> " name="id_km">

                                       <input type="number" min="0" max="100" value="<?php echo $fetch_product['sale_price']; ?>" name="sale_price" class="qty text-center border p-2 m-0" style="width:50px">

                                       <input type="submit" value="Cập nhật" class="option-btn btn-lg" name="add_km">
                                    </form>
                                 </td>



                              </tr>
                        <?php
                           }
                        } else {
                           echo '<p class="empty">Không có sản phẩm chưa giảm giá</p>';
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