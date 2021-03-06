<?php

    session_start();
    if (!isset($_SESSION['username'])|| $_SESSION['role']!="admin"){
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
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">АИС"Октябрь"</a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
             <ul class="navbar-nav">
                 <?php  if (!isset($_SESSION['username'])|| $_SESSION['role']=="admin"){ ?>
                <li class="nav-item">
                    <a class="nav-link " href="doctors.php">Врачи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="admin.php">Админская</a>
                </li>
            <?php  }else{ ?>
                <li class="nav-item">
                    <a class="nav-link" href="chooseDoctor.php">Записаться на прием</a>
                </li>
            <?php } ?>
            </ul>
        </div>
   
        <a class="navbar-brand" href="timetable.php">Вы вошли как: <?= $_SESSION['username']?></a>

        <a href="logout.php" class="btn btn-danger" role="button">Выйти</a>

        
        </div>
        
    </nav>
   <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Док</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                
                        <tr>
                            <td>
                                <?= $idDoctor; ?>
                            </td>
                            <td>
                                <?= $date; ?>
                            </td>
                            <td>
                                <?= $ts; ?>
                            </td>
                            
                        </tr>
            
                    </tbody>
                </table>

            
</body>

</html>