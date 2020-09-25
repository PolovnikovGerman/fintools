<?php
include('mysql.php');
$obj = new db();
for($i=1;$i<32005;$i++)
{
$qry="insert into af_r2 values($i,0,'','','','','','','','','','','','','','','',0,0.00,0,'')";
if($obj->query($qry)) echo "<br>".$i;
}
?>