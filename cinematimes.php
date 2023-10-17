<html>
<head>
<style>
body  {
      background-image: url("backgrnd.jpg");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
}

/* Popup styles */
#popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: lightblue;
  padding-left: 120px;
  padding-right: 120px;
  padding-bottom: 70px;
  padding-top: 40px;
  border: 1px solid black;
  align-items: left;
}


#updpopup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: lightblue;
  padding-left: 120px;
  padding-right: 120px;
  padding-bottom: 70px;
  padding-top: 40px;
  border: 1px solid black;
  align-items: left;
}


</style>
</head>

<title></title>
<link rel=stylesheet type='text/css' href='mycss.css'></link>
<body>
<h1>BACKYARD CINEMA</h1>
<div>
<?php
	$userlevel = 'guest';
	//Get userlevel received
	if(isset($_GET['uxl'])){
		$userlevel=$_GET['uxl'];
	}
	echo '<a href="index.php?uxl='.$userlevel.'" class="myButton">Home</a>';
?>
</div>

<br>

<p style="color:orange;font-weight:bold">
MOVIE TIMES
</p>

<?php

$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'byardtst'; //To be completed to connect to a database. The database must exist.
$port = 3306; //Default must be NULL to use default port
$mysqli = new mysqli('localhost', $user, $password, $database, $port);

//check if form was submitted (change)
if(isset($_POST['UpdateButton'])){
    $upderror=''; 	
	$updmovid = $_POST['updmovid'];
	$updcineid = $_POST['updcineid'];
	$updshowdat = $_POST['updshowdat'];
	$updstrtim = $_POST['updstrtim']; //get input text
	$updtaken = $_POST['updtaken'];
	$updavail = $_POST['updavail'];
	//validate total seats
	if ($updtaken + $updavail != 100) {$upderror='Record not updated..Seats Available + Seats Taken must be equal to 100';}
    if ($upderror != '') {
		echo $upderror; 
	}
    else {	
	$SQL = "UPDATE cinema_time SET start_time='".$updstrtim."', seatstaken = '".$updtaken."', seatsavail = '".$updavail."' WHERE cinema_id = '".$updcineid."' and movie_id = '".$updmovid."' and show_date = '".$updshowdat."'";
    $result2 = mysqli_query($mysqli, $SQL);
	}
}

if(isset($_POST['DeleteButton'])){
	
}	


