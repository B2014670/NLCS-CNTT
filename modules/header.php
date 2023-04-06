<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>
<header class="header d-flex position-relative">
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow shadow-md py-4">
        <div class="container">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex justify-content-center align-items-center " href="home.php">
                <!-- <img src="images/shop log.png"  alt="site icon"> -->
                <span class=" fw-lighter ms-2 py-3">FlowerShop</span>
            </a>

            <div class="collapse navbar-collapse justify-content-center " id="navMenu">
                <ul class="navbar-nav">
                    <li class="nav-item px-2  ">
                        <a class="nav-link text-uppercase active " href="home.php">Trang chủ</a>
                    </li>                  

                    <li class="nav-item px-2  dropdown">
                        <a class="nav-link text-uppercase active dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Loại hoa</a>
                        <ul class="dropdown-menu " aria-labelledby="dropdown03">
                            <?php
                            $select_types = mysqli_query($conn, "SELECT * FROM `types`") or die('query failed');
                            if (mysqli_num_rows($select_types) > 0) {
                                while ($fetch_types = mysqli_fetch_assoc($select_types)) {
                            ?>
                                    <li  style="width:300px"  class="p-2 m-2 border-bottom"><a class="dropdown-item" href="product.php?id_type=<?php echo $fetch_types['id_type']; ?>"><?php echo $fetch_types['name_type']; ?></a></li>
                            <?php
                                }
                            } else {
                                echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
                            }
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item px-2 ">
                        <a class="nav-link text-uppercase active " href="about.php">Giới thiệu</a>
                    </li>

                    <li class="nav-item px-2 ">
                        <a class="nav-link text-uppercase active" href="contact.php">Liên hệ</a>
                    </li>

                    <!-- <li class="nav-item px-2  dropdown">
                        <a class="nav-link text-uppercase active dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Thêm</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="register.php">Đăng ký</a></li>
                            <li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="orders.php">Đơn hàng</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div>

            <div class="nav-btn">
                <a href="search_page.php"><i class=" fas fa-search px-1"></i></a>
                <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
                ?>

                <a href="cart.php"><i class="fas fa-shopping-cart px-1"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>

                <i id="user-btn" class=" fas fa-user px-1"></i>

            </div>
            <div class="account-box ">
                <?php
                    if(isset($_SESSION['user_name'])){
                        echo '<a href="profile.php?query=taikhoan">Tài khoản cá nhân</a> <p>username : <span>' 
                        .$_SESSION['user_name'] .'</span></p> <p>email : <span>' 
                        .$_SESSION['user_email'] .'</span></p> <a href="logout.php" class="delete-btn">đăng xuất</a>';
                    }else{
                        echo '<p>người dùng : <span> Khách </span></p>';
                        echo '<a href="login.php" class="delete-btn">đăng nhập</a>';
                    }
                ?>
            </div>
        </div>
    </nav>
    <!-- end of navbar -->
</header>