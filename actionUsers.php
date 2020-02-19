<?php
	session_start();
	include 'config.php';

		if (isset($_POST['edit'])) {

		$id=$_SESSION['id'];	
		$password=$_POST['password'];	
		$name=$_POST['name'];
		$fam=$_POST['fam'];
		$ot4=$_POST['ot4'];
		$oms=$_POST['oms'];
		$tel=$_POST['tel'];
		$email=$_POST['email'];
	
		if ($password == $_SESSION['password']){



		$sql = "UPDATE `users` SET `email`='".$email."', `фамилия`='".$fam."',`имя`='".$name."',`отчество`='".$ot4."',`номерТел`='".$tel."',`омс`='".$oms."' WHERE `id`='".$id."'";

		if ($conn->query($sql) === TRUE) {
		   
		   $_SESSION['response']="Данные успешно изменены.";
		   $_SESSION['res_type']="primary";
		   
        	
        	$_SESSION['fam']=$fam;
        	$_SESSION['name']=$name;
        	$_SESSION['ot4']=$ot4;
        	$_SESSION['email']=$email;
        	$_SESSION['tel']=$tel;
        	$_SESSION['oms']=$oms;
		   header('location:timetable.php');
		} else {
		   echo "Ошибка: " . $sql . "<br>" . $conn->error; 

		} 
		} else {
			 $_SESSION['response']="Введен неверный пароль";
		   $_SESSION['res_type']="danger";
		    header('location:timetable.php');

		}           
    } 

    if(isset($_GET['delete'])){
		$id=$_GET['delete'];

		$query="DELETE FROM `booking` where `id`=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		header('location:timetable.php');
		   $_SESSION['response']="Вы успешно отменили прием";
		   $_SESSION['res_type']="danger";
	}
		

	


	

		
 ?>	
