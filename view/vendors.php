<?php include('../controller/vendor_controller.php'); ?>
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

	if($_GET['msg']=='error' || $vendor_data['error'] == 'error')
		echo "<div class=\"error\">Unable to Process File.</div>";
	else if($_GET['msg']=='success'  || $vendor_data['error'] == 'success')
		echo "<div class=\"success\">File Processed Successfully.</div>";
	


?>
     
<div class="content"   onkeydown="changecss('.wrap','background-color','#c41aaa')"  >
 <!--BEGINNING OF CONTENT HEAD -->
<div class="contenthead">

 <div id="leftparent">
	<div>
		<a href="vendor_list.php">&laquo;back to Vendor List</a>
	</div>
	<div id="title">
		Vendor Detail - <?php echo $_POST['vname']; ?>
	</div>
 </div>
 <div id="rightparent">
    <div id="search">Search Within Vendors: <input type="text" name="search" />&nbsp;<input type="button" id="button" value="Search" /></div>
    <div id="cancel"><a href="vendor_list.php"><input type="button" value="Cancel" id="cancel_button" /></a></div>
 </div>

 <div id="line">&nbsp;</div>
 </div>
 <!--END OF CONTENT HEAD -->
<!--BEGINNING OF CONTENT BODY-->
<form name="vendor_form" method="post" onsubmit="return validate_form()" enctype="multipart/form-data" action="vendors.php">
 <div class="content_body">
 	<!--beginning of content general-->
    <div class="content_left_wrap">
 	<div class="content_general">
 		<div id="room">
        <span   id="subhead_blue">General Information</span>
        <span><input type="radio" value="cog" name="vgen" <?php if($_POST['vgen']=='cog') echo "checked"; ?> /><span id="subhead_black">COG</span>
        <input type="radio" value="art" name="vgen" <?php if($_POST['vgen']=='art') echo "checked"; ?> /><span id="subhead_black">Art Vendor</span>
        <span><input type="radio" value="ship" name="vgen" <?php if($_POST['vgen']=='ship') echo "checked"; ?> /><span id="subhead_black">Shipping</span>
        <input type="radio" value="gen" name="vgen" <?php if($_POST['vgen']=='gen') echo "checked"; ?> /><span id="subhead_black">General</span></span></div>
        <table cellpadding="2px" cellspacing="0px" border="0" id="content_general_table" >
        
        <tr>
        <td id="subhead_white">ID#:</td>
        <td align="left"><input type="text" size="5" name="id" value="<?php echo $vendor_data['v_id']; ?>" readonly="readonly" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right" id="subhead_white">Our Account # with them:&nbsp;&nbsp;<input type="text" name="vacc" value="<?php echo $_POST['vacc']; ?>"  size="10" /></td>
        </tr>
        <tr>
        <td id="subhead_white">Name*:</td>
        <td align="left"><input type="text" name="vname" id="vendor_name" value="<?php echo $_POST['vname']; ?>" /></td>
        <td width="40px">&nbsp;</td>
        <td>&nbsp;</td>

        <td align="right" id="subhead_white">Nick Name:&nbsp;&nbsp;<input type="text" name="vnick" value="<?php echo $_POST['vnick']; ?>"  /></td>
        </tr>
         <tr>
        <td id="subhead_white">asl #:</td>
        <td align="left"><input type="text" size="5" name="vasi" value="<?php echo $_POST['vasi']; ?>" /></td>
        <td width="40px">&nbsp;</td>
        <td align="right" colspan="2"><span id="subhead_white">Webstie&nbsp;&nbsp;</span><input type="text" value="<?php echo $_POST['vweb']; ?>" name="vweb"/>open site</td>
       
        </tr>
        <tr>
        <td id="subhead_white" colspan="5"><table cellpadding="0" cellspacing="0" border="0">
        									<tr>
                                            <td>Description:&nbsp;</td>
                                            <td><textarea rows="2" cols="43" name="vdesp"><?php echo $_POST['vdesp']; ?></textarea></td><td>
        <table cellpadding="1px" cellspacing="0" border="0">
        	<tr align="left">
            <td colspan="7" id="subhead_white">Pay Methods:</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="checkbox" value="yes" name="vm" <?php if($_POST['vm']=='yes') echo "checked"; ?>/>Visa/Mc</td>
            <td><input type="checkbox" value="yes" name="amex" <?php if($_POST['amex']=='yes') echo "checked"; ?> />Amex</td>
            <td><input type="checkbox" value="yes" name="disc" <?php if($_POST['disc']=='yes') echo "checked"; ?>  />Disc</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="checkbox" value="yes" name="paypal" <?php if($_POST['paypal']=='yes') echo "checked"; ?> />Paypal</td>
            <td><input type="checkbox" value="yes" name="check" <?php if($_POST['check']=='yes') echo "checked"; ?>  />Check</td>
            <td><input type="checkbox" value="yes" name="wire" <?php if($_POST['wire']=='yes') echo "checked"; ?>  />Wire</td>
            </tr>
        	</table>
            </td></tr></table>
        </td>
        </tr>
          
        
        
        
        
        
        </table>
 	</div>
    <!-- ending of content general-->
    
    <!--beginning of content pricing-->
   <div class="content_pricing_cover">
    	<div id="subhead_pricing">Addresses:</div>
    	<div class="content_pricing">
        <table cellpadding="2" cellspacing="0" width="560px">
        <tr>
        <td>
         <table cellpadding="2" cellspacing="0" border="0"  class="content_vendor_address">
         <tr>
         <td id="subhead_white">Address 1:</td>
         <td><input type="text" size="15" name="vadd1_title"  value="<?php echo $_POST['vadd1_title']; ?>"   /></td>
         </tr>
         <tr>
         <td><select name="vadd1_country" onchange="change_add(this.value,1)">
         <?php if(!empty($_POST['vadd1_country']))
		 echo "<option selected=\"selected\" value=".$_POST['vadd1_country'].">".strtoupper($_POST['vadd1_country'])."</option>";
		 else
         echo "<option selected=\"selected\" value=\"usa\">USA</option>"; ?>
         <option value="china">China</option>  
         <option value="india">India</option>  
         <option value="uk">UK</option>  
         <option value="taiwan">Taiwan</option>  
         <option value="korea">Korea</option>  </select>
         </td>
         <td><span id="small_font_vendors">ship address?</span><input type="radio" value="1" name="vadd_ship" <?php if($_POST['vadd_ship']==1) echo "checked" ?> /></td>
         </tr>
         <tr>
         <td colspan="2">
         <?php if($_POST['vadd1_country'] == 'usa' || empty($_POST['vadd1_country'])) { ?>
         <div id="change_address1">
         <table cellpadding="0" cellspacing="0" border="0"><tr><td>
         <input type="text" size="32" name="vadd1_line1" value="<?php echo $_POST['vadd1_line1']; ?>"  /></td>
         </tr>
         <tr>
         <td colspan="2"><input type="text" size="32" name="vadd1_line2" value="<?php echo $_POST['vadd1_line2']; ?>"  /></td>
         </tr>
         <tr>
		 <td colspan="2"><input type="text" size="17" name="vadd1_line3" value="<?php echo $_POST['vadd1_line3']; ?>"  />&nbsp;&nbsp;<select name="vadd1_state"><option selected="selected" value="<?php echo $_POST['vadd1_state']; ?>"><?php echo $_POST['vadd1_state']; ?></option>
         <option value="AL">AL</option>
	<option value="AK">AK</option>
	<option value="AZ">AZ</option>
	<option value="AR">AR</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA">WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
         </select></td>
         </tr>
         <tr>
         
         <td colspan="2" align="right" id="small_font_vendors">zip code:&nbsp;&nbsp;<input type="text" size="10" name="vadd1_zip"  value="<?php echo $_POST['vadd1_zip']; ?>"   /></td>
         </tr> </table> 
         </div>       
         <?php } else { ?>
          <div id="change_address1">
         <table>
         <tr><td><input type="text" size="32" name="vadd1_line1"  value="<?php echo $_POST['vadd1_line1']; ?>"   /></td></tr>
         <tr><td><input type="text" size="32" name="vadd1_line2"  value="<?php echo $_POST['vadd1_line2']; ?>"  /></td></tr>
         <tr><td><input type="text" size="32" name="vadd1_line3"  value="<?php echo $_POST['vadd1_line3']; ?>"  /></td></tr>
         <tr><td><input type="text" size="32" name="vadd1_line4"  value="<?php echo $_POST['vadd1_line4']; ?>"  /></td></tr>
         </table>
         </div>
         <?php } ?>
         </td></tr>
        </table>
       
       </td>
       <!--INNER TABLE ONE CLOSED-->
       <td>
        <table cellpadding="2" cellspacing="0" border="0"  class="content_vendor_address">
         <tr>
         <td id="subhead_white">Address 2:</td>
         <td><input type="text" size="15" name="vadd2_title"  value="<?php echo $_POST['vadd2_title']; ?>"   /></td>
         </tr>
         <tr>
         <td><select name="vadd2_country" onchange="change_add(this.value,2)">
         <?php if(!empty($_POST['vadd2_country']))
		 echo "<option selected=\"selected\" value=".$_POST['vadd2_country'].">".strtoupper($_POST['vadd2_country'])."</option>";
		 else
         echo "<option selected=\"selected\" value=\"usa\">USA</option>"; ?>
         <option value="china">China</option>  
         <option value="india">India</option>  
         <option value="uk">UK</option>  
         <option value="taiwan">Taiwan</option>  
         <option value="korea">Korea</option>  </select>
         </td>
         <td><span id="small_font_vendors">ship address?</span><input type="radio" value="2" name="vadd_ship" <?php if($_POST['vadd_ship']==2) echo "checked" ?> /></td>
         </tr>
         <tr>
         <td colspan="2">
         <?php  if($_POST['vadd2_country'] == 'usa' || empty($_POST['vadd2_country'])) { ?>
         <div id="change_address2">
         <table cellpadding="0" cellspacing="0" border="0"><tr><td>
         <input type="text" size="32" name="vadd2_line1" value="<?php echo $_POST['vadd2_line1']; ?>"  /></td>
         </tr>
         <tr>
         <td colspan="2"><input type="text" size="32" name="vadd2_line2" value="<?php echo $_POST['vadd2_line2']; ?>"  /></td>
         </tr>
         <tr>
		 <td colspan="2"><input type="text" size="17" name="vadd2_line3" value="<?php echo $_POST['vadd2_line3']; ?>"  />&nbsp;&nbsp;<select name="vadd2_state"><option selected="selected" value="<?php echo $_POST['vadd2_state']; ?>"><?php echo $_POST['vadd2_state']; ?></option>
         <option value="AL">AL</option>
	<option value="AK">AK</option>
	<option value="AZ">AZ</option>
	<option value="AR">AR</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA">WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
         </select></td>
         </tr>
         <tr>
         
         <td colspan="2" align="right" id="small_font_vendors">zip code:&nbsp;&nbsp;<input type="text" size="10" name="vadd2_zip"  value="<?php echo $_POST['vadd2_zip']; ?>"   /></td>
         </tr> </table> 
         </div>       
         <?php } else { ?>
          <div id="change_address2">
         <table>
         <tr><td><input type="text" size="32" name="vadd2_line1"  value="<?php echo $_POST['vadd2_line1']; ?>"   /></td></tr>
         <tr><td><input type="text" size="32" name="vadd2_line2"  value="<?php echo $_POST['vadd2_line2']; ?>"  /></td></tr>
         <tr><td><input type="text" size="32" name="vadd2_line3"  value="<?php echo $_POST['vadd2_line3']; ?>"  /></td></tr>
         <tr><td><input type="text" size="32" name="vadd2_line4"  value="<?php echo $_POST['vadd2_line4']; ?>"  /></td></tr>
         </table>
         </div>
         <?php } ?>
         </td></tr>
        </table>
       
       </td>
       <!-- INNER TABLE TWO CLOSED -->
       <td>
        <table cellpadding="2" cellspacing="0" border="0"  class="content_vendor_address">
         <tr>
         <td id="subhead_white">Address 3:</td>
         <td><input type="text" size="15" name="vadd3_title"  value="<?php echo $_POST['vadd3_title']; ?>"   /></td>
         </tr>
         <tr>
         <td><select name="vadd3_country" onchange="change_add(this.value,3)">
         <?php if(!empty($_POST['vadd3_country']))
		 echo "<option selected=\"selected\" value=".$_POST['vadd3_country'].">".strtoupper($_POST['vadd3_country'])."</option>";
		 else
         echo "<option selected=\"selected\" value=\"usa\">USA</option>"; ?>
         <option value="china">China</option>  
         <option value="india">India</option>  
         <option value="uk">UK</option>  
         <option value="taiwan">Taiwan</option>  
         <option value="korea">Korea</option>  </select>
         </td>
         <td><span id="small_font_vendors">ship address?</span><input type="radio" value="3" name="vadd_ship" <?php if($_POST['vadd_ship']==3) echo "checked" ?> /></td>
         </tr>
         <tr>
         <td colspan="2">
         <?php  if($_POST['vadd3_country'] == 'usa' || empty($_POST['vadd3_country'])) { ?>
         <div id="change_address3">
         <table cellpadding="0" cellspacing="0" border="0"><tr><td>
         <input type="text" size="32" name="vadd3_line1" value="<?php echo $_POST['vadd3_line1']; ?>"  /></td>
         </tr>
         <tr>
         <td colspan="2"><input type="text" size="32" name="vadd3_line2" value="<?php echo $_POST['vadd3_line2']; ?>"  /></td>
         </tr>
         <tr>
		 <td colspan="2"><input type="text" size="17" name="vadd3_line3" value="<?php echo $_POST['vadd3_line3']; ?>"  />&nbsp;&nbsp;<select name="vadd3_state"><option selected="selected" value="<?php echo $_POST['vadd3_state']; ?>"><?php echo $_POST['vadd3_state']; ?></option>
         <option value="AL">AL</option>
	<option value="AK">AK</option>
	<option value="AZ">AZ</option>
	<option value="AR">AR</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA">WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
         </select></td>
         </tr>
         <tr>
         
         <td colspan="2" align="right" id="small_font_vendors">zip code:&nbsp;&nbsp;<input type="text" size="10" name="vadd3_zip"  value="<?php echo $_POST['vadd3_zip']; ?>"   /></td>
         </tr> </table> 
         </div>       
         <?php } else { ?>
          <div id="change_address3">
         <table>
         <tr><td><input type="text" size="32" name="vadd3_line1"  value="<?php echo $_POST['vadd3_line1']; ?>"   /></td></tr>
         <tr><td><input type="text" size="32" name="vadd3_line2"  value="<?php echo $_POST['vadd3_line2']; ?>"  /></td></tr>
         <tr><td><input type="text" size="32" name="vadd3_line3"  value="<?php echo $_POST['vadd3_line3']; ?>"  /></td></tr>
         <tr><td><input type="text" size="32" name="vadd3_line4"  value="<?php echo $_POST['vadd3_line4']; ?>"  /></td></tr>
         </table>
         </div>
         <?php } ?>
         </td></tr>
        </table>
       
       </td>
       <!-- INNER TABLE 3 CLOSED-->
       </tr>
       </table>     
          
    	</div>
    	
    </div>
    
    <div class="content_pricing_cover">
    <div id="subhead_pricing">Contacts:</div>
    	<div class="content_pricing">
        
        <table cellpadding="2" cellspacing="0" border="0" >
        <tr>
        <td id="subhead_white">Name</td>
        <td id="subhead_white">Telephone</td>
        <td id="subhead_white">Fax</td>
        <td id="subhead_white">Email</td>
        <td id="subhead_white">Notes</td>
        <td id="small_font_vendors" width="30px">Email<br />PO</td>
        <td id="small_font_vendors" width="25px">Fax<br />PO</td>
        <td id="small_font_vendors" width="30px">Email<br />Art</td>
        </tr>
        <?php if($vendor_data['contact_size'] <=3 ) { ?>
        <tr>
        <td><input type="text" name="vcon1_name" value="<?php echo $_POST['vcon1_name']; ?>" /></td>
        <td><input type="text" name="vcon1_tel" value="<?php echo $_POST['vcon1_tel']; ?>" size="13" /></td>
        <td><input type="text" name="vcon1_fax"  value="<?php echo $_POST['vcon1_fax']; ?>" size="3" /></td>
        <td><input type="text" name="vcon1_email"  value="<?php echo $_POST['vcon1_email']; ?>" /></td>
        <td><input type="text" name="vcon1_notes"  value="<?php echo $_POST['vcon1_notes']; ?>" /></td>
        <td><input type="checkbox" value="yes" name="vcon1_poemail" <?php if($_POST['vcon1_poemail'] == 'yes') echo "checked"; ?> /></td>
        <td><input type="checkbox" value="yes" name="vcon1_pofax" <?php if($_POST['vcon1_pofax'] == 'yes') echo "checked"; ?> /></td>
        <td><input type="checkbox" value="yes" name="vcon1_artemail" <?php if($_POST['vcon1_artemail'] == 'yes') echo "checked"; ?> /></td>
        </tr>
       
       <tr>
        <td><input type="text" name="vcon2_name"  value="<?php echo $_POST['vcon2_name']; ?>" /></td>
        <td><input type="text" name="vcon2_tel"   value="<?php echo $_POST['vcon2_tel']; ?>" size="13" /></td>
        <td><input type="text" name="vcon2_fax"   value="<?php echo $_POST['vcon2_fax']; ?>" size="3" /></td>
        <td><input type="text" name="vcon2_email"   value="<?php echo $_POST['vcon2_email']; ?>"/></td>
        <td><input type="text" name="vcon2_notes"  value="<?php echo $_POST['vcon2_notes']; ?>" /></td>
        <td><input type="checkbox" value="yes" name="vcon2_poemail" <?php if($_POST['vcon2_poemail'] == 'yes') echo "checked"; ?> /></td>
        <td><input type="checkbox" value="yes" name="vcon2_pofax" <?php if($_POST['vcon2_pofax'] == 'yes') echo "checked"; ?> /></td>
        <td><input type="checkbox" value="yes" name="vcon2_artemail" <?php if($_POST['vcon2_artemail'] == 'yes') echo "checked"; ?> /></td>
        </tr>
       
       <tr>
        <td><input type="text" name="vcon3_name"  value="<?php echo $_POST['vcon3_name']; ?>" /></td>
        <td><input type="text" name="vcon3_tel" value="<?php echo $_POST['vcon3_tel']; ?>" size="13" /></td>
        <td><input type="text" name="vcon3_fax" value="<?php echo $_POST['vcon3_fax']; ?>" size="3" /></td>
        <td><input type="text" name="vcon3_email" value="<?php echo $_POST['vcon3_email']; ?>" /></td>
        <td><input type="text" name="vcon3_notes" value="<?php echo $_POST['vcon3_notes']; ?>" /></td>
        <td><input type="checkbox" value="yes" name="vcon3_poemail" <?php if($_POST['vcon3_poemail'] == 'yes') echo "checked"; ?> /></td>
        <td><input type="checkbox" value="yes" name="vcon3_pofax" <?php if($_POST['vcon3_pofax'] == 'yes') echo "checked"; ?> /></td>
        <td><input type="checkbox" value="yes" name="vcon3_artemail" <?php if($_POST['vcon3_artemail'] == 'yes') echo "checked"; ?> /></td>
        </tr>
        <?php } else { 
		for($i=1;$i<=$vendor_data['contact_size'];$i++)
		{
		echo "<tr>";
        echo "<td><input type=\"text\" name=\"vcon".$i."_name\" value=\"".$_POST['vcon'.$i.'_name']."\" /></td>";
        echo "<td><input type=\"text\" name=\"vcon".$i."_tel\" value=\"".$_POST['vcon'.$i.'_tel']."\" size=\"13\" /></td>";
        echo "<td><input type=\"text\" name=\"vcon".$i."_fax\" value=\"".$_POST['vcon'.$i.'_fax']."\" size=\"3\" /></td>";
        echo "<td><input type=\"text\" name=\"vcon".$i."_email\" value=\"".$_POST['vcon'.$i.'_email']."\" /></td>";
        echo "<td><input type=\"text\" name=\"vcon".$i."_notes\" value=\"".$_POST['vcon'.$i.'_notes']."\" /></td>";
		echo "<td><input type=\"checkbox\" value=\"yes\" name=\"vcon".$i."_poemail\""; if($_POST['vcon'.$i.'_poemail'] == 'yes') echo "checked"; echo "/></td>";
        echo "<td><input type=\"checkbox\" value=\"yes\" name=\"vcon".$i."_pofax\""; if($_POST['vcon'.$i.'_pofax'] == 'yes') echo "checked"; echo " /></td>
        <td><input type=\"checkbox\" value=\"yes\" name=\"vcon".$i."_artemail\""; if($_POST['vcon'.$i.'_artemail'] == 'yes') echo "checked"; echo " /></td>
        </tr>";
		}
		echo $con;
		}
		?>
        
        </table>
        <div id="c4"></div>
		<span id="small_font_vendors"  class="point" onclick="add_contact()">[ + ] add another contact</span><span id="hidden"></span>
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
    <td colspan="2"><textarea cols="36" rows="2" id="status" name="vupdate"></textarea></td>
    </tr><tr>
    <td align="left"><span id="subhead_white">History</span></td><td align="right"><span id="button_purple">
    <?php if(!empty($vendor_data['v_id']))
	echo "<input type=\"button\" onclick=\"update(".$vendor_data['v_id'].")\" value=\"Update\" id=\"update_button\"  />"; 
	else
	echo "<input type=\"button\" onclick=\"alert('Cannot Update on Unsaved Files.')\" value=\"Update\" id=\"update_button\"  />";
	?></span></td>
    </tr></table>
    
	<div id="update_history" style="border:1px black solid; margin:5px 0px 5px 0px; background-color:white; width:264px; height:120px; overflow:auto;"><table cellpadding="1px" cellspacing="0px" width="100%" border="0">

