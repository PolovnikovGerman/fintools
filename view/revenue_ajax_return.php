<?php
include_once('../controller/revenue_controller.php');
include_once ('../model/mysql.php');

$obj = new db();

if($_POST['q'] == 'addRevenue')
{
if($_POST['revAmt'] == '') $_POST['revAmt'] = 0.0;
if($_POST['revShip'] == '') $_POST['revShip'] = 0.0;
if($_POST['revTax'] == '') $_POST['revTax'] = 0.0;

if($_POST['poStatus'] && $_POST['poVal'] > 0 && $_POST['orderID'] > 19999)
{
$qry = "update af_child set ch_poTotal = ".$_POST['poVal']." where af_order_id = ".$_POST['orderID']." and ch_po = 'A' ";
$obj->query($qry);
}

	 $qry = "update af_revenue set revAmt = ".$_POST['revAmt'].", revShip = ".$_POST['revShip'].", revTax = ".$_POST['revTax'].", revDateTime = now() where revID = ".$_POST['revID'];
	if($obj->query($qry))
	$retArr = array('error' => false, 'revAmt' => $_POST['revAmt'], 'revShip' => $_POST['revShip'], 'revTax' => $_POST['revTax']);
	else
	$retArr = array('error' => true);
echo json_encode($retArr);
}

if($_POST['q'] == 'getRevNotes')
{
	 $qry = "select notesText from af_revenue_notes where notesDate = '".$_POST['notesDate']."'";
	$res = $obj->query($qry);
	echo json_encode($obj->fetch($res));
}

if($_POST['q'] == 'saveRevNotes')
{
	$qry = "delete from af_revenue_notes where notesDate = '".$_POST['notesDate']."'";
	$obj->query($qry);
	
	$qry = "insert into af_revenue_notes values(null,'".$_POST['notesDate']."','".$_POST['revNotes']."')";
	$res = $obj->query($qry);
	if(!res)
		echo false;
	else
		echo true;
}
?>