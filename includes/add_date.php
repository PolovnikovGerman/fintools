<?php
//adding days
echo $tomorrow = mktime(0,0,0,01,01-1,2011);
echo "Tomorrow is ".date("m-d-Y", $tomorrow);
echo "<br>"; echo strftime("%#d",$tomorrow);
echo date("l", mktime(0,0,0,date('m',$tomorrow),date('d',$tomorrow),date('Y',$tomorrow) ));
echo "<br><br><br><br>";
$paramDate = '11-23-2009';
$dateArr = explode('-',$paramDate);
echo "<pre>";
print_r($dateArr);
echo "</pre>";
echo "<br><br><br><br>"; echo date('m-d-Y');
$paramDate='4-14-2011';
$dateArr = explode('-',$paramDate);
$tomorrow = mktime(0,0,0,$dateArr[0],$dateArr[1],$dateArr[2]);
echo $day = date("l", mktime(0,0,0,date('m',$tomorrow),date('d',$tomorrow),date('Y',$tomorrow) ));

?>