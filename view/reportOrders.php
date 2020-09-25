<?php  include('../controller/report_controller.php'); ?>
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
    

<script language="JavaScript" type="text/javascript" src="report_ajax_calls.js"></script>
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
<div style="margin:10px 20px 0px 20px;"><b>Profit</b>  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
 Orders: <select onchange="display_profit(this.value);">
 
 <?php
 if(isset($_SESSION['prOrdNum']) && is_numeric($_SESSION['prOrdNum']))
 echo "<option value=".$_SESSION['prOrdNum']."> ".$_SESSION['prOrdNum']."'s &nbsp;</option>"; 

 
 
  for($i=22000; $i<65000; $i+=1000)
 {
 
 if(($i%1000) == 0)
 echo "<option style=\"background-color:#ececec;font-weight:bold;font-size:11px; color:#3A3A3A; padding:3px 3px;\" value=$i <b>$i's &nbsp;</b></option>";
 else
 echo "<option style=\"font-size:10px; padding:3px 3px;\" value=$i>&nbsp;$i's &nbsp;</option>";
 
 }
 ?>
 </select></div>
 <div class="prMenu">
 <ul><li id="active"><a href="reportOrders.php">By Order</a></li><li><a href="reportDates.php">By Date</a></li></ul>
 <div class="clear"></div>
 </div>
 
 <div  style="border:1px darkgray solid; margin:0px 13px; width:960px; border-bottom:none;">
 <table cellpadding="2px" border="0" style="font-weight:bold;" cellspacing="0"  width="940px"><tr align="center"><td width="55px">Date</td><td width="40px">Order</td><td width="295px">Customer</td><td width="215px">Description</td><td width="60px">Rev</td><td width="60px">Ship</td><td width="60px">PO</td><td width="75px" align="right">Profit</td><td width="55px" align="right">%%</td></tr></table></div>
<div style="border:1px darkgray solid; border-top:none; height:720px; margin:0px 13px; width:960px; overflow:auto;;">
<table cellpadding="2px" cellspacing="0" border="0" width="940px">
<?php
for($i=0; $i< sizeof($prOrder['orderID']); $i++)
{
	echo "<tr align=center  ".col_bg('#ececec',$i)." class=\"".$prOrder['prBg'][$i]." hilite\" >
			<td width=55px>".print_date($prOrder['date'][$i])."</td>
			<td width=40px>".$prOrder['orderID'][$i]."</td>
			<td width=305px>".$prOrder['cust'][$i]."</td>
			<td width=230px>".$prOrder['desc'][$i]."</td>
			<td width=60px>".$prOrder['revAmt'][$i]."</td>
			<td width=60px>".$prOrder['revShip'][$i]."</td>
			<td width=60px>".$prOrder['poTotal'][$i]."</td>
			<td width=75px align=right class=\"".$prOrder['revProfitClass'][$i]."\" style=\"border-left:1px #ababab solid;\">".$prOrder['revProfit'][$i]."</td>
			<td width=55px align=right  class=\"".$prOrder['revProfitClass'][$i]."\">".$prOrder['revPercent'][$i]."</td>
			
		  </tr>";
}
?>
</table>
</div>

</div>

<div class="clear"></div>
</div>

<script type="text/javascript">
$('#loader').html('');
</script>
</body>
</html>