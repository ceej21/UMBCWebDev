<?php
session_start();

//store all session values locally
$_SESSION["firstN"] = strtoupper($_POST["firstN"]);
$_SESSION["lastN"] = strtoupper($_POST["lastN"]);
$_SESSION["email"] = $_POST["email"];
if($_POST["major"] == 'Engineering Undecided'){$_SESSION["major"] = 'ENGR';}
if($_POST["major"] == 'Mechanical Engineering'){$_SESSION["major"] = 'MENG';}
if($_POST["major"] == 'Computer Science'){$_SESSION["major"] = 'CMSC';}
if($_POST["major"] == 'Computer Engineering'){$_SESSION["major"] = 'CMPE';}
if($_POST["major"] == 'Chemical Engineering'){$_SESSION["major"] = 'CENG';}

//set local values to uppercase to make comparisons easy in the future
$firstn = strtoupper($_POST["firstN"]);
$lastn = strtoupper($_POST["lastN"]);
$studid = $_SESSION["studID"];
$email = $_POST["email"];
$major = $_SESSION["major"];


$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);
//checks if the student exist and if so update their information to the new info inputed
if($_SESSION["studExist"] == true){
	$sql = "update `Proj2Students` set `FirstName` = '$firstn', `LastName` = '$lastn', `Email` = '$email', `Major` = '$major' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

header('Location: 02StudHome.php');
?>