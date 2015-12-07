<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Student Advising Home</title>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>Hello 
		<?php
			//echo $_SESSION["firstN"];
			$studid = $_SESSION["studID"]; //stores student id
 
			$sql = "select * from Proj2Students where `StudentID` like '%$studid%'";
			$rs = $COMMON->exectureQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);

			$firstn = $row[1];
			echo $firstn;

		?>
        </h2>
	    <div class="selections">
		<form action="StudProcessHome.php" method="post" name="Home">
	    <?php
			
			$_SESSION["studExist"] = false; //stores whether the studExist
			$adminCancel = false; //stores whether or not the an admin cancelled an appointment
			$noApp = false; //stores if there is an appointment
			$studid = $_SESSION["studID"]; //stores the students ID

			$sql = "select * from Proj2Students where `StudentID` = '$studid'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			
			//Since the row is not empty, the student exists
			if (!empty($row)){
				$_SESSION["studExist"] = true;
				//checks if the admin canceled their appointment
				if($row[6] == 'C'){
					$adminCancel = true;
				}
				if($row[6] == 'N'){
					$noApp = true;
				}
			}
			//check whether the admin cancelled an appointment, student exist or if there is no appointment
			if ($_SESSION["studExist"] == false || $adminCancel == true || $noApp == true){
				//tells the student that their appointment was cancelled
				if($adminCancel == true){
					echo "<p style='color:red'>The advisor has cancelled your appointment! Please schedule a new appointment.</p>";
				}
				echo "<button type='submit' name='selection' class='button large selection' value='Signup'>Signup for an appointment</button><br>";
			}
			//otherwise print the 3 option buttons for when a student already has an appointment
			else{
				echo "<button type='submit' name='selection' class='button large selection' value='View'>View my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button large selection' value='Reschedule'>Reschedule my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button large selection' value='Cancel'>Cancel my appointment</button><br>";
			}
			echo "<button type='submit' name='selection' class='button large selection' value='Search'>Search for appointment</button><br>";
			echo "<button type='submit' name='selection' class='button large selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
        </div>
		<form action="Logout.php" method="post" name="Logout">
	    <div class="logoutButton">
			<input type="submit" name="logout" class="button large go" value="Logout">
	    </div>
		</div>
		</form>
  </body>
</html>