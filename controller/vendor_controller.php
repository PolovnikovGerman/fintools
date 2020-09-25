<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/vendor_model.php');

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////

if($_POST['snc']=="Save & Close")
{
	$vendor_data=array();
	if(empty($_POST['id']))
	{
		$vendor_data=insert_vendor();
		$history=db::read_vendor_history('vendor_history',$vendor_data['v_id'],'vendor_id');
	}
	else
	{
		$vendor_data=edit_vendor($_POST['id']);
		$history=db::read_vendor_history('vendor_history',$vendor_data['v_id'],'vendor_id');
	}
	header("Location:../view/vendor_list.php?msg=".$vendor_data['error']);


}

////////////////////////////***************************************** SAVE AND NEW ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND NEW ****************************************///////////////////////////////////
if($_POST['snn']=="Save & New")
{
	$vendor_data=array();
	if(empty($_POST['id']))
	{
		$vendor_data=insert_vendor();
		$history=db::read_vendor_history('vendor_history',$vendor_data['v_id'],'vendor_id');
	}
	else
	{
	
		$vendor_data=edit_vendor($_POST['id']);
		$history=db::read_vendor_history('vendor_history',$vendor_data['v_id'],'vendor_id');
	}
	unset($_POST);
	
	header("Location:../view/vendors.php?msg=".$vendor_data['error']);

	
}

////////////////////////////***************************************** SAVE  ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE  ****************************************///////////////////////////////////
if($_POST['save']=="Save")
{
//call insert function in model class of vendors.
	$vendor_data=array();
	if(empty($_POST['id']))
	{
		$vendor_data=insert_vendor();
		$history=db::read_vendor_history('vendor_history',$vendor_data['v_id'],'vendor_id');
	}
	else
	{
	
		$vendor_data=edit_vendor($_POST['id']);
		$history=db::read_vendor_history('vendor_history',$vendor_data['v_id'],'vendor_id');
	}

//retrieve all fields from database 

}
////////////////////////////***************************************** REVERT ****************************************///////////////////////////////////
////////////////////////////***************************************** REVERT ****************************************///////////////////////////////////
if($_POST['revert']=="Revert")
{
	if(!empty($_POST['id']))
	 	header("Location:../view/edit_vendor.php?vendor_id=".$_POST['id']);	
		
	$vendor_data['error']="<div class=\"error\">No Previous Saved Record Found. Cannot Revert</div>";
	
}
/////////////////////////////////******************************************edit_vendor.php fetching data*******************//////////////////////////////////////////////
/////////////////////////////////******************************************edit_vendor.php fetching data*******************//////////////////////////////////////////////
if(isset($_GET['vendor_id']) && !empty($_GET['vendor_id']))
{
	$edit_vdata=fetch_vendor_data($_GET['vendor_id']);
	$history=db::read_vendor_history('vendor_history',$edit_vdata['v_id'],'vendor_id');
}
//////////////////////////////////////////////////////******************** end of fetching data for edit_vendor.php*******************//////////////////////////////////
//////////////////////////////////////////////////////******************** end of fetching data for edit_vendor.php*******************//////////////////////////////////
$obj=new db();
$qry="select * from vendor_info order by vendor_name ASC";
$res=$obj->query($qry);
while($data_v=$obj->fetch($res))
{

$vendor_list_id[]=$data_v['vendor_id'];
$vendor_list_name[]=$data_v['vendor_name'];
}
ob_end_flush();


?>