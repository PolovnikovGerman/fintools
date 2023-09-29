<?php include('../controller/ch_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="fl_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<script language="JavaScript" type="text/javascript" src="attach_ajax_calls.js"></script>


<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function(){
        $("a#exportdata").click(function(){
           export_chinese();
        });
    });

    function export_chinese() {
        if (confirm('You realy want to export data into excell ?')) {
            var url='chineese_export.php';
            $('#loader').css('display','block');
            $.post(url, {}, function(response){
                $('#loader').css('display','none');
                if (response.errors=='') {
                    window.location.href=response.url;
                } else {
                    alert(response.errors);
                }
            }, 'json');
        }
    }
</script>
<title>BT System - Fullfillment </title>
</head>
<body onload="art_hide_modules()"  ><div id="loader"><img src="../images/loader.gif" /></div>
<div style="position:absolute; top:0; left:45%; z-index:1000;"><iframe name="atchiframe" src="attach_iframe.php" frameborder="0" marginwidth="0" marginheight="0"  height="19" width="175"></iframe></div>
<div id="att_wrap"></div>
<div class="wrap"  >
<?php include("../includes/header_navigation.php"); ?>



<?php
	if(isset($_GET['msg']) && $_GET['msg']=='error')
		echo "<div class=\"error\">Unable to Process File.</div>";
	else if(isset($_GET['msg']) && $_GET['msg']=='success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
	?>
 <div class="content" >
 <b style=" color:#2D2D2D; margin-left:20px; font-size:14px;">Fullfillment Overview</b>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


Orders:<select onchange="display_or(this.value);">

 <?php
 if(isset($_GET['or']))
 echo "<option value=".$_GET['or'].">".$_GET['or']."-".($_GET['or']+1000)."</option>";

 for($i=22000; $i<65000; $i+=1000)
 echo "<option value=$i>$i-".($i+1000)."</option>";
 ?>
 </select>

 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <span <?php echo (!isset($_SESSION['whr_ch'])) ? 'class=_sort_act' : 'class=_sort'; ?>><a href="chinese.php?whr_ch=all">ALL</a></span>
 <span <?php echo (isset($_SESSION['whr_ch']) && $_SESSION['whr_ch']=='on_vendor') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="chinese.php?whr_ch=on_vendor">On Vendor</a></span>
 <span <?php echo (isset($_SESSION['whr_ch']) && $_SESSION['whr_ch']=='on_cust') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="chinese.php?whr_ch=on_cust">On Customer</a></span>
 <span <?php echo (isset($_SESSION['whr_ch']) && $_SESSION['whr_ch']=='on_us') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="chinese.php?whr_ch=on_us">On Us</a></span>
 <span class='_sort'><a id="exportdata" href="javascript:void(0)">Export</a></span>

 <div style="  margin:5px 10px 0px 10px; " ><ul class="ff_mn">
 <?php

 echo "<li class=cat_inactive ><a href=\"fullfillment.php\">Fullfillment</a></li>";
 echo "<li class=cat_active ><a href=\"chinese.php\">Chinese</a></li>";
 echo  "<li class=cat_inactive ><a href=\"art3.php\">Art Overview</a></li>";
 echo  "<li class=cat_inactive ><a href=\"pobydate.php\">POs by Date</a></li>";

 ?></ul>
 </div>
 <table width="950px" border="0" cellpadding="0" cellspacing="0"  style="margin-left:10px; border:1px #181818 solid; border-bottom:1px #c0c0c0 solid; " >
 <tr class="ffTableHead" >

 <td width="50px" align="center">Order</td>
       <td width="125px" align="center">Customer</td>
       <td width="140px" align="center">Description</td>
       <td width="25px" align="center">Ar</td>
       <td width="25px" align="center">PO</td>
       <td width="50px" align="center">ShDT</td>
       <td width="35px" align="center">Clay</td>
       <td width="25px" align="center">Snt</td>
       <td width="25px" align="center">Apr</td>
       <td width="35px" align="center">Prv</td>
       <td width="25px" align="center">Snt</td>
       <td width="25px" align="center">Apr</td>
       <td width="100px" align="center">Ship to BT</td>
       <td width="100px" align="center">Ship to Cust</td>
       <td width="25px" align="center">Is</td>
       <td width="140px" align="center">Notes</td>
 </tr></table>
 <div  style="width:980px; height:690px; overflow:auto;">
 <?php if(isset($vch_order['ch_id']) && sizeof($vch_order['ch_id']) > 0) { ?>
 <table width="950px" class="chn_tb" border="0" cellpadding="0" cellspacing="0"   style="margin-left:10px; border:1px #181818 solid;>
 <?php } else { ?>
 <table width="950px" class="chn_tb" border="1" cellpadding="0" cellspacing="10"   style="margin-left:10px; border:1px #181818 solid;"><tr><td align="center"><b>No orders to display</b></td></tr> <?php } ?>
 <?php
 for($i=0;$i<sizeof($vch_order['ch_id']);$i++)
 {
 echo "<tr align=center class=\"chn_tb hilite\" ".col_bg('#ececec',($i+1)).">";
 echo "<td width=50px align=center>".$vch_order['af_order_id'][$i].$vch_order['ch_po'][$i]."</td>";
 echo "<td  width=125px align=center><a class=info href=#>".substr($vch_order['af_cust'][$i],0,19)."<span>".$vch_order['af_cust'][$i]."</span></a></td>";
 echo "<td class=tdbg width=140px align=center><a class=info href=#>".substr($vch_order['af_desc'][$i],0,19)."<span>".$vch_order['af_desc'][$i]."</span></a></td>";

 if($ch_att['art'][$vch_order['af_order_id'][$i]] == 'yes')
 echo "<td  width=25px align=center bgcolor=\"#59b75b\" class=point onclick=send_data(".$vch_order['af_order_id'][$i].",'art','no')>O</td>";
 else
 echo "<td width=25px align=center >&nbsp;</td>";

if($ch_att['poart'][$vch_order['ch_id'][$i]] == 'yes')
 echo "<td width=25px align=center  bgcolor=\"#59b75b\" class=point onclick=send_data(".$vch_order['af_order_id'][$i].",'poart','no',".$vch_order['ch_id'][$i].")>O</td>";
 else
 echo "<td width=25px align=center >&nbsp;</td>";

 echo "<td class=tdbg  width=50px align=center >".print_date($vch_order['ch_ship_date'][$i])."</td>";

  if($ch_att['clay'][$vch_order['ch_id'][$i]] == 'yes')
 echo "<td width=35px align=center ><span  id=icon_clay".$vch_order['ch_id'][$i]."  onclick=send_data(".$vch_order['af_order_id'][$i].",'clay','yes',".$vch_order['ch_id'][$i].",'".$vch_order['ch_po'][$i]."')><img class=point src=\"../images/open_icon.png\"></span></span></td>";
 else
 echo "<td width=35px align=center ><span  id=icon_clay".$vch_order['ch_id'][$i]."  onclick=send_data(".$vch_order['af_order_id'][$i].",'clay','yes',".$vch_order['ch_id'][$i].",'".$vch_order['ch_po'][$i]."')><img class=point src=\"../images/attch_icon.png\"></span></span></td>";

 echo "<td width=25px align=center  bgcolor=\"".$vch_order['claysent'][$i]."\" id=chn_claysent_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'chn_claysent_ck')\"
 name=chn_claysent_ck$i "; if($vch_order['chn_claysent_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "></td>";

 echo "<td class=tdbg   width=25px align=center   bgcolor=\"".$vch_order['clayapr'][$i]."\" id=chn_clayapr_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'chn_clayapr_ck')\"
 name=chn_clayapr_ck$i "; if($vch_order['chn_clayapr_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "></td>";

 if($ch_att['prv'][$vch_order['ch_id'][$i]] == 'yes')
 echo "<td  width=35px align=center ><span  id=icon_prv".$vch_order['ch_id'][$i]."  onclick=send_data(".$vch_order['af_order_id'][$i].",'prv','yes',".$vch_order['ch_id'][$i].")><img class=point src=\"../images/open_icon.png\"></span></span></td>";
 else
 echo "<td  width=35px align=center ><span  id=icon_prv".$vch_order['ch_id'][$i]."  onclick=send_data(".$vch_order['af_order_id'][$i].",'prv','yes',".$vch_order['ch_id'][$i].")><img class=point src=\"../images/attch_icon.png\"></span></span></td>";

 echo "<td  width=25px align=center  bgcolor=\"".$vch_order['prvsent'][$i]."\" id=chn_prvsent_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'chn_prvsent_ck')\"
 name=chn_prvsent_ck$i "; if($vch_order['chn_prvsent_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "></td>";


 echo "<td class=tdbg  width=25px align=center  bgcolor=\"".$vch_order['prvapr'][$i]."\" id=chn_prvapr_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'chn_prvapr_ck')\"
 name=chn_prvapr_ck$i "; if($vch_order['chn_prvapr_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "></td>";


 echo "<td width=100px   align=left bgcolor=\"".$vch_order['shipbt'][$i]."\" id=chn_shipbt_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'chn_shipbt_ck')\"
 name=chn_shipbt_ck$i "; if($vch_order['chn_shipbt_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "><a class=info href=#>".substr($vch_order['chn_shipbt_notes'][$i],0,10)."<span>".$vch_order['chn_shipbt_notes'][$i]."</span></a></td>";

 echo "<td  class=tdbg width=100px  align=left bgcolor=\"".$vch_order['ship'][$i]."\" id=ch_ship_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'ch_ship_ck')\"
 name=ch_ship_ck$i "; if($vch_order['ch_ship_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "><span id=\"chn_sh".$vch_order['ch_id'][$i]."\" ><a class=info href=#>".substr($vch_order['ch_ship_notes'][$i],0,10)."<span>".$vch_order['ch_ship_notes'][$i]."</span></a></span></td>";

 echo "<td width=25px align=center  bgcolor=\"".$vch_order['issue'][$i]."\" id=ch_issue_ck".$vch_order['ch_id'][$i]."><input type=checkbox onclick=\"child_toggle(".$vch_order['ch_id'][$i].",this,$i,'ch_issue_ck')\"
 name=ch_issue_ck$i ";  if($vch_order['ch_issue_ck'][$i] ==  'yes') echo" checked=yes"; else echo " value=no"; echo "></td>";

 echo "<td width=140px align=center id=\"chn_notes".$vch_order['ch_id'][$i]."\" ondblclick=edit_chn(".$vch_order['ch_id'][$i].") ><a class=\"info point\" >".substr($vch_order['ch_notes'][$i],0,22)."<span>".$vch_order['ch_notes'][$i]."</span></a></td>";
 echo "</tr>";

 }
 ?>
 </table>




 </div>

</div>



<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>

<div class="clear"></div>
</div>


<script type="text/javascript">
$('#loader').css('display','none');
</script>
</body>
</html>
