<?php
require_once('../config/smtp_config.php');
require('Exception.php');
require('PHPMailer.php') ;
require('SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_email_docs($to, $subject, $body, $attachs=array(), $cc='') {
    $mail = new PHPMailer;
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
    $obj = new db();
    try {
        $mail->send();
        $from = SENDER_EMAIL;
        $qry = "insert into email_conf values(null,'$to','$from',now(),'$subject','yes','success')";
        $obj->query($qry);
        if (!empty($cc)) {
            $qry = "insert into email_conf values(null,'$to','$from',now(),'$subject','yes','success')";
            $obj->query($qry);
        }
        return 1;
    } catch (Exception $e) {
        // echo 'Exception: ',  $e->getMessage(), "\n";
        $qry = "insert into email_conf values(null,'$to','$from',now(),'$subject','yes','failed')";
        $obj->query($qry);
        if (!empty($cc)) {
            $qry = "insert into email_conf values(null,'$cc','$from',now(),'$subject','yes','failed')";
            $obj->query($qry);
        }
        return 0;
    }
}