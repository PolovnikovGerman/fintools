<?php include('../controller/af2_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="af2_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>



<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Art Overview</title>
</head>
<body onload="hide_modules()"  >
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
 Orders:<select onchange="display_or(this.value);">
 
 <?php
 if(isset($_GET['or']))
 echo "<option value=".$_GET['or'].">".$_GET['or']."-".($_GET['or']+500)."</option>"; 
 
 for($i=0; $i<55000; $i+=500)
 echo "<option value=$i>$i-".($i+500)."</option>";
 
 ?>
 
 </select>
 
 <div style="  margin:5px 10px 0px 10px;" ><ul class="ff_mn">
 <?php
  
 
 echo  "<li class=cat_inactive ><a href=\"art.php\">Orders in QB</a></li>"; 
 echo "<li class=cat_active ><a href=\"art2.php\">Not in QB</a></li>";
  
 
 ?></ul>
 </div>
 
  
 <div><table width="970px" border="0" cellpadding="1" cellspacing="0"  class="task_today_entry"   style="margin-left:10px; border:1px #181818 solid; border-bottom:1px #ababab solid;" >
 <tr class="ffTableHead" >
 <td width="45px" align="center">Rush</td>
 <td width="45px">order</td>
 <td width="130px" align="center">Customer</td>
  <td width="250px" align="center">Description</td>
 <td width="35px" align="center">Art</td>
  <td width="35px" align="center">Redr</td>
   <td width="35px" align="center">Vec</td>
    <td width="35px" align="center">Proof</td>
     <td width="35px" align="center">Appr</td>
    
       <td width="275px" align="center">Art Notes</td>
 </tr>
 
 </table></div>
 <div style="border:1px #181818 solid; border-top:none; margin:0px 10px 10px 10px;">


<div style=" height:690px; overflow:auto;  width:987px;">

 
<div id="task_area">
<?php
for($i=0;$i<sizeof($key['af_order_id']); $i++)
{
echo "<div style=\"font-size:10px;\">";
echo "<table width=970px border=0 cellpadding=1 cellspacing=0 class=task_today_entry style=\"font-size:12px;\" >";
echo "<tr ".col_bg('#ececec',$i).">";
echo "<td align=\"center\" width=\"45px\" class=red_".$key['af_rush_ck'][$i]." id=art_rush$i><input type=checkbox  onclick=make_red(this,$i,".$key['af_order_id'][$i].") name=af_rush_ck "; 
if($key['af_rush_ck'][$i] == 'yes') echo " checked=checked value=yes ></td>"; else echo " value=no ></td>";

echo "<td width=\"45px\"  class=red_".$key['af_rush_ck'][$i]."  id=art_ord$i>".$key['af_order_id'][$i]."</td>";
echo "<td width=\"130px\"  class=red_".$key['af_rush_ck'][$i]."  align=\"center\" id=art_cust$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_cust'][$i]."</td>";
echo "<td width=\"250px\"  class=red_".$key['af_rush_ck'][$i]."  align=\"center\" id=art_desc$i  ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_desc'][$i]."</td>";

echo "<td width=\"35px\" align=\"center\"  class=green_".$key['af_art_ck'][$i]."  id=art_art$i ><input type=checkbox   onclick=make_green(this,$i,'art_art',".$key['af_order_id'][$i].")  name=af_art_ck";
if($key['af_art_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_redraw_ck'][$i]."  id=art_redraw$i><input type=checkbox  onclick=make_green(this,$i,'art_redraw',".$key['af_order_id'][$i].")  name=af_redraw_ck ";
if($key['af_redraw_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_vector_ck'][$i]."  id=art_vector$i ><input type=checkbox  onclick=make_green(this,$i,'art_vector',".$key['af_order_id'][$i].")  name=af_vector_ck ";
if($key['af_vector_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_proof_ck'][$i]."  id=art_proof$i ><input type=checkbox  onclick=make_green(this,$i,'art_proof',".$key['af_order_id'][$i].")  name=af_proof_ck ";
if($key['af_proof_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";

echo  "<td width=\"35px\" align=\"center\"  class=green_".$key['af_appr_ck'][$i]."  id=art_appr$i ><input type=checkbox  onclick=make_green(this,$i,'art_appr',".$key['af_order_id'][$i].")  name=af_appr_ck ";
if($key['af_appr_ck'][$i] == 'yes') echo " checked value=yes ></td>"; else echo " value=no ></td>";


echo "<td width=\"275px\" align=\"center\" id=art_notes$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_notes'][$i]."</td>
</tr>
</table>
</div>";
}

?>
 
</div> 
 

</div>
</div>
</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>
