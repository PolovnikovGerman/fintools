<?php include('../controller/brandBU_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php include('../includes/headerFiles.php'); ?>

<script language="JavaScript" type="text/javascript" src="../js/ajaxCalls_BU.js"></script>
<link href="../css/styleBU.css" rel="stylesheet" type="text/css" />


<title>BT System - Items </title>
</head>
<body onload="art_hide_modules()"  ><div id="loader"></div>

<div id="att_wrap"></div>
	
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

<div class="content">
	<div class="mock_title"><b>Items</b></div>
	<div style="float:left; margin-left:0px; z-index:999; margin-top:9px;"><a href="brandSB.php"><img style="border-bottom:1px #0D0D0D solid; "  src="../images/brand_SB.png" /></a><a href="brandBU.php"><img  src="../images/brand_BU.png" /></a></div>
 	<div class="clear"></div>
  
    <div class="<?php echo $ret['error']['flag']; ?>"><?php echo $ret['error']['msg']; ?></div>
	<div style="width:960px; margin:auto;  margin-top:-1px;  border:1px #232323 solid; height:730px; ">
	<div class="right" style="margin:5px;"><a href="#?w=450&v=add&id=0&org=open" rel="popup_name" class="poplight popUp_addNew" >add New</a></div>
    
    <div class="clear"></div>
	<table border="0" cellpadding="0" cellspacing="0" class="BU_viewTable" style="border-top:1px #ababab solid; margin-top:10px;" >
    <tr style="font-weight:bold; color:white; background-color: #723838">
    <td width="40px">#</td>
    <td width="100px">ItemID</td>
    <td  width="265px">Name</td>
    <td width="45px">1</td>
    <td width="45px">10</td>
    <td width="45px">25</td>
    <td width="45px">50</td>
    <td width="45px">100</td>
    <td width="45px">250</td>
    <td width="45px">500</td>
    <td width="45px">1000</td>
    <td width="45px">2500</td>
    <td width="45px">5000</td>
    <td width="45px">100k</td>
    </tr>
    </table>
    <div style="  height:660px; overflow:scroll;" >
    <table border="0" cellpadding="0" cellspacing="0" class="BU_viewTable">   
    <?php
	if(sizeof($brandBU['itemID']) == 0)
	echo "<tr><td width=939 colspan=14 align=center><b>No Items to Display.</td></tr>";
	else 
	for($i = 0; $i < sizeof($brandBU['itemID']); $i++ )
	{
	echo "<tr ".col_bg("#eaeaea",($i+1))." class=hilite>";
	echo "<td width=\"40px\">".($i+1)."</td>";
	echo "<td width=\"100px\"><a href=\"#?w=450&v=edit&id=".$brandBU['buID'][$i]."&org=open\" rel=\"popup_name\" class=\"poplight\" >".$brandBU['itemID'][$i]."</a></td>";
	echo "<td width=\"265px\">".substr($brandBU['itemName'][$i],0,40)."</td>";
	echo "<td width=\"45px\">".$brandBU['p1'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p10'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p25'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p50'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p100'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p250'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p500'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p1000'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p2500'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p5000'][$i]."</td>";
	echo "<td width=\"45px\">".$brandBU['p10k'][$i]."</td>";
	echo "</tr>";
	}
	?>
    </table>
    </div>

	</div>

<div class=clear></div>
</div>

<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>

</div>

<div id="popup_name" class="popup_block" >


<div>
 
 <div class="itemFieldList">
 <form action="<?php $_SERVER['PHP_SELF']; ?>" onsubmit="return checkBuForm();" enctype="multipart/form-data" method="post">
 <input type="hidden" name="BU_type" /><input type="hidden" name="buID" />
 <table style="font-size:12px;">
 <tr><td>Item ID</td><td><input type="text" name="buItemID" /></td></tr>
 <tr><td>Name</td><td><input type="text" name="buName" /></td></tr>
 <tr><td>Category</td><td><input type="text" name="buCat" /></td></tr>
 <tr><td>Item Size</td><td><input type="text" name="buSize" /></td></tr>
 <tr><td>Text Limit</td><td><input type="text" name="buText" /></td></tr>
 <tr><td>Out Limit</td><td><input type="text" name="buCut" /></td></tr>
 <tr><td>Weight</td><td><input type="text" name="buWeight" /></td></tr>
 <tr><td colspan="2">Buttons Per Print Page:&nbsp;&nbsp;<input type="text" size="7" name="buPrint" /></td></tr>
 </table>
 <br />
Template pic <input type="file" size="1" name="buPic" /><br /><br />
<div  class="buPicArea"></div>
 </div>
 
<div class="priceList">
	<table  style="font-size:12px;" cellspacing="10">
		<tr align="center">
			<td>1</td>
			<td><input type="text" style="font-size:11px;" name="price1" size="4" /></td>
		</tr>
        <tr>
			<td>10</td>
            <td><input type="text" style="font-size:11px;" name="price10"  size="4" /></td>
		</tr>
        <tr>
			<td>25</td>
            <td><input type="text" style="font-size:11px;" name="price25"  size="4" /></td>
		</tr>
        <tr>
			<td>50</td>
            <td><input type="text" style="font-size:11px;" name="price50"  size="4" /></td>
		</tr>
        <tr>
			<td>100</td>
            <td><input type="text" style="font-size:11px;" name="price100"  size="4" /></td>
		</tr>
        <tr>
			<td>250</td>
            <td><input type="text" style="font-size:11px;"  name="price250" size="4" /></td>
		</tr>
        <tr>
			<td>500</td>
            <td><input type="text" style="font-size:11px;" name="price500"  size="4" /></td>
		</tr>
        <tr>
			<td>1000</td>
            <td><input type="text" style="font-size:11px;" name="price1000"  size="4" /></td>
		</tr>
        <tr>
			<td>2500</td>
            <td><input type="text" style="font-size:11px;" name="price2500"  size="4" /></td>
		</tr>
        <tr>
			<td>5000</td>
            <td><input type="text" style="font-size:11px;" name="price5000"  size="4" /></td>
		</tr>
        <tr>
			<td>10,000</td>
            <td><input type="text" style="font-size:11px;" name="price10k"  size="4" /></td>
		</tr>
        <tr>
			<td>20,000</td>
            <td><input type="text" style="font-size:11px;" name="price20k"  size="4" /></td>
		</tr>
        <tr>
			<td>50,000</td>
            <td><input type="text" style="font-size:11px;" name="price50k"  size="4" /></td>
		</tr>
        <tr>
			<td>100,000</td>
            <td><input type="text" style="font-size:11px;" name="price100k"  size="4" /></td>
		</tr>
	</table>
</div>
<div class="clear"></div>

</div>




<div style="float:left;"><span id="actEdit"></span></div>
<div style="float:right; margin:10px;"><input type="submit" id="buSave" name="BU_save"  value="SAVE" class="popUp_save"/></div>
</div>
</body>
</html>