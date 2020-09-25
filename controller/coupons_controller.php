<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/coupons_model.php');
include('../includes/utility_functions.php');
$obj=new db();

if($_GET['portal'] == 'stressballs' || $_GET['portal'] == 'buttons')
	$portal = $_GET['portal'];
else
	$portal = 'stressballs';
$coup = getCoupons($portal);

//parr($coup);
ob_end_flush();
?>