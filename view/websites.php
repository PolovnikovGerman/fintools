<?php include('../controller/fl_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="attach_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="fl_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
<style>
a img{border:none;}
</style>

<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Websites </title>
</head>
<body onload="art_hide_modules()"  >
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:10px 10px 5px 20px;"><b>websites - Backend Views</b></div>
 <div style="width:960px; margin:auto; border:1px #333333 solid; height:730px; ">
	<div style="margin:20px;"><div style="margin:0 auto; text-align:center;"><h3>Click a logo to open up the backend view of that site.</h3></div>
		<div style="margin:0 auto; padding:20px;  width:400px;"><a href="http://www.bluetrack.net/test/sites/bluetrack/" target="_blank"><img src="../sites/bluetrack/images/BLUETRACK_Official_Logo.png"/></a></div>
    	<div style=" float:left;  padding:20px;  width:210px;"><a href="http://www.bluetrack.net/test/sites/buttonUniverse/" target="_blank"><img src="../sites/buttonUniverse/images/logo.png" /></a></div>
        <div style="float:right; padding:20px; margin-top:30px;   width:370px; "><a href="http://www.bluetrack.net/test/sites/stressballs/" target="_blank"><img src="../sites/stressballs/img/SB_backendLogo.png" /></a></div>
        <div class="clear"></div>
        <div style="float:left; padding:20px;"><img src="../sites/onemillionpromos/images/OneMillionPromos_logo.png" /></div>
        <div style="float:right; padding:20px;"><img src="../sites/meadowlandstudios/images/meadowlands-logo.png" /></div>
    	
    </div>
</div>


</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>