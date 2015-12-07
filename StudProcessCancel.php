<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

//check if the student want to cancel their appointment
if($_POST["cancel"] == 'Cancel'){
	//store all session variables locally
	$studid = $_SESSION["studID"]; //store the students ID
	    
	$sql = "select * from Proj2Students where `StudentID` like '%$studid%'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);
	    		
	$firstn = $row[1]; //store the students first name
	$lastn = $row[2]; //store the students last name
	$major = $row[5]; //store the students major
	$email = $row[4]; //store the students email
	
	//remove stud from EnrolledID
	$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);
	$oldAdvisorID = $row[2];
	$oldAppTime = $row[1];
	$newIDs = str_replace($studid, "", $row[4]);
	
	//update the changed values in the appointment table
	$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum-1, `EnrolledID` = '$newIDs' where `AdvisorID` = '$oldAdvisorID' and `Time` = '$oldAppTime'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	//update stud status to noApp
	$sql = "update `Proj2Students` set `Status` = 'N' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	$_SESSION["status"] = "cancel";
}
else{
	$_SESSION["status"] = "keep";
}
header('Location: 12StudExit.php');
?>