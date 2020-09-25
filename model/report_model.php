<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
 <?php


function getProfitByOrder()
{
$obj = new db();

if(!isset($_SESSION['prOrdNum']))
$ordStart = 22000;
else
$ordStart = $_SESSION['prOrdNum'];


//getting order_id sum of PO's cust name desc and date
$qry = "
select 
    b.af_order_id,
    sum(ch_poTotal) as poTotal, 
    a.af_cust, 
    a.af_desc, 
    a.af_date, 
    c.revAmt,
    c.revShip

from 
    af_master a, 
    af_child b, 
   af_revenue c 

where 
     a.af_order_id = b.af_order_id 
 and 
     b.af_order_id = c.orderID 
 and
     a.af_order_id >= $ordStart 
 and 
    a.af_order_id <= ".($ordStart + 1000)."

group by af_order_id";

$res = $obj->query($qry);

while($data = $obj->fetch($res))
{
$retData['date'][] = $data['af_date'];
$retData['orderID'][] = $data['af_order_id'];
$retData['cust'][] = $data['af_cust'];
$retData['desc'][] = $data['af_desc'];
$retData['poTotal'][] = ($data['poTotal'] == 0  ) ? '-' : $data['poTotal'];
$retData['revAmt'][]=($data['revAmt'] == 0  ) ? '-' : $data['revAmt'];
$retData['revShip'][]=($data['revShip'] == 0  ) ? '-' : $data['revShip'];
$retData['revTax'][] = ($data['revTax'] == 0 || $data['revTax'] == '' ) ? '-' : $data['revTax'];

$profit = ($data['revAmt'] - ($data['poTotal'] + $data['revShip'] + $data['revTax']));

if($profit != 0 && $profit != '')
$retData['revProfit'][] = '$'.number_format($profit,2);
else
$retData['revProfit'][] = '-';

if($profit >= 0)
$retData['revProfitClass'][] = 'prBlue';
else
$retData['revProfitClass'][] = 'prRed';

if($data['poTotal'] == 0 || $data['revShip'] == 0 || $data['revAmt'] == 0)
$retData['prBg'][] = 'prBgYellow';
else
$retData['prBg'][] = '';
if($data['revAmt'] != 0 && $data['revAmt'] != '')
$retData['revPercent'][] = number_format(($profit/$data['revAmt']) * 100 ,2);
else
$retData['revPercent'][] = '-';

}
return $retData;
}


function getProfitByDate()
{

$obj = new db();
//$qry = "GRANT ALL ON *.* TO 'bluetrac_u253909'@'localhost'"; 
//$obj->query($qry);
$retData= array();
$qry = " create view profitFeed as
select 
    b.af_order_id,
    sum(ch_poTotal) as poTotal, 
    a.af_cust, 
    a.af_desc, 
    a.af_date, 
    c.revAmt as revAmt,
    c.revShip as revShip,
	c.revTax as revTax

from 
    af_master a, 
    af_child b, 
   af_revenue c 

where 
     a.af_order_id = b.af_order_id 
 and 
     b.af_order_id = c.orderID 
 and 
 	a.af_date != '0000-00-00'
	
group by a.af_order_id

order by a.af_date desc ";

$res = $obj->query($qry);

$qry = "select af_date from profitFeed where poTotal = 0 or revAmt = 0";
$res = $obj->query($qry);
while($data2 = $obj->fetch($res))
{
if( $data2['poTotal'] == 0 ||  $data2['revAmt'] == 0 )
$retData['style'][$data2['af_date']] = 'yellow'; 
}

$qry = "SELECT  sum(poTotal) as poTotal, sum(revAmt) as revAmt , count(af_date) as numOrders, sum(revShip) as revShip, sum(revTax) as revTax,  af_date FROM `profitFeed` group by af_date order by af_date desc";
$res = $obj->query($qry);
while($data = $obj->fetch($res))
{
 

 $profit =(float)$data['revAmt'] - ((float)$data['poTotal'] + (float)$data['revShip'] + (float)$data['revTax']);
 $temp = $data['af_date'];
 $retData['profit'][$temp] = $profit;
 if($data['revAmt'] > 0)
 $retData['percent'][$temp] = round(($profit/$data['revAmt']) * 100);
 else
 $retData['percent'][$temp] = 0;
 
 $retData['cost'][$temp] = (float)$data['revAmt'];
 $retData['num'][$temp] = $data['numOrders']; 
}

$qry = "drop view profitFeed";
$obj->query($qry);

return $retData;
}

?>