<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/items_model.php');
$obj=new db();
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////

if($_POST['snc']=="Save & Close")
{
	$item_data=array();
	if(!empty($_POST['is_itemid']) && empty($_POST['id']))
	{
		if(!db::is_present_itemid($_POST['is_itemid']))
		{
		
			$item_data=insert_items(); 
			$history=db::read_item_history('is_history',$item_data['is_id'],'is_id');
		}
		else
		{
			$item_data['error']="error";
			$item_data['error_msg']="Could not Process File. Duplicate Item Id - ".$_POST['is_itemid'];
			
		}
		
	}
	else if(!empty($_POST['id']))
	{

		$item_data=edit_items($_POST['id']);
		$history=db::read_item_history('is_history',$_POST['id'],'is_id');
	}
	
	if(isset($_POST['inc']) && $_POST['inc']=='yes')
	{
		header("Location:../view/items_list.php?msg=".$item_data['error']."&&ic=".$_POST['ic']."&&tbl=".$_POST['tbl']);
	}
	else
	header("Location:../view/items_list.php?msg=".$item_data['error']);


}

////////////////////////////***************************************** SAVE AND NEW ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND NEW ****************************************///////////////////////////////////
if($_POST['snn']=="Save & New")
{
	$item_data=array();
	if(!empty($_POST['is_itemid']) && empty($_POST['id']))
	{
		if(!db::is_present_itemid($_POST['is_itemid']))
		{
		
			$item_data=insert_items(); 
			$history=db::read_item_history('is_history',$item_data['is_id'],'is_id');
		}
		else
		{
			$item_data['error']="error";
			$item_data['error_msg']="Could not Process File. Duplicate Item Id - ".$_POST['is_itemid'];
			
		}
		
	}
	else if(!empty($_POST['id']))
	{

		$item_data=edit_items($_POST['id']);
		$history=db::read_item_history('is_history',$_POST['id'],'is_id');
	}
	unset($_POST);
	
	header("Location:../view/items.php?msg=".$item_data['error']);

	
}

////////////////////////////***************************************** SAVE AND NEXT****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND NEXT****************************************///////////////////////////////////
if($_POST['snn']=="Save & Next")
{
	echo "here";
		$item_data=edit_items($_POST['id']);
		$history=db::read_item_history('is_history',$_POST['id'],'is_id');
	
	$var1=$_POST['ic']; $var2=$_POST['tbl'];
	$next=db::get_next_inc($_POST['ic'],$_POST['tbl']); echo $next;
	unset($_POST);
	if($next=='error')
	header("Location:../view/items_list.php?msg=error");
	else if($next=='end')
	header("Location:../view/items_list.php?ic=$var1&&tbl=$var2");
	else if($next != '')
	header("Location:../view/edit_items.php?items_id=".$next."&&inc=yes&&ic=$var1&&tbl=$var2");

	
}
////////////////////////////***************************************** SAVE  ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE  ****************************************///////////////////////////////////
if($_POST['save']=="Save")
{
//call insert function in model class of vendors.
	$item_data=array();
	if(empty($_POST['id']))
	{
		if(!db::is_present_itemid($_POST['is_itemid']))
		{
		
			$item_data=insert_items(); 
			$history=db::read_item_history('is_history',$item_data['is_id'],'is_id');
		}
		else
		{
			$item_data['error']="error";
			$item_data['error_msg']="Could not Process File. Duplicate Item Id - ".$_POST['is_itemid'];
			
		}
		
	}
	else if(!empty($_POST['id']))
	{

		$item_data=edit_items($_POST['id']);
		$history=db::read_item_history('is_history',$_POST['id'],'is_id');
	}

}
	


//retrieve all fields from database 


