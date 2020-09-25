<?php
include('mysql.php');
$obj=new db();
//WHILE POPULATING DB AGAIN MAKE SURE TO BREAK IT INTO 1000 ROWS ELSE IT WILL TIME OUT.
$qry = "select * from info_table order by lead_id asc ";
$res = $obj->query($qry);
echo $obj->numrow($res)."<br>"; $i=1;
while($data = $obj->fetch($res) )
{
//	$data['lead_date'] = '2010-01-01';
	$lead_id = $data['lead_id'];
	$date = $data['lead_date'];
	$year = substr($data['lead_date'],0,4);
	$day = substr($data['lead_date'],8,2);
	if(substr($data['lead_date'],5,1) == 0)
		$month = substr($data['lead_date'],6,1);
	else
		$month = substr($data['lead_date'],5,2);
$dd =	date("D m/d/y", mktime(0, 0, 0, $month, $day, $year));
echo "($i)   ".$data['lead_date']." ----- ".$dd."<br>"; $i++;
	$qry2 = "insert into leaddata values(null,'$dd','".addslashes($data['lead_company'])."','".addslashes($data['lead_contact'])."','".addslashes($data['lead_phone'])."','".addslashes($data['lead_email'])."','".addslashes($data['lead_quantity'])."','".addslashes($data['lead_item'])."','".addslashes($data['lead_order'])."','".addslashes($data['lead_currstatus'])."','".addslashes($data['lead_needbydate'])."','".addslashes($data['lead_notes'])."','".$data['lead_datetime']."')";
	$obj->query($qry2);
	$last = mysql_insert_id();
	 $qry3="insert into leaduser values(null,$last,".$data['lead_userid'].")";
	$obj->query($qry3);
	
	
	 $qr = "select * from status_history where status_lead_id = $lead_id";
	$re = $obj->query($qr);
	while($dn = $obj->fetch($re))
	{
	echo $q = "insert into leadshistory values(null,$last,'".addslashes($dn['status_msg'])."','".$data['lead_userid']."','".$dn['status_datetime']."')";
	echo "<br>";
	$obj->query($q);
	
	}
}

?>