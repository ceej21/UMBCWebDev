<?php
session_start();
$debug = false;

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

if(isset($_POST['description'])) // then stage 2, enter data into DB table
{
	if($debug) { echo("stage2"); }
	stage2($_POST);
}
else // they have not entered anything
{
	if($debug) { echo("stage1"); }
	stage1($_GET);
}


// **********************************************************************


function stage1($_GET)
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Work order</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../../css/standard.css'/>
  </head>
  <body>
    <div id="login">
	Work order form for <?php echo($_GET['url']); ?>
    <div id="form">
    <div class="top">

	<form action="workOrder.php" method='post'>
	Description: <br><textarea name='description' id='description' rows="5" cols="200"></textarea><br>
	Priority: <br><input type="radio" name="priority" value="0" checked>None given<br>
			<input type="radio" name="priority" value="1">1 (High)<br>
			<input type="radio" name="priority" value="2">2<br>
			<input type="radio" name="priority" value="3">3<br>
	
	<input type="hidden" name="url" value='<?php echo($_GET["url"]); ?>'>

	<input type="submit" name="next" class="button large go" value="Submit">
		<div>
	</form>
		<form method="link" action="">
		<input type="submit" name="home" class="button large" value="Cancel" onClick="window.close()">
		</form>
		</div>


     </div>
     </div>
     </div>
  </body>
  
</html>

<?php
}


function stage2($_POST)
{
	global $debug;

	include('../../CommonMethods.php');
	$COMMON = new Common($debug);

      $sql = "insert into `work_orders` (`id`, `url`, `description`, `priority`, `author`, `time_entered`) values (null, '".$_POST['url']."', '".$_POST['description']."', '".$_POST['priority']."', '".$_SESSION['UserN']."', CURRENT_TIMESTAMP)";
      $rs = $COMMON->executeQuery($sql, $_SERVER['SCRIPT_NAME']);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Work order</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../../css/standard.css'/>
  </head>
  <body>
    <div id="login">
	Thank you. Work order entered.
	<form action="">
	<input type="submit" name="home" class="button large" value="Close" onClick="window.close()">
	</form>
	</div>
     </div>
  </body>
  
</html>



<?php

	        $message =  "From: ".$_SESSION['userN']."\n\r Priority: ".$_POST['priority']."\n\r ".$_POST['description'];
                mail("slupoli@umbc.edu", "Work Order for COE Advising", $message);

}
?>
