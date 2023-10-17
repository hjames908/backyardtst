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


<img src="logo.png" style="position: absolute; top: 10; left: 50;z-index:-1;">
<h1>BACKYARD CINEMA</h1>
<br><br>

<p style="color:orange;font-weight:bold">
LOGIN
</p>
<?php
$message = "Leave blank to sign in as guest";
$action = ""; 
if(isset($_POST['SubmitButton'])){ //check if form was submitted
  $authuser = strip_tags(trim($_POST['username'])); //get input text  
  $authpass = strip_tags(trim($_POST['password'])); //get input text
  
  $reslevel ='';
  if ($authuser == '') {
	  $reslevel = 'guest';
  } 	  
  
  $user = 'root';
  $password = ''; //To be completed if you have set a password to root
  $database = 'byardtst'; //To be completed to connect to a database. The database must exist.
  $port = 3306; //Default must be NULL to use default port
  $mysqli = new mysqli('localhost', $user, $password, $database, $port);
 
  //Initial method of sql query
  //$SQL = "SELECT username, password from user where username = '$authuser'";
  //$result = mysqli_query($mysqli, $SQL);
  
  //userlevel passed to main php to determine elements hidden/displayed
  
  if ($reslevel == 'guest') {
	  Header("Location: index.php?uxl=".$reslevel);
  }
  else {
 
  //Using parameterized query to prevent SQL Injection
  $stmt = mysqli_prepare($mysqli, "SELECT username,password,userlevel from user where username = ?");
  mysqli_stmt_bind_param($stmt, "s", $authuser);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $resusr,$respas,$reslevel);
  mysqli_stmt_fetch($stmt);
  
   if ($resusr == $authuser) {
	  if ($respas == $authpass) {
		  mysqli_stmt_close($stmt);
		  $mysqli->close();
		  header("location: index.php?uxl=".$reslevel);
      }
      else {
		  $message =  "Invalid Password";
		  mysqli_stmt_close($stmt);
		  $mysqli->close();
	  }
   }	  
   else {
		  $message =  "Invalid User";
		  mysqli_stmt_close($stmt);
		  $mysqli->close();
   }
   
  }
  
}    
?>
<br>
<form name=mainwindow action="" method="post">
<div style="margin-left:480px;padding:35px;width:350px;background-color:#6699cc;border:1px black ridge">
	<table cellspacing=8>
	<tr><td>
	<span>Username</span><br>
    <input type="text" id="username" name="username" size="40" placeholder="Enter Username..">
	</td></tr><tr><td>
    <span>Password</span><br>
    <input type="password" id="password" name="password" size="40" placeholder="Enter Password..">
    </td></tr><tr><td>
	<br>
    <input type="submit" value="Sign In" name="SubmitButton">
	</td></tr><tr><td>
	<?php echo $message; ?>
	</td></tr>
	</table>
</div>
</form>
<br><br>
<div>&copy; Backyard Cinema</div>



</body>
</html>