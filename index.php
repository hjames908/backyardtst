<html>
<head>
<style>
body  {
      background-image: url("backgrnd.jpg");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
}
</style>
</head>

<title></title>
<link rel=stylesheet type='text/css' href='mycss.css'></link>
<body>
<form name=mainwindow>


<h1>BACKYARD CINEMA</h1>

<div>
<?php
	$userlevel = 'guest';
	//Get userlevel received
	if(isset($_GET['uxl'])){
		$userlevel=$_GET['uxl'];
	}
	
    echo '<a href="loginpage.php" style="font-family:Arial; color:blue; font-size:17px; font-weight:bold; position: absolute; right: 20;">Exit</a>';

    //Conditionally display elements based on user level
	if ($userlevel == 'guest') {
		echo '<a href="cinematimes.php?uxl='.$userlevel.'" style="font-family:Arial; color:blue; font-size:17px; font-weight:bold; position: absolute; right: 80;">Movie Times</a>';
	}

    echo '<br><br><br><br>';

	//Conditionally display elements based on user level
	if ($userlevel == 'admin') {
		echo '<a href="users.php?uxl='.$userlevel.'" class="myButton">Maintain Users</a> &nbsp;&nbsp;';
	}
	if ($userlevel == 'admin' || $userlevel == 'supervisor') {
		echo '<a href="movies.php?uxl='.$userlevel.'" class="myButton">Maintain Movies</a> &nbsp;&nbsp;';
		echo '<a href="cinematimes.php?uxl='.$userlevel.'" class="myButton">Maintain Schedules/Seating</a>';
	}
?>
</div>

<br><br><br>


<p style="color:orange;font-weight:bold">
TODAY'S MOVIES
</p>

<?php

$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'byardtst'; //To be completed to connect to a database. The database must exist.
$port = 3306; //Default must be NULL to use default port
$mysqli = new mysqli('localhost', $user, $password, $database, $port);

//select movies where current date in the range of start date and end date 
$SQL = "SELECT * FROM movie where CURDATE() >= start_date and CURDATE() <= end_date order by title";
$result = mysqli_query($mysqli, $SQL);

?>

<div>
<table class="products">
<tr>
<th>Title</th>
<th>Rating</th>
</tr>
		<?php
          while ( $db_field = mysqli_fetch_assoc($result) ) {
			$rtitl=$db_field['title'];
			$rrating=$db_field['rating'];	
            print "<tr>";
            print "<td>".$rtitl."</td>";
            print "<td>".$rrating."</td>";
            print "</tr>";
		  }	
		?>	
</table>
</div>
<br><br>
<div>&copy; Backyard Cinema</div>

</form>
<?php
$mysqli->close();
?>


</form>












</body>
</html>