<?php
 session_start();


$mysqli = new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord");
if(isset($_GET['date'])){
    $date = $_GET['date'];


  
  
    $stmt = $mysqli->prepare("select * from booking where date = ? and doctor = ?");
    $stmt->bind_param('ss', $date,$_SESSION['doctor']);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            
            $stmt->close();
            
     
    }
    
}

}


if(isset($_POST['submit'])){
    $fam = $_POST['fam'];
    $name = $_POST['name'];
    $ot4estvo = $_POST['ot4estvo'];
    $oms = $_POST['oms'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $timeslot = $_POST['timeslot'];

    $stmt = $mysqli->prepare("select * from booking where date = ? AND timeslot = ? and doctor = ?");
    $stmt->bind_param('sss', $date, $timeslot,$_SESSION['doctor']);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
        $msg = "<div class='alert alert-danger'>К сожалению, на это время уже записался другой пациент.</div>";
            
    } else {
    
        $searchClient = $mysqli->query("SELECT id FROM users WHERE омс= $oms") or die($mysqli->error);
        $rowS = $searchClient->fetch_array();
        $id = $rowS['id'];

        

        $stmt = $mysqli->prepare("INSERT INTO booking (date,timeslot,doctor,user) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss',  $date,$timeslot, $_SESSION['doctor'],$id);
        $stmt->execute();
        $msg = "<div class='alert alert-success'>Вы успешно записались на прием. Вскоре, с вами свяжется администратор для подтверждения записи.</div>";
        $bookings[]=$timeslot;
        $stmt->close();
        $mysqli->close();
        
    }
}

   
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
                    <a class="nav-link active" href="chooseDoctor.php">Расписание</a>
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
        <div class="col-md-12">
        <?php
            echo isset($msg)?$msg:"";
            ?>
  
        </div>
        <?php
            $timeslots = timeslots($duration,$cleanup,$start,$end);
                foreach($timeslots as $ts){
        ?>
        <div class="col-md-2">
            <div class="form-group">
            <?php if(in_array($ts,$bookings)){ ?>

            <button class="btn btn-danger"><?php echo $ts; ?></button>
            <?php }else { ?>
            <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
            <?php } ?>

            
            </div>
        </div>
             <?php }?>
        </div>
    </div>

    <div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Запись на: <span id="slot"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
        <form action="" method="post">
        <div class="form-group">
        <label for="">Время</label>
        <input type="text" readonly name="timeslot" id="timeslot" class="form-control">
        <div class="form-group">
                        <label for="">Фамилия</label>
                        <input type="text" readonly class="form-control" name="fam" value="<?php echo  $_SESSION['fam']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Имя</label>
                        <input type="text" class="form-control" readonly  name="name" value="<?php echo  $_SESSION['name']; ?>" >
                    </div>
                    <div class="form-group">
                        <label for="">Отчество</label>
                        <input type="text" class="form-control" readonly name="ot4estvo" value="<?php echo  $_SESSION['ot4']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Номер ОМС</label>
                        <input type="text" class="form-control" readonly  name="oms" value="<?php echo  $_SESSION['oms']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Телефон</label>
                        <input type="text" class="form-control" name="tel" value="<?php echo  $_SESSION['tel']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo  $_SESSION['email']; ?>">
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Записаться</button>
                    
        </div>
        </form>
        </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<script>
    $(".book").click(function(){
        var timeslot = $(this).attr('data-timeslot');
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);
        
        $("#myModal").modal("show");


    })

</script>
  </body>

</html>
