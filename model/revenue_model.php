<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
 <?php
$obj = new db();

function getRevenueOrders()
{
if(!isset($_SESSION['rev']))
$revLimit = 22000;
else
$revLimit = $_SESSION['rev'];
$obj = new db();
$ret=array();
$qry = "select a.af_order_id, a.af_date, a.af_cust, b.revID, b.revAmt, b.revShip, b.revTax from af_master a, af_revenue b where a.af_order_id = b.orderID and a.af_order_id >= $revLimit and a.af_order_id <= ".($revLimit + 1000);
$res = $obj->query($qry);
while( $data = $obj->fetch($res))
{
$ret['af_date'][] = $data['af_date'];
$ret['af_order_id'][] = $data['af_order_id'];
$ret['af_cust'][] = $data['af_cust'];
$ret['revID'][] = $data['revID'];
$ret['revAmt'][] = $data['revAmt'];
$ret['revShip'][] = $data['revShip'];
$ret['revTax'][] = $data['revTax'];
}

$qry = "select af_order_id, sum(ch_poTotal) as poTotal from af_child group by af_order_id";
$res = $obj->query($qry);
while( $data2 = $obj->fetch($res) )
{
	$ret[$data2['af_order_id']]['poTotal'] = $data2['poTotal'];
}
return $ret;
}
?>