<?php 
session_start();
if(!session_is_registered(myusername)){
//if($_SESSION['uid']!=1) {
header("location:../index.php");
}
?>

