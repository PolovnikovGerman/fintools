<?php include('../controller/items_controller.php'); ?>
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

	if($_GET['msg']=='error' || $item_data['error'] == 'error')
		echo "<div class=\"error\">".$item_data['error_msg']."</div>";
	else if($_GET['msg']=='success'  || $item_data['error'] == 'success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
		
	


?>
<div class="content"   onkeydown="changecss('.wrap','background-color','#c41aaa')" >
 <!--BEGINNING OF CONTENT HEAD -->
<div class="contenthead">
 <div id="leftparent">
	<div>
		<a href="items_list.php"><span id="back_small">&laquo;back to Item List</span></a>
	</div>
	<div id="title">
		<?php echo ($_POST['is_title']!='') ? $_POST['is_title'] : "No Title"; ?>
	</div>
    
   
     <div id="sys_info"><img src="../images/sys_info_a.gif" /></div>
    <div id="web_info">
    <?php if(!empty($item_data['is_id'])) echo "<a href=\"itemw.php?sys_id=".$item_data['is_id']."&&sys_name=".$_POST['is_title']."\" ><img src=\"../images/web_info_ia.gif\"></a>"; else echo "<span onClick=\"alert( 'Please Save Item to Add/Edit Website Item Info' )\"><a href=\"\"  ><img src=\"../images/web_info_ia.gif\"></a>"; ?>
	</div>
  
   
 </div>
 <div id="rightparent">
 	
    <div id="search"><input type="text" name="search" value="search within Items" />&nbsp;<input type="button" id="button" value="Search" /></div>
    <div id="cancel"><a href="items_list.php"><input type="button" value="Cancel" id="cancel_button" /></a></div>
 </div>

 <div id="line">&nbsp;</div>
 </div>
 <!--END OF CONTENT HEAD -->
<!--BEGINNING OF CONTENT BODY-->
<form name="items_form" method="post"  enctype="multipart/form-data" action="items.php">
 <div class="content_body">
 	<!--beginning of content general-->
    <div class="content_left_wrap">
 	<div class="content_general">
 		<div id="room">
        <span   id="subhead_blue">General Information</span>
        <span><input type="radio" name="is_ginfo"  value="active" <?php if($_POST['is_ginfo'] == 'active') echo "checked"; ?> /><span id="subhead_black">Active</span>
        <input type="radio" name="is_ginfo" value="inactive" <?php if($_POST['is_ginfo'] == 'inactive') echo "checked"; ?>/><span id="subhead_black">Inactive</span></span>
        <div style="float:right">System ID&nbsp;<input name="id" type="text" size="4" value="<?php echo $item_data['is_id'];  ?>" readonly="readonly"  /></div>
        </div>
        <table cellpadding="1px" cellspacing="0px" border="0" id="content_general_table">
        <tr>
        <td>ID#</td><td><input type="text" name="is_itemid" value="<?php echo $_POST['is_itemid']; ?>" /></td>
        <td><input type="radio" name="is_type" value="open"  <?php if($_POST['is_type'] == 'open') echo "checked"; ?> />Open Source</td>
        <td><input type="radio" name="is_type" value="restricted"  <?php if($_POST['is_type'] == 'restricted') echo "checked"; ?> />Restricted</td>
        <td colspan="2"><input type="text" name="is_type_detail" value="<?php echo stripslashes($_POST['is_type_detail']); ?>" /></td>
        </tr>
        <tr>
        <td>Title</td><td colspan="4"><input type="text" size="75" name="is_title"  value="<?php echo $_POST['is_title']; ?>" /></td><td>Ship Class<select name="is_ship">
        <?php if(isset($_POST['is_ship'])) echo "<option value=\"".$_POST['is_ship']."\">".$_POST['is_ship']."</option"; ?>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select></td>
        </tr>
        </table>
 	</div>
    <!-- ending of content general-->
    
    <!--beginning of content pricing-->
   <div class="content_pricing_cover">
    	<div id="subhead_pricing">Pricing Information</div>
    	<div class=" content_pricing">
    
    		<div class="content_pricing_table">
            <table cellpadding="2" cellspacing="0" border="0">
            <tr>
            <td><span id="subhead_white">Quantity</span></td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" id=q".$i." onkeyup=calculate_yahoo() name=\"isp_quantity[]\" value=\"".$item_data['quantity'][$i]."\" /></td>";
			?>
            </tr>
            <tr>
            <td><span id="subhead_white">Price</span></td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" id=p".$i." onkeyup=calculate_yahoo() name=\"isp_price[]\" value=\"".$item_data['price'][$i]."\" /></td>";
			?>
            </tr>
            </table>
            </div>
            <div class="tabs" id="subhead_competitors">Competitors</div>
        	<div class="content_competitors">
            <table cellpadding="2px" cellspacing="0" border="0">
            <tr><td><span id="subhead_blue">1.</span></td>
   			<td><input type="text" size="12" name="isc_name1" id=nocent value="<?php echo $_POST['isc_name1']; ?>"   /></td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\"  name=\"isc_price1[]\" value=\"".$item_data['comp1'][$i]."\" /></td>";
			?>
            
            </tr>
            <tr>
            <td><span id="subhead_blue">2.</span></td>
			<td><input type="text" size="12" name="isc_name2"  id=nocent  value="<?php echo $_POST['isc_name2']; ?>"   /></td>            
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" name=\"isc_price2[]\" value=\"".$item_data['comp2'][$i]."\" /></td>";
			?>
           
            </tr>
            <tr>
            <td><span id="subhead_blue">3.</span></td>
   			<td><input type="text" size="12" name="isc_name3"  id=nocent  value="<?php echo $_POST['isc_name3']; ?>"   /></td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" name=\"isc_price3[]\" value=\"".$item_data['comp3'][$i]."\" /></td>";
			?>
		
            </tr>
            </table>
            </div>
         
        	<div class="content_vendors">
            
           
            <table cellpadding="2" cellspacing="0" border="0">
           <tr><td colspan="15" id="subhead_competitors" align="left">Vendors</td>
            <tr>
            <td  align="left"><input type="radio" name="group" value="1"  onclick="calculate_profit(1)"  /></td>
            <td>&nbsp;</td>
			<td colspan="7" align="left"><input id="highlight_input"  id=nocent  size="45" name="isv_attribute1"  value="<?php echo $_POST['isv_attribute1']; ?>"  /></td>
           	<td colspan="3">
            <select name="isv_buy1" id="myselect" size="" >
            <option value="<?php echo $_POST['isv_buy1']; ?>" selected="selected"><?php echo $_POST['isv_buy1']; ?></option>
			
			<?php 
			for($i=0;$i<sizeof($buy_print_id);$i++)
			echo "<option value=".$buy_print_name[$i].">".$buy_print_name[$i]."</option>";    ?>
            
            </select></td>
           	<td colspan="3">
            <select name="isv_print1" id="myselect" size="">
            <option value="<?php echo $_POST['isv_print1']; ?>" selected="selected"><?php echo $_POST['isv_print1']; ?></option>
			
			<?php
			for($i=0;$i<sizeof($buy_print_id);$i++)
			echo "<option value=".$buy_print_name[$i].">".$buy_print_name[$i]."</option>";    ?>
            
            </select></td>
            </tr>
            
            <tr>
            <td id="vertical_line_bg" align="center">&nbsp;</td>
            <td>&nbsp;</td>
			<td  id="extra_small_font" align="center">PO<br /> Title</td>
            <td colspan="4"><input id="highlight_input"  id=nocent  size="27" name="isv_potitle1"  value="<?php echo $_POST['isv_potitle1']; ?>"  /></td>
            <td id="extra_small_font">Setup</td>
            <td><input type="text" size="3" name="isv_setup1"  value="<?php echo $_POST['isv_setup1']; ?>"  /></td>
            <td   id="extra_small_font" align="center">Extra<br />Prints</td>
            <td><input type="text" size="3" name="isv_exprints1"  value="<?php echo $_POST['isv_exprints1']; ?>"  /></td>
            <td id="extra_small_font" align="center">PO<br /> Alert</td>
            <td colspan="3"><input id="highlight_input"  id=nocent  size="18" name="isv_poalert1"  value="<?php echo $_POST['isv_poalert1']; ?>" /></td>
            </tr>
            
            <tr id="tb_sep">
            <td id="vertical_line_bg" align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="small_font">Pricing</td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" onkeyup=calculate_profit(1) id=v1$i name=\"isv_price1[]\" value=\"".$item_data['vendor1'][$i]."\" /></td>";
			?>
            </tr>
            <tr><td colspan="15" align="center"><hr /></td></tr>
            
            </table>
            <table cellpadding="2" cellspacing="0" border="0">
             <tr>
            <td  align="left"><input type="radio" name="group"  value="2" onclick="calculate_profit(2)"/></td>
            <td>&nbsp;</td>
			<td colspan="7" align="left"><input id="highlight_input" size="45" name="isv_attribute2"   value="<?php echo $_POST['isv_attribute2']; ?>"  /></td>
           	<td colspan="3">
            <select name="isv_buy2" id="myselect" size="0">
            <option value="<?php echo $_POST['isv_buy2']; ?>" selected="selected"><?php echo $_POST['isv_buy2']; ?></option>
			
			<?php 
			for($i=0;$i<sizeof($buy_print_id);$i++)
			echo "<option value=".$buy_print_name[$i].">".$buy_print_name[$i]."</option>";    ?>
            
            </select></td>
           	<td colspan="3">
            <select name="isv_print2" id="myselect" size="">
            <option value="<?php echo $_POST['isv_print2']; ?>" selected="selected"><?php echo $_POST['isv_print2']; ?></option>
			
			<?php
			for($i=0;$i<sizeof($buy_print_id);$i++)
			echo "<option value=".$buy_print_name[$i].">".$buy_print_name[$i]."</option>";    ?>
            
            </select></td>
            </tr>
            
            <tr>
            <td id="vertical_line_bg">&nbsp;</td>
            <td>&nbsp;</td>
			<td  id="extra_small_font" align="center">PO<br /> Title</td>
            <td colspan="4"><input id="highlight_input" size="20" name="isv_potitle2"   value="<?php echo $_POST['isv_potitle2']; ?>" /></td>
            <td id="extra_small_font">Setup</td>
            <td><input type="text" size="3" name="isv_setup2"   value="<?php echo $_POST['isv_setup2']; ?>" /></td>
            <td  align="right" id="extra_small_font" align="center">Ex<br />Prints</td>
            <td><input type="text" size="3" name="isv_exprints2"   value="<?php echo $_POST['isv_exprints2']; ?>"  /></td>
            <td id="extra_small_font" align="center">PO<br /> Alert</td>
            <td colspan="3"><input id="highlight_input" size="18" name="isv_poalert2"   value="<?php echo $_POST['isv_poalert2']; ?>"  /></td>
            </tr>
            
            <tr id="tb_sep">
            <td id="vertical_line_bg">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="small_font">Pricing</td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" onkeyup=calculate_profit(2) id=v2$i name=\"isv_price2[]\" value=\"".$item_data['vendor2'][$i]."\" /></td>";
			?>
           
            </tr>
                      
            </table>
            <div id="add_vendor" onclick="toggle_vendor3()">add vendor</div>
            <div id="vendor3">
            <table cellpadding="2" cellspacing="0"  border="0">
             <tr>
            <td  align="left"><input type="radio" name="group" value="3"  onclick="calculate_profit(3)" /></td>
            <td>&nbsp;</td>
			<td colspan="7" align="left"><input id="highlight_input" size="45" name="isv_attribute3"   value="<?php echo $_POST['isv_attribute3']; ?>"  /></td>
           	<td colspan="3">
            <select name="isv_buy3" id="myselect" size="0">
             
            <option value="<?php echo $_POST['isv_buy3']; ?>" selected="selected"><?php echo $_POST['isv_buy3']; ?></option>
			
			<?php 
			for($i=0;$i<sizeof($buy_print_id);$i++)
			echo "<option value=".$buy_print_name[$i].">".$buy_print_name[$i]."</option>";    ?>
            
            </select></td>
           	<td colspan="3">
            <select name="isv_print3" id="myselect" size="">
            <option value="<?php echo $_POST['isv_print3']; ?>" selected="selected"><?php echo $_POST['isv_print3']; ?></option>
			
			<?php
			for($i=0;$i<sizeof($buy_print_id);$i++)
			echo "<option value=".$buy_print_name[$i].">".$buy_print_name[$i]."</option>";    ?>
            
            </select></td>
            </tr>
            
            <tr>
            <td id="vertical_line_bg">&nbsp;</td>
            <td>&nbsp;</td>
			<td  id="extra_small_font" align="center">PO<br /> Title</td>
            <td colspan="4"><input id="highlight_input" size="20" name="isv_potitle3"  value="<?php echo $_POST['isv_potitle3']; ?>"  /></td>
            <td id="extra_small_font">Setup</td>
            <td><input type="text" size="3" name="isv_setup3"   value="<?php echo $_POST['isv_setup3']; ?>"  /></td>
            <td  align="right" id="extra_small_font" align="center">Ex<br />Prints</td>
            <td><input type="text" size="3" name="isv_exprints3"  value="<?php echo $_POST['isv_exprints3']; ?>"  /></td>
            <td id="extra_small_font" align="center">PO<br /> Alert</td>
            <td colspan="3"><input id="highlight_input" size="18" name="isv_poalert3"  value="<?php echo $_POST['isv_poalert3']; ?>"  /></td>
            </tr>
            
            <tr id="tb_sep">
            <td id="vertical_line_bg">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="small_font">Pricing</td>
            <?php
			for($i=0;$i<12;$i++)
			echo "<td><input type=\"text\" size=\"3\" onkeyup=calculate_profit(3) id=v3$i name=\"isv_price3[]\" value=\"".$item_data['vendor3'][$i]."\" /></td>";
			?>
           
            </tr>
                       
            </table></div>
            </div>
            
            <div class="content_proft">
            <table cellpadding="2" cellspacing="0" border="0">
            <tr>
            <td id="vertical_line_profit">&nbsp;</td>
            <td>&nbsp;</td>
            
            
             <td><span id="subhead_white">Profit</span></td>
            <td><input type="text" id="profit0" size="3" name="" /></td>
            <td><input type="text" id="profit1"  size="3" name="" /></td>
            <td><input type="text" id="profit2"  size="3" name="" /></td>
            <td><input type="text" id="profit3"  size="3" name="" /></td>
            <td><input type="text" id="profit4"  size="3" name="" /></td>
            <td><input type="text" id="profit5"  size="3" name="" /></td>
            <td><input type="text" id="profit6"  size="3" name="" /></td>
            <td><input type="text" id="profit7"  size="3" name="" /></td>
            <td><input type="text" id="profit8"  size="3" name="" /></td>
            <td><input type="text" id="profit9"  size="3" name="" /></td>
            <td><input type="text" id="profit10"  size="3" name="" /></td>
            <td><input type="text" id="profit11"  size="3" name="" /></td>
            </tr>
            <tr>
            <td align="left">Profit</td>
            <td>&nbsp;</td>
            
             
            <td><span id="subhead_white">%</span></td>
            <td><input type="text" id="pct0" size="3" name="" /></td>
            <td><input type="text" id="pct1"  size="3" name="" /></td>
            <td><input type="text" id="pct2"  size="3" name="" /></td>
            <td><input type="text" id="pct3"  size="3" name="" /></td>
            <td><input type="text" id="pct4"  size="3" name="" /></td>
            <td><input type="text" id="pct5"  size="3" name="" /></td>
            <td><input type="text" id="pct6"  size="3" name="" /></td>
            <td><input type="text" id="pct7"  size="3" name="" /></td>
            <td><input type="text" id="pct8"  size="3" name="" /></td>
            <td><input type="text" id="pct9"  size="3" name="" /></td>
            <td><input type="text" id="pct10"  size="3" name="" /></td>
            <td><input type="text" id="pct11"  size="3" name="" /></td>
            </tr>
            </table>
            
            </div>
    	</div>
    	
    </div>
    <!--ending of content pricing-->
    </div><!--end of content_left_wrap-->
    <div class="content_right_wrap">
    <div  id="subhead_competitors">Notes & History</div>
    <div class="content_notes_history">
    <table cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td align="left"><span id="subhead_white">New Update</span></td><td>&nbsp;</td>
    </tr><tr>
    <td colspan="2"><textarea name="is_update"  id="status"  cols="36" rows="2"></textarea></td>
    </tr><tr>
    <td align="left"><span id="subhead_white">History</span></td><td align="right"><span id="button_purple">
    <?php if(!empty($item_data['is_id']))
	echo "<input type=\"button\" onclick=\"update_items(".$item_data['is_id'].")\" value=\"Update\" id=\"update_button\"  />"; 
	else
	echo "<input type=\"button\" onclick=\"alert('Cannot Update on Unsaved Files.')\" value=\"Update\" id=\"update_button\"  />";
	?>
    </span></td></tr></table>
    <div id="update_history" style="border:1px black solid; margin:5px 0px 5px 0px; background-color:white;  height:120px; overflow:auto;"><table cellpadding="1px" cellspacing="0px" width="100%" border="0">

<?php

for($j=0;$j<sizeof($history['id']);$j++) { 


echo "<tr><td>&bull;".$history['msg'][$j]."</td></tr>";


echo "<tr><td align=\"right\" style=\"font-size:10px; color:black; font-family:Arial, Helvetica, sans-serif; font:arial; color:#0000ff; font-style:italic;\">--&nbsp;".$history['datetime'][$j]."&nbsp;&nbsp;&nbsp;".$history['time'][$j]."&nbsp;&nbsp;-".$history['userid'][$j]."&nbsp;&nbsp;</td></tr>"; } 


?>
</table></div>
	<table cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td colspan="2" align="left"><span id="subhead_white">Transactional Alert Notes</span></td>
    </tr><tr>
    <td colspan="2"><textarea cols="36" rows="2" name="is_trans"><?php echo $_POST['is_trans']; ?></textarea></td>
    </tr><tr>
    <td align="left"><span id="subhead_white">Other Notes</span></td>
    </tr><tr>
    <td colspan="2"><textarea cols="36" rows="2" name="is_notes"><?php echo $_POST['is_notes']; ?></textarea></td>
    </tr>
    </table>
    </div>
    <div  id="subhead_templates" >Imprint Area Templates</div>
    <div class="imprint_templates">
    <?php
	if(!empty($_POST['is_itemid']))
	{
		for($j=1;$j<4;$j++)
		{
		if(!empty($item_data['is_attach'.$j]))
			echo "<div id=\"is_attach".$j."\"><a href=\"../docs/imprint_templates/".$item_data['is_attach'.$j]."\" target=_blank>".$item_data['is_attach'.$j]."</a>&nbsp;&nbsp;
			<span onclick=delete_template('".$item_data['is_attach_id'.$j]."','".$j."')><img src=\"../images/close.gif\"></span></div>";
		else
			echo "<div id=\"is_attach".$j."\"><input type=\"file\" name=\"is_attach".$j."\" ></div>";
		}
	}
	else { ?>
    <div id="is_attach1"><input type="file" name="is_attach1" /></div>
    <div id="is_attach2"><input type="file" name="is_attach2" /></div>
    <div id="is_attach3"><input type="file" name="is_attach3" /></div>
    <?php } ?> <br />
    
    <div class="save_s"><input type="submit" value="Save"  name="save" id="save"  />&nbsp;<input type="submit" name="snn" value="Save & New" id="save_new" />&nbsp;<input value="Save & Close" type="submit" name="snc" id="save_close" />&nbsp;<input type="submit" name="revert" value="Revert" id="revert" /></div>
    
    
 </div>
 <!--ENDING OF CONTENT BODY-->
 
</div>
</div>
<div class="yahoo_save_panel">
<div class="yahoo">
<table border="0" cellpadding="2" cellspacing="0"><tr><td>
<span id="subhead_black">Yahoo</span></td><td><textarea rows="1" cols="100" id="yahoo" name="is_yahoo"><?php echo $_POST['is_yahoo']; ?></textarea></td></tr></table></div>

</div>

</div>

</form>
<div class="clear"></div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>
</body>
</html>
