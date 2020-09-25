<?php
// $curdir=__DIR__;
$curdir='/home/bluetrac/public_html/system';
include($curdir.'/model/mysql.php');
//
$db=new db();
$notplaced=array();
$notconfirmed=array();
$notshipped=array();
$custtrk=array();
$issues=array();
$artdept=array();
// Not placed
$min_order=32000;
// $min_order=30000;
$sql="select concat(a.af_order_id,'-',a.ch_po) as order_num, b.af_cust as customer, b.af_desc as order_item, b.af_rush_ck, a.ch_ship_date as ship_date,
    a.ch_vendor as vendor, a.ch_notes, a.ch_issue_ck
from af_child a
join af_master b  on b.af_order_id=a.af_order_id
where a.ch_active = 'on' and a.af_order_id >={$min_order}  and b.af_appr_ck = 'yes' and a.ch_placed_ck = 'no'  and a.ch_active = 'on' order by a.af_order_id";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $notplaced[]=array(
        'order_num'=>$data['order_num'],
        'ship_date'=>($data['ship_date']=='0000-00-00' ? '---' : date('m/d/Y', strtotime($data['ship_date']))),
        'rush'=>($data['af_rush_ck']=='yes' ? 1 : 0),
        'customer'=>$data['customer'],
        'order_item'=>$data['order_item'],
        'vendor'=>$data['vendor'],
        'issue'=>($data['ch_issue_ck']=='yes' ? $data['ch_notes'] : ''),
    );
}
// Issues
$sql="select concat(a.af_order_id,'-',a.ch_po) as order_num, b.af_cust as customer, b.af_desc as order_item, b.af_rush_ck, a.ch_ship_date as ship_date, a.ch_vendor as vendor
    , a.ch_notes
    from af_child a
join af_master b  on b.af_order_id=a.af_order_id
where a.ch_active = 'on' and a.af_order_id >={$min_order}  and b.af_appr_ck = 'yes'
    and a.ch_issue_ck = 'yes'  and a.ch_active = 'on' order by a.af_order_id";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $issues[]=array(
        'order_num'=>$data['order_num'],
        'ship_date'=>($data['ship_date']=='0000-00-00' ? '---' : date('m/d/Y', strtotime($data['ship_date']))),
        'rush'=>($data['af_rush_ck']=='yes' ? 1 : 0),
        'customer'=>$data['customer'],
        'order_item'=>$data['order_item'],
        'vendor'=>$data['vendor'],
        'issue'=>$data['ch_notes'],
    );
}
// Not Confirm
$sql="select concat(a.af_order_id,'-',a.ch_po) as order_num, b.af_cust as customer, b.af_desc as order_item, b.af_rush_ck, a.ch_ship_date as ship_date,
    a.ch_vendor as vendor, a.ch_notes, a.ch_issue_ck
from af_child a
join af_master b  on b.af_order_id=a.af_order_id
where a.ch_active = 'on' and a.af_order_id >={$min_order}  and b.af_appr_ck = 'yes'
and a.ch_placed_ck = 'yes' and a.ch_conf_ck = 'no'  and a.ch_active = 'on' order by a.ch_ship_date";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $notconfirmed[]=array(
        'order_num'=>$data['order_num'],
        'ship_date'=>($data['ship_date']=='0000-00-00' ? '---' : date('m/d/Y', strtotime($data['ship_date']))),
        'rush'=>($data['af_rush_ck']=='yes' ? 1 : 0),
        'customer'=>$data['customer'],
        'order_item'=>$data['order_item'],
        'vendor'=>$data['vendor'],
        'issue'=>($data['ch_issue_ck']=='yes' ? $data['ch_notes'] : ''),
    );
}
// Not Shipped
$sql="select concat(a.af_order_id,'-',a.ch_po) as order_num, b.af_cust as customer, b.af_desc as order_item, b.af_rush_ck, a.ch_ship_date as ship_date,
    a.ch_vendor as vendor, a.ch_notes, a.ch_issue_ck
