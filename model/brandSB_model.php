<?php  include_once('mysql.php');
		include_once('mysql_module.php');
		include_once('../controller/generic_functions.php');
		 require_once('../includes/utility_functions.php');?>
 
 <?php


function getSBData()
{
	$obj = new db();
	$ret = array();
	$qry = "select sbID, sbItemID, sbName,sbCatCount, sbNew from sb_items order by sbItemID";
	$res = $obj->query($qry);
	
	while($data = $obj->fetch($res) )
	{
		$ret['sbID'][] = $data['sbID'];
		$ret['sbItemID'][] = $data['sbItemID'];
		$ret['sbName'][] = $data['sbName'];
		$ret['sbNew'][] = $data['sbNew'];
		$ret['sbCatCount'][] = $data['sbCatCount'];
	}
	$qry = "select * from sb_category";
	$res = $obj->query($qry);
	while($ret['sbCat'][] = $obj->fetch($res) ) {}
	array_pop($ret['sbCat']);
	
	$qry = "select sbID from sb_media";
	$res = $obj->query($qry);
	while($data = $obj->fetch($res))
	{
		$ret['img'][$data['sbID']] = 'noCat';
	}
	
	return $ret;
}

function getSBData_C($val)
{
	if(is_array($val))
	{
	$obj = new db();
	$ret = array();
	
	 $qry = "select sbID, sbItemID, sbName,sbCatCount, sbNew from sb_items where sbItemID in (";
	foreach($val as $key => $value)
	$qry.="'".$value."',";
	$qry=substr($qry,0,strlen($qry)-1);
	$qry.=") order by sbItemID";
	
	$res = $obj->query($qry);
	
	while($data = $obj->fetch($res) )
	{
		$ret['sbID'][] = $data['sbID'];
		$ret['sbItemID'][] = $data['sbItemID'];
		$ret['sbName'][] = $data['sbName'];
		$ret['sbNew'][] = $data['sbNew'];
		$ret['sbCatCount'][] = $data['sbCatCount'];
	}
	$qry = "select * from sb_category";
	$res = $obj->query($qry);
	while($ret['sbCat'][] = $obj->fetch($res) ) {}
	array_pop($ret['sbCat']);
	
	$qry = "select sbID from sb_media";
	$res = $obj->query($qry);
	while($data = $obj->fetch($res))
	{
		$ret['img'][$data['sbID']] = 'noCat';
	}
	
	return $ret;
	}
	
}


