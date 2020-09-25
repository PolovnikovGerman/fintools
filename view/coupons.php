<?php include('../controller/coupons_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php include('../includes/headerFiles.php'); ?>

<script language="JavaScript" type="text/javascript" src="../js/ajaxCalls_Coupons.js"></script>
<link href="../css/coupons.css" rel="stylesheet" type="text/css" />

<title>BT System - Fullfillment </title>
</head>
<body onload="art_hide_modules()"  >
<div id="loader"><img src="../images/loader.gif"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 	<div class="content">
 		<div  class="mock_title"><b>Coupons</b></div>
 			<div style="float:left; margin-left:0px; z-index:999; margin-top:9px;">
            <?php
			if($portal == 'buttons')
			    echo '<a href="coupons.php"><img style="border-bottom:1px #0D0D0D solid; "   src="../images/brand_SB.png" /></a><a href="coupons.php?portal=buttons"><img   src="../images/brand_BU.png" /></a></div>';			
			else
			    echo '<a href="coupons.php"><img   src="../images/brand_SB_a.png" /></a><a href="coupons.php?portal=buttons"><img style="border-bottom:1px #0D0D0D solid; "  src="../images/brand_BU_ia.png" /></a></div>';
            ?>
			<div class="clear"></div>
          
        <div style="width:960px; margin:auto; text-align:center; margin-top:-1px;  border:1px #232323 solid; height:730px; ">
			<div class="couponBody">
            	<table border="0" cellpadding="0" cellspacing="0" class="couponHeadTable"  >
                	<tr><th>Status</th><th>Type</th><th>Code</th><th>Description</th><th>Value</th><th>Unit</th><th>Action</th></tr>
                    <tr><input type="hidden" id="editID" /><input type="hidden" name="portal" value="<?php echo $portal; ?>" />
                    	<td><input type="checkbox"  id="status" name="status" /></td>
                    	<td><select id="selectType" name="type"><option value="survey">survey</option><option value="promo">promo</option></select></td>
                        <td><input type="text" id="code" name="code" size="8" /></td>
                        <td><input type=text id="coupDesc" name="description" size="60"/></td>
                        <td><input type=text id="coupValue" name="value" size="4"/></td>
                        <td><select id="selectUnit" name="vUnit"><option value="pct">pct</option><option value="dlr">dlr</option><option value="ship">ship</option></select></td>
                        <td><input type="button" id="save" class="adCoupon" name="addCoupon" value="save" /></td>
                    </tr>
                </table>
                <div class="couponDiv">
                <table id="couponTable"    border="0" cellpadding="0" cellspacing="0">
                <tr><th>Status</th><th>Type</th><th>Code</th><th>Description</th><th>Value</th><th>Unit</th><th>Edit</th></tr>
                	<?php
						for($i = 0; $i < sizeof($coup); $i++)
							echo "<tr class=hilite>
									<td>".$coup[$i]['coupStatus']."</td>
                    				<td>".$coup[$i]['coupType']."</td>
			                        <td class=coupCode>".$coup[$i]['coupCode']."</td>
            			            <td>".$coup[$i]['coupDesc']."</td>
                        			<td>".$coup[$i]['coupValue']."</td>
			                        <td>".$coup[$i]['coupUnit']."</td>
            			            <td class=edit id=".$coup[$i]['coupID']."><img src=\"../images/edit_icon1.gif\"></td>
                    			 </tr>";
					?>
                    <tr><td colspan="7"></td></tr>
                </table>
                </div>
                
            </div>
		</div>


	</div>

	<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
$('#loader').html('');
</script>
</body>
</html>