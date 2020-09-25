<?php
include_once('../controller/dev_controller.php');
include_once ('../model/mysql.php');

$obj = new db();


/*********************************************************************************************************************************************************/
if($_POST['q'] == 'getProj')
{
$qry = "select * from dev_project where projID = ".$_POST['projID'];
$res = $obj->query($qry);
$data = $obj->fetch($res);

echo json_encode($data);
}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'addProj')
{
$qry = "insert into dev_project values(null,'".$_POST['name']."','".$_POST['desc']."','".format_date($_POST['start'])."','".$_POST['notes']."','on','',now(),now())";
$res = $obj->query($qry);
if($res)
echo $ret['error']='false';
else{
$ret['error']='true'; $ret['error']['msg'] ='Add Project query failed.';
echo $ret;
}

}

/*********************************************************************************************************************************************************/
/*********************************************************************************************************************************************************/
if($_POST['q'] == 'getProjects')
{
$i=1;
if($_POST['status'] == 'on')
$qry = "select * from dev_project where projStatus = 'on' order by projID desc ";
else
$qry = "select * from dev_project  order by projID desc ";
$res = $obj->query($qry);
$result = "<table  border=\"0\"  cellpadding=\"2px\" cellspacing=\"3px\"  class=\"devProjects\"><tr>";
while( $data = $obj->fetch($res))
{
if($i%6 == 0)
$result.="<td width=152px class=\"devPr proj_".$data['projStatus']."\" id=pr_".$data['projID'].">".$data['projName']."</td></tr><tr>";
else
$result.="<td width=152px class=\"devPr proj_".$data['projStatus']."\"  id=pr_".$data['projID'].">".$data['projName']."</td>";

$i++;
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
$qry = "select * from dev_project a, dev_link b where a.projID = b.projID and a.projID = ".$_POST['id'];
$res = $obj->query($qry);
	
	while($data = $obj->fetch($res))
	    	$returnLink.=" <span id=link".$data['linkID'].">&nbsp;<a href=\"http://".$data['linkName']."\" target=_blank>".$data['linkName']."</a><span  onclick=remove(".$data['linkID'].",'link')>[x]</span>&nbsp;</span>  ";
			
			

//retrieving the sort field and unserializing it to get the sort order on tasks
$qry = "select projSort from dev_project where projID = ".$_POST['id'];
$res = $obj->query($qry);
$data3 = $obj->fetch($res);



if($data3['projSort'] != NULL && $data3['projSort'] != '' )
{
	$sortTask = array();
	$sortTask = unserialize($data3['projSort']);
		
//GETTING ALL TASKS FOR A GIVEN PROJECT			
$qry = "select * from dev_task where projID = ".$_POST['id'];
$res = $obj->query($qry);



	$builder = array();//builder array to store all tasks with their taskid's as key in the array

//storing all tasks with taskid as the key in builder array inorder to display in the right sort
	while($data2 = $obj->fetch($res)){
			$builder[$data2['dtaskID']]['desc'] = $data2['dtaskDesc'];
			$builder[$data2['dtaskID']]['type'] = $data2['dtaskType'];
			$builder[$data2['dtaskID']]['status'] = $data2['dtaskStatus'];
			
			}


 	for($i=0; $i<sizeof($sortTask); $i++)
	{
		if($_POST['status'] == 'on')
		{
			if($builder[$sortTask[$i]]['status'] == 'on' )
			$returnTask.="<div id=task_".$sortTask[$i]." class=\"".$builder[$sortTask[$i]]['type']." hover\"><table cellpadding=0px cellspacing=0px width=100% ><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px  valign=top onclick=editTask(".$sortTask[$i].",'".$builder[$sortTask[$i]]['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox class=check id=".$sortTask[$i]."></td><td ><span id=taskDesc_".$sortTask[$i].">".$builder[$sortTask[$i]]['desc']."</span></td></table></div>";	
		}
		else if($_POST['status'] == 'off')
		{
			if($builder[$sortTask[$i]]['status'] == 'off' )
			$returnTask.="<div id=task_".$sortTask[$i]." class=\"".$builder[$sortTask[$i]]['type']." hover task_".$builder[$sortTask[$i]]['status']."\"><table cellpadding=0px cellspacing=0px width=100% ><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask(".$sortTask[$i].",'".$builder[$sortTask[$i]]['type']."')><span class=\"ui-icon ui-icon-pencil\"></span></td><td width=20px valign=top><input type=checkbox checked=checked  class=check id=".$sortTask[$i]."></td><td ><span id=taskDesc_".$sortTask[$i].">".$builder[$sortTask[$i]]['desc']."</span></td></table></div>";	
			else
			$returnTask.="<div id=task_".$sortTask[$i]." class=\"".$builder[$sortTask[$i]]['type']." hover task_".$builder[$sortTask[$i]]['status']."\"><table cellpadding=0px cellspacing=0px width=100% ><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask(".$sortTask[$i].",'".$builder[$sortTask[$i]]['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox  class=check id=".$sortTask[$i]."></td><td ><span id=taskDesc_".$sortTask[$i].">".$builder[$sortTask[$i]]['desc']."</span></td></table></div>";	
		}
	}//close for
}	
$ret = array('projectLink'=>$returnLink, 'taskText' => $returnTask, 'projStatus'=>$projStatus , 'projNotes' => $projNotes);


echo json_encode($ret);
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

if($_POST['q'] == 'addTask')
{
	$qry = "insert into dev_task values(null, ".$_POST['projID'].",'".$_POST['type']."', '".$_POST['task']."', 'on', now(), now() )";
	if($obj->query($qry))
	{
		$taskID = mysql_insert_id();
		$rr = sortTask('bottom',$_POST['projID'],$taskID,0);
		$ret = array('error' => false, 'task' => "<div id=task_$taskID class=\"".$_POST['type']." hover\"><table cellpadding=0px cellspacing=0px width=100%><tr><td valign=top width=15px><span class=\"ui-icon ui-icon-arrow-2-n-s\" style=\"float:left\"></span></td><td width=20px valign=top onclick=editTask($taskID,'".$_POST['type']."')><span class=\"ui-icon ui-icon-pencil\" ></span></td><td width=20px valign=top><input type=checkbox class=check id=$taskID></td><td ><span id=taskDesc_".$taskID.">".$_POST['task']."</span></td></tr></table></div>", 'db' => $rr);
		
	}
	else
		$ret = array('error' => true, 'reason' => 'Insert query failed');
		
	echo json_encode($ret);

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