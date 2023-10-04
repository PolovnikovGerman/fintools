<?php
require('../includes/utility_functions.php');
require('../model/mysql.php');
require_once('../config/smtp_config.php');
require('../includes/Exception.php');
require('../includes/PHPMailer.php') ;
require('../includes/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;
$mail->isSMTP();
$mail->CharSet = 'utf-8';
$mail->Host = SMTP_SERVER;
$mail->SMTPAuth = true;
$mail->SMTPSecure = SMTP_SECURE;
$mail->Port = SMTP_PORT;
$mail->Username = SMTP_USER;
$mail->Password = SMTP_PASSWORD;

$mail->setFrom('ff@bluetrack.com', 'Test Mail');  // FROM
$mail->addAddress('german.polovnikov@bluetrack.com');         // To
$mail->addCC('sage.katakura@bluetrack.com');      // CC
$mail->addCC('junior.gonzalez@bluetrack.com');
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Purchase Order BLUETRACK_PO_BT63238A';
$data2 = array();
// $data2['v_email'] = 'to_german@yahoo.com';
// $data2['v_additional_email'] = 'german.polovnikov@bluetrack.com';
$data2['v_name'] = 'ChemLite';
$oid = 63295;
$chpo = 'A';
$par=array($data2['v_name'],'BT'.$oid.$chpo);
$msg=emailTemplate('po',$par);
$mail->Body = $msg;
$save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$oid.$chpo.".pdf";
$mail->addAttachment($save_name, "BLUETRACK_PO_BT".$oid.$chpo.".pdf");         //Add attachments
$qry = "select att_path, att_name from af_attach where att_ref = ".$oid." and att_type = 'art'";
$obj = new db();
$res = $obj->query($qry);
while($data = $obj->fetch($res)){
    $mail->addAttachment($data['att_path'], $data['att_name']);         //Add attachments
}
try {
    $mail->send();
    echo 'Send Successfully'.PHP_EOL;
} catch (Exception $e) {
    echo 'Exception: ',  $e->getMessage(), "\n";
}
//if(!$mail->send()) {
//    echo 'Error during send Email'.PHP_EOL;
//} else {
//    echo 'SUCCESS Send'.PHP_EOL;
//}
