<?php  include('../controller/report_controller.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/json2.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/client.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ui/jquery-ui-custom.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ui/jquery-ui-1.8.5.custom.js"></script>
<script src="../includes/calendar/js/jscal2.js"></script>
    <script src="../includes/calendar/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../includes/calendar/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../css/jquery.ui.all.css" />
    

<script language="JavaScript" type="text/javascript" src="revenue_ajax_calls.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/menu.js"></script>
<link href="../images/attach_style.css" rel="stylesheet" type="text/css" />
<link href="../images/popUp.css" rel="stylesheet" type="text/css" />

<style>
body{font-size:60%;}

</style>
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<title>BT System - Development </title>
</head>
<body onload="art_hide_modules()"  ><div id="loader"><img src="../images/loader.gif" /></div>
<div id="dialog" title="Notes" style="text-align:right;">
	<textarea cols="71" rows="32" style="border:1px white solid;" id="revNotes"></textarea><br /><input type="button" class="saveRevNotes" id="" value="save" />
</div>
<div id="att_wrap"></div>

<div class="wrap">
<?php include("../includes/header_navigation.php"); ?>
<div class="content">
 <div class="prMenu">
 <ul><li ><a href="reportOrders.php">By Order</a></li><li id="active"><a href="reportByWeek.php">By Date</a></li></ul>
 <div class="clear"></div>
 </div>
<div style="border:1px darkgray solid; height:720px; margin:0px 13px; width:960px; overflow:auto; ">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<div style="margin:20px;">
<b>Select Year : </b>
<select name="year">
    <?php $start_year=date('Y');
 while ($start_year>=2006) {
     echo '<option value="'.$start_year.'">'.$start_year.'</option>';
     $start_year-=1;
 }
    ?>
</select> 
<input type="submit" style="background-color: #006C00; color:white; font-family:verdana; font-weight:bold; border:1px #2D2D2D solid; padding:2px;" value="Get Report" name="getReport" />
</div>
<div style="margin:20px;">

<?php
 //This gets today's date 
 $date =time () ; 
 for($i=1; $i<=date('m',$date);$i++)
 {
 if($i<10) $i="0".$i;
 //This puts the day, month, and year in seperate variables 
 if(isset($_POST['getReport']))
 {
 	$day = '01';
	$month = $i;
	$year = ($_POST['year']=='') ? date('Y',$date) : $_POST['year'];
 }
 else
 {
 	$day = date('d', $date) ;
 	$month = $i;
 	$year = date('Y', $date) ;
}

 //Here we generate the first day of the month 
 $first_day = mktime(0,0,0,$month, 1, $year) ; 
 //This gets us the month name 
 $title = date('F', $first_day) ; 
 //Here we find out what day of the week the first day of the month falls on 
 $day_of_week = date('D', $first_day) ; 

 //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
 switch($day_of_week){ case "Sun": $blank = 0; break; 
 case "Mon": $blank = 1; break; 
 case "Tue": $blank = 2; break; 
 case "Wed": $blank = 3; break; 
 case "Thu": $blank = 4; break; 
 case "Fri": $blank = 5; break; 
 case "Sat": $blank = 6; break; 
 }

 //We then determine how many days are in the current month
 $days_in_month = cal_days_in_month(0, $month, $year) ; 
 //Here we start building the table heads 

 echo "<table class=prWeekTable style=\"background-color:white; border:2px #ababab solid;\">";
 echo "<tr><th colspan=7 style=\"background-color:blue; color:white;\"> $title $year </th></tr>";
 echo "<tr align=center><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td><td style=\"border:2px #2D2D2D solid; color:blue;\">Total</td></tr>";
 //This counts the days in the week, up to 7
 $day_count = 1;
 echo "<tr>";
 //first we take care of those blank days
 while ( $blank > 0 ) 
 { 
 echo "<td></td>"; 
 $blank = $blank-1; 
 $day_count++;
 } 
  //sets the first day of the month to 1 
 $day_num = 1;
 $weekTotal = (float)0.00;
 $weekPercent = (float)0.00;
 $weekCost=(float)0.00;
 $weekNum=0;
 //count up the days, untill we've done all of them in the month
 while ( $day_num <= $days_in_month ) 
 { 
 
 	$day_num = sprintf("%02d", $day_num); 
 
 	$temp = $year."-".$month."-".$day_num;
// 	echo "<td>".$day_num."--".$prDate['profit'][$temp]."</td>"; 
	echo "<td class=\"".$prDate['style'][$temp]."\"><div class=prWeekDate><span class=getRevNotes id=note".$temp.">".$day_num."</span></div>";
	if($prDate['profit'][$temp] != '')
	{
	if($prDate['profit'][$temp] > 0)
		echo "<div class=prNumOrders>".$prDate['num'][$temp]." = $".number_format($prDate['cost'][$temp],2)."</div><div class=prWeekProfit>$".number_format($prDate['profit'][$temp],2)."</div><div class=prWeekPercent>".$prDate['percent'][$temp]."%</div></td>";
	else
		echo "<div class=prNumOrders>".$prDate['num'][$temp]." = $".number_format($prDate['cost'][$temp],2)."</div><div class=prWeekProfitRed>$".number_format($prDate['profit'][$temp],2)."</div><div class=prWeekPercent>".$prDate['percent'][$temp]."%</div></td>";
		
	$weekTotal+=(float)$prDate['profit'][$temp];
	$weekCost+=(float)$prDate['cost'][$temp];
	$weekNum+=$prDate['num'][$temp];
	}
	else
	echo "<div class=prNumOrders> </div><div class=prWeekProfit> </div><div class=prWeekPercent> </div></td>";
 	$day_num++; 
	$day_count++;
	
	 //Make sure we start a new row every week
			if ($day_count > 7)
			{
				 if($weekCost > 0)
				 $weekPercent = round(((float)$weekTotal/(float)$weekCost) * 100);
				 if($weekTotal >= 0)
				 echo "<td style=\"border:2px #2D2D2D solid;\"><div class=prNumOrders>".$weekNum." = $".number_format($weekCost,2)."</div><div class=prWeekProfit>$".number_format($weekTotal,2)."</div><div class=prWeekPercent>".$weekPercent."%</div></td></tr><tr>";
				 else
				 echo "<td style=\"border:2px #2D2D2D solid;\"><div class=prNumOrders>".$weekNum." = $".number_format($weekCost,2)."</div><div class=prWeekProfitRed>$".number_format($weekTotal,2)."</div><div class=prWeekPercent>".$weekPercent."%</div></td></tr><tr>";
				 $day_count = 1;
				 $weekTotal=0;
				 $weekCost=0;
				 $weekNum=0;
				 $weekPercent=0;
			 }

 } 
//Finaly we finish out the table with some blank details if needed
 while ( $day_count >1 && $day_count <=7 ) 
 { 
	 echo "<td> </td>"; 
	 $day_count++; 
 } 
 echo "</tr></table><br><br>"; 

 
 }//end of for
?>


<?php /*
 //This gets today's date 
 $date =time () ; 
 //This puts the day, month, and year in seperate variables 
 if(isset($_POST['getReport']))
 {
 	$day = '01';
	$month = ($_POST['month']=='') ? date('m',$date) : sprintf('%02d',$_POST['month']);
	$year = ($_POST['year']=='') ? date('Y',$date) : $_POST['year'];
 }
 else
 {
 	$day = date('d', $date) ;
 	$month = date('m', $date) ;
 	$year = date('Y', $date) ;
}

 //Here we generate the first day of the month 
 $first_day = mktime(0,0,0,$month, 1, $year) ; 
 //This gets us the month name 
 $title = date('F', $first_day) ; 
 //Here we find out what day of the week the first day of the month falls on 
 $day_of_week = date('D', $first_day) ; 

 //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
 switch($day_of_week){ case "Sun": $blank = 0; break; 
 case "Mon": $blank = 1; break; 
 case "Tue": $blank = 2; break; 
 case "Wed": $blank = 3; break; 
 case "Thu": $blank = 4; break; 
 case "Fri": $blank = 5; break; 
 case "Sat": $blank = 6; break; 
 }

 //We then determine how many days are in the current month
 $days_in_month = cal_days_in_month(0, $month, $year) ; 
 //Here we start building the table heads 

 echo "<table class=prWeekTable>";
 echo "<tr><th colspan=7> $title $year </th></tr>";
 echo "<tr align=center><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td><td style=\"border:2px #2D2D2D solid; color:blue;\">Total</td></tr>";
 //This counts the days in the week, up to 7
 $day_count = 1;
 echo "<tr>";
 //first we take care of those blank days
 while ( $blank > 0 ) 
 { 
 echo "<td></td>"; 
 $blank = $blank-1; 
 $day_count++;
 } 
  //sets the first day of the month to 1 
 $day_num = 1;
 $weekTotal = (float)0.00;
 $weekPercent = (float)0.00;
 $weekCost=(float)0.00;
 $weekNum=0;
 //count up the days, untill we've done all of them in the month
 while ( $day_num <= $days_in_month ) 
 { 
 
 	$day_num = sprintf("%02d", $day_num); 
 
 	$temp = $year."-".$month."-".$day_num;
// 	echo "<td>".$day_num."--".$prDate['profit'][$temp]."</td>"; 
	echo "<td class=\"".$prDate['style'][$temp]."\"><div class=prWeekDate><span class=getRevNotes id=note".$temp.">".$day_num."</span></div>";
	if($prDate['profit'][$temp] != '')
	{
	if($prDate['profit'][$temp] > 0)
		echo "<div class=prNumOrders>".$prDate['num'][$temp]." = $".number_format($prDate['cost'][$temp],2)."</div><div class=prWeekProfit>$".number_format($prDate['profit'][$temp],2)."</div><div class=prWeekPercent>".$prDate['percent'][$temp]."%</div></td>";
	else
		echo "<div class=prNumOrders>".$prDate['num'][$temp]." = $".number_format($prDate['cost'][$temp],2)."</div><div class=prWeekProfitRed>$".number_format($prDate['profit'][$temp],2)."</div><div class=prWeekPercent>".$prDate['percent'][$temp]."%</div></td>";
		
	$weekTotal+=(float)$prDate['profit'][$temp];
	$weekCost+=(float)$prDate['cost'][$temp];
	$weekNum+=$prDate['num'][$temp];
	}
	else
	echo "<div class=prNumOrders> </div><div class=prWeekProfit> </div><div class=prWeekPercent> </div></td>";
 	$day_num++; 
	$day_count++;
	
	 //Make sure we start a new row every week
			if ($day_count > 7)
			{
				 if($weekCost > 0)
				 $weekPercent = round(((float)$weekTotal/(float)$weekCost) * 100);
				 if($weekTotal >= 0)
				 echo "<td style=\"border:2px #2D2D2D solid;\"><div class=prNumOrders>".$weekNum." = $".number_format($weekCost,2)."</div><div class=prWeekProfit>$".number_format($weekTotal,2)."</div><div class=prWeekPercent>".$weekPercent."%</div></td></tr><tr>";
				 else
				 echo "<td style=\"border:2px #2D2D2D solid;\"><div class=prNumOrders>".$weekNum." = $".number_format($weekCost,2)."</div><div class=prWeekProfitRed>$".number_format($weekTotal,2)."</div><div class=prWeekPercent>".$weekPercent."%</div></td></tr><tr>";
				 $day_count = 1;
				 $weekTotal=0;
				 $weekCost=0;
				 $weekNum=0;
				 $weekPercent=0;
			 }

 } 
//Finaly we finish out the table with some blank details if needed
 while ( $day_count >1 && $day_count <=7 ) 
 { 
	 echo "<td> </td>"; 
	 $day_count++; 
 } 
 echo "</tr></table>"; 

 */
 
?>
</div>
</div>

</div>

<div class="clear"></div>
</div>

<script type="text/javascript">
$('#loader').html('');
</script>
</body>
</html>