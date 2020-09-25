<?php include('../controller/leads_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script src="../includes/calendar/js/jscal2.js"></script>
    <script src="../includes/calendar/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/img/img.css" />

<script language="JavaScript" type="text/javascript" src="leads_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/popUp.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
<link href="../images/popUp.css" rel="stylesheet" type="text/css" />


<link href="../images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function(){
        $("a#exportleads").click(function(){
           export_leads(); 
        });
    });
    
    function export_leads() {
        if (confirm('You realy want to export data into excell ?')) {
            var url='leads_export.php';
            $('#loader').empty().html('<img src="../images/loader.gif" />');
            $.post(url, {}, function(response){
                $('#loader').empty();
                if (response.errors=='') {
                    window.location.href=response.url;
                } else {
                    alert(response.errors);
                }
            }, 'json');
        }        
    }
</script>
<title>BT System - Leads </title>
</head>
<body onload="art_hide_modules()"  ><div id="loader"><img src="../images/loader.gif" /></div>
<div id="att_wrap"></div>

<div class="wrap">
<?php include("../includes/header_navigation.php"); 

?>
 <div class="content">
 <div class="ld_title"><b>Lead Management</b></div>
 <div class="ld_new_lead"><a href="#?w=700&v=two&id=0&org=open" rel="popup_name" class="poplight" style="color:white;">Add New Lead</a></div>
 <div class="ld_users">
 <ul>
 <li <?php if($_SESSION['repID'] == 99) echo "class=active" ?>><a class=load  href="leads.php?repID=99">All</a></li><li <?php if($_SESSION['repID'] == 100) echo "class=active" ?>><a class=load  href="leads.php?repID=100">Unassigned</a></li><li <?php if($_SESSION['repID'] == 1) echo "class=active" ?>><a class=load  href="leads.php?repID=1">Sean</a></li><li <?php if($_SESSION['repID'] == 2) echo "class=active" ?>><a class=load  href="leads.php?repID=2">Sage</a></li><li <?php if($_SESSION['repID'] == 4) echo "class=active" ?>><a class=load  href="leads.php?repID=4">Nick</a></li><li <?php if($_SESSION['repID'] == 8) echo "class=active" ?>><a class=load  href="leads.php?repID=8">Lisa</a></li><li <?php if($_SESSION['repID'] == 12) echo "class=active" ?>><a class=load  href="leads.php?repID=12">Cris</a></li></ul>
 </div>
 <div class="clear"></div>
 <div class="ld_fence">
 <div class="ld_sort">Sort By: 
 <a  <?php if($_SESSION['leadSort'] == 'leadID') echo "class=\"load noLink\""; else echo "class=\"load link\""; ?>  href="leads.php?leadSort=leadID">Date Created</a> | <a <?php if($_SESSION['leadSort'] == 'leadDateTime') echo "class=\"load noLink\""; else echo "class=\"load link\""; ?>  href="leads.php?leadSort=leadDateTime">Last Updated</a> | <a <?php if($_SESSION['leadSort'] == 'leadType') echo "class=\"load noLink\""; else echo "class=\"load link\""; ?>  href="leads.php?leadSort=leadType">Priority</a>
 
 <?php
 //////////////////////////////////////////////DISPLAYING PAGE NUMBERS FOR OPEN LEADS//////////////////////////////////////////////////////////
 
 echo "<select style=\"margin-left:120px;\" onchange=DisplayPage(this.value)>";
 for($i=0;$i<$page;$i++)
 {
 	if($i%2 ==0)
 		echo "<option class=option1 ";
	else
		echo "<option class=option2 ";
 if($_SESSION['leadPg'] == $i) echo "\"selected = selected\"";
 echo " value=$i>Leads <b>".(($i*200)+1)." - ".(($i*200)+200)."</b></option>";
 }
 echo "</select>";
 //////////////////////////////////////////////DISPLAYING PAGE NUMBERS FOR OPEN LEADS//////////////////////////////////////////////////////////
 ?>
 <span class='_sort'><a id="exportleads" href="javascript:void(0)">Export</a></span>
 </div>
 <div class="ld_key">
 <table ><tr><td style="border:1px #626262 solid" bgcolor="#fbde1f" width="10px">&nbsp;</td><td>Priority</td><td width="10px"  style="border:1px #626262 solid"  bgcolor="#91c9fc">&nbsp;</td><td>Closed</td></tr>
<tr><td  style="border:1px #626262 solid"  bgcolor="#ffffff">&nbsp;</td><td>Open</td><td  style="border:1px #626262 solid"  bgcolor="#b35895">&nbsp;</td><td>Dead</td></tr></table>
 </div>
 <div class="ld_toggle"><?php if($_SESSION['DC'] == 'yes') echo "Hide:"; else echo "Show:"; ?> <span id="closedDead"><?php if($_SESSION['DC'] == 'yes') echo "<a class=load  href=\"leads.php?DC=no\">Closed/Dead</a>"; else echo "<a class=load  href=\"leads.php?DC=yes\">Closed/Dead</a>"; ?></span></div>
