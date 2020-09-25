<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/webQuotes_model.php');
include_once('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////

$quotes = array();
$quotes = getQuotes();
//parr($quotes);

ob_end_flush();


?>