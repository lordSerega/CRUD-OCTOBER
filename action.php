<?php
	session_start();
	include 'config.php';

	if(isset($_POST['add'])){
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$lastname=$_POST['lastName'];
		$spec=$_POST['spec'];

	
				
		$sql = "INSERT INTO `врач` (`специальность`, `фамилия`, `имя`, `отчество`)
		VALUES ('".$spec."','".$surname."','".$name."','".$lastname."')";

		if ($conn->query($sql) === TRUE) {
		   header('location:index.php');
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
		header('location:index.php');
		   $_SESSION['response']="Врач успешно удален";
		   $_SESSION['res_type']="danger";
	}

		
 ?>	
