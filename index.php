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
        <form class="form-inline" action="/action_page.php">
            <input class="form-control mr-sm-2" type="text" placeholder="Поиск">
            <button class="btn btn-primary" type="submit">Найти</button>
        </form>
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3 class="text-center text-dark mt-2">Добро пожаловать в автоматизированную информационную систему стоматологической клиники ООО"Октябрь"</h3>
                <hr>
                <?php if(isset($_SESSION['response'])) { ?>
                <div class="alert alert-<?=$_SESSION['res_type']; ?> alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['response']; ?>
                </div>
           		<b><?php } unset($_SESSION['response']); ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center text-info">Добавить запись</h3>
                <form action="action.php" method="post" enctype="multupart/form-data">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Введите имя" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="surname" class="form-control" placeholder="Введите фамилию" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lastName" class="form-control" placeholder="Введите отчество" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Специальность</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="spec">
                            <option selected>Выбрать...</option>
                            <option value="2">Терапевт</option>
                            <option value="3">Ортодонт</option>
                            <option value="4">Ортопед</option>
                            <option value="5">Пародонтолог</option>
                            <option value="1">Хирург</option>
                            <option value="6">Зубной техник</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary btn-block" value="Добавить запись">
                    </div>
                </form>
            </div>
            <?php 
            	$query="SELECT врач.кодВрача, специальность.название, врач.фамилия, врач.имя, врач.отчество FROM врач INNER JOIN специальность ON врач.специальность = специальность.кодСпец";
            	$stmt=$conn->prepare($query);
            	$stmt->execute();
            	$result=$stmt->get_result();
             ?>
            <div class="col-md-8">
                <h3 class="text-center text-info">Список врачей в базе данных</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Код</th>
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
                            <td><?=$row['кодВрача']; ?></td>
                            <td><?=$row['название']; ?></td>
                            <td><?=$row['фамилия']; ?></td>
                            <td><?=$row['имя']; ?></td>
                            <td><?=$row['отчество']; ?></td>
                            <td>
                                <a href="details.php?details=<?= $row['кодВрача'];?>" class="badge badge-primary p-2">Подробнее</a> |
                                <a href="action.php?delete=<?= $row['кодВрача'];?>" class="badge badge-danger p-2">Удалить</a> |
                                <a href="index.php?edit=<?= $row['кодВрача'];?>" class="badge badge-success p-2">Изменить</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>