<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php
function create_task_section()
{

$obj = new db();
$qry = "insert into task_section values(null,".$_POST['task_cat'].",'".$_POST['task_sec_name']."',now(),".$_SESSION['uid'].")";
$res=$obj->query($qry);
$last_id=mysql_insert_id();
$qry = "insert into task_sort values(null,$last_id,null,".$_POST['task_cat'].")";
$qry2 = "insert into task_dead_sort values(null,$last_id,null,".$_POST['task_cat'].")";

$res=$obj->query($qry);
$res2=$obj->query($qry2);

return $last_id;
}
function create_task_category()
{
$obj=new db();
$qry = "insert into task_cat values(null,'".$_POST['task_cat_name']."',now(),".$_SESSION['uid'].")";
$res=$obj->query($qry);
if($res)
{
$last_id=mysql_insert_id();
$qry = "insert into task_sort values(null,".$_SESSION['uid'].",null,$last_id)";
$qry2 = "insert into task_dead_sort values(null,".$_SESSION['uid'].",null,$last_id)";
$res=$obj->query($qry);
$res2=$obj->query($qry2);
return $last_id;
}

return 0;
}

function display_active($sec,$cat)
{
$obj = new db(); $disp='';
$sort = array();

if($_SESSION['status'] == 'closed')
$sort = $obj->get_sort_dead_order($sec,$cat);  
else if($_SESSION['status'] == 'open')
$sort = $obj->get_sort_order($sec,$cat); 


$qry = "select * from task_roll a, task_active b where a.task_status = '".$_SESSION['status']."' AND a.task_id = b.task_id and b.section_id = $sec and b.hilite_cat = '$cat' order by hilite_id DESC";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$tid=$data['task_id'];
$active['task_id'][$tid]=$data['task_id'];
$active['hilite_id'][$tid]=$data['hilite_id'];
$active['task_msg'][$tid]=$data['task_msg'];
$active['hilite_cat'][$tid]=$data['hilite_cat'];
$active['task_type'][$tid]=$data['task_type'];
 
}
for($i=0;$i<sizeof($active['task_id']);$i++) {
	if($active['task_type'][$sort[$i]] == 'head')
	{
	$disp.="<div><table width=\"915px\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" class=\"task_today_entry\" ><tr class=task_head><td width=\"25px\" align=center>".($i+1).".</td><td width=\"35px\" align=center><input type=\"checkbox\"  onclick=close_task(".$active['task_id'][$sort[$i]].",".$_SESSION['uid'].",$i,$sec)  /></td><td width=\"780px\">".$active['task_msg'][$sort[$i]]."</td><td width=\"35px\">";
$disp.="<select name=\"order\" onchange=\"move_task_active(this.value,".($i+1).",$sec,".$active['task_id'][$sort[$i]].")\" ><option value=\"0\">--</option>";
for($j=1;$j<=sizeof($active['task_id']);$j++)
	{ $disp.="<option value=$j>$j</option>"; }

$disp.="</td><td width=\"35px\" align=center><input type=\"checkbox\"  onclick=\"make_task_inactive(".$active['hilite_id'][$sort[$i]].",".$active['task_id'][$sort[$i]].")\"  /></td></tr></table></div>";
	}//enf of if for head/task
	else
	{
	$disp.="<div><table width=\"915px\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" class=\"task_today_entry\" ><tr ".col_bg('#F7C8AC',$i)."><td width=\"25px\" align=center>".($i+1).".</td><td width=\"35px\" align=center><input type=\"checkbox\"  onclick=close_task(".$active['task_id'][$sort[$i]].",".$_SESSION['uid'].",$i,$sec)  /></td><td width=\"780px\">".$active['task_msg'][$sort[$i]]."</td><td width=\"35px\">";
$disp.="<select name=\"order\" onchange=\"move_task_active(this.value,".($i+1).",$sec,".$active['task_id'][$sort[$i]].")\" ><option value=\"0\">--</option>";
for($j=1;$j<=sizeof($active['task_id']);$j++)
	{ $disp.="<option value=$j>$j</option>"; }

$disp.="</td><td width=\"35px\" align=center><input type=\"checkbox\"  onclick=\"make_task_inactive(".$active['hilite_id'][$sort[$i]].",".$active['task_id'][$sort[$i]].")\"  /></td></tr></table></div>";
	}//end of else for head/task
}//end of for.
	

