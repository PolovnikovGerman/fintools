
   <?php include('mysql.php');          
            
            

	$obj = new db();
	$qry = "select miscData from misc where miscHead like 'search'";
	$res = $obj->query($qry);
	$dd = $obj->fetch($res);
	$qry = "update misc set miscData = '".$dd['miscData'].$_REQUEST['term']." | ' where miscHead like 'search'";
	$obj->query($qry);
	$qry = "select sbCatName from sb_category where sbCatName like '".$_REQUEST['term']."%'";
	$res = $obj->query($qry);
	if($obj->numrow($res) > 0)
	$data.='<h2>Categories</h2><ul>';
	while($ret = $obj->fetch($res) ) 
	{
	  $data.= "<li>".$ret['sbCatName']."</li>";
	}
	
	$qry = "select sbName from sb_items where sbName like '".$_REQUEST['term']."%'";
	$res = $obj->query($qry);
	if($obj->numrow($res) > 0)
	$data.='</ul><h2>Items</h2><ul>';
	while($ret = $obj->fetch($res) ) 
	{
	  $data.= "<li>".$ret['sbName']."</li>";
	}
	$data.="</ul>";
	$disp = array('disp'=>$data);
	echo json_encode($disp);

?>