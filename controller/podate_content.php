<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
} else {
    include('../model/podate_model.php');
    include('../includes/utility_functions.php');
    
    $offset=$_POST['offset'];       
    $offset=intval($offset);
    $limit=$_POST['limit'];        
    $limit=intval($limit);
    $limit=($limit==0 ? 200 : $limit);

    $offset=$offset*$limit;

    /* Get Data about PO dates  */
    $po_dates=get_po_dates($limit,$offset);

    /* Get data about PO Orders in this time */        
    $po_data=get_pobydates($po_dates);        
    
    $data=array('po_data'=>$po_data,'po_dates'=>$po_dates);

    $content = po_date_content($data);
    $mdata=array('content'=>$content);
    $error='';
    ajaxResponse($mdata, $error);            
}
function po_date_content($data) {
    $content="";
    $po_dates=$data['po_dates'];
    $po_data=$data['po_data'];
    foreach ($po_dates as $drow) {
        $content.="<div class='po_daterow'>".date('D - m/d/y',strtotime($drow['order_date']))."</div>";
        $show_ar=$po_data[$drow['order_date']];        
        foreach ($show_ar as $row) {
            $content.="<div class='po_datarow'>";        
            $content.="<div class='vendor_name'>".$row['vendor']."</div>";
            $content.="<div class='po_number'>".$row['order_num']."</div>";
            $content.="<div class='po_open'>";
            
            // if($row['art_attrib'] == 'yes') {
                $content.="<span class='get_art_files' onclick=\"send_data(".$row['af_order_id'].",'poart','yes',".$row['ch_id'].",'".$row['ch_po']."');\">";
                $content.="<img class=point src=\"../images/open_icon.png\"/></span>";
            /* } else {
                //$content.="<span class=get_art_files onclick='send_data();'>";
                // $content.="<img src=\"../images/attch_icon.png\"/></span>";
                $content.="<span>NA</span>";                
            }*/
            $content.="</div>";
            /*
            <span id=icon_".$key_c[$point]['ch_id'][0]." onclick=send_data(".$key_c[$point]['af_order_id'][0].",'poart','yes',".$key_c[$point]['ch_id'][0].",'".$key_c[$point]['ch_po'][0]."')><img class=point src=\"../images/open_icon.png\"></span></span>";
            else 
            echo "<span id=icon_".$key_c[$point]['ch_id'][0]." onclick=send_data(".$key_c[$point]['af_order_id'][0].",'poart','yes',".$key_c[$point]['ch_id'][0].",'".$key_c[$point]['ch_po'][0]."') class=point ><img src=\"../images/attch_icon.png\"></span>";
             
             */
            $content.='</div>';
        }
    }
    return $content;
}

?>
