<?php require 'clandarAction.php';
  $mysqli =  new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord") or die(mysqli_error($mysqli));
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
	</div>

    <?php 
				if ($update == true):
			?>

			<div class="container">

            <?php
            $searchSpec = $mysqli->query("SELECT название from специальность WHERE кодСпец= $id") or die($mysqli->error);
            $result = $searchSpec->fetch_array();
            $nameSpec = $result['название'];
	        ?>

				<h3>Выбор врача по специальности <strong><?php echo  $nameSpec;?></strong> </h3>

	<?php
		$result = $mysqli->query("SELECT * from врач WHERE специальность= $id") or die($mysqli->error);
	?>

	<div class="row justify-content-center">
		<table class="table">
			<thead>
				<tr>
					<th>фамилия</th>
					<th>имя</th>
					<th>отчество</th>
					<th colspan="1">Действие</th>
				</tr>
			</thead>
				<?php while($row =$result->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['фамилия']; ?></td>
						<td><?php echo $row['имя']; ?></td>
                        <td><?php echo $row['отчество']; ?></td>
                        <td><form action="calendar.php" method="POST">	
					
						<button type="submit" class="btn btn-success" name="selectedAll">Выбрать</button>
						</form>							
						</td>
					</tr>
				<?php endwhile; ?>
		</table>
	</div>



			<?php 
				else:
			?>

	
	<div class="container">

	<?php
		$mysqli =  new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord") or die(mysqli_error($mysqli));
		$result = $mysqli->query("SELECT * FROM специальность") or die($mysqli->error);
	?>
 <h3>Выбор специализации</h3>
	<div class="row justify-content-center">
   
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Название</th>
					<th colspan="1">Действие</th>
				</tr>
			</thead>
				<?php while($row =$result->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['название']; ?></td>
				
						<td>
							<a href="chooseDoctor.php?specialisation=<?php echo $row['кодСпец']; ?>" class="btn btn-success">Выбрать</a>

						</td>
					</tr>
				<?php endwhile; ?>
		</table>
	</div>
	<?php 
				endif;
			?>
    


</body>
</html>