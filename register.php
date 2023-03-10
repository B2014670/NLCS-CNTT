<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = mysqli_real_escape_string($conn, $filter_name);
    $filter_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = mysqli_real_escape_string($conn, $filter_pass); // md5($filter_pass)
    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $cpass = mysqli_real_escape_string($conn, $filter_cpass); // md5($filter_pass)

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'") or die('query_fail');

    if (mysqli_num_rows($select_users)) {
        $message[] = 'Người dùng đã tồn tại!';
    } else if ($pass != $cpass) {
        $message[] = 'Mật khẩu xác nhận không trùng khớp!';
    } else {
        mysqli_query($conn, " INSERT INTO `users`(name,email,password) VALUE ('$name','$email','$pass') ") or die('query_fail');
        $message[] = "Đăng ký thành công!";
        header('location:login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
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
    <section class="vh-100" style="background-image:  url('img/home-bg.png');">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: rem;">
                        <div class="card-body p-5 text-center">

                            <form id="signupForm" action="" method="post">
                                <h1 class="mb-3 text-uppercase">Đăng ký</h1>

                                <div class="form-outline mb-3 ">
                                    <input type="text" name="name" class="form-control form-control-lg py-3" placeholder="Nhập tên của bạn" required />
                                </div>

                                <div class="form-outline mb-3 ">
                                    <input type="email" name="email" class="form-control form-control-lg py-3" placeholder="Nhập email của bạn" required />
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="password" name="pass" id="pass" class="form-control form-control-lg py-3" placeholder="Nhập mật khẩu" required />
                                </div>

                                <div class="form-outline ">
                                    <input type="password" name="cpass" id="cpass" class="form-control form-control-lg py-3" placeholder="Xác nhận mật khẩu" required />
                                </div>

                                <div class="pt-2">
                                    <button class="btn btn-lg btn-block" name="submit" type="submit" style="background-color:#E84393; color:white">Đăng ký</button>
                                </div>

                                <div class="pt-2">
                                    <p>Bạn đã có tài khoản? Đăng nhập <a href="login.php" style="color: #E84393">Tại đây</a></p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>

	<script type="text/javascript">
		$.validator.setDefaults({
			submitHandler: function(){
				alert("submitted!");
			}
		});
		$(document).ready(function(){
			$("#signupForm").validate({
				rules: {
					name: {required: true, minlength:2},
					pass: {required: true, minlength:5},
					cpass: {required: true, minlength:5, equalTo: '#pass'},
					email: {required: true, email: true},
				},
				messages: {
					name: {
						required: "Bạn chưa nhập vào tên đăng nhập của bạn",
						minlength: "Tên đăng nhập phải có ít nhất 2 ký tự"
					},
					pass: {
						required: "Bạn chưa nhập vào mật khẩu của bạn",
						minlength: "Mật khẩu phải có ít nhất 5 ký tự"
					},
					cpass: {
						required: "Bạn chưa nhập vào mật khẩu của bạn",
						minlength: "Mật khẩu phải có ít nhất 5 ký tự",
						equalTo: "Mật khẩu không trùng khớp"
					},
					email: {
                        required: "Bạn chưa nhập vào email của bạn",
                        email:"Địa chỉ mail không hợp lệ"
                    } 
				},
				errorElement: "div",
				errorPlacement: function (error, element) {
					error.addClass("invalid-feedback");
					if (element.prop("type") === "checkbox") {
						error.insertAfter(element.siblings("label"));
					} else {
						error.insertAfter(element);
					}
				},
				highlight: function (element, errorClass, validClass) {
					$(element).addClass("is-invalid").removeClass("is-valid");
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).addClass("is-valid").removeClass("is-invalid");
				}
			})
		})
	</script>
</body>


</html>