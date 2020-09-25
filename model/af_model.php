<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php
function get_art()
{
if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
$val = $_SESSION['or'];
else
$val = 22000;

$obj = new db(); $key=array();
$qry = "select * from af_master where af_order_id >= $val and af_order_id <=".($val+500)." order by af_order_id ";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$key['af_order_id'][]=$data['af_order_id'];
$key['af_rush_ck'][]=$data['af_rush_ck'];
$key['af_cust'][]=$data['af_cust'];
$key['af_desc'][]=$data['af_desc'];
$key['af_date'][]=$data['af_date'];
$key['af_art_ck'][]=$data['af_art_ck'];
$key['af_redraw_ck'][]=$data['af_redraw_ck'];
$key['af_vector_ck'][]=$data['af_vector_ck'];
$key['af_proof_ck'][]=$data['af_proof_ck'];
$key['af_appr_ck'][]=$data['af_appr_ck'];
$key['af_notes'][]=$data['af_notes'];
$key['af_cust_ck'][]=$data['af_cust_ck'];
$key['af_datetime'][]=$data['af_datetime'];
}
return $key;
}

function chk_attach_files()
{
if(isset($_SESSION['or']) && is_numeric($_SESSION['or']))
$val = $_SESSION['or'];
else
$val = 22000;
$obj = new db(); $att = array();
 $qry = "select * from af_attach WHERE att_ref >= $val and att_ref <=".($val+500);
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$order_id= $data['att_ref'];
$att[$order_id] = 'yes';
}
return $att;
}



// Below function to move file to art_af_fl_uploads folder.


function attach_files()
{
$go = 0; 
$result = 0;  sizeof($_FILES['fileX']['name']);
$obj=new db();
$qry="insert into af_attach(att_ref, att_ch, att_path, att_name, att_type,att_datetime, att_edit) ";
$qry.=" VALUES ";
for ($i=1; $i<sizeof($_FILES['fileX']['name']); $i++)
	{
	
		if($_POST['_type']=='clay' or $_POST['_type'] == 'prv')
		{
		$ext=findexts($_FILES['fileX']['name'][$i]);
		$poName=$obj->get_PONAME($_POST['chid']);
		$target_path = "../docs/art_af_fl_uploads/".$_POST['_type']."/"; 
   		$target_path.="BLUETRACK_".$_POST['_type']."_".$poName['af_order_id'].$poName['ch_po']."_".($i+0).".".$ext;
		$target_name="BLUETRACK_".$_POST['_type']."_".$poName['af_order_id'].$poName['ch_po']."_".($i+0).".".$ext;
		}
		else
		{
		$target_path = "../docs/art_af_fl_uploads/".$_POST['_type']."/"; 
   		$target_path.=$_FILES['fileX']['name'][$i];
		$target_name=$_FILES['fileX']['name'][$i];
		}
		
   			if(move_uploaded_file($_FILES['fileX']['tmp_name'][$i], $target_path)) 
				{
				if($_POST['_type'] == 'art')
				$qry.="('".$_POST['artid']."',0,'".$target_path."','".$target_name."','".$_POST['_type']."',now(),0),"; 
				else 
				$qry.="(0,'".$_POST['chid']."','".$target_path."','".$target_name."','".$_POST['_type']."',now(),0),"; 
				
				$go = 1; }
			else
				$ret = 0;
	} // FOR close
if($go){
	$qry = substr($qry,0,strlen($qry)-1);
		if(!$obj->query($qry)) $ret =  0;
			else $ret=mysql_insert_id();
		}
if($_POST['_type'] == 'poart'){
$qry = "update af_child set ch_placed_ck = 'yes' where ch_id = ".$_POST['chid'];
$obj->query($qry); }
if($_POST['_type'] == 'clay'){
$qry = "update af_child set ch_claydoc_ck = 'yes' where ch_id = ".$_POST['chid'];
$obj->query($qry);
//send_email_attach('sean@bluetrack.com','attachment test','this is a <b>test</b> with test in bold to check html comp.',$target_path,"Purchase Order");
 }
if($_POST['_type'] == 'prv'){
$qry = "update af_child set ch_prvdoc_ck = 'yes' where ch_id = ".$_POST['chid'];
$obj->query($qry); }


return $ret;
}// attach_files()

function get_orderart($af_order_id) {
    $obj = new db();
    $qry = "select * from af_master where af_order_id = " . $af_order_id;
    $res = $obj->query($qry);
    while ($data = $obj->fetch($res)) {
        $ret = $data;
    }
    return $ret;
}

