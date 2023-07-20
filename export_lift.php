<?php
$starttime = time();
include('model/mysql.php');
$username='develop';
$password='mJWFFZ5mFhjy';
$URL='http://lifttest.stressballs.com/export/claypreview_export';

$obj = new db();
$qry = "select id, order_number, doc_type, doc_link, doc_name from lift_exports where managed=0 limit 100";
$res = $obj->query($qry);
while($data = $obj->fetch($res) ) {
    $params = array(
        'order_number' => $data['order_number'],
        'doc_type' => $data['doc_type'],
        'doc_link' => $data['doc_link'],
        'doc_name' => $data['doc_name'],
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$URL);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $result=curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close ($ch);
    echo 'Curl send '.$data['id'].' Status - '.$status_code.PHP_EOL;
    $updsql = "update lift_exports set managed=1 where id=".$data['id'];
    $resupd = $obj->query($updsql);
}
$endtime = time();
$period = ($endtime - $starttime);
echo 'Export finished '.$period.PHP_EOL;
?>