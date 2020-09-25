<?php  include('mysql.php');
		include('../controller/generic_functions.php'); ?>
 
<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************   INSERT VENDOR INFORMATION  *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function insert_items()
{

$key=array();
$obj=new db();
//retrieving general info table vendor_info
$error_flag=0;

//////////////////////////////////////////////////********************** INSERT INTO ITEMS INFO*****************************/////////////////////////////////////////
if(!empty($_POST['is_title']))
{

$quantity=serialize($_POST['isp_quantity']);
$price=serialize($_POST['isp_price']);
$qry="insert into is_info values(null,'".$_POST['is_itemid']."','".$_POST['is_ginfo']."','".$_POST['is_title']."','".$_POST['is_type']."','".$_POST['is_type_detail']."','".$_POST['is_ship']."','".$_POST['is_trans']."','".$_POST['is_notes']."','".$_POST['is_yahoo']."', '$quantity' , '$price')";
if(!$obj->query($qry)) $error_flag=1;
$last_id=mysql_insert_id();
$key['is_id']=$last_id;
$key['quantity']=unserialize($quantity);
$key['price']=unserialize($price);



////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
////////////////////////////////////////////////////********************INSERT GENERAL QUANTITY PRICES*****************///////////////////////////////////////////////

////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

}

////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

//////////////////////////////////////////////////********************** INSERT ITEMS VENDORS*****************************/////////////////////////////////////////
if(!empty($_POST['isv_attribute1']) || !empty($_POST['isv_attribute2']) || !empty($_POST['isv_attribute3']))
{

			if(!empty($_POST['isv_attribute1']) && !empty($last_id))
			{
			$vendor_price1=serialize($_POST['isv_price1']);
			$qry="insert into is_vendor values(null, $last_id,'".$_POST['isv_attribute1']."','".$_POST['isv_buy1']."','".$_POST['isv_print1']."','".$_POST['isv_potitle1']."','".$_POST['isv_setup1']."','".$_POST['isv_exprints1']."','".$_POST['isv_poalert1']."','$vendor_price1')";
			if(!$obj->query($qry)) $error_flag=1;
			$key['vendor1']=unserialize($vendor_price1);
			}
			
			if(!empty($_POST['isv_attribute2']) && !empty($last_id))
			{
			$vendor_price2=serialize($_POST['isv_price2']);
			$qry="insert into is_vendor values(null, $last_id,'".$_POST['isv_attribute2']."','".$_POST['isv_buy2']."','".$_POST['isv_print2']."','".$_POST['isv_potitle2']."','".$_POST['isv_setup2']."','".$_POST['isv_exprints2']."','".$_POST['isv_poalert2']."','$vendor_price2')";
			if(!$obj->query($qry)) $error_flag=1;
			$key['vendor2']=unserialize($vendor_price2);
			}
			if(!empty($_POST['isv_attribute3']) && !empty($last_id))
			{
			$vendor_price3=serialize($_POST['isv_price3']);
			$qry="insert into is_vendor values(null, $last_id,'".$_POST['isv_attribute3']."','".$_POST['isv_buy3']."','".$_POST['isv_print3']."','".$_POST['isv_potitle3']."','".$_POST['isv_setup3']."','".$_POST['isv_exprints3']."','".$_POST['isv_poalert3']."','$vendor_price3')";
			if(!$obj->query($qry)) $error_flag=1;
			$key['vendor3']=unserialize($vendor_price3);
			}

}
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
////////////////////////////////////////////////////*******************INSERT INTO ITEMS COMPETITORS******************///////////////////////////////////////////////
if(!empty($_POST['isc_name1']) || !empty($_POST['isc_name2']) || !empty($_POST['isc_name3']))
{
		
			if(!empty($_POST['isc_name1']) && !empty($last_id))
			{
			$comp_price1=serialize($_POST['isc_price1']);
				$qry="insert into is_comp values(null, $last_id,'".$_POST['isc_name1']."','$comp_price1')";
				if(!$obj->query($qry)) $error_flag=1;
				
			$key['comp1']=unserialize($comp_price1);
				
			}
			if(!empty($_POST['isc_name2']) && !empty($last_id))
			{
			$comp_price2=serialize($_POST['isc_price2']);
				$qry="insert into is_comp values(null, $last_id,'".$_POST['isc_name2']."','$comp_price2')";
				if(!$obj->query($qry)) $error_flag=1;
				
			$key['comp2']=unserialize($comp_price2);
				
			}
			if(!empty($_POST['isc_name3']) && !empty($last_id))
			{
			$comp_price3=serialize($_POST['isc_price3']);
				$qry="insert into is_comp values(null, $last_id,'".$_POST['isc_name3']."','$comp_price3')";
				if(!$obj->query($qry)) $error_flag=1;
				
			$key['comp3']=unserialize($comp_price3);
			}
				
			
}
//////////////////////////////////////////////////********************** INSERT INTO PRICE****************************/////////////////////////////////////////

	
	
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////****************************ATTACHMENTS HERE**************************************************///////////
if(!empty($_FILES['is_attach1']['name']))
{
	$qry="insert into is_attach values(null, $last_id, now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach1_id=mysql_insert_id();
	$ext=findexts($_FILES['is_attach1']['name']);
	$d=substr(str_replace(" ","-",$_POST['is_title']),0,10)."_01";
	
	$target="../docs/imprint_templates/";
	$target.=$attach1_id."_imptemp_".$_POST['is_itemid']."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['is_attach1']['tmp_name'],$target))
	{
	$qry="update is_attach set isattach_name = '$target' where isattach_id = $attach1_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('is_history',$last_id,substr($target,26)." attached",$_SESSION['screenname'],'yes');
	}
	$key['is_attach1']=substr($target,26);
	$key['is_attach_id1']=$attach1_id;
	
}
if(!empty($_FILES['is_attach2']['name']))
{
	$qry="insert into is_attach values(null, $last_id, now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach2_id=mysql_insert_id();
	$ext=findexts($_FILES['is_attach2']['name']);
	$d=substr(str_replace(" ","-",$_POST['is_title']),0,10)."_02";
	
	$target="../docs/imprint_templates/";
	$target.=$attach2_id."_imptemp_".$_POST['is_itemid']."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['is_attach2']['tmp_name'],$target))
	{
	$qry="update is_attach set isattach_name = '$target' where isattach_id = $attach2_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('is_history',$last_id,substr($target,26)." attached",$_SESSION['screenname'],'yes');
	}

	$key['is_attach2']=substr($target,26);
	$key['is_attach_id2']=$attach2_id;
}
if(!empty($_FILES['is_attach3']['name']))
{
	$qry="insert into is_attach values(null, $last_id, now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach3_id=mysql_insert_id();
	$ext=findexts($_FILES['is_attach3']['name']);
	$d=substr(str_replace(" ","-",$_POST['is_title']),0,10)."_03";
	
	$target="../docs/imprint_templates/";
	$target.=$attach3_id."_imptemp_".$_POST['is_itemid']."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['is_attach3']['tmp_name'],$target))
	{
	$qry="update is_attach set isattach_name = '$target' where isattach_id = $attach3_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('is_history',$last_id,substr($target,26)." attached",$_SESSION['screenname'],'yes');
	}
	$key['is_attach3']=substr($target,26);
	$key['is_attach_id3']=$attach3_id;
	
}

//////////////////////////////////////////////////********************** INSERT INTO ITEM HISTORY*****************************/////////////////////////////////////////
if(!empty($_POST['is_update']))
	db::write_to_vendor_history('is_history',$last_id,$_POST['is_update'],$_SESSION['screenname'],'no');
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
if($error_flag==1)
{
$key['error']="error";
$key['error_msg']="Unable to Process File.";
}
else
$key['error']="success";

return $key;
}//closing of function 
///////////////////////////////////////////////////*****************************close insert vendor*********************//////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************    EDIT VENDOR INFORMATION  *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function edit_items($edit_items_id)
{
$key=array();
$obj=new db();
$error_flag=0;

//////////////////////////////////////////////////********************** EDIT VENDOR INFO*****************************/////////////////////////////////////////
$quantity=serialize($_POST['isp_quantity']);
$price=serialize($_POST['isp_price']);
$qry="update is_info set is_itemid ='".$_POST['is_itemid']."', is_ginfo ='".$_POST['is_ginfo']."', is_title ='".$_POST['is_title']."', is_type ='".$_POST['is_type']."', is_type_detail ='".$_POST['is_type_detail']."', is_ship ='".$_POST['is_ship']."', is_trans ='".$_POST['is_trans']."', is_notes='".$_POST['is_notes']."', is_yahoo='".$_POST['is_yahoo']."', is_quantity = '$quantity', is_price='$price'  where is_id = $edit_items_id";
if(!$obj->query($qry)) $error_flag=1;

$key['is_id']=$edit_items_id;
$key['quantity']=unserialize($quantity);
$key['price']=unserialize($price);

////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
////////////////////////////////////////////////////*******************EDIT INTO ITEMS COMPETITORS******************///////////////////////////////////////////////

$qry="delete from is_comp where is_id = $edit_items_id ";
if(!$obj->query($qry)) $error_flag=1;
else
{
	if(!empty($_POST['isc_name1']))
	{
		$comp1=serialize($_POST['isc_price1']);
				$qry="insert into is_comp values(null, $edit_items_id, ' ".$_POST['isc_name1']." ', '$comp1' )";
				if(!$obj->query($qry)) $error_flag=1;
				$key['comp1']=unserialize($comp1);
	}

	if(!empty($_POST['isc_name2']))	
	{
		$comp2=serialize($_POST['isc_price2']);
				$qry="insert into is_comp values(null, $edit_items_id, ' ".$_POST['isc_name2']." ', '$comp2' )";
				if(!$obj->query($qry)) $error_flag=1;
				$key['comp2']=unserialize($comp2);
	}

	if(!empty($_POST['isc_name3']))
	{
		$comp3=serialize($_POST['isc_price3']);
				$qry="insert into is_comp values(null, $edit_items_id, ' ".$_POST['isc_name3']." ', '$comp3' )";
				if(!$obj->query($qry)) $error_flag=1;
				$key['comp3']=unserialize($comp3);
	}
}
//////////////////////////////////////////////////********************** EDIT INTO PRICE****************************/////////////////////////////////////////
$qry="delete from is_vendor where is_id = $edit_items_id";
if(!$obj->query($qry)) $error_flag=1;


//////////////////////////////////////////////////********************** EDIT ITEMS VENDORS*****************************/////////////////////////////////////////
if(!empty($_POST['isv_attribute1']) || !empty($_POST['isv_attribute2']) || !empty($_POST['isv_attribute3']))
{

			if(!empty($_POST['isv_attribute1']) && !empty($edit_items_id))
			{
			$v_price1=serialize($_POST['isv_price1']);
			$qry="insert into is_vendor values(null, $edit_items_id,'".$_POST['isv_attribute1']."','".$_POST['isv_buy1']."','".$_POST['isv_print1']."','".$_POST['isv_potitle1']."','".$_POST['isv_setup1']."','".$_POST['isv_exprints1']."','".$_POST['isv_poalert1']."','$v_price1')";
			if(!$obj->query($qry)) $error_flag=1;
			
			$key['vendor1']=unserialize($v_price1);
			
			}
			
			if(!empty($_POST['isv_attribute2']) && !empty($edit_items_id))
			{
			$v_price2=serialize($_POST['isv_price2']);
			$qry="insert into is_vendor values(null, $edit_items_id,'".$_POST['isv_attribute2']."','".$_POST['isv_buy2']."','".$_POST['isv_print2']."','".$_POST['isv_potitle2']."','".$_POST['isv_setup2']."','".$_POST['isv_exprints2']."','".$_POST['isv_poalert2']."','$v_price2')";
			$last_isv = mysql_insert_id();
			if(!$obj->query($qry)) $error_flag=1;
			
			$key['vendor2']=unserialize($v_price2);
			}
			
			if(!empty($_POST['isv_attribute3']) && !empty($edit_items_id))
			{
			$v_price3=serialize($_POST['isv_price3']);
			$qry="insert into is_vendor values(null, $edit_items_id,'".$_POST['isv_attribute3']."','".$_POST['isv_buy3']."','".$_POST['isv_print3']."','".$_POST['isv_potitle3']."','".$_POST['isv_setup3']."','".$_POST['isv_exprints3']."','".$_POST['isv_poalert3']."','$v_price3')";
			$last_isv = mysql_insert_id();
			if(!$obj->query($qry)) $error_flag=1;
			
			$key['vendor3']=unserialize($v_price3);
			}

}
	
	
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////****************************ATTACHMENTS HERE**************************************************///////////
if(!empty($_FILES['is_attach1']['name']))
{
	$qry="insert into is_attach values(null, $edit_items_id, now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach1_id=mysql_insert_id();
	$ext=findexts($_FILES['is_attach1']['name']);
	$d=substr(str_replace(" ","-",$_POST['is_title']),0,10)."_01";
	
	$target="../docs/imprint_templates/";
	$target.=$attach1_id."_imptemp_".$_POST['is_itemid']."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['is_attach1']['tmp_name'],$target))
	{
	$qry="update is_attach set isattach_name = '$target' where isattach_id = $attach1_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('is_history',$edit_items_id,substr($target,26)." attached",$_SESSION['screenname'],'yes');
	}
	$key['is_attach1']=substr($target,26);
	$key['is_attach_id1']=$attach1_id;
	
}
if(!empty($_FILES['is_attach2']['name']))
{
	$qry="insert into is_attach values(null, $edit_items_id, now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach2_id=mysql_insert_id();
	$ext=findexts($_FILES['is_attach2']['name']);
	$d=substr(str_replace(" ","-",$_POST['is_title']),0,10)."_02";
	
	$target="../docs/imprint_templates/";
	$target.=$attach2_id."_imptemp_".$_POST['is_itemid']."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['is_attach2']['tmp_name'],$target))
	{
	$qry="update is_attach set isattach_name = '$target' where isattach_id = $attach2_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('is_history',$edit_items_id,substr($target,26)." attached",$_SESSION['screenname'],'yes');
	}

	$key['is_attach2']=substr($target,26);
	$key['is_attach_id2']=$attach2_id;
}
if(!empty($_FILES['is_attach3']['name']))
{
	$qry="insert into is_attach values(null, $edit_items_id, now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach3_id=mysql_insert_id();
	$ext=findexts($_FILES['is_attach3']['name']);
	$d=substr(str_replace(" ","-",$_POST['is_title']),0,10)."_03";
	
	$target="../docs/imprint_templates/";
	$target.=$attach3_id."_imptemp_".$_POST['is_itemid']."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['is_attach3']['tmp_name'],$target))
	{
	$qry="update is_attach set isattach_name = '$target' where isattach_id = $attach3_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('is_history',$edit_items_id,substr($target,26)." attached",$_SESSION['screenname'],'yes');
	}
	$key['is_attach3']=substr($target,26);
	$key['is_attach_id3']=$attach3_id;
	
}

if(!empty($_POST['is_update']))
	db::write_to_vendor_history('is_history',$edit_items_id,$_POST['is_update'],$_SESSION['screenname'],'no');
	
$qry="select * from is_attach where is_id = $edit_items_id";
$res=$obj->query($qry);
$count=1;
while($data = $obj->fetch($res))
{
	$key['is_attach_id'.$count]=$data['isattach_id'];
	$key['is_attach'.$count]=substr($data['isattach_name'],26);
	$count++;

}

////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////	

//////////////////////////////////////////////////********************** EDIT ADDRESS*****************************/////////////////////////////////////////
if($error_flag==1)
$key['error']="error";
else
$key['error']="success";
return $key;
	
///////////////////////////////////////////////////*****************************close  edit  vendor*********************//////////////////////////////////////////////////
return $key;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************    FETCH VENDOR INFORMATION  *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetch_items_data($fetch_items_id)
{
$key=array();
$obj=new db();
$error_flag=0;
$qry="select * from is_info where is_id = $fetch_items_id";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['is_id']=$data['is_id'];
	$key['is_itemid']=$data['is_itemid'];
	$key['is_ginfo']=$data['is_ginfo'];
	$key['is_title']=$data['is_title'];
	$key['is_type']=$data['is_type'];
	$key['is_type_detail']=$data['is_type_detail'];
	$key['is_ship']=$data['is_ship'];
	$key['is_trans']=$data['is_trans'];
	$key['is_notes']=$data['is_notes'];
	$key['is_yahoo']=$data['is_yahoo'];
	$key['quantity']=unserialize($data['is_quantity']);
	$key['price']=unserialize($data['is_price']);;

}

$qry="select * from is_vendor where is_id = $fetch_items_id ";
$res=$obj->query($qry);
$count=1; 
while($data = $obj->fetch($res))
{
	
	$key['isv_attribute'.$count]=$data['isv_attribute'];
	$key['isv_buy'.$count]=$data['isv_buy'];
	$key['isv_print'.$count]=$data['isv_print'];
	$key['isv_potitle'.$count]=$data['isv_potitle'];
	$key['isv_setup'.$count]=$data['isv_setup'];
	$key['isv_exprints'.$count]=$data['isv_exprints'];
	$key['isv_poalert'.$count]=$data['isv_poalert'];
	$key['vendor'.$count]=unserialize($data['isv_price']);
	$count++;
}

$qry="select * from is_comp where is_id = $fetch_items_id";
$res=$obj->query($qry);
$count=1;
while($data = $obj->fetch($res))
{
	$key['isc_name'.$count]=$data['isc_name'];
	$key['comp'.$count]=unserialize($data['isc_price']);
	$count++;
}

$qry="select * from is_attach where is_id = $fetch_items_id";
$res=$obj->query($qry);
$count=1;
while($data = $obj->fetch($res))
{
	$key['is_attach_id'.$count]=$data['isattach_id'];
	$key['is_attach'.$count]=substr($data['isattach_name'],26);
	$count++;

}

return $key;
}

?>