<?php

for($j=0;$j<sizeof($history['id']);$j++) { 


echo "<tr><td>&bull;".$history['msg'][$j]."</td></tr>";


echo "<tr><td align=\"right\" style=\"font-size:10px; color:black; font-family:Arial, Helvetica, sans-serif; font:arial; color:#0000ff; font-style:italic;\">--&nbsp;".$history['datetime'][$j]."&nbsp;&nbsp;&nbsp;".$history['time'][$j]."&nbsp;&nbsp;-".$history['userid'][$j]."</td></tr>"; } 


?>
</table></div>
    
    <table cellpadding="0" cellspacing="0" border="0"><tr>
    <td colspan="2" align="left"><span id="subhead_white">Transactional Alert Notes(<span id="small_font_vendors">purchase orders</span>)</span></td>
    </tr><tr>
    <td colspan="2"><textarea cols="36" rows="2" name="vtrans_alert"><?php echo $_POST['vtrans_alert']; ?></textarea></td>
    </tr>
    </table>
    </div>
      <div  id="subhead_competitors">Attachments:</div>
<div id="update_history" class="history_attach" style="border:1px black solid; margin:10px 0px 5px 10px; background-color:white; width:288px; height:65px; font-size:11px; overflow:auto; text-decoration:underline;"><table cellpadding="1px" cellspacing="0px" width="100%" border="0">

