<?php
require_once('../config/smtp_config.php');
require('Exception.php');
require('PHPMailer.php') ;
require('SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_email_docs($to, $subject, $body, $attachs=array(), $cc='') {
    $logfn = fopen('../topdf.log', 'a');
    $logger = 0;
    if ($logfn) {
        $logger = 1;
    }
    $mail = new PHPMailer;
    if ($logger) {
        fwrite($logfn,'Open PHPMAILER'.PHP_EOL);
        fwrite($logfn,'SMTP server'.SMTP_SERVER.PHP_EOL);
        fwrite($logfn,'SMTP secure '.SMTP_SECURE.PHP_EOL);
        fwrite($logfn,'SMTP port '.SMTP_PORT.PHP_EOL);
        fwrite($logfn,'SMTP user '.SMTP_USER.PHP_EOL);
        fwrite($logfn,'SMTP passwd '.SMTP_PASSWORD.PHP_EOL);
        fwrite($logfn,'SMTP sender '.SENDER_EMAIL.PHP_EOL);
    }
    $mail->isSMTP();
    $mail->CharSet = 'utf-8';
    $mail->Host = SMTP_SERVER;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port = SMTP_PORT;
    $mail->Username = SMTP_USER;
    $mail->Password = SMTP_PASSWORD;
    $mail->setFrom(SENDER_EMAIL);  // FROM
    $mail->addAddress($to);         // To
    if (!empty($cc)) {
        $mail->addCC($cc);      // CC
    }
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $body;
    if (count($attachs) > 0) {
        foreach ($attachs as $attach) {
            if (isset($attach['name'])) {
                $mail->addAttachment($attach['link'], $attach['name']);
            } else {
                $mail->addAttachment($attach['link']);
            }
        }
    }
    if ($logger) {
        fwrite($logfn,'Number of attachments '.count($attachs).PHP_EOL);
    }
    $obj = new db();
    if ($logger) {
        fwrite($logfn,'Start SEND '.PHP_EOL);
    }
    $flagsend = 0;
    $errmsg = '';
    try {
        $mail->send();
    } catch (Exception $e) {
        $errmsg = $e->getMessage();
    }
    $from = SENDER_EMAIL;
    if (empty($errmsg)) {
        $flagsend = 1;
        $qry = "insert into email_conf values(null,'$to','$from',now(),'$subject','yes','success')";
        $obj->query($qry);
        if (!empty($cc)) {
            $qry = "insert into email_conf values(null,'$to','$from',now(),'$subject','yes','success')";
            $obj->query($qry);
        }
    } else {
        if ($logger) {
            fwrite($logfn,'SEND ERROR '.$errmsg.PHP_EOL);
        }
        $qry = "insert into email_conf values(null,'$to','$from',now(),'$subject','yes','failed')";
        $obj->query($qry);
        if (!empty($cc)) {
            $qry = "insert into email_conf values(null,'$cc','$from',now(),'$subject','yes','failed')";
            $obj->query($qry);
        }
    }
    if ($logger) {
        fclose($logfn);
    }
    return $flagsend;
}