function update_orderart($updparams, $artnotes) {
    $obj = new db();
    $fh = fopen('/home/bluetrac/public_html/system/uploads/exportdata.log', 'a+');    
//    $fh = fopen('/home/polovnikov-go/Projects/fintool/uploads/exportdata.log', 'a+');
    $qry="update af_master set ";
    // if (in_array('af_cust', $updparams) && !empty($updparams['af_cust'])) {
        $qry.="af_cust='{$updparams['af_cust']}',";
    // }
    // if (in_array('af_desc', $updparams)) {
        $qry.=" af_desc='{$updparams['af_desc']}',";
    // }
    $orderdate=date('Y-m-d', $updparams['order_date']);
    $qry.="af_date='{$orderdate}', ";
    $newnote=$artnotes;
    if (intval($updparams['order_blank'])==1) {
        $msg='Old Notes '.$artnotes.PHP_EOL;
        fwrite($fh, $msg);   
        if (mb_strpos($artnotes,'blank order')==FALSE) {
            $newnote='blank order '.$artnotes;
        }        
    } else {
        if (mb_strpos($artnotes,'blank order')!==FALSE) {
            $newnote=str_replace('blank order', '', $artnotes);
        }
    }
    if (isset($updparams['contact_info']) && !empty($updparams['contact_info'])) {
        $qry.="af_contacinfo='{$updparams['contact_info']}', ";
    }
    
    $qry.="af_notes='{$newnote}',";
    $rushparam=($updparams['af_rush_ck']==0 ? 'no' : 'yes');
    $qry.=" af_rush_ck='{$rushparam}',";
    $artparam=($updparams['af_art_ck']==0 ? 'no' : 'yes');
    $qry.=" af_art_ck='{$artparam}',";
    $redrawparam=($updparams['af_redraw_ck']==0 ? 'no': 'yes');
    $qry.=" af_redraw_ck='{$redrawparam}',";
    $vectparam=($updparams['af_vector_ck']==0 ? 'no' : 'yes');
    $qry.="af_vector_ck='{$vectparam}',";
    $profparam=($updparams['af_proof_ck']==0 ? 'no' : 'yes');
    $qry.="af_proof_ck='{$profparam}',";
    $approvparam=($updparams['af_appr_ck']==0 ? 'no' : 'yes');
    $qry.="af_appr_ck='{$approvparam}'";
    $qry.=" where af_order_id={$updparams['af_order_id']}";
    $fh = fopen('/home/bluetrac/public_html/system/uploads/exportdata.log', 'a+');
//    $fh = fopen('/home/polovnikov-go/Projects/fintool/uploads/exportdata.log', 'a+');
    $msg = date('d.m.Y H:i:s') . ' API UPDATE  '.$qry. PHP_EOL;
    fwrite($fh, $msg);   
    fclose($fh);
    $obj->query($qry);
    return TRUE;
}

function update_orderartdoc($updparam) {
    $outres=array('result'=>0, 'error'=>'File Get Content Error');    
    if ($updparam['operation']=='add') {
        // Check that file exist
        $obj = new db();        
        $qry = "select count(*) as cnt from af_attach where att_ref={$updparam['af_order_id']} and att_name='{$updparam['source_name']}'";
        $res = $obj->query($qry);
        while ($data = $obj->fetch($res)) {
            $ret = $data;
        }
        // Get Content
        $income = @file_get_contents($updparam['source_lnk']);

        if ($income) {            
            $outres['error']='Local File Save Error';
            $outfile='../docs/art_af_fl_uploads/art/'.$updparam['source_name'];
            // $outfile='../uploads/'.$updparam['source_name'];            
            $saveres = @file_put_contents($outfile,$income);

            if ($saveres) {
                if ($ret['cnt']==0) {
                    $dateins=date('Y-m-d H:i:s');
                    $qry="insert into af_attach(att_ref, att_ch, att_path, att_name, att_type,att_datetime, att_edit) ";
                    $qry.=" values({$updparam['af_order_id']},0,'{$outfile}','{$updparam['source_name']}','art','{$dateins}','0')";
                    $obj = new db();
                    $obj->query($qry);                    
                }
                $outres['result']=1;
                $outres['error']='';
            }
        }            
    } else {
        // Delete 
        $qry="delete from af_attach where att_ref={$updparam['af_order_id']} and att_name='{$updparam['source_name']}'";
        $obj = new db();
        $obj->query($qry);
        $outres['result']=1;
        $outres['error']='';        
    }
    return $outres;
}

?>