<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php


function getLeads()
{

$obj = new db(); $lastDate = '';

if(isset($_SESSION['leadPg']) && is_numeric($_SESSION['leadPg']))
	$openStart = ($_SESSION['leadPg']*200);
else	
	$openStart = 0;

if(!isset($_SESSION['leadSort']))
	$leadSort = 'leadID';
else
	$leadSort = $_SESSION['leadSort'];

if($leadSort == 'leadType')
	$param = 'asc';
else
	$param = 'desc';
		
$retLead = array('error'=>false);

if(!isset($_SESSION['repID']) || $_SESSION['repID']=='')
{
 $retLead['errorMsg']='Rep not selected or inactive';
 return $retLead;
}
else {
if($_SESSION['repID'] == 99)
 $qry = "select * from leaddata where (leadType = 1 or leadType =2)  order by $leadSort $param, leadID desc limit $openStart,200";
else if($_SESSION['repID'] == 100)
$qry = "select * from leaddata  where leadID not in (select distinct(leadID) from leaduser) and (leadType = 1 or leadType =2) order by $leadSort $param, leadID desc limit $openStart,200";
else 
$qry = "select * from leaddata a, leaduser b where a.leadID = b.leadID and b.userID = ".$_SESSION['repID']." and (leadType = 1 or leadType =2) order by a.$leadSort $param, a.leadID desc limit $openStart,200";
$lastDate = '';
$res = $obj->query($qry);
while($data = $obj->fetch($res))
{
	$retLead['id'][]=$data['leadID'];
	
if($_SESSION['leadSort'] == 'leadDateTime')
    if($lastDate == substr($data['leadDateTime'],0,10))
	{
		$retLead['date'][]="---";
		$lastDate = substr($data['leadDateTime'],0,10);
		$retLead['sep'][]='';
	}
	else 
	{
		$retLead['date'][] = print_date(substr($data['leadDateTime'],0,10));
		$lastDate = substr($data['leadDateTime'],0,10);
		$retLead['sep'][]='class=sep';
	}
else
	if($lastDate == $data['leadDateCreated'])
	{
		$retLead['date'][]="---";
		$lastDate = $data['leadDateCreated'];
		$retLead['sep'][]='';
	}
	else 
	{
		$retLead['date'][] = $data['leadDateCreated'];;
		$lastDate = $data['leadDateCreated'];
		$retLead['sep'][]='class=sep';
	}
	
	
	$retLead['company'][]=$data['leadCompany'];
	$retLead['name'][]=$data['leadName'];
	$retLead['qty'][]=$data['leadQty'];
	$retLead['item'][]=$data['leadItem'];
	$retLead['type'][]=$data['leadType'];
	$retLead['status'][]=$data['leadStatus'];
	
	$retLead['needby'][]=($data['leadNeedBy'] != '0000-00-00' && $data['leadNeedBy'] != '2090-12-30') ? $data['leadNeedBy'] : '&nbsp;';

	if($data['leadNeedBy'] != '' && preg_match('/^d{4}-d{2}-d{2}$/', $data['leadNeedBy']) && is_numeric($data['leadNeedBy']))
		echo $retLead['needby'][]=print_date($data['leadNeedBy']);
	
	$retLead['notes'][]=$data['leadNotes'];
	$retLead['datetime'][]=$data['leadDateTime'];
	
}
return $retLead;



}


}
/*

function get_history($cid)
{
$obj = new db(); $dat = array();
$qry = "select * from r2_history where r2_cid = $cid order by r2_datetime DESC";
$res = $obj->query($qry);
while($dat = $obj->fetch($res) )
{
$data_h['r2_hid'][]=$dat['r2_hid'];
$data_h['r2_cid'][]=$dat['r2_cid'];
$data_h['r2_msg'][]=$dat['r2_msg'];
$data_h['r2_user'][]=$dat['r2_user'];
$data_h['r2_datetime'][]=$dat['r2_datetime'];
}
return $data_h;

}


*/



