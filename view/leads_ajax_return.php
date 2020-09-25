<?php
include_once('../controller/leads_controller.php');
include_once ('../model/mysql.php');

$obj = new db();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function leadHistory($leadID, $msg, $check)
{
$obj=new db();
	if(!$check && $msg != '')
	{
		$qry = "insert into leadshistory values(null,$leadID,'$msg','".$_SESSION['uid']."',now())";
		$obj->query($qry);
		return true;
	}
	else
	{
		$qry = "select lhMsg from leadshistory where leadID = $leadID order by lhDatetime desc limit 0,1";
		$res = $obj->query($qry);
		if($obj->numrow($res) == 0)
		{
				if($msg != '')
				leadHistory($leadID, $msg, false);
		}
		else
		{
			$data = $obj->fetch($res);
			if($msg != $data['lhMsg'] && $msg != '')
				leadHistory($leadID, $msg, false);
		}
	}
}


if($_POST['q'] == 'addLead')
{
$ck = $_POST['reps']; $ret = array('error'=>false,'show'=>false,'errormsg'=>'Unknown Action.');

if($_POST['action'] == 'add')
	{
		$qry = "insert into leaddata values(null,'".date("D m/d/y")."','".$_POST['company']."','".$_POST['name']."','".$_POST['phone']."','".$_POST['email']."','".$_POST['qty']."','".$_POST['items']."','".$_POST['type']."','".$_POST['status']."','".$_POST['needby']."','".$_POST['notes']."',now())";

		if($obj->query($qry))
			{
	
				$lastID = mysql_insert_id();
				$BG = col_bg_leads($_POST['type'], 1);
				$ret = array('error'=>false,'date'=>date("D m/d/y"),'company'=>$_POST['company'],'name'=>$_POST['name'],'qty'=>$_POST['qty'],'items'=>$_POST['items'],'type'=>$_POST['type'],'status'=>$_POST['status'],'needby'=>$_POST['needby'],'leadID' => $lastID,'action'=>'add', 'bgclr' => $BG );

				if(isset($ck))
					foreach($ck as $value)
						{
 							$qry = "insert into leaduser values(null,$lastID, $value)";
 							$obj->query($qry);
 							if($_SESSION['repID'] == $value || $_SESSION['repID'] == 99) 
 								$ret['show']=true;
						}
				else
					{
						if($_SESSION['repID'] == 100 || $_SESSION['repID'] == 99)
						$ret['show'] = true;
					}	
	
			}
leadHistory($lastID,$_POST['status'],false);
echo  json_encode($ret);
}
else
{ 
	$qry = "update leaddata set leadCompany = '".$_POST['company']."', leadName = '".$_POST['name']."', leadPhone = '".$_POST['phone']."', leadEmail = '".$_POST['email']."', leadQty = '".$_POST['qty']."', leadItem = '".$_POST['items']."',leadType = '".$_POST['type']."', leadStatus = '".$_POST['status']."', leadNeedBy = '".$_POST['needby']."', leadNotes = '".$_POST['notes']."', leadDateTime = now() where leadID = ".$_POST['leadID'];

if($obj->query($qry))
			{
	
				$lastID = $_POST['leadID']; 
				//getting date created from db to display on system.
				if($_SESSION['leadSort'] == 'leadDateTime')
				$date = date("D m/d/y");
				else
				{
					$qry = "select leadDateCreated from leaddata where leadID = $lastID";
					$data = $obj->fetch($obj->query($qry));
					$date = $data['leadDateCreated'];
				}
				$BG = col_bg_leads($_POST['type'], 1); 
				$ret = array('error'=>false,'date'=>$date,'company'=>$_POST['company'],'name'=>$_POST['name'],'qty'=>$_POST['qty'],'items'=>$_POST['items'],'type'=>$_POST['type'],'status'=>$_POST['status'],'needby'=>$_POST['needby'], 'leadID' => $lastID ,'action'=>'edit', 'bgclr' => $BG, 'org' => $_POST['org'] );
				//deleting all users from the leaduser table to update them after edit
				$qry = "delete from leaduser where leadID = $lastID";
				$obj->query($qry);
				if(isset($ck))
					foreach($ck as $value)
						{
 							$qry = "insert into leaduser values(null,$lastID, $value)";
 							$obj->query($qry);
 							if($_SESSION['repID'] == $value || $_SESSION['repID'] == 99 ) 
 								$ret['show']=true;
						}
				else
					{
						if($_SESSION['repID'] == 100)
						$ret['show'] = true;
					}	
					
	
			}
leadHistory($lastID,$_POST['status'],true);
echo  json_encode($ret);
}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


if($_POST['q'] == 'getLead')
{
$qry = "select * from leaddata where leadID = ".$_POST['id'];
$res = $obj->query($qry);
$data = $obj->fetch($res);
$qry = "select userID from leaduser where leadID = ".$_POST['id'];
$res = $obj->query($qry);
while($d = $obj->fetch($res))
$data['ck'][] = $d['userID'] ;

if(preg_match('/^\d{1,2}\/\d{1,2}\/\d{2}$/', $data['leadNeedBy'])) 
$data['phrase']=false;
else
$data['phrase']=true;
if($data['leadNeedBy'] == '0000-00-00'  || $data['leadNeedBy'] == '2090-12-30')
$data['leadNeedBy'] = '';

$qry = "select * from leadshistory where leadID = ".$_POST['id']." order by lhDatetime desc";
$res = $obj->query($qry);
while($dd = $obj->fetch($res))
{
	$data['lhID'][]=$dd['lhID'];
	$data['lhMsg'][]=$dd['lhMsg'];
	$data['lhUser'][]=$userNames[$dd['lhUser']];
	$data['lhWhen'][]=substr($dd['lhDatetime'],5,2)."/".substr($dd['lhDatetime'],8,2)."/".substr($dd['lhDatetime'],2,2)." ".substr($dd['lhDatetime'],11,5);
}
echo json_encode($data);
}
?>