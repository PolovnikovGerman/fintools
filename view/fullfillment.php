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
<script language="JavaScript" type="text/javascript" src="attach_ajax_calls.js?r=<?php echo rand(1,200)?>"></script>
<script language="JavaScript" type="text/javascript" src="fl_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Fullfillment </title>
<script type="text/javascript">
$(document).ready(function(){
    $("a#fullfill_export").click(function(){
        export_fulfill();
    })    
    function export_fulfill() {
        if (confirm('You realy want to export data into excell ?')) {
            var url='fulfillment_export.php';
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
    // Search
    $("input#ordernumber").keypress(function(event){
        if (event.which == 13) {
            search_fullfilmentview();
        }
    });
    $("select#vendorname").unbind('change').change(function(){
        search_fullfilmentview();
    });
    $("input#itemname").keypress(function(event){
        if (event.which == 13) {
            search_fullfilmentview();
        }
    });    
    $("div#searchflflmbtn").unbind('click').click(function(){
        search_fullfilmentview();
    });    
    // Clean Search
    $("div#clearflflmbtn").unbind('click').click(function() {
        $("input#ordernumber").val('');
        $("input#itemname").val('');
        // $("input#vendorname").val('');
        $("select#vendorname").val('');
        search_fullfilmentview();
    });
})
function search_fullfilmentview() {
    var params=new Array();
    params.push({name: 'q', value: 'searchfullfilm'});
    params.push({name: 'order_num', value: $("input#ordernumber").val()});
    // params.push({name: 'vendor', value: $("input#vendorname").val()});
    params.push({name: 'vendor', value: $("select#vendorname").val()});
    params.push({name: 'item', value: $("input#itemname").val()});
    params.push({name: 'orders', value: $("select#ordersnumberselect").val()});
    var url="fl_ajax_return.php";
    $("#loader").show();
    $.post(url, params, function(response){
        if (response.error=='') {            
            $("div#task_area").empty().html(response.content);
            $("#loader").hide();
        } else {
            $("#loader").hide();
            alert(response.error);
        }
    },'json');    
}
</script>
</head>
<body onload="art_hide_modules()"  ><div id="loader"><img src="../images/loader.gif" /></div>
<div style="position:absolute; top:0; left:45%; z-index:1000;"><iframe name="atchiframe" src="attach_iframe.php" frameborder="0" marginwidth="0" marginheight="0"  height="19" width="175"></iframe></div>
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>



<?php
	if(isset($_GET['msg']) && $_GET['msg']=='error')
		echo "<div class=\"error\">Unable to Process File.</div>";
	else if(isset($_GET['msg']) && $_GET['msg']=='success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
	?>
 <div class="content"
 <b style=" color:#2D2D2D; margin-left:20px; font-size:14px;">Fullfillment Overview </b>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


Orders:<select onchange="display_or(this.value);" id="ordersnumberselect">

 <?php
 if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
 echo "<option value=".$_SESSION['or'].">".$_SESSION['or']."-".($_SESSION['or']+500)."</option>";

// for($i=22000; $i<30000; $i+=500)
// echo "<option value=$i>$i-".($i+500)."</option>";
//  for($i=22000; $i<30000; $i+=500)

  for($i=22000; $i<65000; $i+=500)
 {

 if(($i%1000) == 0)
 echo "<option style=\"background-color:#ececec;font-weight:bold;font-size:11px; color:#3A3A3A; padding:3px 3px;\" value=$i <b>$i-".($i+499)."</b></option>";
 else
 echo "<option style=\"font-size:10px; padding:3px 3px;\" value=$i>&nbsp;$i-".($i+499)."</option>";

 }
 ?>
 </select>

 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <span <?php echo (!isset($_SESSION['whr'])) ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=all">ALL</a></span>
 <span <?php echo (isset($_SESSION['whr']) && $_SESSION['whr']=='ch_placed_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_placed_ck">Not Placed</a></span>
 <span <?php echo (isset($_SESSION['whr']) && $_SESSION['whr']=='ch_conf_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_conf_ck">Not Confirmed</a></span>
 <span <?php echo (isset($_SESSION['whr']) && $_SESSION['whr']=='ch_ship_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_ship_ck">Not Shipped</a></span>
 <span <?php echo (isset($_SESSION['whr']) && $_SESSION['whr']=='ch_cust_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_cust_ck">Cust Trk</a></span>
 <span <?php echo (isset($_SESSION['whr']) && $_SESSION['whr']=='ch_issue_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_issue_ck">Issues</a></span>
 <span class='_sort'><a id="fullfill_export" href="javascript:void(0)">Export</a></span>
 <div style="  margin:5px 10px 0px 10px; float:left;"  >
     <ul class="ff_mn">
        <li class=cat_active ><a href="fullfillment.php">Fullfillment</a></li>
        <li class=cat_inactive ><a href="chinese.php">Chinese</a></li>
        <li class=cat_inactive ><a href="art3.php">Art Overview</a></li>
        <li class=cat_inactive ><a href="pobydate.php">POs by Date</a></li>
    </ul>
 </div>
 <div class="fulfillmentsearcharea" style="float: left; margin-top: 10px;">
     <input type="text" style="width: 50px; float: left;" id="ordernumber" placeholder="Order#"/>
     <select id="vendorname" style="width: 120px; float: left; margin-left: 4px;">
         <option value="">Select Vendor</option>
         <?php $vendcnt=count($ven_list['v_abbr']);?>
         <?php for($i=0; $i<$vendcnt; $i++) { ?>
            <option value="<?=$ven_list['v_abbr'][$i]?>"><?=$ven_list['v_abbr'][$i]?></option>             
         <?php } ?>
     </select>
     <!-- <input type="text" style="width: 120px" id="vendorname" placeholder="Vendor"/> -->
     <input type="text" style="width: 120px; float: left; margin-left: 3px;" id="itemname" placeholder="Item"/>
     <div class="searchflflmbtn" id="searchflflmbtn">&nbsp;</div>
     <div class="clearflflmbtn" id="clearflflmbtn">&nbsp;</div>
 </div>
 
 <div class="clear"></div>
 <div ><table width="970px" border="0" cellpadding="0" cellspacing="0"  class="task_today_entry"  style="margin-left:10px; border:1px #181818 solid; border-bottom:1px #ababab solid; " >
 <tr class="ffTableHead"   >

 <td width="45px" align="center" class=ffOrderSort><?php echo (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? '<a  href="fullfillment.php">' : '<a  href="fullfillment.php?sort=desc">'; ?>Order</a></td>
 <td width="120px" align="center">Customer</td>
  <td width="115px" align="center">Description</td>
 <td width="35px" align="center">Ap</td>
      <td width="35px" align="center">Opt</td>
  <td width="70px" align="center">ShipDt</td>
   <td width="35px" align="center">PO</td>
    <td width="75px" align="center">Vendor</td>
     <td width="35px" align="center">Pl</td>
          <td width="35px" align="center">Conf</td>
       <td width="100px" align="center">Shipped</td>
        <td width="35px" align="center">Cust</td>
                 <td width="35px" align="center">Issue</td>
       <td width="175px" align="center">Notes</td>
 </tr>

 </table></div>
 <div style="border:1px #181818 solid; border-top:none;  margin:0px 10px 10px 10px;">


<div style=" height:690px; padding:0px; overflow:auto;  width:987px;">


<div id="task_area" >
<?php
if(isset($_GET['or']) and is_numeric($_GET['or']) )
$ind = $_GET['or'];
else
$ind = 22000;
$point = $ind;

if(!empty($key_c['msg'][0]))
echo "<h4>".$key_c['msg'][0]."</h4>";

for($i=0;$i<sizeof($key_c['1']['1']); $i++)
{
$point=$key_c['1']['1'][$i];
echo "<div>";
echo "<table width=970px border=0 cellpadding=0 cellspacing=0 class=task_today_entry >";
echo "<tr ".col_bg('#ececec',$i)." class=hilite>";
echo "<td width=\"45px\" class=tdbg  align=center  >".$key_c[$point]['af_order_id'][0]."</td>";
echo "<td width=\"120px\"   align=\"center\" id=af_cust$i class=\"tdbg small_font\" ondblclick=edit_af($i,".$key_c[$point]['af_order_id'][0].",".$key_c[$point]['ch_id'][0].")><a class=info href=#>".(isset($key_c[$point]['af_cust'][0]) ? substr($key_c[$point]['af_cust'][0],0,19) : '')."<span>".(isset($key_c[$point]['af_cust'][0]) ? $key_c[$point]['af_cust'][0] : '')."</span></a></td>";
echo "<td width=\"115px\" class=\"tdbg small_font\"    align=\"center\" id=af_desc$i  ondblclick=edit_af($i,".$key_c[$point]['af_order_id'][0].",".$key_c[$point]['ch_id'][0].")><a class=info href=#>".(isset($key_c[$point]['af_desc'][0]) ? substr($key_c[$point]['af_desc'][0],0,19) : '')."<span>".isset($key_c[$point]['af_desc'][0]) ? $key_c[$point]['af_desc'][0] :''."</span></a></td>";

echo  "<td width=\"35px\"  align=\"center\"  bgcolor=\"".$key_c[$point]['clr_appr'][0]."\"     ><input type=checkbox onclick=\"return false\" name=af_appr_ck ";
if($key_c[$point]['af_appr_ck'][0] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" class=tdbg align=\"center\" >";
if(isset($att['art'][$key_c[$point]['af_order_id'][0]]) && $att['art'][$key_c[$point]['af_order_id'][0]] == 'yes')
echo "<span class=get_art_files id=".$key_c[$point]['af_order_id'][0]."  onclick=send_data(".$key_c[$point]['af_order_id'][0].",'art','no',".$key_c[$point]['ch_id'][0].",'".$key_c[$point]['ch_po'][0]."')><img class=point src=\"../images/open_icon.gif\"></span></span>";
else echo "<span>NA</span>";
echo "</td>";
echo "<td width=\"70px\"   align=\"center\" id=af_shdate$i bgcolor=\"".$key_c[$point]['ch_ship'][0]."\"  ondblclick=edit_af($i,".$key_c[$point]['af_order_id'][0].",".$key_c[$point]['ch_id'][0].")>".print_date($key_c[$point]['ch_ship_date'][0])."</td>";
if(sizeof($key_c[$point]['af_order_id']) ==1 )
echo  "<td width=\"35px\" bgcolor=\"".$key_c[$point]['clr_ven'][0]."\" id=af_po$i align=\"center\"><span onclick=add_PO($i,".$key_c[$point]['ch_id'][0].",'$po_title[0]',".$key_c[$point]['af_order_id'][0].")>A</span></td>";
else
echo  "<td width=\"35px\" id=af_po$i bgcolor=\"".$key_c[$point]['clr_ven'][0]."\" align=\"center\">A</td>";
echo  "<td width=\"75px\" align=\"center\"  bgcolor=\"".$key_c[$point]['clr_ven'][0]."\"  id=af_ven$i  ondblclick=edit_af($i,".$key_c[$point]['af_order_id'][0].",".$key_c[$point]['ch_id'][0].")>".$key_c[$point]['ch_vendor'][0]."</td>";

	echo "<td align=\"center\"    width=\"35px\"
			 				 >";
			if(isset($att['poart'][$key_c[$point]['ch_id'][0]]) && $att['poart'][$key_c[$point]['ch_id'][0]] == 'yes')
			echo "<span class=get_art_files id=".$key_c[$point]['ch_id'][0]."><span id=icon_".$key_c[$point]['ch_id'][0]." onclick=send_data(".$key_c[$point]['af_order_id'][0].",'poart','yes',".$key_c[$point]['ch_id'][0].",'".$key_c[$point]['ch_po'][0]."')><img class=point src=\"../images/open_icon.png\"></span></span>";
			else
			echo "<span id=icon_".$key_c[$point]['ch_id'][0]." onclick=send_data(".$key_c[$point]['af_order_id'][0].",'poart','yes',".$key_c[$point]['ch_id'][0].",'".$key_c[$point]['ch_po'][0]."') class=point ><img src=\"../images/attch_icon.png\"></span>";
echo "</td>";
/*echo  "<td align=\"center\" bgcolor=\"".$key_c[$point]['clr_pl'][0]."\"  width=\"35px\"
			 id=ch_placed_ck".$key_c[$point]['ch_id'][0]." >
			 <input type=checkbox
			 onclick=\"child_toggle(".$key_c[$point]['ch_id'][0].",this,$i,'ch_placed_ck')\"
			 id=_pl".$key_c[$point]['ch_id'][0]."
			 name=ch_placed_ck ";
					if($key_c[$point]['ch_placed_ck'][0] == 'yes')
					echo " checked value=yes ></td>";
					else echo " value=no ></td>";
 */
echo  "<td align=\"center\"  bgcolor=\"".$key_c[$point]['clr_conf'][0]."\"  width=\"35px\"
			 id=ch_conf_ck".$key_c[$point]['ch_id'][0].">
			 <input type=checkbox
			 onclick=\"child_toggle(".$key_c[$point]['ch_id'][0].",this,$i,'ch_conf_ck')\"
			 id=_conf".$key_c[$point]['ch_id'][0]."
			 name=ch_conf_ck ";
					if($key_c[$point]['ch_conf_ck'][0] == 'yes')
					echo " checked value=yes ></td>";
					else echo " value=no ></td>";

echo  "<td align=\"left\"  bgcolor=\"".$key_c[$point]['clr_ship'][0]."\" width=\"100px\"
			ondblclick=edit_af($i,".$key_c[$point]['af_order_id'][0].",".$key_c[$point]['ch_id'][0].")
			id=ch_ship_ck".$key_c[$point]['ch_id'][0].">
			<input type=checkbox
			onclick=\"child_toggle(".$key_c[$point]['ch_id'][0].",this,$i,'ch_ship_ck')\"
			id=_ship".$key_c[$point]['ch_id'][0]."
			name=ch_ship_ck ";
					if($key_c[$point]['ch_ship_ck'][0] == 'yes')
					echo " checked value=yes >";
					else echo " value=no >";
					echo "<span id=af_shnotes$i  >".substr($key_c[$point]['ch_ship_notes'][0],0,10)."</span></td>";

 echo  "<td  class=tdbg align=\"center\" bgcolor=\"".$key_c[$point]['clr_cust'][0]."\"  width=\"35px\"
							 id=ch_cust_ck".$key_c[$point]['ch_id'][0]." >
							<input type=checkbox
							onclick=\"child_toggle(".$key_c[$point]['ch_id'][0].",this,$i,'ch_cust_ck')\"
							name=ch_cust_ck ";
							if($key_c[$point]['ch_cust_ck'][0] == 'yes')
							echo " checked value=yes ></td>";
							else echo " value=no ></td>";

echo  "<td align=\"center\"    bgcolor=\"".$key_c[$point]['clr_is'][0]."\" width=\"35px\"
 			id=ch_issue_ck".$key_c[$point]['ch_id'][0]." >
			<input type=checkbox
			onclick=\"child_toggle(".$key_c[$point]['ch_id'][0].",this,$i,'ch_issue_ck')\"
			name=ch_issue_ck ";
					if($key_c[$point]['ch_issue_ck'][0] == 'yes')
					echo " checked value=yes ></td>";
					else echo " value=no ></td>";

echo "<td width=\"175px\" align=\"center\" id=af_notes$i  ondblclick=edit_af($i,".$key_c[$point]['af_order_id'][0].",".$key_c[$point]['ch_id'][0].") ><a class=info href=#>".substr($key_c[$point]['ch_notes'][0],0,25)."<span>".$key_c[$point]['ch_notes'][0]."</span></a></td>";

echo  "</tr>";
echo  "</table>";
echo  "</div>";
if(sizeof($key_c[$point]['af_order_id']) ==1 )
echo "<div id=po_child".($key_c[$point]['ch_id'][0]+1)."></div>";

		for($j=1;$j<sizeof($key_c[$point]['af_order_id']); $j++)
		{
			echo "<div id=po_child".$key_c[$point]['ch_id'][$j]." >";
			echo "<table width=970px border=0 cellpadding=0 cellspacing=0 class=task_today_entry >";
			echo "<tr  ".col_bg('#ececec',$i)." class=hilite>";
			echo "<td width=\"45px\"  class=tdbg align=center >&nbsp;</td>";
			echo "<td width=\"120px\" class=tdbg  >&nbsp;</td>";
			echo "<td width=\"115px\" class=tdbg >&nbsp;</td>";
			echo  "<td width=\"35px\" >&nbsp;</td>";
			echo  "<td width=\"35px\"  class=tdbg>&nbsp;</td>";

			echo "<td   width=\"70px\"   align=\"center\"  bgcolor=\"".$key_c[$point]['ch_ship'][$j]."\"   id=ch_shdate".$key_c[$point]['ch_id'][$j]."   ondblclick=edit_ch(".$key_c[$point]['ch_id'][$j].")>".print_date($key_c[$point]['ch_ship_date'][$j])."</td>";
			if(($j+1) == sizeof($key_c[$point]['af_order_id']) && $j<=2)
			echo  "<td width=\"35px\" id=ch_po".$key_c[$point]['ch_id'][$j]." bgcolor=\"".$key_c[$point]['clr_ven'][$j]."\" align=\"center\"><span onclick=add_PO($i,".$key_c[$point]['ch_id'][$j].",'$po_title[$j]',".$key_c[$point]['af_order_id'][$j].")>".$key_c[$point]['ch_po'][$j]."</span></td>";
			else
		    echo  "<td width=\"35px\" id=ch_po".$key_c[$point]['ch_id'][$j]."  bgcolor=\"".$key_c[$point]['clr_ven'][$j]."\" align=\"center\">".$key_c[$point]['ch_po'][$j]."</td>";

			echo  "<td width=\"75px\"  bgcolor=\"".$key_c[$point]['clr_ven'][$j]."\"  align=\"center\" id=ch_ven".$key_c[$point]['ch_id'][$j]."  ondblclick=edit_ch(".$key_c[$point]['ch_id'][$j].")>".$key_c[$point]['ch_vendor'][$j]."</td>";

			echo "<td align=\"center\"   width=\"35px\"
			 				 >";
			if($att['poart'][$key_c[$point]['ch_id'][$j]] == 'yes')
			echo "<span class=get_art_files id=".$key_c[$point]['ch_id'][$j]."><span  id=icon_".$key_c[$point]['ch_id'][$j]."  onclick=send_data(".$key_c[$point]['af_order_id'][$j].",'poart','yes',".$key_c[$point]['ch_id'][$j].",'".$key_c[$point]['ch_po'][$j]."')><img class=point src=\"../images/open_icon.png\"></span></span>";
			else
			echo "<span  id=icon_".$key_c[$point]['ch_id'][$j]."  onclick=send_data(".$key_c[$point]['af_order_id'][$j].",'poart','yes',".$key_c[$point]['ch_id'][$j].",'".$key_c[$point]['ch_po'][$j]."') class=point ><img src=\"../images/attch_icon.png\"></span>";
echo "</td>";
			/*echo  "<td align=\"center\" bgcolor=\"".$key_c[$point]['clr_pl'][$j]."\"  width=\"35px\"
			 				id=ch_placed_ck".$key_c[$point]['ch_id'][$j]." >
							<input type=checkbox
							onclick=\"child_toggle(".$key_c[$point]['ch_id'][$j].",this,$i,'ch_placed_ck')\"
							name=ch_placed_ck ";
							if($key_c[$point]['ch_placed_ck'][$j] == 'yes')
							echo " checked value=yes ></td>";
							else echo " value=no ></td>";
 */
            echo  "<td align=\"center\" bgcolor=\"".$key_c[$point]['clr_conf'][$j]."\"  width=\"35px\"
							 id=ch_conf_ck".$key_c[$point]['ch_id'][$j]." >
							<input type=checkbox
							onclick=\"child_toggle(".$key_c[$point]['ch_id'][$j].",this,$i,'ch_conf_ck')\"
							name=ch_conf_ck ";
							if($key_c[$point]['ch_conf_ck'][$j] == 'yes')
							echo " checked value=yes ></td>";
							else echo " value=no ></td>";

            echo  "<td    width=\"100px\" align=\"left\"   bgcolor=\"".$key_c[$point]['clr_ship'][$j]."\"
							ondblclick=edit_ch(".$key_c[$point]['ch_id'][$j].")
							id=ch_ship_ck".$key_c[$point]['ch_id'][$j].">
							<input type=checkbox
							onclick=\"child_toggle(".$key_c[$point]['ch_id'][$j].",this,$i,'ch_ship_ck')\"
							name=ch_ship_ck ";
							if($key_c[$point]['ch_ship_ck'][$j] == 'yes')
							echo " checked value=yes >";
							else echo " value=no >";
							echo "<span id=ch_shnotes".$key_c[$point]['ch_id'][$j]."> ".substr($key_c[$point]['ch_ship_notes'][$j],0,10)."</span></td>";

			 echo  "<td  class=tdbg align=\"center\" bgcolor=\"".$key_c[$point]['clr_cust'][$j]."\"  width=\"35px\"
							 id=ch_cust_ck".$key_c[$point]['ch_id'][$j]." >
							<input type=checkbox
							onclick=\"child_toggle(".$key_c[$point]['ch_id'][$j].",this,$i,'ch_cust_ck')\"
							name=ch_cust_ck ";
							if($key_c[$point]['ch_cust_ck'][$j] == 'yes')
							echo " checked value=yes ></td>";
							else echo " value=no ></td>";

            echo  "<td align=\"center\" bgcolor=\"".$key_c[$point]['clr_is'][$j]."\"  width=\"35px\"
							 id=ch_issue_ck".$key_c[$point]['ch_id'][$j]." >
							<input type=checkbox
							onclick=\"child_toggle(".$key_c[$point]['ch_id'][$j].",this,$i,'ch_issue_ck')\"
							name=ch_issue_ck ";
							if($key_c[$point]['ch_issue_ck'][$j] == 'yes')
							echo " checked value=yes ></td>";
							else echo " value=no ></td>";

            echo "<td    width=\"175px\" align=\"center\" id=ch_notes".$key_c[$point]['ch_id'][$j]."  ondblclick=edit_ch(".$key_c[$point]['ch_id'][$j].")    ><a class=info href=#>".substr($key_c[$point]['ch_notes'][$j],0,23)."<span>".$key_c[$point]['ch_notes'][$j]."</span></a></td>";

	        echo  "</tr>";
			echo  "</table>";
			echo  "</div>";
			if(($j+1) == sizeof($key_c[$point]['af_order_id']) && $j<=2 )
			echo "<div id=po_child".($key_c[$point]['ch_id'][$j]+1)."></div>";


		}
$point++;
//$clr++;
}
?>
<input type=hidden name=_type id=att_type value=poart>

</div>


</div>
</div>
</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>
<script type="text/javascript">
$('#loader').css('display','none');
</script>
</body>
</html>
