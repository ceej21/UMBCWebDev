<?php
session_start();

//store the posted data as session variables
$_SESSION["AdvF"] = $_POST["firstN"];
$_SESSION["AdvL"] = $_POST["lastN"];
$_SESSION["AdvUN"] = $_POST["UserN"];
$_SESSION["AdvPW"] = $_POST["PassW"];
$_SESSION["Office"] = $_POST["office"];
$_SESSION["Location"] = $_POST["location"];
$_SESSION["PassCon"] = false;

//check if the password and the cofirm password match otherwise go back
if($_POST["PassW"] == $_POST["ConfP"]){
	header('Location: AdminCreateNew.php');
}
elseif($_POST["PassW"] != $_POST["ConfP"]){
	$_SESSION["PassCon"] = true;
	header('Location: AdminCreateNewAdv.php');
}

?>