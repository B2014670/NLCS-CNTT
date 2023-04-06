<div class="container my-2 profile">
        <h3 class="text-center text-uppercase">Thông tin cá nhân </h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- <div class="col-4 d-flex justify-content-center align-items-center"> -->
                <div class="col-md-4 col-sm-12 col-12 text-center">
                    <img class="rounded-circle d-block mx-auto" width="300px" height="300px" src="uploaded_img/<?php echo $row['avatar'];   ?>" alt="">
                    <label for="avatar" class="text-center bg-primary text-white p-2 rounded mt-1">Tải ảnh lên</label>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" id="avatar" name="avatar" class="d-none">
                </div>

                <div class="col-md-8  col-sm-12 col-12  mx-auto box">

                    <div class="form-group">
                        <label for="">Họ và tên</label>
                        <input type="text" class="form-control" value="<?php echo $row['name'] ?>" name="hoten" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" value="<?php echo  $row['email'] ?>" name="email" id="">
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <div class="input-group border form-control">
                            <input  id="password-input-matkhau" value="<?php echo $row['password'] ?>" name='matkhau' type="password" class="form-control border-0" placeholder="Nhập mật khẩu của bạn">
                            <i onclick="ShowPassword(document.querySelector('#password-input-matkhau'))" class="fa-sharp fa-solid fa-eye border-0 bg-white px-2 my-auto"></i>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control" value="<?php echo $row['phone'] ?>" placeholder="chưa có số điện thoại" name="phone" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ nhận hàng</label>
                        <input type="text" class="form-control" value="<?php echo $row['address'] ?>" placeholder="chưa có địa chỉ" name="diachi" id="">
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <button class="btn w-100  bg-primary text-white" name="capnhatthongtin" type="submit">Cập nhật</button>
                    </div>
                </div>
        </form>
    </div>