from af_child a
join af_master b  on b.af_order_id=a.af_order_id
where a.ch_active = 'on' and a.af_order_id >={$min_order}  and b.af_appr_ck = 'yes'
and a.ch_placed_ck = 'yes' and a.ch_conf_ck = 'yes' and a.ch_ship_ck = 'no'  and a.ch_active = 'on' order by a.ch_ship_date";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $notshipped[]=array(
        'order_num'=>$data['order_num'],
        'ship_date'=>($data['ship_date']=='0000-00-00' ? '---' : date('m/d/Y', strtotime($data['ship_date']))),
        'rush'=>($data['af_rush_ck']=='yes' ? 1 : 0),
        'customer'=>$data['customer'],
        'order_item'=>$data['order_item'],
        'vendor'=>$data['vendor'],
        'issue'=>($data['ch_issue_ck']=='yes' ? $data['ch_notes'] : ''),
    );
}

// Cust TCK
$sql="select concat(a.af_order_id,'-',a.ch_po) as order_num, b.af_cust as customer, b.af_desc as order_item, b.af_rush_ck, a.ch_ship_date as ship_date,
    a.ch_vendor as vendor, a.ch_notes, a.ch_issue_ck
from af_child a
join af_master b  on b.af_order_id=a.af_order_id
where a.ch_active = 'on' and a.af_order_id >={$min_order}  and b.af_appr_ck = 'yes'
    and a.ch_placed_ck = 'yes' and a.ch_conf_ck = 'yes' and a.ch_ship_ck = 'yes'
    and a.ch_cust_ck = 'no'  and a.ch_active = 'on' order by a.ch_ship_date";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $custtrk[]=array(
        'order_num'=>$data['order_num'],
        'ship_date'=>($data['ship_date']=='0000-00-00' ? '---' : date('m/d/Y', strtotime($data['ship_date']))),
        'rush'=>($data['af_rush_ck']=='yes' ? 1 : 0),
        'customer'=>$data['customer'],
        'order_item'=>$data['order_item'],
        'vendor'=>$data['vendor'],
        'issue'=>($data['ch_issue_ck']=='yes' ? $data['ch_notes'] : ''),
    );
}
// In ART dept
$sql="select concat(a.af_order_id,'-',a.ch_po) as order_num, b.af_cust as customer, b.af_desc as order_item, b.af_rush_ck, a.ch_ship_date as ship_date,
    a.ch_vendor as vendor, a.ch_notes, a.ch_issue_ck
from af_child a
join af_master b  on b.af_order_id=a.af_order_id
where a.ch_active = 'on' and a.af_order_id >={$min_order}  and b.af_appr_ck = 'no' and a.ch_active = 'on' and b.af_cust!=''  order by b.af_order_id";
$res=$db->query($sql);
while($data = $db->fetch($res) ) {
    $artdept[]=array(
        'order_num'=>$data['order_num'],
        'ship_date'=>($data['ship_date']=='0000-00-00' ? '---' : date('m/d/Y', strtotime($data['ship_date']))),
        'rush'=>($data['af_rush_ck']=='yes' ? 1 : 0),
        'customer'=>$data['customer'],
        'order_item'=>$data['order_item'],
        'vendor'=>$data['vendor'],
        'issue'=>($data['ch_issue_ck']=='yes' ? $data['ch_notes'] : ''),
    );
}

$subjest=".NET Report - ".date('m/d/Y');

$adminemail='net@bluetrack.com';

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: .NET Admin <{$adminemail}>" . "\r\n";

$message = "<html><body><div style='clear:both; float:left; width:1200px;'>";
$message.='<div style="clear: both; float: left; font-size: 16px; font-weight: bold; text-align: center; width: 750px;">Daily report - orders in project stage '.date('m/d/Y H:i:s').'</div>';
if (count($notplaced)>0) {
    $message.=out_content($notplaced, 'Orders TO PLACE');
} else {
    $message.=out_emptycontent('No Orders TO PLACE');
}
if (count($notconfirmed)>0) {
    $message.=out_content($notconfirmed, 'Orders TO CONFIRM');
} else {
    $message.=out_emptycontent('No Orders TO CONFIRM');
}
if (count($notshipped)>0) {
    $message.=out_content($notshipped, 'Orders TO SHIP (Get Tracking #s)');
} else {
    $message.=out_emptycontent('No Orders TO SHIP');
}
if (count($custtrk)>0) {
    $message.=out_content($custtrk, ' Orders TO EMAIL CUSTOMER (Tracking #s)');
} else {
    $message.=out_emptycontent('No  Orders TO EMAIL CUSTOMER');
}
if (count($issues)>0) {
    $message.=out_content_issues($issues, 'Orders WITH ISSUES');
} else {
    $message.=out_emptycontent('No Orders WITH ISSUES');
}
if (count($artdept)>0) {
    $message.=out_content($artdept, 'Orders in ART DEPT');
} else {
    $message.=out_emptycontent('No Orders in ART DEPT');
}
// Finish body
$message .= "</div></body></html>";


