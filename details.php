<?php
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
                    <a class="nav-link" href="#">Расписание</a>
                </li>
            </ul>
        </div>
        <a class="navbar-brand" href="#">Вы вошли как:
            <?= $_SESSION['username']?></a>
        <a href="logout.php" class="btn btn-danger" role="button">Выйти</a>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-3 bg-dark p-2 rounded">
                <h2 class="bg-light p-2 rounded text-center text-dark">ID :
                    <?= $vid; ?>
                </h2>
                <h4 class="text-light">Специальность :
                    <?= $vspec; ?>
                </h4>
                <h4 class="text-light">Фамилия :
                    <?= $vsurname; ?>
                </h4>
                <h4 class="text-light">Имя :
                    <?= $vname; ?>
                </h4>
                <h4 class="text-light">Отчество :
                    <?= $vlastname; ?>
                </h4>
                <a href="doctors.php"><button type="button" class="btn btn-dark btn-block">Назад</button></a>
            </div>
        </div>
    </div>
    <h3>Список приемов:</h3>
    <?php 
                
                $query="SELECT
                          booking.id,
                          booking.date,
                          booking.timeslot,
                          врач.кодВрача,
                          врач.специальность,
                          врач.фамилия,
                          врач.имя,
                          врач.отчество,
                          users.фамилия as фамПац
                        FROM booking
                          INNER JOIN врач
                            ON booking.doctor = врач.кодВрача
                          INNER JOIN users
                            ON booking.user = users.id
                            WHERE users.фамилия <> 'ВЫХОДНОЙ' AND кодВрача =$vid";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $result=$stmt->get_result();
             ?>
    <table class="table table-hover" id="table-data">
        <thead>
            <tr>
                <th>#</th>
                <th>Дата</th>
                <th>Время</th>
                <th>Врач</th>
                <th>Пациент</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                            while ($row=$result->fetch_assoc()){ ?>
            <tr>
                <td>
                    <?=$row['id']; ?>
                </td>
                <td>
                    <?=$row['date']; ?>
                </td>
                <td>
                    <?=$row['timeslot']; ?>
                </td>
                <td>
                    <?=  $row['фамилия']." ".$row['имя']." ".$row['отчество']; ?>
                </td>
                <td>
                    <?=$row['фамПац']; ?>
                </td>
                <td>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>