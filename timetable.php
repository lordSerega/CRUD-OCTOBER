<?php
        ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION['username'])){
        header("location:index.php");
    }
    include 'actionUsers.php';
   $pId =   $_SESSION['id'];

    
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
                <?php  if (!isset($_SESSION['username'])|| $_SESSION['role']=="admin"){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="doctors.php">Врачи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Админская</a>
                </li>
            <?php  }else{ ?>
                <li class="nav-item">
                    <a class="nav-link" href="chooseDoctor.php">Записаться на прием</a>
                </li>
            <?php } ?>
            </ul>
        </div>
        <div>
            <a class="navbar-brand" href="timetable.php">Вы вошли как:
                <?= $_SESSION['username']?></a>
            <a href="logout.php" class="btn btn-danger" role="button">Выйти</a>
    </nav>
    <hr>
    <?php if(isset($_SESSION['response'])) { ?>
    <div class="alert alert-<?=$_SESSION['res_type']; ?> alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= $_SESSION['response']; ?>
    </div>
    <b>
        <?php } unset($_SESSION['response']); ?></b>
    </div>


    <div class="container">
      
            <div class="col-sm-12 ">
                <h3>Личная карточка пациента #
                    <?php echo $_SESSION['id'];?>
                </h3>
                <form action="actionUsers.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['email'];?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">ОМС</label>
                            <input type="text" class="form-control" name="oms" value="<?php echo $_SESSION['oms'];?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">Телефон</label>
                            <input type="tel" class="form-control" name="tel" value="<?php echo $_SESSION['tel'];?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">Фамилия</label>
                            <input type="text" class="form-control" name="fam" value="<?php echo $_SESSION['fam'];?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">Имя</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['name'];?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">Отчество</label>
                            <input type="text" class="form-control" name="ot4" value="<?php echo $_SESSION['ot4'];?>">
                        </div>
                    </div>
                    <hr>
                    <h6>Для подтверждения изменений, введите пароль</h6>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <input type="password" class="form-control " name="password">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="submit" class="form-control btn btn-success" name="edit" value="Сохранить изменения">
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12">
                <h3>Список ваших приемов:</h3>
                <?php 
                
                $query="SELECT booking.id, booking.date,booking.timeslot,специальность.название,врач.фамилия,врач.имя,врач.отчество,booking.user FROM booking INNER JOIN врач ON booking.doctor = врач.кодВрача INNER JOIN специальность ON врач.специальность = специальность.кодСпец WHERE booking.user = $pId";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $result=$stmt->get_result();
             ?>
             <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Специальность</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row=$result->fetch_assoc()){ ?>
                        <tr>
                            <td>
                                <?=$row['date']; ?>
                            </td>
                            <td>
                                <?=$row['timeslot']; ?>
                            </td>
                            <td>
                                <?=$row['название']; ?>
                            </td>
                            <td>
                                <?=$row['фамилия']; ?>
                            </td>
                            <td>
                                <?=$row['имя']; ?>
                            </td>
                              <td>
                                <?=$row['отчество']; ?>
                            </td>
                            <td>
    
                                <a href="actionUsers.php?delete=<?= $row['id'];?>" class="badge badge-danger p-2" onclick="return confirm('Вы действительно хотите удалить запись?');">Отменить запись</a>
                               
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

    </div>
</body>

</html>