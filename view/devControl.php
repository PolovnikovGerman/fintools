<?php include('../controller/dev_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('../includes/headerFiles.php'); ?>
	<script language="JavaScript" type="text/javascript" src="../js/ajaxCalls_PTM.js"></script>
	<link href="../css/stylePTM.css" rel="stylesheet" type="text/css" /> 
	<style>
		body{font-size:60%;}
		
	</style>
<style>
	
	.prSortable { margin: 2px 4px; border:1px gray dotted; padding: 3px 5px; float: left; cursor:pointer; width:160px;  height: 15px; font-size: 12px; text-align: center; }
	</style>
	<script>
	$(function() {
		
	});
	</script>
	<title>BT System - PTN </title>
</head>

<body><div id="loader"><img src="../images/loader.gif" /></div>

<div id="dialog" title="Notes" style="text-align:right;">
	<textarea cols="71" rows="32" style="border:1px white solid;" id="putNotes"></textarea><br /><input type="button" class="saveTaskNotes" id="" value="save" />
</div>

<div style="position:absolute; top:0; left:45%; z-index:1000;"><iframe name="uploadAttach" src="uploadAttach.php" frameborder="0" marginwidth="0" marginheight="0"  height="19" width="175"></iframe></div>
<div id="att_wrap"></div>
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:5px 10px 0px 20px;"><b>Project Task Notes</b><B><div style="float:right;"><a href="#?w=600&v=new&id=0&org=0" rel="popup_name" class="poplight" style="-moz-border-radius:4px; color:blue; border:1px #C0C0C0 solid; background-color:white; padding:2px 5px;" >add new</a></B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked" id="hideClosed" name="hideClosed" />&nbsp;Hide Closed Projects&nbsp;&nbsp;</div></div>
<input type="hidden" id="loggedIn" value="<?php echo $_SESSION['uid']; ?>" >
<input type="hidden" id="sessUser" value="<?php echo $_SESSION['uid']; ?>" >
 <?php if($_SESSION['uid'] == 1 || $_SESSION['uid'] ==2) { ?>
 <div class="tabMenu"><ul><li id="user1">Sean</li><li id="user2">Sage</li><li id="user9">Lucky</li><li id="user4">Nick</li><li id="user11">Randy</li><li id="user12">Cris</li><li id="user10">Taisen</li></ul></div>
 <?php } ?>
 <div style="width:1180px; margin:auto; border:1px #282828 solid; height:740px; ">
<div style="margin:10px 0px 0px 10px; max-height:720px;  float:left; width:185px;  overflow:auto;" class="devProjects" id="projectGrid">

</div>
<div style="float:right; width:980px; margin-top:10px; ">
<div>
<div class="projName hide">&nbsp;&nbsp;<b><span id="projName" style="cursor:pointer;" ></span><span id="attachDocs"></span></b> </div>
<div class="projVars hide" ><span class="viewCompleted"></span><span class="projectClosed"></span></div>
<div class="clear"></div>
</div>


<!-- PANEL FRAME TEMPLATE - Tasks-->
<div style="border:1px #C1C1C1 solid; background-color: #F4F4F4; margin:0px 10px;  overflow:auto;">
	<?php if($_SESSION['uid'] == 1 || $_SESSION['uid'] == 2) {?>
    <div class=adminOptions>
    <ul>
    <li><input type="checkbox"  class="empAll"   />&nbsp;<b>All</b></li>
    <li <?php if($_SESSION['uid'] == 1) echo "style=\"background-color:blue; color:white;\""; ?>><input type="checkbox" id="chk1" class="emp" <?php if($_SESSION['uid'] == 1) echo 'checked=checked';  ?> value="1" />&nbsp;Sean<li>
    <li  <?php if($_SESSION['uid'] == 2) echo "style=\"background-color:blue; color:white;\""; ?>><input type="checkbox" id="chk2" class="emp" <?php if($_SESSION['uid'] == 2) echo 'checked=checked'; ?> value="2"/>&nbsp;Sage</li>
    <li><input type="checkbox" class="emp" value="9" />&nbsp;Lucky</li>
    <li><input type="checkbox" class="emp" value="4" />&nbsp;Nick</li>
    <li><input type="checkbox" class="emp" value="10" />&nbsp;Taisen</li>
    <li><input type="checkbox" class="emp" value="11" />&nbsp;Randy</li>
    <li><input type="checkbox" class="emp" value="12" />&nbsp;Cris</li>
    <li><input type="checkbox" class="emp" value="88" />&nbsp;<b>Shared</b></li>
    </ul>
    </div>
    <?php } ?>
<div style="  padding:3px 5px;">
<div style="float:left; margin-top:10px;">
 <div style="float:left; margin-bottom:10px; ">&nbsp;<input name="head"  type="checkbox"   /></div><textarea style="border:1px #ABABAB solid;"  cols="93" rows="1" id="taskText" /></textarea>&nbsp;<div style=" float:right; margin-top:2px;"><input type="button"  value="Add" class="addTask hide button" /></div></div><div style="float:left; margin:10px 5px;"><textarea style="border:1px #ABABAB solid;"  cols="30" rows="1" id="taskNotes" /></textarea></div>
<div class="clear"></div>
</div>

<div class="taskArea"></div>

</div>
<!-- -->

<!-- CLOSING OF TEXT AND CONTENT BLUE BOX -->
</div>
</div>
<!-- CLOSE OF CONTENT -->
</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
<!-- CLOSE OF WRAP -->
</div>
<div id="popup_name" class="popup_block" >

<div style="padding:5px; margin-top:10px; border:1px #47A7F5 solid; -moz-border-radius:7px; background-color:#DFEFFF; color:#0D0D0D; font-size:12px; font-family:verdana;">
<table width="100%" border="0" cellpadding="2">
  <tr>
    <td>Name:</td>
    <td><input type="text" name="name"  size="25" /></td>
    <td >Start Date:</td>
    <td><input type="text" value="<?php echo date('m/d/y'); ?>" name="start" id="datepicker" onblur="__dt(this)" size="10"/></td>
  </tr>
<tr>
  	<td colspan="2">Description:</td>
    <td colspan="2">Notes:</td>
  </tr>
  <tr>
    <td colspan="2" ><textarea name="desc" id="desc" rows="5" cols="31"></textarea></td>
    <td colspan="2">
                    <textarea name="notes" id="notes" cols="32" rows="5"></textarea>
                    <input type="hidden" id="action" name="action" value="add" />
                    <input type="hidden" id=projID name="projID" value="0" />
    </td>
  </tr>
   
</table>
</div>

<div style="float:right; margin:10px;"><img src="../images/coolSave.gif"  id="coolSave" class="addProj"  /></div>
</div>

<script type="text/javascript">
$('#loader').html('');
</script>
</body>
</html>