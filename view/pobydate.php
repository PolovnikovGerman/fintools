<?php include('../controller/podate_controller.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../js/jquery.js"></script>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script> -->
<script type="text/javascript" src="../js/json2.js"></script>
<script type="text/javascript" src="../js/client.js"></script>
<script type="text/javascript" src="ajax_calls.js"></script>
<script type="text/javascript" src="attach_ajax_calls.js"></script>
<script type="text/javascript" src="fl_ajax_calls.js"></script>
<script type="text/javascript" src="../js/menu.js"></script>
<script type="text/javascript" src="../js/jquery.pagination.js"></script>
<script type="text/javascript" src="../js/purchorder_bydate.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<link href="../css/pagination.css" rel="stylesheet" type="text/css" />
<style >
.ff_mn li {
    display: inline;
    margin-left: -4px;
    padding: 5px 12px 4px;
}    
.po_daterow {
    clear: both;
    float: left;
    font-weight: bold;
    padding-left: 15px;
    width: 290px;
}
.po_datarow {
    clear: both;
    float: left;
    width: 390px;
}
.vendor_name {
    float: left;
    padding-left: 30px;
    width: 160px;    
}
.po_number {
    float: left;
    width: 115px;    
}
.po_open {
    float:left; 
    width:80px;
    text-align:center;
}

</style>
<title>BT System - PO by Date </title>
</head>
<body onload="art_hide_modules()">
    <input type="hidden" id="totalrec" value="<?=$num_recs?>"/>
    <input type="hidden" id="curpage" value="<?=$curpage?>"/>
    <div id="loader"><img src="../images/loader.gif" /></div>
    <div style="position:absolute; top:0; left:45%; z-index:1000;"><iframe name="atchiframe" src="attach_iframe.php" frameborder="0" marginwidth="0" marginheight="0"  height="19" width="175"></iframe></div>
    <div id="att_wrap"></div>
    <div class="wrap" style="margin-left:320px; float: left; clear: both; width: 1237px;">
        <?php include("../includes/header_navigation.php"); ?>
        
        <div class="content" style=" color:#2D2D2D; margin-left:20px; font-size:14px;">
            <div class="pagetitle" style="float: left; margin-left: 10px; margin-top: 5px;font-weight: bold;">
                POs by date
            </div>
            <div class="orderselector" style="float:left; margin-left: 50px;width: 190px;">
                Orders:
                <select onchange="display_or(this.value);">
                <?php
                if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
                echo "<option value=".$_SESSION['or'].">".$_SESSION['or']."-".($_SESSION['or']+500)."</option>"; 

                for($i=22000; $i<75000; $i+=500) {
                    if(($i%1000) == 0)
                        echo "<option style=\"background-color:#ececec;font-weight:bold;font-size:11px; color:#3A3A3A; padding:3px 3px;\" value=$i <b>$i-".($i+499)."</b></option>";
                    else
                        echo "<option style=\"font-size:10px; padding:3px 3px;\" value=$i>&nbsp;$i-".($i+499)."</option>";

                }
                ?>
                </select>               
            </div>
            <div class="sort_filters" style="float:left; margin-left: 30px;width: 547px;">
                <span <?php echo (!isset($_SESSION['whr'])) ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=all">ALL</a></span>
                <span <?php echo ($_SESSION['whr']=='ch_placed_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_placed_ck">Not Placed</a></span>
                <span <?php echo ($_SESSION['whr']=='ch_conf_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_conf_ck">Not Confirmed</a></span>
                <span <?php echo ($_SESSION['whr']=='ch_ship_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_ship_ck">Not Shipped</a></span>
                <span <?php echo ($_SESSION['whr']=='ch_cust_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_cust_ck">Cust Trk</a></span>
                <span <?php echo ($_SESSION['whr']=='ch_issue_ck') ? 'class=_sort_act' : 'class=_sort'; ?>><a href="fullfillment.php?whr=ch_issue_ck">Issues</a></span>               
            </div>  
            <div style="clear: both; margin: 5px 10px 0 14px; float:left;">
                <ul class="ff_mn">
                    <li class=cat_inactive ><a href="fullfillment.php">Fullfillment</a></li>
                    <li class=cat_inactive ><a href="chinese.php">Chinese</a></li>
                    <li class=cat_inactive ><a href="art3.php">Art Overview</a></li>
                    <li class=cat_active ><a href="pobydate.php">POs by Date</a></li>  
                <ul>
            </div>
            <div class="pageview" style="float:left; width: 460px;">
                <div id="Pagination"></div>
            </div>
            <div class="clear"></div>
            <div>
                <table width="415px" border="0" cellpadding="0" cellspacing="0"  class="task_today_entry"  style="margin-left:10px; border:1px #181818 solid; border-bottom:1px #ababab solid; ">
                    <tr class="ffTableHead">                        
                        <td width="115px" align="center">Vendor</td>
                        <td width="115px" align="center">PO#</td>
                        <td width="90px" align="center">Open</td>                        
                    </tr> 
                </table>
            </div>
            <div style="border:1px #181818 solid; border-top:none;  margin:0px 10px 10px 10px;width: 415px;">
                <div style=" height:690px; padding:0px; overflow:auto;  width: 415px;">
                    <div id="order_area" >
                    </div>
                </div>
            </div>
        </div> <!-- Content END -->
    </div> <!-- Wrap END -->
</body>
</html>
