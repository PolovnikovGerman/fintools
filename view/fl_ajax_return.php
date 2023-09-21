<?php

include_once('../controller/fl_controller.php');
include_once ('../model/mysql.php');
// include('../includes/firephp.php');

$obj = new db();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($_GET['q'] == 'update_master') {
    if ($_GET['ven'] == '0')
        $qry = "update af_master set af_cust = '', af_desc = '' where af_order_id = " . $_GET['ord'];
    else
        $qry = "update af_master set af_cust = '" . $_GET['cust'] . "', af_desc = '" . $_GET['dsc'] . "' where af_order_id = " . $_GET['ord'];
    if ($obj->query($qry)) {
        /*
          if($_GET['ven'] == '0')
          {
          $d1='';
          $d2='';
          $d3='';
          $d4='';
          $d5='';
          $d6='';
          $qry = "update af_child set ch_ship_date = '2090-12-30', ch_vendor = '', ch_ship_notes = '', ch_notes= '' where ch_id = ".$_GET['chid'];
          }
          else
          { */
        $d1 = $_GET['cust'];
        $d2 = $_GET['dsc'];
        $d3 = $_GET['notes'];
//$d4=$_GET['ven'];
//$d5=format_date($_GET['shdate']);
        $d6 = $_GET['shnotes'];
        $qry = "update af_child set  ch_ship_notes = '" . $_GET['shnotes'] . "', ch_notes= '" . $_GET['notes'] . "' where ch_id = " . $_GET['chid'];
//}
        if ($obj->query($qry)) {

            $ret = array('one' => $d1, 'two' => $d2, 'three' => $d3, 'six' => $d6);
            //echo "{\"firstResponse\":".$d1.",\"secondResponse\":".$d2."}";
            echo json_encode($ret);
        }
    } else
        echo "Error";
}


