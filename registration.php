<?php
$conn = new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord");

if(isset($_POST['do_signup'])) {
    $username= $_POST['username'];
    $password= $_POST['password'];
    $password2= $_POST['password_2'];
    $fam= $_POST['fam'];
    $name= $_POST['name'];
    $ot4= $_POST['ot4'];
    $tel= $_POST['tel'];
    $email= $_POST['email'];
    $oms= $_POST['oms'];
    $user_type = "user";

    if ($password == $password2){


        $sql = "INSERT INTO `users` (`username`, `password`, `user_type`, `фамилия`, `имя`, `отчество`, `номерТел`, `email`, `омс`)
		VALUES ('".$username."','".$password."','".$user_type."','".$fam."','".$name."','".$ot4."','".$tel."','".$email."','".$oms."')";

		if ($conn->query($sql) === TRUE) {
		   header('location:index.php');
		   $_SESSION['response']="Вы успешно зарегистрированы";
		   $_SESSION['res_type']="success";
		} else {
		   echo "Ошибка: " . $sql . "<br>" . $conn->error; 

		}
  
    } else {

        $_SESSION['response']="Пароли не совпадают";
        $_SESSION['res_type']="danger";
    }

}



  

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Kaplin Sergey">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, install-scale=1,
	shrink-to-fit=no ">
    <title>АИС "Октябрь" - РЕГИСТРАЦИЯ</title>
    <link rel="stylesheet" href="css/register.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 bg-light mt-5 px-0">
            <?php if(isset($_SESSION['response'])) { ?>
                <div class="alert alert-<?=$_SESSION['res_type']; ?> alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $_SESSION['response']; ?>
                </div>
                <b>
                    <?php } unset($_SESSION['response']); ?></b>

                <h3 class="text-center text-light bg-primary p-3">Регистрация</h3>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="p-4">
                <div class="form-group">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Логин" value="<?php echo @$data['login']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Пароль" value="<?php echo @$data['password']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="password" name="password_2" class="form-control form-control-lg" placeholder="Повторите пароль" value="<?php echo @$data['password_2']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="<?php echo @$data['email']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="text" name="fam" class="form-control form-control-lg" placeholder="Фамилия" value="<?php echo @$data['fam']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="text" name="name" class="form-control form-control-lg" placeholder="Имя" value="<?php echo @$data['name']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="text" name="ot4" class="form-control form-control-lg" placeholder="Отчество" value="<?php echo @$data['ot4']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="tel" name="tel" class="form-control form-control-lg"  pattern="+7[0-9]{10}" placeholder="Телефон с +7" value="<?php echo @$data['tel']; ?>" required="">
                </div>
                <div class="form-group">
                        <input type="text" name="oms" class="form-control form-control-lg"   placeholder="Номер ОМС" value="<?php echo @$data['oms']; ?>" required="">
                </div>
                <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-block"  name="do_signup">Зарегистрироваться</button>
                </div>
                </form>
                
            </div>
        </div>
    </div>

    
</body>

</html>