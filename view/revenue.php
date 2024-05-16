<?php  include('../controller/revenue_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ui/jquery-ui-custom.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ui/jquery-ui-1.8.5.custom.js"></script>
<script src="../includes/calendar/js/jscal2.js"></script>
    <script src="../includes/calendar/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../css/jquery.ui.all.css" />
    

<script language="JavaScript" type="text/javascript" src="revenue_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
<link href="../images/popUp.css" rel="stylesheet" type="text/css" />

<style>
body{font-size:60%;}

</style>
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Development </title>
</head>
<body onload="art_hide_modules()"  ><div id="loader"><img src="../images/loader.gif" /></div>

<div id="att_wrap"></div>

<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>
<div class="content">
<div style="margin:10px 20px 0px 20px;"><b>Revenue:</b>  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
 Orders: <select onchange="display_rev(this.value);">
 
 <?php
 if(isset($_SESSION['rev']) && is_numeric($_SESSION['rev']))
 echo "<option value=".$_SESSION['rev']."> ".$_SESSION['rev']."'s &nbsp;</option>"; 

// for($i=22000; $i<30000; $i+=500)
// echo "<option value=$i>$i-".($i+500)."</option>";
//   for($i=22000; $i<30000; $i+=1000)
 
  for($i=22000; $i<75000; $i+=1000)
 {
 
 if(($i%1000) == 0)
 echo "<option style=\"background-color:#ececec;font-weight:bold;font-size:11px; color:#3A3A3A; padding:3px 3px;\" value=$i <b>$i's &nbsp;</b></option>";
 else
 echo "<option style=\"font-size:10px; padding:3px 3px;\" value=$i>&nbsp;$i's &nbsp;</option>";
 
 }
 ?>
 </select></div>
 <div style="float:left">
 
 <table style="margin:10px 10px 0px 10px;"  cellpadding="0px" cellspacing="0" border="0">
<tr align="center" class="bold"><td width="53px">Date</td><td width="45px">Order</td><td width="120px">Customer</td><td width="52px">Rev</td><td width="52px">Ship</td><td width="52px">Tax</td><td width="52px">PO</td></tr></table>

<div class="halfBox">
<table width="100%" cellpadding="5px" cellspacing="0" border="0">

<?php
for($i = 0; $i < 500; $i++){
echo "<tr  ".col_bg('#ececec',$i)." class=\"hilite revList\" >
		<td>".print_date($revData['af_date'][$i])."</td>
		<td>".$revData['af_order_id'][$i]."</td>
		<td>".substr($revData['af_cust'][$i],0,18)."</td>";
		
		if($revData['revAmt'][$i] == 0.00 || $revData['revAmt'][$i] == '')
		{
		echo "<td align=center id=revAmt".$revData['revID'][$i]."><input type=text class=bgYellow  id=rev".$revData['revID'][$i]."  size=5></td>";
		echo "<td align=center  id=revShip".$revData['revID'][$i]."><input type=text  class=bgYellow  id=ship".$revData['revID'][$i]." size=5></td>";
		echo "<td align=center  id=revTax".$revData['revID'][$i]."><input type=text  class=bgYellow  id=tax".$revData['revID'][$i]." size=5></td>";
		if( $revData[$revData['af_order_id'][$i]]['poTotal'] == 0.00 || $revData[$revData['af_order_id'][$i]]['poTotal'] == '' )
			echo "<td align=center id=revPO".$revData['af_order_id'][$i]."><input type=text class=bgYellow id=PO".$revData['af_order_id'][$i]." size=5></td>";
		else
			echo "<td>".$revData[$revData['af_order_id'][$i]]['poTotal']."</td>";
		}
		else
		{
		echo "<td align=center id=revAmt".$revData['revID'][$i].">".$revData['revAmt'][$i]."</td>";
		echo "<td align=center id=revShip".$revData['revID'][$i].">".$revData['revShip'][$i]."</td>";
		echo "<td align=center id=revTax".$revData['revID'][$i].">".$revData['revTax'][$i]."</td>";
		if( $revData[$revData['af_order_id'][$i]]['poTotal'] == 0.00 || $revData[$revData['af_order_id'][$i]]['poTotal'] == '' )
			echo "<td align=center id=revPO".$revData['af_order_id'][$i]."><input type=text class=bgYellow id=PO".$revData['af_order_id'][$i]." size=5></td>";
		else
			echo "<td>".$revData[$revData['af_order_id'][$i]]['poTotal']."</td>";
		}
		if($revData['revAmt'][$i] < 1 || $revData['revAmt'][$i] == '')
		echo "<td id=revSubmit".$revData['revID'][$i]."><input type=button onclick=addRev(".$revData['revID'][$i].",".$revData['af_order_id'][$i].") class=\"saveButton\" value=s ></td>";
		else
		echo "<td id=revSubmit".$revData['revID'][$i]."><span class=point style=\"color:blue;\" onclick=editRev(".$revData['revID'][$i].",".$revData['af_order_id'][$i].")>edit</span></td>";
	echo "</tr>";
	}
?>
</table>
</div>
</div>
<div style="float:right;">
<table style="margin:10px 10px 0px 10px;"  cellpadding="0px" cellspacing="0" border="0">
<tr align="center" class="bold"><td width="53px">Date</td><td width="45px">Order</td><td width="120px">Customer</td><td width="52px">Rev</td><td width="52px">Ship</td><td width="52px">Tax</td><td width="52px">PO</td></tr></table>

<div class="halfBox">
<table width="100%" cellpadding="5px" cellspacing="0" border="0">
<?php
for($i = 500; $i < 1000; $i++){
echo "<tr  ".col_bg('#ececec',$i)." class=\"hilite revList\" >
		<td>".print_date($revData['af_date'][$i])."</td>
		<td>".$revData['af_order_id'][$i]."</td>
		<td>".substr($revData['af_cust'][$i],0,20)."</td>";
		
		if($revData['revAmt'][$i] == 0.00 || $revData['revAmt'][$i] == '')
		{
		echo "<td align=center id=revAmt".$revData['revID'][$i]."><input type=text class=bgYellow  id=rev".$revData['revID'][$i]."  size=5></td>";
		echo "<td align=center  id=revShip".$revData['revID'][$i]."><input type=text  class=bgYellow  id=ship".$revData['revID'][$i]." size=5></td>";
		echo "<td align=center  id=revTax".$revData['revID'][$i]."><input type=text  class=bgYellow  id=tax".$revData['revID'][$i]." size=5></td>";
		if( $revData[$revData['af_order_id'][$i]]['poTotal'] == 0.00 || $revData[$revData['af_order_id'][$i]]['poTotal'] == '' )
			echo "<td align=center id=revPO".$revData['af_order_id'][$i]."><input type=text class=bgYellow id=PO".$revData['af_order_id'][$i]." size=5></td>";
		else
			echo "<td>".$revData[$revData['af_order_id'][$i]]['poTotal']."</td>";
		}
		else
		{
		echo "<td align=center id=revAmt".$revData['revID'][$i].">".$revData['revAmt'][$i]."</td>";
		echo "<td align=center id=revShip".$revData['revID'][$i].">".$revData['revShip'][$i]."</td>";
		echo "<td align=center id=revTax".$revData['revID'][$i].">".$revData['revTax'][$i]."</td>";
		if( $revData[$revData['af_order_id'][$i]]['poTotal'] == 0.00 || $revData[$revData['af_order_id'][$i]]['poTotal'] == '' )
			echo "<td align=center id=revPO".$revData['af_order_id'][$i]."><input type=text class=bgYellow id=PO".$revData['af_order_id'][$i]." size=5></td>";
		else
			echo "<td>".$revData[$revData['af_order_id'][$i]]['poTotal']."</td>";
		}
		if($revData['revAmt'][$i] < 1 || $revData['revAmt'][$i] == '')
		echo "<td id=revSubmit".$revData['revID'][$i]."><input type=button onclick=addRev(".$revData['revID'][$i].",".$revData['af_order_id'][$i].") class=\"saveButton\" value=s ></td>";
		else
		echo "<td id=revSubmit".$revData['revID'][$i]."><span class=point style=\"color:blue;\" onclick=editRev(".$revData['revID'][$i].",".$revData['af_order_id'][$i].")>edit</span></td>";
	echo "</tr>";
	}
?></table>
</div>

</div>
</div>
<div class="clear"></div>
</div>

<script type="text/javascript">
$('#loader').html('');
</script>
</body>
</html>
