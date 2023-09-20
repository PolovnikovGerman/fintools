<?php
ob_start();
session_start();
//if(!session_is_registered(myusername))
//header("location:../index.php");
if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
    header("location:../index.php");
}
include('../model/fl_model.php');
include('../includes/utility_functions.php');
// include('../includes/firephp.php');

$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
$ven_list = $obj->get_ven_list();
$item_code = $obj->get_item_list();

if(isset($_POST['newven_post'])){
if(!add_vendor()) echo "Error in Adding Vendor."; }




if(isset($_GET['whr']) && !empty($_GET['whr']) )
{
if($_GET['whr'] == 'all')
unset($_SESSION['whr']);
else
$_SESSION['whr']=$_GET['whr'];
}
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
$epo = get_PO($_GET['attid'],$_GET['chid']);
$po_hist = get_history($_GET['chid']);
}

ob_end_flush();


?>