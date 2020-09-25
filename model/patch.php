<?php
include('mysql.php');
/*$po=array('A','B','C','D');
$obj=new db();

for($i=22000;$i<=30000;$i++)
{
	for($j = 0; $j<4; $j++)
	{
		if($j == 0)
		 $qry = "insert into af_child values(null,$i,'0000-00-00','".$po[$j]."' , '', 'no', 'no', 'no', '', 'no', '', now(),'on' )";
		 else
		 		 $qry = "insert into af_child values(null,$i,'0000-00-00','".$po[$j]."' , '', 'no', 'no', 'no', '', 'no', '', now(),'off' )";
		$obj->query($qry);
		echo "<br>";
	}

}*/


$obj = new db();

$qry = "select sbID from sb_items";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
	echo $qry2 = "insert into sb_pricing values(null,".$data['sbID'].",'0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','qty','qty','')";
	$obj->query($qry2);
	
		$qry2 = "insert into sb_pricing values(null,".$data['sbID'].",'0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','price','price','')";
	$obj->query($qry2);
	
		$qry2 = "insert into sb_pricing values(null,".$data['sbID'].",'0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','sale','sale','')";
	$obj->query($qry2);
	
		$qry2 = "insert into sb_pricing values(null,".$data['sbID'].",'0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','','cmp1','')";
	$obj->query($qry2);
	
		$qry2 = "insert into sb_pricing values(null,".$data['sbID'].",'0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','','cmp2','')";
	$obj->query($qry2);
	
		$qry2 = "insert into sb_pricing values(null,".$data['sbID'].",'0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','','cmp3','')";
	$obj->query($qry2);
}


?>