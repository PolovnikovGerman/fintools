<?php
ob_start();
session_start();
if(!$_SESSION['uid'])
header("location:../index.php");
include('../model/dev_model.php');
include_once('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////



ob_end_flush();


?>