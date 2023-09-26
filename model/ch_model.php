<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>

<?php


function get_vch_orders($value)
{
if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
$value = $_SESSION['or'];
else
$value = 22000;


$obj = new db();

if(isset($_SESSION['whr_ch']) && !empty($_SESSION['whr_ch'])  )
{
if($_SESSION['whr_ch'] == 'on_vendor')
 // $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and b.ch_conf_ck = 'yes' and (b.ch_claydoc_ck = 'no' or (b.chn_clayapr_ck = 'yes' and b.ch_prvdoc_ck = 'no') or (b.chn_prvapr_ck = 'yes' and (b.ch_ship_notes = '' and b.chn_shipbt_notes = '')) )";
    $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and (b.ch_claydoc_ck = 'no' or (b.chn_clayapr_ck = 'yes' and b.ch_prvdoc_ck = 'no') or (b.chn_prvapr_ck = 'yes' and (b.ch_ship_notes = '' and b.chn_shipbt_notes = '')) )";
if($_SESSION['whr_ch'] == 'on_cust')
// $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and b.ch_conf_ck = 'yes' and ((b.chn_claysent_ck = 'yes' and b.chn_clayapr_ck = 'no') or (b.chn_prvsent_ck = 'yes' and b.chn_prvapr_ck = 'no'))";
    $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and ((b.chn_claysent_ck = 'yes' and b.chn_clayapr_ck = 'no') or (b.chn_prvsent_ck = 'yes' and b.chn_prvapr_ck = 'no'))";
if($_SESSION['whr_ch'] == 'on_us')
// $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and b.ch_conf_ck = 'yes' and ((ch_claydoc_ck = 'yes' and chn_claysent_ck = 'no') or (ch_prvdoc_ck = 'yes' and chn_prvsent_ck = 'no') or (chn_shipbt_ck = 'yes' and ch_ship_ck = 'no') )";
    $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and ((ch_claydoc_ck = 'yes' and chn_claysent_ck = 'no') or (ch_prvdoc_ck = 'yes' and chn_prvsent_ck = 'no') or (chn_shipbt_ck = 'yes' and ch_ship_ck = 'no') )";
}
else
// $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id and b.ch_conf_ck = 'yes'";
    $qry = "select * from af_master a,af_child b  where b.ch_vendor in (select distinct(v_abbr) from af_vendor where v_type = 'chinese') and b.af_order_id >= $value and b.af_order_id <=".($value+1000)." and a.af_order_id = b.af_order_id";

$res = $obj->query($qry);
$vch_ord = array();
while($data = $obj->fetch($res) )
{
$vch_ord['af_cust'][]=$data['af_cust'];
$vch_ord['af_desc'][]=$data['af_desc'];
$vch_ord['ch_id'][]=$data['ch_id'];
$vch_ord['af_order_id'][]=$data['af_order_id'];
$vch_ord['ch_ship_date'][]=$data['ch_ship_date'];
$vch_ord['ch_po'][]=$data['ch_po'];
$vch_ord['chn_claysent_ck'][]=$data['chn_claysent_ck'];
$vch_ord['claysent'][]=($data['chn_claysent_ck']=='yes') ? '#ff2a00' : '';
$vch_ord['chn_clayapr_ck'][]=$data['chn_clayapr_ck'];
$vch_ord['clayapr'][]=($data['chn_clayapr_ck']=='yes') ? '#ff2a00' : '';
$vch_ord['chn_prvsent_ck'][]=$data['chn_prvsent_ck'];
$vch_ord['prvsent'][]=($data['chn_prvsent_ck']=='yes') ? '#ff2a00' : '';
$vch_ord['chn_prvapr_ck'][]=$data['chn_prvapr_ck'];
$vch_ord['prvapr'][]=($data['chn_prvapr_ck']=='yes') ? '#ff2a00' : '';
$vch_ord['chn_shipbt_ck'][]=$data['chn_shipbt_ck'];
$vch_ord['shipbt'][]=($data['chn_shipbt_ck']=='yes') ? '#ff2a00' : '';
$vch_ord['chn_shipbt_notes'][]=$data['chn_shipbt_notes'];
$vch_ord['ch_ship_ck'][]=$data['ch_ship_ck'];
$vch_ord['ship'][]=($data['ch_ship_ck']=='yes') ? '#ff2a00' : '';
$vch_ord['ch_ship_notes'][]=$data['ch_ship_notes'];
$vch_ord['ch_issue_ck'][]=$data['ch_issue_ck'];
$vch_ord['issue'][]=($data['ch_issue_ck']=='yes') ? '#fdae03' : '';
$vch_ord['ch_notes'][]=$data['ch_notes'];
}

$qry="select af_order_id,af_cust, af_desc from af_master";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
	$ord=$data['af_order_id'];

}

return $vch_ord;
}


function chk_attach_files()
{
if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
$value = $_SESSION['or'];
else
$value = 22000;
$obj = new db(); $att = array();
$qry = "select * from af_attach where (att_type = 'art' and att_ref>= $value and att_ref<=".($value+500).") or (att_type != 'art' and att_ref = 0 and att_ch > 0 ) ";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$order_id= $data['att_ref'];
$ch_id=$data['att_ch'];
if($data['att_type'] == 'art')
$att['art'][$order_id] = 'yes';
else if($data['att_type'] == 'poart')
$att['poart'][$ch_id] = 'yes';
else if($data['att_type'] == 'clay')
$att['clay'][$ch_id] = 'yes';
else if($data['att_type'] == 'prv')
$att['prv'][$ch_id] = 'yes';

}
return $att;
}

?>