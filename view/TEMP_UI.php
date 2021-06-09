<?php include('../controller/fl_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js?v=1.0"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="attach_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="fl_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
    <script src="../includes/calendar/js/jscal2.js"></script>
    <script src="../includes/calendar/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/border-radius.css" />
    <!-- <link rel="stylesheet" type="text/css" href="../includes/calendar/css/img/img.css" /> -->

<!-- AUTO COMPLETE FILES -->

<script language="JavaScript" type="text/javascript" src="../includes/autosuggest/xpath.js"></script>
	<script language="JavaScript" type="text/javascript" src="../includes/autosuggest/SpryData.js"></script>
	<script language="JavaScript" type="text/javascript" src="../includes/autosuggest/SpryAutoSuggest.js"></script>
	<link href="../includes/autosuggest/SpryAutoSuggest.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">
  var ds0 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds1 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds2 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds3 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds4 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds5 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds6 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds7 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds8 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");
  var ds9 = new Spry.Data.XMLDataSet("../includes/dataset/items.xml","items/item");

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("div#senddocument").unbind('click').click(function(){
            var chkres=r2_validate();
            if (chkres==true) {                    
                var dat=$("form#purchaseorderdetail").serializeArray();
                var url="to-PDF.php";
                var chid=$("input[name='chid']").val();
                var chkurl = 'fl_ajax_return.php?q=getsendsbefore&val=' + chid;
                $.get(chkurl, function (data) {
                    var obj = JSON.parse(data);
                    if (obj.result == '1') {
                        var r = confirm(obj.msg + '. Re send file ?');
                        if (r === true) {
                            loaderOn();
                            $.post(url, dat, function(response){
                                if (response.flag==false) {
                                    window.location.href=response.docfile;
                                }
                                loaderOff();
                            }, 'json');                
                        }
                    } else {
                        loaderOn();
                        $.post(url, dat, function(response){
                            if (response.flag==false) {
                                window.location.href=response.docfile;
                            }
                        }, 'json');                
                        loaderOff();
                    }
                });                    
            }            
        })
    });
</script>
<!----------------------------->


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Fullfillment </title>
</head>

<body onload="hide_att()"><div id="att_wrap"></div>
<!-- <form action="to-PDF.php" onsubmit="return r2_validate()" method="post"> -->
<form id="purchaseorderdetail">
<div class="pdf_ui">
<div class="pdf_ui_title"  >
<div style="float:left">
PO#<span style="font-size:16px; font-weight:bold;"> BT <?php echo $_GET['oid']."-".$_GET['chpo']; ?></span>
</div>
<div style="float:right">
<b>Date:</b> <input type="text" onblur="__dt(this)" value="<?php echo date('m')."/".date('d')."/".date('y'); ?>" size="6" name="r2_date"  id="f_date1" />&nbsp;<input type="button" value=".." class="date" id="f_btn1"><br />
</div>
<div class="clear"></div>
  </div>
<div class="top_bar">
<div class="top_1">
<span ><b>Vendor :</b> </span><span>
<?php
echo "<select name=r2_ven_id class=yellow onchange=get_ven_details(this.value) id=r2_vendor><option value=0></option>";
for($i=0;$i<sizeof($ven_list['v_id']);$i++)
{
echo "<option value=".$ven_list['v_id'][$i].">".$ven_list['v_abbr'][$i]."</option>";
}
echo "</select>";

?>
<br /><br />
<table cellpadding="2" cellspacing="0" border="0" >
<tr><td  align="right"><b>Phone:</b> </td><td id="r2_ph"></td></tr>

<tr><td  align="right"><b>Email:</b>  </td><td  ><div id=r2_email></div></td></tr>
</table>

</div>
<div class="top__">
<span><b>Address:</b></span><br />
<span ><textarea cols="19" style="border:1px white solid; resize: none; overflow-y: auto;" rows="3" id="r2_ven_add" name="r2_ven_add" readonly="readonly"></textarea></span>
</div>
<div class="top__">
<span><b>Vendor Memos:</b></span><br />
<div id="r2_venmemos">

</div>

</div>
<div class="top_2">
<table border="0" cellpadding="2" cellspacing="0">
<tr><td  class="blue">Message to Vendor:</td></tr>
<tr><td><textarea name="r2_ven_msg" rows="2" cols="28" style="resize: none; overflow-y: auto;"></textarea></td></tr>
</table>

