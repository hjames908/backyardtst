<html>
<head>
<style>
body  {
   background: linear-gradient(to bottom, white, 90%, #A3E4D7);
}
</style>
</head>

<title></title>
<link rel=stylesheet type='text/css' href='mycss.css'></link>
<body>
<img src="logo.png" style="position: absolute; top: 10; left: 50;z-index:-1;">
<h1>BACKYARD CINEMA</h1>
<div>
<?php
	$userlevel = 'guest';
	//Get userlevel received
	if(isset($_GET['userlevel'])){
		$userlevel=$_GET['userlevel'];
	}
	echo '<a href="index.php?userlevel='.$userlevel.'" class="myButton">Home</a>';
?>
</div>

<br>

<p style="color:orange;font-weight:bold">
MOVIE TIMES
</p>

<?php

$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'byardtst'; //To be completed to connect to a database. The database must first exist.
$port = 3306; //Default must be NULL to use default port
$mysqli = new mysqli('localhost', $user, $password, $database, $port);

//check if form was submitted
if(isset($_POST['SubmitButton'])){
	//get showtime info from maintanance form and call maintenance screen
}

//select movies where current date in the range of start date and end date 
$SQL = "SELECT title,rating,show_date,start_time,cinema_id FROM movie INNER JOIN cinema_time on movie.id=cinema_time.movie_id order by show_date,cinema_id,start_time";
$result = mysqli_query($mysqli, $SQL);
	

?>


<div>

<?php
	//display movie times by date then by cinema
  $moviedate='';
  while ( $db_field = mysqli_fetch_assoc($result) ) {
     $showdate=$db_field['show_date'];	
	 //New table for each show date
     if ($showdate != $moviedate) {	 
	    //print end of table if change in show date and previous show date info printed
		if ($moviedate != '') {			
			print '</table><br>';
		}
		//Assign new movie date for display
		$moviedate=$showdate;
		//get day of week and print weekday and date
		$dayOfWeek = date("l", strtotime($moviedate));
		echo $dayOfWeek.' - '.date("d-m-Y", strtotime($moviedate));
        //print table header		
		print '<table class="products">';
		print '<tr>';
		print '<th>Cinema</th>';
		print '<th>Title</th>';
		print '<th>Rating</th>';
		print '<th>Showtime</th>';
			if ($userlevel != 'guest') {
				print '<th>Action</th>';
			}
		print '</tr>';
	 }
				//print new cinema number encountered
				$reccinema='Cinema '.$db_field['cinema_id'];
				$rtitl=$db_field['title'];
				$rrating=$db_field['rating'];	
				$rshowtime=$db_field['start_time'];
				print "<tr>";
				print '<form action="" method="post">';
				print "<td>".$reccinema."</td>";
				print "<td>".$rtitl."</td>";
				print "<td>".$rrating."</td>";
				print "<td>".$rshowtime."</td>";
				if ($userlevel != 'guest') {
					print '<td><input type="submit" value="Change" name="SubmitButton"></td>';
				}
				print '</form>';
				print "</tr>";
  }	
?>
</div>

<?php
$mysqli->close();
?>


</form>












</body>
</html>