if ($_GET['q'] == 'update_child') {

    if ($_GET['ven'] == '0')
        $qry = "update af_child set ch_ship_date = '2090-12-30', ch_vendor = '', ch_ship_notes = '', ch_notes= '' where ch_id = " . $_GET['chid'];
    else
        $qry = "update af_child set ch_ship_notes = '" . $_GET['shnotes'] . "', ch_notes= '" . $_GET['notes'] . "', ch_active = 'on' where ch_id = " . $_GET['chid'];


    if ($obj->query($qry)) {
        /* if($_GET['ven']=='0')
          {
          $d1='';     $d2='';    $d3='';    $d4='';
          }
          else
          { */
        $d1 = $_GET['notes'];     //$d2=$_GET['ven'];     //$d3=format_date($_GET['shdate']);
        $d4 = $_GET['shnotes'];
//}
        $ret = array('one' => $d1, 'four' => $d4);
        //echo "{\"firstResponse\":".$d1.",\"secondResponse\":".$d2."}";
        echo json_encode($ret);
    } else
        echo "Error";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
if ($_GET['q'] == 'toggle') {

    $qry = " update af2_master set " . $_GET['col'] . " = '" . $_GET['state'] . "' where af_order_id = " . $_GET['ord'];
    if ($obj->query($qry))
        echo $_GET['state'];
    else
        echo "false";
}

if ($_GET['q'] == 'child_toggle') {

    $qry = " update af_child set " . $_GET['col'] . " = '" . $_GET['state'] . "' where ch_id = " . $_GET['chid'];
    if ($obj->query($qry)) {

        //WHILE PUTTING THE EMAIL TEMPLATES LIVE DONT FORGET TO ADD VENDORS ADDRESS ITS IN THE PP ARRAY
        if ($_GET['col'] == 'chn_clayapr_ck' && $_GET['state'] == 'yes') {
            $pp = $obj->get_email_data($_GET['chid']);
            $par = array($pp['v_name'], 'BT' . $pp['af_order_id'] . $pp['chpo'], 'items' => $pp['items']);
            $msg = emailTemplate('clayApproved', $par);
            send_email_attach($pp['v_email'], 'Clay approved for #BT' . $pp['af_order_id'] . $ppT['chpo'], $msg, $arr, $arr2);
        } else if ($_GET['col'] == 'chn_prvapr_ck' && $_GET['state'] == 'yes') {
            $pp = $obj->get_email_data($_GET['chid']);
            $par = array($pp['v_name'], 'BT' . $pp['af_order_id'] . $pp['chpo'], 'items' => $pp['items']);
            $msg = emailTemplate('prvApproved', $par);
            send_email_attach($pp['v_email'], 'Preview approved for #BT' . $pp['af_order_id'] . $ppT['chpo'], $msg, $arr, $arr2);
        }

        echo $_GET['state'];
    } else
        echo "false";
}

if ($_GET['q'] == 'getven') {
    $qry = "select * from af_vendor";
    $res = $obj->query($qry);
    $ret = "<select  id=" . $_GET['hr'] . $_GET['val'] . ">";
    if (!empty($_GET['v_v']))
        $ret.="<option value=" . $_GET['v_v'] . " selected=\"selected\">" . $_GET['v_v'] . "</option>";
    else
        $ret.="<option></option>";
    while ($data = $obj->fetch($res)) {
        if ($_GET['v_v'] != $data['v_abbr'])
            $ret.="<option value=" . $data['v_abbr'] . ">" . $data['v_abbr'] . "</option>";
    }
    $ret.="<option onclick='new_ven()'>new</option>";
    $ret.="<option value=0 class=red><span class=red>-clear-</span></option></select>";
    echo $ret;
}

if (isset($_POST['q']) && $_POST['q'] == 'getFullAf') {
    $qry = "select  af_cust, af_desc, ch_ship_notes, ch_notes from af_master a, af_child b where a.af_order_id = b.af_order_id and ch_id = " . $_POST['val'];
    $res = $obj->query($qry);
    $data = $obj->fetch($res);
    $ret = array('custName' => $data['af_cust'], 'custDesc' => $data['af_desc'], 'shipnotes' => $data['ch_ship_notes'], 'notes' => $data['ch_notes']);
    echo json_encode($ret);
}


if (isset($_POST['q']) && $_POST['q'] == 'getFullChn') {
    $qry = "select  ch_ship_notes, ch_notes from af_child where ch_id = " . $_POST['id'];
    $res = $obj->query($qry);
    $data = $obj->fetch($res);
    $ret = array('shipNotes' => $data['ch_ship_notes'], 'chnNotes' => $data['ch_notes']);
    echo json_encode($ret);
}




if (isset($_GET['q']) && $_GET['q'] == 'getvendetails') {
    $qry = "select * from af_vendor where v_id = " . $_GET['val'];
    $res = $obj->query($qry);
    $data = $obj->fetch($res);
    echo json_encode($data);
}

if (isset($_GET['q']) && $_GET['q'] == 'getitemdetails') {
    $qry = "select * from af_items where i_itemid = '" . $_GET['val'] . "'";
    $res = $obj->query($qry);
    $data = $obj->fetch($res);

    echo json_encode($data);
}

if (isset($_POST['q']) && $_POST['q'] == 'get_item_notes') {
    $qry = "select i_oth_ven from af_items where i_itemid = '" . $_POST['id'] . "'";
    $res = $obj->query($qry);
    $data = $obj->fetch($res);
    echo json_encode($data);
}

if (isset($_POST['q']) && $_POST['q'] == 'save_vendors' && is_numeric($_POST['val'])) {
    $qry = "select * from af_vendor where v_id!= " . $_POST['val'] . " and v_email = '" . strtolower($_POST['email']) . "'";
    $data = $obj->fetch($obj->query($qry));
    $qry = "select * from af_vendor where v_id!= " . $_POST['val'] . " and v_abbr = '" . strtolower($_POST['abbr']) . "'";
    $data2 = $obj->fetch($obj->query($qry));


    if ($data['v_email'] == strtolower($_POST['email']) && $data2['v_abbr'] == strtolower($_POST['abbr']))
        echo 3;
    else if ($data['v_email'] == strtolower($_POST['email']))
        echo 1;
    else if ($data2['v_abbr'] == strtolower($_POST['abbr']))
        echo 2;
    else {
        $qry = "update af_vendor set v_name = '" . $_POST['name'] . "' , v_abbr = '" . strtolower(substr($_POST['abbr'], 0, 7)) . "' ,
    v_email = '" . strtolower($_POST['email']) . "' ,
    v_additional_email = '" . strtolower($_POST['addemail']) . "' ,
    v_type = '" . $_POST['type'] . "' , v_address = '" . $_POST['address'] . "' , v_memos = '" . $_POST['memos'] . "' , v_phone = '" . $_POST['phone'] . "' , v_datetime = 'now()' where v_id = " . $_POST['val'];
        if ($obj->query($qry))
            echo $_POST['val'];
    }
}

if (isset($_POST['q']) && $_POST['q'] == 'addNewVendor') {
    $qry = "select * from af_vendor where v_email = '" . strtolower($_POST['email']) . "'";
    $data = $obj->fetch($obj->query($qry));
    $qry = "select * from af_vendor where v_abbr = '" . strtolower($_POST['abbr']) . "'";
    $data2 = $obj->fetch($obj->query($qry));

    if ($data['v_email'] == strtolower($_POST['email']) && $data2['v_abbr'] == strtolower($_POST['abbr']))
        echo 3;
    else if ($data['v_email'] == strtolower($_POST['email']))
        echo 1;
    else if ($data2['v_abbr'] == strtolower($_POST['abbr']))
        echo 2;
    else {
        $pwd = generatePassword();
        $qry = "insert into af_vendor values(null, '" . $_POST['name'] . "', '" . strtolower(substr($_POST['abbr'], 0, 7)) . "', '" . strtolower($_POST['email']) . "', '" . strtolower($_POST['addemail']) . "',  '$pwd', '" . $_POST['type'] . "', '" . $_POST['address'] . "', '" . $_POST['memos'] . "', '" . $_POST['phone'] . "', now())";
        $obj->query($qry);
        $lastid = mysqli_insert_id();
        $ar = array($_POST['name'], strtolower($_POST['email']), $pwd);
        $msg = emailTemplate('emailPassword', $ar);
        send_email_TEXT(strtolower($_POST['email']), 'Vendor Access into BLUETRACK System', $msg);
        echo $lastid;
    }
}





if (isset($_POST['q']) && $_POST['q'] == 'post_history' && is_numeric($_POST['cid'])) {
    $date = date("m/d/y");
    $time = date("G:i");
    $qry = "insert into r2_history values(null," . $_POST['cid'] . ",'" . $_POST['msg'] . "','" . $_SESSION['screenname'] . "',now())";
    if ($obj->query($qry))
        echo "<tr><td><b>" . $_SESSION['screenname'] . " - $date - $time</b></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;" . $_POST['msg'] . "</td></tr>";
    else
        echo "Error";
}

if (isset($_POST['q']) && $_POST['q'] == 'save_ff_items') {

    $qry = "update af_items set i_itemid = '" . $_POST['itemid'] . "', i_desc = '" . $_POST['desc'] . "', i_price = " . $_POST['price'] . ", i_ven = '" . $_POST['ven'] . "', i_oth_ven = '" . $_POST['notes'] . "' where i_id = " . $_POST['id'];
    if ($obj->query($qry)) {
        $qry = "select * from af_items where i_id = " . $_POST['id'];
        $res = $obj->query($qry);
        $data = $obj->fetch($res);
        echo json_encode($data);
    } else
        echo 0;
}

if (isset($_POST['q']) && $_POST['q'] == 'update_chn') {
    $qry = "update af_child set ch_ship_notes = '" . $_POST['shipCust'] . "' , ch_notes = '" . $_POST['notes'] . "' where ch_id = " . $_POST['child'];
    $obj->query($qry);
    $qry = "select ch_ship_notes, ch_notes from af_child where ch_id = " . $_POST['child'];
    $data = $obj->fetch($obj->query($qry));
    echo json_encode($data);
}
if (isset($_GET['q']) && $_GET['q'] == 'getsendsbefore') {
    $chid = $_GET['val'];
    $retarray = array(
        'result' => 0,
        'msg' => 0,
    );
    if (intval($chid) > 0) {
        // Receive ChID - check - that file was sended before
        $qry = "select * from af_attach where att_ch=" . $chid . " and att_type='poart' limit 1";
        $res = $obj->query($qry);
        $data = $obj->fetch($res);
        if (isset($data['att_id'])) {
            $retarray['result'] = 1;
            $retarray['msg'] = 'File ' . $data['att_name'] . ' was send ' . date('m/d/Y H:i:s', strtotime($data['att_datetime']));
        }
    }
    echo json_encode($retarray);
}
if (isset($_POST['q']) && $_POST['q'] == 'searchfullfilm') {
    $retarray = array(
        'error' => '',
    );
    $order_num = $_POST['order_num'];
    $vendor = strtoupper($_POST['vendor']);
    $item = strtoupper($_POST['item']);
    $orders = $_POST['orders'];
    $startord = 22000;
    $endord = 22500;
    if ($orders != 0) {
        $startord = $orders;
        $endord = $orders + 500;
    }    
    // get data
    $qry = "select * from af_child a, af_master b where a.af_order_id = b.af_order_id and a.ch_active = 'on'";
    $attachqry = "select attch.* from af_attach attch, af_master b, af_child a where a.ch_active = 'on' and a.af_order_id = b.af_order_id";
    $attachqry.=" and ((attch.att_type = 'poart' and attch.att_ch=b.af_order_id) or (attch.att_type = 'art' and attch.att_ref=b.af_order_id)) ";
    if (!empty($order_num)) {
        $qry.=" and b.af_order_id like '%{$order_num}%' ";
        $attachqry.=" and b.af_order_id like '%{$order_num}%' ";
    } else {
        $qry.=" and a.af_order_id >= {$startord} and a.af_order_id <= {$endord} ";
        $attachqry.=" and a.af_order_id >= {$startord} and a.af_order_id <= {$endord} ";
    }
    if (!empty($vendor)) {
        $qry.=" and upper(a.ch_vendor) like '%{$vendor}%' ";
        $attachqry.=" and upper(a.ch_vendor) like '%{$vendor}%' ";
    }
    if (!empty($item)) {
        $qry.=" and upper(b.af_desc) like '%{$item}%' ";
        $attachqry.=" and upper(b.af_desc) like '%{$item}%' ";
    }    
    $qry.=" order by a.af_order_id " . $_SESSION['sort'] . " , a.ch_po";
    $attachqry.=" order by a.af_order_id " . $_SESSION['sort'] . " , a.ch_po";
    $res = $obj->query($qry);
    $temp = 0;
    $key_c = array();
    while ($data = $obj->fetch($res)) {
        $val = $data['af_order_id'];
        if ($temp != $val) {
            $key_c['1']['1'][] = $val;
            $temp = $val;
        }
        $key_c[$val]['af_cust'][] = $data['af_cust'];
        $key_c[$val]['af_desc'][] = $data['af_desc'];
        $key_c[$val]['af_appr_ck'][] = $data['af_appr_ck'];
        $key_c[$val]['clr_appr'][] = ($data['af_appr_ck'] == 'yes') ? '#59b75b' : '';
        $key_c[$val]['af_datetime'][] = $data['af_datetime'];
        $key_c[$val]['ch_id'][] = $data['ch_id'];
        $key_c[$val]['ch_ship_date'][] = ($data['ch_ship_date'] == '2090-12-30' || $data['ch_ship_date'] == '0000-00-00') ? '' : $data['ch_ship_date'];
        $key_c[$val]['ch_ship'][] = (($data['ch_ship_date'] != '2090-12-30' && $data['ch_ship_date'] != '0000-00-00' && $data['ch_ship_date'] != '') || $data['ch_placed_ck'] == 'yes') ? '#ff2a00' : '';
        $key_c[$val]['af_order_id'][] = $data['af_order_id'];
        $key_c[$val]['ch_po'][] = $data['ch_po'];
        $key_c[$val]['ch_vendor'][] = $data['ch_vendor'];
        $key_c[$val]['clr_ven'][] = ($data['ch_vendor'] != '' || $data['ch_placed_ck'] == 'yes') ? '#ff2a00' : '';
        $key_c[$val]['ch_placed_ck'][] = $data['ch_placed_ck'];
        $key_c[$val]['clr_pl'][] = ($data['ch_placed_ck'] == 'yes') ? '#ff2a00' : '';
        $key_c[$val]['ch_conf_ck'][] = $data['ch_conf_ck'];
        $key_c[$val]['clr_conf'][] = ($data['ch_conf_ck'] == 'yes') ? '#ff2a00' : '';
        $key_c[$val]['ch_cust_ck'][] = $data['ch_cust_ck'];
        $key_c[$val]['clr_cust'][] = ($data['ch_cust_ck'] == 'yes') ? '#ff2a00' : '';

        $key_c[$val]['ch_ship_ck'][] = $data['ch_ship_ck'];
        $key_c[$val]['clr_ship'][] = ($data['ch_ship_ck'] == 'yes') ? '#ff2a00' : '';

        $key_c[$val]['ch_ship_notes'][] = $data['ch_ship_notes'];
        $key_c[$val]['ch_issue_ck'][] = $data['ch_issue_ck'];
        $key_c[$val]['clr_is'][] = ($data['ch_issue_ck'] == 'yes') ? '#fdae03' : '';
        $key_c[$val]['ch_notes'][] = $data['ch_notes'];
        $key_c[$val]['ch_datetime'][] = $data['ch_datetime'];
    }
    // Get attached docs
    
    // Build content
    $attres = $obj->query($attachqry);
    $att = array();
    while ($data = $obj->fetch($attres)) {
        $order_id = $data['att_ref'];
        $ch_id = $data['att_ch'];
        if ($data['att_type'] == 'art') {
            $att['art'][$order_id] = 'yes';
        } else {
            $att['poart'][$ch_id] = 'yes';
        }
    }
    // Build content
    $retarray['content']=_outfullfilmentpage($key_c, $att);
    /**/
    echo json_encode($retarray);
}

function _outfullfilmentpage($key_c, $att) {
    $content = "";
    for ($i = 0; $i < sizeof($key_c['1']['1']); $i++) {
        $point = $key_c['1']['1'][$i];
        $content.="<div>";
        $content.="<table width=970px border=0 cellpadding=0 cellspacing=0 class=task_today_entry >";
        $content.="<tr " . col_bg('#ececec', $i) . " class=hilite>";
        $content.="<td width=\"45px\" class=tdbg  align=center  >" . $key_c[$point]['af_order_id'][0] . "</td>";
        $content.="<td width=\"120px\"   align=\"center\" id=af_cust$i class=\"tdbg small_font\" ondblclick=edit_af($i," . $key_c[$point]['af_order_id'][0] . "," . $key_c[$point]['ch_id'][0] . ")><a class=info href=#>" . substr($key_c[$point]['af_cust'][0], 0, 19) . "<span>" . $key_c[$point]['af_cust'][0] . "</span></a></td>";
        $content.="<td width=\"115px\" class=\"tdbg small_font\"    align=\"center\" id=af_desc$i  ondblclick=edit_af($i," . $key_c[$point]['af_order_id'][0] . "," . $key_c[$point]['ch_id'][0] . ")><a class=info href=#>" . substr($key_c[$point]['af_desc'][0], 0, 19) . "<span>" . $key_c[$point]['af_desc'][0] . "</span></a></td>";

        $content.="<td width=\"35px\"  align=\"center\"  bgcolor=\"" . $key_c[$point]['clr_appr'][0] . "\"     ><input type=checkbox onclick=\"return false\" name=af_appr_ck ";
        if ($key_c[$point]['af_appr_ck'][0] == 'yes') {
            $content.=" checked value=yes ></td>";
        } else {
            $content.=" value=no ></td>";            
        }
        $content.="<td width=\"35px\" class=tdbg align=\"center\" >";
        if ($att['art'][$key_c[$point]['af_order_id'][0]] == 'yes') {
            $content.="<span class=get_art_files id=" . $key_c[$point]['af_order_id'][0] . "  onclick=send_data(" . $key_c[$point]['af_order_id'][0] . ",'art','no'," . $key_c[$point]['ch_id'][0] . ",'" . $key_c[$point]['ch_po'][0] . "')><img class=point src=\"../images/open_icon.gif\"></span></span>";
        } else {
            $content.="<span>NA</span>";
        }
        $content.="</td>";
        $content.="<td width=\"70px\"   align=\"center\" id=af_shdate$i bgcolor=\"" . $key_c[$point]['ch_ship'][0] . "\"  ondblclick=edit_af($i," . $key_c[$point]['af_order_id'][0] . "," . $key_c[$point]['ch_id'][0] . ")>" . print_date($key_c[$point]['ch_ship_date'][0]) . "</td>";
        if (sizeof($key_c[$point]['af_order_id']) == 1) {
            $content.="<td width=\"35px\" bgcolor=\"" . $key_c[$point]['clr_ven'][0] . "\" id=af_po$i align=\"center\"><span onclick=add_PO($i," . $key_c[$point]['ch_id'][0] . ",'$po_title[0]'," . $key_c[$point]['af_order_id'][0] . ")>A</span></td>";            
        } else {
            $content.="<td width=\"35px\" id=af_po$i bgcolor=\"" . $key_c[$point]['clr_ven'][0] . "\" align=\"center\">A</td>";            
        }
        $content.="<td width=\"75px\" align=\"center\"  bgcolor=\"" . $key_c[$point]['clr_ven'][0] . "\"  id=af_ven$i  ondblclick=edit_af($i," . $key_c[$point]['af_order_id'][0] . "," . $key_c[$point]['ch_id'][0] . ")>" . $key_c[$point]['ch_vendor'][0] . "</td>";

        $content.="<td align=\"center\"    width=\"35px\">";
        if ($att['poart'][$key_c[$point]['ch_id'][0]] == 'yes') {
            $content.="<span class=get_art_files id=" . $key_c[$point]['ch_id'][0] . "><span id=icon_" . $key_c[$point]['ch_id'][0] . " onclick=send_data(" . $key_c[$point]['af_order_id'][0] . ",'poart','yes'," . $key_c[$point]['ch_id'][0] . ",'" . $key_c[$point]['ch_po'][0] . "')><img class=point src=\"../images/open_icon.png\"></span></span>";
        } else {
            $content.="<span id=icon_" . $key_c[$point]['ch_id'][0] . " onclick=send_data(" . $key_c[$point]['af_order_id'][0] . ",'poart','yes'," . $key_c[$point]['ch_id'][0] . ",'" . $key_c[$point]['ch_po'][0] . "') class=point ><img src=\"../images/attch_icon.png\"></span>";
        }
        $content.="</td>";
        $content.="<td align=\"center\"  bgcolor=\"" . $key_c[$point]['clr_conf'][0] . "\"  width=\"35px\"
			 id=ch_conf_ck" . $key_c[$point]['ch_id'][0] . ">
			 <input type=checkbox
			 onclick=\"child_toggle(" . $key_c[$point]['ch_id'][0] . ",this,$i,'ch_conf_ck')\"
			 id=_conf" . $key_c[$point]['ch_id'][0] . "
			 name=ch_conf_ck ";
        if ($key_c[$point]['ch_conf_ck'][0] == 'yes') {
            $content.=" checked value=yes ></td>";
        } else {
            $content.=" value=no ></td>";
        }
        $content.="<td align=\"left\"  bgcolor=\"" . $key_c[$point]['clr_ship'][0] . "\" width=\"100px\"
			ondblclick=edit_af($i," . $key_c[$point]['af_order_id'][0] . "," . $key_c[$point]['ch_id'][0] . ")
			id=ch_ship_ck" . $key_c[$point]['ch_id'][0] . ">
			<input type=checkbox
			onclick=\"child_toggle(" . $key_c[$point]['ch_id'][0] . ",this,$i,'ch_ship_ck')\"
			id=_ship" . $key_c[$point]['ch_id'][0] . "
			name=ch_ship_ck ";
        if ($key_c[$point]['ch_ship_ck'][0] == 'yes') {
            $content.=" checked value=yes >";
        } else {
            $content.=" value=no >";
        }
        $content.="<span id=af_shnotes$i  >" . substr($key_c[$point]['ch_ship_notes'][0], 0, 10) . "</span></td>";

        $content.="<td  class=tdbg align=\"center\" bgcolor=\"" . $key_c[$point]['clr_cust'][0] . "\"  width=\"35px\"
							 id=ch_cust_ck" . $key_c[$point]['ch_id'][0] . " >
							<input type=checkbox
							onclick=\"child_toggle(" . $key_c[$point]['ch_id'][0] . ",this,$i,'ch_cust_ck')\"
							name=ch_cust_ck ";
        if ($key_c[$point]['ch_cust_ck'][0] == 'yes') {
            $content.=" checked value=yes ></td>";
        } else {
            $content.=" value=no ></td>";
        }
        $content.="<td align=\"center\"    bgcolor=\"" . $key_c[$point]['clr_is'][0] . "\" width=\"35px\"
 			id=ch_issue_ck" . $key_c[$point]['ch_id'][0] . " >
			<input type=checkbox
			onclick=\"child_toggle(" . $key_c[$point]['ch_id'][0] . ",this,$i,'ch_issue_ck')\"
			name=ch_issue_ck ";
        if ($key_c[$point]['ch_issue_ck'][0] == 'yes') {
            $content.=" checked value=yes ></td>";
        } else {
            $content.=" value=no ></td>";
        }
        $content.="<td width=\"175px\" align=\"center\" id=af_notes$i  ondblclick=edit_af($i," . $key_c[$point]['af_order_id'][0] . "," . $key_c[$point]['ch_id'][0] . ") ><a class=info href=#>" . substr($key_c[$point]['ch_notes'][0], 0, 25) . "<span>" . $key_c[$point]['ch_notes'][0] . "</span></a></td>";

        $content.="</tr>";
        $content.="</table>";
        $content.="</div>";
        if (sizeof($key_c[$point]['af_order_id']) == 1) {
            $content.="<div id=po_child" . ($key_c[$point]['ch_id'][0] + 1) . "></div>";
        }
        for ($j = 1; $j < sizeof($key_c[$point]['af_order_id']); $j++) {
            $content.="<div id=po_child" . $key_c[$point]['ch_id'][$j] . " >";
            $content.="<table width=970px border=0 cellpadding=0 cellspacing=0 class=task_today_entry >";
            $content.="<tr  " . col_bg('#ececec', $i) . " class=hilite>";
            $content.="<td width=\"45px\"  class=tdbg align=center >&nbsp;</td>";
            $content.="<td width=\"120px\" class=tdbg  >&nbsp;</td>";
            $content.="<td width=\"115px\" class=tdbg >&nbsp;</td>";
            $content.="<td width=\"35px\" >&nbsp;</td>";
            $content.="<td width=\"35px\"  class=tdbg>&nbsp;</td>";

            $content.="<td   width=\"70px\"   align=\"center\"  bgcolor=\"" . $key_c[$point]['ch_ship'][$j] . "\"   id=ch_shdate" . $key_c[$point]['ch_id'][$j] . "   ondblclick=edit_ch(" . $key_c[$point]['ch_id'][$j] . ")>" . print_date($key_c[$point]['ch_ship_date'][$j]) . "</td>";
            if (($j + 1) == sizeof($key_c[$point]['af_order_id']) && $j <= 2) {
                $content.="<td width=\"35px\" id=ch_po" . $key_c[$point]['ch_id'][$j] . " bgcolor=\"" . $key_c[$point]['clr_ven'][$j] . "\" align=\"center\"><span onclick=add_PO($i," . $key_c[$point]['ch_id'][$j] . ",'$po_title[$j]'," . $key_c[$point]['af_order_id'][$j] . ")>" . $key_c[$point]['ch_po'][$j] . "</span></td>";
            } else {
                $content.="<td width=\"35px\" id=ch_po" . $key_c[$point]['ch_id'][$j] . "  bgcolor=\"" . $key_c[$point]['clr_ven'][$j] . "\" align=\"center\">" . $key_c[$point]['ch_po'][$j] . "</td>";
            }
            $content.="<td width=\"75px\"  bgcolor=\"" . $key_c[$point]['clr_ven'][$j] . "\"  align=\"center\" id=ch_ven" . $key_c[$point]['ch_id'][$j] . "  ondblclick=edit_ch(" . $key_c[$point]['ch_id'][$j] . ")>" . $key_c[$point]['ch_vendor'][$j] . "</td>";

            $content.="<td align=\"center\"   width=\"35px\">";
            if ($att['poart'][$key_c[$point]['ch_id'][$j]] == 'yes') {
                $content.="<span class=get_art_files id=" . $key_c[$point]['ch_id'][$j] . "><span  id=icon_" . $key_c[$point]['ch_id'][$j] . "  onclick=send_data(" . $key_c[$point]['af_order_id'][$j] . ",'poart','yes'," . $key_c[$point]['ch_id'][$j] . ",'" . $key_c[$point]['ch_po'][$j] . "')><img class=point src=\"../images/open_icon.png\"></span></span>";
            } else {
                $content.="<span  id=icon_" . $key_c[$point]['ch_id'][$j] . "  onclick=send_data(" . $key_c[$point]['af_order_id'][$j] . ",'poart','yes'," . $key_c[$point]['ch_id'][$j] . ",'" . $key_c[$point]['ch_po'][$j] . "') class=point ><img src=\"../images/attch_icon.png\"></span>";
            }
            $content.="</td>";
            $content.="<td align=\"center\" bgcolor=\"" . $key_c[$point]['clr_conf'][$j] . "\"  width=\"35px\"
							 id=ch_conf_ck" . $key_c[$point]['ch_id'][$j] . " >
							<input type=checkbox
							onclick=\"child_toggle(" . $key_c[$point]['ch_id'][$j] . ",this,$i,'ch_conf_ck')\"
							name=ch_conf_ck ";
            if ($key_c[$point]['ch_conf_ck'][$j] == 'yes') {
                $content.=" checked value=yes ></td>";
            } else {
                $content.=" value=no ></td>";
            }
            $content.="<td    width=\"100px\" align=\"left\"   bgcolor=\"" . $key_c[$point]['clr_ship'][$j] . "\"
							ondblclick=edit_ch(" . $key_c[$point]['ch_id'][$j] . ")
							id=ch_ship_ck" . $key_c[$point]['ch_id'][$j] . ">
							<input type=checkbox
							onclick=\"child_toggle(" . $key_c[$point]['ch_id'][$j] . ",this,$i,'ch_ship_ck')\"
							name=ch_ship_ck ";
            if ($key_c[$point]['ch_ship_ck'][$j] == 'yes') {
                $content.=" checked value=yes >";
            } else {
                $content.=" value=no >";
            }
            $content.="<span id=ch_shnotes" . $key_c[$point]['ch_id'][$j] . "> " . substr($key_c[$point]['ch_ship_notes'][$j], 0, 10) . "</span></td>";

            $content.="<td  class=tdbg align=\"center\" bgcolor=\"" . $key_c[$point]['clr_cust'][$j] . "\"  width=\"35px\"
							 id=ch_cust_ck" . $key_c[$point]['ch_id'][$j] . " >
							<input type=checkbox
							onclick=\"child_toggle(" . $key_c[$point]['ch_id'][$j] . ",this,$i,'ch_cust_ck')\"
							name=ch_cust_ck ";
            if ($key_c[$point]['ch_cust_ck'][$j] == 'yes') {
                $content.=" checked value=yes ></td>";
            } else {
                $content.=" value=no ></td>";
            }
            $content.="<td align=\"center\" bgcolor=\"" . $key_c[$point]['clr_is'][$j] . "\"  width=\"35px\"
							 id=ch_issue_ck" . $key_c[$point]['ch_id'][$j] . " >
							<input type=checkbox
							onclick=\"child_toggle(" . $key_c[$point]['ch_id'][$j] . ",this,$i,'ch_issue_ck')\"
							name=ch_issue_ck ";
            if ($key_c[$point]['ch_issue_ck'][$j] == 'yes') {
                $content.=" checked value=yes ></td>";
            } else {
                $content.=" value=no ></td>";
            }
            $content.="<td    width=\"175px\" align=\"center\" id=ch_notes" . $key_c[$point]['ch_id'][$j] . "  ondblclick=edit_ch(" . $key_c[$point]['ch_id'][$j] . ")    ><a class=info href=#>" . substr($key_c[$point]['ch_notes'][$j], 0, 23) . "<span>" . $key_c[$point]['ch_notes'][$j] . "</span></a></td>";

            $content.="</tr>";
            $content.="</table>";
            $content.="</div>";
            if (($j + 1) == sizeof($key_c[$point]['af_order_id']) && $j <= 2) {
                $content.="<div id=po_child" . ($key_c[$point]['ch_id'][$j] + 1) . "></div>";
            }
        }
        // $point++;
        // $clr++;
    }
    return $content;
}

?>