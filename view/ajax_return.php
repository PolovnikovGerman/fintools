<?php
include_once ('../model/mysql.php');

$obj = new db();


if($_GET['q'] == 99)
{


$status=$_GET['st'];
$ven_key=$_GET['ven_id'];
$qry="insert into vendor_history values(null,$ven_key,'$status',now(),'".$_SESSION['screenname']."','no')";
$res=$obj->query($qry);

$history=db::read_vendor_history('vendor_history',$ven_key,'vendor_id');
$ret="<table cellpadding=\"1px\" cellspacing=\"0px\" width=\"100%\" border=\"0\">";
for($j=0;$j<sizeof($history['id']);$j++)
 { 
$ret.="<tr><td>&bull;".$history['msg'][$j]."</td></tr>";
$ret.="<tr><td align=\"right\" style=\"font-size:10px; color:black; font-family:Arial, Helvetica, sans-serif; font:arial; color:#0000ff; font-style:italic;\">--&nbsp;".$history['datetime'][$j]."&nbsp;&nbsp;&nbsp;".$history['time'][$j]."&nbsp;&nbsp;-".$history['userid'][$j]."</td></tr>";
 } 
$ret.="</table>";

echo $ret;
}
////////////////////////////////*********************** DELETING IMPRINT AREAS *************************************/////////////////////////////////////////////////
if($_GET['q'] == 28)
{
$qry="update iw_imprint set is_alive = 'no' where iw_impid =".$_GET['impid'];
if($obj->query($qry))
echo "<input type=\"file\" size=1  name=\"iw_impimg[]\" >";
else
echo "Error";
}
//////////////////////////////////*****************************UPDATE ITEMS************************************************////////////////////////////////////////


if($_GET['q'] == 97)
{


$status=$_GET['st'];
$ven_key=$_GET['ven_id'];
$qry="insert into is_history values(null,$ven_key,'$status',now(),'".$_SESSION['screenname']."','no')";
$res=$obj->query($qry);

$history=db::read_item_history('is_history',$ven_key,'is_id');
$ret="<table cellpadding=\"1px\" cellspacing=\"0px\" width=\"100%\" border=\"0\">";
for($j=0;$j<sizeof($history['id']);$j++)
 { 
$ret.="<tr><td>&bull;".$history['msg'][$j]."</td></tr>";
$ret.="<tr><td align=\"right\" style=\"font-size:10px; color:black; font-family:Arial, Helvetica, sans-serif; font:arial; color:#0000ff; font-style:italic;\">--&nbsp;".$history['datetime'][$j]."&nbsp;&nbsp;&nbsp;".$history['time'][$j]."&nbsp;&nbsp;-".$history['userid'][$j]."</td></tr>";
 } 
$ret.="</table>";

echo $ret;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_GET['q'] == 88)
{
$qry="select * from is_attach where isattach_id = ".$_GET['aaid'];
if($res=$obj->query($qry))
{
	$data_attach=$obj->fetch($res);
	$qry="delete from is_attach where isattach_id = ".$_GET['aaid'];
	if($res=$obj->query($qry))
		if(unlink($data_attach['isattach_name']))
		{
			echo "<div id=\"is_attach".$_GET['place']."\"><input type=\"file\" name=\"is_attach".$_GET['place']."\"></div>";
			
		}
		else
		echo "Error. Contact Admin";
}
else
echo "Error. Contact Admin";

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_GET['q'] == 77)
{
$qry="select * from iw_images where iw_imgid = ".$_GET['imgid'];
if($res=$obj->query($qry))
{
	$data_attach=$obj->fetch($res);
	$qry="delete from iw_images where iw_imgid = ".$_GET['imgid'];
	if($res=$obj->query($qry))
		if(unlink($data_attach['iw_imgname']))
		{
			echo "<input type=text name=iw_imagetitle[]>";
			
		}
		else
		echo "Error. Contact Admin";
}
else
echo "Error. Contact Admin";

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($_GET['q']==63)
{
$pos=$_GET['pos']-1;
$curr=$_GET['curr']-1;
$gr=$_GET['gr'];
$iid=$_GET['iid'];

$qry="select * from is_sections where sec_id = $gr";
$res=$obj->query($qry);
$new=$obj->fetch($res);
$old_order=array(); $new_order=array();
$old_order=unserialize($new['sec_items']);
$old=0;

	for($i=0;$i<sizeof($old_order);$i++)
	{
		if($i==$pos)
		{
		$new_order[]=$iid;
		}
		else
		{
			 if($old_order[$old]==$iid)
			{
				$old++;
				$new_order[]=$old_order[$old];
				$old++;
			}
			else 
			{
				$new_order[]=$old_order[$old];
				$old++;
			}
		}
	}


$qry="update is_sections set sec_items = '".serialize($new_order)."' where sec_id = $gr";
$res=$obj->query($qry);
if($res)
{
	$qry="select *  from is_sections where sec_id = $gr ";
 	$res=$obj->query($qry); 
	$data_sec=$obj->fetch($res);
	$db_sec=array();
	$db_sec_order=array();
	$db_sec_order=unserialize($data_sec['sec_items']); 
		if($data_sec['sec_items'] != NULL) 
		{
			$query_in = implode(",",$db_sec_order);
		echo	$qry="select * from is_info where is_id in (".$query_in.") ";
			$res=$obj->query($qry);
				while($sec = $obj->fetch($res))
				{
					$iid=$sec['is_id'];
					$itemid[$iid]=$sec['is_itemid'];
					$itemname[$iid]=$sec['is_title'];
				}
	
		}
		
		$disp="<table cellpadding=\"5px\" cellspacing=\"0px\" border=\"0\" style=\"margin:10px;background-color:#EAEAEA; border:1px #2D2D2D solid;\">";
for($i=0;$i<sizeof($itemname);$i++)
{
if($i==0) $disp.="<tr><td>&nbsp;</td><td>&nbsp;</td><td><b>ITEM ID</b></td><TD><B>TITLE</B></TD><td>Position</td></tr>";
$disp.="<tr><td>".($i+1)."<td><img src=\"../images/delete_item_icon.gif\"  onclick=\"remove_sec_item($db_sec_order[$i],".$_GET['section_id'].")\"></td><td><b>".$itemid[$db_sec_order[$i]]."</b></td><td>".$itemname[$db_sec_order[$i]]."</td>";
$disp.="<td><select name=moveto onchange=\"move_section(this.value,".($i+1).",$gr,$db_sec_order[$i])\" ><option value=0>--</option>";
for($j=1;$j<=sizeof($itemname);$j++)
	 $disp.="<option value=$j>$j</option>";


$disp.="</tr>";
if(sizeof($itemname) == 0) $disp.="<tr><td>NO ITEMS IN THIS SECTION.</TD></TR>";
}

$disp.="</table>";
	
echo $disp;
		
}
else
echo "Error! DB Transaction Failed.";


}

?>











