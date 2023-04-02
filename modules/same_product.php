<section class="products">
    <div class="row pt-0 mt-0 pb-3 text-center">
        <h1 class="title p-0">CÓ THỂ BẠN CŨNG THÍCH</h1>
    </div>

    <div class="box-container">

        <?php
        $select_foreign_key = mysqli_query($conn, "SELECT id_type FROM `products` WHERE id = '$pid'") or die('query fail');
        $select_foreign_key  = mysqli_fetch_array($select_foreign_key);
        $select_type = $select_foreign_key['id_type'];
        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE  id <> '$pid' and id_type='$select_type'") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                <form action="" method="POST" class="box">
                    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <?php
                        if ($fetch_products['sale_price'] != 0) {
                            echo '<div class="row">
                                        <p class="price col  text-decoration-line-through text-right" >' . number_format($fetch_products['price'], 0, ",", ".") . 'đ</p>
                                        <p class="price col text-danger text-left text-left">' . number_format((100 - $fetch_products['sale_price']) * $fetch_products['price'] / 100, 0, ",", ".") . 'đ</p>
                                    </div>';
                        } else {
                            echo '<div class="row">
                                        <div class="price col">' . number_format($fetch_products['price'], 0, ",", ".") . 'đ</div>
                                        
                                    </div>';
                        }
                        ?>
                    </a>
                    <input type="hidden" name="product_quantity" value="1" min="0" class="qty">
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                    <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn">
                </form>
        <?php
            }
        } else {
            echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
        }
        ?>

    </div>

    <div class="more-btn">
        <a href="product.php" class="option-btn">Xem thêm</a>
    </div>

</section>