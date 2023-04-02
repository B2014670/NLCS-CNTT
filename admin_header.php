<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Trang <span>Admin</span></a>

      <nav class="navbar">
         <a href="admin_category.php">Quản lý danh mục</a>
         <a href="admin_products.php">Quản lý sản phẩm</a>
         <a href="admin_orders.php">Quản lý đơn hàng</a>
         <a href="admin_users.php">Quản lý người dùng</a>
         <a href="admin_contacts.php">Quản lý góp ý</a>
      </nav>
      
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>Quản trị viên : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Đăng xuất</a>
         <div><a href="login.php">đăng nhập</a> mới | <a href="register.php">đăng kí</a> </div>
      </div>

   </div>

</header>