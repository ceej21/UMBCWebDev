<?php
session_start();

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

/* no need to re get session variables
$sql = "select * from Proj2Students where `StudentID` = '".$_SESSION["studID"]."'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

$row = mysql_fetch_row($rs)		
$_SESSION["firstN"] = $row[1];
$_SESSION["lastN"] = $row[2];
$_SESSION["email"] = $row[4];
$_SESSION["major"] = $row[5];
*/

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Student Information</title>
    <link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
			<div class="top">
			<h2>Edit Student Information<span class="login-create"></span></h2>
			<form action="StudProcessEdit.php" method="post" name="Edit">
			<div class="field">
				<label for="firstN">First Name</label>
				<input id="firstN" size="30" maxlength="50" type="text" name="firstN" required value=<?php echo $_SESSION["firstN"]?>>
			</div>
			<div class="field">
			  <label for="lastN">Last Name</label>
			  <input id="lastN" size="30" maxlength="50" type="text" name="lastN" required value=<?php echo $_SESSION["lastN"]?>>
			</div>
			<div class="field">
				<label for="studID">Student ID</label>
				<input id="studID" size="30" maxlength="7" type="text" pattern="[A-Za-z]{2}[0-9]{5}" title="AB12345" name="studID" disabled value=<?php echo $_SESSION["studID"]?>>
			</div>
			<div class="field">
				<label for="email">E-mail</label>
				<input id="email" size="30" maxlength="255" type="email" name="email" required value=<?php echo $_SESSION["email"]?>>
			</div>
			<div class="field">
				  <label for="major">Major</label>
				  <select id="major" name = "major">
				  	<option <?php if($_SESSION["major"] == 'ENGR'){echo("selected");}?>>Engineering Undecided</option>
					<option <?php if($_SESSION["major"] == 'CMPE'){echo("selected");}?>>Computer Engineering</option>
					<option <?php if($_SESSION["major"] == 'CMSC'){echo("selected");}?>>Computer Science</option>
					<option <?php if($_SESSION["major"] == 'MENG'){echo("selected");}?>>Mechanical Engineering</option>
					<option <?php if($_SESSION["major"] == 'CENG'){echo("selected");}?>>Chemical Engineering</option>
<!-- someday
					<option <?php if($_SESSION["major"] == 'Africana Studies'){echo("selected");}?>>Africana Studies</option>
					<option <?php if($_SESSION["major"] == 'American Studies'){echo("selected");}?>>American Studies</option>
					<option <?php if($_SESSION["major"] == 'Ancient Studies'){echo("selected");}?>>Ancient Studies</option>
					<option <?php if($_SESSION["major"] == 'Anthropology'){echo("selected");}?>>Anthropology</option>
					<option <?php if($_SESSION["major"] == 'Asian Studies'){echo("selected");}?>>Asian Studies</option>
					<option <?php if($_SESSION["major"] == 'Biochemistry and Molecular Biology'){echo("selected");}?>>Biochemistry and Molecular Biology</option>
					<option <?php if($_SESSION["major"] == 'Bioinformatics and Computational Biology'){echo("selected");}?>>Bioinformatics and Computational Biology</option>
					<option <?php if($_SESSION["major"] == 'Biological Sciences'){echo("selected");}?>>Biological Sciences</option>
					<option <?php if($_SESSION["major"] == 'Business Technology Administration'){echo("selected");}?>>Business Technology Administration</option>
					<option <?php if($_SESSION["major"] == 'Chemistry'){echo("selected");}?>>Chemistry</option>
					<option <?php if($_SESSION["major"] == 'Dance'){echo("selected");}?>>Dance</option>
					<option <?php if($_SESSION["major"] == 'Economics'){echo("selected");}?>>Economics</option>
					<option <?php if($_SESSION["major"] == 'Financial Economics'){echo("selected");}?>>Financial Economics</option>
					<option <?php if($_SESSION["major"] == 'Emergency Health Services'){echo("selected");}?>>Emergency Health Services</option>
					<option <?php if($_SESSION["major"] == 'English'){echo("selected");}?>>English</option>
					<option <?php if($_SESSION["major"] == 'Environmental Science and Environmental Studies'){echo("selected");}?>>Environmental Science and Environmental Studies</option>
					<option <?php if($_SESSION["major"] == 'Gender and Womens Studies'){echo("selected");}?>>Gender and Womens Studies</option>
					<option <?php if($_SESSION["major"] == 'Geography'){echo("selected");}?>>Geography</option>
					<option <?php if($_SESSION["major"] == 'Global Studies'){echo("selected");}?>>Global Studies</option>
					<option <?php if($_SESSION["major"] == 'Health Administration and Policy'){echo("selected");}?>>Health Administration and Policy</option>
					<option <?php if($_SESSION["major"] == 'History'){echo("selected");}?>>History</option>
					<option <?php if($_SESSION["major"] == 'Information Systems'){echo("selected");}?>>Information Systems</option>
					<option <?php if($_SESSION["major"] == 'Interdisciplinary Studies'){echo("selected");}?>>Interdisciplinary Studies</option>
					<option <?php if($_SESSION["major"] == 'Management of Aging Services'){echo("selected");}?>>Management of Aging Services</option>
					<option <?php if($_SESSION["major"] == 'Mathematics'){echo("selected");}?>>Mathematics</option>
					<option <?php if($_SESSION["major"] == 'Statistics'){echo("selected");}?>>Statistics</option>
					<option <?php if($_SESSION["major"] == 'Media and Communication Studies'){echo("selected");}?>>Media and Communication Studies</option>
					<option <?php if($_SESSION["major"] == 'Modern Languages, Linguistics and Intercultural Communication'){echo("selected");}?>>Modern Languages, Linguistics and Intercultural Communication</option>
					<option <?php if($_SESSION["major"] == 'Music'){echo("selected");}?>>Music</option>
					<option <?php if($_SESSION["major"] == 'Philosophy'){echo("selected");}?>>Philosophy</option>
					<option <?php if($_SESSION["major"] == 'Physics'){echo("selected");}?>>Physics</option>
					<option <?php if($_SESSION["major"] == 'Political Sciences'){echo("selected");}?>>Political Science</option>
					<option <?php if($_SESSION["major"] == 'Psychology'){echo("selected");}?>>Psychology</option>
					<option <?php if($_SESSION["major"] == 'Social Work'){echo("selected");}?>>Social Work</option>
					<option <?php if($_SESSION["major"] == 'Sociology'){echo("selected");}?>>Sociology</option>
					<option <?php if($_SESSION["major"] == 'Theatre'){echo("selected");}?>>Theatre</option>
					<option <?php if($_SESSION["major"] == 'Visual Arts'){echo("selected");}?>>Visual Arts</option>
					<option <?php if($_SESSION["major"] == 'Undecided'){echo("selected");}?>>Undecided</option>
					<option <?php if($_SESSION["major"] == 'Other'){echo("selected");}?>>Other</option>
-->
					</select>
			</div>
			<div class="nextButton">
				<input type="submit" name="save" class="button large go" value="Save">
			</div>
			</div>
		</form>
<?php include("footer.php") ?>
  </body>
  
</html>
