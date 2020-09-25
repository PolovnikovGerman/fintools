<?php
/*
 select * from af_items i where substr(i.i_itemid,1,3)='22-' order by i.i_itemid;
 * 
 */
// $curdir=__DIR__;
$curdir='/home/bluetrac/public_html/system';
include($curdir.'/model/mysql.php');
//
/*
$items=array();
$db=new db();
$sql="select * from af_items i where substr(i.i_itemid,1,3)='22-' order by i.i_itemid;";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $items[]=array(        
        'item_num'=>$data['i_itemid'],
        'item_name'=>$data['i_desc'],
        'vendor'=>$data['i_ven'],
        'qty_2012'=>0,
        'orders_2012'=>0,
        'custom_2012'=>0,
        'qty_2013'=>0,
        'orders_2013'=>0,
        'custom_2013'=>0,
        'qty_2014'=>0,
        'orders_2014'=>0,
        'custom_2014'=>0,
        'qty_2015'=>0,
        'orders_2015'=>0,
        'custom_2015'=>0,
    );
}
$i=0;
foreach ($items as $row) {
    $sql="select date_format(m.af_date,'%Y') as ordyear, sum(i.r2i_qty) as qty, count(m.af_order_id) as cnt from af_master m join af_r2_items i on i.r2_id=m.af_order_id
    where date_format(m.af_date,'%Y')>=2012 and m.af_appr_ck='yes' and i.r2i_itemid='{$row['item_num']}' group by ordyear";
    $res1=$db->query($sql);
    while($data = $db->fetch($res1) ) {    
        switch ($data['ordyear']) {
            case '2012':
                $items[$i]['qty_2012']+=$data['qty'];
                $items[$i]['orders_2012']+=$data['cnt'];
                break;
            case '2013':
                $items[$i]['qty_2013']+=$data['qty'];
                $items[$i]['orders_2013']+=$data['cnt'];
                break;
            case '2014':
                $items[$i]['qty_2014']+=$data['qty'];
                $items[$i]['orders_2014']+=$data['cnt'];
                break;
            case '2015':
                $items[$i]['qty_2015']+=$data['qty'];
                $items[$i]['orders_2015']+=$data['cnt'];
                break;
        }
    }
    $sql="select date_format(m.af_date,'%Y') as ordyear, m.af_cust as cust, count(m.af_order_id) as cnt from af_master m
        join af_r2_items i on i.r2_id=m.af_order_id where date_format(m.af_date,'%Y')>=2012 and m.af_appr_ck='yes' 
        and i.r2i_itemid='{$row['item_num']}' group by ordyear, cust";
    $res2=$db->query($sql);
    while($data = $db->fetch($res2) ) {    
        switch ($data['ordyear']) {
            case '2012':
                $items[$i]['custom_2012']+=1;
                break;
            case '2013':
                $items[$i]['custom_2013']+=1;
                break;
            case '2014':
                $items[$i]['custom_2014']+=1;
                break;
            case '2015':
                $items[$i]['custom_2015']+=1;
                break;
        }
    }    
    $i++;
}
$fh=fopen('multyrep.csv','a');
if ($fh) {
    $msg='Item#,Item Name,Vendor,QTY 2012,Orders 2012,DiffCust 2012,QTY 2013,Orders 2013,DiffCust 2013,QTY 2014,Orders 2014,DiffCust 2014,QTY 2015,Orders 2015,DiffCust 2015'.PHP_EOL;
    fwrite($fh, $msg);
    foreach ($items as $row) {
        $msg=$row['item_num'].',"'.$row['item_name'].'",'.$row['vendor'].',';
        $msg.=$row['qty_2012'].','.$row['orders_2012'].','.$row['custom_2012'].',';
        $msg.=$row['qty_2013'].','.$row['orders_2013'].','.$row['custom_2013'].',';
        $msg.=$row['qty_2014'].','.$row['orders_2014'].','.$row['custom_2014'].',';
        $msg.=$row['qty_2015'].','.$row['orders_2015'].','.$row['custom_2015'].PHP_EOL;
        fwrite($fh, $msg);        
    }
    fclose($fh);
} else {
    echo 'Error - cann\'t open file to write';
}
 * 
 */
$results=array();
$yearsarr=array();
// year, Total Orders, Orders with 1PO, Orders with 2PO, Orders with 3PO, Orders with 4+PO
for ($i=2009; $i<2017; $i++) {
    $results[]=array(
        'year'=>$i,
        'total'=>0,
        'total_1'=>0,
        'total_2'=>0,
        'total_3'=>0,
        'total_4'=>0,
    );
    array_push($yearsarr, $i);    
}
// lets go
$sql="select date_format(from_unixtime(unix_timestamp(af_date)),'%Y') as ordyear, af_order_id, 
af_art_ck,af_redraw_ck, af_vector_ck, af_proof_ck, af_appr_ck, af_cust_ck, af_notes
from af_master";
$db=new db();
@unlink('totalrep.csv');
$fh=fopen('totalrep.csv','a');
if ($fh) {
    $resmaster=$db->query($sql);
    while($data = $db->fetch($resmaster) ) {  
        if ($data['ordyear']>=2009 and $data['ordyear']<2017) {
            $sql1="select count(*) as cnt from af_child where af_order_id={$data['af_order_id']} and ch_placed_ck='yes'";
            $resact=$db->query($sql1);
            while($total = $db->fetch($resact) ) {                 
                if ($total['cnt']>0) {
                    $yearkey=  array_search($data['ordyear'], $yearsarr);                    
                    if ($yearkey!==FALSE) {
                        $results[$yearkey]['total']+=1;
                        if ($total['cnt']==1) {
                            $results[$yearkey]['total_1']+=1;
                        } elseif ($total['cnt']==2) {
                            $results[$yearkey]['total_2']+=1;
                        } elseif ($total['cnt']==3) {
                            $results[$yearkey]['total_3']+=1;
                        } else {
                            $results[$yearkey]['total_4']+=1;
                        }                    
                    }
                }
            }
            
        }
        // Select count of active PO        
    }
    var_dump($results);
    die();
    $msg='Year;Total Orders;Orders with 1PO;Orders with 2PO;Orders with 3PO;Orders with 4+PO;'.PHP_EOL;
    fwrite($fh, $msg);
    foreach ($results as $row) {
        $msg=$row['year'].';'.$row['total'].';'.$row['total_1'].';'.$row['total_2'].';'.$row['total_3'].';'.$row['total_4'].';'.PHP_EOL;
        fwrite($fh, $msg);
    }
    fclose($fh);
    echo 'Ready'.PHP_EOL;
} else {
    echo 'Error - cann\'t open file to write';
}
/*
    foreach ($items as $row) {
        $msg=$row['item_num'].',"'.$row['item_name'].'",'.$row['vendor'].',';
        $msg.=$row['qty_2012'].','.$row['orders_2012'].','.$row['custom_2012'].',';
        $msg.=$row['qty_2013'].','.$row['orders_2013'].','.$row['custom_2013'].',';
        $msg.=$row['qty_2014'].','.$row['orders_2014'].','.$row['custom_2014'].',';
        $msg.=$row['qty_2015'].','.$row['orders_2015'].','.$row['custom_2015'].PHP_EOL;
        fwrite($fh, $msg);        
    }
    fclose($fh);

 */