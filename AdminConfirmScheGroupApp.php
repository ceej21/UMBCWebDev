<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
          <h2>Appointments Created</h2><br>
          <?php
          	//store the data posted
            $date = $_POST["Date"];
            $times = $_POST["time"];
            $majors = $_POST["major"];
            $repeatDays = $_POST["repeat"];
            $repeatWeek = $_POST["stepper"];
            $studentLimit = $_POST["stepper1"];
          
          //one week with given start date (Ex. Thur - Wed) ['Thursday']=>[########]
          $d0 = $date;
          $d1 = '+1 day ' . $date;
          $d2 = '+2 day ' . $date;
          $d3 = '+3 day ' . $date;
          $d4 = '+4 day ' . $date;
          $d5 = '+5 day ' . $date;
          $d6 = '+6 day ' . $date;
          $oneweek = array(date('l', strtotime($d0)) => strtotime($d0),
                  date('l', strtotime($d1)) => strtotime($d1),
                  date('l', strtotime($d2)) => strtotime($d2),
                  date('l', strtotime($d3)) => strtotime($d3),
                  date('l', strtotime($d4)) => strtotime($d4),
                  date('l', strtotime($d5)) => strtotime($d5),
                  date('l', strtotime($d6)) => strtotime($d6)); 
          
          //initialize the first wk
          $dates = array();
          //add the first appointment day
          array_push($dates, date('Y-m-d',strtotime($date))); 
          //check to make sure dates have been selected
          if(!empty($repeatDays)){
          	//adds each date that is not the first appointment of that week
            foreach($repeatDays as $day){
              if($day != date("l", strtotime($date))){
                array_push($dates, date('Y-m-d',$oneweek[$day]));
              }
            }
          }
          //repeat weeks based on initial wk
          $countDates = count($dates);
          //loops through the amount of weeks your want to repeat the appointments
          for($i=0; $i < $repeatWeek; $i++){
          	//loops through each appointment date the amount of week it should be repeated
            for($j=0; $j < $countDates; $j++){
              //adds use the last add date of that day of the week and add another duplicate 1 week later.
              $newDateStr = "+1 week " . $dates[$j + ($i * $countDates)];
              $newDate = date('Y-m-d',strtotime($newDateStr));
              array_push($dates, $newDate);
            }
          }
          
          //pair dates and times to make datetime things YYYY-MM-DD hh:mm:ss
          $datetimes = array();
          foreach($dates as $aDate){
            foreach($times as $time){
              $newDatetime = $aDate . " " . $time;
              array_push($datetimes, $newDatetime);
            }
          }
          
          //add store the string of all major appilcable to the appointment
          $majorDB = "";
          $majorPrint = "All";
          if(!empty($majors)){
            $majorPrint = "";
            foreach($majors as $m){
              $majorDB .= $m . " ";
              $majorPrint .= $m . ", ";
            }
            $majorPrint = substr($majorPrint, 0, -2);
          }
          
          //get advisor id
          $User = $_SESSION["UserN"];
          $Pass = $_SESSION["PassW"];
          $sql = "select `id` from `Proj2Advisors` where `Username` = '$User' and `Password` = '$Pass'";
          $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
          $row = mysql_fetch_row($rs);
          $id = $row[0];
          
          //make sure app doesn't exist
          //insert new app to DB
          //print app
          foreach($datetimes as $dt){
            $sql = "SELECT * from `Proj2Appointments` where `Time` = '$dt' and `AdvisorID` = '0'";
            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            $row = mysql_fetch_row($rs);
            echo date('l, F d, Y g:i A', strtotime($dt)), "<br>Majors included: ", $majorPrint;
            echo("<br>Number of seats: $studentLimit");
            //check to make sure that there will not be duplicate appointments
            if($row){
              echo "<br><span style='color:red'>!!</span>";
            }
            else{
              $sql = "insert into Proj2Appointments (`Time`, `AdvisorID`, `Major`, `Max`) values ('$dt', '0', '$majorDB','$studentLimit')";
              $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            }
            echo "<br><br>";
          }
        ?>
        <br>
        <form method="link" action="AdminUI.php">
          <input type="submit" name="next" class="button large go" value="Return to Home">
        </form>
      </div>
      <div class="bottom">
        <p><span style="color:red">!!</span> indicates that this appointment already exists. A repeat appointment was not made.</p>
      </div>
	</div>
	</form>
  </body>
  
</html>