<div class="clear"></div>

<div>
<table  cellspacing="0" width="940px" class="ld_tb_head"  cellpadding="2">
<tr><td width="75px" align="center">Date</td><td width="160px">Company</td><td width="160px">Name</td><td width="80px" align="center">Qty</td><td width="177px">Item</td><td width="178px" align="center">Status</td><td width="90px" align="center">Need By</td><td width="20px">&nbsp;</td></tr></table>
<div class="<?php echo $cssOpen; ?>" style="width:957px;"><table border="0" cellspacing="0" cellpadding="2" id="leadTable">
<?php
for($i=0;$i<sizeof($dispLead['id']);$i++)
echo "<tr ".$dispLead['sep'][$i]." ".col_bg_leads($dispLead['type'][$i],($i+1),$scheme)." id=pos".$dispLead['id'][$i]." >
<td align=center width=75px style=\"font-size:10px;\">".$dispLead['date'][$i]."</td>
<td width=160px>&nbsp;".$dispLead['company'][$i]."</td>
<td width=160px>&nbsp;".$dispLead['name'][$i]."</td>
<td align=center width=80px>".substr($dispLead['qty'][$i],0,10)."</td>
<td width=177px>&nbsp;".substr($dispLead['item'][$i],0,25)."</td>
<td width=178px>&nbsp;<a class=info href=#>".substr($dispLead['status'][$i],0,25)."<span>".$dispLead['status'][$i]."</span></a></td>
<td align=center width=90px>".substr($dispLead['needby'][$i],0,10)."</td>
<td width=20px align=right><a href=\"#?w=700&v=edit&id=".$dispLead['id'][$i]."&org=open\" rel=\"popup_name\" class=\"poplight\" ><img src=\"../images/edit_icon.gif\"></a></td>
</tr>";
if(!sizeof($dispLead['id']))
echo "<tr id=nolead1><td colspan=\"8\" align=center ><b>No leads to display</b></td></tr>";
?>
</table>
</div>
</div>
<!-- CLOSED AND DEAD LEADS DISPLAY SEGMENT -->
<!-- CLOSED AND DEAD LEADS DISPLAY SEGMENT -->
<!-- CLOSED AND DEAD LEADS DISPLAY SEGMENT -->
<!-- CLOSED AND DEAD LEADS DISPLAY SEGMENT -->
<?php if($DC) { ?>
<div>
	<div>
    <h3>&nbsp;&nbsp;Dead/Closed Leads&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    <?php
 //////////////////////////////////////////////DISPLAYING PAGE NUMBERS FOR DC LEADS//////////////////////////////////////////////////////////

 echo "<select style=\"margin-left:220px;\" onchange=DisplayDCPage(this.value)>";
 for($i=0;$i<$pageDC;$i++)
 {
 	if($i%2 == 0)
		 echo "<option class=option1 ";
	else
		 echo "<option class=option2 ";
 if($_SESSION['leadDCPg'] == $i) echo "selected = selected";
 echo " value=$i>Leads <b>".(($i*200)+1)." - ".(($i*200)+200)."</b></option>";
 }
 echo "</select";
 //////////////////////////////////////////////DISPLAYING PAGE NUMBERS DC OPEN LEADS//////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  
 ?>
    </h3>
		<table  cellspacing="0" width="940px" class="ld_tb_head"  cellpadding="2">
			<tr><td width="75px" align="center">Date</td><td width="160px">Company</td><td width="160px">Name</td><td width="80px" align="center">Qty</td><td width="177px">Item</td><td width="178px" align="center">Status</td><td width="90px" align="center">Need By</td><td width="20px">&nbsp;</td></tr></table>
		<div class="ld_table ld_deadOpen" style=" width:957px;"><table border="0" width="940px;" cellspacing="0"  cellpadding="2" id="leadDCTable">
			<?php
				for($i=0;$i<sizeof($dispDCLead['id']);$i++)
				echo "<tr   ".$dispDCLead['sep'][$i]." ".col_bg_leads($dispDCLead['type'][$i],($i+1),$scheme)." id=pos".$dispDCLead['id'][$i]." >
				<td align=center width=75px style=\"font-size:10px;\">".$dispDCLead['date'][$i]."</td>
				<td width=160px>&nbsp;".$dispDCLead['company'][$i]."</td>
				<td width=160px>&nbsp;".$dispDCLead['name'][$i]."</td>
				<td align=center width=80px>".substr($dispDCLead['qty'][$i],0,10)."</td>
				<td width=177px>&nbsp;".substr($dispDCLead['item'][$i],0,25)."</td>
				<td width=178px><a class=info href=#>".substr($dispDCLead['status'][$i],0,25)."<span>".$dispDCLead['status'][$i]."</span></a></td>
				<td width=90px>".substr($dispDCLead['needby'][$i],0,10)."</td>
				<td width=20px align=right><a href=\"#?w=700&v=edit&id=".$dispDCLead['id'][$i]."&org=dead\" rel=\"popup_name\" class=\"poplight\" ><img src=\"../images/edit_icon.gif\"></a></td>
				</tr>";
				if(!sizeof($dispDCLead['id']))
					echo "<tr id=nolead2><td colspan=\"8\" align=center  ><b>No Leads to display</b></td></tr>";
			?>
        </table>
		</div>
	</div>
</div>
<?php } ?>
<!-- END OF END OF END OF -->
<!-- END OF END OF END OF -->
<!-- END OF END OF END OF -->
<!-- END OF END OF END OF -->
<input type="hidden" value="open" id="org" />
<input type="hidden" value="<?php echo $DC; ?>" id="DC" />
</div><!-- CLOSING OF FENCE, INNER DISPLAY AREA-->
</div>

