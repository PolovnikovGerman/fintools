<?php
include('../model/mysql.php');
$obj = new db();
$qry = "select ld.leadID, ld.leadDateCreated, ld.leadCompany, ld.leadName, ld.leadPhone, ld.leadEmail, ld.leadQty, 
ld.leadItem, ld.leadType, ld.leadStatus, ld.leadNeedBy, ld.leadNotes, ld.leadDateTime, lh.cnt_history, lu.userID
from leaddata ld 
left join (select leadID, count(lhID) as cnt_history from leadshistory group by leadID) lh on lh.leadID=ld.leadID
left join leaduser lu on lu.leadId=ld.leadID";
$res = $obj->query($qry);
$results=array();
while($data = $obj->fetch($res) )
{
    $results[]=$data;
}
$nlead='';
$leads=array();
foreach ($results as $row) {
    if ($nlead!=$row['leadID']) {
        switch ($row['leadType']) {
            case 1:
                $type='Priority';
                break;
            case 2:
                $type='Open';
                break;
            case 3: 
                $type='Dead';
                break;
            case 4:
                $type='Closed';
                break;
            default:
                break;
        }        
        $nlead=$row['leadID'];
        $row['lead_note']=  htmlspecialchars($row['lead_note']);
        $leads[]=array(
            'lead_create'=>strtotime($row['leadDateCreated']),
            'lead_company'=>($row['leadCompany']=='' ? ' ' : $row['leadCompany']),
            'lead_customer'=>($row['leadName']=='' ? ' ' : $row['leadName']),
            'contact_phone'=>($row['leadPhone']=='' ? ' ' : $row['leadPhone']),
            'lead_qty'=>($row['leadQty']=='' ? ' ' : $row['leadQty']),
            'lead_item'=>($row['leadItem']=='' ? ' ' : $row['leadItem']),
            'lead_type'=>$type,
            'lead_status'=>($row['leadStatus']=='' ? ' ' : $row['leadStatus']),
            'lead_needby'=>($row['leadNeedBy']=='' ? ' ' : $row['leadNeedBy']),
            'lead_note'=>($row['leadNotes']=='' ? ' ' : $row['leadNotes']),
            'lead_datetime'=>($row['leadDateTime']=='' ? 0 : strtotime($row['leadDateTime'])),
            'cnt_history'=>intval($rrow['cnt_history']),
            'unsign'=>'no',
            'sean'=>'no',
            'sage'=>'no',
            'nick'=>'no',
            'lisa'=>'no',
            'cris'=>'no',            
            'other'=>'no',
        );
        $lead_idx=count($leads)-1;        
    }
    switch ($row['userID']) {
        case 0:
            $leads[$lead_idx]['unsign']='yes';
            break;
        case 1: 
            $leads[$lead_idx]['sean']='yes';
            break;
        case 2:
            $leads[$lead_idx]['sage']='yes';
            break;
        case 4:
            $leads[$lead_idx]['nick']='yes';
            break;
        case 8:
            $leads[$lead_idx]['lisa']='yes';
            break;
        case 12:
            $leads[$lead_idx]['cris']='yes';
        default:
            $leads[$lead_idx]['other']='yes';
            break;
    }
}
$filename='../uploads/leads_export_'.date('Y-m-d').'_'.date('H_i_s').'.csv';
$fh=fopen($filename,'w');
if ($fh) {
    /* Title */
    $row='Lead Create Date;Company;Customer;Phone;QTY;Item;Type;Status;Need By;Lead Note;Last Update;# Rec in History;';
    $row.='Unsigned;Sean;Sage;Nick;Lisa;Cris;Other;'.PHP_EOL;
    fwrite($fh, $row);
    foreach ($leads as $row) {        
        $str=($row['lead_create']>0 ? date('m/d/Y',$row['lead_create']) : '').';"'.$row['lead_company'].'";"'.$row['lead_customer'].'";"';
        $str.=$row['contact_phone'].'";"'.$row['lead_qty'].'";"'.$row['lead_item'].'";"'.$row['lead_item'].'";'.$row['lead_type'].';"';
        $str.=$row['lead_status'].'";"'.$row['lead_needby'].'";"'.$row['lead_note'].'";'.$row['cnt_history'].';'.($row['lead_datetime']>0 ? date('m/d/Y H:i:s',$row['lead_datetime']) : '').';';
        $str.=$row['unsign'].';'.$row['sean'].';'.$row['sage'].';'.$row['nick'].';'.$row['lisa'].';'.$row['cris'].';'.$row['unsign'].';'.PHP_EOL;
        fwrite($fh, $str);
    }
    fclose($fh);
    echo json_encode(array('errors'=>'','url'=>$filename));
} else {
    echo json_encode(array('errors'=>'Can\t save export file','url'=>''));
}

?>