</div>


</div>
<div class="mid_left_cover" >
<span class="blue">Shp Date : </span><input name="r2_ship_date" id="r2_ship_date" onkeyup="yellow('r2_ship_date')" onblur="__dt(this)" class="yellow" type="text" size="6" />&nbsp;<input type="button" value=".." class="date" id="f_btn2"><span class="blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deliver:</span><br />
<br />
<span class="blue">Ship Act:</span> 
<select class="yellow"  id="r2_ship_act"  name="r2_ship_act">
    <option value="0"></option>
    <option value="UPS 084YR7" >UPS 084YR7</option>
    <option  value="Ship on your acct">Ship on your acct</option>
    <option value="FedEx 260424580">FedEx 260424580</option>
</select>
<br />
<br />
<span class="blue">History:</span><br />
<textarea cols="34" id="hist_msg" style="resize: none; overflow-y: auto;"></textarea><br />
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;


<input type="button" id="save" onclick="r2_hist_post(<?php echo $_GET['chid']; ?>)" value="Update" /><br />
<div style="width:257px; height:372px; border:1px black solid; margin-top:5px; overflow:auto;" rows="17" cols="27" id="r2_get" readonly="readonly"><table id="histTable" width="100%"><tr><td>&nbsp;</td></tr></table></div>


</div>
<div class="mid_right_cover" >

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
<td><input type="text" size="6"  onblur="__dt(this)"  name="r2_d1_date" id=r2_d1_date onkeyup="yellow('r2_d1_date')"   class="yellow" />&nbsp;<input type="button"  value=".." class="date" id="f_btn3"></td><td><select class="yellow"  name="r2_d1_type"  id="r2_d1_type"  >
<option value="Ground">Ground</option>
<option value="3 Day">3 Day</option>
<option value="2nd Day">2nd Day</option>
<option value="NextDay">Next Day Saver</option>
<option value="NextDay AM">Next Day</option>
<option value="NextDay Early">Next Day Early AM</option>
<option value="Intl - UPS Expedited">Intl UPS Expdtd</option>
<option value="Intl - UPS Express">Intl UPS Express</option>
<option value="Intl - FedEx Economy">Intl FedEx Economy</option>
<option value="Intl - FedEx Priority">Intl FedEx Priority</option>
<option value="US Postal Service">USPS</option>
</select>
</td>
<td><input type="text" size="6"  onblur="__dt(this)" id="f_date4"   name="r2_d2_date" />&nbsp;<input type="button" value=".." class="date" id="f_btn4"></td><td><select  name="r2_d2_type"   >
<option></option>
<option value="Ground">Ground</option>
<option value="3 Day">3 Day</option>
<option value="2nd Day">2nd Day</option>
<option value="NextDay">Next Day Saver</option>
<option value="NextDay AM">Next Day</option>
<option value="NextDay Early">Next Day Early AM</option>
<option value="Intl - UPS Expedited">Intl UPS Expdtd</option>
<option value="Intl - UPS Express">Intl UPS Express</option>
<option value="Intl - FedEx Economy">Intl FedEx Economy</option>
<option value="Intl - FedEx Priority">Intl FedEx Priority</option>
<option value="US Postal Service">USPS</option>
</select>
</td>
<td><input type="text" size="6"  onblur="__dt(this)" id="f_date5" name="r2_d3_date" />&nbsp;<input type="button" value=".." class="date" id="f_btn5"></td><td><select  name="r2_d3_type"><option></option>
<option value="Ground">Ground</option>
<option value="3 Day">3 Day</option>
<option value="2nd Day">2nd Day</option>
<option value="NextDay">Next Day Saver</option>
<option value="NextDay AM">Next Day</option>
<option value="NextDay Early">Next Day Early AM</option>
<option value="Intl - UPS Expedited">Intl UPS Expdtd</option>
<option value="Intl - UPS Express">Intl UPS Express</option>
<option value="Intl - FedEx Economy">Intl FedEx Economy</option>
<option value="Intl - FedEx Priority">Intl FedEx Priority</option>
<option value="US Postal Service">USPS</option>
</select>
</td>
</tr>
<tr>
    <td colspan=2><textarea rows="5" cols="27" class="yellow" id=r2_d1_add style="resize: none; overflow-y: auto;"  name="r2_d1_add"></textarea></td>
    <td colspan=2><textarea rows="5" cols="27" name="r2_d2_add" style="resize: none; overflow-y: auto;"></textarea></td>
    <td colspan=2><textarea rows="5" cols="27" name="r2_d3_add" style="resize: none; overflow-y: auto;"></textarea></td>
