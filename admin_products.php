<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `carts` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}
if(isset($_POST['capnhat-tatca'])){
   $sort=$_POST['key'];
   $soluong=$_POST['soluong'];
   if($sort=='DUOI10'){
       $sql="UPDATE products a SET soluongkho=soluongkho+'$soluong' WHERE a.soluongkho < 10 AND a.soluongkho >=1";
   }
   if($sort=="HET"){
       $sql="UPDATE products a SET soluongkho=soluongkho+'$soluong' WHERE a.soluongkho =0";
   }
   mysqli_query($conn,$sql);
}
if (isset($_POST['orderbysp'])) {
   $sort = $_POST['orderbysp'];
   if ($sort == 'DUOI10') {
      $sql_lietke_sp = 'SELECT * FROM products a  JOIN types c ON a.id_type=c.id_type WHERE  a.soluongkho < 10 AND a.soluongkho >=1 ';
   }
   if ($sort == "HET") {
      $sql_lietke_sp = 'SELECT * FROM products a  JOIN types c ON a.id_type=c.id_type WHERE  a.soluongkho = 0 ';
   }
   if ($sort == "ALL") {
      $sql_lietke_sp = 'SELECT * FROM products a  JOIN types c ON a.id_type=c.id_type ';
   }
} else {
   $sql_lietke_sp = 'SELECT * FROM products a  JOIN types c ON a.id_type=c.id_type ';
}
$select_products = mysqli_query($conn, $sql_lietke_sp);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

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

   <section>
      <h1 class="title">Sản phẩm</h1>
      <div class="container-fluid">
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3 row">
               <h1 class="col m-0 font-weight-bold text-primary">Danh sách sản phẩm</h1>
               <div class="col">
                  <form class="form-inline row" id="formsapxepspkho" method="POST">
                     <h2 class=" col-md-5 col-sm-6">Liệt kê sản phẩm </h2>

                     <select class="p-1 border col" name="orderbysp" id="sapxepspkho">
                        <option <?php if (isset($_POST['orderbysp'])) {
                                    echo $_POST['orderbysp'] == 'ALL' ? 'selected' : '';
                                 } ?> value="ALL">Tất cả</option>
                        <option <?php if (isset($_POST['orderbysp'])) {
                                    echo $_POST['orderbysp'] == 'DUOI10' ? 'selected' : '';
                                 } ?> value="DUOI10">Số lượng dưới 10 (sắp hết)</option>
                        <option <?php if (isset($_POST['orderbysp'])) {
                                    echo $_POST['orderbysp'] == 'HET' ? 'selected' : '';
                                 } ?> value="HET">Hết hàng</option>
                     </select>

                  </form>

                  <!-- form cap nhat so luong -->
                  <form class="form-inline row" method="POST" onsubmit="return confirm('chắc chắn tăng số lượng trong kho?');">
                     <div class="form-group">
                        <input class="form-control  col-md-2 col-md-3" type="number" name="soluong" id="sl-sp-cong-them">
                        <input type="hidden" name="key" value="<?php echo isset($_POST['orderbysp'])?$_POST['orderbysp'] :'ALL' ?>">
                        <button class="btn btn-secondary col p-2 m-2" name="capnhat-tatca">Cộng Thêm Số Lượng Cho Tất Cả</button>
                     </div>
                  </form>
               </div>
               <div class="col-md-4">
                  <a href="admin_add_product.php" class="col-md-4 offset-md-8 col-sm-6 offset-sm-6 btn btn-primary ">
                     <i class="fa fa-plus"></i> Thêm sản phẩm</a>
               </div>

            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th scope="col" class="col-md-1">#</th>
                           <th scope="col" class="col-md-1">loại </th>
                           <th scope="col" class="col-md-1">tên </th>
                           <th scope="col" class="col-md-1">giá bó</th>
                           <th scope="col" class="col-md-1">giá cành</th>
                           <th scope="col" class="col-md-1">giảm %</th>
                           <th scope="col" class="col-md-1">kho</th>
                           <th scope="col">mô tả</th>
                           <th scope="col" class="col-md-1">ảnh</th>
                           <th scope="col" style="width:100px;">Thao tác</th>
                        </tr>
                     </thead>

                     <tbody>
                        <?php
                        // $select_products = mysqli_query($conn, "SELECT * FROM products a  JOIN types c ON a.id_type=c.id_type ") or die('query failed');
                        if (mysqli_num_rows($select_products) > 0) {
                           while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                        ?>
                              <tr>
                                 <td>
                                    <div>
                                       <span><?php echo $fetch_products['id']; ?></span>
                                    </div>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_products['name_type'] ?? '' ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_products['name']; ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_products['price']; ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_products['giacanh'] ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_products['sale_price'] ?></span>
                                 </td>

                                 <td>
                                    <span><?php echo $fetch_products['soluongkho'] ?></span>
                                 </td>

                                 <td>
                                    <p class="describe mx-auto"><?php echo $fetch_products['details']; ?></p>                                     
                                 </td>

                                 <td>
                                    <span class="text-center "><img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image" height="100px"></span>
                                 </td>

                                 <td>
                                    <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn btn-lg">cập nhật</a>
                                    <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn btn-lg" onclick="return confirm('bạn chắc chắn muốn xóa sản phẩm này?');">xóa</a>
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
   <!-- Bootstrap core JavaScript-->
   <script src="vendor/jquery/jquery.min.js"></script>
   <!-- Page level plugins -->
   <script src="vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
   <!-- Page level custom scripts -->
   <script src="js/demo/datatables-demo.js"></script>
   <script>
      const selectElement = document.getElementById('sapxepspkho');
      selectElement.addEventListener('change', (event) => {
         document.getElementById('formsapxepspkho').submit();
      });
   </script>
</body>

</html>