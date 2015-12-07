<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

//store the signin variables in the session
$firstn = strtoupper($_POST["firstN"]);
$lastn = strtoupper($_POST["lastN"]);
$email = $_POST["email"];
if($_POST["major"] == 'Engineering Undecided'){$major = 'ENGR';}
if($_POST["major"] == 'Mechanical Engineering'){$major = 'MENG';}
if($_POST["major"] == 'Computer Science'){$major = 'CMSC';}
if($_POST["major"] == 'Computer Engineering'){$major = 'CMPE';}
if($_POST["major"] == 'Chemical Engineering'){$major = 'CENG';}
$_SESSION["studID"] = strtoupper($_POST["studID"]);
$studid = strtoupper($_POST["studID"]);

//determine whether to create a new student
$sql = "select * from Proj2Students where `StudentID` like '%$studid%'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
if(empty($row))
{
	$sql = "insert into Proj2Students (`FirstName`,`LastName`,`StudentID`,`Email`,`Major`, `Status`) values ('$firstn','$lastn','$studid','$email','$major','N')";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

header('Location: 02StudHome.php');
?>