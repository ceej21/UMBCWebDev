<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Cancel Appointment</title>
    <link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Cancel Appointment</h1>
	    <div class="field">
	    <?php
	    		$studid = $_SESSION["studID"]; //store the students ID
	    
	    		$sql = "select * from Proj2Students where `StudentID` like '%$studid%'";
	    		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	    		$row = mysql_fetch_row($rs);
	    		
	    		$firstn = $row[1]; //store the students first name
			$lastn = $row[2]; //store the students last name
		//	$studid = $row[3]; //store the students ID
			$major = $row[5]; //store the students major
			$email = $row[4]; //store the students email
	    		/*
			$firstn = $_SESSION["firstN"]; //store the students first name
			$lastn = $_SESSION["lastN"]; //store the students last name
			$studid = $_SESSION["studID"]; //store the students ID
			$major = $_SESSION["major"]; //store the students major
			$email = $_SESSION["email"]; //store the students email
			*/
			$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			$oldAdvisorID = $row[2]; //store the current appointment's advisor's id
			$oldDatephp = strtotime($row[1]); //store the current appointment's date
			
			//check that it isn't a group appointment
			if($oldAdvisorID != 0){
				$sql2 = "select * from Proj2Advisors where `id` = '$oldAdvisorID'";
				$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
				$row2 = mysql_fetch_row($rs2);					
				$oldAdvisorName = $row2[1] . " " . $row2[2];
				$oldLocation = $row2[3];
			}
			else{
				$oldAdvisorName = "Group";
				$oldLocation = "ITE 201B";
			}
			
			echo "<h2>Current Appointment</h2>";
			echo "<label for='info'>";
			echo "Advisor: ", $oldAdvisorName, "<br>";
			echo "Appointment: ", date('l, F d, Y g:i A', $oldDatephp), "<br>";
			echo "Location: ", $oldLocation, "</label><br>"
		?>		
        </div>
	    <div class="finishButton">
			<form action = "StudProcessCancel.php" method = "post" name = "Cancel">
			<input type="submit" name="cancel" class="button large go" value="Cancel">
			<input type="submit" name="cancel" class="button large" value="Keep">
			</form>
	    </div>
		</div>
		<div class="bottom">
			<p>Click "Cancel" to cancel appointment. Click "Keep" to keep appointment.</p>
		</div>
		</form>
<?php include("footer.php") ?>
  </body>
</html>
