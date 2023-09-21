<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/brandBU_model.php');
include('../includes/utility_functions.php');
$obj=new db();


//if $_POST IS SET THEN FIRST UPDATE DATABASE WITH NEW ENTRANT OR EDIT

if(isset($_POST['BU_save']) && $_POST['BU_type'] == 'add' )
	$ret = putBUData();
	
if(isset($_POST['BU_save']) && $_POST['BU_type'] == 'edit')
	$ret = editBUData();
	
//FETCH DATA FROM DATABASE FOR DISPLAY IN UI
$brandBU = getBUData();


ob_end_flush();
?>