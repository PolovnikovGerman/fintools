<?php
include('model/mysql.php');
$obj = new db();
$qry = "select count(id) as cnt, max(last_managed) as maxrec from lift_exports";
$res = $obj->query($qry);
$maxid = 0;
while($data = $obj->fetch($res) )
{
    if ($data['cnt'] > 0) {
        $maxid = $data['maxrec'];
    }
}
$qrydoc = "select atch.att_id as id, atch.att_path as doc_link, atch.att_type as doc_type, atch.att_name as doc_name, ch.af_order_id as order_num
from af_attach atch 
join af_child ch on ch.ch_id=atch.att_ch
where atch.att_ch > ".$maxid." and atch.att_type in ('prv','clay') order by atch.att_id limit 1000";
$resdoc = $obj->query($qrydoc);
while($data = $obj->fetch($resdoc) ) {
    $insqry = "insert into lift_exports(order_number, doc_type, doc_link, doc_name, last_managed) values ({$data['order_num']},'{$data['doc_type']}', '{$data['doc_link']}','{$data['doc_name']}', {$data['id']})";
    $resins = $obj->query($insqry);
}
echo 'Export finished'.PHP_EOL;
?>