function getDCLeads()
{

$obj = new db(); $lastDate = '';
if(isset($_SESSION['leadDCPg']) && is_numeric($_SESSION['leadDCPg']))
	$deadStart = ($_SESSION['leadDCPg']*50);
else
	$deadStart = 0;

if(!isset($_SESSION['leadSort']))
	$leadSort = 'leadID';
else
	$leadSort = $_SESSION['leadSort'];

if($leadSort == 'leadType')
	$param = 'asc';
else
	$param = 'desc';
	
$retLead = array('error'=>false);

if(!isset($_SESSION['repID']) || $_SESSION['repID']=='')
{
 $retLead['errorMsg']='Rep not selected or inactive';
 return $retLead;
}
else 
{
	if($_SESSION['repID'] == 99)
		 $qry = "select * from leaddata where (leadType = 3 or leadType =4)  order by $leadSort $param, leadID desc limit $deadStart,50";
	
	else if($_SESSION['repID'] == 100)
		$qry = "select * from leaddata a where leadID not in (select distinct(leadID) from leaduser) and (leadType = 3 or leadType =4) order by $leadSort $param, leadID desc limit $deadStart,50";

	else 
		$qry = "select * from leaddata a, leaduser b where a.leadID = b.leadID and b.userID = ".$_SESSION['repID']." and (leadType = 3 or leadType =4) order by a.".$leadSort." $param, a.leadID desc limit $deadStart,50";

		$res = $obj->query($qry);
		while($data = $obj->fetch($res))
		{
			$retLead['id'][]=$data['leadID'];
	
	if($_SESSION['leadSort'] == 'leadDateTime')
    	if($lastDate == substr($data['leadDateTime'],0,10))
		{
			$retLead['date'][]="---";
			$lastDate = substr($data['leadDateTime'],0,10);
			$retLead['sep'][]='';
		}
		else 
		{
			$retLead['date'][] = print_date(substr($data['leadDateTime'],0,10));
			$lastDate = substr($data['leadDateTime'],0,10);
			$retLead['sep'][]='class=sep';
		}
	else
		if($lastDate == $data['leadDateCreated'])
		{
			$retLead['date'][]="---";
			$retLead['sep'][]='';
			$lastDate = $data['leadDateCreated'];
		}
		else 
		{
			$retLead['date'][] = $data['leadDateCreated'];;
			$lastDate = $data['leadDateCreated'];
			$retLead['sep'][]='class=sep';
		}
	
	
		$retLead['company'][]=$data['leadCompany'];
		$retLead['name'][]=$data['leadName'];
		$retLead['qty'][]=$data['leadQty'];
		$retLead['item'][]=$data['leadItem'];
		$retLead['type'][]=$data['leadType'];
		$retLead['status'][]=$data['leadStatus'];
		$retLead['needby'][]=$data['leadNeedby'];
		$retLead['notes'][]=$data['leadNotes'];
		$retLead['datetime'][]=$data['leadDateTime'];
	
		}

return $retLead;
}

}


function getPages($val)
{
	$obj = new db();

	if($_SESSION['repID'] == 99)
		$qry = "select count(leadID) as pagesDC from leaddata where  (leadType = $val or leadType = ".($val+1).") ";
	else if($_SESSION['repID'] == 100)
		$qry = "select count(leadID) as pagesDC from leaddata where  (leadType = $val or leadType = ".($val+1).") ";
	else
		 $qry = "select count(a.leadID) as pagesDC from leaddata a, leaduser b where a.leadID = b.leadID and b.userID = ".$_SESSION['repID']." and (leadType = $val or leadType = ".($val+1).") ";
		
		$res = $obj->query($qry);
		 $data = $obj->fetch($res);
		if($val == 1)
 		 $break = $data['pagesDC']/200;
		else
		 $break = $data['pagesDC']/50;
		 
		
		
		return ceil($break);
	
	
}
?>