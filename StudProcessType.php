<?php
session_start();
//store the type of appointment in a session variable
if ($_POST["type"] == "Group"){
	$_SESSION["advisor"] = 0;
	header('Location: 08StudSelectTime.php');
}
//also go to select which advisor to store in the session variable
elseif ($_POST["type"] == "Individual"){
	header('Location: 07StudSelectAdvisor.php');
}
?>