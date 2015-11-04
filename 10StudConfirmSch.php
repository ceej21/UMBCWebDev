<?php
session_start();
$appTime = $_POST["appTime"]; // radio button selection from previous form
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Confirm Appointment</title>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>  </head>
  <body>
	<div id="login">
      <div id="form">
        <div class="top">
		<h1>Confirm Appointment</h1>
	    <div class="field">
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
	    <?php
			$debug = false;
			include('CommonMethods.php');
			$COMMON = new Common($debug);
			

			$studid = $_SESSION["studID"]; //Stores student ID
			
			$sql = "select * from Proj2Student where `StudentID` like '%$studid%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			
			$firstn = $row[1]; //Stores first name
			$lastn = $row[2]; //Stores last name
			$major = $row[4]; //Major is stored
			$email = $row[5]; //stores the students email
			
			$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			
			//checks whehter the student is try to reschedule their original appointment
			if(mysql_num_rows($rs) != 0){
				$row = mysql_fetch_row($rs);
				//if so, it queries for their current appointment
				$oldAdvisorID = $row[2];
				$oldDatephp = strtotime($row[1]);
				
				//checks if it is a group a appointmnet
				if($oldAdvisorID != 0){
					//if not it just get the advisors name and location
					$sql2 = "select * from Proj2Advisors where `id` = '$oldAdvisorID'";
					$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
					$row2 = mysql_fetch_row($rs2);
					$oldAdvisorName = $row2[1] . " " . $row2[2];
					$oldLocation = $row2[3];
				}
				else{
					//otherwise the standard group name and location are printed
					$oldAdvisorName = "Group";
					$oldLocation = "ITE 201B";
				}
				
				//prints out the old advisor's information
				echo "<h2>Previous Appointment</h2>";
				echo "<label for='info'>";
				echo "Advisor: ", $oldAdvisorName, "<br>";
				echo "Appointment: ", date('l, F d, Y g:i A', $oldDatephp), "<br>";
				echo "Location: ", $oldLocation,"</label><br>";
			}
			
			$currentAdvisorName; //stores the new advisors name
			$currentAdvisorID = $_SESSION["advisor"]; //stores the new advisor's id
			$currentDatephp = strtotime($_SESSION["appTime"]); //get the time of the appointment
			//checks if the appointment is a group appointmnet
			if($currentAdvisorID != 0){
				//if not get the data for that advisor
				$sql2 = "select * from Proj2Advisors where `id` = '$currentAdvisorID'";
				$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
				$row2 = mysql_fetch_row($rs2);
				$currentAdvisorName = $row2[1] . " " . $row2[2];
				$location = $row2[3];
			}
			else{
				//otherwise use the defualt group information
				$currentAdvisorName = "Group";
				$location = "ITE 201B";
			}
			
			//prints out the new appointment's information
			echo "<h2>Current Appointment</h2>";
			echo "<label for='newinfo'>";
			echo "Advisor: ",$currentAdvisorName,"<br>";
			echo "Appointment: ",date('l, F d, Y g:i A', $currentDatephp),"<br>";
			echo "Location: ", $location,"</label>";
			
		?>
        </div>
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
		</div>
  </body>
</html>