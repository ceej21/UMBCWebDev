<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Individual Appointment</title>
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
          <h2>Select which appointment you would like to change: </h2>
		  <div class="field">
		  
          <?php
            $debug = false;
            include('CommonMethods.php');
            $COMMON = new Common($debug);
			//gets all individual advising appointments
            $sql = "SELECT * FROM `Proj2Appointments` WHERE `AdvisorID` != '0' and `Time` > '".date('Y-m-d H:i:s')."' ORDER BY `Time`";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");
            $row = mysql_fetch_array($rs, MYSQL_NUM); 
			//first item in row, if it exist show each appointment as a radio button
            if($row){
              echo("<form action=\"AdminConfirmEditInd.php\" method=\"post\" name=\"Confirm\">");
              

	echo("<table border='1px'>\n<tr>");
	echo("<tr><td width='320px'>Time</td><td>Majors</td><td>Enrolled</td></tr>\n");
			//get the name for the advisior
              $secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
              $secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
              $secrow = mysql_fetch_row($secrs);
				//check if there is a student with the appointment and get the student
              if($row[4]){
                $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
                $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
                $trdrow = mysql_fetch_row($trdrs);
              }
				//output the date with a value relating to the information of the advisor and appointment
              echo("<tr><td><label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"IndApp\" 
                required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
              echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
              //check if majors are specified
              if($row[3]){
                echo("<td>$row[3]</td>"); 
              }
              else{
                echo("Available to all majors"); 
              }
              //check if there is a student schedule and outputs their full name
              if($row[4]){
                echo("<td>$trdrow[0] $trdrow[1]</td>");
              }
              else{
                echo("<td>Empty</td>");
              }
			  echo("</tr>\n");

              
			  //repeat above with the rest of the data in the row
              while ($row = mysql_fetch_array($rs, MYSQL_NUM)) {
                $secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
                $secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
                $secrow = mysql_fetch_row($secrs);

                if($row[4]){
                  $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
                  $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
                  $trdrow = mysql_fetch_row($trdrs);
                }

                echo("<tr><td><label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"IndApp\" 
                  required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
                echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
                if($row[3]){
                  echo("<td>$row[3]</td>"); 
                }
                else{
                  echo("Available to all majors"); 
                }

                

                if($row[4]){
                  echo("<td>$trdrow[0] $trdrow[1]</td>");
                }
                else{
                  echo("<td>Empty</td>");
                }
				echo("</tr>\n");
		
                
				
              }
              echo("</table>");

              echo("<div class=\"nextButton\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Delete Appointment\">");
              echo("</div>");
			  echo("</form>");
			  echo("<form method=\"link\" action=\"AdminUI.php\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large\" value=\"Cancel\">");
              echo("</form>");
            }
            //otherwise tell the admin there are no indv appointments
            else{
              echo("<br><b>There are currently no individual appointments scheduled at the current moment.</b>");
              echo("<br><br>");
			  echo("</td</tr>");
              echo("<form method=\"link\" action=\"AdminUI.php\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Return to Home\">");
              echo("</form>");
            }
          ?>
		  
	</div>
	</div>
	<div class="bottom">
		<p style='color:red'>Please note that individual appointments can only be removed from schedule.</p>
	</div>
	</div>
	<?php include("footer.php") ?>
	<?php include('./workOrder/workButton.php'); ?>

	</div>
  </body>
  
</html>
