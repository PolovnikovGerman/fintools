<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/itemw_model.php');
$obj=new db();
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////

if($_POST['snc']=="Save & Close")
{
$item_data=array();
	if(empty($_POST['wid']))
		$itemw_data=insert_itemw();
	else 
		$itemw_data=edit_itemw($_POST['wid']);
	
	if(isset($_POST['inc']) && $_POST['inc']=='yes')
	{
		header("Location:../view/items_list.php?msg=".$itemw_data['error']."&&ic=".$_POST['ic']."&&tbl=".$_POST['tbl']);
	}
	else
	{
		unset($_POST);
		header("Location:../view/items_list.php?msg=".$itemw_data['error']);
	}

}

////////////////////////////***************************************** SAVE AND NEW ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND NEW ****************************************///////////////////////////////////
if($_POST['snn']=="Save & New")
{
	$item_dataw=array();
	if(empty($_POST['wid']))
		$itemw_data=insert_itemw();
	else 
		$itemw_data=edit_itemw($_POST['wid']);
	unset($_POST);
	
	header("Location:../view/items.php?msg=".$itemw_data['error']);

	
}
////////////////////////////***************************************** SAVE AND NEXT ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND NEXT ****************************************///////////////////////////////////

if($_POST['snn']=="Save & Next")
{
	
		$itemw_data=array();
		if(empty($_POST['wid']))
			$itemw_data=insert_itemw();
		else 
			$itemw_data=edit_itemw($_POST['wid']);
		

	
	$var1=$_POST['ic']; $var2=$_POST['tbl']; $var3=$_POST['sys_id']; $var4=$_POST['sys_name'];
	
	$next=db::get_next_inc($_POST['ic'],$_POST['tbl']); 
	
	 $next_name=db::get_next_inc_itemw($next); echo $next_name;
	 
	unset($_POST);
	
	if($next=='error' || $next_name == 'error')
	header("Location:../view/items_list.php?msg=error");
	else if($next=='end')
	header("Location:../view/items_list.php?ic=$var1&&tbl=$var2");
	else if($next != '')
	header("Location:../view/itemw.php?sys_id=".$next."&&sys_name=".$next_name."&&inc=yes&&ic=$var1&&tbl=$var2");

	
}
////////////////////////////***************************************** SAVE  ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE  ****************************************///////////////////////////////////
if($_POST['save']=="Save")
{
//call insert function in model class of vendors.
	$item_data=array();
	if(empty($_POST['wid']))
		$itemw_data=insert_itemw();
	else 
		$itemw_data=edit_itemw($_POST['wid']);
	
	if(isset($_POST['inc']) && $_POST['inc']=='yes')
	{	
		
		$inc_sysw_name=db::get_next_inc_itemw($_POST['sys_id']);
		header("Location:../view/itemw.php?sys_id=".$_POST['sys_id']."&&sys_name=$inc_sysw_name&&ic=".$_POST['ic']."&&tbl=".$_POST['tbl']."&&inc=yes");
	}
		
}
	


//retrieve all fields from database 


////////////////////////////***************************************** REVERT ****************************************///////////////////////////////////
////////////////////////////***************************************** REVERT ****************************************///////////////////////////////////
if($_POST['revert']=="Revert")
{
	if(!empty($_POST['wid']) && isset($_POST['inc']) && $_POST['inc']=='yes')
	{
		$inc_sysw_name=db::get_next_inc_itemw($_POST['sys_id']);
		header("Location:../view/itemw.php?sys_id=".$_POST['sys_id']."&&sys_name=$inc_sysw_name&&ic=".$_POST['ic']."&&tbl=".$_POST['tbl']."&&inc=yes");
	}
	else if(!empty($_POST['wid']))
	 	header("Location:../view/itemw.php?sys_id=".$_POST['wid']."&&sys_name=".$_POST['title']);	
	else
	{
	$itemw_data['error']="error";	
	$itemw_data['error_msg']="No Previous Saved Record Found. Cannot Revert";
	}
	
}
/////////////////////////////////******************************************edit_vendor.php fetching data*******************//////////////////////////////////////////////
/////////////////////////////////******************************************edit_vendor.php fetching data*******************//////////////////////////////////////////////
if(isset($_GET['sys_id']) && !empty($_GET['sys_id']))
{
	$itemw_data=array();
	if(exist_itemw($_GET['sys_id']))
		{
		$itemw_data=fetch_itemw($_GET['sys_id']);
		$itemw_data['title']=$_GET['sys_name'];
		}
	else
	{
		$itemw_data['is_id_fk']=$_GET['sys_id'];
		$itemw_data['title']=$_GET['sys_name'];
	}
	
}
//////////////////////////////////////////////////////******************** end of fetching data for edit_vendor.php*******************//////////////////////////////////
//////////////////////////////////////////////////////******************** end of fetching data for edit_vendor.php*******************//////////////////////////////////

ob_end_flush();


?>