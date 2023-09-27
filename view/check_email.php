<?php
require('../includes/utility_functions.php');
require('../model/mysql.php');
$from = "ff@bluetrack.com";
$headers = [];
$headers[] = "From: ff@";
// boundary
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
// headers for attachment
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

$data2 = array();
$data2['v_email'] = 'to_german@yahoo.com';
$data2['v_additional_email'] = 'german.polovnikov@bluetrack.com';
$data2['v_name'] = 'ChemLite';
$oid = 63238;
$chpo = 'A';
$par=array($data2['v_name'],'BT'.$oid.$chpo);
$msg=emailTemplate('po',$par);

$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
$message .= "--{$mime_boundary}\n";

$ok = mail($data2['v_email'], 'Purchase Order #BT'.$oid.$chpo, $message, $headers);
echo 'Test SEND '.$ok.'!'.PHP_EOL;
die();


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
echo 'SEND DATA '.$data2['v_email'].PHP_EOL;
$res = send_email_attach($data2['v_email'],'Purchase Order #BT'.$oid.$chpo,$msg,$arr,$arr2);
echo 'Send result '.$res.' !'.PHP_EOL;
if ($data2['v_additional_email']!='') {
    echo 'SEND DATA '.$data2['v_additional_email'].PHP_EOL;
    $resadd = send_email_attach($data2['v_additional_email'],'Purchase Order #BT'.$oid.$chpo,$msg,$arr,$arr2);
    echo 'ADD Send result '.$resadd.' !'.PHP_EOL;
}
