<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php

function getQuotes()
{
	$obj = new db();
	$qry = "select a.but_QID, a.but_Qdate,  a.but_Qqty, a.but_Qemail,a.but_Qstate, a.but_Qvia, a.but_Qtotal, b.but_name from button_quote a, button_items b where a.but_Qshape = b.butID order by but_QID desc";
	$res = $obj->query($qry);
	while($ret[] = $obj->fetch($res) ){}
	array_pop($ret);
	return $ret;
}

?>