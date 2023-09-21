<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/revenue_model.php');
include('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
if(isset($_GET['rev']) && is_numeric($_GET['rev']) )
$_SESSION['rev'] = $_GET['rev'];

$revData = array();
$revData =getRevenueOrders();

ob_end_flush();


?>