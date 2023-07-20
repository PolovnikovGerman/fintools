<?php
$starttime = time();
include('model/mysql.php');
$username='develop';
$password='mJWFFZ5mFhjy';
$URL='http://lifttest.stressballs.com/export/claypreview_export';
$authtoken = base64_encode($username.':'.$password);

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

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '.$authtoken
        ),
    ));

    $response = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    var_dump($status_code);
    $updsql = "update lift_exports set managed=1 where id=".$data['id'];
    $resupd = $obj->query($updsql);
}
$endtime = time();
$period = ($endtime - $starttime);
echo 'Export finished '.$period.PHP_EOL;
?>