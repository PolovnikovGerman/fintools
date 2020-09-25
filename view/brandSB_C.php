<?php include('../controller/brandSB_C_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('../includes/headerFiles.php'); ?>

<script language="JavaScript" type="text/javascript" src="../js/ajaxCalls_SB.js"></script>
<link href="../css/styleSB.css" rel="stylesheet" type="text/css" />
<style>
	
	
	</style>
	

<title>BT System - Items </title>
</head>
<body onload="art_hide_modules()"  ><div id="loader"><img src="../images/loader.gif" /></div>
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 	<div class="mock_title"><b>Items</b></div>
 	<div style="float:left; margin-left:0px; z-index:999; margin-top:9px;"><a href="brandSB.php"><img   src="../images/brand_SB_a.png" /></a>
  	</div>
 	<div class="clear"></div>
  
  	<div style="width:960px; margin:auto; text-align:center; margin-top:-1px;  border:1px #232323 solid; height:730px; ">
		
    	<div class="clear"></div>
    	<div><input name="sbCatID" type="hidden" value="0" />
        	
          

		


<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<div class="left sbItemsList" id="sbItems" style="margin:20px;"   >
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" style="border:1px #6C6C6C solid;" >
            <tr><td><b>Item ID</b></td><td><b>Item Name</b></td></tr>
        	<?php
				for($i=0 ; $i < sizeof($brandSB['sbID']); $i++)
					echo "<tr class=\"hilite\" ".col_bg('#f5f5f5',($i+1))."><td><a href=\"#?w=800&v=edit&id=".$brandSB['sbID'][$i]."&org=open\" rel=\"popup_name\" class=\"poplight\" >".$brandSB['sbItemID'][$i]."</a></td><td>".$brandSB['sbName'][$i]."</td></tr>";
				
			?>
            </table>
            
            </div>
        </div>
 	</div>
	<div class=clear></div>
</div>

<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>

</div>
<fORM action="<?PHP echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post" onsubmit="return checkSBForm()">
<input type="hidden" name="SB_type" /><input type="hidden" name="sbID" />
<div id="popup_name" class="popup_block" >
	<div >
		<div class="navigation"  >
			<ul><li class="live menuSB" id="SBData">Data</li><li class="menuSB" id="SBImages">Images</li><li class="menuSB" id="SBPricing">Pricing</li><li class="menuSB" id="SBAttributes">Attributes</li><li style="margin-left:300px; background-color:white; border:none; font-weight:bold;" id="itemName_tab"></li></ul>
            <div style="border:1px #575757 solid; margin-top:5px; ">
			<!-- DATA DIV -->	
                <div style="margin:10px; " class="SBData">
                	<div style="float:left; width:210px; ">
          				<table border="0" cellspacing="5px" style="font-size:12px;">
                    	<tr>
		                    <td>Item ID</td>
        	                <td><input type="text" size="20" name="itmID" /></td>
                        </tr>
                        <tr> 
                            <td>Name</td>
                            <td><input type="text"  size="20" name="sbName" /></td>
                        </tr>
                        <tr>
                            <td>Webpage</td>
                            <td><input type="text"  size="20" name="sbWebpage"/></td>
                        </tr>
                        <tr>
                            <td>Colors</td>
                            <td><input type="text"  size="20" name="sbColors" /></td>
                        </tr>
                        <tr>
                            <td>Size</td>
                            <td><input type="text"  size="20" name="sbSize"/></td>
                        </tr>
                        <tr>
                            <td>Weight</td>
                            <td><input type="text"  size="20" name="sbWeight"/></td>
                        </tr>
                        <tr>
                            <td>Material</td>
                            <td><input type="text"  size="20" name="sbMaterial" /></td>      
                        </tr>
                        <tr>
                            <td>Lead A</td>
                            <td><input type="text"  size="20" name="sbLeada"/></td>
                        </tr>
                        <tr>
                            <td>Lead B</td>
                            <td><input type="text"  size="20" name="sbLeadb" /></td>
                        </tr>
                        <tr>
                            <td>Lead C</td>
                            <td><input type="text"  size="20" name="sbLeadc" /></td>
                        </tr>
                        <tr><td>Template</td><td><input type="text" name="sbTemplate" /></td></tr>
                    </table>
                    </div>
                    <div style="float:left; font-size:12px; background-color:#FFD9B3; border:1px #FF9122 solid; padding:5px 10px; width:200px;  ">
                    	<table>
                        <tr><td>New</td><td><select name="sbNew"><option value="yes">yes</option><option value="no">no</option></select></td></tr>
                        <tr><td>Active</td><td><select name="sbActive"><option value="yes">yes</option><option value="no">no</option></select></td></tr>
                        <tr><td>NJ Tax</td><td><select name="sbTax"><option value="yes">yes</option><option value="no">no</option></select></td></tr>
                   
                        <tr><td colspan="2">Internal Keywords</td></tr>
                        <tr><td colspan="2"><textarea name="sbKeys" cols="23" rows="8"></textarea></td></tr>
                        <tr><td></td><td></td></tr>
                        <tr><td>Set up: <input type="text" size="3" name="sbSetup" /></td><td>Ext Prints: <input type="text" size="3" name="sbPrints" /></td></tr>
                        </table>
                    </div>
                    <div style="float:right; width:240px;  margin-left:5px;  font-size:12px;">
                	    <table>
        			<tr><td>Vendor</td><td id="vendors"><input type="text" size="26" name="sbVendor"/></td></tr>
                    <tr><td>Vendor Price</td><td><input type="text" size="26" name="sbVprice" /></td></tr>            
		            <tr><td>Vendor Notes</td><td><textarea rows="3" cols="17" id="sbV" name="sbVnotes"></textarea></td></tr>

                    <tr><td>Meta Title</td><td><input type="text" size="26"  name="sbMtitle"/></td></tr>
                    <tr><td>Meta Keywords</td><td><textarea rows="3" cols="17" name="sbMkeys"></textarea></td></tr>
                    <tr><td>Meta Description</td><td><textarea rows="3" cols="17" name="sbMdesc"></textarea></td></tr>
					</table> 
                    </div>
                 	<div class="clear"></div>
				</div>
            <!-- END OF DATA DIV -->  
            
            <!-- IMAGES DIV -->  
                <div style="margin:10px; display:none;" class="SBImages">
					<div style="width:220px;   float:left;">
                	    <table border="0" cellpadding="0" cellspacing="0">
                    
                    <tr>
                    	<td align="center" id="img1"><img src="../images/TEMP_DEL.jpg" class="sbImg" height="60px" width="60px" /></td>
                        <td align="center" id="img2"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
	                </tr>
                    <tr>
                    	<td><input type="file" id="image1" size="1" name="fileX[]" /></td>
                        <td><input type="file" size="1" name="fileX[]" /></td>
                    </tr>
                    <tr>
                    	<td align="center" id="img3" ><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
                        <td align="center"  id="img4"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
	                </tr>
                    <tr>
                    	<td><input type="file" size="1" name="fileX[]" /></td>
                        <td><input type="file" size="1" name="fileX[]" /></td>
                    </tr>
                    <tr>
                    	<td align="center" id="img5"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
                        <td align="center"  id="img6"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
	                </tr>
                    <tr>
                    	<td><input type="file" size="1" name="fileX[]" /></td>
                        <td><input type="file" size="1" name="fileX[]" /></td>
                    </tr>
                    <tr>
                    	<td align="center"  id="img7"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
                        <td align="center"  id="img8"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
	                </tr>
                    <tr>
                    	<td><input type="file" size="1" name="fileX[]" /></td>
                        <td><input type="file" size="1" name="fileX[]" /></td>
                    </tr>
                    <tr>
                    	<td align="center"  id="img9"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
                        <td align="center"  id="img10"><img src="../images/TEMP_DEL.jpg" class="sbImg"  height="60px" width="60px" /></td>
	                </tr>
                    <tr>
                    	<td><input type="file" size="1" name="fileX[]" /></td>
                        <td><input type="file" size="1"  name="fileX[]"/></td>
                    </tr>
                    </table>
                    </div>
                    <div style="float:right; width:400px; padding:8px 20px; font-size:12px;  background-color:#FFD9B3; border:1px #FF9122 solid;  ">
                    	<table cellpadding="3px">
                        <tr><td>#</td><td>Imprint Name</td><td>Size</td><td>Image</td></tr>
                        <tr><td>1.</td><td><input type="text" size="30" id="impN1" name="impName[]" /></td><td><input type="text" id="impS1" size="5" name="impSize[]" /></td><td><input type="file" size="3"  name="fileY[]" /></td><td class="impLink" id="imp1"></td></tr>
                        <tr><td>2.</td><td><input type="text" size="30"  id="impN2" name="impName[]" /></td><td><input type="text" id="impS2"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td  class="impLink" id="imp2"></td></tr>
                        <tr><td>3.</td><td><input type="text" size="30" id="impN3"  name="impName[]" /></td><td><input type="text" id="impS3"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td class="impLink"  id="imp3"></td></tr>
                        <tr><td>4.</td><td><input type="text" size="30"  id="impN4" name="impName[]" /></td><td><input type="text" id="impS4"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td  class="impLink" id="imp4"></td></tr>
                        <tr><td>5.</td><td><input type="text" size="30"  id="impN5" name="impName[]" /></td><td><input type="text" id="impS5"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td class="impLink"  id="imp5"></td></tr>
                        <tr><td>6.</td><td><input type="text" size="30"  id="impN6" name="impName[]" /></td><td><input type="text" id="impS6"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td  class="impLink" id="imp6"></td></tr>
                        <tr><td>7.</td><td><input type="text"  size="30"  id="impN7" name="impName[]"/></td><td><input type="text" id="impS7"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td class="impLink"  id="imp7"></td></tr>
                        <tr><td>8.</td><td><input type="text"  size="30"  id="impN8" name="impName[]"/></td><td><input type="text" id="impS8"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td class="impLink"  id="imp8"></td></tr>
                        <tr><td>9.</td><td><input type="text" size="30"  id="impN9" name="impName[]" /></td><td><input type="text"  id="impS9" size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td  class="impLink" id="imp9"></td></tr>
                        <tr><td>10.</td><td><input type="text" size="30"  id="impN10" name="impName[]" /></td><td><input type="text" id="impS10"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td  class="impLink" id="imp10"></td></tr>
                        <tr><td>11.</td><td><input type="text" size="30" id="impN11"  name="impName[]" /></td><td><input type="text"  id="impS11" size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td class="impLink"  id="imp11"></td></tr>
                        <tr><td>12.</td><td><input type="text" size="30" id="impN12"  name="impName[]" /></td><td><input type="text" id="impS12"  size="5" name="impSize[]" /></td><td><input type="file" size="3" name="fileY[]" /></td><td  class="impLink" id="imp12"></td></tr>
                        </table>
                    </div>
                	<div class="clear"></div>
                </div>
            <!-- END OF IMAGES DIV -->    
            
            <!-- PRICING DIV -->
                <div style="margin:10px; display:none;  font-size:12px;" class="SBPricing">
           		     <table style="padding:5px;">
                <tr>
                	<td>Quantity<input type="hidden" name="sbPrID1" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td><input type="text" size="3" name="sbQty[]" /></td>
                    <td>Setup</td>
                    <td></td>
                </tr>
                <tr>
                	<td>Price<input type="hidden" name="sbPrID2" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]"/></td>
                    <td><input type="text" size="3" name="sbPrice[]"/></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td><input type="text" size="3" name="sbPrice[]" /></td>
                    <td></td>
                </tr>
                <tr>
                	<td>Sale Price<input type="hidden" name="sbPrID3" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td><input type="text" size="3" name="sbSale[]" /></td>
                    <td></td>
                </tr>
                <tr><td align="center">Name</td>
                <td colspan="13"><hr /></td>
                <td align="center">Webpage</td></tr>
               
                <tr>
                	<td><input type="text" size="10" name="cmpName1" /><input type="hidden" name="sbPrID4" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3"  name="sbCmp1[]"/></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]"/></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="3" name="sbCmp1[]" /></td>
                    <td><input type="text" size="10" name="cmpWebpage1" /></td>
                </tr>
                
               
                <tr>
                	<td><input type="text" size="10" name="cmpName2" /><input type="hidden" name="sbPrID5" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="3" name="sbCmp2[]" /></td>
                    <td><input type="text" size="10" name="cmpWebpage2" /></td>
                </tr>
            
                <tr>
                	<td><input type="text" size="10" name="cmpName3" /><input type="hidden" name="sbPrID6" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="3" name="sbCmp3[]" /></td>
                    <td><input type="text" size="10" name="cmpWebpage3" /></td>
                </tr>
                <tr><td align="center"></td>
                <td colspan="12"><hr /></td>
                <td align="center"></td></tr>
                 <tr>
                	<td>Profit $</td>
                    <td><input type="text" size="5" readonly="readonly" id="prf1" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf2" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf3" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf4" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf5" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf6" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf7" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf8" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf9" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf10" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf11" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="prf12" class=pr /></td>
                    <td></td>
                </tr>
                <tr>
                	<td>Profit %</td>
                    <td><input type="text" size="5" readonly="readonly" id="pct1" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct2" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct3" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct4" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct5" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct6" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct7" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct8" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct9" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct10" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct11" class=pr /></td>
                    <td><input type="text" size="5" readonly="readonly" id="pct12" class=pr /></td>
                    <td></td>
                </tr>
                </table>
                	<div class="clear"></div>
                </div>
            <!-- END OF PRICING DIV -->  
             <!-- ATTRIBUTES DIV -->  
                <div style="margin:10px; display:none;" class="SBAttributes">
					<div style="float:left; font-size:12px;">
                	    <table border="0" cellpadding="5" cellspacing="5">
                        	<tr><td><b>Attribute 1</b></td><td><textarea name="sbAttr[]" cols="95" rows="2"></textarea></td></tr>
                            <tr><td><b>Attribute 2</b></td><td><textarea name="sbAttr[]" cols="95" rows="2"></textarea></td></tr>
                            <tr><td><b>Attribute 3</b></td><td><textarea name="sbAttr[]" cols="95" rows="2"></textarea></td></tr>
                            <tr><td><b>Attribute 4</b></td><td><textarea name="sbAttr[]" cols="95" rows="2"></textarea></td></tr>
                    	</table>
                    </div>
                   
                	<div class="clear"></div>
                </div>
            <!-- END OF ATTRIBUTES DIV -->    
			</div>
		</div>
 	</div>
    <div style="float:left; margin:10px"><span id="actEdit"></span></div>
    <div style="float:right; margin:10px;"><input type="submit" id="sbSave" value="SAVE" name="SB_save" class="popUp_save" />
    </div>
</div>

<script type="text/javascript">
$('#loader').html('');
</script>
</body>
</html>