<?php
include('model/mysql.php');
$obj = new db();
// $startdate = strtotime(date("Y-m-d"));
// $startdate = strtotime('2026-09-16');
// $finishdate = strtotime(date('Y-m-d', $startdate)."+1 day");
$finishdate = strtotime(date('Y-m-d'));
$startdate = strtotime(date('Y-m-d', $finishdate)."-1 day");
echo 'Start '.date("Y-m-d H:i:s",$startdate).' to '.date("Y-m-d  H:i:s",$finishdate).PHP_EOL;
$qry = 'select ch.ch_id, ch.af_order_id, ch.ch_po, r.r2_date, ch.ch_vendor, ch.ch_poTotal, r.r2_ship_date, r.r2_ship_act, r.r2_ven_msg';
for ($i=1; $i<4; $i++) {
    $qry.=',r.r2_d'.$i.'_type, r.r2_d'.$i.'_date, r.r2_d'.$i.'_add';
}
$qry.=' from af_child ch join af_r2 r on r.r2_id=ch.ch_id ';
$qry.=' where (unix_timestamp(ch.updatetime) >= '.$startdate.' and unix_timestamp(ch.updatetime) < '.$finishdate.') and ch.ch_vendor != \'\'';
$qry.=' order by ch.af_order_id, ch.ch_po';
$res = $obj->query($qry);
$numpp = 0;
while($data = $obj->fetch($res) )
{
    echo 'Order '.$data['af_order_id'].'-'.$data['ch_po'].PHP_EOL;
    // Get attached files
    $docsql = 'select att_path, att_name from af_attach where att_ch='.$data['ch_id'].' and att_type="poart"';
    $resdoc = $obj->query($docsql);
    $attname = $attpath = '';
    while($datadoc = $obj->fetch($resdoc) )
    {
        $attname = $datadoc['att_name'];
        $attpath = $datadoc['att_path'];
    }
    // $vendmsg = preg_replace('/"([^"]+)"/', '«$1»', $data['r2_ven_msg']);
    $vendmsg = addslashes($data['r2_ven_msg']);
    $sqlins = 'insert into lift_exportpo(order_num, po_code, po_date, vendor_name, po_total, po_ship_date, po_ship_act, po_vendor_msg, po_attach_path, po_attach_name)';
    $sqlins.=' values('.$data['af_order_id'].',"'.$data['ch_po'].'", "'.$data['r2_date'].'", "'.$data['ch_vendor'].'", '.$data['ch_poTotal'].', "'.$data['r2_ship_date'].'",';
    $sqlins.='"'.$data['r2_ship_act'].'","'.$vendmsg.'", "'.$attpath.'", "'.$attname.'")';
    $resins = $obj->query($sqlins);
    $poexpid = mysqli_insert_id($obj->conn);
    if ($poexpid > 0) {
        for ($i=1; $i<4; $i++) {
            if (!empty($data['r2_d'.$i.'_type'])) {
                //$shipaddr = preg_replace('/"([^"]+)"/', '«$1»', $data['r2_d'.$i.'_add']);
                $shipaddr = addslashes($data['r2_d'.$i.'_add']);
                $methins = 'insert into lift_exportpo_methods(exportpo_id, ship_method, ship_date, ship_address)';
                $methins.=' values('.$poexpid.', "'.$data['r2_d'.$i.'_type'].'","'.$data['r2_d'.$i.'_date'].'", "'.$shipaddr.'")';
                $resins = $obj->query($methins);
            }
        }
        // Add Items
        $itmsql = 'select * from af_r2_items where r2_id = '.$data['ch_id'];
        $itmobj = $obj->query($itmsql);
        while ($item = $obj->fetch($itmobj)) {
            // $itemname = preg_replace('/"([^"]+)"/', '«$1»', $item['r2i_desc']);
            $itemname = substr(addslashes($item['r2i_desc']),0,250);
            $itmins = 'insert into lift_exportpo_items(exportpo_id, item_number, item_name, item_qty, item_price) ';
            $itmins.=' values('.$poexpid.', "'.$item['r2i_itemid'].'", "'.$itemname.'", '.$item['r2i_qty'].', '.$item['r2i_prc'].')';
            $resins = $obj->query($itmins);
        }
    }
    //
    $numpp++;
}
echo 'Insert '.$numpp.' items done'.PHP_EOL;
