<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
 <?php
$obj = new db();


$qry = "SELECT r2_id, sum(r2i_prc * r2i_qty) as total from af_r2_items group by r2_id";
$res = $obj->query($qry);
while($data = $obj->fetch($res))
{
 $qry = "update af_child set ch_poTotal = ".$data['total']." where ch_id = ".$data['r2_id'];
 $obj->query($qry);
 echo $data['r2_id']." - ".$data['total']."<br>";
}



?>