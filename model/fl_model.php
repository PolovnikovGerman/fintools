<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>

<?php
function get_art($val)
{
$obj = new db(); $key=array();
$qry = "select * from af_master where af_order_id >= $val and af_order_id <=".($val+500)." order by af_order_id ";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$key['af_order_id'][]=$data['af_order_id'];

$key['af_cust'][]=$data['af_cust'];
$key['af_desc'][]=$data['af_desc'];
$key['af_appr_ck'][]=$data['af_appr_ck'];
$key['af_datetime'][]=$data['af_datetime'];

}

return $key;
}

function add_vendor()
{
$obj = new db();
$qry="insert into af_vendor values(null,'".$_POST['v_name']."','".substr($_POST['v_abbr'],0,7)."','".$_POST['v_email']."','".generatePassword()."','".$_POST['v_type']."','".$_POST['v_address']."','".$_POST['v_memos']."','".$_POST['v_phone']."',now() )";
if($obj->query($qry))
return true;
else
return false;
}
function add_item()
{
$obj = new db();
if($_POST['i_price'] == '') $_POST['i_price'] = 0.00;
$qry="insert into af_items values(null,'".$_POST['i_itemid']."','".$_POST['i_desc']."',".$_POST['i_price'].",'".$_POST['i_ven']."','".$_POST['i_notes']."' )";
if($obj->query($qry))
return true;
else
return false;
}

function get_child()
{
	if (isset($_SESSION['or']) && is_numeric($_SESSION['or']))
		$value = $_SESSION['or'];
	else
		$value = 22000;
	$obj = new db();
	$key = array();
	$temp = 0;
	if (isset($_SESSION['whr']) && !empty($_SESSION['whr'])) {
		if ($_SESSION['whr'] == 'ch_issue_ck') $st = 'yes'; else $st = 'no';
		if ($_SESSION['whr'] == 'ch_conf_ck')
			$qry = "select af_order_id from af_child where af_order_id >= $value and af_order_id <=" . ($value + 500) . " and " . $_SESSION['whr'] . " = '$st' and ch_active = 'on' and ch_placed_ck = 'yes'  order by af_order_id";
		else if ($_SESSION['whr'] == 'ch_ship_ck')
			$qry = "select af_order_id from af_child where af_order_id >= $value and af_order_id <=" . ($value + 500) . " and " . $_SESSION['whr'] . " = '$st' and ch_active = 'on' and ch_conf_ck = 'yes'  order by af_order_id";
		else if ($_SESSION['whr'] == 'ch_placed_ck')
			$qry = "select af_order_id from af_child where af_order_id >= $value and af_order_id <=" . ($value + 500) . " and " . $_SESSION['whr'] . " = '$st'  and ch_active = 'on'  order by af_order_id";
		else if ($_SESSION['whr'] == 'ch_cust_ck')
			$qry = "select af_order_id from af_child where af_order_id >= $value and af_order_id <=" . ($value + 500) . " and " . $_SESSION['whr'] . " = '$st' and ch_ship_ck = 'yes' and ch_active = 'on'  order by af_order_id";
		else
			$qry = "select af_order_id from af_child where af_order_id >= $value and af_order_id <=" . ($value + 500) . " and " . $_SESSION['whr'] . " = '$st' and ch_active = 'on'  order by af_order_id";

		$res = $obj->query($qry);
		$num = 0;
		$num = $obj->numrow($res);
		while ($ddd = $obj->fetch($res)) {
			$d[] = $ddd['af_order_id'];
		}
		if ($num > 0)
			$m = implode(",", array_unique($d));
		$temp = 0;
		if ($_SESSION['whr'] == 'ch_placed_ck')
			$qry = "select * from af_child a, af_master b   where a.af_order_id = b.af_order_id and a.ch_active = 'on' and a.af_order_id >= $value and a.af_order_id <=" . ($value + 500) . " and af_appr_ck = 'yes' and a.af_order_id IN (" . $m . ") order by a.af_order_id " . $_SESSION['sort'];
		else
			$qry = "select * from af_child a, af_master b   where a.af_order_id = b.af_order_id and a.ch_active = 'on' and a.af_order_id >= $value and a.af_order_id <=" . ($value + 500) . " and a.af_order_id IN (" . $m . ") order by a.af_order_id " . $_SESSION['sort'];

	} else {
		$qry = "select * from af_child a, af_master b   where a.af_order_id = b.af_order_id and a.ch_active = 'on' and a.af_order_id >= $value and a.af_order_id <=" . ($value + 500) . "  order by a.af_order_id " . $_SESSION['sort'] . " , a.ch_po";
		$num = 1;
	}
	var_dump($num);
	$key_c = [];
	if ($num > 0) {

		$res = $obj->query($qry);
		while ($data = $obj->fetch($res)) {


			$val = $data['af_order_id'];
			if ($temp != $val) {
				$key_c['1']['1'][] = $val;
				$temp = $val;
			}
			$key_c[$val]['af_cust'][] = $data['af_cust'];
			$key_c[$val]['af_desc'][] = $data['af_desc'];
			$key_c[$val]['af_appr_ck'][] = $data['af_appr_ck'];
			$key_c[$val]['clr_appr'][] = ($data['af_appr_ck'] == 'yes') ? '#59b75b' : '';
			$key_c[$val]['af_datetime'][] = $data['af_datetime'];

			$val = $data['af_order_id'];
			$key_c[$val]['ch_id'][] = $data['ch_id'];
			$key_c[$val]['ch_ship_date'][] = ($data['ch_ship_date'] == '2090-12-30' || $data['ch_ship_date'] == '0000-00-00') ? '' : $data['ch_ship_date'];
			$key_c[$val]['ch_ship'][] = (($data['ch_ship_date'] != '2090-12-30' && $data['ch_ship_date'] != '0000-00-00' && $data['ch_ship_date'] != '') || $data['ch_placed_ck'] == 'yes') ? '#ff2a00' : '';
			$key_c[$val]['af_order_id'][] = $data['af_order_id'];
			$key_c[$val]['ch_po'][] = $data['ch_po'];
			$key_c[$val]['ch_vendor'][] = $data['ch_vendor'];
			$key_c[$val]['clr_ven'][] = ($data['ch_vendor'] != '' || $data['ch_placed_ck'] == 'yes') ? '#ff2a00' : '';
			$key_c[$val]['ch_placed_ck'][] = $data['ch_placed_ck'];
			$key_c[$val]['clr_pl'][] = ($data['ch_placed_ck'] == 'yes') ? '#ff2a00' : '';
			$key_c[$val]['ch_conf_ck'][] = $data['ch_conf_ck'];
			$key_c[$val]['clr_conf'][] = ($data['ch_conf_ck'] == 'yes') ? '#ff2a00' : '';
			$key_c[$val]['ch_cust_ck'][] = $data['ch_cust_ck'];
			$key_c[$val]['clr_cust'][] = ($data['ch_cust_ck'] == 'yes') ? '#ff2a00' : '';

			$key_c[$val]['ch_ship_ck'][] = $data['ch_ship_ck'];
			$key_c[$val]['clr_ship'][] = ($data['ch_ship_ck'] == 'yes') ? '#ff2a00' : '';

			$key_c[$val]['ch_ship_notes'][] = $data['ch_ship_notes'];
			$key_c[$val]['ch_issue_ck'][] = $data['ch_issue_ck'];
			$key_c[$val]['clr_is'][] = ($data['ch_issue_ck'] == 'yes') ? '#fdae03' : '';
			$key_c[$val]['ch_notes'][] = (!empty($data['af_contacinfo']) ? $data['af_contacinfo'] . ' ' : '') . $data['ch_notes'];
			$key_c[$val]['ch_datetime'][] = $data['ch_datetime'];


		}
	}
	if ($num == 0)
		$key_c['msg'][0] = "<div style=\"text-align:center; margin:20px; font-weight:bold; font-size:15px;\">No results to display</div>";
	return $key_c;
}

