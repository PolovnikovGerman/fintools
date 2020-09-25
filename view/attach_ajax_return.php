<?php
include_once('../controller/af_controller.php');
include_once ('../model/mysql.php');

$obj = new db();

$attachTitle=array('art'=>'Approved Artwork','poart'=>'Purchase Order','clay'=>'Clay pictures', 'prv'=>'Preview pictures');

if($_GET['q'] == 'display_art')
{
if($_GET['type']=='art' )
{
$qry = " select * from af_attach where att_ref = ".$_GET['ordid'];
$res = $obj->query($qry);
}
else if($_GET['type']=='poart' || $_GET['type'] == 'clay' || $_GET['type'] == 'prv' )
{
$qry = "select ch_po from af_child where ch_id = ".$_GET['chid'];
$res = $obj->query($qry);
$d = $obj->fetch($res);
$po = $d['ch_po'];

$qry = " select * from af_attach where att_ch = ".$_GET['chid']." and att_type = '".$_GET['type']."'";
if($obj->query($qry))
$res = $obj->query($qry);
}

if($_GET['perm'] == 'yes'){

$disp= "<table  width=\"100%\  cellpadding=\"0\" cellspacing=0><tr class=att_wrap_head><th >".$_GET['ordid'].$po." - ".$attachTitle[$_GET['type']]."</th><th align=right><img  onclick=\"hide('att_wrap')\"  src=\"../images/close.gif\"></th></tr>";
 while($data = $obj->fetch($res) )
 {
  $ord_id = $data['att_ref'];
  if($data['att_type'] == 'poart'){
  if($data['att_edit']!=0)
  $disp.="<tr id=att_".$data['att_id']." class=wrap_td ><td class=wrap_td><img  onclick=remove_tr('att_".$data['att_id']."','".$_GET['type']."',".$_GET['ordid'].",".$_GET['chid'].") src=\"../images/delete_icon.gif\"><a href=\"".$data['att_path']."?r=".rand(1, 200)."\" target=\"_blank\">&nbsp;&nbsp;".$data['att_name']."</a></td><td align=right class=wrap_td ><a href=\"TEMP_UI_EDIT.php?edit_PO=1&&oid=".$_GET['ordid']."&&chpo=".$po."&&chid=".$data['att_edit']."&&attid=".$data['att_id']."\" target=_blank>edit</a></td></tr>";
  else
  $disp.="<tr id=att_".$data['att_id']." class=wrap_td ><td class=wrap_td><img  onclick=remove_tr('att_".$data['att_id']."','".$_GET['type']."',".$_GET['ordid'].",".$_GET['chid'].") src=\"../images/delete_icon.gif\"><a href=\"".$data['att_path']."?r=".rand(1, 200)."\" target=\"_blank\">&nbsp;&nbsp;".$data['att_name']."</a></td><td align=right class=wrap_td >&nbsp;</td></tr>";
  }
   else
  $disp.="<tr id=att_".$data['att_id']." class=wrap_td ><td class=wrap_td><img  onclick=remove_tr('att_".$data['att_id']."','".$_GET['type']."',".$_GET['ordid'].",".$_GET['chid'].") src=\"../images/delete_icon.gif\"><a href=\"".$data['att_path']."?r=".rand(1, 200)."\" target=\"_blank\">&nbsp;&nbsp;".$data['att_name']."</a></td>
  			<td align=right class=wrap_td ></td></tr>";
 }
}//closing of if
else{
$disp= "<table  width=\"100%\  cellpadding=\"0\" cellspacing=0><tr class=att_wrap_head><th >".$_GET['ordid'].$po." - ".$attachTitle[$_GET['type']]."</th><th align=right><img  onclick=\"hide('att_wrap')\"  src=\"../images/close.gif\"></th></tr>";
 while($data = $obj->fetch($res) )
 {
  $ord_id = $data['att_ref'];
  if($data['att_type'] == 'poart')
  $disp.="<tr id=att_".$data['att_id']." class=wrap_td ><td class=wrap_td><a href=\"".$data['att_path']."?r=".rand(1, 200)."\" target=\"_blank\">&nbsp;&nbsp;".$data['att_name']."</a></td><td align=right class=wrap_td >&nbsp;</td></tr>";
   else
  $disp.="<tr id=att_".$data['att_id']." class=wrap_td ><td class=wrap_td><a href=\"".$data['att_path']."?r=".rand(1, 200)."\" target=\"_blank\">&nbsp;&nbsp;".$data['att_name']."</a></td>
  			<td align=right class=wrap_td ></td></tr>";
 }
}//closing of else

$disp.="</table>";
echo $disp;
}



