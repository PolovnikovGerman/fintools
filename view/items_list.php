<?php include('../controller/items_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>

<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>Items - Bluetrack Inc</title>
</head>
<body onload="hide_modules()"  >
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>



<?php
	if($_GET['msg']=='error')
		echo "<div class=\"error\">Unable to Process File.</div>";
	else if($_GET['msg']=='success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
	?>
 <div class="content">
 <div class="incomplete_menu" >
 <table cellspacing="5px" width="100%">
 <tr>
 <td><a href="items_list.php">All Items</a></td>
 <td><a href="items_list.php?ic=is_itemid&&tbl=is_info">Item#</a></td>
 <td><a href="items_list.php?ic=is_title&&tbl=is_info">Title</a></td>
 <td><a href="items_list.php?ic=is_ginfo&&tbl=is_info">Active</a></td>
 <td><a href="items_list.php?ic=is_ship&&tbl=is_info">Ship Class</a></td>
 <td><a href="items_list.php?ic=is_type&&tbl=is_info">Restricted</a></td>
 <td><a href="items_list.php?ic=is_price&&tbl=is_info">Price</a></td>
 <td><a href="items_list.php?ic=isv_attribute&&tbl=is_vendor">Color</a></td>
 <td><a href="items_list.php?ic=isv_buy&&tbl=is_vendor">Buy Vend</a></td>
 <td><a href="items_list.php?ic=isv_print&&tbl=isv_vendor">Print Vend</a></td>
 <td><a href="items_list.php?ic=isv_setup&&tbl=isv_vendor">Setup</a></td>
 <td><a href="items_list.php?ic=isv_exprints&&tbl=isv_vendor">Ex Prints</a></td>
 <td><a href="items_list.php?ic=isv_price&&tbl=isv_vendor">Vend Price</a></td>
 <td>Temp</td>
 <td><a href="items_list.php?ic=iw_search&&tbl=iw_info">Search</a></td>
 <td><a href="items_list.php?ic=iw_desp&&tbl=iw_info">Desc</a></td>
 <td><a href="items_list.php?ic=iw_size&&tbl=iw_info">Size</a></td>
 <td>Image</td>
 <td><a href="items_list.php?ic=iw_id&&tbl=iw_imprint">Imp Area</a></td>
 <td><a href="items_list.php?ic=iw_mwords&&tbl=iw_info">Meta</a></td>
 </tr>
 </table>
 <div class="incomplete_list">
 <?php 
 if(isset($_GET['ic']) )
 {
 ?>
 <?php
 if(isset($_GET['ic']))
 {
 	switch($_GET['ic']){
	case 'is_title': echo "<b>Incomplete Attribute : <span id=inc_heading>Item Name</span>";
					break;
	case 'is_ginfo': echo "<b>Incomplete Attribute : <span id=inc_heading>Active/Inactive</span>";
					break;
	case 'is_ship': echo "<b>Incomplete Attribute : <span id=inc_heading>Shipping</span>";
					break;
	case 'is_type': echo "<b>Incomplete Attribute : <span id=inc_heading>Open/Restricted</span>";
					break;
	case 'is_price': echo "<b>Incomplete Attribute : <span id=inc_heading>Item Price</span>";
					break;
	case 'isv_attribute': echo "<b>Incomplete Attribute : <span id=inc_heading>Vendor Color</span>";
					break;
	case 'isv_buy': echo "<b>Incomplete Attribute : <span id=inc_heading>Vendor Buyer</span>";
					break;
	case 'isv_print': echo "<b>Incomplete Attribute : <span id=inc_heading>Vendor Printer</span>";
					break;
	case 'isv_setup': echo "<b>Incomplete Attribute : <span id=inc_heading>Vendor Setup</span>";
					break;
	case 'isv_exprints': echo "<b>Incomplete Attribute : <span id=inc_heading>Vendor Exprints</span>";
					break;
	case 'isv_price': echo "<b>Incomplete Attribute : <span id=inc_heading>Vendor Price</span>";
					break;
					
	case 'iw_search': echo "<b>Incomplete Attribute : <span id=inc_heading>Item Search terms</span>";
					break;
	case 'iw_desp': echo "<b>Incomplete Attribute : <span id=inc_heading>Item description</span>";
					break;
	case 'iw_size': echo "<b>Incomplete Attribute : <span id=inc_heading>Item Size</span>";
					break;
					
	case 'iw_id': echo "<b>Incomplete Attribute : <span id=inc_heading>Imprint Areas (website)</span>";
					break;
	case 'iw_mwords': echo "<b>Incomplete Attribute : <span id=inc_heading>Meta Info</span>";
					break;
	default : echo "unknown attribute";
					
					
	}
	
 }
 ?>
 <table cellspacing="5px"  style="font-size:10px;"><tr>
 <?php
 if(sizeof($par1)>11){
 	$sz="11"; $tot=sizeof($par1);}
	else{
	$sz=sizeof($par1); $tot=sizeof($par1);}
 for($i=0;$i<$sz;$i++)
 {
 if(substr($_GET['tbl'],0,2) == 'iw')
 echo "<td style=\"font-size:10px;\">&nbsp;<a href=\"itemw.php?sys_id=$par[$i]&&sys_name=$par2[$i]&&inc=yes&&ic=".$_GET['ic']."&&tbl=".$_GET['tbl']."\">$par1[$i]</a>&nbsp;&nbsp;|&nbsp;&nbsp;$par2[$i]</td>";
 else
 echo "<td style=\"font-size:10px;\">&nbsp;<a href=\"edit_items.php?items_id=$par[$i]&&inc=yes&&ic=".$_GET['ic']."&&tbl=".$_GET['tbl']."\">$par1[$i]</a>&nbsp;&nbsp;|&nbsp;&nbsp;$par2[$i]</td>";
 if(($i+1)==$sz)
 echo "<td style=\"background-color:#2d2d2d; color:#ffff00;\" ><i><b>................</b>displaying</i> <b>".$sz." of ".$tot."</b></td>";
 if(($i+1)%4 == 0)
 echo "</tr><tr>";
 }
 echo "</tr></table>";
 if(!$par1)
 echo "No Incomplete Items Present.";
 }
 ?>
 </div>
 

 </div>
 <div class="clear"></div>

<div class="section_pillar_wrap" >
<div class="subhead">
<div style="float:left;">Complete Item List:&nbsp;&nbsp;</div><div style="float:right"><a href="items.php"><img src="../images/add_item.gif" /></a></div>
<div class="clear"></div>
</div>
<div class="section_itemlist">


<form action="items_list.php?section_id=<?php echo $_GET['section_id']; ?>&&bg=<?php echo $_GET['bg']; ?>" name="add_section" onsubmit="return valid_ckbox()" method="post">
<div class="active_inactive">
<span style="color:#0000ff; font-size:13px"><b>Show:</b></span>
<span id="show_style">All Items</span>
<span id="show_style">Active Items</span>
<span id="show_style">Inactive Items</span>
</div>
<table cellpadding="5px" cellspacing="0px" border="0" class="items_list_table">

<?php
for($i=0;$i<sizeof($items_list_id);$i++)
{
if(($i+1) % 2 ==0)
echo "<tr ><td><input type=checkbox name=chk[] value=$items_id[$i]></td><td><b>$items_list_id[$i]</b></td><td><a href=\"edit_items.php?items_id=".$items_id[$i]."\">$items_list_name[$i]</a></td></tr>";
else
echo "<tr bgcolor=#eaeaea><td><input type=checkbox name=chk[] value=$items_id[$i]></td><td><b>$items_list_id[$i]</b></td><td><a href=\"edit_items.php?items_id=".$items_id[$i]."\">$items_list_name[$i]</a></td></tr>";

}
?>
</table>
</div>
</div>

<div class="section_pillar_wrap">
<div class="subhead">
<div style="float:left;">Section List:&nbsp;&nbsp;</div><div style="float:right"><span onclick="addsection()" style="cursor:pointer; color:#47B855;"><img src="../images/add_section.gif" onclick="" /></span></div>
<div class="clear"></div>
<div style="margin:5px 0px 0px 110px;"><?php if(!empty($_GET['section_id'])) echo "<input type=\"submit\" name=\"section_save\" id=\"insert\" value=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; />"; else echo "&nbsp;"; ?></div>
</div>

<div class="section_itemlist_center">


<table cellpadding="5px" cellspacing="0" border="0" width="100%" class="items_list_table" style="margin-right:0px; padding-right:0px;">


<?php 
for($i=0;$i<sizeof($sec_id);$i++)
{
if(isset($_GET['bg']) && $_GET['bg']==$i)
echo "<tr><td id=sec_bg ><span onclick=DisplayContent(".$sec_id[$i].",$i)><b>".$sec_name[$i]."</b></span></td></tr>";
else
echo "<tr><td id=sec_nobg ><span onclick=DisplayContent(".$sec_id[$i].",$i)><b>".$sec_name[$i]."</b></span></td></tr>";
}
?>
</table>
<input type="hidden" name="secid" value="<?php echo $_GET['section_id']; ?>" />


</div>
</div>

<div class="section_pillar_wrap2">
<div class="subhead_right"></div>
<div class="section_itemlist2">
<div id="add_item" style="background-color:#6C6C6C; color:white; font-weight:bold; font-size:15px; padding:10px; "><?php echo $item_sec_name; ?>&nbsp;</div>
<div id="ret_section">
<table cellpadding="5px" cellspacing="0px" border="0" style="margin:10px;background-color:#EAEAEA; border:1px #2D2D2D solid;">

<?php 
for($i=0;$i<sizeof($itemname);$i++)
{
if($i==0) echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td><b>ITEM ID</b></td><TD><B>TITLE</B></TD><td>Position</td></tr>";
echo "<tr><td>".($i+1)."<td><img src=\"../images/delete_item_icon.gif\" onclick=\"remove_sec_item($db_sec_order[$i],".$_GET['section_id'].")\"></td><td><b>".$itemid[$db_sec_order[$i]]."</b></td><td>".$itemname[$db_sec_order[$i]]."</td>";
echo "<td><select name=moveto onchange=\"move_section(this.value,".($i+1).",".$_GET['section_id'].",$db_sec_order[$i])\" ><option value=0>--</option>";
for($j=1;$j<=sizeof($itemname);$j++)
	 echo "<option value=$j>$j</option>";


echo "</tr>";
}
if(!isset($_GET['section_id']))
echo "<tr><td>SELECT A SECTION TO VIEW IT'S ITEMS</TD></TR>";
else if(sizeof($itemname) == 0)
echo "<tr><td>NO ITEMS IN THIS SECTION.</td></tr>";
?>
</table>
</div><!-- close of ret_section -->
</div>
</div>
<div id="new_sec">&nbsp;</div>
<div id="ret_section"></div>
</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>
</body>
</html>