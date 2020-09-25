<?php include('../controller/fl_controller.php'); ?>
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
<script language="JavaScript" type="text/javascript" src="fl_ajax_calls.js?r=<?php rand(1,200)?>"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Fullfillment </title>
</head>
<body onload="art_hide_modules()"  >
<div id="att_wrap"></div>
<div id="fadeMessage"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:10px 10px 5px 20px;"><b>Fullfillment Vendor Center</b></div>
 <div style="width:960px; margin:auto; height:600px; ">
<div style="float:left; width:250px; border:1px gray solid; height:650px; overflow:scroll;">
<div align="right" class="point" style="background-color:gray; color:white; font-weight:bold; padding:6px;"><span onclick="addNewVen()">[+] add vendor</span></div><br />

<table  cellpadding="3px" cellspacing="0" border="0" width="100%" id="vendorListTable">

<?php
for($i=0;$i<sizeof($ven_list['v_id']);$i++)
echo "<tr><td class=\"bdbot point\" id=td_".$ven_list['v_id'][$i]." onclick=edit_ven(".$ven_list['v_id'][$i].",$i)>&nbsp;&nbsp;&nbsp;<span class=ven_list id=vl_$i>".$ven_list['v_name'][$i]."</span></td></tr>";
?>

</table>
</div>
<div style="float:right;  width:700px;height:850px; overflow:auto;">
<form>
<div style="background-color:#0000ff; height:17px; width:100%; font-size:14px; color:white; font-weight:bold; padding:7px 0px 3px 15px;" id="ff_ven_name">New Vendor</div>
<div align="center" style="border:1px darkgray solid; height:625px;">
<div id="vendorMsg"></div>
<table class="ff_vendor_table" style="font-size:12px; margin:20px 0px 0px 10px;  solid; border-top: none;" width=100% cellspacing=0 cellpadding=5 border=0>
<tr>
<td align=left class="blue" width="75px"><b>Name :</b> </td>
<td align=left width="200px"><input name=v_name id="ff_v_name" size="32" style="font-size:14px;" type=text></td>
<td align=left colspan="2" class="blue"><b>Vendor Type : </b>&nbsp;&nbsp;
<select name=v_type id="ff_v_type"><option value=domestic>Domestic&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><option value=chinese>Chinese</option></select></td>
</tr>
<tr>
<td align=left class="blue"><b>Address :</b></td>
<td><textarea id="ff_v_address" name=v_address rows=3 cols=28 style=\"overflow:hidden;\" wrap=\"hard\"></textarea></td>
<td align=left class="blue" width="160px"><b>7 letter Abbreviation:</b></td><td align=left><input id="ff_v_abbr" size="23" name=v_abbr type=text></td>
</tr>
<tr>
<td align=left class="blue"><b>Phone : </b></td>
<td align=left><input type=text id="ff_v_phone" size="32" style="font-size:14px" name=v_phone></td>
<td align=left class="blue" colspan=\"2\"><b>Vendor Memos:</b></td>
</tr>
<tr>
<td align=left class="blue" valign="bottom"><b>Email : </b></td>
<td align=left valign="bottom"><input name=v_email id="ff_v_email" size="32" style="font-size:14px" type=text></td>
<td colspan=2><textarea name=v_memos id="ff_v_memos" rows=3 cols=48 style=\"overflow:hidden;\" wrap=\"hard\"></textarea>
<input type="hidden" id="ven_id" />
</td>
</tr>
<tr>
    <td align=left class="blue" valign="bottom"><b>Additional Email : </b></td>
    <td align=left valign="bottom"><input name=v_additional_email id="ff_v_additional_email" size="32" style="font-size:14px" type=text></td>
    <td colspan=2>&nbsp;</td>
</tr>

</table></form>
<div style="position:absolute; width:700px; top:700px; text-align:right; " id=saveVendor>
<input name=newven_post type="button" onclick=saveNewVen() value=SAVE id=save>&nbsp;&nbsp;&nbsp;
</div>
</div>
</div>
</div>


</div>
<div id="loader" ></div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>