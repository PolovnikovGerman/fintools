<?php
$out=array('errors'=>'Connection Lost. Please Reload page');
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/af_model.php');
include('../includes/utility_functions.php');
$obj=new db();

if(isset($_POST['start']) && is_numeric($_POST['start']) ) {
    $_SESSION['or']=$_POST['start'];
    $key = get_art();
} else {
    $key = get_art();
}
$att = chk_attach_files();
$out['errors']='';
$content='';
for($i=0;$i<sizeof($key['af_order_id']); $i++)
{
$content.="<div style=\"font-size:10px;\">";
$content.="<table width=970px border=0 cellpadding=0 cellspacing=0  style=\"font-size:12px;\" >";
$content.="<tr ".col_bg('#ececec',$i)." class=hilite>";
$content.="<td align=\"center\" width=\"45px\" class=red_".$key['af_rush_ck'][$i]." id=art_rush$i><input type=checkbox  onclick=make_red(this,$i,".$key['af_order_id'][$i].") name=af_rush_ck ";
if($key['af_rush_ck'][$i] == 'yes') $content.=" checked=checked value=yes ></td>"; else $content.=" value=no ></td>";

$content.="<td width=\"45px\"  class=red_".$key['af_rush_ck'][$i]."  id=art_ord$i>".$key['af_order_id'][$i]."</td>";
$content.="<td width=\"120px\"  class=red_".$key['af_rush_ck'][$i]."  align=\"center\" id=art_cust$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_cust'][$i]."</td>";
$content.="<td width=\"225px\"  class=red_".$key['af_rush_ck'][$i]."   align=\"center\" id=art_desc$i  ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".substr($key['af_desc'][$i],0,33)."</td>";
$content.="<td width=\"60px\" align=center id=art_date$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".print_date($key['af_date'][$i])."</td>";

$content.="<td  width=\"35px\" align=\"center\"  class=\"green_".$key['af_art_ck'][$i]." td_border\"  id=art_art$i ><input type=checkbox   onclick=make_green(this,$i,'art_art',".$key['af_order_id'][$i].")  name=af_art_ck";
if($key['af_art_ck'][$i] == 'yes') $content.=" checked value=yes ></td>"; else $content.=" value=no ></td>";

$content.="<td width=\"35px\" align=\"center\"  class=green_".$key['af_redraw_ck'][$i]."  id=art_redraw$i><input type=checkbox  onclick=make_green(this,$i,'art_redraw',".$key['af_order_id'][$i].")  name=af_redraw_ck ";
if($key['af_redraw_ck'][$i] == 'yes') $content.=" checked value=yes ></td>"; else $content.=" value=no ></td>";

$content.="<td width=\"35px\" align=\"center\"  class=green_".$key['af_vector_ck'][$i]."  id=art_vector$i ><input type=checkbox  onclick=make_green(this,$i,'art_vector',".$key['af_order_id'][$i].")  name=af_vector_ck ";
if($key['af_vector_ck'][$i] == 'yes') $content.=" checked value=yes ></td>"; else $content.=" value=no ></td>";

$content.="<td width=\"35px\" align=\"center\"  class=green_".$key['af_proof_ck'][$i]."  id=art_proof$i ><input type=checkbox  onclick=make_green(this,$i,'art_proof',".$key['af_order_id'][$i].")  name=af_proof_ck ";
if($key['af_proof_ck'][$i] == 'yes') $content.=" checked value=yes ></td>"; else $content.=" value=no ></td>";

$content.="<td width=\"35px\" align=\"center\"  class=green_".$key['af_appr_ck'][$i]."  id=art_appr$i ><input type=checkbox  onclick=make_green(this,$i,'art_appr',".$key['af_order_id'][$i].")  name=af_appr_ck ";
if($key['af_appr_ck'][$i] == 'yes') $content.=" checked value=yes ></td>"; else $content.=" value=no ></td>";

if ($att[$key['af_order_id'][$i]] == 'yes')
{
$content.="<td width=\"35px\" align=\"center\" class=td_border id=icon_".$key['af_order_id'][$i].">
<span onclick=send_data(".$key['af_order_id'][$i].",'art','yes')><img class=point src=\"../images/open_icon.gif\"></span><input type=hidden name=_type id=att_type value=art></td>";
}
else
{
$content.="<td width=\"35px\" align=\"center\" class=td_border id=icon_".$key['af_order_id'][$i].">
<span onclick=send_data(".$key['af_order_id'][$i].",'art','yes') class=point ><img src=\"../images/attch_icon.png\"></span></td>";
}

$content.="<td width=\"250px\" align=\"center\" id=art_notes$i ondblclick=edit_af($i,".$key['af_order_id'][$i].")>".$key['af_notes'][$i]."</td>";
$content.="</tr>";
$content.="</table>";
$content.="</div>";
}
$content.='<div id="loader"></div>';
$out['content']=$content;
echo json_encode($out);
ob_end_flush();
?>