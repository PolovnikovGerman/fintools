<?php include('../controller/webQuotes_controller.php'); ?>
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
<title>BT System - Website Quotes </title>
</head>
<body onload="art_hide_modules()"  >
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:10px 10px 5px 20px;"><b>Website Quotes</b></div>
 <div style="width:1180px; margin:auto; border:1px #424242 solid; overflow:auto; height:740px; ">
<table border="0" style="border: 1px #969696 solid; border-bottom:none; margin:20px 0px 0px 20px;" cellpadding="5" cellspacing="0">
<tr>
	<th width="70px">Quote #</th>
    <th width="70px">Date</th>
    <th width="350px">Email</th>
    <th width="100px">Shape</th>
    <th width="70px">Qty</th>
    <th width="70px">State</th>
    <th width="100px">Ship Method</th>
    <th width="100px">Total Amt</th>
</tr>
</table>
<div style="width:1031px; max-height:700px; overflow: auto; margin-left:20px;">
<table border="0" style="border: 1px #969696 solid;border-top:none;  " cellpadding="5" cellspacing="0">
<?php

for($i=0;$i<sizeof($quotes); $i++)
echo "<tr  ".col_bg('#ececec',$i)." class=hilite align=center>
		<td width=70px><a href=\"../../www.buttonuniverse.com/docs/BU".$quotes[$i]['but_QID'].".pdf\" target=\"_blank\"><b>BU".$quotes[$i]['but_QID']."</b></a></td>
		<td width=70px>".$quotes[$i]['but_Qdate']."</td>
		<td width=350px>".$quotes[$i]['but_Qemail']."</td>
		<td width=100px>".$quotes[$i]['but_name']."</td>
		<td width=70px>".$quotes[$i]['but_Qqty']."</td>
		<td width=70px>".$quotes[$i]['but_Qstate']."</td>
		<td width=100px>".$quotes[$i]['but_Qvia']."</td>
		<td width=100px align=right>".$quotes[$i]['but_Qtotal']."</td>
	</tr>";
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