<?php include('../controller/vendor_controller.php'); ?>
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


<div class="section_pillar_wrap" style="margin-top:50px;" >
<div class="subhead">
<div style="float:left;">Vendor List:&nbsp;&nbsp;</div><div style="float:right"><a href="vendors.php"><img src="../images/add_item.gif" /></a></div>
<div class="clear"></div>
</div>
<div class="section_itemlist">




<table cellpadding="5px" width="100%" cellspacing="0px" border="0" class="items_list_table"><tr><th>Vendor ID#</th><th>Vendor Name</th></tr>
<?php
for($i=0;$i<sizeof($vendor_list_id);$i++)
echo "<tr><td>$vendor_list_id[$i]</td><td><a href=\"edit_vendor.php?vendor_id=".$vendor_list_id[$i]."\"><b>$vendor_list_name[$i]</b></a></td></tr>";
?>
<?php
for($i=0;$i<sizeof($vendor_list_id);$i++)
{
if(($i+1) % 2 ==0)
echo "<tr ><td><b>$vendor_list_id[$i]</b></td><td><a href=\"edit_vendor.php?vendor_id=".$vendor_list_id[$i]."\">$vendor_list_name[$i]</a></td></tr>";
else
echo "<tr bgcolor=#eaeaea><td><b>$vendor_list_id[$i]</b></td><td><a href=\"edit_vendor.php?vendor_id=".$vendor_list_id[$i]."\">$vendor_list_name[$i]</a></td></tr>";

}
?>
</table>
</div>
</div>

</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>
</body>
</html>