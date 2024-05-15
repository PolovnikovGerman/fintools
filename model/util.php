<?php
include('mysql.php');
$obj = new db();

/*for ($i=30011; $i<=35000; $i++) {
$qry="INSERT into af_master (af_order_id) values($i)";
$obj->query($qry);
echo 'Record '.$i.' Inserted '.PHP_EOL;
}
*/
$po=array('A','B','C','D');
$obj=new db();

for($i=64500;$i<=74999;$i++)
{
    $qry="INSERT into af_master (af_order_id, af_date) values($i,'0000-00-00')";
    $obj->query($qry);
    echo 'Record '.$i.' Inserted '.PHP_EOL;

	for($j = 0; $j<4; $j++)
	{
		if ($j==0) {
		 $qry = "insert into af_child (af_order_id, ch_ship_date,ch_po,ch_vendor, ch_placed_ck, ch_conf_ck, ch_ship_ck, ch_ship_notes, ch_issue_ck, ch_datetime, ch_active)
                                        values($i, '0000-00-00', '".$po[$j]."' , '', 'no', 'no' , 'no', '','no', now(), 'on' )";
		} else {
		 $qry = "insert into af_child (af_order_id, ch_ship_date,ch_po,ch_vendor, ch_placed_ck, ch_conf_ck, ch_ship_ck, ch_ship_notes, ch_issue_ck, ch_datetime, ch_active)
                                        values($i, '0000-00-00', '".$po[$j]."' , '', 'no', 'no' , 'no', '','no', now(), 'off' )";

		}
		echo 'SQL '.$qry.PHP_EOL;
		$obj->query($qry);

		echo 'Record '.$i.' PO '.$po[$j].' Added'.PHP_EOL;
	}

}

?>
