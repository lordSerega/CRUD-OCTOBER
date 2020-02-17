<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}

if(isset($_POST['submit'])){
    $fam = $_POST['fam'];
    $name = $_POST['name'];
    $ot4estvo = $_POST['ot4estvo'];
    $oms = $_POST['oms'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $mysqli =  new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord");
    $stmt = $mysqli->prepare("INSERT INTO booking (fam,name,ot4estvo,oms,tel,email,date) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssss', $fam, $name,$ot4estvo,$oms,$tel, $email, $date);
    $stmt->execute();
    $msg = "<div class='alert alert-success'>Вы успешно записались на прием. Вскоре, с вами свяжется администратор для подтверждения записи.</div>";
    $stmt->close();
    $mysqli->close();
}



$duration = 30;
$cleanup = 0;
$start = "09:00";
$end = "20:00";


function timeslots($duration,$cleanup,$start,$end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    for($intStart =$start;$intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
       $endPeriod = clone $intStart;
       $endPeriod->add($interval);
       if($endPeriod>$end){
       break;
       } 

       $slots[] = $intStart->format("H:i")."-".$endPeriod->format("H:i");
    }

    return $slots;
}

?>
<!doctype html>
<html lang="ru">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Бронирование</title>

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
                    <a class="nav-link" href="doctors.php">Врачи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Специальности</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="calendar.php">Расписание</a>
                </li>
            </ul>
        </div>
   
        <a class="navbar-brand" href="#">Вы вошли как: <?= $_SESSION['username']?></a>

        <a href="logout.php" class="btn btn-danger" role="button">Выйти</a>

        
        </div>
        
    </nav>
    <div class="container">
        <h1 class="text-center">Записаться на: <?php echo date('d/m/Y', strtotime($date)); ?></h1><hr>
        <div class="row">
        <?php
            $timeslots = timeslots($duration,$cleanup,$start,$end);
                foreach($timeslots as $ts){

               

        ?>
        <div class="col-md-2">
            <div class="form-group">
            <button class="btn btn-success"><?php echo $ts; ?></button>
            </div>
        </div>
                <?php }?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>

</html>
