
   <?php include('mysql.php');          
            
            

	$obj = new db();
	$data = array();
	$qry = "select sbCatName from sb_category where sbCatName like '".$_REQUEST['term']."%'";
	$res = $obj->query($qry);
	if($obj->numrow($res) > 0)
	$data[] = array('label' => "CATEGORY",'value' => '');
	while($ret = $obj->fetch($res) ) 
	{
	  $data[] = array( 'label' => $ret['sbCatName'], 'value' => $ret['sbCatName']);
	}
	
	$qry = "select sbName from sb_items where sbName like '".$_REQUEST['term']."%'";
	$res = $obj->query($qry);
	if($obj->numrow($res) > 0)
	$data[] = array('label' => 'ITEMS','value' => '');
	while($ret = $obj->fetch($res) ) 
	{
	  $data[] = array( 'label' => $ret['sbName'], 'value' => $ret['sbName']);
	}
	
	echo json_encode($data);

?>