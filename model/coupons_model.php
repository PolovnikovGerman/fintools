<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
 <?php

function getCoupons($portal)
{
	$obj = new db();
 $qry = "select * from coupons where coupPortal = '$portal'";
	$res = $obj->query($qry);
	while($data[] = $obj->fetch($res)) {}
	array_pop($data);
	return $data;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////// AJAX  RETURNS //////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['q'] == 'addCoupon')
{

$obj = new db();
 $arr = array();
 
 	$arr[$_POST['type']] = 'selected';
 	$arr[$_POST['vUnit']] = 'selected';
 

 
	if($_POST['action'] == 'save')
	{
		$qry = "insert into coupons values(null,'".$_POST['type']."','".$_POST['code']."','".$_POST['description']."','".$_POST['value']."','".$_POST['vUnit']."','".$_POST['portal']."','no',now(),'".$_POST['status']."')";
	$res = $obj->query($qry);
	$disp="<tr><td><input type=\"checkbox\" checked=\"".$_POST['status']."\" name=\"status\" /></td><td><select name=\"type\"><option value=\"survey\" selected = \"".$arr['survey']."\" >survey</option><option value=\"promo\" selected = \"".$arr['survey']."\" >promo</option></select></td><td><input type=\"text\" name=\"code\" size=\"8\" value=\"".$_POST['code']."\" /></td><td><input type=text name=\"description\"  value=\"".$_POST['description']."\"  size=\"60\"/></td>                    <td><input type=text name=\"value\"  value=".$_POST['value']."  size=\"4\"/></td>
                        <td><select name=\"unit\"><option value=\"percent\"  selected = \"".$arr['percent']."\">%</option><option value=\"dollar\"  selected = \"".$arr['dollar']."\">$</option><option value=\"ship\"  selected = \"".$arr['ship']."\">ship</option></select></td>
                        <td>edit</td><tr>";
		$last_id = mysql_insert_id();
	if($res)
		echo json_encode(array('coupID' => $last_id, 'flag' => true));
	else
		echo false;
  }
  else
  {
  	if($_POST['action'] == 'edit' && $_POST['editID'] > 0 )
	{
		$qry = "update coupons set coupType = '".$_POST['type']."', coupCode = '".$_POST['code']."', coupDesc = '".$_POST['description']."', coupValue = '".$_POST['value']."', coupUnit = '".$_POST['vUnit']."', coupPortal = '".$_POST['portal']."', coupDateTime = now(), coupStatus = '".$_POST['status']."' where coupID = ".$_POST['editID'];
		$res = $obj->query($qry);
		if($res)
		echo json_encode(array('coupID' =>$_POST['editID'], 'flag' => true));
	else
		echo false;
	}
	else
		echo false;
  }

}

if($_POST['q'] == 'getCoupon')
{
	$obj = new db();
	$qry = "select * from coupons where coupID = ".$_POST['cID'];
	echo json_encode($obj->fetch($obj->query($qry)));
}
?>