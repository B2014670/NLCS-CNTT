<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['update_order'])) { // chưa check spam trùng
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE  id = '$order_id' AND payment_status='$update_payment'") or die('query failed');
   if (mysqli_num_rows($select_pendings) > 0) {
   } else {
      mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
      $message[] = 'trạng thái đơn hàng đã được cập nhật!';
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- Custom styles for this template -->
   <link href="css/sb-admin-2.min.css" rel="stylesheet">
   <!-- Custom styles for this page -->
   <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="placed-orders">
      <h1 class="title">Đơn hàng</h1>
      <div class="container">

         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h1 class="m-0 font-weight-bold text-primary">DataTables Order</h1>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col">mã đơn</th>
                           <th scope="col">tên khách hàng</th>
                           <th scope="col">địa chỉ </th>
                           <th scope="col">số điện thoại</th>
                           <th scope="col">thời gian đặt hàng</th>
                           <th scope="col">trạng thái</th>
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
                        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                        if (mysqli_num_rows($select_orders) > 0) {
                           while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                        ?>
                              <tr>
                                 <td>
                                    <div>
                                       <span>#<?php echo $fetch_orders['id']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <div>
                                       <span><?php echo $fetch_orders['name']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_orders['address']; ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_orders['number']; ?></span>
                                 </td>
                                 <td>
                                    <span><?php echo $fetch_orders['placed_on']; ?></span>
                                 </td>
                                 <td>
                                    <form action="" method="post">
                                       <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                                       <select name="update_payment" required>
                                          <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                                          <option value="đang xử lý">đang xử lý</option>
                                          <option value="hoàn thành">hoàn thành</option>
                                       </select>
                                       <input type="submit" name="update_order" value="cập nhật" class="option-btn btn-lg mt-0">
                                    </form>
                                 </td>

                                 <td>
                                 <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn btn-lg mt-0" onclick="return confirm('delete this order?');">xóa</a>
                                 <a href="admin_detail_orders.php?detail_order=<?php echo $fetch_orders['id']; ?>" class="option-btn bg-primary btn-lg mt-0">Xem chi tiết</a>
                                 </td>

                              </tr>
                        <?php
                           }
                        } else {
                           echo '<p class="empty">bạn không có tin nhắn!</p>';
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