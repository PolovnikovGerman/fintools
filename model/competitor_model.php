<?php  include_once('mysql_module.php');
		include_once('../controller/generic_functions.php'); ?>
 
 <?php

function getReport()
{
$ob = new db_module();

$qry = "select * from bt_items a, bt_pricing b where a.sbID = b.sbID order by a.sbID";
$res = $ob->query($qry);
while($data = $ob->fetch($res) )
{
	$id = $data['sbID'];
	$type = $data['sbType'];
	$ref[]=$data['sbID'];
	$arr[$id]['itemID'][] = $data['itemID'];
	$arr[$id]['itemName'][] = $data['itemName'];
	$arr[$id]['sbP1'][$type] = $data['sbP1'];
	$arr[$id]['sbP2'][$type] = $data['sbP2'];
	$arr[$id]['sbP3'][$type] = $data['sbP3'];
	$arr[$id]['sbP4'][$type] = $data['sbP4'];
	$arr[$id]['sbP5'][$type] = $data['sbP5'];
	$arr[$id]['sbP6'][$type] = $data['sbP6'];
	$arr[$id]['sbP7'][$type] = $data['sbP7'];
	$arr[$id]['sbP8'][$type] = $data['sbP8'];
	$arr[$id]['sbP9'][$type] = $data['sbP9'];
	$arr[$id]['sbP10'][$type] = $data['sbP10'];
	$arr[$id]['sbP11'][$type] = $data['sbP11'];
	$arr[$id]['sbP12'][$type] = $data['sbP12'];
	$arr[$id]['sbPriceName'][$type] = $data['sbPriceName'];
}
/*
array_unique($ref);
echo "<pre>";
print_r(array_unique($ref));
echo "</pre>";
echo "<pre>";
print_r($arr);
echo "</pre>";
*/

$ids = array_unique($ref);
$disp=array();
foreach($ids as $key => $value)
{

	for($j =1; $j < 13; $j++)
	{
	
		
		if( $arr[$value]['sbP'.$j]['price'] > $arr[$value]['sbP'.$j]['cmp1'] && $arr[$value]['sbP'.$j]['cmp1']!= 0 )
		{
			$disp['itemID'][]=$arr[$value]['itemID'][1];
			$disp['itemName'][]=$arr[$value]['itemName'][1];
		}
			
		if( $arr[$value]['sbP'.$j]['price'] > $arr[$value]['sbP'.$j]['cmp2'] && $arr[$value]['sbP'.$j]['cmp2']!= 0 )
		{
			$disp['itemID'][]=$arr[$value]['itemID'][1];
			$disp['itemName'][]=$arr[$value]['itemName'][1];
		}
			
		if( $arr[$value]['sbP'.$j]['price'] > $arr[$value]['sbP'.$j]['cmp3'] && $arr[$value]['sbP'.$j]['cmp3']!= 0 )
		{
			$disp['itemID'][]=$arr[$value]['itemID'][1];
			$disp['itemName'][]=$arr[$value]['itemName'][1];
		}
		
	}
}



return $disp;
}
?>