<?php include('../controller/surveys_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('../includes/headerFiles.php'); ?>

<script language="JavaScript" type="text/javascript" src="../js/ajaxCalls_Surveys.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/popUp.js"></script>

<link rel="stylesheet" type="text/css" href="../images/popUp.css" />
<title>BT System - Marketing </title>
</head>
<body onload="art_hide_modules()"  >
<div id="att_wrap"></div>
<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>

 <div class="content">
 <div style="margin:10px 10px 5px 20px; float:left;"><b>Surveys</b> <a  href="#?w=455&v=add&id=0&org=null" rel="popup5" class="poplight flt_left">click here</a></div>
 <div class="cssTabs"><ul><li class="cssTabs_active">Buttons</li><li>SB.com</li></ul></div>
 <div style="width:1180px; margin:auto; border:1px #818181 solid; overflow:auto; clear:both; height:740px; ">
 
 <?php
 $temp = 1;
 $style['old'] = "style=\"color:darkgray;\"";
 $style['new'] = '';
 if(sizeof($survey) > 2000)
 {
 	echo $temp= sizeof($survey)/2000;
	$temp++;
 }
 $date = '';
 $i = 0;
 for($j = 0; $j < $temp; $j++)
 {
 
 echo "<div style=\"width:100px; text-align=center; padding:2px; height:700px; float:left; overflow:auto; margin:20px; background-color:#fefefe; border:1px #818181 solid;\">";
 echo "<table  width=100% cellspacing=0 cellpadding=3px>";
 	while($survey[$i]['surID'] != '' && $i < 2000)
	{
	$index = $i + ($j*2000);
	if($date == substr($survey[$index]['sur_datetime'],0,10))
		echo "<tr class=hilite><td align=center><a  href=\"#?w=455&v=edit&id=".$survey[$index]['surID']."&org=button_survey\" rel=\"popup5\" class=\"poplight flt_left\" ".$style[$survey[$index]['status']].">view</a></td></tr>";
	else
	{
		echo "<tr><td>".print_date(substr($survey[$index]['sur_datetime'],0,10))."</td></tr>";
		echo "<tr class=hilite ><td align=center><a  href=\"#?w=455&v=edit&id=".$survey[$index]['surID']."&org=button_survey\" rel=\"popup5\" class=\"poplight flt_left\" ".$style[$survey[$index]['status']].">view</a></td></tr>";
		$date = substr($survey[$index]['sur_datetime'],0,10);
	}
	$i++;
	
	} 
echo "</table>";
echo "</div>";
}	
 
 ?>
 
 
 
 
 </div>


</div>
<div class="footer"> COPYRIGHT &copy; Bluetrack Inc &nbsp;2001-<?php echo date("Y"); ?>. All Rights Reserved</div>
<div class="clearfix"></div>
</div>


<div id="popup5" class="popup_block">
	<div id="pop_up_survey_left"></div>
    <div id="pop_up_survey_center">
    		
            	<ul style="list-style:none;">
                	<li> 1. Why did you choose to visit our site?</li>
                    <li><textarea class="txt" cols="55" readonly="readonly" name="ans1" ></textarea></li>
                    <li>2. What are you looking for when buying buttons?</li>
                    <li><textarea class="txt" cols="55" readonly="readonly" name="ans2" ></textarea></li>
                    <li>3. What do you like about our site?</li>
                    <li><textarea class="txt" cols="55" readonly="readonly"  name="ans3"></textarea></li>
                    <li>4. What would you improve about our site?</li>
                    <li><textarea class="txt" cols="55" readonly="readonly" name="ans4" ></textarea></li>
                    
                </ul>

           
    		
    </div>
    <div id="pop_up_survey_right"></div>
    
</div>
</body>
</html>