if($_GET['q'] == 'remove_attach' )
{
 $qry = "select att_ch, att_type from af_attach where att_id =".substr($_GET['att_id'],4);
 $res = $obj->query($qry);
 $data = $obj->fetch($res);
 if($data['att_type'] == 'poart' && $data['att_ch'] > 0)
 {
 	$qry = "delete from af_attach where att_id = ".substr($_GET['att_id'],4);
	if($obj->query($qry)){
	//write code to unlink the file
	$qry = "update af_child set ch_placed_ck = 'no' where ch_id = ".$data['att_ch'];
	$obj->query($qry);
	$qry = "delete from af_r2_items where r2_id = ".$data['att_ch'];
	$obj->query($qry);


	 $poName = $obj->get_PONAME($data['att_ch']);

	//REMOVING ALL DATA FROM af_child IF THERE IS NO PO ATTACHED
	if($poName['ch_po'] == 'A')
	 $qry = "update af_child set ch_ship_date = '', ch_vendor = '', ch_placed_ck = 'no', ch_conf_ck = 'no', ch_ship_ck = 'no', ch_ship_notes = '', ch_cust_ck = 'no', ch_issue_ck = 'no', chn_claysent_ck = 'no', chn_clayapr_ck = 'no', chn_prvsent_ck = 'no', chn_prvapr_ck = 'no', chn_shipbt_ck = 'no', chn_shipbt_notes = '', ch_notes = '', ch_datetime = now(), ch_active = 'on', ch_claydoc_ck = 'no', ch_prvdoc_ck = 'no' where ch_id = ".$data['att_ch'];
	else
	 $qry = "update af_child set ch_ship_date = '', ch_vendor = '', ch_placed_ck = 'no', ch_conf_ck = 'no', ch_ship_ck = 'no', ch_ship_notes = '', ch_cust_ck = 'no', ch_issue_ck = 'no', chn_claysent_ck = 'no', chn_clayapr_ck = 'no', chn_prvsent_ck = 'no', chn_prvapr_ck = 'no', chn_shipbt_ck = 'no', chn_shipbt_notes = '', ch_notes = '', ch_datetime = now(), ch_active = 'off', ch_claydoc_ck = 'no', ch_prvdoc_ck = 'no' where ch_id = ".$data['att_ch'];

	$obj->query($qry);


	$qry = "delete from af_attach where att_ch = ".$data['att_ch']." and att_type != 'art'";
	$obj->query($qry);
	}

	}
else {
$qry = "delete from af_attach where att_id = ".substr($_GET['att_id'],4);
	if($obj->query($qry)){
	//write code to unlink the file
	$qry = "select * from af_attach where att_type='".$data['att_type']."' and att_ch = ".$data['att_ch'];
	$num = $obj->numrow($obj->query($qry));
	if($num==0){
	if($data['att_type'] == 'clay')
	$qry = "update af_child set ch_claydoc_ck = 'no' where ch_id = ".$data['att_ch'];
	else if($data['att_type'] == 'prv')
	$qry = "update af_child set ch_prvdoc_ck = 'no' where ch_id = ".$data['att_ch'];

	$obj->query($qry);
	}//closing of num=0
	}
	}
}

if($_GET['q'] == 'change_icon')
{
if($_GET['type'] == 'poart' || $_GET['type'] == 'clay' || $_GET['type'] == 'prv' )
{
$qry = "select * from af_attach where att_ch = ".$_GET['chid']." and att_type = '".$_GET['type']."'";
$res = $obj->query($qry);
echo $obj->numrow($res);
}
else
{
$qry = "select * from af_attach where att_ref = ".$_GET['ordid'];
$res = $obj->query($qry);
echo $obj->numrow($res);
}
}

if($_POST['q'] == 'reqChange')
{
$qry = "delete from af_attach where att_ch = ".$_POST['child']." and att_type = '".$_POST['type']."'";
$res = $obj->query($qry);
$qry = "update af_child set ch_".$_POST['type']."doc_ck = 'no' where ch_id = ".$_POST['child'];
$qry = $obj->query($qry);
$pp = $obj->get_email_data($_POST['child']);
			$par=array($pp['v_name'],'BT'.$pp['af_order_id'].$pp['chpo'],$_POST['msg'],'items'=>$pp['items']);
			if($_POST['type'] == 'clay'){
				$msg=emailTemplate('clayChange',$par);
				send_email_attach($pp['v_email'],'Clay Change needed for PO #BT'.$pp['af_order_id'].$ppT['chpo'],$msg,$arr,$arr2);
				}
			else if($_POST['type'] == 'prv'){
				$msg=emailTemplate('prvChange',$par);
				send_email_attach($pp['v_email'],'Preview Change needed for PO #BT'.$pp['af_order_id'].$ppT['chpo'],$msg,$arr,$arr2);
				}

}
// Show link on documents
if ($_POST['q'] == 'showpoart') {
    $response = array('errors' => 'Not Found');
    if ($_POST['type'] == 'art') {
        $qry = " select * from af_attach where att_ref = " . $_POST['ordid'];
        $res = $obj->query($qry);
    } else if ($_POST['type'] == 'poart' || $_POST['type'] == 'clay' || $_POST['type'] == 'prv') {
        $qry = "select ch_po from af_child where ch_id = " . $_POST['chid'];
        $res = $obj->query($qry);
        $d = $obj->fetch($res);
        $po = $d['ch_po'];

        $qry = " select * from af_attach where att_ch = " . $_POST['chid'] . " and att_type = '" . $_POST['type'] . "'";
        if ($obj->query($qry)) {
            $res = $obj->query($qry);
        }            
    }
    $urls=array();
    
    while ($data = $obj->fetch($res)) {
        $ord_id = $data['att_ref'];
        if ($data['att_type'] == 'poart') {
            $docurl=$data['att_path'] . "?r=" . rand(1, 200);
        } else {
            $docurl=$data['att_path'] . "?r=" . rand(1, 200);
        }
        array_push($urls, $docurl);            
    }
    $response['url'] = $urls;
    $response['errors'] = '';
    
    echo json_encode($response);

}
?>