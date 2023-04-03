<div class="placed-orders ">
    <h1 class="title text-center text-uppercase">Chờ xác nhận</h1>
    <div class="box-container">

        <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND payment_status = 'đang xử lý'") or die('query failed');
        if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            $id_order = $fetch_orders['id']
        ?>
                <div class="box">
                    <p> #<span><?php echo $fetch_orders['id']; ?></span> </p>
                    <p> ngày đặt : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>                    
                    <p> đơn hàng : </p>
                    <table class="table">
                        <tbody>
                            <?php $select_p_order = mysqli_query($conn, "SELECT image,name,detail_orders.price AS price,quantity,unit  FROM `orders` join detail_orders on orders.id=detail_orders.id_order join products on detail_orders.pid=products.id WHERE user_id = '$user_id' && id_order='$id_order '") or die('query failed');
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

                    <p> tổng giá : <span><?php echo number_format($fetch_orders['total_price'], 0, ",", ".") ?>đ</span> </p>
                    <p> phương thức thanh toán : <span><?php echo $fetch_orders['method']; ?></span> </p>
                    <p> trạng thái : <span style="color:<?php if ($fetch_orders['payment_status'] == 'đang xử lý') {
                                                            echo 'tomato';
                                                        } else {
                                                            echo 'green';
                                                        } ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                </div>

        <?php
            }
        } else {
            echo '<p class="empty">Chưa có đơn đặt hàng!</p>';
        }
        ?>
    </div>
</div>