</div>

<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clear"></div>
</div>

<div id="popup_name" class="popup_block" >
<div style="float:left; padding:5px; -moz-border-radius:7px 7px 7px 7px; border:1px #78E286 solid; background-color: #E1FBDD; "><span style="color:blue;">Reps:</span> <input type="checkbox" name="reps[]" id="ck1" value="1" /> Sean <input type="checkbox"  name="reps[]" id="ck2" value="2" /> Sage <input type="checkbox" id="ck4"  name="reps[]" value="4" /> Nick <input type="checkbox"  id="ck8" name="reps[]" value="8" /> Lisa <input type="checkbox" id="ck12"  name="reps[]" value="12" /> Cris </div>
<div style="float:right;  padding:5px; -moz-border-radius:7px 7px 7px 7px; border:1px #FFBC79 solid; background-color:#FFEFDF; "><span style="color:blue;">Type:</span>  <input type="radio" id="type1" name="type" value="1"  /> Priority <input type="radio" id="type2"  name="type" value="2" checked="checked"  /> Open <input type="radio" id="type4" name="type" value="4" /> Closed <input type="radio" id="type3"  name="type" value="3"  /> Dead</div>

<div class="clear"></div>
<div style="padding:5px; margin-top:10px; border:1px #47A7F5 solid; -moz-border-radius:7px; background-color:#DFEFFF; color:#0D0D0D; font-size:12px; font-family:verdana;">
<table width="700" border="0" cellpadding="2">
  <tr>
    <td>Company:</td>
    <td><input type="text" name="company" name="company" size="25" /></td>
    <td align="center">Name:</td>
    <td><input type="text" name="name" size="25" /></td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td><input type="text" name="phone" size="25" /></td>
    <td align="center">Email:</td>
    <td><input type="text" name="email" size="25" /></td>
  </tr>
  <tr>
    <td>Item:</td>
    <td><input type="text" name="items" size="25" /></td>
    <td >Qty: <input type="text" size="12" name="qty" /></td>
    <td>Need By:
    <input type="text" onblur="__dt(this)" value="" size="7" align="middle" name="needby"  id="f_date1" />&nbsp;<input type="button" value=".." class="date" id="f_btn1">
    
     (or)<br /><input type="text" name="needbyPhrase" style="margin-top:5px;"  size="25"/></td>
    
    </td>
  </tr>
</table>
</div>
<div style="padding:5px; margin-top:10px;  background-color:#FFF; color:#0D0D0D; font-size:12px; font-family:verdana;">
<table width="700px" border="0" cellpadding="2" >
  <tr>
  	<td>Notes:</td>
    <td>Status:</td>
    
  </tr>
  <tr>
  	 
    <td ><textarea name="textarea" rows="9" cols="50" id="notes"  name="notes" cols="25"></textarea></td>
    <td><textarea name="textarea" cols="40" id="status"  rows="2" name="status"></textarea><input type="hidden" name="action" value="add" /><input type="hidden" id=leadID name="leadID" value="0" />
    <br /><br />
    History:<br />

  <div id="historyDisplay" style="width:300px; border:1px gray solid; height:80px; overflow:auto;">&nbsp;</div></td></tr>
 
  </tr>
</table>
</div>

<div style="float:right; margin:10px;"><img src="../images/coolSave.gif"  id="coolSave" class="addLead"  /></div>
</div>
<input type="hidden" id="userID" value="<?php echo $_SESSION['uid']; ?>"  />
<script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() },
          showTime: false
      });
      cal.manageFields("f_btn1", "f_date1", "%m/%d/%y");
      
    //]]></script>
<script type="text/javascript">
$('#loader').html('');
</script>

</body>
</html>