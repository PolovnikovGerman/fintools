<?php
include('../model/mysql.php');
$obj = new db();
$results=array();
$qry = "select m.af_order_id as order_num, af_cust as customer, m.af_desc as order_item, m.af_date as order_date, m.af_art_ck as order_art,
m.af_redraw_ck as order_redraw, m.af_vector_ck as order_vect, m.af_proof_ck as order_proof, m.af_appr_ck as order_approve, m.af_notes as order_note,
a.att_path, a.att_name, a.att_datetime 
from af_master m
left join af_attach a on a.att_ref=m.af_order_id 
where a.att_type='art'
order by m.af_order_id desc";
$res = $obj->query($qry);
while($data = $obj->fetch($res) ) {
    $results[]=$data;    
}
$art=array();
$norder='';
foreach ($results as $row) {
    if ($norder!=$row['order_num']) {
        $norder=$row['order_num'];
        $att_idx=1;
        $art[]=array(
            'order_num'=>$row['order_num'],
            'customer'=>$row['customer'],
            'order_item'=>$row['order_item'],
            'order_date'=>strtotime($row['order_date']),
            'order_note'=>($row['order_note']=='' ? ' ': $row['order_note']),
            'order_art'=>$row['order_art'],
            'order_redraw'=>$row['order_redraw'],
            'order_vect'=>$row['order_vect'],
            'order_proof'=>$row['order_proof'],
            'order_approve'=>$row['order_approve'],
            'attach_path_1'=>'',
            'attach_name_1'=>'',
            'attach_time_1'=>'',
            'attach_path_2'=>'',
            'attach_name_2'=>'',
            'attach_time_2'=>'',
            'attach_path_3'=>'',
            'attach_name_3'=>'',
            'attach_time_3'=>'',
            'attach_path_4'=>'',
            'attach_name_4'=>'',
            'attach_time_4'=>'',
            'attach_path_5'=>'',
            'attach_name_5'=>'',
            'attach_time_5'=>'',
            'attach_path_6'=>'',
            'attach_name_6'=>'',
            'attach_time_6'=>'',
            'attach_path_7'=>'',
            'attach_name_7'=>'',
            'attach_time_7'=>'',
            'attach_path_8'=>'',
            'attach_name_8'=>'',
            'attach_time_8'=>'',
            'attach_path_9'=>'',
            'attach_name_9'=>'',
            'attach_time_9'=>'',
            'attach_path_10'=>'',
            'attach_name_10'=>'',
            'attach_time_10'=>'',
            'attach_path_11'=>'',
            'attach_name_11'=>'',
            'attach_time_11'=>'',            
        );
        $art_idx=count($art)-1;        
    }
    $art[$art_idx]['attach_path_'.$att_idx]=$row['att_path'];
    $art[$art_idx]['attach_name_'.$att_idx]=$row['att_name'];
    $art[$art_idx]['attach_time_'.$att_idx]=strtotime($row['att_datetime']);
    $att_idx++;
}
$filename='../uploads/art_export_'.date('Y-m-d').'_'.date('H_i_s').'.csv';
$fh=fopen($filename,'w');
if ($fh) {
    /* Title */
    $row='Order #;Order Date;Customer;Order Item;Order Note;Art Check;Redraw Check;Vector Check;Order Proof;Order Approve;';
    for ($i=1; $i<=11; $i++) {
        $row.='Attach '.$i.' File;Attach '.$i.' name;Attach '.$i.' Time;';        
    }
    $row.=PHP_EOL;
    
    fwrite($fh, $row);
    foreach ($art as $row) {        
        $str=$row['order_num'].';'.($row['order_date']>0 ? date('m/d/Y',$row['order_date']) : '').';'.$row['customer'].';'.$row['order_item'].';'.$row['order_note'].';';
        $str.=$row['order_art'].';'.$row['order_redraw'].';'.$row['order_vect'].';'.$row['order_proof'].';'.$row['order_approve'].';';
        for ($i=1; $i<=11; $i++) {
            if (empty($row['attach_name_'.$i])) {
                $str.=' ; ; ;';
            } else {
                $str.=$row['attach_path_'.$i].';'.$row['attach_name_'.$i].';'.($row['attach_time_'.$i]>0 ? date('m/d/Y H:i:s') : '').';';
            }
        }
        $str.=PHP_EOL;
        fwrite($fh, $str);
    }
    fclose($fh);
    echo json_encode(array('errors'=>'','url'=>$filename));
} else {
    echo json_encode(array('errors'=>'Can\t save export file','url'=>''));
}

?>
