<?php
session_start();

$update=false;

if (isset($_GET['specialisation'])){
    $id = $_GET['specialisation'];
    $update = true;


}



?>