//select movies where current date in the range of start date and end date 
$SQL = "SELECT id,title,rating,show_date,start_time,cinema_id,seatstaken,seatsavail FROM movie INNER JOIN cinema_time on movie.id=cinema_time.movie_id order by show_date,cinema_id,start_time";
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
				print '<th>Seats Taken</th>';
				print '<th>Seats Available</th>';
		}
		print '<th>Movie Details</th>';
			if ($userlevel != 'guest') {
				print '<th>Action</th>';
			}
		print '</tr>';
	 }
				//print new cinema number encountered
				$reccinema='Cinema '.$db_field['cinema_id'];
				$rcinemaid=$db_field['cinema_id'];
				$rid=$db_field['id'];
				$rtitl=$db_field['title'];
				$rrating=$db_field['rating'];	
				$rshowtime=$db_field['start_time'];
				$rtaken=$db_field['seatstaken'];
				$ravail=$db_field['seatsavail'];
				print "<tr>";
				print '<form action="" method="post">';
				print "<td>".$reccinema." <input type='text' id='rcinemaid' name='rcinemaid' value=".$rcinemaid." style='display:none'></td>";
				print "<td>".$rtitl." <input type='text' id='rid' name='rid' value=".$rid." style='display:none'></td>";
				print "<td>".$rrating."</td>";
				print "<td>".$rshowtime." <input type='text' id='rshowdate' name='rshowdate' value=".$moviedate." style='display:none'></td>";
				if ($userlevel != 'guest') {
					print "<td>".$rtaken."</td>";
					print "<td>".$ravail."</td>";
				}	
				print '<td><input type="submit" value="Movie Info" name="DetailsButton"></td>';
				if ($userlevel != 'guest') {
					print '<td><input type="submit" value="Change" name="SubmitButton"> &nbsp;&nbsp; <input type="submit" value="Delete" name="DeleteButton"></td>';
				}
				print '</form>';
				print "</tr>";
  }
  if(isset($_POST['DetailsButton'])){
	//get movie info
	      $recid = $_POST['rid']; //get input text
		  $SQL = "SELECT * FROM movie where id = '".$recid."'";
          $result1 = mysqli_query($mysqli, $SQL);
		  $db_field = mysqli_fetch_assoc($result1);
		  $mtitl=$db_field['title'];
		  $mrating=$db_field['rating'];
		  $recdesc = $db_field['description'];
	
		  print '<div id="popup">';
		  print '<div>';
		  print '  <h2>Movie Details</h2>';
		  print '  <form>';
		  print '    <label>Title</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="mtitle" name="mtitle" value='.$mtitl.' readonly><br><br>';
		  print '    <label>Rating</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  print '    <input type="text" id="mrating" name="mrating" value='.$mrating.' readonly><br><br>';
		  print '    <label>Description</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  print '    <textarea id="mdesc" name="mdesc" rows="5" cols="25" readonly>'.$recdesc.'</textarea><br><br>';
		  print '    <img src="logo.png"><br><br><br>';
		  print '  </form>';
		  print '   <button onclick="closePopup()" class="myButton">Close</button>';
		  print '</div>';
		  print '</div>';
		  
		 echo '<script type="text/JavaScript">
					function closePopup() {
					  document.getElementById("popup").style.display = "none";
					}
			   </script>';
} 
//check if form was submitted (change)
if(isset($_POST['SubmitButton'])){
	//get showtime info from form and call maintenance screen
	$updmovid = $_POST['rid'];
	$updcineid = $_POST['rcinemaid'];
	$updshowdat = $_POST['rshowdate'];
	$SQL = "SELECT start_time,title,seatstaken,seatsavail FROM movie INNER JOIN cinema_time on movie.id=cinema_time.movie_id where cinema_id = '".$updcineid."' and movie_id = '".$updmovid."' and show_date = '".$updshowdat."'";
    $result2 = mysqli_query($mysqli, $SQL);
	$db_field = mysqli_fetch_assoc($result2);
	$updstrtim=$db_field['start_time'];
	$updrtitl=$db_field['title'];
	$updtaken=$db_field['seatstaken'];
	$updavail=$db_field['seatsavail'];
		
	print '<div id="updpopup">';
		  print '<div>';
		  print '  <h2>Maintain Cinema Time</h2><br>';  
		  print '  <form action="" method="post">';
		  print '    <label>Cinema</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="updcineid" name="updcineid" value='.$updcineid.' readonly style="background-color:#6699cc"><br><br>';
		  print '    <label>Movie</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="updmovid" name="updmovid" value='.$updmovid.' readonly style="display:none">';
          print '    <input type="text" id="updtitle" name="updtitle" value='.$updrtitl.' readonly style="background-color:#6699cc"> <br><br>';
		  print '    <label>Date</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="updshowdat" name="updshowdat" value='.$updshowdat.' readonly style="background-color:#6699cc"><br><br>';
		  print '    <label>Start Time</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="updstrtim" name="updstrtim" value='.$updstrtim.'><br>';
          print '    <h2>Seating</h2>'; 
		  print '    <label>Seats Sold</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp <input type="text" id="updtaken" name="updtaken" value='.$updtaken.'><br><br>';
		  print '    <label>Seats Available</label>&nbsp<input type="text" id="updavail" name="updavail" value='.$updavail.'><br><br>';
		  print '    <input type="submit" value="Change" name="UpdateButton" class="myButton"> &nbsp;&nbsp;';
		  print '    <button onclick="closeupdPopup()" class="myButton">Cancel</button>';
          print '  </form>';
		  print '</div>';
		  print '</div>';
		  
		 echo '<script type="text/JavaScript">
					function closeupdPopup() {
					  document.getElementById("updpopup").style.display = "none";
					}
			   </script>';
	
} 
?>
</div>

<?php
$mysqli->close();
?>



</body>
</html>