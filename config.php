<?php
	$conn = new mysqli("kaplin-web.h1n.ru","kaplinadmin","parolAdmina","onlinerecord");

	if($conn->connect_error){
		die("Невозможно подключиться к БД!".$conn->connect_error);
	}
?>