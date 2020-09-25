<?php
ob_start();
session_start();
//if(!session_is_registered(myusername))
//header("location:../index.php");
include('../model/af2_model.php');
include('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////

$key=array();
if(isset($_GET['or']) && is_numeric($_GET['or']) )
{
$key = get_art($_GET['or']);

}
else
$key = get_art(1);


ob_end_flush();


?>