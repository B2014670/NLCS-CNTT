<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_GET['delete_type'])) {
    $type_id = $_GET['delete_type'];
    mysqli_query($conn, "DELETE FROM `types` WHERE id_type = '$type_id'") or die('query failed');
    header('location:admin_category.php');
}
if (isset($_POST['add_type'])) {
    $type_name = $_POST['name_type'];
    $select_types = mysqli_query($conn, "SELECT * FROM `types` WHERE name_type ='$type_name'") or die('query failed');
    if (mysqli_num_rows($select_types) > 0){
        $message[] = 'loại đã tồn tại!';
    }else{
        mysqli_query($conn, "INSERT INTO `types` (name_type) VALUES ('$type_name') ") or die('query failed');
        $message[] = 'loại mới đã được thêm!';

    }
}

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
        <h1 class="title">Danh mục</h1>
        <div class="container">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 row">
                    <h1 class="col m-0 font-weight-bold text-primary">Loại</h1>
                    <form class="form-inline" method="POST">
                        <div class="form-group p-3">
                            <input type="text" class="form-control" name="name_type" placeholder="tên loại">
                        </div>
                        <input type="submit" name="add_type" class="btn btn-primary mt-0 " value="Thêm loại"></input>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">mã loại</th>
                                    <th scope="col">tên loại</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $select_types = mysqli_query($conn, "SELECT * FROM `types`") or die('query failed');
                                if (mysqli_num_rows($select_types) > 0) {
                                    while ($fetch_types = mysqli_fetch_assoc($select_types)) {
                                ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <span><?php echo $fetch_types['id_type']; ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    <span><?php echo $fetch_types['name_type']; ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <a href="admin_update_category.php?update_type=<?php echo $fetch_types['id_type']; ?>" class="option-btn btn-lg">cập nhật</a>
                                                <a href="admin_category.php?delete_type=<?php echo $fetch_types['id_type']; ?>" class="delete-btn btn-lg" onclick="return confirm('chắc chắn xóa loại hoa này?');">xóa</a>
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
            <!-- DataTales Example -->
            <!-- <div class="card shadow mb-4">
                <div class="card-header py-3 row">
                    <h1 class="col m-0 font-weight-bold text-primary">Loại</h1>
                    <form class="form-inline" method="POST">
                        <div class="form-group p-3">
                            <input type="text" class="form-control" name="name_type" placeholder="tên loại">
                        </div>
                        <input type="submit" name="add_type" class="btn btn-primary mt-0 " value="Thêm loại"></input>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">id loại</th>
                                    <th scope="col">tên loại</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $select_types = mysqli_query($conn, "SELECT * FROM `types`") or die('query failed');
                                if (mysqli_num_rows($select_types) > 0) {
                                    while ($fetch_types = mysqli_fetch_assoc($select_types)) {
                                ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <span><?php echo $fetch_types['id_type']; ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    <span><?php echo $fetch_types['name_type']; ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <a href="admin_update_category.php?update_type=<?php echo $fetch_types['id_type']; ?>" class="option-btn btn-lg">cập nhật</a>
                                                <a href="admin_category.php?delete_type=<?php echo $fetch_types['id_type']; ?>" class="delete-btn btn-lg" onclick="return confirm('delete this product?');">xóa</a>
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
            </div> -->
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