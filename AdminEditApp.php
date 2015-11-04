<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Appointment</title>
    <link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	<h1>Edit Appointments</h1>
	<h2>Select advising type</h2><br>

	<form method="post" action="AdminProcessEdit.php">
	<div class="nextButton">
		<input type="submit" name="next" class="button large go" value="Individual">
		<input type="submit" name="next" class="button large go" value="Group">
	</div>
	</form>
        </div>
        <div class="field">
	<br>
	<br>
	<form method="link" action="AdminUI.php">
	<input type="submit" name="next" class="button large go" value="Return to Home">
	</form>
         
        </div>
	</div>
		
  </body>
  
</html>
