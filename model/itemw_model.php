<?php  include('mysql.php');
		include('../controller/generic_functions.php'); ?>
 
<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************   INSERT VENDOR INFORMATION  *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function insert_itemw()
{

$key=array();
$key=$_POST;
$obj=new db();
//retrieving general info table vendor_info
$error_flag=0;
$itemw_data=array();
$itemw_data=$_POST;
//////////////////////////////////////////////////********************** INSERT INTO ITEMS INFO*****************************/////////////////////////////////////////
if(1)
{


$qry="insert into iw_info values(null,'".$_POST['is_id_fk']."','".$_POST['iw_search']."','".$_POST['iw_desp']."','".$_POST['iw_size']."','".$_POST['iw_page']."','".$_POST['iw_similar']."','".$_POST['iw_mtitle']."','".$_POST['iw_mwords']."','".$_POST['iw_mdesp']."')";
if(!$obj->query($qry)) $error_flag=1;
$last_id=mysql_insert_id();
$key['wid']=$last_id;
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////
////////////////////////////////////////////////////********************INSERT GENERAL QUANTITY PRICES*****************///////////////////////////////////////////////
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

}

////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////


	
	
////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////***************************IMAGES HERE**************************************************///////////
$img_title=array();
$img_title=$_POST['iw_imgtitle'];

for($i=0;$i<10;$i++)
{
	if($img_title[$i]=='') $img_title[$i]='No-Title'; 
	if($i == 0) $main='yes'; else $main = 'no';
	if(!empty($_FILES['iw_img']['name'][$i]))
	{
		
		$qry="insert into iw_images values(null, $last_id,'".$img_title[$i]."','','$main','yes')";
		if(!$obj->query($qry)) $error_flag=1;
		$attach1_id=mysql_insert_id();
		$ext=findexts($_FILES['iw_img']['name'][$i]);
		$d=substr(str_replace(" ","-",$img_title[$i]),0,10)."_".($i+1);
	
		$target="../docs/website_images/";
		$target.=$attach1_id."_image_SS-2203SS_".$d.".".$ext;
		if(move_uploaded_file($_FILES['iw_img']['tmp_name'][$i],$target))
		{
		$qry="update iw_images set iw_imgname = '$target' where iw_imgid = $attach1_id";
		if(!$obj->query($qry)) $error_flag=1;

		}
		$key['iw_imgname'.$i]="../docs/website_images/".substr($target,23);
		$key['iw_imgid'.$i]=$attach1_id;
		$key['iw_imgtitle'.$i]=$img_title[$i];
	}
}


////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////***************************IMPRINT LOCATIONS HERE**************************************************///////////
$imp_size=array();
$imp_loc=array();
$imp_size=$_POST['iw_impsize'];
$imp_loc=$_POST['iw_imploc'];

$qry="select is_itemid from is_info where is_id = ".$_POST['is_id_fk'];
$res=$obj->query($qry);
if($res) 
{
$dat=$obj->fetch($res);


for($i=0;$i<12;$i++)
{

	if(!empty($_FILES['iw_impimg']['name'][$i]))
	{
		
		$qry="insert into iw_imprint values(null, $last_id,'".$imp_loc[$i]."','".$imp_size[$i]."','','yes')";
		if(!$obj->query($qry)) $error_flag=1;
		$attach1_id=mysql_insert_id();
		$ext=findexts($_FILES['iw_impimg']['name'][$i]);
		$d=substr(str_replace(" ","-",$itemw_data['title']),0,10)."_".($i+1);
	
		$target="../docs/imprint_locations/";
		$target.=$attach1_id."_imploc_".$dat['is_itemid']."_".$d.".".$ext;
		if(move_uploaded_file($_FILES['iw_impimg']['tmp_name'][$i],$target))
		{
		$qry="update iw_imprint set iw_impimg = '$target' where iw_impid = $attach1_id";
		if(!$obj->query($qry)) $error_flag=1;

		}
		$key['iw_impimg'.$i]=substr($target,26);
		$key['iw_impid'.$i]=$attach1_id;
		$key['iw_imploc'.$i]=$imp_loc[$i];
		$key['iw_impsize'.$i]=$imp_size[$i];
	}
}

}//close of if
else
$error_flag = 1;

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
function edit_itemw($edit_itemw_id)
{
$key=array();
$key=$_POST;
$obj=new db();
$error_flag=0;

//////////////////////////////////////////////////********************** EDIT VENDOR INFO*****************************/////////////////////////////////////////
$qry="update iw_info set iw_search ='".$_POST['iw_search']."', iw_desp ='".$_POST['iw_desp']."', iw_size ='".$_POST['iw_size']."', iw_page ='".$_POST['iw_page']."', iw_similar ='".$_POST['iw_similar']."', iw_mtitle ='".$_POST['iw_mtitle']."', iw_mwords ='".$_POST['iw_mwords']."', iw_mdesp='".$_POST['iw_mdesp']."'  where iw_id = $edit_itemw_id";
if(!$obj->query($qry)) $error_flag=1;

$key['wid']=$edit_itemw_id;

$img_title=array();
$img_title=$_POST['iw_imgtitle'];


for($i=0;$i<10;$i++)
{
	
	if(!empty($_FILES['iw_img']['name'][$i]))
	{
		if($img_title[$i]=='') $img_title[$i]='No-Title'; 
		if($i == 0) $main='yes'; else $main = 'no';
	
		$qry="insert into iw_images values(null, $edit_itemw_id,'".$img_title[$i]."','','$main','yes')";
		if(!$obj->query($qry)) $error_flag=1;
		$attach1_id=mysql_insert_id();
		$ext=findexts($_FILES['iw_img']['name'][$i]);
		$d=substr(str_replace(" ","-",$img_title[$i]),0,10)."_".($i+1);
	
		$target="../docs/website_images/";
		$target.=$attach1_id."_image_SS-2203SS_".$d.".".$ext;
		if(move_uploaded_file($_FILES['iw_img']['tmp_name'][$i],$target))
		{
		$qry="update iw_images set iw_imgname = '$target' where iw_imgid = $attach1_id";
		if(!$obj->query($qry)) $error_flag=1;

		}
		//$key['iw_imgname'.$i]="../docs/website_images/".substr($target,23);
		//$key['iw_imgid'.$i]=$attach1_id;
		//$key['iw_imgtitle'.$i]=$img_title[$i];
	}

}



////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////***************************IMPRINT LOCATIONS HERE**************************************************///////////
$imp_size=array();
$imp_loc=array();
$imp_size=$_POST['iw_impsize'];
$imp_loc=$_POST['iw_imploc'];

$qry="select is_itemid from is_info where is_id = (select is_id_fk from iw_info where iw_id = $edit_itemw_id)";
$res=$obj->query($qry);
if($res) 
{
$dat=$obj->fetch($res);
$qry="select count(iw_id) as total from iw_imprint where iw_id = $edit_itemw_id";
$res=$obj->query($qry);
$c=$obj->fetch($res);
$tot=$c['total']+1;
for($i=0;$i<12;$i++)
{

	if(!empty($_FILES['iw_impimg']['name'][$i]))
	{
		
		$qry="insert into iw_imprint values(null, $edit_itemw_id,'".$imp_loc[$i]."','".$imp_size[$i]."','','yes')";
		if(!$obj->query($qry)) $error_flag=1;
		$attach1_id=mysql_insert_id();
		$ext=findexts($_FILES['iw_impimg']['name'][$i]);
		$d=substr(str_replace(" ","-",$_POST['title']),0,10)."_".($tot++);
	
		$target="../docs/imprint_locations/";
		$target.=$attach1_id."_imploc_".$dat['is_itemid']."_".$d.".".$ext;
		if(move_uploaded_file($_FILES['iw_impimg']['tmp_name'][$i],$target))
		{
		$qry="update iw_imprint set iw_impimg = '$target' where iw_impid = $attach1_id";
		if(!$obj->query($qry)) $error_flag=1;

		}
		$key['iw_impimg'.$i]=substr($target,26);
		$key['iw_impid'.$i]=$attach1_id;
		$key['iw_imploc'.$i]=$imp_loc[$i];
		$key['iw_impsize'.$i]=$imp_size[$i];
	}
}

}//close of if
else
$error_flag = 1;

////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////

$count=0;
 $qry="select * from iw_imprint where iw_id = $edit_itemw_id and is_alive = 'yes' ORDER BY iw_impid ASC";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['iw_impid'.$count]=$data['iw_impid'];
	$key['iw_imploc'.$count]=$data['iw_imploc'];
	$key['iw_impsize'.$count]=$data['iw_impsize'];
	$key['iw_impimg'.$count]=$data['iw_impimg'];
	$count++;
}

$count=0;
 $qry="select * from iw_images where iw_id = $edit_itemw_id ORDER BY iw_imgid ASC";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['iw_imgid'.$count]=$data['iw_imgid'];
	$key['iw_imgtitle'.$count]=$data['iw_imgtitle'];
	$key['iw_imgname'.$count]=$data['iw_imgname'];
	
	$count++;
}


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
///////////////////////////////////////////////////////////////CHECK IF ITEM-S EXISTS IN ITEM-W///////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function exist_itemw($var)
{
$obj=new db();
$qry="select * from iw_info where is_id_fk = $var";
$res=$obj->query($qry);
if($obj->numrow($res) == 1)
return 1;
else
return 0;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************    FETCH VENDOR INFORMATION  *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetch_itemw($fk)
{
$key=array();
$obj=new db();
$error_flag=0;
 $qry="select * from iw_info where is_id_fk = $fk";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['wid']=$data['iw_id'];
	$wid=$data['iw_id'];
	$key['is_id_fk']=$data['is_id_fk'];
	$key['iw_search']=$data['iw_search'];
	$key['iw_desp']=$data['iw_desp'];
	$key['iw_size']=$data['iw_size'];
	$key['iw_page']=$data['iw_page'];
	$key['iw_similar']=$data['iw_similar'];
	$key['iw_mtitle']=$data['iw_mtitle'];
	$key['iw_mwords']=$data['iw_mwords'];
	$key['iw_mdesp']=$data['iw_mdesp'];
}
$count=0;
 $qry="select * from iw_imprint where iw_id = $wid and is_alive = 'yes' ORDER BY iw_impid ASC ";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['iw_impid'.$count]=$data['iw_impid'];
	$key['iw_imploc'.$count]=$data['iw_imploc'];
	$key['iw_impsize'.$count]=$data['iw_impsize'];
	$key['iw_impimg'.$count]=$data['iw_impimg'];
	$count++;
}

$count=0;
 $qry="select * from iw_images where iw_id = $wid ORDER BY iw_imgid ASC";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
	$key['iw_imgid'.$count]=$data['iw_imgid'];
	$key['iw_imgtitle'.$count]=$data['iw_imgtitle'];
	$key['iw_imgname'.$count]=$data['iw_imgname'];
	
	$count++;
}

return $key;
}

?>