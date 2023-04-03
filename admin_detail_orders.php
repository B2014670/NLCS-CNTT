<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['update_order'])) {
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
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

</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="placed-orders">

      <h1 class="title">placed orders</h1>

      <div class="box-container">

         <?php
         if (isset($_GET['detail_order'])) {
            $id = $_GET['detail_order'];
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` JOIN users ON orders.user_id=users.id WHERE orders.id = '$id'") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
               while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
         ?>
                  <div class="box">
                     <p> mã đơn : <span><?php echo $fetch_orders['id']; ?></span> </p>
                     <p> ngày đặt : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                     <p> tên khách hàng : <span><?php echo $fetch_orders['name']; ?></span> </p>
                     <p> số điện thoại: <span><?php echo $fetch_orders['phone']; ?></span> </p>
                     <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                     <p> đại chỉ : <span><?php echo $fetch_orders['address']; ?></span> </p>
                     <p> các sản phẩm :  
                     <table class="table">
                        <tbody>
                            <?php $select_p_order = mysqli_query($conn, "SELECT image,name,detail_orders.price AS price,quantity,unit  FROM `orders` join detail_orders on orders.id=detail_orders.id_order join products on detail_orders.pid=products.id WHERE id_order='$id'") or die('query failed');
                            if (mysqli_num_rows($select_p_order) > 0) {
                                while ($fetch_p_order = mysqli_fetch_array($select_p_order)) {
                            ?>
                                    <tr>
                                        <td class="mt-3">
                                            <div class="text-center "><img src="uploaded_img/<?php echo $fetch_p_order['image']; ?>" alt="" class="img-fruit" height="80px"> </div>
                                        </td>
                                        <td class="mt-3">
                                            <div class="">
                                                <div class=""><?php echo $fetch_p_order['name']; ?></div>
                                                <div class=""><?php echo number_format($fetch_p_order['price'], 0, ",", ".") . "đ" ?></div>
                                                <div class=""><?php echo "x" . $fetch_p_order['quantity']. ' ' . $fetch_p_order['unit'] ?></div>

                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                     </p>

                     <p> tổng tiền : <span><?php echo $fetch_orders['total_price']; ?>đ</span> </p>
                     <p> phương thức thanh toán : <span><?php echo $fetch_orders['method']; ?></span> </p>
                     <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                        <select name="update_payment">
                           <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                           <option value="pending">đang xử lí</option>
                           <option value="completed">hoàn thành</option>
                        </select>
                        <input type="submit" name="update_order" value="cập nhật" class="option-btn">
                        <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">xóa</a>
                     </form>
                  </div>
         <?php
               }
            } else {
               echo '<p class="empty">no orders placed yet!</p>';
            }
         }
         ?>
      </div>

   </section>













   <script src="js/admin_script.js"></script>

</body>

</html>