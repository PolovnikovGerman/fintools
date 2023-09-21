<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/leads_model.php');
include('../includes/utility_functions.php');

$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
if(!isset($_SESSION['leadSort']))
$_SESSION['leadSort'] = 'leadID';

if(isset($_GET['repID']) && !empty($_GET['repID']) )
{
	$_SESSION['repID']=$_GET['repID'];
	$_SESSION['leadPg']=0;
	$_SESSION['leadDCPg'] = 0;
	header("location:leads.php");
}
if(isset($_GET['DC']) ){
	$_SESSION['DC'] = $_GET['DC'];
	header("location:leads.php");
	}
if(isset($_GET['leadSort'])){
	$_SESSION['leadSort'] = $_GET['leadSort'];
	header("location:leads.php");
	}
if(isset($_GET['page']) && is_numeric($_GET['page']) )
{

	echo $_SESSION['leadPg'] = $_GET['page'];
	header("location:leads.php");
}
if(isset($_GET['pageDC']) && is_numeric($_GET['pageDC']) )
{
	$_SESSION['leadDCPg'] = $_GET['pageDC'];
	header("location:leads.php");
}


if($_SESSION['leadSort'] == 'leadType') $scheme = true; else $scheme = false;

	if($_SESSION['DC'] == 'yes')
	{
		$dispDCLead = getDCLeads();
		$cssOpen = "ld_table ld_shortOpen";
		$pageDC = getPages(3);
		$DC = true;
	}
	else
	{
	    $cssOpen = "ld_table ld_maxOpen";
		$DC = false;
		
	}

$page = getPages(1);

$dispLead = getLeads();
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

/*
if(isset($_GET['sort']) && !empty($_GET['sort']))
{
$_SESSION['sort']='DESC';
}
else
{
$_SESSION['sort']='ASC';
}
$key=array(); $att=array();
if(isset($_GET['or']) && is_numeric($_GET['or']) )
{
$_SESSION['or'] = $_GET['or'];
$key_c = get_child();
$att= chk_attach_files();
}
else
{
$key_c = get_child();
$att= chk_attach_files();

}



if(isset($_GET['rev']) && is_numeric($_GET['chid']))
{
$reverse = 0;
$reverse = delete_tempPO($_GET['chid']);
}
$epo=array();
if(isset($_GET['edit_PO']) && is_numeric($_GET['attid']) && is_numeric($_GET['chid']))
{
$po_hist = array();
$epo = get_PO($_GET['attid'],$_GET['chid']);
$po_hist = get_history($_GET['chid']);
//echo "<pre>";
//print_r($epo);
//echo "</pre>";
}

*/

ob_end_flush();


?>