<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

$studID = $_SESSION["studID"];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>View Appointment</title>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>View Appointment</h1>
	    <div class="field">
	    <?php
	    	//query for the student's appointment
			$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studID%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			// if for some reason there really isn't a match, (something got messed up, tell them there really isn't one there)
			$num_rows = mysql_num_rows($rs);

			//check to make sure there is at least one appointment
			if($num_rows > 0)
			{
				$row = mysql_fetch_row($rs); // get legit data
				$advisorID = $row[2]; //store the advisor id
				$datephp = strtotime($row[1]); //store the date of the appointment
				//check whehter or not the appointment is an individual appointment and retrieve the advisors data based on that
				if($advisorID != 0){
					$sql2 = "select * from Proj2Advisors where `id` = '$advisorID'";
					$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
					$row2 = mysql_fetch_row($rs2);
					$advisorName = $row2[1] . " " . $row2[2];
					$office = $row2[6];
					$location = $row2[3];
				}
				//other wise just print standard group info
				else{
					$advisorName = "Group";
					$location = 'ITE 201B';
				}
			
				echo "<label for='info'>";
				echo "Advisor: ", $advisorName, "<br>";
				echo "Appointment: ", date('l, F d, Y g:i A', $datephp), "<br>";
				echo "Office: ", $office, "<br>";
				echo "Location: ", $location, "</label>";
			}
			else // something is up, and there DB table needs to be fixed
			{
				echo("No appointment was detected. It may have been cancelled. Please make another appointment.");
				$sql = "update `Proj2Students` set `Status` = 'N' where `StudentID` = '$studID'";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			}
	

		?>
        </div>
	    <div class="finishButton">
			<button onclick="location.href = '02StudHome.php'" class="button large go" >Return to Home</button>
	    </div>
		</div>
		</form>
<?php include("footer.php") ?>
  </body>
</html>