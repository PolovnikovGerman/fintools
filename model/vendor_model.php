<?php  include('mysql.php');
		include('../controller/generic_functions.php'); ?>
 
<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************   INSERT VENDOR INFORMATION  *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function insert_vendor()
{

$key=array();
$obj=new db();
//retrieving general info table vendor_info
$error_flag=0;

//////////////////////////////////////////////////********************** INSERT INTO VENDOR INFO*****************************/////////////////////////////////////////
if(!empty($_POST['vname']))
{
$qry="insert into vendor_info values(null,'".$_POST['vgen']."','".$_POST['vname']."','".$_POST['vasi']."','".$_POST['vacc']."','".$_POST['vnick']."','".$_POST['vweb']."','".$_POST['vdesp']."','".$_POST['vtrans_alert']."','".$_POST['vsetup']."','".$_POST['vexprints']."','".$_POST['vothsetup']."','".$_POST['vothprints']."')";
if(!$obj->query($qry)) $error_flag=1;
$last_id=mysql_insert_id();
$key['v_id']=$last_id;
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

//////////////////////////////////////////////////********************** INSERT PAYMENT METHOD INFO*****************************/////////////////////////////////////////
$qry="insert into vendor_paymethod values(null,'$last_id','".$_POST['vm']."','".$_POST['amex']."','".$_POST['disc']."','".$_POST['paypal']."','".$_POST['check']."','".$_POST['wire']."')";
if(!$obj->query($qry)) $error_flag=1; 
}
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

//////////////////////////////////////////////////********************** INSERT INTO ADDRESS*****************************/////////////////////////////////////////
if(!empty($_POST['vadd1_title']) || !empty($_POST['vadd2_title']) || !empty($_POST['vadd3_title']))
{
	if($_POST['vadd_ship']==1)
		$ship1='yes';
	if($_POST['vadd_ship']==2)
		$ship2='yes';
	if($_POST['vadd_ship']==3)
		$ship3='yes';
		
	$qry="insert into vendor_address values";
		if(!empty($_POST['vadd1_title']))
			$qry.="(null, $last_id,'".$_POST['vadd1_title']."','".$_POST['vadd1_country']."','".$ship1."','".$_POST['vadd1_line1']."','".$_POST['vadd1_line2']."','".$_POST['vadd1_line3']."','".$_POST['vadd1_line4']."','".$_POST['vadd1_city']."','".$_POST['vadd1_state']."','".$_POST['vadd1_zip']."'),";
			if(!empty($_POST['vadd2_title']))
			$qry.="(null, $last_id,'".$_POST['vadd2_title']."','".$_POST['vadd2_country']."','".$ship2."','".$_POST['vadd2_line1']."','".$_POST['vadd2_line2']."','".$_POST['vadd2_line3']."','".$_POST['vadd2_line4']."','".$_POST['vadd2_city']."','".$_POST['vadd2_state']."','".$_POST['vadd2_zip']."'),";
			if(!empty($_POST['vadd3_title']))
			$qry.="(null, $last_id,'".$_POST['vadd3_title']."','".$_POST['vadd3_country']."','".$ship3."','".$_POST['vadd3_line1']."','".$_POST['vadd3_line2']."','".$_POST['vadd3_line3']."','".$_POST['vadd3_line4']."','".$_POST['vadd3_city']."','".$_POST['vadd3_state']."','".$_POST['vadd3_zip']."')";


if(substr($qry,-1) == ",")
	$qry=substr($qry,0,strlen($qry)-1);
	
if(!$obj->query($qry)) $error_flag=1;
}
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

//////////////////////////////////////////////////********************** INSERT INTO CONTACTS****************************/////////////////////////////////////////

	$i=1; $doquery=0;
	$qry="insert into vendor_contacts values";
	while(!empty($_POST['vcon'.$i.'_name']))
	{
		$key['contact_size']=$i;
		$qry.="(null,'$last_id','".$_POST['vcon'.$i.'_name']."','".$_POST['vcon'.$i.'_tel']."','".$_POST['vcon'.$i.'_fax']."','".$_POST['vcon'.$i.'_email']."','".$_POST['vcon'.$i.'_notes']."','".$_POST['vcon'.$i.'_poemail']."','".$_POST['vcon'.$i.'_pofax']."','".$_POST['vcon'.$i.'_artemail']."'),";
	$i++;
	$doquery=1;
	}
	if(substr($qry,-1) == ",")
	$qry=substr($qry,0,strlen($qry)-1);
	if($doquery)
	if(!$obj->query($qry)) $error_flag=1;
	
	
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////****************************ATTACHMENTS HERE**************************************************///////////
if(!empty($_FILES['vattach1']['name']))
{
	$qry="insert into vendor_attach values(null, $last_id, '".$_POST['vattach_desp1']."','".$_POST['vattach_date1']."',now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach1_id=mysql_insert_id();
	$ext=findexts($_FILES['vattach1']['name']);
	$d=substr(str_replace(" ","-",$_POST['vattach_desp1']),0,10);
	$target_date1=substr($_POST['vattach_date1'],0,5).substr($_POST['vattach_date1'],6,2);
	$target="../docs/vendor_attach/";
	$target.=$attach1_id."_vendreco_".$last_id."_".$target_date1."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['vattach1']['tmp_name'],$target))
	{
	$qry="update vendor_attach set vattach_name = '$target' where vattach_id = $attach1_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('vendor_history',$last_id,substr($target,22)." attached",$_SESSION['screenname'],'yes');
	}

	
}
if(!empty($_FILES['vattach2']['name']))
{
	$qry="insert into vendor_attach values(null, $last_id, '".$_POST['vattach_desp2']."','".$_POST['vattach_date2']."',now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach2_id=mysql_insert_id();
	$ext=findexts($_FILES['vattach2']['name']);
	$d=substr(str_replace(" ","-",$_POST['vattach_desp2']),0,10);
		$target_date2=substr($_POST['vattach_date2'],0,5).substr($_POST['vattach_date2'],6,2);
	$target="../docs/vendor_attach/";
	$target.=$attach2_id."_vendreco_".$last_id."_".$target_date2."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['vattach2']['tmp_name'],$target))
	{
	$qry="update vendor_attach set vattach_name = '$target' where vattach_id = $attach2_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('vendor_history',$last_id,substr($target,22)." attached",$_SESSION['screenname'],'yes');
	}
}

//////////////////////////////////////////////////********************** INSERT INTO VENDOR INFO*****************************/////////////////////////////////////////
if(!empty($_POST['vupdate']))
	db::write_to_vendor_history('vendor_history',$last_id,$_POST['vupdate'],$_SESSION['screenname'],'no');
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
if($error_flag==1)
$key['error']="error";
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
function edit_vendor($edit_vendor_id)
{
$key=array();
$obj=new db();
$error_flag=0;

//////////////////////////////////////////////////********************** EDIT VENDOR INFO*****************************/////////////////////////////////////////
$qry="update vendor_info set vendor_ginfo ='".$_POST['vgen']."', vendor_name ='".$_POST['vname']."', vendor_asi ='".$_POST['vasi']."', vendor_account ='".$_POST['vacc']."', vendor_nickname ='".$_POST['vnick']."', vendor_website ='".$_POST['vweb']."', vendor_desp='".$_POST['vdesp']."', vendor_transalert='".$_POST['vtrans_alert']."', vendor_setup='".$_POST['vsetup']."', vendor_exprints='".$_POST['vexprints']."', vendor_othsetup='".$_POST['vothsetup']."', vendor_othprints='".$_POST['vothprints']."' where vendor_id = $edit_vendor_id";
if(!$obj->query($qry)) $error_flag=1;

$key['v_id']=$edit_vendor_id;



//////////////////////////////////////////////////********************** EDIT PAYMENT METHOD INFO*****************************/////////////////////////////////////////
 $qry="update vendor_paymethod set pm_visamc='".$_POST['vm']."', pm_amex='".$_POST['amex']."', pm_disc='".$_POST['disc']."',pm_paypal='".$_POST['paypal']."', pm_check='".$_POST['check']."', pm_wire='".$_POST['wire']."' where vendor_id = $edit_vendor_id";
if(!$obj->query($qry)) $error_flag=1;



//////////////////////////////////////////////////********************** EDIT ADDRESS*****************************/////////////////////////////////////////
$qry="delete from vendor_address where vendor_id = $edit_vendor_id";
if(!$obj->query($qry)) $error_flag=1;

if(!empty($_POST['vadd1_title']) || !empty($_POST['vadd2_title']) || !empty($_POST['vadd3_title']))
{
	if($_POST['vadd_ship']==1)
		$ship1='yes';
	if($_POST['vadd_ship']==2)
		$ship2='yes';
	if($_POST['vadd_ship']==3)
		$ship3='yes';
		
	 $qry="insert into vendor_address values";
		if(!empty($_POST['vadd1_title']))
			$qry.="(null, $edit_vendor_id,'".$_POST['vadd1_title']."','".$_POST['vadd1_country']."','".$ship1."','".$_POST['vadd1_line1']."','".$_POST['vadd1_line2']."','".$_POST['vadd1_line3']."','".$_POST['vadd1_line4']."','".$_POST['vadd1_city']."','".$_POST['vadd1_state']."','".$_POST['vadd1_zip']."'),";
			if(!empty($_POST['vadd2_title']))
			$qry.="(null, $edit_vendor_id,'".$_POST['vadd2_title']."','".$_POST['vadd2_country']."','".$ship2."','".$_POST['vadd2_line1']."','".$_POST['vadd2_line2']."','".$_POST['vadd2_line3']."','".$_POST['vadd2_line4']."','".$_POST['vadd2_city']."','".$_POST['vadd2_state']."','".$_POST['vadd2_zip']."'),";
			if(!empty($_POST['vadd3_title']))
			$qry.="(null, $edit_vendor_id,'".$_POST['vadd3_title']."','".$_POST['vadd3_country']."','".$ship3."','".$_POST['vadd3_line1']."','".$_POST['vadd3_line2']."','".$_POST['vadd3_line3']."','".$_POST['vadd3_line4']."','".$_POST['vadd3_city']."','".$_POST['vadd3_state']."','".$_POST['vadd3_zip']."')";


if(substr($qry,-1) == ",")
	$qry=substr($qry,0,strlen($qry)-1);
	
if(!$obj->query($qry)) $error_flag=1;
}

//////////////////////////////////////////////////********************** INSERT INTO CONTACTS****************************/////////////////////////////////////////
$qry="delete from vendor_contacts where vendor_id = $edit_vendor_id";
if(!$obj->query($qry)) $error_flag=1;

	$i=1; $doquery=0;
	$qry="insert into vendor_contacts values";
	while(!empty($_POST['vcon'.$i.'_name']))
	{
		$key['contact_size']=$i;
		$qry.="(null,'$edit_vendor_id','".$_POST['vcon'.$i.'_name']."','".$_POST['vcon'.$i.'_tel']."','".$_POST['vcon'.$i.'_fax']."','".$_POST['vcon'.$i.'_email']."','".$_POST['vcon'.$i.'_notes']."','".$_POST['vcon'.$i.'_poemail']."','".$_POST['vcon'.$i.'_pofax']."','".$_POST['vcon'.$i.'_artemail']."'),";
	$i++;
	$doquery=1;
	}
	if(substr($qry,-1) == ",")
	$qry=substr($qry,0,strlen($qry)-1);
	if($doquery)
	if(!$obj->query($qry)) $error_flag=1;
	
		
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////****************************ATTACHMENTS HERE**************************************************///////////
if(!empty($_FILES['vattach1']['name']))
{
	$qry="insert into vendor_attach values(null, $edit_vendor_id, '".$_POST['vattach_desp1']."','".$_POST['vattach_date1']."',now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach1_id=mysql_insert_id();
	$ext=findexts($_FILES['vattach1']['name']);
	$d=substr(str_replace(" ","-",$_POST['vattach_desp1']),0,10);
	$target_date1=substr($_POST['vattach_date1'],0,5).substr($_POST['vattach_date1'],6,2);
	$target="../docs/vendor_attach/";
	$target.=$attach1_id."_vendreco_".$edit_vendor_id."_".$target_date1."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['vattach1']['tmp_name'],$target))
	{
	$qry="update vendor_attach set vattach_name = '$target' where vattach_id = $attach1_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('vendor_history',$edit_vendor_id,substr($target,22)." attached",$_SESSION['screenname'],'yes');
	}

	
}
if(!empty($_FILES['vattach2']['name']))
{
	$qry="insert into vendor_attach values(null, $edit_vendor_id, '".$_POST['vattach_desp2']."','".$_POST['vattach_date2']."',now(),'')";
	if(!$obj->query($qry)) $error_flag=1;
	$attach2_id=mysql_insert_id();
	$ext=findexts($_FILES['vattach2']['name']);
	$d=substr(str_replace(" ","-",$_POST['vattach_desp2']),0,10);
	$target_date2=substr($_POST['vattach_date2'],0,5).substr($_POST['vattach_date2'],6,2);
	$target="../docs/vendor_attach/";
	$target.=$attach2_id."_vendreco_".$edit_vendor_id."_".$target_date2."_".$d.".".$ext;
	if(move_uploaded_file($_FILES['vattach2']['tmp_name'],$target))
	{
	$qry="update vendor_attach set vattach_name = '$target' where vattach_id = $attach2_id";
	if(!$obj->query($qry)) $error_flag=1;
	db::write_to_vendor_history('vendor_history',$edit_vendor_id,substr($target,22)." attached",$_SESSION['screenname'],'yes');
	}
}

//////////////////////////////////////////////////********************** INSERT INTO VENDOR INFO*****************************/////////////////////////////////////////
if(!empty($_POST['vupdate']))
	db::write_to_vendor_history('vendor_history',$edit_vendor_id,$_POST['vupdate'],$_SESSION['screenname'],'no');
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
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
function fetch_vendor_data($fetch_vendor_id)
{
$key=array();
$obj=new db();
$error_flag=0;
$qry="select * from vendor_info where vendor_id = $fetch_vendor_id";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['v_id']=$data['vendor_id'];
	$key['vgen']=$data['vendor_ginfo'];
	$key['vname']=$data['vendor_name'];
	$key['vasi']=$data['vendor_asi'];
	$key['vacc']=$data['vendor_account'];
	$key['vnick']=$data['vendor_nickname'];
	$key['vweb']=$data['vendor_website'];
	$key['vdesp']=$data['vendor_desp'];
	$key['vtrans_alert']=$data['vendor_transalert'];
	$key['vsetup']=$data['vendor_setup'];
	$key['vexprints']=$data['vendor_exprints'];
	$key['othsetup']=$data['vendor_othsetup'];
	$key['vothprints']=$data['vendor_othprints'];
}

$qry="select * from vendor_paymethod where vendor_id = $fetch_vendor_id";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['vm']=$data['pm_visamc'];
	$key['amex']=$data['pm_amex'];
	$key['disc']=$data['pm_disc'];
	$key['paypal']=$data['pm_paypal'];
	$key['check']=$data['pm_check'];
	$key['wire']=$data['pm_wire'];
}

$qry="select * from vendor_address where vendor_id = $fetch_vendor_id order by add_id ASC";
$res=$obj->query($qry);
$count=1;
while($data = $obj->fetch($res))
{
	$key['vadd'.$count.'_title']=$data['add_title'];
	$key['vadd'.$count.'_country']=$data['add_country'];
	$key['vadd_ship']=($data['add_isship']=='yes')? $count : 0;
	$key['vadd'.$count.'_line1']=$data['add_line1'];
	$key['vadd'.$count.'_line2']=$data['add_line2'];
	$key['vadd'.$count.'_line3']=$data['add_line3'];
	$key['vadd'.$count.'_line4']=$data['add_line4'];
	$key['vadd'.$count.'_city']=$data['add_city'];
	$key['vadd'.$count.'_state']=$data['add_state'];
	$key['vadd'.$count.'_zip']=$data['add_zip'];

	$count++;
}

$qry="select * from vendor_contacts where vendor_id = $fetch_vendor_id order by cont_id ASC";
$res=$obj->query($qry);
$count=1; $key['contact_size']=$obj->numrow($res);
while($data = $obj->fetch($res))
{
	$key['vcon'.$count.'_name']=$data['cont_name'];
	$key['vcon'.$count.'_tel']=$data['cont_tel'];
	$key['vcon'.$count.'_fax']=$data['cont_fax'];
	$key['vcon'.$count.'_email']=$data['cont_email'];
	$key['vcon'.$count.'_notes']=$data['cont_notes'];
	$key['vcon'.$count.'_poemail']=$data['cont_emailpo'];
	$key['vcon'.$count.'_pofax']=$data['cont_faxpo'];
	$key['vcon'.$count.'_artemail']=$data['cont_emailart'];
	$count++;
}

return $key;
}

?>