return $disp;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************   DISPLAY COMON TASK *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function display($sec,$cat,$live)
{

$obj = new db(); $disp=''; $show = array(); $sort = array();
if($_SESSION['status'] == 'closed')
$sort = $obj->get_sort_dead_order($sec,$cat);  
else if($_SESSION['status'] == 'open')
$sort = $obj->get_sort_order($sec,$cat);  

$qry = "select * from task_roll where task_status = '".$_SESSION['status']."' and task_userid = ".$_SESSION['uid']." and task_cat = $cat order by task_id DESC";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$tid=$data['task_id'];
$show['task_id'][$tid]=$data['task_id'];
$show['task_msg'][$tid]=$data['task_msg'];
$show['task_cat'][$tid]=$data['task_cat'];
$show['task_type'][$tid]=$data['task_type'];
 
} 
for($i=0;$i<sizeof($show['task_cat']);$i++) {
	if($show['task_type'][$sort[$i]] == 'head')
	{
	$disp.="<div><table width=915px border=0 cellpadding=1 cellspacing=0 class=task_today_entry ><tr class=task_head><td width=25px align=center>".($i+1).".</td><td width=\"35px\" align=center><input id=close$i 						type=\"checkbox\" onclick=close_task(".$show['task_id'][$sort[$i]].",$sec,$i,$live) /></td><td width=\"780px\"  id=alltasks$i ondblclick=edit_task($i,'all',".$show['task_id'][$sort[$i]].") >".$show['task_msg'][$sort[$i]]."</td><td width=\"35px\" align=center>";
$disp.="<select name=\"order\" onchange=\"move_task(this.value,".($i+1).",".$_SESSION['uid'].",".$show['task_id'][$sort[$i]].",$live)\" ><option value=\"0\">--</option>";
for($j=1;$j<=sizeof($show['task_id']);$j++)
	{ $disp.="<option value=$j>$j</option>"; }

$disp.="</td><td width=\"35px\" align=center><input type=\"checkbox\" name=\"hilite".($i+1)."\" onclick=\"make_task_active(".$show['task_id'][$sort[$i]].",'head')\"  /></td></tr></table></div>";
	}//closing of if with task_type
else
	{
	$disp.="<div><table width=915px border=0 cellpadding=1 cellspacing=0 class=task_today_entry ><tr ".col_bg('#ececec',$i)."><td width=25px align=center>".($i+1).".</td><td width=\"35px\" align=center><input id=close$i 						type=\"checkbox\" onclick=close_task(".$show['task_id'][$sort[$i]].",$sec,$i,$live) /></td><td width=\"780px\"  id=alltasks$i ondblclick=edit_task($i,'all',".$show['task_id'][$sort[$i]].") >".$show['task_msg'][$sort[$i]]."</td><td width=\"35px\" align=center>";
$disp.="<select name=\"order\" onchange=\"move_task(this.value,".($i+1).",".$_SESSION['uid'].",".$show['task_id'][$sort[$i]].",$live)\" ><option value=\"0\">--</option>";
for($j=1;$j<=sizeof($show['task_id']);$j++)
	{ $disp.="<option value=$j>$j</option>"; }

$disp.="</td><td width=\"35px\" align=center><input type=\"checkbox\" name=\"hilite".($i+1)."\" onclick=\"make_task_active(".$show['task_id'][$sort[$i]].",'task')\"  /></td></tr></table></div>";
	}
}//end of for.

return $disp;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////*******************************   DISPLAY COMON TASK *****************************************//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function slider($cat)
{
$obj=new db();
$qry = "select * from task_section where section_cat = ".$cat." ORDER BY section_datetime DESC";
$res = $obj->query($qry);
while($data = $obj->fetch($res))
{
	$slider['sec_id'][]=$data['section_id'];
	$slider['sec_name'][]=$data['section_name'];
}

return $slider;
}

function cat_menu($uid)
{
$obj=new db();
$qry = "select * from task_cat where cat_userid = ".$uid;
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$cat_menu['id'][]=$data['cat_id'];
$cat_menu['name'][]=substr($data['cat_name'],0,12);
}
return $cat_menu;
}

function create_cat($uid,$name)
{
$obj=new db();
$qry = "insert into task_cat values(null,'$name',now(),$uid)";
$res = $obj->query($res);
return $res;
}
?>