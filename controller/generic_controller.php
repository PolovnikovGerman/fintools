<?php
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
require_once('../model/generic_model.php');
require_once('../includes/utility_functions.php');
$obj=new db();

if(isset($_GET['rev']) && is_numeric($_GET['chid']))
{
$reverse = 0;
$reverse = reverse_tempPO($_GET['chid']);
}
$epo=array();
if(isset($_GET['edit_PO']) && is_numeric($_GET['attid']) && is_numeric($_GET['chid']))
{

$epo = get_PO($_GET['attid'],$_GET['chid']);

}

$pageURL = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
if($pageURL == 'users.php')
{
	$users = array();
	$users = getUsers();

}

$pageURL = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
if($pageURL == 'amount_listing.php')
{
	$po = array();
	$po = poTotal();

}


$pageURL = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
if($pageURL == 'display_search.php')
{
	$disp_search = array();
	$disp_search = displaySearch();

}
ob_end_flush();

?>