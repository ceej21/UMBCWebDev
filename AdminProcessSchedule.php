<?php
session_start();

//if group set advisor to group
if ($_POST["next"] == "Group"){
	$_SESSION["advisor"] = $_POST["next"];
	header('Location: AdminScheduleGroup.php');
}
//otherwise get more information
elseif ($_POST["next"] == "Individual"){
	header('Location: AdminScheduleInd.php');
}

?>