</tr>
</table>
<div style="height:265px; border-bottom:1px #C0C0C0 dotted; overflow:auto;">
<table cellpadding="2" cellspacing="0" border="0" width="100%" style="font-size:11px; " >
<tr align="center"><td width="85px">Item#</td><td>Description</td><td width="30px" align="center">&nbsp;</td><td width="50px">Qty</td><td width="50px">Price</td><td width="65px">Subtotal</td><td width="50px">recomd</td></tr>


<?php
for($j=0;$j<10;$j++)
{
echo "<tr>";


echo "<td class=\"bdr "; if($j==0) echo " yellow\" "; else echo "\"";
echo " ><div id=\"mySuggest$j\"><input class=\"nobg";
if($j==0) echo " yellow\" id=firstitem"; else echo "\"";

echo "  type=\"text\"  name=r2_itemid$j size=9><div  id=\"resultsDIV$j\" spry:region=\"ds$j\">

      <div  onclick=get_item_details(\"{itemid}\",$j); spry:repeat=\"ds$j\" spry:suggest=\"{itemid}\"><b>{itemid}</b>&nbsp;{description}</div>

  </div>
</div></td>";


echo "<td class=\"bdr\" id=r2_desc$j></td>";
echo "<td class=\"bdr\" width=30px id=r2_notes$j>&nbsp;</td>";
if($j==0)
echo "<td class=\"bdr yellow\" align=center onkeyup=tot($j) id=r2_qty_cover$j><input size=2 class=\"nobg yellow\" id=r2_qty0></td>";
else
echo "<td class=\"bdr\" align=center onkeyup=tot($j) id=r2_qty_cover$j></td>";
echo "<td class=\"bdr\" align=center onkeyup=tot($j) id=r2_price_cover$j></td>";
echo "<td class=\"bdrr\" align=\"right\" readonly=yes id=r2_total$j></td>";
echo "<td id=r2_pref_ven$j class=small_font style=\"padding-left:5px;\"><input type=text size=2 class=nobg></td>";
echo "</tr>";
}
?>
</table>
</div>
<table cellpadding="2" cellspacing="0" border="0" width="100%" style="font-size:11px;" >

<tr >
<td colspan="3" align="right"><span class="blue">Bill method</span>: <select name="r2_bill" class="yellow"  id="r2_bill">
<option value="0"></option>
<option value="z0214371557464912013">Amex Plum</option>
<option value="z1011371731716041000">Amex Starwoods</option>
<!-- <option value="y01205528519166891110">CapOne MC</option> -->
<option value="y10245528519074417289">CapOne MC</option>
<!-- <option value="x10184147202162798241">Chase Visa (new)</option> -->
<!-- <option value="x01204147202289989277">Chase Visa (new)</option> -->
<option value="x12254147202472633484">Chase Visa (new)</option>
<option value="x10134266841218286662">Chase Visa (old)</option>
<option value="t00000000000000000000">Terms</option>
<option value="c00000000000000000000">Check</option>
<option value="o00000000000000000000">Other</option>
<option
</select></td>
<td align="right"><b>Total:</b></td>
<td width="62px" align="right"><span class="box"><b><span id="r2_grand"></span></b></span></td>
<td width="65px"><input type="hidden" name="r2_grand_total" id="r2_grand_total" value="0" /></td>
</tr>
</table>

<input type="hidden" name="chid" value="<?php echo $_GET['chid']; ?>" />
<input type="hidden" name="oid" value="<?php echo $_GET['oid']; ?>" />
<input type="hidden" name="chpo" value="<?php echo $_GET['chpo']; ?>" />
<hr />

<table class="checklist" width="100%">
<tr><td><B>CHECKLIST</B></td><td><input type="checkbox" name="ckb[]" /></td><td>1. Is it the right order number?</td><td><input type="checkbox"  name="ckb[]"/></td><td>6. Correct Item? Color?</td></tr>
<tr><td>&nbsp;</td><td><input type="checkbox"  name="ckb[]"/></td><td>2. Shipping to correct place/s?</td><td><input type="checkbox" name="ckb[]" /></td><td>7. Correct quantity?</td></tr>
<tr><td>&nbsp;</td><td><input type="checkbox" name="ckb[]" /></td><td>3. Delivery dates are correct?</td><td><input type="checkbox" name="ckb[]" /></td><td>8. Cheapest vendor? Correct Price?</td></tr>
<tr><td>&nbsp;</td><td><input type="checkbox" name="ckb[]"/></td><td>4. Ship account, date and methods?</td><td><input type="checkbox"  name="ckb[]"/></td><td>9. Any special notes? Going int'l?</td></tr>
<tr><td>&nbsp;</td><td><input type="checkbox" name="ckb[]"/></td><td>5. Did customer pay or have cc?</td><td><input type="checkbox" name="ckb[]" /></td><td>10. Correct # prints? Pricing?</td></tr>
</table>
<div id="loader"></div>
</div>
<div class="clear pdf_ui_foot">
<div style="float:left;"><input type="button" value=Reverse&nbsp;&&nbsp;Delete />
</div>
    <div style="float: left;margin-left: -105px;margin-top: 30px;">        
        <div class="printcolorlabel">Print color/s</div>
        <div class="printcolorvalueinpt">
            <input type="text" class="poordercolorinpt" name="ch_printcolor" value=""/>
        </div>        
        <div class="printvaluelabel">#Prints</div>
        <div class="printvalueinpt">
            <input type="text" class="orderitmqtyinpt" name="ch_printqty" value=""/>
        </div>
        <div class="printvaluelabel">#Items</div>
        <div class="printvalueinpt">
            <input type="text" class="orderitmqtyinpt" name="af_itemqty" value=""/>
        </div>    
        <div class="printcolorlabel">Item color/s</div>
        <div class="printcolorvalueinpt">
            <input type="text" class="poordercolorinpt" name="ch_itemcolor" value=""/>
        </div>        
        <div class="rushinputarea">
            <input type="checkbox" name="ch_rush_ck" value="1" /> Rush
        </div>        
    </div>
    
    <div class="savepo" style="float: right; margin-left: 10px; margin-top: 27px; width: 90px;" id="senddocument">
    <!-- <input type="submit" id="save" value="SEND" name="r2_send" /> -->
    SEND
</div>
</div>
<script type="text/javascript">

	var theSuggest0 = new Spry.Widget.AutoSuggest("mySuggest0","resultsDIV0", "ds0", ["itemid","description"], {containsstring: true});
	var theSuggest1 = new Spry.Widget.AutoSuggest("mySuggest1","resultsDIV1", "ds1", ["itemid","description"], {containsstring: true});
	var theSuggest2 = new Spry.Widget.AutoSuggest("mySuggest2","resultsDIV2", "ds2", ["itemid","description"], {containsstring: true});
	var theSuggest3 = new Spry.Widget.AutoSuggest("mySuggest3","resultsDIV3", "ds3", ["itemid","description"], {containsstring: true});
	var theSuggest4 = new Spry.Widget.AutoSuggest("mySuggest4","resultsDIV4", "ds4", ["itemid","description"], {containsstring: true});
	var theSuggest5 = new Spry.Widget.AutoSuggest("mySuggest5","resultsDIV5", "ds5", ["itemid","description"], {containsstring: true});
	var theSuggest6 = new Spry.Widget.AutoSuggest("mySuggest6","resultsDIV6", "ds6", ["itemid","description"], {containsstring: true});
	var theSuggest7 = new Spry.Widget.AutoSuggest("mySuggest7","resultsDIV7", "ds7", ["itemid","description"], {containsstring: true});
	var theSuggest8 = new Spry.Widget.AutoSuggest("mySuggest8","resultsDIV8", "ds8", ["itemid","description"], {containsstring: true});
	var theSuggest9 = new Spry.Widget.AutoSuggest("mySuggest9","resultsDIV9", "ds9", ["itemid","description"], {containsstring: true});


</script>
<script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() },
          showTime: false
      });
      cal.manageFields("f_btn1", "f_date1", "%m/%d/%y");
      cal.manageFields("f_btn2", "r2_ship_date", "%m/%d/%y");
      cal.manageFields("f_btn3", "r2_d1_date", "%m/%d/%y");
      cal.manageFields("f_btn4", "f_date4", "%m/%d/%y");
	   cal.manageFields("f_btn5", "f_date5", "%m/%d/%y");

    //]]></script>
</body>
</html>
