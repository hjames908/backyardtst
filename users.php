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
USERS
</p>

<?php

$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'byardtst'; //To be completed to connect to a database. The database must exist.
$port = 3306; //Default must be NULL to use default port
$mysqli = new mysqli('localhost', $user, $password, $database, $port);

    

//check if form was submitted (change)
if(isset($_POST['UpdateButton'])){      
	$updusername = $_POST['updusername'];
	$updfname = $_POST['updfname'];
	$updlname = $_POST['updlname'];
	$updpass=$_POST['updpass'];
	$updlevel=$_POST['updlevel'];
	$SQL = "UPDATE user SET firstname='".$updfname."', lastname='".$updlname."', password='".$updpass."', userlevel='".$updlevel."', WHERE username = '".$updusername."'";
    $result2 = mysqli_query($mysqli, $SQL);
}

if(isset($_POST['DeleteButton'])){
	
}	


//select users 
$SQL = "SELECT * FROM user order by userlevel,lastname";
$result = mysqli_query($mysqli, $SQL);
	

?>


<div>

<?php
	//display users by level then by name
  $userlev='';
  while ( $db_field = mysqli_fetch_assoc($result) ) {
     $userlevel=$db_field['userlevel'];	
	 //New table for each show date
     if ($userlevel != $userlev) {	 
	    //print end of table if change in userlevel and previous show date info printed
		if ($userlev != '') {			
			print '</table><br>';
		}
		//Assign new userlevel for display
		$userlev=$userlevel;
				
        //print table header		
		print '<table class="products">';
		print '<tr>';
		print '<th>User</th>';
		print '<th>First Name</th>';
		print '<th>Last Name</th>';
		print '<th>Password</th>';
		print '<th>User Level</th>';
		print '<th>Action</th>';
		print '</tr>';
	 }
				//print user
				$rusername=$db_field['username'];
				$rfname=$db_field['firstname'];
				$rpass=$db_field['password'];
				$rlname=$db_field['lastname'];	
				$rlevel=$db_field['userlevel'];
				print "<tr>";
				print '<form action="" method="post">';
				print "<td>".$rusername." <input type='text' id='rusername' name='rusername' value=".$rusername." style='display:none'></td>";
				print "<td>".$rfname." <input type='text' id='rfname' name='rfname' value=".$rfname." style='display:none'></td>";
				print "<td>".$rlname." <input type='text' id='rlname' name='rlname' value=".$rlname." style='display:none'></td>";
				print "<td> ******* <input type='text' id='rpass' name='rpass' value=".$rpass." style='display:none'></td>";
				print "<td>".$rlevel." <input type='text' id='rlevel' name='rlevel' value=".$rlevel." style='display:none'></td>";
				print '<td><input type="submit" value="Change" name="SubmitButton"> &nbsp;&nbsp; <input type="submit" value="Delete" name="DeleteButton"></td>';
				print '</form>';
				print "</tr>";
  }
 
//check if form was submitted (change)
if(isset($_POST['SubmitButton'])){
	//get showtime info from form and call maintenance screen
	$updusername = $_POST['rusername'];
	$updfname = $_POST['rfname'];
	$updlname = $_POST['rlname'];
	$updpass=$_POST['rpass'];
	$updlevel=$_POST['rlevel'];
		
	print '<div id="updpopup">';
		  print '<div>';
		  print '  <h2>Maintain User</h2><br>';  
		  print '  <form action="" method="post">';
		  print '    <label>User Name</label> &nbsp;&nbsp';
		  print '    <input type="text" id="updusername" name="updusername" value='.$updusername.' size=30 readonly style="background-color:#6699cc"><br><br>';
		  print '    <label>First Name</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="updfname" name="updfname" value='.$updfname.'> <br><br>';
          print '    <label>Last Name</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="text" id="updlname" name="updlname" value='.$updlname.'> <br><br>';
		  print '    <label>Password</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <input type="password" id="updpass" name="updpass" value='.$updpass.'><br><br>';
		  print '    <label>User Level</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
		  print '    <select id="updlevel" name="updlevel"><option value="'.$updlevel.'" selected>'.$updlevel.'</option><option value="admin">admin</option><option value="supervisor">supervisor</option></select><br><br><br><br>';
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