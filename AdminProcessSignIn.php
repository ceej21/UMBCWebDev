<?php

/* Had to make sure sessions was enabled. Some help here:

https://wiki.umbc.edu/pages/viewpage.action?pageId=46563550

cd /afs/umbc.edu/public/web/sites/coeadvising/prod/php/session/

/usr/bin/fs sa /afs/umbc.edu/public/web/sites/coeadvising/prod/php/session/ web.coeadvising all


then edit .htaccess file here in the same directory

*/


session_start();

include('CommonMethods.php');
$debug = false;
$Common = new Common($debug);

$_SESSION["UserN"] = strtoupper($_POST["UserN"]); //Stores the Session's username
$_SESSION["PassW"] = strtoupper($_POST["PassW"]); //stores the Session's password
$_SESSION["UserVal"] = false; //stores whether or not the admin exists

$user = $_SESSION["UserN"];
$pass = $_SESSION["PassW"];

//queries for an admin of UserN and PassW
$sql = "SELECT * FROM `Proj2Advisors` WHERE `Username` = '$user' AND `Password` = '$pass'";
$rs = $Common->executeQuery($sql, "Advising Appointments");
$row = mysql_fetch_row($rs);

//if the admin exists logon otherwise ask for correst username and password
if($row){
	if($debug) { echo("<br>".var_dump($_SESSION)."<- Session variables above<br>"); }
	else { header('Location: AdminUI.php'); }
}
else{
	$_SESSION["UserVal"] = true;
	header('Location: AdminSignIn.php'); 
}

?>