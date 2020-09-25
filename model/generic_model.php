<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php
function getUsers()
{
	$obj = new db();
	$qry = "select * from client_info where client_info.grant like 't' order by user_id";
	$res = $obj->query($qry);
	while($ret[] = $obj->fetch($res)) {}
	array_pop($ret);
	return $ret;
}
function displaySearch()
{
    $obj = new db();
	$qry = "select miscData from misc where miscHead like 'search'";
	$res = $obj->query($qry);
	return $obj->fetch($res);
}
function POTotal()
{
$obj = new db();
$qry = " select af_order_id, sum(ch_poTotal) as poTotal from af_child group by af_order_id order by af_order_id asc ";
$res = $obj->query($qry);
while($data[] = $obj->fetch($res) ) {}
array_pop($data);
return $data;
}
function reverse_tempPO($val)
{
$obj = new db();
$qry = " delete from af_attach where att_ch = $val";
$res = $obj->query($qry);

$qry = "update af_r2 set 
r2_ven_id = '', 
r2_date = '', 
r2_ven_msg = '', 
r2_ship_date = '', 
r2_ship_act = '', 
r2_d1_date = '0000-00-00', 
r2_d1_type = '', 
r2_d1_add = '', 
r2_d2_date = '', 
r2_d2_type = '', 
r2_d2_add = '', 
r2_d3_date = '', 
r2_d3_type = '', 
r2_d3_add = '', 
r2_histid = '', 
r2_datetime = now() where r2_id = ".$val;

$obj->query($qry);

$qry = " delete from af_r2_items where r2_id = $val";
$res = $obj->query($qry);
if($res) $result = 1;
$qry = " update af_child set ch_placed_ck = 'no' where ch_id = $val";
$res = $obj->query($qry);
if($res) $result++;

if($result == 2)
return 'yes';
else
return 'no';
}

function get_PO($attid, $chid)
{
$obj = new db();
$qry = "select * from af_r2 a, af_vendor b where a.r2_id = $chid and b.v_id = a.r2_ven_id";
$res = $obj->query($qry);
$data = $obj->fetch($res);
$qry = "select * from af_r2_items where r2_id = $chid";
$res = $obj->query($qry);
while($dat = $obj->fetch($res) )
{
$data['r2i_id'][]=$dat['r2i_id'];
$data['r2_id_'][]=$dat['r2_id'];
$data['r2i_itemid'][]=$dat['r2i_itemid'];
$data['r2i_desc'][]=$dat['r2i_desc'];
$data['r2i_qty'][]=$dat['r2i_qty'];
$data['r2i_prc'][]=$dat['r2i_prc'];
}

return $data;
}

if($_POST['q'] == 'accessLevel')
{
	$obj = new db();
	echo $qry = "update client_info set accessLevel = '".$_POST['level']."' where user_id = ".$_POST['userID'];
	$res = $obj->query($qry);
	echo $res;
}
?>