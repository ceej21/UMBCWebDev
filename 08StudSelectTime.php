<?php
session_start();
$debug = false;

//check if an advisor was posted
if(isset($_POST["advisor"])){
	//$_POST["advisor"] = $_POST["advisor"];
}
$studid = $_SESSION["studID"]; //store the students ID
$localAdvisor = $_POST["advisor"]; //stores the advisor
	    
$sql = "select * from Proj2Students where `StudentID` like '%$studid%'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
$localMaj=$row[5];
/*
if($_SESSION["major"] == 'ENGR'){$localMaj = 'Engineering Undecided' ;}
if($_SESSION["major"] == 'MENG'){$localMaj = 'Mechanical Engineering';}
if($_SESSION["major"] == 'CMSC'){$localMaj = 'Computer Science';}
if($_SESSION["major"] == 'CMPE'){$localMaj = 'Computer Engineering';}
if($_SESSION["major"] == 'CENG'){$localMaj = 'Chemical Engineering';}
*/


include('CommonMethods.php');
$COMMON = new Common($debug);

//query for $localAdvisor's information
$sql = "select * from Proj2Advisors where `id` = '$localAdvisor'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
$advisorName = $row[1]." ".$row[2];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Appointment</title>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>

  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Select Appointment Time</h1>
	    <div class="field">
		<form action = "10StudConfirmSch.php" method = "post" name = "SelectTime">
	    <?php

// http://php.net/manual/en/function.time.php fpr SQL statements below
// Comparing timestamps, could not remember. 

			$curtime = time();
			
			//checks if it is a group appointment and determines what to do based on that info
			if ($_POST["advisor"] != 0)  // for individual conferences only
			{ 
				//if not a group get the all of the appointment times for the advisor that are available
				$sql = "select * from Proj2Appointments where $temp `EnrolledNum` = 0 
					and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` = ".$_POST['advisor']." 
					order by `Time` ASC limit 30";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				echo "<h2>Individual Advising</h2><br>";
				echo "<label for='prompt'>Select appointment with ",$advisorName,":</label><br>";
			}
			else // for group conferences
			{
				//otherwise show all group appointments that are available on the specified date
				$temp = "`AdvisorID` = '$localAdvisor' and ";

				$sql = "select * from Proj2Appointments where $temp `EnrolledNum` < `Max` and `Max` > 1 and (`Major` like '%$localMaj%' or `Major` = '')  and `Time` > '".date('Y-m-d H:i:s')."' order by `Time` ASC limit 30";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				echo "<h2>Group Advising</h2><br>";
				echo "<label for='prompt'>Select appointment:</label><br>";
			}
			//print out each appointment as a radio button
			while($row = mysql_fetch_row($rs)){
				$datephp = strtotime($row[1]);
				echo "<label for='",$row[0],"'>";
				echo "<input id='",$row[0],"' type='radio' name='appId' required value='", $row[0], "'>", date('l, F d, Y g:i A', $datephp) ,"</label><br>\n";
			}
		?>
        </div>
	    <div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Next">
	    </div>
		</form>
		<div>
		<form method="link" action="02StudHome.php">
		<input type="submit" name="home" class="button large" value="Cancel">
		</form>
		</div>
		<div class="bottom">
		<p>Note: Appointments are maximum 30 minutes long.</p>
		<p style="color:red">If there are no more open appointments, contact your advisor or click <a href='02StudHome.php'>here</a> to start over.</p>
		</div>
  </body>
</html>
