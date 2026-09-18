<?php
$fh = fopen('../test.txt', 'a+');
if (!$fh) {
    echo json_encode(array('error' => 'Unable to open test.txt'));
    return FALSE;
} else {
    fwrite($fh, 'Export start '.date('Y-m-d H:i:s').PHP_EOL);
}
$out = array('result' => 0, 'error' => 'Clay / Previews Not Found');
include_once('../model/mysql.php');
$obj = new db();
$results = array();
$qry = 'select * from lift_exportpo where managed=0 order by id desc limit 100';
fwrite($fh, 'PO SQL '.$qry.PHP_EOL);
$res = $obj->query($qry);
while($data = $obj->fetch($res)){
    $methods = array();
    $items = array();
    // Get methods
    $methsql = 'select * from lift_exportpo_methods where exportpo_id='.$data['id'];
    fwrite($fh, 'Method SQL '.$methsql.PHP_EOL);
    $methres = $obj->query($methsql);
    while ($methdat = $obj->fetch($methres)){
        $methods[] = array(
            'id' => $methdat['id'],
            'exportpo_id' => $methdat['exportpo_id'],
            'ship_method' => $methdat['ship_method'],
            'ship_date' => $methdat['ship_date'],
            'ship_address' => $methdat['ship_address'],
        );
    }
    // Get items
    $itemsql = 'select * from lift_exportpo_items where exportpo_id='.$data['id'];
    fwrite($fh, 'Items SQL '.$itemsql.PHP_EOL);
    $itemres = $obj->query($itemsql);
    while ($itemdata = $obj->fetch($itemres)) {
        $items[] = array(
            'id' => $itemdata['id'],
            'exportpo_id' => $itemdata['exportpo_id'],
            'item_number' => $itemdata['item_number'],
            'item_name' => $itemdata['item_name'],
            'item_qty' => $itemdata['item_qty'],
            'item_price' => $itemdata['item_price'],
        );
    }
    $results[] = array(
        'id' => $data['id'],
        'order_num' => $data['order_num'],
        'po_code' => $data['po_code'],
        'po_date' => $data['po_date'],
        'vendor_name' => $data['vendor_name'],
        'po_total' => $data['po_total'],
        'po_ship_date' => $data['po_ship_date'],
        'po_ship_act' => $data['po_ship_act'],
        'po_vendor_msg' => $data['po_vendor_msg'],
        'po_attach_path' => $data['po_attach_path'],
        'po_attach_name' => $data['po_attach_name'],
        'methods' => $methods,
        'items' => $items,
    );
    $updsql = "update lift_exportpo set managed=1 where id=".$data['id'];
    fwrite($fh, 'UPdate PO '.$updsql.PHP_EOL);
    $resupd = $obj->query($updsql);
}
if  (count($results) > 0) {
    $out['result'] = 1;
    $out['orders'] = $results;
}
echo json_encode($out);
fclose($fh);
return TRUE;
