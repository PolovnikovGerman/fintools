<?php
$starttime = time();
include('model/mysql.php');
$username='develop';
$password='mJWFFZ5mFhjy';
$URL='http://lifttest.stressballs.com/export/claypreview_export';
$authtoken = base64_encode($username.':'.$password);
$headers = array(
    'Authorization: Basic '.$authtoken,
);

$obj = new db();
$qry = "select id, order_number, doc_type, doc_link, doc_name from lift_exports where managed=0 limit 10";
$res = $obj->query($qry);
$results = array();
while($data = $obj->fetch($res) ) {
    $results[] = array(
        'order_number' => $data['order_number'],
        'doc_type' => $data['doc_type'],
        'doc_link' => $data['doc_link'],
        'doc_name' => $data['doc_name'],
    );
}
echo 'Prepare '.count($results).' records'.PHP_EOL;
foreach ($results as $result) {
    $params = array(
        'order_number' => $result['order_number'],
        'doc_type' => $result['doc_type'],
        'doc_link' => $result['doc_link'],
        'doc_name' => $result['doc_name'],
    );
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $apiResponse=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);
        if ($status_code==200) {
            echo 'Success ID '.$result['id'].PHP_EOL;
            $updsql = "update lift_exports set managed=1 where id=".$result['id'];
            $resupd = $obj->query($updsql);
        }
    } catch (Exception $e) {
        echo 'Error '.PHP_EOL;
        var_dump($e);
        die();
    }

}
$endtime = time();
$period = ($endtime - $starttime);
echo 'Export finished '.$period.PHP_EOL;
?>