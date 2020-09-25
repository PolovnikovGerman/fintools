<?php include('../controller/ff_items_controller.php'); ?>
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
 <div style="margin:10px 10px 5px 20px;"><b>Fullfillment - Item Center</b></div>
 <div style="width:960px; margin:auto; border:1px #818181 solid;  ">
<table width="940px" cellpadding="1" cellspacing="0" >
<tr class="all_task_table_head" align="center">
<td  width="30px">&nbsp;</td><td width="65px" style="padding-right:10px">Item#</td><td width="240px">Description</td><td width="50px">Price</td><td width="100px">Pref-Vendor</td><td width="440px">Notes</td><td width="30px"><span class="point" onclick="add_ffitem()">[+]</span></td>
</tr>
</table>
<div style="width:960px; height:600px; overflow:auto;">


<table width="940px" cellpadding="1" cellspacing="0" style="color: #2D2D2D;" >
<?php
for($i=0;$i<sizeof($items['i_id']); $i++)
echo "<tr  ".col_bg('#ececec',$i)." class=hilite align=\"center\">
<td class=tdbg  width=\"30px\">".($i+1)."</td>
<td class=tdbg align=right style=\"padding-right:10px;font-weight:bold;\" width=\"65px\" ondblclick=edit_ffitems($i,".$items['i_id'][$i].") id=ffi_itemid_$i>".$items['i_itemid'][$i]."</td>
<td class=tdbg width=\"240px\" ondblclick=edit_ffitems($i,".$items['i_id'][$i].") id=ffi_desc_$i>".$items['i_desc'][$i]."</td>
<td class=tdbg width=\"50px\"  ondblclick=edit_ffitems($i,".$items['i_id'][$i].") id=ffi_price_$i>".$items['i_price'][$i]."</td>
<td class=tdbg width=\"100px\" ondblclick=edit_ffitems($i,".$items['i_id'][$i].") id=ffi_ven_$i>".$items['i_ven'][$i]."</td>
<td class=tdbg width=\"440px\" style=\"padding-left:5px;\" ondblclick=edit_ffitems($i,".$items['i_id'][$i].") id=ffi_notes_$i align=justify>".substr($items['i_oth_ven'][$i],0,70)."</td>
<td width=\"30px\" id=ffi_submit_$i>&nbsp;</td>
</tr>";
?>
</table>


</div>
<div class="clear"></div>
<div id="loader"></div>
</div>


</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>