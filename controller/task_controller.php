<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/task_model.php');
include('../includes/utility_functions.php');
$obj=new db();
if(!isset($_SESSION['status'])){
header("Location:../view/task.php?status=open");
$_SESSION['status'] = 'open';
}
if($_SESSION['status'] != 'closed' || !isset($_SESSION['status']))
$_SESSION['status'] = 'open';


if($_GET['status']=='open')
$_SESSION['status']='open';
if($_GET['status']=='closed')
$_SESSION['status']='closed';

if(isset($_POST['create_sec']))
{
	if(!empty($_POST['task_sec_name']))
	{
	$new_sec = create_task_section();
	if((int)$new_sec >0)
	header("Location:../view/task.php?tsec=".$new_sec."&cat=".$_POST['task_cat']);
	else
	header("Location:../view/task.php");
	}
}

if(isset($_POST['create_cat']))
{
	if(!empty($_POST['task_cat_name']))
	{
	$new_cat = create_task_category();
	if((int)$new_cat >0)
	header("Location:../view/task.php?cat=".$new_cat);
	else
	header("Location:../view/task.php");
	}
}

if(isset($_GET['tsec']))
{
$qry = "select * from task_section where section_id = ".$_GET['tsec'];
$res = $obj->query($qry);
$sec_name = $obj->fetch($res);
$sec = $sec_name['section_id'];
if(!isset($_GET['cat']) || empty($_GET['cat']) )
$cat=$_SESSION['uid'];
else
$cat=$_GET['cat'];

$disp2=display_active($sec,$cat);


}
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
$show=array();
$key=array();
$slider=array();
$cat_menu=array();
if(!isset($_GET['cat']) || empty($_GET['cat']) )
$cat=$_SESSION['uid'];
else
$cat=$_GET['cat'];



$live = ($_GET['tsec'] > 0 ) ? $_GET['tsec'] : 0;
$disp_all_tasks = display($_SESSION['uid'],$cat,$live);
$slider = slider($cat);
$cat_menu = cat_menu($_SESSION['uid']); 
ob_end_flush();


?>