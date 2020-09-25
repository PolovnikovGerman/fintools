<?php  if ($_SERVER['SERVER_NAME']!=='fintools.local')  session_start();
include_once('mysql.php');
		include_once('../controller/generic_functions.php');
		include_once('../includes/utility_functions.php'); 
		
		 ?>
 
 <?php
function uploadAttach()
{
$go=0; $ret = 1;
$attachName = $_POST['attachName'];
sizeof($_FILES['fileX']['name']);
$obj=new db();
$qry = "INSERT INTO dev_attachment VALUES ";
for ($i=0; $i < sizeof($_FILES['fileX']['name'])-1; $i++)
	{
	
		//last element always is empty in the files super global. thats why loop runs only till second last element
		$target_path = "../docs/dev/"; 
   		$target_path.=$_FILES['fileX']['name'][$i];
		$target_name=$attachName[$i];
	
		
   			if(move_uploaded_file($_FILES['fileX']['tmp_name'][$i], $target_path)) 
				{
				$qry.="(null,".$_POST['_id'].",'$target_name','$target_path',now()),";
				$go=1; 
				}
			else
				$ret = 0;
	} // FOR close
if($go){ 
	$qry = substr($qry,0,strlen($qry)-1);
		if(!$obj->query($qry)) 
			$ret =  0;
			
		}


return $ret;
}

/*****************************************************************************************************************************************************************/

function sortTask($where, $projID, $taskID, $prvID = 0)
{
$obj = new db();
if($projID)
	{
	switch($where)
	{
	case 'bottom':

		$projSort = array();
		 $qry = "select projSort from dev_project where projID = $projID";
		$res = $obj->query($qry);
		$data = $obj->fetch($res);
		//$array = unserialize($data['projSort']);
		if($data['projSort'] == NULL || $data['projSort'] == '' )
			$projSort = (array)$taskID;
		else
			$projSort = array_merge( (array)unserialize($data['projSort']), (array)$taskID);		

		
		$qry = "update dev_project set projSort = '".serialize($projSort)."'  where projID = $projID";
		if($obj->query($qry))
			return true;
		else
			return false;
		break;
		
	}//end of switch	
	
	}//close of if projID
}

/*$obj = new db();
		
		$array = array();
		$projSort = array();
		$qry   = "select projSort from dev_project where projID = 17";
		$res   = $obj->query($qry);
		$data  = $obj->fetch($res);
		$array = unserialize($data['projSort']);
		echo "<pre>";
		print_r($array);
		echo "</pre>";
*/
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
/************************************************************AJAX RETURNS*********************************************************************************/
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

