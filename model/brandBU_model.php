<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
 <?php



function getBUData()
{

$obj = new db();

$qry = "select * from bu_items ";

$res = $obj->query($qry);


while($data = $obj->fetch($res))
{
$retData['buID'][]=$data['buID'];
 $retData['itemID'][]=$data['bu_item_id'];
 $retData['itemName'][]=$data['bu_item_name'];
  $retData['p1'][]=$data['bu_price1'];
  $retData['p10'][]=$data['bu_price10'];
  $retData['p25'][]=$data['bu_price25'];
  $retData['p50'][]=$data['bu_price50'];
  $retData['p100'][]=$data['bu_price100'];
  $retData['p250'][]=$data['bu_price250'];
  $retData['p500'][]=$data['bu_price500'];
  $retData['p1000'][]=$data['bu_price1000'];
  $retData['p2500'][]=$data['bu_price2500'];
  $retData['p5000'][]=$data['bu_price5000'];
  $retData['p10k'][]=$data['bu_price10000'];
  $retData['p20k'][]=$data['bu_price20000'];
  $retData['p50k'][]=$data['bu_price50000'];
  $retData['p100k'][]=$data['bu_price100000'];

}

return $retData;
}

function putBUData()
{

$obj = new db();
//parr($_FILES);
	$target_path = '';
	$error['error']['flag']='success';
	$error['error']['msg']='added Successfully.';
	
	if($_FILES['buPic']['size'] > 0)
	{
		$target_path = "../docs/buttons/";
		$target_path = $target_path . basename( $_FILES['buPic']['name']); 
		if(move_uploaded_file($_FILES['buPic']['tmp_name'], $target_path)) 
			{
			}	 
		else
			{
    			$error['error']['flag']='error';
				$error['error']['msg']='Template Pic upload FAILED.';
				$target_path = '';
			}
	}
	$qry = "insert into bu_items values(null,
									'".$_POST['buItemID']."',
									'".$_POST['buName']."',
									'".$_POST['buCat']."',
									'".$_POST['buSize']."',
									'".$_POST['buText']."',
									'".$_POST['buCut']."',
									'".$_POST['buWeight']."',
									'".$_POST['buPrint']."',
									'".$target_path."',
									' ',
									now(),
									'".$_POST['price1']."',
									'".$_POST['price10']."',
									'".$_POST['price25']."',
									'".$_POST['price50']."',
									'".$_POST['price100']."',
									'".$_POST['price250']."',
									'".$_POST['price500']."',
									'".$_POST['price1000']."',
									'".$_POST['price2500']."',
									'".$_POST['price5000']."',
									'".$_POST['price10k']."',
									'".$_POST['price20k']."',
									'".$_POST['price50k']."',
									'".$_POST['price100k']."'
									)";
		$res = $obj->query($qry);
		if($error['error']['flag'] == 'success');
		$error['error']['msg'] = $_POST['buItemID'].' '.$error['error']['msg'];
	return $error;	
}

