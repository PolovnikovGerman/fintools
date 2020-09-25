<?php
ob_start();
session_start();
if(!session_is_registered(myusername) || $_SESSION['uid'] == 11 || $_SESSION['uid'] == 12)
header("location:../index.php");
include('../model/report_model.php');
include('../includes/utility_functions.php');
$obj=new db();


if(isset($_GET['prOrdNum']) && is_numeric($_GET['prOrdNum']) )
$_SESSION['prOrdNum'] = $_GET['prOrdNum'];


$pageURL = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

if($pageURL == 'reportOrders.php')
$prOrder = getProfitByOrder();
else
$prDate = getProfitByDate();
//parr($prDate);
ob_end_flush();




?>