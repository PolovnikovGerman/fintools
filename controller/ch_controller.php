<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/ch_model.php');
include('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////


if(isset($_GET['whr_ch']) && !empty($_GET['whr_ch']) )
{
if($_GET['whr_ch'] == 'all')
unset($_SESSION['whr_ch']);
else
 $_SESSION['whr_ch']=$_GET['whr_ch'];
}


$vch_order= array();
if(isset($_GET['or']) && is_numeric($_GET['or']) )
{
$_SESSION['or'] = $_GET['or'];
$vch_order=get_vch_orders($_GET['or']);

}
else
$vch_order=get_vch_orders(22000);



$ch_att= chk_attach_files();

ob_end_flush();


?>