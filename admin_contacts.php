<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}
if (isset($_GET['delete_comment'])) {
   $delete_id = $_GET['delete_comment'];
   mysqli_query($conn, "DELETE FROM `comments` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quản lý bình luận</title>

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
   <section class="">
      <h1 class="title">Bình luận, đánh giá</h1>
      <div class="container">
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h1 class="m-0 font-weight-bold text-primary">Danh sách bình luận đánh giá</h1>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">tên khách hàng</th>
                           <th scope="col">sản phẩm </th>
                           <th scope="col">nội dung bình luận</th>
                           <th scope="col">số sao</th>
                           <th scope="col">thời gian</th>
                           <th scope="col">Thao tác</th>
                        </tr>
                     </thead>
                     
                     <tbody>
                        <?php
                        $select_comment = mysqli_query($conn, "SELECT a.id, b.name, c.name AS namep, a.content, a.vote, a.time  FROM comments a JOIN users b ON a.id_user=b.id JOIN products c ON a.pid=c.id") or die('query failed');
                        if (mysqli_num_rows($select_comment) > 0) {
                           while ($fetch_comment = mysqli_fetch_assoc($select_comment)) {
                        ?>
                              <tr>
                                 <td>
                                    <div>
                                       <span><?php echo $fetch_comment['id']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <div>
                                       <span><?php echo $fetch_comment['name']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_comment['namep']; ?></span>
                                 </td>

                                 <td>
                                    <div>
                                       <span><?php echo $fetch_comment['content']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_comment['vote']; ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_comment['time']; ?></span>
                                 </td>

                                 <td>
                                    <a href="admin_contacts.php?delete_comment=<?php echo $fetch_comment['id']; ?>" onclick="return confirm('bạn chắc chắn muốn xóa bình luận này?');" class="delete-btn btn-lg mt-0">xóa</a>
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

   <!-- <section class="messages">
      <h1 class="title">Góp ý</h1>
      <div class="container">

         
         <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h1 class="m-0 font-weight-bold text-primary">DataTables Message</h1>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">tên tài khoản</th>
                           <th scope="col">email </th>
                           <th scope="col">số điện thoại</th>
                           <th scope="col">tin nhắn</th>
                           <th scope="col">Thao tác</th>
                        </tr>
                     </thead>
                    
                     <tbody>
                        <?php
                        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                        if (mysqli_num_rows($select_message) > 0) {
                           while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                        ?>
                              <tr>
                                 <td>
                                    <div>
                                       <span><?php echo $fetch_message['id']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <div>
                                       <span><?php echo $fetch_message['name']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_message['email']; ?></span>
                                 </td>

                                 <td>
                                    <div>
                                       <span><?php echo $fetch_message['number']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_message['message']; ?></span>
                                 </td>

                                 <td>
                                    <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn btn-lg mt-0">xóa</a>
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
   </section> -->

   
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