////////////////////////////***************************************** REVERT ****************************************///////////////////////////////////
////////////////////////////***************************************** REVERT ****************************************///////////////////////////////////
if($_POST['revert']=="Revert")
{
	if(!empty($_POST['id']) && isset($_POST['inc']) && $_POST['inc']=='yes')
		header("Location:../view/edit_items.php?items_id=".$_POST['inc_code']."&&inc=yes&&ic=".$_POST['ic']."&&tbl=".$_POST['tbl']);
	else if(!empty($_POST['id']))
	 	header("Location:../view/edit_items.php?items_id=".$_POST['id']);	
		
	$vendor_data['error']="<div class=\"error\">No Previous Saved Record Found. Cannot Revert</div>";
	
}
/////////////////////////////////******************************************edit_vendor.php fetching data*******************//////////////////////////////////////////////
/////////////////////////////////******************************************edit_vendor.php fetching data*******************//////////////////////////////////////////////
if(isset($_GET['items_id']) && !empty($_GET['items_id']))
{
	$is_data=fetch_items_data($_GET['items_id']);
	$history=db::read_item_history('is_history',$_GET['items_id'],'is_id');
}
//////////////////////////////////////////////////////******************** end of fetching data for edit_vendor.php*******************//////////////////////////////////
//////////////////////////////////////////////////////******************** end of fetching data for edit_vendor.php*******************//////////////////////////////////
$items_id=array();
$obj=new db();
$qry="select * from is_info order by is_itemid ASC";
$res=$obj->query($qry);
while($data_v=$obj->fetch($res))
{

$items_id[]=$data_v['is_id'];
$items_list_id[]=$data_v['is_itemid'];
$items_list_name[]=$data_v['is_title'];
}

if(isset($_POST['create']) && !empty($_POST['sec_name']))
{
	$qry="insert into is_sections values(null, '".$_POST['sec_name']."','')";
	$res=$obj->query($qry);
}


$qry="select * from is_sections order by sec_name ASC";
$res=$obj->query($qry);
while($data_s=$obj->fetch($res))
{
$sec_id[]=$data_s['sec_id'];
$sec_name[]=$data_s['sec_name'];
}

if(!empty($_POST['section_save']) && !empty($_POST['secid']))
{
 $qry="select * from is_sections where sec_id = ".$_POST['secid'];
$res=$obj->query($qry);
$sec_data=$obj->fetch($res);
if($sec_data['sec_items']==NULL)
{
$qry="update is_sections set sec_items = '".serialize($_POST['chk'])."' where sec_id = ".$_POST['secid'];
$obj->query($qry);
}
else
{
$db_sec_item=array();
$db_sec_item=unserialize($sec_data['sec_items']);
if(!empty($db_sec_item))
$db_sec_item=array_unique(array_merge($db_sec_item,$_POST['chk'])); 
else
$db_sec_item=$_POST['chk'];
	$qry="update is_sections set sec_items = '".serialize($db_sec_item)."' where sec_id = ".$_POST['secid'];
	$obj->query($qry);
}
}


if(isset($_GET['section_id']) && !empty($_GET['section_id']))
{
$qry="select sec_name from is_sections where sec_id =".$_GET['section_id'];

$d=$obj->fetch($obj->query($qry));
$item_sec_name=$d['sec_name'];

 $qry="select *  from is_sections where sec_id =  ".$_GET['section_id'];
 $res=$obj->query($qry); 
$data_sec=$obj->fetch($res);
$db_sec=array();
$db_sec_order=unserialize($data_sec['sec_items']); 
if($data_sec['sec_items'] != NULL && !empty($db_sec_order)) 
{
$query_in = implode(",",$db_sec_order);

 
 $qry="select * from is_info where is_id in (".$query_in.") "; 
$res=$obj->query($qry);
	while($sec = $obj->fetch($res))
	{
	$iid=$sec['is_id'];
	$itemid[$iid]=$sec['is_itemid'];
	$itemname[$iid]=$sec['is_title'];
	
	}
	
}
}

if(!empty($_GET['ic']) && !empty($_GET['tbl']) )
{
if($_GET['tbl'] == 'is_info')
$qry="select * from ".$_GET['tbl']." where ".$_GET['ic']." = '' or ".$_GET['ic']." = null ";
else if($_GET['tbl'] == 'iw_info')
$qry="select * from is_info a, ".$_GET['tbl']." b where a.is_id = b.is_id_fk and b.".$_GET['ic']." = '' or ".$_GET['ic']." = null ";
else if($_GET['tbl'] == 'is_vendor')
$qry="select * from is_info a, ".$_GET['tbl']." b where a.is_id = b.is_id and b.".$_GET['ic']." = '' or ".$_GET['ic']." = null ";
else if($_GET['tbl'] == 'iw_imprint')
$qry="select * from is_info where is_id not in (select is_id_fk from iw_info a, iw_imprint b where a.iw_id = b.iw_id) ORDER BY is_itemid ASC ";

$res=$obj->query($qry);
while($inc = $obj->fetch($res))
{
$par[]=$inc['is_id'];
$par1[]=$inc['is_itemid'];
$par2[]=$inc['is_title'];
}
$inc_list=array();
$inc_list=serialize($par1);
}

ob_end_flush();


?>