function editBUData()
{
	$error = array();
	$error['error']['flag']='success';
	$error['error']['msg']=$_POST['buItemID'].' updated Successfully.';
	
	$obj = new db();
	$target_path = '';
	$update = 0;
	if($_FILES['buPic']['size'] > 0)
	{
		$target_path = "../docs/buttons/";
		$target_path = $target_path . basename( $_FILES['buPic']['name']); 
		if(move_uploaded_file($_FILES['buPic']['tmp_name'], $target_path)) 
			{
				$update = 1;
			}	 
		else
			{
    			$error['error']['flag'] = 'error';
				$error['error']['msg'] = 'Template Pic upload Failed.';
				$target_path = '';
			}
	}
	if($update)
		 $qry = "update bu_items set bu_item_id = '".$_POST['buItemID']."',
									bu_item_name = '".$_POST['buName']."',
									bu_item_category = '".$_POST['buCat']."',
									bu_item_sizeItem = '".$_POST['buSize']."',
									bu_item_sizeText = '".$_POST['buText']."',
									bu_item_sizeCut = '".$_POST['buCut']."',
									bu_item_weight = '".$_POST['buWeight']."',
									bu_item_perPrint = '".$_POST['buPrint']."',
									bu_templatepic = '".$target_path."',
									bu_item_datetime = now(),
									bu_price1 = '".$_POST['price1']."',
									bu_price10 = '".$_POST['price10']."',
									bu_price25 = '".$_POST['price25']."',
									bu_price50 = '".$_POST['price50']."',
									bu_price100 = '".$_POST['price100']."',
									bu_price250 = '".$_POST['price250']."',
									bu_price500 = '".$_POST['price500']."',
									bu_price1000 = '".$_POST['price1000']."',
									bu_price2500 = '".$_POST['price2500']."',
									bu_price5000 = '".$_POST['price5000']."',
									bu_price10000 = '".$_POST['price10k']."',
									bu_price20000 = '".$_POST['price20k']."',
									bu_price50000 = '".$_POST['price50k']."',
									bu_price100000 = '".$_POST['price100k']."' where buID = ".$_POST['buID'];
	else
		 $qry = "update bu_items set bu_item_id = '".$_POST['buItemID']."',
									bu_item_name = '".$_POST['buName']."',
									bu_item_category = '".$_POST['buCat']."',
									bu_item_sizeItem = '".$_POST['buSize']."',
									bu_item_sizeText = '".$_POST['buText']."',
									bu_item_sizeCut = '".$_POST['buCut']."',
									bu_item_weight = '".$_POST['buWeight']."',
									bu_item_perPrint = '".$_POST['buPrint']."',
									
									bu_item_datetime = now(),
									bu_price1 = '".$_POST['price1']."',
									bu_price10 = '".$_POST['price10']."',
									bu_price25 = '".$_POST['price25']."',
									bu_price50 = '".$_POST['price50']."',
									bu_price100 = '".$_POST['price100']."',
									bu_price250 = '".$_POST['price250']."',
									bu_price500 = '".$_POST['price500']."',
									bu_price1000 = '".$_POST['price1000']."',
									bu_price2500 = '".$_POST['price2500']."',
									bu_price5000 = '".$_POST['price5000']."',
									bu_price10000 = '".$_POST['price10k']."',
									bu_price20000 = '".$_POST['price20k']."',
									bu_price50000 = '".$_POST['price50k']."',
									bu_price100000 = '".$_POST['price100k']."' where buID = ".$_POST['buID'];
									
		$res = $obj->query($qry);
		
		return $error;
	
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////// AJAX  RETURNS //////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['q'] == 'getBUData')
{

$obj = new db();
$qry = "select * from bu_items where buID = '".$_POST['ID']."'";
$res = $obj->query($qry);
while($data = $obj->fetch($res))
{
 $retData['buID']=$data['buID'];
 $retData['buItemID']=$data['bu_item_id'];
 $retData['buName']=$data['bu_item_name'];
 $retData['buCat']=$data['bu_item_category'];
 $retData['buSize']=$data['bu_item_sizeItem'];
 $retData['buText']=$data['bu_item_sizeText'];
 $retData['buCut']=$data['bu_item_sizeCut'];
 $retData['buWeight']=$data['bu_item_weight'];
 $retData['buPrint']=$data['bu_item_perPrint'];
 $retData['buPic']=$data['bu_templatepic'];
 $retData['buOption1']=$data['bu_item_option1'];
 $retData['buDatetime']=$data['bu_item_datetime'];
  $retData['p1']=$data['bu_price1'];
  $retData['p10']=$data['bu_price10'];
  $retData['p25']=$data['bu_price25'];
  $retData['p50']=$data['bu_price50'];
  $retData['p100']=$data['bu_price100'];
  $retData['p250']=$data['bu_price250'];
  $retData['p500']=$data['bu_price500'];
  $retData['p1000']=$data['bu_price1000'];
  $retData['p2500']=$data['bu_price2500'];
  $retData['p5000']=$data['bu_price5000'];
  $retData['p10k']=$data['bu_price10000'];
  $retData['p20k']=$data['bu_price20000'];
  $retData['p50k']=$data['bu_price50000'];
  $retData['p100k']=$data['bu_price100000'];

}
echo  json_encode($retData);
}
?>