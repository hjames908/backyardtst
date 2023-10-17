<html>
<head>
<style>
body  {
      
}
</style>
</head>

<title></title>
<link rel=stylesheet type='text/css' href='mycss.css'></link>
<body>


<h1>BACKYARD CINEMA</h1
<br>
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
MOVIES
</p>

<?php

$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'byardtst'; //To be completed to connect to a database. The database must exist.
$port = 3306; //Default must be NULL to use default port
$mysqli = new mysqli('localhost', $user, $password, $database, $port);

$message = "";
if(isset($_POST['SubmitButton'])){ //check if form was submitted
  $recid = $_POST['rid']; //get input text
  $rectitl = $_POST['rtitl']; //get input text
  $recdesc = $_POST['rdesc']; //get input text
  $recrating = $_POST['rrating']; //get input text
  $recstart = date('Y-m-d',strtotime($_POST['start_date'])); //Set date value to Y-m-d format
  $recend = date('Y-m-d',strtotime($_POST['end_date'])); //Set date value to Y-m-d format
  //If no new rating selected use previous rating
  if ($recrating == '') {
	  $recrating = $_POST['oldrating'];
  }
  $SQL = "SELECT * FROM movie where id = '$recid'";
  $result1 = mysqli_query($mysqli, $SQL);
  if ($result1->num_rows == 0) {
      $message =  "Record not found for update";
  }
  else {
	  $SQL = "UPDATE movie SET title='".$rectitl."', description='".$recdesc."', rating='".$recrating."', start_date='".$recstart."', end_date='".$recend."' WHERE id = '".$recid."'";
      $result2 = mysqli_query($mysqli, $SQL);
	  $message =  "Record ".$recid." updated sucessfully";
  }
}

if(isset($_POST['CreateButton'])){ //check if form was submitted
  $arectitl = $_POST['adtitl']; //get input text
  $arecdesc = $_POST['addesc']; //get input text
  $arecrating = $_POST['adrating']; //get input text
  $arecstart = date('Y-m-d',strtotime($_POST['adstart_date'])); //Set date value to Y-m-d format
  $arecend = date('Y-m-d',strtotime($_POST['adend_date'])); //Set date value to Y-m-d format
  $SQL = "INSERT INTO movie (id, title, description, rating, start_date, end_date) VALUES ('','".$arectitl."', '".$arecdesc."', '".$arecrating."', '".$arecstart."', '".$arecend."')";
  $result2 = mysqli_query($mysqli, $SQL);
  $message =  "Record added sucessfully";
  
}

$SQL = "SELECT * FROM movie order by title";
$result = mysqli_query($mysqli, $SQL);

?>

<div>
<table class="products">
<tr>
<th>New Movie</th>
<th>Title</th>
<th>Description</th>
<th>Rating</th>
<th>Date Period</th>
<th>Submit</th>
</tr>
	<?php
          //allows addition of new record
		  print "<tr>";
			  print '<form action="" method="post">';
              print "<td><input type='text' id='adid' name='adid' size='3' maxlength='3' readonly style='background-color:#6699cc'></td>";
              print "<td><input type='text' id='adtitl' name='adtitl' size='40' maxlength='40' required></td>";
              print "<td><textarea id='addesc' name='addesc' rows='2' cols='50'></textarea></td>";
              print "<td>New Rating <select id='adrating' name='adrating'><option value=''></option><option value='PG-13'>PG-13</option><option value='PG-16'>PG-16</option></select></td>";
			  print '<td>Start Date <input type="date" id="adstart_date" name="adstart_date" required><br>';
			  print 'End Date &nbsp <input type="date" id="adend_date" name="adend_date" required></td>';
			  print '<td><input type="submit" value=" Create " name="CreateButton"></td>';
			  print '</form>';
            print "</tr>";
	?>
</table>
<table class="products">
<tr>
<th>Movie Num</th>
<th>Title</th>
<th>Description</th>
<th>Rating</th>
<th>Date Period</th>
<th>Submit</th>
</tr>
		<?php
          while ( $db_field = mysqli_fetch_assoc($result) ) {
			//if id blank or null  
			if (is_null($db_field['id']) || $db_field['id']=='') {  
			   $rid='N/A';
			}
			else {
			   $rid=$db_field['id'];	
			}
			$rtitl="'".$db_field['title']."'";
			//No need to put values for textareas in quotes
			$rdesc=$db_field['description'];
			//if rating blank or null
			if (is_null($db_field['rating']) || $db_field['rating']=='') {  
			   $rrating='Not_Rated';
			}
			else {
			   $rrating="'".$db_field['rating']."'";	
			}
            print "<tr>";
			  print '<form action="" method="post">';
              print "<td><input type='text' id='rid' name='rid' value=".$rid." size='3' maxlength='3' readonly style='background-color:#6699cc'></td>";
              print "<td><input type='text' id='rtitl' name='rtitl' value=".$rtitl." size='40' maxlength='40' required></td>";
              print "<td><textarea id='rdesc' name='rdesc' rows='2' cols='50'>".$rdesc."</textarea></td>";
              print "<td><input type='text' id='oldrating' name='oldrating' value=".$rrating." size='15' maxlength='15' readonly style='background-color:#6699cc'><br>";
			  print "New Rating <select id='rrating' name='rrating'><option value=''></option><option value='PG-13'>PG-13</option><option value='PG-16'>PG-16</option></select></td>";
              print '<td>Start Date <input type="date" id="start_date" name="start_date" value='.$db_field['start_date'].' required><br>';
			  print 'End Date &nbsp <input type="date" id="end_date" name="end_date" value='.$db_field['end_date'].' required></td>';
              print '<td><input type="submit" value="Change" name="SubmitButton"></td>';
			  print '</form>';
            print "</tr>";
		  }	
		?>	
</table>
</div>
<?php echo $message; ?>
<br><br>
<div>&copy; Backyard Cinema</div>

<?php
$mysqli->close();
?>
</body>
</html>