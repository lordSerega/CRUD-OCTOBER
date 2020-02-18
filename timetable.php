<?php
 
    session_start();
    if (!isset($_SESSION['username'])){
        header("location:index.php");
    }
	include 'action.php';

    
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

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">АИС"Октябрь"</a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Врачи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Специальности</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chooseDoctor.php">Расписание</a>
                </li>
            </ul>
        </div>
        <div>
        <a class="navbar-brand" href="#">Вы вошли как: <?= $_SESSION['username']?></a>
        <a href="logout.php" class="btn btn-danger" role="button">Выйти</a>
    </nav>
   
</body>

</html>