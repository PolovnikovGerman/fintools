<?php

include ("mysql.php");
$obj=new db();
$qry="select * from dump";
$res=$obj->query($qry);
while($data=$obj->fetch($res))
{
	$id[]=$data['id'];
	$search[]=$data['search'];
	$size[]=$data['size'];

	

}

for($i=0;$i<sizeof($id);$i++)
{
echo $i."<br>";
echo $qry="insert into iw_info values(null,".$id[$i].",'".addslashes($search[$i])."','','".addslashes($size[$i])."','','','','','')";
$obj->query($qry);
echo "<br>";
}




?>