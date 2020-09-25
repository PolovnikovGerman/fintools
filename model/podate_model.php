<?php  
include_once('mysql.php');
include_once('../controller/generic_functions.php'); 
?>
<?php
function get_podate_count() {
    $obj = new db();    
    $qry = "select count(distinct date_format(email_datetime,'%Y-%m-%d')) as cnt from email_conf where email_type like 'Purchase Order #BT%' ";
    $res = $obj->query($qry);
    while ($data = $obj->fetch($res)) {
        $cntrec=$data['cnt'];
    }

    return $cntrec;
}
function get_po_dates($limit,$offset) {
    $obj = new db();
    $key = array();
    $qry = "select distinct date_format(email_datetime,'%Y-%m-%d') as po_date from email_conf where email_type like 'Purchase Order #BT%' order by email_datetime desc limit $offset,$limit";
    
    $key=array();
    $res = $obj->query($qry);    
    while ($data = $obj->fetch($res)) {
        $key[]=array('order_date'=>$data['po_date']);        
    }
    
    return $key;
}
function get_pobydates($po_dates) {
    $obj = new db();
    $key = array();
    foreach ($po_dates as $row) {
        $qry = "select e.email_datetime, ch.ch_id, ch.ch_vendor, concat('BT',ch.af_order_id,ch.ch_po) as order_num, ch.ch_po, ch.af_order_id 
            from email_conf e, af_child ch   ";        
        $qry.=" where date_format(e.email_datetime,'%Y-%m-%d') = '".$row['order_date']."' and substr(e.email_type,19)=concat(ch.af_order_id,ch_po)";
        $res = $obj->query($qry);    
        while ($data = $obj->fetch($res)) {
            
            $ct=$obj->get_CHILD($data['af_order_id']);
            $ord_id=$data['af_order_id'];
            $qry1 = "select * from af_attach where (att_type = 'art' and att_ref= $ord_id )";
            if ($ct != '') {
                $qry1.=" or (att_type = 'poart' and att_ch = $ct )";
            }
            /* End new version */
            $res2 = $obj->query($qry1);
            $attrib_art='';
            $attrib_poart='';
            while ($dats = $obj->fetch($res2)) {
                if ($dats['att_type'] == 'art')
                    $attrib_art = 'yes';
                else
                    $attrib_poart = 'yes';
            }
            
            $key[$row['order_date']][]=array(
                'ch_id'=>$data['ch_id'],
                'order_date'=>$data['ch_ship_date'],
                'vendor'=>($data['ch_vendor']=='' ? '&nbsp;' : $data['ch_vendor']),
                'order_num'=>$data['order_num'],
                'art_attrib'=>$attrib_art,
                'poart_attrib'=>$attrib_poart,
                'af_order_id'=>$data['af_order_id'],
                'ch_po'=>$data['ch_po'],
                
                
            );        
            
        }
    }
    return $key;
}
?>