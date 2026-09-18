<?php
$out = array('result' => 0, 'error' => 'Clay / Previews Not Found');
include_once ('../model/mysql.php');
$obj = new db();
$qry = "select id, order_number, doc_type, doc_link, doc_name from lift_exports where managed=0 limit 10";
$res = $obj->query($qry);
$results = array();
while($data = $obj->fetch($res) ) {
    $results[] = array(
        'id' => $data['id'],
        'order_number' => $data['order_number'],
        'doc_type' => $data['doc_type'],
        'doc_link' => $data['doc_link'],
        'doc_name' => $data['doc_name'],
    );
}
if  (count($results) > 0) {
    $out['result'] = 1;
    $out['data'] = $results;
    foreach ($results as $result) {
        $updsql = "update lift_exports set managed=1 where id=".$result['id'];
        $resupd = $obj->query($updsql);
    }
}
echo json_encode($out);
return TRUE;

