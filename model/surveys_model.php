<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php

function getSurvey($table)
{
	$obj = new db();
	$qry = "select * from $table order by sur_datetime desc";
	$res = $obj->query($qry);
	while($ret[] = $obj->fetch($res) ){}
	array_pop($ret);
	return $ret;
}

if($_POST['q'] == 'showSurvey')
{
	$obj = new db();
	$qry = "select * from ".$_POST['org']." where surID = ".$_POST['id'];
	$res = $obj->query($qry);
	$qry = "update ".$_POST['org']." set status = 'old'  where surID = ".$_POST['id'];
	$obj->query($qry);
	echo json_encode($obj->fetch($res));

}
?>