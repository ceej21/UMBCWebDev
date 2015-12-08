<html>
<footer>
<ul>
<?php
if(isset($_SESSION['studID']))
{
	echo "<li><a href='02StudHome.php'>Home</a></li>";
}
else if(isset($_SESSION["UserN"]))
{
	echo "<li><a href='AdminUI.php'>Home</a></li>";
}
?>
<li><a href="http://coeit.umbc.edu">About COEIT</a></li>

<li><a href="http://advising.coeit.umbc.edu/contact-us/">Contact Us</a></li>

<li><a href="http://humanrelations.umbc.edu/non-discrimination/ ">Equal Opportunity</a></li>	

</ul>
<h3 class = "location">© 2010 University of Maryland, Baltimore County. • 1000 Hilltop Circle, Baltimore, MD 21250 • 410-455-1000</h3>
</footer>
</html>