/*********************************************************************************************************************************************************/
$obj = new db();
if(isset($_POST['q']) &&  $_POST['q']== 'getProj')
{
$qry = "select * from dev_project where projID = ".$_POST['projID'];
$res = $obj->query($qry);
$data = $obj->fetch($res);

echo json_encode($data);
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if(isset($_POST['q']) &&  $_POST['q']== 'addProj')
{

if($_SESSION['uid'] > 0 || $_SESSION['uid'] < 15)
{
$qry = "insert into dev_project values(null,'".$_POST['name']."','".$_POST['desc']."','".format_date($_POST['start'])."','".$_POST['notes']."','on','',now(),now(),".$_SESSION['uid'].")";
$res = $obj->query($qry);
	if($res)
	{
	$lastID = mysql_insert_id();
	$qry = "select ptmCat from client_info where user_id = ".$_SESSION['uid'];
	$data = $obj->fetch($obj->query($qry));
	$new = array();
	if($data['ptmCat'] != '')
	$new = unserialize($data['ptmCat']);
	$new[] = $lastID;
	$qry = "update client_info set ptmCat = '".serialize($new)."' where user_id = ".$_SESSION['uid'];
	$obj->query($qry);
		$ret['error']['status']=false;
	}
	else
	{
		$ret['error']['status']=true; $ret['error']['msg'] ='Add Project query failed.';
	}
}
else{
	$ret['error']['status']=true; 
	$ret['error']['msg']="Error: Logged In User Session ID missing.".$_SESSION['uid'];
}
echo json_encode($ret);
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if(isset($_POST['q']) &&  $_POST['q']== 'getProjects')
{
$qry = "select ptmCat from client_info where user_id = ".$_POST['user'];
$res = $obj->query($qry);
$data = $obj->fetch($res);
$arr = array();
$arr = unserialize($data['ptmCat']);

if($_POST['status'] == 'on')
$qry = "select * from dev_project where projStatus = 'on' and projUserID = ".$_POST['user']." order by projID asc ";
else
$qry = "select * from dev_project where  projUserID = ".$_POST['user']."   order by projID asc ";
$res = $obj->query($qry);
$result = "";
while( $data = $obj->fetch($res))
{
	$temp=$data['projID'];
	$pr[$temp]['projStatus'] = $data['projStatus'];
	$pr[$temp]['projName'] = $data['projName'];

}


if(!empty($arr))
foreach($arr as $key => $value)
{
		$result.="<div class=\"devPr proj_".$pr[$value]['projStatus']." prSortable\" id=pr_".$value.">".$pr[$value]['projName']."</div>";
}

$ret = array('projectList'=>$result);
echo json_encode($ret);
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'showProject')
{
$returnTask='';
$qry = "select projStatus, projNotes from dev_project where projID = ".$_POST['id'];
$res = $obj->query($qry);
$data = $obj->fetch($res);
$projStatus = $data['projStatus'];
$projNotes = $data['projNotes'];
/*$qry = "select * from dev_project a, dev_link b where a.projID = b.projID and a.projID = ".$_POST['id'];
$res = $obj->query($qry);
	
	while($data = $obj->fetch($res))
	    	$returnLink.=" <span id=link".$data['linkID'].">&nbsp;<a href=\"http://".$data['linkName']."\" target=_blank>".$data['linkName']."</a><span  onclick=remove(".$data['linkID'].",'link')>[x]</span>&nbsp;</span>  ";
			
	*/	
	




 

//retrieving the sort field and unserializing it to get the sort order on tasks
$qry = "select projSort from dev_project where projID = ".$_POST['id'];
$res = $obj->query($qry);
$data3 = $obj->fetch($res);



if($data3['projSort'] != NULL && $data3['projSort'] != '' )
{
	$sortTask = array();
	$sortTask = unserialize($data3['projSort']);
	$sortTaskStr = (implode(',',$sortTask) == '') ? 0 : implode(',',$sortTask);	
//GETTING ALL TASKS FOR A GIVEN PROJECT			
 $qry = "select * from dev_task where dtaskID in ($sortTaskStr) or projID = ".$_POST['id'];
$res = $obj->query($qry);



	$builder = array();//builder array to store all tasks with their taskid's as key in the array

//storing all tasks with taskid as the key in builder array inorder to display in the right sort
	while($data2 = $obj->fetch($res)){
			$builder[$data2['dtaskID']]['desc'] = $data2['dtaskDesc'];
			$builder[$data2['dtaskID']]['type'] = $data2['dtaskType'];
			$builder[$data2['dtaskID']]['status'] = $data2['dtaskStatus'];
			if($data2['dtaskNotes'] != '')
			$builder[$data2['dtaskID']]['notes'] = 'notesBlue';
			else
			$builder[$data2['dtaskID']]['notes'] = 'notesGray';
			
			
			}


 	for($i=0; $i<sizeof($sortTask); $i++)
	{
		if($_POST['status'] == 'on')
		{
			if($builder[$sortTask[$i]]['status'] == 'on' )
			$returnTask.="<div id=task_".$sortTask[$i]." class=\"".$builder[$sortTask[$i]]['type']." hover\"><table cellpadding=0px cellspacing=0px width=100%  ><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px  valign=top onclick=editTask(".$sortTask[$i].",'".$builder[$sortTask[$i]]['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox class=check id=".$sortTask[$i]."></td><td width=840px ><span id=taskDesc_".$sortTask[$i].">".$builder[$sortTask[$i]]['desc']."</span></td><td class=getNotes id=note".$sortTask[$i]."><div class=\"".$builder[$sortTask[$i]]['notes']."\"></div></td></table></div>";	
		}
		else if($_POST['status'] == 'off')
		{
			if($builder[$sortTask[$i]]['status'] == 'off' )
			$returnTask.="<div id=task_".$sortTask[$i]." class=\"".$builder[$sortTask[$i]]['type']." hover task_".$builder[$sortTask[$i]]['status']."\"><table cellpadding=0px cellspacing=0px width=100% ><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask(".$sortTask[$i].",'".$builder[$sortTask[$i]]['type']."')><span class=\"ui-icon ui-icon-pencil\"></span></td><td width=20px valign=top><input type=checkbox checked=checked  class=check id=".$sortTask[$i]."></td><td width=840px><span id=taskDesc_".$sortTask[$i].">".$builder[$sortTask[$i]]['desc']."</span></td><td class=getNotes id=note".$sortTask[$i]."><div class=\"".$builder[$sortTask[$i]]['notes']."\"></div></td></table></div>";	
			else
			$returnTask.="<div id=task_".$sortTask[$i]." class=\"".$builder[$sortTask[$i]]['type']." hover task_".$builder[$sortTask[$i]]['status']."\"><table cellpadding=0px cellspacing=0px width=100% ><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask(".$sortTask[$i].",'".$builder[$sortTask[$i]]['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox  class=check id=".$sortTask[$i]."></td><td width=840px><span id=taskDesc_".$sortTask[$i].">".$builder[$sortTask[$i]]['desc']."</span></td><td class=getNotes id=note".$sortTask[$i]."><div class=\"".$builder[$sortTask[$i]]['notes']."\"></div></td></table></div>";	
		}
	}//close for
}	
$ret = array('projectLink'=>$returnLink, 'taskText' => $returnTask, 'projStatus'=>$projStatus , 'projNotes' => $projNotes);


echo json_encode($ret);
}

if($_POST['q'] == 'renameProject')
{
 $qry = "update dev_project set projName = '".$_POST['name']."' where projID = ".$_POST['pr_id'];
 $res = $obj->query($qry);
 if($res)
 echo TRUE;
 else
 echo FALSE;
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'addLink')
{
$qry = "insert into dev_link values(null,".$_POST['id'].", '".$_POST['linkName']."',now())";

if($obj->query($qry))
{
	$lastid= mysql_insert_id();
	$ret = array('Link'=>" <span id=link".$lastid.">&nbsp;<a href=\"http://".$_POST['linkName']."\" target=_blank>".$_POST['linkName']."</a><span class=remove onclick=remove($lastid,'link')>[x]</span>&nbsp;</span> "); 
}
else
	$ret = array('error'=>'Error');

echo json_encode($ret);
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

if($_POST['q'] == 'showAttach')
{
$qry = "select * from dev_attachment where projID = ".$_POST['id'];
$res =$obj->query($qry);

$disp ="<table  width=\"100%\  cellpadding=\"0\" cellspacing=0><tr class=att_wrap_head><th >Upload Files</th><th align=right><img  onclick=\"hide('att_wrap')\"  src=\"../images/close.gif\"></th></tr>";
 while($data = $obj->fetch($res) )
  $disp.="<tr id=attach".$data['dattachID']." class=wrap_td ><td class=wrap_td><img  onclick=remove(".$data['dattachID'].",'attach') src=\"../images/delete_icon.gif\"><a href=\"".$data['dattachUrl']."\" target=\"_blank\">&nbsp;&nbsp;".$data['dattachName']."</a></td><td class=wrap_td>&nbsp;</td></tr>";
  
  $disp.="</table>";
 
 echo $disp;
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

if($_POST['q'] == 'remove')
{
if($_POST['type'] == 'attach')
$qry = "delete from dev_attachment where dattachID = ".$_POST['ID'];
else if($_POST['type'] == 'link')
$qry = "delete from dev_link where linkID = ".$_POST['ID'];

$obj->query($qry);
echo true;
}


/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'getNotes')
{
	$qry = "select dtaskNotes from dev_task where dtaskID = ".$_POST['notesID'];
	$res = $obj->query($qry);
	echo json_encode($obj->fetch($res));
}

if($_POST['q'] == 'saveNotes')
{
	$qry = "update dev_task set dtaskNotes = '".$_POST['taskNotes']."' where dtaskID = ".$_POST['notesID'];
	$res = $obj->query($qry);
	if(!res)
		echo false;
	else
		echo true;
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

if($_POST['q'] == 'addTask')
{ 

	if($_SESSION['uid'] == 1 || $_SESSION['uid'] == 2)
	{
		$arr =  $_POST['values'];
		
		if(!empty($arr)){
			if(in_array(88,$arr))
			{
					 $qry = "insert into dev_task values(null, ".$_POST['projID'].",'".$_POST['type']."', '".$_POST['task']."', 'on', now(),'".$_POST['notes']."' )";
					if($obj->query($qry))
					{
						$taskID = mysql_insert_id();
						for($i=0;$i<sizeof($arr)-1;$i++)
						{
						
								if($arr[$i] == $_SESSION['uid'])
									$rr = sortTask('bottom',$_POST['projID'],$taskID,0);
								else
									$rr = sortTask('bottom',$arr[$i],$taskID,0);
						}
					}
			}
			else
			{
				for($i=0;$i<sizeof($arr);$i++)
				{
				$qry = "insert into dev_task values(null, ".$_POST['projID'].",'".$_POST['type']."', '".$_POST['task']."', 'on', now(),'".$_POST['notes']."' )";
					if($obj->query($qry))
					{
						$taskID = mysql_insert_id();
						if($arr[$i] == $_SESSION['uid'])
							$rr = sortTask('bottom',$_POST['projID'],$taskID,0);
						else	
							$rr = sortTask('bottom',$arr[$i],$taskID,0);
						
						//$key = array_search($taskid, $sort_array); 
						//array_splice($sort_array, $key, 1); 
					}
				}
			}
		if(in_array($_SESSION['uid'],$arr))
		$ret = array('error' => false, 'task' => "<div id=task_$taskID class=\"".$_POST['type']." hover\"><table cellpadding=0px cellspacing=0px width=100%><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask($taskID,'".$_POST['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox class=check id=$taskID></td><td width=840px><span id=taskDesc_".$taskID.">".$_POST['task']."</span></td><td class=getNotes id=note".$taskID."><div class=\"notesGray\"></div></td></tr></table></div>", 'db' => $rr,'show' => true);
		else
		$ret = array('show' => false);
		}
		else
			$ret = array('error' => true,'msg' => 'Error : No User Selected', 'show' => true);
		echo json_encode($ret);
		
	
	}
	else
	{
	$qry = "insert into dev_task values(null, ".$_POST['projID'].",'".$_POST['type']."', '".$_POST['task']."', 'on', now(),'".$_POST['notes']."' )";
		if($obj->query($qry))
		{
			$taskID = mysql_insert_id();
			$rr = sortTask('bottom',$_POST['projID'],$taskID,0);
			$ret = array('error' => false, 'task' => "<div id=task_$taskID class=\"".$_POST['type']." hover\"><table cellpadding=0px cellspacing=0px width=100%><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask($taskID,'".$_POST['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox class=check id=$taskID></td><td width=840px><span id=taskDesc_".$taskID.">".$_POST['task']."</span></td><td class=getNotes id=note".$taskID."><div class=\"notesGray\"></div></td></tr></table></div>", 'db' => $rr,'show' => true);
		
		}
		else
			$ret = array('error' => true, 'reason' => 'Insert query failed');
	
		echo json_encode($ret);
	}
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

if($_POST['q'] == 'sortTask')
{
	if($_POST['projID'] > 0 )
	{
		$sortArray = str_replace('task_','',$_POST['task']);
		$qry = "update dev_project set projSort = '".serialize($sortArray)."' where projID = ".$_POST['projID'];
		$obj->query($qry);
	}
	print_r($sortArray);
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

if($_POST['q'] == 'sortProjects')
{
	if($_POST['userID'] > 0 )
	{
		$sortArray = str_replace('pr_','',$_POST['order']);
		$qry = "update client_info set ptmCat = '".serialize($sortArray)."' where user_id = ".$_POST['userID'];
		$obj->query($qry);
	}
	print_r($sortArray);
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/

if($_POST['q'] == 'toggleTask')
{
	if($_POST['status'] == 'on' || $_POST['status'] == 'off'){
	$qry = "update dev_task set dtaskStatus = '".$_POST['status']."' where dtaskID = ".$_POST['taskID'];
		if($obj->query($qry))
			echo true;
		else
			echo false;
	}
	else
		echo false;
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'getSections')
{
	$result = "<select id=changeSection><option value=0>select</option>";
	$qry = "select * from dev_project where projUserID = ".$_SESSION['uid'];
	$res = $obj->query($qry);
	while($data = $obj->fetch($res) )
		$result.="<option value=".$data['projID'].">".$data['projName']."</option>";
	$result.="</select>";
	echo $result;
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'changeSection')
{
	$taskid = $_POST['taskID'];
	 $qry = "select * from dev_project where projID = ".$_POST['from'];
			$res = mysql_query($qry);
			$data = mysql_fetch_array($res);
			
			$sort_array = array();
			$sort_array = unserialize($data['projSort']); 
			
			if(is_array($sort_array) && in_array($taskid,$sort_array))
			{
				$key = array_search($taskid, $sort_array); 
				array_splice($sort_array, $key, 1); 
				 $qry = "update dev_project set projSort = '".serialize($sort_array)."' where projID = ".$_POST['from'];
				$res = mysql_query($qry);
				if($res)
					sortTask('bottom',$_POST['to'],$taskid,0);
					
					echo true;
			}
			echo false;
		
}
/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/


if($_POST['q'] == 'closeProject')
{
	if($_POST['status'] == 'on' || $_POST['status'] == 'off'){
	$qry = "update dev_project set projStatus = '".$_POST['status']."' where projID = ".$_POST['projID'];
		if($obj->query($qry))
			echo true;
		else
			echo false;
	}
	else
		echo false;
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/



if($_POST['q'] == 'editTask')
{

	$qry = "update dev_task set dtaskDesc = '".$_POST['taskDesc']."', dtaskType = '".$_POST['taskType']."' where dtaskID = ".$_POST['taskID'];
		if($obj->query($qry))
			echo true;
		else
			echo false;
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
?>