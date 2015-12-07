<?php
session_start();
$debug =true;
include('CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Next Appointment Message</title>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
        <h2>Next Available Appointment</h2>
	    <div class="statusMessage">
		Someone JUST took that appointment before you. Please find another available appointment.
        </div>		
	    <div class="field">
		<form action = "10StudConfirmSch.php" method = "post" name = "SelectTime">
		<?php
		$apptime = $_SESSION["appTime"]; //stores the attempted appoitment time
		$localAdvisor = $_SESSION["advisor"]; //stores the advisorID
		
		$studid = $_SESSION["studId"];
		
		$sql = "select * from Proj2Students where `StudentID` like '%$studid%'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		
		$firstn = $row[1]; //Stores first name
		$lastn = $row[2]; //Stores last name
		$localMaj = $row[5]; //Major is stored
		$email = $row[4]; //stores the students email
		
		//determine what major to store based on the session major
		if($localMaj == 'ENGR'){$localMaj = 'Engineering Undecided' ;}
		if($localMaj == 'MENG'){$localMaj = 'Mechanical Engineering';}
		if($localMaj == 'CMSC'){$localMaj = 'Computer Science';}
		if($localMaj == 'CMPE'){$localMaj = 'Computer Engineering';}
		if($localMaj == 'CENG'){$localMaj = 'Chemical Engineering';}
		
		//gets the row associated the the student's advisor
		$sql = "select * from Proj2Advisors where `id` = '$localAdvisor'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		$advisorName = $row[1]." ".$row[2];
		
		//checks what type of appointment it is
		if ($_SESSION["advisor"] != 0)  // for individual conferences only
		{
			//queries for the next appointment time after the current apptime for an
			$sql = "select * from Proj2Appointments where `EnrolledNum` = 0
			and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".$apptime."' and `AdvisorID` = ".$localAdvisor."
							order by `Time` ASC limit 30";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//echo "<h2>Individual Advising</h2><br>";
			echo "<label for='prompt'>Next available appointment with ",$advisorName," is: </label>";
		}
		else // for group conferences
		{
			$temp = "`AdvisorID` = '$localAdvisor' and ";
			//queries for the next group appointment after time
			$sql = "select * from Proj2Appointments where $temp `EnrolledNum` < `Max` and `Max` > 1 and (`Major` like '%$localMaj%' or `Major` = '')  and `Time` > '".$apptime."' order by `Time` ASC limit 30";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//echo "<h2>Group Advising</h2><br>";
			echo "<label for='prompt'>Next available appointment is: </label>";
		}
		//gets the first data point and output it as a radio button
		$row = mysql_fetch_row($rs);
		$datephp = strtotime($row[1]);
		echo "<label for='",$row[0],"'>";
		echo "<input id='",$row[0],"' type='radio' name='apptime' required value='", $row[1], "'>", date('l, F d, Y g:i A', $datephp) ,"</label><br>\n";
		?>
		<div class="nextButton">
		<?php
			if($_SESSION["resch"] == true){
				echo "<input type='submit' name='finish' class='button large go' value='Reschedule'>";
			}
			else{
				echo "<input type='submit' name='finish' class='button large go' value='Submit'>";
			}
		?>
			<input style="margin-left: 50px" type="submit" name="finish" class="button large" value="Cancel">
	    </div>
		</form>
		<!--<form action="02StudHome.php" method="post" name="complete">
	    <div class="returnButton">
			<input type="submit" name="return" class="button large go" value="Return to Home">
	    </div>
		</div>
		</form>-->
  </body>
</html>
<?php
function isStillAvailable($apptime, $advisor)
{
	// advisor could be "Group"
	global $debug; global $COMMON;
	$sql = "";

	if($advisor == "Group")
	{ $sql = "select `EnrolledNum`, `Max` from `Proj2Appointments` where `Time` = '$apptime' and `AdvisorID` = 0";  }
	else // then specific
	{ $sql = "select `EnrolledNum`, `Max` from `Proj2Appointments` where `Time` = '$apptime' and `AdvisorID` = '$advisor'";  }
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);

	// if max [1] =< EnrolledNum[0], then the spot was indeed taken
	if($row[1] > $row[0]) // then all good
	{ 
		if($debug) { echo("spot available\n<br>"); }
		return true; 
	}
	else // spot was taken
	{
		if($debug) { echo("spot NOT available\n<br>"); }	
		return false; 
	}

}
?>