function putSBData()
{

$obj = new db();
//parr($_FILES);
	
	$qry = "insert into sb_items values(null,
									'".$_POST['itmID']."',
									'".$_POST['sbName']."',
									'".$_POST['sbWebpage']."',
									'".$_POST['sbColors']."',
									'".$_POST['sbSize']."',
									'".$_POST['sbWeight']."',
									'".$_POST['sbMaterial']."',
									'".$_POST['sbLeada']."',
									'".$_POST['sbLeadb']."',
									'".$_POST['sbLeadc']."',
									'".$_POST['sbVendor']."',
									'".$_POST['sbVprice']."',
									'".$_POST['sbVnotes']."',
									'".$_POST['sbSetup']."',
									'".$_POST['sbPrints']."',
									'".$_POST['sbKeys']."',
									'".$_POST['sbMtitle']."',
									'".$_POST['sbMkeys']."',
									'".$_POST['sbMdesc']."',
									'".$_POST['sbNew']."',
									'".$_POST['sbActive']."',
									'".$_POST['sbTax']."',
									'".$_POST['sbTemplate']."',
									'".$_POST['sbAttr'][0]."',
									'".$_POST['sbAttr'][1]."',
									'".$_POST['sbAttr'][2]."',
									'".$_POST['sbAttr'][3]."',
									0
									)";
		$res = $obj->query($qry); 
		$lastID = mysql_insert_id();
		if($res)
		{
			
			$mediaQry = "insert into sb_media values"; 
			$go = 0;
					
			
			for($i=0;$i<13;$i++)
			{
				$target_path = "../docs/sbImages/";
				$target_path = $target_path . $_POST['sbWebpage']."_".($i+1).".".findexts($_FILES['fileX']['name'][$i]); 
					if(move_uploaded_file($_FILES['fileX']['tmp_name'][$i], $target_path))
						{ 
							$mediaQry.="(null,$lastID,'".$_POST['sbWebpage']."_".($i+1)."','".$target_path."','','img',".($i+1)."),"; 
							$go = 1;
							
						}
					else
							{//do if anything needs to be done for no images put in
							}
						
			}
			
			
			//parr($_POST);
			for($i=0;$i<12;$i++)
			{
				$target_path = "../docs/sbImprints/";
				$target_path = $target_path . "IMP_".$_POST['sbWebpage']."_".($i+1).".".findexts($_FILES['fileY']['name'][$i]); 
					if(move_uploaded_file($_FILES['fileY']['tmp_name'][$i], $target_path)) 
						{
							$mediaQry.="(null,$lastID,'".$_POST['impName'][$i]."','".$target_path."','".$_POST['impSize'][$i]."','imp',".($i+1)."),"; 
							$go = 1;
							
						}
					else
							{
								if(strlen($_POST['impName'][$i]) > 0)
								$mediaQry.="(null, $lastID, '".$_POST['impName'][$i]."',' ','".$_POST['impSize'][$i]."','imp',".($i+1)."),";
							}
						
			}
		
			if($go == 1)
				{
					 $mediaQry = substr($mediaQry,0,strlen($mediaQry) - 1);
					$mediaRes = $obj->query($mediaQry);	
				}
		
		
		//////////////////////////////////// START OF PRICE ENTRY QUERY ////////////////////////////////////////////////////////
		
		$qry = "insert into sb_pricing values";
		$optType[1] = "price";
		$optType[2] = "sale";
		
		for($i=0; $i<6; $i++)
		{
			$qry.="(null,$lastID,";
			for( $j = 0; $j < 12; $j++ )
			{
				if($i == 0)
					$qry.="'".$_POST['sbQty'][$j]."',";
				else if($i == 1)
					$qry.="'".$_POST['sbPrice'][$j]."',";
				else if($i == 2)
					$qry.="'".$_POST['sbSale'][$j]."',";
				else
					$qry.="'".$_POST['sbCmp'.($i - 2)][$j]."',";
					
					
					
			}
			
			if($i == 0)
			$qry.="'qty','qty',''),";
			else if($i > 0 && $i <3)
			$qry.="'".$optType[$i]."','".$optType[$i]."',''),";
			else
			$qry.="'".$_POST['cmpName'.($i-2)]."','cmp".($i-2)."','".$_POST['cmpWebpage'.($i-2)]."'),";
		}
		
		
				{
					 $qry = substr($qry,0,strlen($qry) - 1);
		     		  $res = $obj->query($qry);	
					 				 
				}
		//////////////////////////////////// END   OF PRICE ENTRY QUERY ////////////////////////////////////////////////////////
		
		}//CLOSING OF DATA ENTRY QUERY
		
		
}

