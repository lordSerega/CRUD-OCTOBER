<?php
	session_start();
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

		  if(isset($_POST['login'])) {
        $username= $_POST['username'];
        $password= $_POST['password'];
        $password = sha1($password);
        $userType= $_POST['userType'];

        $sql = "SELECT * from users WHERE username=? AND password=? AND user_type=?";

        $stmt=$conn->prepare($sql);
        $stmt->bind_param("sss",$username,$password,$userType);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();

        session_regenerate_id();
        $_SESSION['username']=$row['username'];
        $_SESSION['role']=$row['user_type'];
        session_write_close();
 
        if ($result->nuw_rows==1 && $_SESSION['role'] =="user"){
            header("location:timetable.php");
        }

        else if ($result->nuw_rows==1 && $_SESSION['role'] =="admin"){
            header("location:doctors.php");
        }
        else {
            $msg = "Неверный логин или пароль";
        }


    }

		
 ?>	
