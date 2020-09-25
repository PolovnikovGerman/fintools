<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include ("mysql.php");
$obj=new db();
$qry="select * from dump";
$res=$obj->query($qry);
while($data=$obj->fetch($res))
{
	$id[]=$data['id'];
	$y[]=$data['yahoo'];
	

}


for($i=0;$i<sizeof($y);$i++)
{
$arr=array();
$q=array();
$p=array();

$arr=explode(" ",$y[$i]);
if($arr[1]==150)
{
$q[0]=1;
$q[1]=10;
$q[2]=25;
$q[3]=50;
$q[4]=150;
$q[5]=$arr[3];
$q[6]=$arr[5];
$q[7]=$arr[7];
$q[8]=$arr[9];
$q[9]='';
$q[10]='';

$p[0]="4.98";
$p[1]="3.99";
$p[4]=round($arr[2]/$arr[1],2);
$p[5]=round($arr[4]/$arr[3],2);
$p[6]=round($arr[6]/$arr[5],2);
$p[7]=round($arr[8]/$arr[7],2);
$p[8]=round($arr[10]/$arr[9],2);
$p[9]='';
$p[10]='';
$p[2]=round($p[4]+1.00,2);
$p[3]=round($p[4]+0.50,2);

$ps=serialize($p);
$qs=serialize($q);

if($id[$i]==2){
$e=unserialize($ps);
echo "<pre>";
print_r($e);
echo "</pre>";

echo "<pre>";
print_r($p);
echo "</pre>"; }

$qry="update dump set quantity = '$qs' , price = '$ps' where id = ".$id[$i];
$obj->query($qry);
}


}


?>
</body>
</html>
