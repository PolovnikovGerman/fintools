<?php
/* 
 * API Controller - receive Brown Export
 */
include('../model/af_model.php');
include('../includes/utility_functions.php');
$out = array('result' => 0, 'error' => 'Order Not Found');
$postdata = $_POST;
// Get Order bi ID
if (isset($postdata['af_order_id'])) {
    $dat = get_orderart($postdata['af_order_id']);
    if (array_key_exists('af_order_id', $dat)) {
        if ($postdata['sync']=='data') {
            // Order Found
            $updres=update_orderart($postdata, $dat['af_notes']);
            $out['error']='';
            $out['result']=1;
        } else {
            // Save Documents
//        $fh = fopen('../log/exportdata.log', 'a+');
//        foreach ($postdata as $key=>$val) {
//            $msg = date('d.m.Y H:i:s') . 'POST KEY '.$key.' Value '.$val.PHP_EOL;
//            fwrite($fh, $msg);
//        }
//        fclose($fh);
//        $out['result']=0;
//        $out['error']='Test';
            $updres=update_orderartdoc($postdata);
            $out['result']=$updres['result'];
            $out['error']=$updres['error'];
        }
    }
}
echo json_encode($out);
return TRUE;
