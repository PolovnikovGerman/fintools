<?php if(isset($_GET['cat']) && $_GET['cat'] == 'bu') {?>
 <div style="float:left; margin-left:0px; z-index:999; margin-top:9px;"><a href="<?php echo $_SERVER['PHP_SELF']."?cat=bt";?>"><img style="border-bottom:1px #0D0D0D solid; "  src="../images/brand_BT_ia.png" /></a><a href="<?php echo $_SERVER['PHP_SELF']."?cat=bu";?>"><img  src="../images/brand_BU.png" /></a></div>
 <?php } else if(isset($_GET['cat']) && $_GET['cat'] == 'bt') { ?>
 <div style="float:left; margin-left:0px; z-index:999; margin-top:9px;"><a href="<?php echo $_SERVER['PHP_SELF']."?cat=bt";?>"><img   src="../images/brand_BT.png" /></a><a href="<?php echo $_SERVER['PHP_SELF']."?cat=bu";?>"><img style="border-bottom:1px #0D0D0D solid; "  src="../images/brand_bu_ia.png" /></a></div>
 <?php } else  { ?>
 <div style="float:left; margin-left:0px; z-index:999; margin-top:9px;"><a href="<?php echo $_SERVER['PHP_SELF']."?cat=bt";?>"><img   src="../images/brand_BT.png" /></a><a href="<?php echo $_SERVER['PHP_SELF']."?cat=bu";?>"><img style="border-bottom:1px #0D0D0D solid; "  src="../images/brand_bu_ia.png" /></a></div>
 <?php } 