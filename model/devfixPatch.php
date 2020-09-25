<?php
include('mysql.php');
$po=array('A','B','C','D');
$obj=new db();

$qry = "select dtaskID from dev_task where projID = 28";
$res = $obj->query($qry);

while($data = $obj->fetch($res))
{
	$primeArray[] = $data['dtaskID'];
}
 
 echo "<pre>";
 print_r($primeArray);
 echo "</pre>"; 
 echo serialize($primeArray);
 /*
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

}
*/
?>