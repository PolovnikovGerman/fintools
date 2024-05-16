<?php include('../controller/af_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="af_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="attach_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function(){
        $("a#exportart").click(function(){
           export_art();
        });
        setInterval(function(){cache_clear()},300000);
    });
    
    function cache_clear() {        
        var start=$("select#ordersdatafiltr").val();
        var url="artrefresh.php";
        $.post(url, {'start': start}, function(response){
            if (response.errors=='') {
                $("div#task_area").empty().html(response.content);                
            } else {
                alert(response.errors);
            }
        },'json');
//        window.location.reload(true);
//        alert('reloaded');
    }        

    function export_art() {
        if (confirm('You realy want to export data into excell ?')) {
            var url='art_export.php';
            $('#loader').empty().html('<img src="../images/loader.gif" />');
            $.post(url, {}, function(response){
                $('#loader').empty();
                if (response.errors=='') {
                    window.location.href=response.url;
                } else {
                    alert(response.errors);
                }
            }, 'json');
        }
    }
</script>

<title>BT System - Art Overview</title>
</head>
<body onload="art_hide_modules()"  >
<div style="position:absolute; top:0; left:45%; z-index:1000;"><iframe name="atchiframe" src="attach_iframe.php" frameborder="0" marginwidth="0" marginheight="0"  height="19" width="175"></iframe></div>
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>


<?php
	if($_GET['msg']=='error')
		echo "<div class=\"error\">Unable to Process File.</div>";
	else if($_GET['msg']=='success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
	?>
 <div class="content">
 <b style=" color:#2D2D2D; margin-left:20px; font-size:14px;">Art Overview</b>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 Orders:<select onchange="display_or(this.value);" id="ordersdatafiltr">

 <?php
 if(isset($_SESSION['or']) && is_numeric($_SESSION['or'])){
 echo "<option value=".$_SESSION['or'].">".$_SESSION['or']."-".($_SESSION['or']+499)."</option>";
echo "<option>----------------------</option>";}
 for($i=22000; $i<75000; $i+=500)
 {

 if(($i%1000) == 0)
 echo "<option style=\"background-color:#ececec;font-weight:bold;font-size:11px; color:#3A3A3A; padding:3px 3px;\" value=$i <b>$i-".($i+499)."</b></option>";
 else
 echo "<option style=\"font-size:10px; padding:3px 3px;\" value=$i>&nbsp;$i-".($i+499)."</option>";

 }
 ?>
 </select>
 <span class='_sort'><a id="exportart" href="javascript:void(0)">Export</a></span>
 <div style="  margin:5px 10px 0px 10px;" ><ul class="ff_mn">
 <?php


 echo "<li class=cat_active><a href=\"art.php\">Orders in QB</a></li>";
 echo "<li class=cat_inactive><a href=\"art2.php\">Not in QB</a></li>";


 ?></ul>
 </div>

 <div><table width="970px" border="0" cellpadding="0" cellspacing="0"   style="margin-left:10px; border:1px #181818 solid; border-bottom:1px #ABABAB solid;  " >
 <tr class="ffTableHead" >
 <td width="45px" align="center">Rush</td>
 <td width="45px">order</td>
 <td width="120px" align="center">Customer</td>
  <td width="225px" align="center">Description</td>
  <td width="60px" align="center">Date</td>
 <td width="35px" align="center">Art</td>
  <td width="35px" align="center">Redr</td>
   <td width="35px" align="center">Vec</td>
    <td width="35px" align="center">Pr</td>
     <td width="35px" align="center">Ap</td>
      <td width="35px" align="center">App</td>
       <td width="250px" align="center">Art Notes</td>
 </tr>

 </table></div>
 <div style=" border:1px #181818 solid; border-top:none; margin:0px 10px 10px 10px;">


<div style=" height:690px; overflow:auto;  width:987px;">


<div id="task_area">
<?php
for($i=0;$i<sizeof($key['af_order_id']); $i++)
{
echo "<div style=\"font-size:10px;\">";
echo "<table width=970px border=0 cellpadding=0 cellspacing=0  style=\"font-size:12px;\" >";
echo "<tr ".col_bg('#ececec',$i)." class=hilite>";
echo "<td align=\"center\" width=\"45px\" class=red_".$key['af_rush_ck'][$i]." id=art_rush$i><input type=checkbox  onclick=make_red(this,$i,".$key['af_order_id'][$i].") name=af_rush_ck ";
if($key['af_rush_ck'][$i] == 'yes') echo " checked=checked value=yes ></td>"; else echo " value=no ></td>";

echo "<td width=\"45px\"  class=red_".$key['af_rush_ck'][$i]."  id=art_ord$i>".$key['af_order_id'][$i]."</td>";
echo "<td width=\"120px\"  class=red_".$key['af_rush_ck'][$i]."  align=\"center\" id=art_cust$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_cust'][$i]."</td>";
echo "<td width=\"225px\"  class=red_".$key['af_rush_ck'][$i]."   align=\"center\" id=art_desc$i  ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".substr($key['af_desc'][$i],0,33)."</td>";
echo "<td width=\"60px\" align=center id=art_date$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".print_date($key['af_date'][$i])."</td>";

echo "<td  width=\"35px\" align=\"center\"  class=\"green_".$key['af_art_ck'][$i]." td_border\"  id=art_art$i ><input type=checkbox   onclick=make_green(this,$i,'art_art',".$key['af_order_id'][$i].")  name=af_art_ck";
if($key['af_art_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_redraw_ck'][$i]."  id=art_redraw$i><input type=checkbox  onclick=make_green(this,$i,'art_redraw',".$key['af_order_id'][$i].")  name=af_redraw_ck ";
if($key['af_redraw_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_vector_ck'][$i]."  id=art_vector$i ><input type=checkbox  onclick=make_green(this,$i,'art_vector',".$key['af_order_id'][$i].")  name=af_vector_ck ";
if($key['af_vector_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_proof_ck'][$i]."  id=art_proof$i ><input type=checkbox  onclick=make_green(this,$i,'art_proof',".$key['af_order_id'][$i].")  name=af_proof_ck ";
if($key['af_proof_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_appr_ck'][$i]."  id=art_appr$i ><input type=checkbox  onclick=make_green(this,$i,'art_appr',".$key['af_order_id'][$i].")  name=af_appr_ck ";
if($key['af_appr_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

if ($att[$key['af_order_id'][$i]] == 'yes')
{
echo "<td width=\"35px\" align=\"center\" class=td_border id=icon_".$key['af_order_id'][$i].">
<span onclick=send_data(".$key['af_order_id'][$i].",'art','yes')><img class=point src=\"../images/open_icon.gif\"></span><input type=hidden name=_type id=att_type value=art></td>";
}
else
{
echo "<td width=\"35px\" align=\"center\" class=td_border id=icon_".$key['af_order_id'][$i].">
<span onclick=send_data(".$key['af_order_id'][$i].",'art','yes') class=point ><img src=\"../images/attch_icon.png\"></span></td>";
}

echo "<td width=\"250px\" align=\"center\" id=art_notes$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_notes'][$i]."</td>
</tr>
</table>
</div>";
}

?>
 <div id="loader"></div>
</div>


</div>
</div>
</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>

</div>

</body>
</html>
