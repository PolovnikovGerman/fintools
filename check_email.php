<?php
require('./includes/utility_functions.php');
require('./model/mysql.php');

$data2 = array();
$data2['v_email'] = 'to_german@yahoo.com';
$data2['v_name'] = 'ChemLite';
$oid = 63238;
$chpo = 'A';
$par=array($data2['v_name'],'BT'.$oid.$chpo);
$msg=emailTemplate('po',$par);
$save_name = "./docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$oid.$chpo.".pdf";
$arr = array(); $arr2 = array();
$arr[0] = $save_name; $arr2[0] = "BLUETRACK_PO_BT".$oid.$chpo.".pdf";
$obj = new db();

$qry = "select att_path, att_name from af_attach where att_ref = ".$oid." and att_type = 'art'";
$res = $obj->query($qry);
while($data = $obj->fetch($res)){
    $arr[]=$data['att_path'];
    $arr2[]=$data['att_name'];
}
send_email_attach($data2['v_email'],'Purchase Order #BT'.$oid.$chpo,$msg,$arr,$arr2);