function editSBData()
{
	$obj = new db();
//parr($_POST);
	
	$qry = "update sb_items set
									sbItemID = '".$_POST['itmID']."',
									sbName = '".$_POST['sbName']."',
									sbWebpage = '".$_POST['sbWebpage']."',
									sbColors = '".$_POST['sbColors']."',
									sbSize = '".$_POST['sbSize']."',
									sbWeight = '".$_POST['sbWeight']."',
									sbMaterial = '".$_POST['sbMaterial']."',
									sbLeada = '".$_POST['sbLeada']."',
									sbLeadb = '".$_POST['sbLeadb']."',
									sbLeadc = '".$_POST['sbLeadc']."',
									sbVendor = '".$_POST['sbVendor']."',
									sbVprice = '".$_POST['sbVprice']."',
									sbVnotes = '".$_POST['sbVnotes']."',
									sbSetup = '".$_POST['sbSetup']."',
									sbPrints = '".$_POST['sbPrints']."',
									sbKeys = '".$_POST['sbKeys']."',
									sbMtitle = '".$_POST['sbMtitle']."',
									sbMkeys = '".$_POST['sbMkeys']."',
									sbMdesc = '".$_POST['sbMdesc']."',
									sbNew = '".$_POST['sbNew']."',
									sbActive = '".$_POST['sbActive']."',
									sbTax = '".$_POST['sbTax']."',
									sbTemplate = '".$_POST['sbTemplate']."',
									sbAttr1 = '".$_POST['sbAttr'][0]."',
									sbAttr2 = '".$_POST['sbAttr'][1]."',
									sbAttr3 = '".$_POST['sbAttr'][2]."',
									sbAttr4 ='".$_POST['sbAttr'][3]."' where sbID = ".$_POST['sbID'];

		$res = $obj->query($qry); 
		///////////////////////////////pricing////////////////////////
		
		$optType[1] = "price";
		$optType[2] = "sale";
		
		for($i=0; $i<6; $i++)
		{
		$qry = "update sb_pricing set ";
			
			for( $j = 0; $j < 13; $j++ )
			{
				if($i == 0)
					$qry.="sbP".($j+1)." = '".$_POST['sbQty'][$j]."',";
				else if($i == 1)
					$qry.="sbP".($j+1)." = '".$_POST['sbPrice'][$j]."',";
				else if($i == 2)
					$qry.="sbP".($j+1)." = '".$_POST['sbSale'][$j]."',";
				else
					$qry.="sbP".($j+1)." = '".$_POST['sbCmp'.($i - 2)][$j]."',";
			}
			
			if($i == 0)
			$qry.="sbPriceName = 'qty'  where sbID = ".$_POST['sbID']." and sbPrID = ".$_POST['sbPrID'.($i+1)];
			else if($i > 0 && $i <3)
			$qry.="sbPriceName = '".$optType[$i]."' where sbID = ".$_POST['sbID']." and sbPrID = ".$_POST['sbPrID'.($i+1)];
			else
			$qry.="sbPriceName = '".$_POST['cmpName'.($i-2)]."', sbOption = '".$_POST['cmpWebpage'.($i-2)]."' where sbID = ".$_POST['sbID']." and sbPrID = ".$_POST['sbPrID'.($i+1)];
		 $qry;
		$res = $obj->query($qry);	
		}

		$mediaQry = "insert into sb_media values"; 
		$go = 0;
		for($i = 0; $i < 10; $i++)
		{
			if($_FILES['fileX']['size'] > 0 && $_FILES['fileX']['name'] != '')
			{
				
					
			
			
				$target_path = "../docs/sbImages/";
				$target_path = $target_path . $_POST['sbWebpage']."_".($i+1).".".findexts($_FILES['fileX']['name'][$i]); 
					if(move_uploaded_file($_FILES['fileX']['tmp_name'][$i], $target_path))
						{ 
							$mediaQry.="(null,".$_POST['sbID'].",'".$_POST['sbWebpage']."_".($i+1)."','".$target_path."','','img',".($i+1)."),"; 
							$go = 1;
							
						}
					else
							{//do if anything needs to be done for no images put in
							}
						
			
			}
		}
		
		
		for($i=0;$i<12;$i++)
			{
				$target_path = "../docs/sbImprints/";
				$target_path = $target_path . "IMP_".$_POST['sbWebpage']."_".($i+1).".".findexts($_FILES['fileY']['name'][$i]); 
					if(move_uploaded_file($_FILES['fileY']['tmp_name'][$i], $target_path)) 
						{
							$mediaQry.="(null,".$_POST['sbID'].",'".$_POST['impName'][$i]."','".$target_path."','".$_POST['impSize'][$i]."','imp',".($i+1)."),"; 
							$go = 1;
							
						}
					else
							{
								if(strlen($_POST['impName'][$i]) > 0)
								$mediaQry.="(null,".$_POST['sbID'].", '".$_POST['impName'][$i]."',' ','".$_POST['impSize'][$i]."','imp',".($i+1)."),";
							}
						
			}
		
		
		if($go == 1)
				{
					 $mediaQry = substr($mediaQry,0,strlen($mediaQry) - 1);
					$mediaRes = $obj->query($mediaQry);	
				}
		
		////////////////////////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////AJAX RETURNS////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function temp()
if($_POST['q'] == 'getSBData')
{ 
	$obj = new db();
	$ret = array();
	$qry = "select * from sb_items where sbID = ".$_POST['ID'];
	$res = $obj->query($qry);
	$ret = $obj->fetch($res);
	
	$qry = "select * from sb_pricing where sbID = ".$_POST['ID'];
	$res = $obj->query($qry);
	while($ret[] = $obj->fetch($res) ) {}
	array_pop($ret);
	
	$qry = "select * from sb_media where sbID = ".$_POST['ID'];
	$res = $obj->query($qry);
	while($ret['media'][] = $obj->fetch($res) ) {}
	array_pop($ret['media']);
	
	$qry = "select * from af_vendor";
	$res = $obj->query($qry);
	$vendorDD="<select name=sbVendor><option></option>";
	while($data = $obj->fetch($res) )
	{
		if($ret['sbVendor'] == $data['v_id'])
		$vendorDD.="<option value=".$data['v_id']." selected=selected>".$data['v_abbr']."</option>";
		else
		$vendorDD.="<option value=".$data['v_id']." >".$data['v_abbr']."</option>";
	}
	$vendorDD.="</select>";
	$ret['vendors'] = $vendorDD;
	//parr($ret);
	echo  json_encode($ret);
}

if($_POST['q'] == 'putItemOnCat')
{

	$obj = new db();
	$ret = array();
	$build = array();
	$disp = "";
	$func = sortItem('bottom',$_POST['catID'],$_POST['itemID']);
	if($func)
	{
		$qry = "update sb_items set sbCatCount = sbCatCount + 1 where sbID = ".$_POST['itemID'];
		$res = $obj->query($qry);
		
		echo displaySortItem($_POST['catID']);
	}
	else
	echo 'error';
	
}


if($_POST['q'] == 'removeItemOnCat')
{ 
			$obj = new db();
			$qry = "select * from sb_category where sbCatID = ".$_POST['catID'];
			$res = $obj->query($qry);
			$data = $obj->fetch($res);
			
			$sort_array = array();
			$sort_array = unserialize($data['sbCatSort']); 
			
			if(is_array($sort_array) && in_array($_POST['itemID'],$sort_array))
			{
				$key = array_search($_POST['itemID'], $sort_array); 
				array_splice($sort_array, $key, 1); 
				$qry = "update sb_category set sbCatSort = '".serialize(array_filter($sort_array))."' where sbCatID = ".$_POST['catID'];
				$res = $obj->query($qry);
				
				$qry = "update sb_items set sbCatCount = sbCatCount - 1 where sbID = ".$_POST['itemID'];
				$res = $obj->query($qry);
			}
			
		echo displaySortItem($_POST['catID']);	
			
		}
		
if($_POST['q'] == 'putSortItem')
{
	$obj = new db();
	$qry = "update sb_category set sbCatSort = '".serialize(array_filter($_POST['serial']))."' where sbCatID = ".$_POST['catID'];
	$res = $obj->query($qry);
	
	serialize(array_filter($_POST['serial']));
}

if($_POST['q'] == 'getCategoryItems')
{
	$obj = new db();
	$catItems = displaySortItem($_POST['catID']);
	
	$qry = "select sbCatSort from sb_category where sbCatID = ".$_POST['catID'];
	$res = $obj->query($qry);
	$data = $obj->fetch($res);
	
	//if((array) unserialize($data['sbCatSort']) != NULL)
	//{	
		$i=0; $disp="<table width=100% cellpadding=0 cellspacing=0><tr><td colspan=4 class=\"noCat\">Highlited Items not in any Category</td></tr>";
		$qry = "select sbID, sbItemID, sbName,sbCatCount, sbNew from sb_items";
		$res = $obj->query($qry);
		while($data2 = $obj->fetch($res) )
		{
				if($data2['sbCatCount'] <= 0 || $data2['sbCatCount'] == NULL)
						$catCount = 'noCat';
				else
						$catCount = '';
					
		if($data2['sbNew'] == 'yes')
			if(in_array($data2['sbID'], (array) unserialize($data['sbCatSort'])))
				$disp.="<tr class=\"".$catCount." hilite\" ".col_bg('#f5f5f5',($i+1))."><td><input type=checkbox class=\"sbCheck noCat\" checked=\"checked\" name=sbItem value=".$data2['sbID']."></td><td><b>!</b></td><td><a href=\"#?w=750&v=edit&id=".$data2['sbID']."&org=open\" rel=\"popup_name\" class=\"poplight\" >".$data2['sbItemID']."</a></td><td>".$data2['sbName']."</td></tr>";
			else
				$disp.="<tr class=\"".$catCount." hilite\" ".col_bg('#f5f5f5',($i+1))."><td><input type=checkbox class=\"sbCheck \" name=sbItem value=".$data2['sbID']."></td><td><b>!</b></td><td><a href=\"#?w=750&v=edit&id=".$data2['sbID']."&org=open\" rel=\"popup_name\" class=\"poplight\" >".$data2['sbItemID']."</a></td><td>".$data2['sbName']."</td></tr>";
		else
			if(in_array($data2['sbID'], (array) unserialize($data['sbCatSort'])))
				$disp.="<tr class=\"".$catCount." hilite\" ".col_bg('#f5f5f5',($i+1))."><td><input type=checkbox class=\"sbCheck noCat\" checked=\"checked\" name=sbItem value=".$data2['sbID']."></td><td></td><td><a href=\"#?w=750&v=edit&id=".$data2['sbID']."&org=open\" rel=\"popup_name\" class=\"poplight\" >".$data2['sbItemID']."</a></td><td>".$data2['sbName']."</td></tr>";
			else
				$disp.="<tr  class=\"".$catCount." hilite\" ".col_bg('#f5f5f5',($i+1))."><td><input type=checkbox class=\"sbCheck \" name=sbItem value=".$data2['sbID']."></td><td></td><td><a href=\"#?w=750&v=edit&id=".$data2['sbID']."&org=open\" rel=\"popup_name\" class=\"poplight\" >".$data2['sbItemID']."</a></td><td>".$data2['sbName']."</td></tr>";
		$i++;
		}
	
	$disp.="</table>";
	//}
	$arr = array('sbItems'=>$disp, 'catItems' => $catItems);
	echo json_encode($arr);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////MISC FUNCTIONS//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function displaySortItem($catID)
{
		$obj = new db();
		$qry = "select sbCatSort from sb_category where sbCatID = $catID";
		$res = $obj->query($qry);
		$data = $obj->fetch($res);
		$sort = unserialize($data['sbCatSort']);
		
		if($sort != NULL)
		{
			$qry = "select a.sbID, a.sbItemID,b.sbMediaPath from sb_items a, sb_media b where a.sbID = b.sbID and b.sbMediaLoc = 1 and b.sbMediaType = 'img' and a.sbID in (".implode(",",array_filter($sort)).")"; 
			$res = $obj->query($qry);
			while($data2 = $obj->fetch($res) )
			{
				$build[$data2['sbID']]['sbItemID'] = $data2['sbItemID'];
				$build[$data2['sbID']]['sbMediaPath'] = $data2['sbMediaPath'];
			}
		
			for($i = 0; $i<sizeof($sort); $i++)
			{
				//$ret[$i]['sbID'] = $sort[$i];
				//$ret[$i]['sbItemID'] = $build[$sort[$i]]['sbItemID'];
				$disp.="<li class=sbCatItemsList id=".$sort[$i]."><img src=\"".$build[$sort[$i]]['sbMediaPath']."\" width=100px height=90px></li>";
			}
		
		}
		else
			$disp = "<li>No Items in this Category.</li>";
			
		return $disp;
}


function sortItem($where, $catID, $sbID)
{
$obj = new db();
if($catID)
	{
	switch($where)
	{
	case 'bottom':

		$catSort = array();
		$qry = "select sbCatSort from sb_category where sbCatID = $catID";
		$res = $obj->query($qry);
		$data = $obj->fetch($res);
		//$array = unserialize($data['projSort']);
		if($data['sbCatSort'] == NULL || $data['sbCatSort'] == '' )
			$catSort = (array)$sbID;
		else
			$catSort = array_merge( (array)unserialize($data['sbCatSort']), (array)$sbID);		

		$catSort = array_unique($catSort);
		$qry = "update sb_category set sbCatSort = '".serialize(array_filter($catSort))."'  where sbCatID = $catID";
		if($obj->query($qry))
			return true;
		else
			return false;
		break;
		
	}//end of switch	
	
	}//close of if catID
}	


function getCompetitorReport()
{
 			$ob = new db_module();
			
			
$qry = "select * from bt_items a, bt_pricing b where a.sbID = b.sbID order by a.sbID";
$res = $ob->query($qry);
while($data = $ob->fetch($res) )
{
	$id = $data['sbID'];
	$type = $data['sbType'];
	$ref[]=$data['sbID'];
	$arr[$id]['itemID'][] = $data['itemID'];
	$arr[$id]['itemName'][] = $data['itemName'];
	$arr[$id]['sbP1'][$type] = $data['sbP1'];
	$arr[$id]['sbP2'][$type] = $data['sbP2'];
	$arr[$id]['sbP3'][$type] = $data['sbP3'];
	$arr[$id]['sbP4'][$type] = $data['sbP4'];
	$arr[$id]['sbP5'][$type] = $data['sbP5'];
	$arr[$id]['sbP6'][$type] = $data['sbP6'];
	$arr[$id]['sbP7'][$type] = $data['sbP7'];
	$arr[$id]['sbP8'][$type] = $data['sbP8'];
	$arr[$id]['sbP9'][$type] = $data['sbP9'];
	$arr[$id]['sbP10'][$type] = $data['sbP10'];
	$arr[$id]['sbP11'][$type] = $data['sbP11'];
	$arr[$id]['sbP12'][$type] = $data['sbP12'];
	$arr[$id]['sbPriceName'][$type] = $data['sbPriceName'];
}
/*
array_unique($ref);
echo "<pre>";
print_r(array_unique($ref));
echo "</pre>";
echo "<pre>";
print_r($arr);
echo "</pre>";
*/

$ids = array_unique($ref);

foreach($ids as $key => $value)
{

	for($j =1; $j < 13; $j++)
	{
	
		
		if( $arr[$value]['sbP'.$j]['price'] > $arr[$value]['sbP'.$j]['cmp1'] && $arr[$value]['sbP'.$j]['cmp1']!= 0 )
			$disp[]=$arr[$value]['itemID'][1];
			
		if( $arr[$value]['sbP'.$j]['price'] > $arr[$value]['sbP'.$j]['cmp2'] && $arr[$value]['sbP'.$j]['cmp2']!= 0 )
			$disp[]=$arr[$value]['itemID'][1];
			
		if( $arr[$value]['sbP'.$j]['price'] > $arr[$value]['sbP'.$j]['cmp3'] && $arr[$value]['sbP'.$j]['cmp3']!= 0 )
			$disp[]=$arr[$value]['itemID'][1];
		
	}
}
if(is_array($disp))
$disp = array_unique($disp);



return $disp;
}
?>