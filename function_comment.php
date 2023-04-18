<?php
    include('config.php');
    session_start();

    
    if (!isset($_SESSION['user_id'])) {
        echo 'Bạn cần đăng nhập để bình luận.';
        // header('location:login.php');
    }
    else{
    if(isset($_POST['thembinhluan'])){
        $user_id = $_SESSION['user_id'];
        $pid = $_GET['pid'];
        $noidung=$_POST['content'];

        $so_sao=isset($_POST['rating']) ? $_POST['rating'] : 0;
        $sql="INSERT INTO comments(id_user,pid,vote,content) values('$user_id','$pid','$so_sao','$noidung')";
        mysqli_query($conn,$sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }}
