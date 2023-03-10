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


                    <?php
                        $select_danhmuc = mysqli_query($conn, "SELECT * FROM danhmuc") or die('query failed');
                            if (mysqli_num_rows($select_danhmuc) > 0) {
                                while ($fetch_danhmuc = mysqli_fetch_assoc($select_danhmuc)) {
                    ?>
                        <li class="nav-item px-2  dropdown">
                            <a class="nav-link text-uppercase active dropdown-toggle" href="product.php" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $fetch_danhmuc['name_danhmuc']; ?></a>
                            <ul class="dropdown-menu p-1" aria-labelledby="dropdown03">
    
                                <?php                                
                                    $id_danhmuc=$fetch_danhmuc['id_danhmuc'];
                                                        
                                    $select_topics = mysqli_query($conn, "SELECT * FROM topics WHERE id_danhmuc='$id_danhmuc'") or die('query failed');
                                    if (mysqli_num_rows($select_topics) > 0) {
                                        while ($fetch_topics = mysqli_fetch_assoc($select_topics)) {
                                ?>
                                    <!-- <div class="dropdown-divider"></div> -->
                                    <li class="m-3" style="width:200px"><a class="dropdown-item" href="product.php?id_topic=<?php echo $fetch_topics['id_topic']; ?>"><?php echo $fetch_topics['name_topic']; ?></a></li>
                                <?php
                                        }
                                    } 
                                ?>
                                <?php                                                                       

                                    $select_types = mysqli_query($conn, "SELECT * FROM types WHERE id_danhmuc='$id_danhmuc'");
                                    if (mysqli_num_rows($select_types) > 0) {
                                            while ($fetch_types = mysqli_fetch_assoc($select_types)) {
                                    ?>
                                    <!-- <div class="dropdown-divider"></div> -->
                                    <li class="m-3" style="width:200px"><a class="dropdown-item" href="product.php?id_type=<?php echo $fetch_types['id_type']; ?>"><?php echo $fetch_types['name_type']; ?></a></li>
                                <?php
                                        }
                                    } 
                                ?>
                            </ul>
                        </li>

                    <?php
                            }
                                } 
                    ?>
                    <!-- <li class="nav-item px-2  dropdown">
                        <a class="nav-link text-uppercase active dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Loại hoa</a>
                        <ul class="dropdown-menu " aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="product.php">Tất cả sản phẩm</a></li>
                            <?php
                                $select_types = mysqli_query($conn, "SELECT * FROM `types`") or die('query failed');
                                if (mysqli_num_rows($select_types) > 0) {
                                    while ($fetch_types = mysqli_fetch_assoc($select_types)) {
                            ?>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" href="product.php?id_type=<?php echo $fetch_types['name_type']; ?>"><?php echo $fetch_types['name_type']; ?></a></li>
                            <?php
                                    }
                                } else {
                                    echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
                                }
                            ?>
                        </ul>
                    </li> -->

                    <li class="nav-item px-2 ">
                        <a class="nav-link text-uppercase active " href="about.php">Giới thiệu</a>
                    </li>

                    <li class="nav-item px-2 ">
                        <a class="nav-link text-uppercase active" href="contact.php">Liên hệ</a>
                    </li>

                    <li class="nav-item px-2  dropdown">
                        <a class="nav-link text-uppercase active dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Thêm</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="register.php">Đăng ký</a></li>
                            <!-- <li><a class="dropdown-item" href="login.php">Đăng nhập</a></li> -->
                            <li><a class="dropdown-item" href="orders.php">Đơn hàng</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="nav-btn">
                <a href="search_page.php"><i class=" fas fa-search px-1"></i></a>

                <!-- <?php
                        $select_wishlist_count = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                        $wishlist_num_rows = mysqli_num_rows($select_wishlist_count);
                        ?>
                    <a href="wishlist.php"><i class=" fas fa-heart px-1"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a> -->

                <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
                ?>

                <a href="cart.php"><i class="fas fa-shopping-cart px-1"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>

                <i id="user-btn" class=" fas fa-user px-1"></i>

            </div>
            <div class="account-box ">
                <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">đăng xuất</a>
            </div>
        </div>
    </nav>
    <!-- end of navbar -->
</header>