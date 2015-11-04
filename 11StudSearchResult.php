<?php
session_start();
//ini_set('display_errors','1');
//ini_set('display_startup_errors','1');
//error_reporting (E_ALL);

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search for Appointment</title>
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Search Results</h1>
		<h3>Showing open appointments only</h3>
	    <div class="field">
			<p>Showing results for: </p>
			<?php
				$date = $_POST["date"]; //stores the date of the search
				$times = $_POST["time"]; //stores the times of the search
				$advisor = $_POST["advisor"]; //stores the advisor of the search
				$results = array();
				//set the major to the name that will be stored in the advisor table
				if($_SESSION["major"] == 'ENGR'){$major = 'Engineering Undecided' ;}
				if($_SESSION["major"] == 'MENG'){$major = 'Mechanical Engineering';}
				if($_SESSION["major"] == 'CMSC'){$major = 'Computer Science';}
				if($_SESSION["major"] == 'CMPE'){$major = 'Computer Engineering';}
				if($_SESSION["major"] == 'CENG'){$major = 'Chemical Engineering';}
				
				//check if the date is not all, and print the date
				if($date == ''){ echo "Date: All"; }
				else{ 
					echo "Date: ",$date;
					$date = date('Y-m-d', strtotime($date));
				}
				echo "<br>";
				//check whether there is a specific time to print otherwise print all time on $date
				if(empty($times)){ echo "Time: All"; }
				else{
					$i = 0;
					echo "Time: ";
					//prints out all applicable times
					foreach($times as $t){
						echo ++$i, ") ", date('g:i A', strtotime($t)), " ";
					}
				}
				echo "<br>";
				//tells the student who the advisor they search for is
				if($advisor == ''){ echo "Advisor: All appointments"; }
				elseif($advisor == 'I'){ echo "Advisor: All individual appointments"; }
				elseif($advisor == '0'){ echo "Advisor: All group appointments"; }
				else{
					//searches for the specific advisor's name and print it out
					$sql = "select * from Proj2Advisors where `id` = '$advisor'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					while($row = mysql_fetch_row($rs)){
						echo "Advisor: ", $row[1], " ", $row[2];
					}
				}
				?>
				<br><br><label>
				<?php
				//checks if there are specified times
				if(empty($times)){
					//check what type of advisor
					if($advisor == 'I'){
						//get all appointments on $date that are individual appointments
						$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` != 0 and `EnrolledNum` = 0 and `Major` like '%$major%' order by `Time` ASC Limit 30";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					}
					else{
						//get all appointments on $date for the specified advisor
						$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` like '%$advisor%' and `EnrolledNum` = 0 and `Major` like '%$major%' order by `Time` ASC Limit 30";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					}
					$row = mysql_fetch_row($rs);
					//$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					//checks if there is data
					if($row){
						if($row[2] == 0){
							$advName = "Group";
						}
						else{ $advName = getAdvisorName($row); }
							
						
						//string that will be output for this row
						$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
								"<td>". $advName."</td>".
								"<td>". $row[3]. "</td></tr>".
								//string added to the results array
						array_push($results, $found);
						//loop through all rows and add it to the html output
						while($row = mysql_fetch_row($rs)){
							//check what the name of the adviosr for the appointment is
							if($row[2] == 0){
								$advName = "Group";
							}
							else{ $advName = getAdvisorName($row); }
							

							//string that will be output for this row
							$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
									"<td>". $advName."</td>". 
									"<td>". $row[3]. "</td></tr>".
							//string added to the results array
							array_push($results, $found);
						}
					}
				}
				else{
					//checks what the advisor parameter is
					if($advisor == 'I'){
						//if any individual get each and store it in $results
						foreach($times as $t){
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `Time` like '%$t%' and `AdvisorID` != 0 and `EnrolledNum` = 0 and `Major` like '%".$major."%' order by `Time` ASC Limit 30";
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							$row = mysql_fetch_row($rs);
							//$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							//checks if there is data and add the data to $results
							if($row){
								if($row[2] == 0){
									$advName = "Group";
								}
								else{ $advName = getAdvisorName($row); }
								//store results in found string
								$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
										"<td>". $advName."</td>".
										"<td>". $row[3]. "</td></tr>".
								array_push($results, $found);
								while($row = mysql_fetch_row($rs)){
									//check the name of the advisor
									if($row[2] == 0){
										$advName = "Group";
									}
									else{ $advName = getAdvisorName($row); }
							//store results in found string
									$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
											"<td>". $advName."</td>". 
											"<td>". $row[3]. "</td></tr>".
									array_push($results, $found);
								}
							}
						}
					}
					else{
						//go through each time and add it to the results
						foreach($times as $t){
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `Time` like '%$t%' and `AdvisorID` like '%$advisor%' and `EnrolledNum` = 0 and `Major` like '%".$major."%' order by `Time` ASC Limit 30";
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							$row = mysql_fetch_row($rs);
							//checks if data exists
							if($row){
								//adds the data to results
								while($row = mysql_fetch_row($rs)){
									//determines if it is a group appointment or not
									if($row[2] == 0){
										$advName = "Group";
									}
									else{ $advName = getAdvisorName($row); }
							//stores the data in resutlts
							$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
									"<td>". $advName."</td>". 
									"<td>". $row[3]. "</td></tr>".
									array_push($results, $found);
								}
							}
						}
					}
				}
				//checks if there are results
				if(empty($results)){
					echo "No results found.<br><br>";
				}
				//print out table with the results
				else{
					echo("<table border='1'><th colspan='3'>Appointments Available</th>\n");
					echo("<tr><td width='60px'>Time:</td><td>Advisor</td><td>Major</td></tr>\n");

					foreach($results as $r){ echo($r."\n"); }

					echo("</table>");
				}
			?>
			</label>
        </div>
		<form action="02StudHome.php" method="link">
	    <div class="nextButton">
			<input type="submit" name="done" class="button large go" value="Done">
	    </div>
		</form>
		</div>
		<div class="bottom">
		<p>If the Major category is followed by a blank, then it is open for all majors.</p>
		</div>
  </body>
</html>

<?php


// More code reduction by Lupoli - 9/1/15
// just getting the advisor's name
function getAdvisorName($row)
{
	global $debug; global $COMMON;
	$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
	$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	$row2 = mysql_fetch_row($rs2);
	return $row2[1] ." ". $row2[2];
}

?>