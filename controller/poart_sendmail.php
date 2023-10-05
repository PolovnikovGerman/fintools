<?php
include('../model/mysql.php');
include('../includes/email_functions.php');
$obj = new db();
$qry = "select * from email_queue where send=0 order by id limit 1";
$res = $obj->query($qry);
while ($data = $obj->fetch($res)) {
    if (count($data) > 0) {
        $qryupd = "update email_queue set send=1, sendtime='".date('Y-m-d H:i:s')."' where id=".$data['id'];
        $resupd = $obj->query($qryupd);
        // Prepare email
        $attachs = json_decode($data['email_attach'], true);
        $sendres = send_email_docs($data['email_to'], $data['email_subj'], $data['email_body'], $attachs, $data['email_cc']);
        $qryupd1 = "update email_queue set send_result=".$sendres." where id=".$data['id'];
        $resupd1 = $obj->query($qryupd1);
    }
}
