<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search Appointments</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
    <link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Search Appointments</h1>
        <form action="AdminSearchResults.php" method="post" name="Confirm">
	    <div class="field">
			<label for="date">Date</label>
			<input id="date" type="date" name="date" placeholder="mm/dd/yyyy" autofocus> (mm/dd/yyyy)
	    </div>

	    <div class="field">
	      <label for="time">Time</label><span style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
		<input type="checkbox" name="time[]" value="8:00:00"> 8:00am - 8:30am<br>
		<input type="checkbox" name="time[]" value="8:30:00"> 8:30am - 9:00am<br>
		<input type="checkbox" name="time[]" value="9:00:00"> 9:00am - 9:30am<br>
		<input type="checkbox" name="time[]" value="9:30:00"> 9:30am - 10:00am<br>
		<input type="checkbox" name="time[]" value="10:00:00"> 10:00am - 10:30am<br>
		<input type="checkbox" name="time[]" value="10:30:00"> 10:30am - 11:00am<br>
		<input type="checkbox" name="time[]" value="11:00:00"> 11:00am - 11:30am<br>
		<input type="checkbox" name="time[]" value="11:30:00"> 11:30am - 12:00pm<br>
		<input type="checkbox" name="time[]" value="12:00:00"> 12:00pm - 12:30pm<br>
		<input type="checkbox" name="time[]" value="12:30:00"> 12:30pm - 1:00pm<br>
		<input type="checkbox" name="time[]" value="13:00:00"> 1:00pm - 1:30pm<br>
		<input type="checkbox" name="time[]" value="13:30:00"> 1:30pm - 2:00pm<br>
		<input type="checkbox" name="time[]" value="14:00:00"> 2:00pm - 2:30pm<br>
		<input type="checkbox" name="time[]" value="14:30:00"> 2:30pm - 3:00pm<br>
		<input type="checkbox" name="time[]" value="15:00:00"> 3:00pm - 3:30pm<br>
		<input type="checkbox" name="time[]" value="15:30:00"> 3:30pm - 4:00pm<br></span>
	    </div>

	    <div class="field">
	      <label for="advisor">Advisor</label>
	      	<select id="advisor" name="advisor">
				<option value="">All appointments</option>
				<option value="I">Individual appointments</option>
				<option value="0">Group appointments</option>
				<?php
				//prints out all advisors names
				$sql = "select * from Proj2Advisors";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				while($row = mysql_fetch_row($rs)){
					echo "<option value='$row[0]'>$row[1] $row[2]</option>";
				}
				?>
			</select>
	    </div>
		
		<div class="field">
			<label for="studID">Student ID</label>
			<input id="studID" type="text" name="studID" maxlength="7" pattern="[A-Za-z]{2}[0-9]{5}" title="AB12345" placeholder="AB12345">
	    </div>
		
		<div class="field">
			<label for="studLN">Student Last Name</label>
			<input id="studLN" type="text" name="studLN">
	    </div>
		
		<div class="field">
			<label for="filter">Filter Open/Closed Appointments</label>
			<select id="filter" name="filter">
				<option value="">All</option>
				<option value="0">Open</option>
				<option value="1">Closed</option>
			</select>
	    </div>

	<div class="nextButton">
			<input type="submit" name="go" class="button large go" value="Go">
	</div>
	</div>
	</form>
	<br>
	<br>
	<form method="link" action="AdminUI.php">
	<input type="submit" name="next" class="button large go" value="Return to Home">
	<?php include("footer.php"); ?>
	<?php include('./workOrder/workButton.php'); ?>
	</form>
  </body>
  
</html>
