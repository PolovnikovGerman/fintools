<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/brandSB_model.php');
require_once('../includes/utility_functions.php');
$obj=new db();
//temp();
//parr($_POST);
//parr($_FILES);
//if $_POST IS SET THEN FIRST UPDATE DATABASE WITH NEW ENTRANT OR EDIT

if(isset($_POST['SB_save']) && $_POST['SB_type'] == 'add' )
	putSBData();
	//error handling here later on.
	
if(isset($_POST['SB_save']) && $_POST['SB_type'] == 'edit')
	$ret = editSBData();
	
//FETCH DATA FROM DATABASE FOR DISPLAY IN UI


$brandSB = getSBData();
//parr($brandSB);
ob_end_flush();
?>