function chk_attach_files()
{
if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
$value = $_SESSION['or'];
else
$value = 22000;

$obj = new db(); $att = array();
$c_st = $obj->get_CHILD($value);
$c_end = $obj->get_CHILD(($value+500));
/* Old Query */
// $qry = "select * from af_attach where (att_type = 'art' and att_ref>= $value and att_ref<=".($value+500).") or (att_type = 'poart' and att_ch >= $c_st and att_ch <= $c_end )";
/* Ver 08/30/2012  */
$qry = "select * from af_attach where (att_type = 'art' and att_ref>= $value and att_ref<=".($value+500).")";
if ($c_st!='' && $c_end!='') {
  $qry.=" or (att_type = 'poart' and att_ch >= $c_st and att_ch <= $c_end )";
}
/* End new version */
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$order_id= $data['att_ref'];
$ch_id=$data['att_ch'];
if($data['att_type'] == 'art')
$att['art'][$order_id] = 'yes';
else
$att['poart'][$ch_id] = 'yes';

}
return $att;
}


function reverse_tempPO($val)
{
$obj = new db();
$qry = " delete from af_attach where att_ch = $val";
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
$datadet = $obj->fetch($res);
$qry = "select a.af_order_id, a.ch_printqty, b.af_itemqty, a.ch_printcolor, a.ch_itemcolor, a.ch_rush_ck from af_child a, af_master b where a.ch_id = $chid and b.af_order_id = a.af_order_id";
$resdet = $obj->query($qry);
$dataord=$obj->fetch($resdet);
$data=  array_merge($datadet, $dataord);
 $qry = "select * from af_r2_items a, af_items b where a.r2_id = $chid and a.r2i_itemid = b.i_itemid";
$res = $obj->query($qry);
while($dat = $obj->fetch($res) )
{
$data['r2i_id'][]=$dat['r2i_id'];
$data['r2_id_'][]=$dat['r2_id'];
$data['i_itemid'][]=$dat['i_itemid'];
$data['i_oth_ven'][]=$dat['i_oth_ven'];
$data['r2i_itemid'][]=$dat['r2i_itemid'];
$data['r2i_desc'][]=$dat['r2i_desc'];
$data['r2i_qty'][]=$dat['r2i_qty'];
$data['r2i_prc'][]=$dat['r2i_prc'];
}

return $data;
}

function get_history($cid)
{
$obj = new db(); $dat = array();
$qry = "select * from r2_history where r2_cid = $cid order by r2_datetime DESC";
$res = $obj->query($qry);
$data_h=array();
while($dat = $obj->fetch($res) )
{
$data_h['r2_hid'][]=$dat['r2_hid'];
$data_h['r2_cid'][]=$dat['r2_cid'];
$data_h['r2_msg'][]=$dat['r2_msg'];
$data_h['r2_user'][]=$dat['r2_user'];
$data_h['r2_datetime'][]=$dat['r2_datetime'];
}
return $data_h;

}

function get_items()
{
$obj = new db(); $dat = array();
$qry = "select * from af_items order by i_itemid ASC";
$res = $obj->query($qry);
while($dat = $obj->fetch($res) )
{
$data_i['i_id'][]=$dat['i_id'];
$data_i['i_itemid'][]=$dat['i_itemid'];
$data_i['i_desc'][]=$dat['i_desc'];
$data_i['i_price'][]=$dat['i_price'];
$data_i['i_ven'][]=$dat['i_ven'];
$data_i['i_oth_ven'][]=$dat['i_oth_ven'];


}
return $data_i;

}

?>
