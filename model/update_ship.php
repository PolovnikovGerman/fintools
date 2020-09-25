<?php

include('mysql.php');

$obj=new db();

$qry="select id,ship from dump";
$res=$obj->query($qry);
while($data = $obj->fetch($res))
{
if(!empty($data['ship']))
{
echo $qry2="update is_info set is_ship = ".$data['ship']." where is_id = ".$data['id'];
echo "<br>";
echo $res2=$obj->query($qry2);
echo "<br>";
}
}

?>
