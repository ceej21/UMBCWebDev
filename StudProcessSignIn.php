<?php
session_start();

//store the signin variables in the session
$_SESSION["firstN"] = strtoupper($_POST["firstN"]);
$_SESSION["lastN"] = strtoupper($_POST["lastN"]);
$_SESSION["studID"] = strtoupper($_POST["studID"]);
$_SESSION["email"] = $_POST["email"];
if($_POST["major"] == 'Engineering Undecided'){$_SESSION["major"] = 'ENGR';}
if($_POST["major"] == 'Mechanical Engineering'){$_SESSION["major"] = 'MENG';}
if($_POST["major"] == 'Computer Science'){$_SESSION["major"] = 'CMSC';}
if($_POST["major"] == 'Computer Engineering'){$_SESSION["major"] = 'CMPE';}
if($_POST["major"] == 'Chemical Engineering'){$_SESSION["major"] = 'CENG';}

header('Location: 02StudHome.php');
?>