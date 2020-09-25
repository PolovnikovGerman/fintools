<?php
include('../model/mysql.php');
$obj = new db();
$qry = " select m.af_order_id as order_num, m.af_date as order_date, m.af_rush_ck as order_rush, m.af_cust as customer,
m.af_desc as order_item, m.af_appr_ck as order_approve, m.af_notes, atch.cnt_attach,
lower(chld.ch_po) as ch_po, chld.ch_ship_date as ship_date, chld.ch_vendor as vendor,
chld.ch_conf_ck as order_confirm, chld.ch_ship_ck order_shipping, chld.ch_ship_notes, chld.ch_cust_ck,
chld.ch_issue_ck
from af_master m
left join (SELECT att_ref,count(att_id) as cnt_attach FROM af_attach where att_ref!=0 group by att_ref) atch on atch.att_ref=m.af_order_id
left join (select * from af_child where ch_placed_ck='yes') as  chld on chld.af_order_id=m.af_order_id
join af_vendor v on v.v_abbr=chld.ch_vendor
where m.af_date!='0000-00-00' 
and v.v_type = 'chinese'
order by m.af_order_id";
$res = $obj->query($qry);
$results=array();
while($data = $obj->fetch($res) )
{
    $results[]=$data;
}
$norder='';
$fullfil=array();
foreach ($results as $row) {
    if ($norder!=$row['order_num']) {
        /* New order data */
        $norder=$row['order_num'];
        $fullfil[]=array(
            'order_num'=>$row['order_num'],
            'order_date'=>strtotime($row['order_date']),
            'customer'=>$row['customer'],
            'order_item'=>$row['order_item'],
            'order_approve'=>$row['order_approve'],
            'order_notes'=>$row['af_notes'],
            'cnt_attach'=>$row['cnt_attach'],
            'po_a_ship_date'=>0,
            'po_a_vendor'=>'',
            'po_a_confirm'=>'',
            'po_a_shipping'=>'',
            'po_a_ship_notes'=>'',
            'po_a_cust_check'=>'',
            'po_a_issue'=>'',
            'po_b_ship_date'=>0,
            'po_b_vendor'=>'',
            'po_b_confirm'=>'',
            'po_b_shipping'=>'',
            'po_b_ship_notes'=>'',
            'po_b_cust_check'=>'',
            'po_b_issue'=>'',
            'po_c_ship_date'=>0,
            'po_c_vendor'=>'',
            'po_c_confirm'=>'',
            'po_c_shipping'=>'',
            'po_c_ship_notes'=>'',
            'po_c_cust_check'=>'',
            'po_c_issue'=>'',
            'po_d_ship_date'=>0,
            'po_d_vendor'=>'',
            'po_d_confirm'=>'',
            'po_d_shipping'=>'',
            'po_d_ship_notes'=>'',
            'po_d_cust_check'=>'',
            'po_d_issue'=>'',            
        );
        $fillidx=count($fullfil)-1;
    }
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_ship_date']=strtotime($row['ship_date']);
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_vendor']=$row['vendor'];
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_confirm']=$row['order_confirm'];
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_shipping']=$row['order_shipping'];
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_ship_notes']=$row['ch_ship_notes'];
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_cust_check']=$row['ch_cust_ck'];
    $fullfil[$fillidx]['po_'.$row['ch_po'].'_issue']=$row['ch_issue_ck'];
}

$filename='../uploads/chinese_fullfill_export_'.date('Y-m-d').'_'.date('H_i_s').'.csv';
$fh=fopen($filename,'w');
if ($fh) {
    /* Title */
    $row='Order #;Order Date;Customer;Order Item;Order Approve;Order Note;# Attachments;';
    $row.='PO-A Ship Date;PO-A Vendor;PO-A Confirm;PO-A Shipping;PO-A Ship Notes;PO-A Custom Check;PO-A Issue;';
    $row.='PO-B Ship Date;PO-B Vendor;PO-B Confirm;PO-B Shipping;PO-B Ship Notes;PO-B Custom Check;PO-B Issue;';
    $row.='PO-C Ship Date;PO-C Vendor;PO-C Confirm;PO-C Shipping;PO-C Ship Notes;PO-C Custom Check;PO-C Issue;';
    $row.='PO-D Ship Date;PO-D Vendor;PO-D Confirm;PO-D Shipping;PO-D Ship Notes;PO-D Custom Check;PO-D Issue;'.PHP_EOL;
    fwrite($fh, $row);
    foreach ($fullfil as $row) {        
        $str=$row['order_num'].';'.($row['order_date']>0 ? date('m/d/Y',$row['order_date']) : '').';'.$row['customer'].';'.$row['order_item'].';'.$row['order_approve'].';';
        $str.=$row['order_notes'].';'.intval($row['cnt_attach']).';';
        $str.=($row['po_a_ship_date']>0 ? date('m/d/Y',$row['po_a_ship_date']) : '').';';
        $str.=$row['po_a_vendor'].';'.$row['po_a_confirm'].';'.$row['po_a_shipping'].';'.$row['po_a_ship_notes'].';'.$row['po_a_cust_check'].';'.$row['po_a_issue'].';';
        $str.=($row['po_b_ship_date']>0 ? date('m/d/Y',$row['po_b_ship_date']) : '').';';
        $str.=$row['po_b_vendor'].';'.$row['po_b_confirm'].';'.$row['po_b_shipping'].';'.$row['po_b_ship_notes'].';'.$row['po_b_cust_check'].';'.$row['po_b_issue'].';';
        $str.=($row['po_c_ship_date']>0 ? date('m/d/Y',$row['po_c_ship_date']) : '').';';
        $str.=$row['po_c_vendor'].';'.$row['po_c_confirm'].';'.$row['po_c_shipping'].';'.$row['po_c_ship_notes'].';'.$row['po_c_cust_check'].';'.$row['po_c_issue'].';';
        $str.=($row['po_d_ship_date']>0 ? date('m/d/Y',$row['po_d_ship_date']) : '').';';
        $str.=$row['po_d_vendor'].';'.$row['po_d_confirm'].';'.$row['po_d_shipping'].';'.$row['po_d_ship_notes'].';'.$row['po_d_cust_check'].';'.$row['po_d_issue'].';'.PHP_EOL;
        fwrite($fh, $str);
    }
    fclose($fh);
    echo json_encode(array('errors'=>'','url'=>$filename));
} else {
    echo json_encode(array('errors'=>'Can\t save export file','url'=>''));
}
?>
