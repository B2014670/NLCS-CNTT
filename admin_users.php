<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quản lý người dùng</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- bootstrap cdn link -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- Custom styles for this template -->
   <link href="css/sb-admin-2.min.css" rel="stylesheet">
   <!-- Custom styles for this page -->
   <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="users">
      <h1 class="title">TÀI KHOẢN NGƯỜI DÙNG</h1>
      <div class="container">

         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h1 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h1>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col">id người dùng</th>
                           <th scope="col">tên tài khoản</th>
                           <th scope="col">email </th>
                           <th scope="col">số điện thoại </th>
                           <th scope="col">loại người dùng</th>
                           <th scope="col">Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                        if (mysqli_num_rows($select_users) > 0) {
                           while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                        ?>
                              <tr>
                                 <td>
                                    <div>
                                       <span><?php echo $fetch_users['id']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <div>
                                       <span><?php echo $fetch_users['name']; ?></span>
                                    </div>
                                 </td>                                 

                                 <td>
                                    <span><?php echo $fetch_users['email']; ?></span>
                                 </td>
                                 
                                 <td>
                                    <span><?php echo $fetch_users['phone']; ?></span>
                                 </td>

                                 <td>
                                    <span style="color:<?php if ($fetch_users['user_type'] == 'admin') {
                                                            echo 'var(--orange)';
                                                         }; ?>"><?php echo $fetch_users['user_type']; ?></span>
                                 </td>
                                 
                                 <td>                                    
                                    <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>"  onclick="return confirm('bạn chắc chắn muốn xóa tài khoản này?');" class="delete-btn btn-lg mt-0 <?php if ($fetch_users['user_type'] == 'admin') { echo 'disabled';  }; ?>"> Xóa</a>
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
   <script src="vendor/jquery/jquery.min.js"></script>
   <!-- Page level plugins -->
   <script src="vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
   <!-- Page level custom scripts -->
   <script src="js/demo/datatables-demo.js"></script>
</body>

</html>