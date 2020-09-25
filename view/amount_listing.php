<?php include('../controller/generic_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="attach_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="fl_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Fullfillment </title>
</head>
<body onload="art_hide_modules()"  >
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:10px 10px 5px 20px;"><b>Amount Listing</b></div>
 <div style="width:1180px; overflow:auto; margin:auto; border:1px #575757 solid; height:740px; ">
<?php
$size = sizeof($po);
$size = $size/5;
echo "<table width=100% cellpadding=5 border=1><tr>";
for($i = 0; $i < sizeof($po) ; $i++)
{
	echo "<td><b>".$po[$i]['af_order_id']."</b></td><td style=\"color:blue; background-color:#fafafa;\">".$po[$i]['poTotal']."</td>";
	if( ($i+1)%10 == 0 )
		echo "</tr><tr>";
}
echo "</tr></table>";
?>
</div>


</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>