<?php
for($j=0;$j<$history['attach_size'];$j++) 
 echo "<tr><td><a href=\"../docs/vendor_attach/".$history['attach'][$j]."\" target=_blank>".$history['attach'][$j]."</a></td></tr>";
?>
</table></div>
    <div class="content_templates_vendor">
    <table cellpadding="2" cellspacing="0" border="0">
    <tr>
    <td id="subhead_black">desc of file:</td>
    <td colspan="2" id="subhead_black">date: {yy-mm-dd}</td>
   
    </tr>
    <tr>
    <td><input type="text" name="vattach_desp1" size="15"/></td>
    <td><input type="text" size="7" name="vattach_date1" value="<?php echo date("y-m-d"); ?>" /> </td>
    <td><input type="file" name="vattach1" size="1" /></td>	
    </tr>
     <tr>
    <td><input type="text" size="15" name="vattach_desp2" /></td>
    <td><input type="text" size="7" name="vattach_date2" value="<?php echo date("y-m-d"); ?>" /> </td>
    <td><input type="file" name="vattach2"  size="1"/></td>
    </tr>
    </table>
    
 </div>
 <!--ENDING OF CONTENT BODY-->
 
</div>
</div>
<div class="yahoo_save_panel">
<div class="yahoo" align="center">
<div class="yahoo_vendor_block" id="subhead_blue">Their<br />Items:</div>
<div class="yahoo_vendor_block">
<table cellpadding="2px" cellspacing="0" border="0" class="vendor_yahoo_table">
<tr>
<td id="small_font_vendors">Setup:</td>
<td><input  size="3" type="text" name="vsetup" value="<?php echo $_POST['vsetup']; ?>" /></td>
<td id="small_font_vendors">Extra<br />Prints:</td>
<td><input type="text" size="3" name="vexprints" value="<?php echo $_POST['vexprints']; ?>" /></td>
</tr>
</table>
</div>
<div class="yahoo_vendor_block" id="subhead_blue">Other<br />Vendors:</div>
<div class="yahoo_vendor_block">
<table cellpadding="2px" cellspacing="0" border="0" class="vendor_yahoo_table">
<tr>
<td id="small_font_vendors">Setup:</td>
<td><input  size="3" type="text" name="vothsetup" value="<?php echo $_POST['vothsetup']; ?>" /></td>
<td id="small_font_vendors">All<br />Prints:</td>
<td><input type="text" size="3" name="vothprints" value="<?php echo $_POST['vothprints']; ?>" /></td>
</tr>
</table>
</div>
</div>
<div class=" save"><input type="submit" value="Save"  name="save" id="save"  />&nbsp;<input type="submit" name="snn" value="Save & New" id="save_new" />&nbsp;<input value="Save & Close" type="submit" name="snc" id="save_close" />&nbsp;<input type="submit" name="revert" value="Revert" id="revert" /></div>
</div>
</div>

</form>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-2009. All Rights Reserved</div>
</body>
</html>
