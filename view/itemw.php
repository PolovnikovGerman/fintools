<?php include('../controller/itemw_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>Items - Bluetrack Inc</title>
</head>
<body onload="hide_modules()">
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

<?php

	if($itemw_data['error'] == 'error')
		echo "<div class=\"error\">".$itemw_data['error_msg']."</div>";
	else if($itemw_data['error'] == 'success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
		
	


?>
<div class="content"   onkeydown="changecss('.wrap','background-color','#c41aaa')" >
 <!--BEGINNING OF CONTENT HEAD -->
<div class="contenthead">
 <div id="leftparent">
	<div>
		 <?php 
		 
		 if(isset($_GET['inc']) && $_GET['inc'] == 'yes') 
	echo "<a href=\"items_list.php?ic=".$_GET['ic']."&&tbl=".$_GET['tbl']."\">&laquo;back to Item List</a>";
	else
		echo "<a href=\"items_list.php\"><span id=back_small>&laquo;back to Item List</span></a>";
		?>
	</div>
	<div id="title">
		<?php echo $itemw_data['title']; ?>
	</div>
    
    
     <div id="web_info">
    <?php if(!empty($itemw_data['is_id_fk'])) echo "<a href=\"edit_items.php?items_id=".$itemw_data['is_id_fk']."\" ><img src=\"../images/sys_info_ia.gif\" /></a>"; else echo "<span onClick=\"alert( 'System Id Key missing.' )\"><a href=\"\"  ><img src=\"../images/sys_info_a.gif\" /></a>"; ?>
	</div>
     <div id="sys_info"><img src="../images/web_info_a.gif" /></div>
    
    
 </div>
 <div id="rightparent">
    <div id="search"> <input type="text" name="search" value="search within Items" />&nbsp;<input type="button" id="button" value="Search" /></div>
    <div id="cancel"><a href="items_list.php"><input type="button" value="Cancel" id="cancel_button" /></a></div>
 </div>

 <div id="line">&nbsp;</div>
 </div><form name="itemw_form" method="post"  enctype="multipart/form-data" action="itemw.php">
 <!--END OF CONTENT HEAD -->
<!--BEGINNING OF CONTENT BODY-->
 <div class="content_body">
 	<!--beginning of content general-->
    <div class="content_left_wrap">
      <!-- ending of content general-->
      <!--beginning of content pricing-->
<div class="content_pricing_cover" >
    	<div id="subhead_pricing">Web Contents:<input type="hidden" name="wid" value="<?php echo $itemw_data['wid']; ?>" readonly="readonly" size="4" />
        <input type="hidden" name="is_id_fk" value="<?php echo $itemw_data['is_id_fk']; ?>" size="4" readonly="readonly" /><input type="hidden" name="title" value="<?php echo $itemw_data['title']; ?>" />
        </div>
    	<div class=" content_box" >
    
    		<div class="content_pricing_table" style="margin:5px;">
            <table cellpadding="1" cellspacing="0" border="0" width="100%">
            <tr><td  id="subhead_white">Internal Search:</td><td colspan="3"><textarea rows="2" cols="80" name="iw_search"><?php echo $itemw_data['iw_search']; ?></textarea></td></tr>
            <tr><td id="subhead_white">Description</td><td colspan="3"><textarea rows="2" cols="80" name="iw_desp"><?php echo $itemw_data['iw_desp']; ?></textarea></td></tr>
            <tr>
            <td id="subhead_white">Size:</td>
            <td><input type="text" name="iw_size" size="45" value="<?php echo $itemw_data['iw_size']; ?>" /></td>
            <td>&nbsp;</td>
            <td><select name="iw_similar1"><option>22-220045 Round</option></select></td>
            </tr>
            <tr>
            <td id="subhead_white">Web Page:</td>
            <td><input type="text" name="iw_page" size="45" value="<?php echo $itemw_data['iw_page']; ?>" /></td>
            <td id="subhead_white">Similar Items:</td>
            <td><select name="iw_similar2"><option>22-220045 Round</option></select></td>
            </tr>
            <tr>
            <td colspan="3">&nbsp;</td>
            <td><select name="iw_similar3"><option>22-220045 Round</option></select></td>
            </tr>
            </table>
            <table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr><td colspan="5" id="subhead_white">Images:( First is Main Image )</td></tr>
            <tr><?php
            for($i=0;$i<5;$i++)
            {
			if(empty($itemw_data['iw_imgname'.$i])) 
			echo "<td><img src=\"../images/noimage.jpg\" /></td>"; 
			else 
			echo "<td><img src=\"".$itemw_data['iw_imgname'.$i]."\" id=img$i height=120px width=120px></td>"; 
			}?>
            </tr>
            <tr>
            <?php
			for($i=0;$i<5;$i++)
            {
			 if(empty($itemw_data['iw_imgtitle'.$i])) 
			 echo "<td><input type=\"text\" name=\"iw_imgtitle[]\" /></td>"; 
			 else 
			 echo "<td><span id=title$i><img src=\"../images/sc.gif\" align=\"absbottom\" onclick=rm_img(".$itemw_data['iw_imgid'.$i].",".$i.")><input type=\"text\"  name=\"iw_imgtitle[]\" value=".$itemw_data['iw_imgtitle'.$i]." size=18 /></span>
			 </td> ";
			 }
			  ?>
             </tr>
             <tr>
            <td><input type="file" name="iw_img[]" size="7"  /></td>
            <td><input type="file" name="iw_img[]"  size="7"   /></td>
            <td><input type="file" name="iw_img[]"  size="7"   /></td>
            <td><input type="file" name="iw_img[]"  size="7"  /></td>
            <td><input type="file" name="iw_img[]"  size="7"   /></td>
             <tr>
            <?php
            for($i=5;$i<10;$i++)
            {
			if(empty($itemw_data['iw_imgname'.$i])) 
			echo "<td><img src=\"../images/noimage.jpg\" /></td>"; 
			else 
			echo "<td><img src=\"".$itemw_data['iw_imgname'.$i]."\" id=img$i height=120px width=120px></td>"; 
			}?>
            </tr>
            <tr>
            <?php
			for($i=5;$i<10;$i++)
            {
			 if(empty($itemw_data['iw_imgtitle'.$i])) 
			 echo "<td><input type=\"text\" name=\"iw_imgtitle[]\" /></td>"; 
			 else 
			 echo "<td><span id=title$i><img src=\"../images/sc.gif\" align=\"absbottom\" onclick=rm_img(".$itemw_data['iw_imgid'.$i].",".$i.")><input type=\"text\"  name=\"iw_imgtitle[]\" value=".$itemw_data['iw_imgtitle'.$i]." size=18 /></span>
			 </td> ";
			 }
			  ?>
             </tr>
             <tr>
            <td><input type="file" name="iw_img[]"  size="7"   /></td>
            <td><input type="file" name="iw_img[]"  size="7"   /></td>
            <td><input type="file" name="iw_img[]"  size="7"   /></td>
            <td><input type="file" name="iw_img[]"  size="7"  /></td>
            <td><input type="file" name="iw_img[]"  size="7"  /></td>
             <tr>
            </table>
            
            <!-- HIDDEN FIELDS FOR INCOMPLETE ITEMS -->
<?php if(isset($_GET['inc']) && $_GET['inc'] == 'yes') echo "<input type=hidden name=inc value=yes><input type=hidden name=inc_code value=".$_GET['items_id']."><input type=hidden name=ic value=".$_GET['ic']."><input type=hidden name=tbl value=".$_GET['tbl']."> <input type=hidden name=sys_id value=".$_GET['sys_id']."><input type=hidden name=sys_name value=".$_GET['sys_name'].">"; ?>
<!-- END OF HIDDEN FIELDS FOR INCOMPLETE ITEMS -->

            </div>
        </div>
</div>
    <!--ending of content pricing-->
    </div><!--end of content_left_wrap-->
    <div class="content_right_wrap">
    <div  id="subhead_competitors">Imprint Areas:</div>
    <div class="content_notes_history">
    <table cellpadding="2" cellspacing="0" border="0">
    <tr><td id="subhead_white" align="center">Location:</td><td id="subhead_white" align="center">Loc Size:</td><td id="subhead_white" align="center">Area Image:</td></tr>
    <?php
	for($i=0;$i<12;$i++)
	{
	if(empty($itemw_data['iw_impimg'.$i]))
	echo "<tr><td align=right><span id=\"subhead_white\">".($i+1)."&nbsp;&nbsp;</span><input type=\"text\" size=10 name=\"iw_imploc[]\" ></td>
    <td><input type=\"text\" size=8  name=\"iw_impsize[]\"></td>
    <td><input type=\"file\" size=1  name=\"iw_impimg[]\" ></td></tr>"; 
	else
	echo "<tr><td align=right><span id=loc".$itemw_data['iw_impid'.$i]."><span id=\"subhead_white\">".($i+1)."&nbsp;&nbsp;</span><input type=\"text\" size=10   id=loc".$itemw_data['iw_impid'.$i]."  value=\"".$itemw_data['iw_imploc'.$i]."\" ></span></td>
    <td><span id=size".$itemw_data['iw_impid'.$i]."><input type=\"text\" size=8  id=size".$itemw_data['iw_impid'.$i]."  value=\"".str_replace("\"","&quot;",$itemw_data['iw_impsize'.$i])."\"  ></span></td>
    <td><span id=".$itemw_data['iw_impid'.$i]."><a href=\"".$itemw_data['iw_impimg'.$i]."\" target=_blank><span id=subhead_white>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;view&nbsp;</a>&nbsp;&nbsp;&nbsp;<img src=\"../images/close_button.png\" onclick=delete_imprint(".$itemw_data['iw_impid'.$i].",".($i+1).") /></span></td></tr>";
	
	}
	?>
   
    
    </tr>
    </table>
    </div>
    
    <div  id="subhead_competitors" style="margin-top:5px;">MetatagInfo:</div>
    <div class="content_notes_history" >
    <table cellpadding="2" cellspacing="0" border="0">
    <tr><td id="subhead_white">Meta Title:</td>
    <td><input type="text" name="iw_mtitle" size="34" value="<?php echo $itemw_data['iw_mtitle']; ?>" /></td></tr>
    <tr><td id="subhead_white">Meta Keywords:</td>
    <td><textarea rows="2" cols="24" name="iw_mwords"><?php echo $itemw_data['iw_mwords']; ?></textarea></td></tr>
    <tr><td id="subhead_white">Meta Description</td>
    <td><textarea rows="2" cols="24" name="iw_mdesp"><?php echo $itemw_data['iw_mdesp']; ?></textarea></td></tr>
    </table>
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
 <!--ENDING OF CONTENT BODY-->
 
</div><br />
<div class=" save" ><input type="submit" value="Save"  name="save" id="save"  />&nbsp;
<?php if(isset($_GET['inc']) && $_GET['inc'] == 'yes') echo "<input type=\"submit\" name=\"snn\" value=\"Save & Next\" id=\"save_new\" />"; else
echo  "<input type=\"submit\" name=\"snn\" value=\"Save & New\" id=\"save_new\" />"; ?>
&nbsp;<input value="Save & Close" type="submit" name="snc" id="save_close" />&nbsp;<input type="submit" name="revert" value="Revert" id="revert" /></div>
    </div>
</div>

</div>
</form>

<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>
</body>
</html>
