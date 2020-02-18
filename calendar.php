<?php
if (isset($_POST['selectedAll'])){
    $doctor = $_POST['codeDoctor'];
    session_start();

    $_SESSION['doctor'] = $doctor;

}
   function build_calendar($month,$year){
    $mysqli = new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord");
    $stmt = $mysqli->prepare("select * from booking where MONTH(date) = ? AND YEAR(date) = ? AND doctor= ?");
    $stmt->bind_param('sss', $month, $year, $doctor);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['date'];
            }
            
            $stmt->close();
        }

    }



    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенеье');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0,0,0,$month,7,$year);

    // How many days does this month contain?
    $numberDays = date('t',$firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?


    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers
    
   $datetoday = date('Y-m-d');
   
   
   
   $calendar = "<table class='table table-bordered'>";
   $calendar .= "<center><h2>$monthName $year</h2>";
   $calendar .= "<h2>   $doctor</h2>";

   $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 7, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 7, $year))."'>Прошлый месяц</a> ";
    
   $calendar.= " <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Текущий месяц</a> ";
   
   $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 7, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 7, $year))."'>Следующий месяц</a></center><br>";
     $calendar .= "<tr>";

    // Create the calendar headers

    foreach($daysOfWeek as $day) {
         $calendar .= "<th  class='header'>$day</th>";
    } 

    // Create the rest of the calendar

    // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) { 
        for($k=0;$k<$dayOfWeek;$k++){
               $calendar .= "<td  class='empty'></td>"; 

        }
    }
   
    
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
 
    while ($currentDay <= $numberDays) {

         // Seventh column (Saturday) reached. Start a new row.

         if ($dayOfWeek == 7) {

              $dayOfWeek = 0;
              $calendar .= "</tr><tr>";

         }
         
         $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
         $date = "$year-$month-$currentDayRel";
         
          
         $dayname = strtolower(date('l', strtotime($date)));
         $eventNum = 0;
         $today = $date==date('Y-m-d')? "today" : "";
      if($date<date('Y-m-d')){
          $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Запись закрыта</button>";
       } else{
          $calendar.="<td class='$today'><h4>$currentDay </h4> <a href='book.php?date=".$date."' class='btn btn-success btn-xs'>Записаться</a>";
      }
         $calendar .="</td>";


         $currentDay++;
         $dayOfWeek++;

    }
    
    

    // Complete the row of the last week in month, if necessary

    if ($dayOfWeek != 7) { 
    
         $remainingDays = 7 - $dayOfWeek;
           for($l=0;$l<$remainingDays;$l++){
               $calendar .= "<td class='empty'></td>"; 

        }

    }
    
    $calendar .= "</tr>";

    $calendar .= "</table>";

    echo $calendar;


}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на прием</title>
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
        <div class="row">
            <div class="col-md-12">
            <?php
                     $dateComponents = getdate();
                     if(isset($_GET['month']) && isset($_GET['year'])){
                         $month = $_GET['month']; 			     
                         $year = $_GET['year'];
                     }else{
                         $month = $dateComponents['mon']; 			     
                         $year = $dateComponents['year'];
                     }
                    echo build_calendar($month,$year);
                ?>
            </div>
        </div>
    </div>
    
</body>
</html>