<?php
    include('config.php');
    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)) {
        echo "<meta http-equiv='refresh' content='0;url=../../index.php?quanly=dangnhap'>";
        echo "<script>alert('Bạn cần đăng nhập để bình luận.')</script>";
        header('location:login.php');
    }
    else{
    if(isset($_POST['thembinhluan'])){
        $pid = $_GET['pid'];
        $noidung=$_POST['content'];

        $so_sao=isset($_POST['rating']) ? $_POST['rating'] : 0;
        $sql="INSERT INTO comment(id_user,pid,vote,content) values('$user_id','$pid','$so_sao','$noidung')";
        mysqli_query($conn,$sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }}
