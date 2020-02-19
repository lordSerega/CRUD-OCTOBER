<?php
error_reporting(-1);
    ini_set('display_errors', 1);
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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h3 class="text-center text-dark mt-2">Добро пожаловать в автоматизированную информационную систему стоматологической клиники ООО"Октябрь"</h3>
                <hr>
                <?php if(isset($_SESSION['response'])) { ?>
                <div class="alert alert-<?=$_SESSION['res_type']; ?> alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $_SESSION['response']; ?>
                </div>
                <b>
                    <?php } unset($_SESSION['response']); ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center text-info">Добавить врачу выходной</h3>
                <form action="action.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="id" value="" class="form-control" placeholder="Код врача" required>
                    </div>
                    <div class="form-group">
                        <input type="date" name="date" value="" class="form-control" placeholder="Дата" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addWeekend" class="btn btn-primary btn-block" value="Добавить">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm-12">
                <h3>Список приемов у доктора:</h3>
                    <form action="action.php" method="post" enctype="multipart/form-data">
        
                   


              <?php
 
                $searchClient = $conn->query("SELECT * FROM врач") or die($mysqli->error);
                echo "<select name='user_id'><option>Выберите врача</option>";
                while ( $row = $searchClient->fetch_array()) {
                    echo "<option value='" . $row['кодВрача'] . "'>" . $row['фамилия'] ." ". $row['имя'] ." ". $row['отчество'] . "</option>";
                }
                echo "</select>";
            ?>

             <div class="form-group">
                        <input type="submit" name="selectDoctor" class="btn btn-primary btn-block" value="Добавить">
                    </div>
                </form>

                
            
            </div>

            
</body>

</html>