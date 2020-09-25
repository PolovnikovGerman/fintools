<?php include('../controller/fl_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ui/jquery-ui-1.8.5.custom.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/temp.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../css/search.css" rel="stylesheet" type="text/css" />
<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; width:600px; }
			li.ui-menu-item { border-bottom:1px #999999 solid !important; }
	
	--></style> 
    
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#auto').autocomplete(
        {
            source: "../model/search.php",
            minLength: 1,
			width: 600
        });
    });
</script>


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<link href="../css/search.css" rel="stylesheet" type="text/css" />
<title>BT System - Fullfillment </title>
</head>
<body onload="art_hide_modules()"  >
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:10px 10px 5px 20px;"><b>Heading</b></div>
 <div style="width:1140px; margin:auto; border:1px #666666 solid; height:700px; ">
<div style=" width:350px; margin:10px; float:left;  padding:10px; border:1px gray solid; height:500px;">

<form action="#" method="post">
	Enter Search String:
	<input type="text"  id="auto" />
 
	<input type="button" value="Search" id="sb_search" />
</form>

</div>
<div class="disp" style="float:right; margin:10px; padding:10px; overflow:auto; width:650px; border:1px gray solid; height:500px;">
        
                                                          
</div>
</div>


</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>

</body>
</html>