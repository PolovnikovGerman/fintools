<?php
ob_start();
session_start();
include ("model/mysql.php");
//$host="localhost"; // Host name 
//$username="root"; // Mysql username 
//$password=""; // Mysql password 
//$db_name="vital_suits"; // Database name 
$tbl_name="client_info"; // Table name 

$obj=new db();



// Connect to server and select databse.
//mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
//mysql_select_db("$db_name")or die("cannot select DB");

// Define $myusername and $mypassword 
$myusername=$_POST['username']; 
$mypassword=$_POST['password']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = addslashes($myusername);
$mypassword = addslashes($mypassword);

 $sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=$obj->query($sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1)
{
	// Register $myusername, $mypassword and redirect to file "login_success.php"
	$info = mysqli_fetch_array($result);
	 $_SESSION['uid']=$info['user_id'];
 	$_SESSION['screenname']=$info['name'];

//	session_register("myusername");
//	session_register("mypassword"); 
	
	//echo $_SESSION['or']=$obj->get_start_point();
//	$_SESSION['or']=22000;
	$_SESSION['repID']=99;
	if($info['user_id'] == 1)
		  header("location:view/devControl.php");
	else if($info['user_id'] == 2)
		  header("location:view/fullfillment.php");
	else if($info['user_id'] == 10)
		  header("location:view/art.php");
	else
		  header("location:view/leads.php");
		
}
else 
{
header("Location:index.php?id=notLogin");
}

ob_end_flush();
?>

