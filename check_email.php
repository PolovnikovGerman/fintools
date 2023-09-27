<?php
require('../includes/utility_functions.php');
require('../model/mysql.php');

$data2 = array();
$data2['v_email'] = 'to_german@yahoo.com';
$data2['v_additional_email'] = 'german.polovnikov@bluetrack.com';
$data2['v_name'] = 'ChemLite';
$oid = 63238;
$chpo = 'A';
$par=array($data2['v_name'],'BT'.$oid.$chpo);
$msg=emailTemplate('po',$par);
$save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$oid.$chpo.".pdf";
$arr = array(); $arr2 = array();
$arr[0] = $save_name; $arr2[0] = "BLUETRACK_PO_BT".$oid.$chpo.".pdf";
$obj = new db();

$qry = "select att_path, att_name from af_attach where att_ref = ".$oid." and att_type = 'art'";
$res = $obj->query($qry);
while($data = $obj->fetch($res)){
    // $arr[] =str_replace('../docs/','./docs/', $data['att_path']);
    $arr[] = $data['att_path'];
    $arr2[] = $data['att_name'];
}
// var_dump($data2);
// var_dump($arr);
// var_dump($arr2);
// echo $msg.PHP_EOL;
$res = send_email_attach($data2['v_email'],'Purchase Order #BT'.$oid.$chpo,$msg,$arr,$arr2);
echo 'Send result '.$res.' !'.PHP_EOL;
if ($data2['v_additional_email']!='') {
    $resadd = send_email_attach($data2['v_additional_email'],'Purchase Order #BT'.$oid.$chpo,$msg,$arr,$arr2);
    echo 'ADD Send result '.$resadd.' !'.PHP_EOL;
}
