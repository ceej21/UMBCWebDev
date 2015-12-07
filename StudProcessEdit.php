<?php
session_start();

//store the signin variables in the session
$firstn = strtoupper($_POST["firstN"]);
$lastn = strtoupper($_POST["lastN"]);
$email = $_POST["email"];
if($_POST["major"] == 'Engineering Undecided'){$major = 'ENGR';}
if($_POST["major"] == 'Mechanical Engineering'){$major = 'MENG';}
if($_POST["major"] == 'Computer Science'){$major = 'CMSC';}
if($_POST["major"] == 'Computer Engineering'){$major = 'CMPE';}
if($_POST["major"] == 'Chemical Engineering'){$major = 'CENG';}
$studid = $_SESSION["studID"];

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);
$sql = "update `Proj2Students` set `FirstName` = '$firstn', `LastName` = '$lastn', `Email` = '$email', `Major` = '$major' where `StudentID` = '$studid'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

header('Location: 02StudHome.php');
?>