$to='sage@bluetrack.com, darrell.martin@bluetrack.com, sean@bluetrack.com';
// $to='to_german@yahoo.com, sean@bluetrack.com';

$success = mail($to, $subjest, $message, $headers);
// echo $message; die();

if (!$success) {
    echo 'Mail Not sended'.PHP_EOL;
} else {
    echo 'Mail was sended successfully'.PHP_EOL;
}

function out_content_issues($data, $title) {
    $content='<div style="clear:both; float:left; width: 880px; border-top: 2px solid #000;height: 5px; margin-top:10px;">&nbsp;</div>';
    $content.='<div style="clear: both; float: left; font-size: 15px; font-weight: bold; margin: 5px 0; text-align: center; width:  880px;">'.$title.'</div>';
    $content.="<table width=880 border=1px solid #ccc align=left cellpadding=0 cellspacing=0 bgcolor=#E8E8E8 style='font-size:13px;'>";
    $content.="<thead style='font-weight:bold;'>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 40px;'>#</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 65px;'>Order #</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 175px;'>Customer</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 170px;'>Description</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 90px;'>Shipping Date</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 70px;'>Vendor</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 190px;'>Issue</td>
        </thead>";
    $numpp=1;
    foreach ($data as $row) {
        if ($row['rush']==1) {
            $content.="<tr style='background:none #ff2a00; height: 22px;'>";
        } else {
            $content.="<tr style='background:none #FFB132; height: 22px;'>";
        /*} else {
            $content.="<tr style='background:none ".($numpp%2==0 ? '#FFF' : '#CCC')."; height: 22px;'>";
        */}
        $content.="<td style='text-align:center; vertical-align:middle;'>{$numpp}</td>
            <td style='text-align:center; vertical-align:middle;'>{$row['order_num']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['customer']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['order_item']}</td>
            <td style='text-align:center; vertical-align:middle;'>{$row['ship_date']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['vendor']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['issue']}</td>
            </tr>";
        $numpp++;
    }
    $content.="</table>";
    return $content;
}

function out_emptycontent($title) {
    $content='<div style="clear: both; float: left; font-size: 15px; font-weight: bold; margin: 5px 0; text-align: center; width: 750px;">'.$title.'</div>';
    return $content;
}

function out_content($data, $title) {
    $content='<div style="clear: both; float: left; font-size: 15px; font-weight: bold; margin: 5px 0; text-align: center; width: 750px;">'.$title.'</div>';
    $content.="<table width=750 border=1px solid #ccc align=left cellpadding=0 cellspacing=0 bgcolor=#E8E8E8 style='font-size:13px;'>";
    $content.="<thead style='font-weight:bold;'>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 40px;'>#</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 65px;'>Order #</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 215px;'>Customer</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 200px;'>Description</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 90px;'>Shipping Date</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 90px;'>Vendor</td>
        <td style='text-align:center; vertical-align: middle; padding:5px; width: 190px;'>Issue</td>
        </thead>";
    $numpp=1;
    foreach ($data as $row) {
        if ($row['rush']==1) {
            $content.="<tr style='background:none #ff2a00; height: 22px;'>";
        } elseif ($row['issue']!='') {
            $content.="<tr style='background:none #FFB132; height: 22px;'>";
        } else {
            $content.="<tr style='background:none ".($numpp%2==0 ? '#FFF' : '#CCC')."; height: 22px;'>";
        }
        $content.="<td style='text-align:center; vertical-align:middle;'>{$numpp}</td>
            <td style='text-align:center; vertical-align:middle;'>{$row['order_num']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['customer']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['order_item']}</td>
            <td style='text-align:center; vertical-align:middle;'>{$row['ship_date']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['vendor']}</td>
            <td style='text-align:left; vertical-align:middle; padding: 0 5px;'>{$row['issue']}</td>
            </tr>";
        $numpp++;
    }
    $content.="</table>";
    return $content;
}
?>


