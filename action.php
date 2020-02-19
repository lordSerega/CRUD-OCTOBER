<?php
error_reporting(-1);
	session_start();
	ini_set('display_errors', 1);
	include 'config.php';

	$update=false;

	$id="";
	$spec="";
	$name="";
	$surname="";
	$lastname="";
	



	if(isset($_POST['add'])){
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$lastname=$_POST['lastName'];
		$spec=$_POST['spec'];

	
				
		$sql = "INSERT INTO `врач` (`специальность`, `фамилия`, `имя`, `отчество`)
		VALUES ('".$spec."','".$surname."','".$name."','".$lastname."')";

		if ($conn->query($sql) === TRUE) {
		   header('location:doctors.php');
		   $_SESSION['response']="Врач успешно добавлен в БД";
		   $_SESSION['res_type']="success";
		} else {
		   echo "Ошибка: " . $sql . "<br>" . $conn->error; 

		}
	}

	if(isset($_GET['delete'])){
		$id=$_GET['delete'];

		$query="DELETE FROM `врач` where `кодВрача`=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		header('location:doctors.php');
		   $_SESSION['response']="Врач успешно удален";
		   $_SESSION['res_type']="danger";
	}

	if(isset($_POST['addWeekend'])){
		$id=$_POST['id'];
		$date=$_POST['date'];


		$duration = 30;
	   	$cleanup = 0;
	    $start = "09:00";
	  	 $end = "20:00";

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
       $lol=21;


       }

		for($i=0;$i<=23;$i++){
       $sql= "INSERT INTO booking (date,timeslot,doctor,user) VALUES ('$date','$slots[$i]','$id','$lol')" ;
       if ($conn->query($sql) === TRUE) {
		  
		} else {
		   echo "Ошибка: " . $sql . "<br>" . $conn->error; 

		}
    	}

		header('location:admin.php');
		   $_SESSION['response']="Ура! У врача появился выходной с:";
		   $_SESSION['res_type']="danger";
	}

	if(isset($_GET['edit'])){
		$id=$_GET['edit'];

		$query="SELECT * FROM `врач` where `кодВрача`=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();


		$id=$row['кодВрача'];
		$spec=$row['специальность'];
		$name=$row['имя'];
		$surname=$row['фамилия'];
		$lastname=$row['отчество'];

		$update=true;
		}

		if (isset($_POST['update'])) {
		$id=$_POST['id'];	
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$lastname=$_POST['lastName'];
		$spec=$_POST['spec'];

		$sql = "UPDATE `врач` SET `специальность`='".$spec."', `фамилия`='".$surname."',`имя`='".$name."',`отчество`='".$lastname."' WHERE `кодВрача`='".$id."'";

		if ($conn->query($sql) === TRUE) {
		   
		   $_SESSION['response']="Врач успешно изменен.";
		   $_SESSION['res_type']="primary";
		   header('location:doctors.php');
		} else {
		   echo "Ошибка: " . $sql . "<br>" . $conn->error; 

		}

		}


		if(isset($_GET['details'])){
			$id=$_GET['details'];
			$query="SELECT врач.кодВрача, специальность.название, врач.фамилия, врач.имя, врач.отчество FROM врач INNER JOIN специальность ON врач.специальность = специальность.кодСпец WHERE кодВрача=?";
		
			$stmt=$conn->prepare($query);
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result=$stmt->get_result();
			$row=$result->fetch_assoc();

			$vid=$row['кодВрача'];
			$vspec=$row['название'];
			$vname=$row['имя'];
			$vsurname=$row['фамилия'];
			$vlastname=$row['отчество'];
		}

	

		
 ?>	
