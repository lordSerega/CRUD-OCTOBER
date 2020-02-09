<?php
    session_start();

	$conn = new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord");

    $msg="";

    if(isset($_POST['login'])) {
        $username= $_POST['username'];
        $password= $_POST['password'];
        $userType= $_POST['userType'];

        $sql = "SELECT * from users WHERE username=? AND password=? AND user_type=?";

        $stmt=$conn->prepare($sql);
        $stmt->bind_param("sss",$username,$password,$userType);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();

        session_regenerate_id();
        $_SESSION['username']=$row['username'];
        $_SESSION['role']=$row['user_type'];
        session_write_close();
 
        if ($result->num_rows==1 && $_SESSION['role'] =="user"){
            header("location:timetable.php");
        }

        else if ($result->num_rows==1 && $_SESSION['role'] =="admin"){
            header("location:doctors.php");
        }
        else {
            $msg = "Неверный логин или пароль";
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
    <title>АИС "Октябрь"</title>
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
                <h3 class="text-center text-light bg-primary p-3">Авторизация</h3>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="p-4">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Логин" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Пароль" required="">
                    </div>
                    <div class="form-group lead">
                        <label for="userType">Права:</label>
                        <input type="radio" name="userType" value="user" class="custom-radio" required>&nbsp;Пациент |
                        <input type="radio" name="userType" value="admin" class="custom-radio" required>&nbsp;Администратор 
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="btn btn-danger btn-block">
                    </div>
                    <h5 class="text-danger text-center"> <?= $msg; ?> </h5>
                </form>
                
            </div>
        </div>
    </div>
    
    
</body>

</html>