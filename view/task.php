<?php include('../controller/task_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="task_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>



<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Task Management</title>
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
 <b style=" color:#2D2D2D; margin-left:20px; font-size:14px;">Task Management</b>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
 <span style="font-size:14px;">
 <span <?php if($_SESSION['status'] == 'closed') echo "class=live_link"; else echo "class=dead_link"; ?>><a href="task.php?status=open&cat=<?php echo $cat; if(isset($_GET['tsec'])) echo "&tsec=".$_GET['tsec']; ?>" >Incomplete</a></span>  |  
 <span <?php if($_SESSION['status'] == 'open') echo "class=live_link"; else echo "class=dead_link"; ?> ><a href="task.php?status=closed&cat=<?php echo $cat;  if(isset($_GET['tsec'])) echo "&tsec=".$_GET['tsec'];?>" >Complete</a></span>
 </span>
 
 <div style="  margin:5px 10px 0px 10px;" ><table cellspacing="0" width="100%" cellpadding="0"><tr>
 <?php
 for($i=0;$i<sizeof($cat_menu['id']);$i++)
 {
 
 if(!isset($_GET['cat']) && $i==0){
 echo "<td class=cat_active><a href=\"task.php?cat=".$cat_menu['id'][$i]."\">".$cat_menu['name'][$i]."</a></td>"; $cat_name="Business"; }
 else if(isset($_GET['cat']) && $cat_menu['id'][$i] == $_GET['cat'] ){
 echo  "<td class=cat_active ><a href=\"task.php?cat=".$cat_menu['id'][$i]."\">".$cat_menu['name'][$i]."</a></td>"; $cat_name = $cat_menu['name'][$i]; }
 else
 echo "<td class=cat_inactive ><a href=\"task.php?cat=".$cat_menu['id'][$i]."\">".$cat_menu['name'][$i]."</a></td>";
 
 
 }
 ?><td>&nbsp;<?php if(sizeof($cat_menu['id'])==8) echo "&nbsp;"; else { ?><span onclick="task_cat_add()" class="point">+</span> <?php } ?></td></tr></table>
 </div>
 
 <div style="border-top:1px #ABABAB dotted; border-left:1px #6C6C6C solid;border-right:1px #6C6C6C solid;border-bottom:1px #6C6C6C solid; margin:0px 10px 10px 10px;">
 <div style=" padding:2px;margin-top:0px;text-align:center; " >
 <span class="title"  >Highlighted Tasks:</span><span  onclick="task_section_add()" class="point new" >New</span><input type="hidden" id="get_tsec" size="2" value="<?php echo $_GET['tsec']; ?>" /><input type="hidden" id="task_cat" name="task_category" value="<?php echo $cat; ?>" />

</div>
<?php if(sizeof($slider['sec_id']) > 0) { ?>
 <div style=" margin:0px 13px 0px 13px;  overflow:auto;  height:40px;">
<table border="0" cellpadding="2" cellspacing="0" ><tr>
<?php for($i=0;$i<sizeof($slider['sec_id']);$i++)
{
if($_GET['tsec'] == $slider['sec_id'][$i] )
echo "<td><input type=text readonly=\"readonly\" onclick=\"DisplaySection(".$slider['sec_id'][$i].")\" size=18 class=slider_menu_box_active value=\"".$slider['sec_name'][$i]."\"></td>";
else
echo "<td><input type=text readonly=\"readonly\" onclick=\"DisplaySection(".$slider['sec_id'][$i].")\" size=18 class=slider_menu_box value=\"".$slider['sec_name'][$i]."\"></td>";
}  ?>
</tr></table>
</div>
<?php } ?>

<div style=" height:575px; overflow:auto;  width:970px;">
<?php if(isset($_GET['tsec'])) { ?>
<div class="task_heading_cover"> <span id="task_menu_active"><?php echo $sec_name['section_name']; ?></span></div>
<div class="task_heading">
<table width="915px" border="0" cellpadding="3" cellspacing="0" class="task_today_entry"  >
 <tr class="active_head">
 <td width="15px">&nbsp;</td>
 <td width="35px">Done</td>
 <td width="780px" align="center">Reminder</td>
 
 <td width="35px" align="center">Move</td>
 <td width="35px" align="center">Hi-lt</td>
 </tr>
 </table>
</div>

 <div class="task_today_cover" id="active_area">
 
 <div><?php echo ($disp2=='') ? 'No Tasks': $disp2; ?></div>
 </div>
 <?php } ?>
 
  <div id="new_sec" onclick="task_section_close()">&nbsp;</div>
<div class="title">All Tasks : <?php echo $cat_name; ?> </div>
 <div class="task_today_cover_all"  >
 <div><table width="915px" border="0" cellpadding="3" cellspacing="0" class="task_today_entry" >
 <tr  class="all_task_table_head">
 <td width="15px">&nbsp;</td>
 <td width="35px">Done</td>
 <td width="780px" align="center">Reminder</td>
  <td width="35px" align="center">Move</td>
 <td width="35px" align="center">Hi-lt</td>
 </tr>
 <tr>
 <td width="15px">&nbsp;</td>
 <td width="35px">&nbsp;</td>
 <td width="780px"><textarea id="task_msg" rows="1" class=task_msg cols="100"></textarea>&nbsp;<input  type="button" onclick="add_task('task',<?php echo ($_GET['tsec'] >0 ) ? $_GET['tsec'] : 0; ?>)" value="save" id="save"></td>
 
 <td width="35px">&nbsp;</td>
 <td width="35px">&nbsp;</td>
 </tr>
 </table></div>
<div id="task_area">
<?php echo $disp_all_tasks; ?>
</div>
 
</div> 
 
 </div>
</div>
</div>

<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>