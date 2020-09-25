<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/fl_model.php');
include('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
if(isset($_POST['ffitems_post'])){
if(!add_item()) echo "Error in Adding Item."; }

$items = array();
$items = get_items();
//echo "<pre>";
//print_r($epo);
//echo "</pre>";



ob_end_flush();


?>