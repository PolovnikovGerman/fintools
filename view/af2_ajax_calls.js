// JavaScript Document

var xmlhttp;
var index;
function update_art(val, ordid)
{
	
index=val;
	
	var cust=document.getElementById('_cust'+val).value; 
	var dsc=document.getElementById('_desc'+val).value; 
	var notes=document.getElementById('_notes'+val).value; 
	

	 cust = cust.replace('#','%23');
	 cust = cust.replace('&','%26');
	 cust = cust.replace('+','%2b');
	 
	 dsc = dsc.replace('#','%23');
	 dsc = dsc.replace('&','%26');
	 dsc = dsc.replace('+','%2b');
	 
	 notes = notes.replace('#','%23');
	 notes = notes.replace('&','%26');
	 notes = notes.replace('+','%2b');
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="af2_ajax_return.php";
url=url+"?q=update_art&cust="+cust+"&dsc="+dsc+"&notes="+notes+"&val="+val+"&ord="+ordid; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_art_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function update_art_return()
{

if (xmlhttp.readyState==4)
{
	//alert(xmlhttp.responseText);
try{
	var theResponse = JSON.parse(xmlhttp.responseText); 
	}
	catch(err)
	{
	alert("Error in JSON response format");	
	}
	document.getElementById('art_cust'+index).innerHTML = theResponse.one; 
	document.getElementById('art_desc'+index).innerHTML = theResponse.two;
		document.getElementById('art_notes'+index).innerHTML = theResponse.three;

}
}

function edit_af(val,ord)
{
if(document.getElementById('_cust'+val) == null)
{
var v_c = document.getElementById('art_cust'+val).innerHTML; 
var v_d = document.getElementById('art_desc'+val).innerHTML; 
var v_n = document.getElementById('art_notes'+val).innerHTML; 
document.getElementById('art_cust'+val).innerHTML = "<input id=_cust"+val+" value=\""+v_c+"\" name=af_cust size=10>"; 
document.getElementById('art_desc'+val).innerHTML = "<input id=_desc"+val+" value=\""+v_d+"\" name=af_desc size=25>"; 
document.getElementById('art_notes'+val).innerHTML = "<input id=_notes"+val+" value=\""+v_n+"\" name=af_notes size=20><input  type=\"button\" onclick=update_art("+val+","+ord+") value=\"s\" id=\"save\">"; 
document.getElementById('_cust'+val).focus();	
}
}


function make_red(val,ind,ordid)
{ 
index = ind; 
var name = val.name; 
if(val.checked == 1)
{
	
	xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="af2_ajax_return.php";
url=url+"?q=toggle&col="+name+"&state=yes&ord="+ordid; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_toggle_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
	document.getElementById('art_rush'+index).style.backgroundColor='#ff2a00';
	document.getElementById('art_ord'+index).style.backgroundColor='#ff2a00';
	document.getElementById('art_cust'+index).style.backgroundColor='#ff2a00';
	document.getElementById('art_desc'+index).style.backgroundColor='#ff2a00';
	
}
else
{
	xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="af2_ajax_return.php";
url=url+"?q=toggle&col="+name+"&state=no&ord="+ordid; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_toggle_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
	var col; 
	if(parseInt(index)%2 == 0) { col = "#ececec"; } else { col = "#ffffff"; } 
		document.getElementById('art_rush'+index).style.backgroundColor=col;
		document.getElementById('art_ord'+index).style.backgroundColor=col;
		document.getElementById('art_cust'+index).style.backgroundColor=col;
		document.getElementById('art_desc'+index).style.backgroundColor=col;	
}
}

function update_toggle_return()
{
if (xmlhttp.readyState==4)
{
	/*if(xmlhttp.responseText == 'yes')
	{
		document.getElementById('art_rush'+num).style.backgroundColor='#ff2a00';
		document.getElementById('art_ord'+num).style.backgroundColor='#ff2a00';
		document.getElementById('art_cust'+num).style.backgroundColor='#ff2a00';
		document.getElementById('art_desc'+num).style.backgroundColor='#ff2a00';
	}
	else if(xmlhttp.responseText == 'no')
	{
		var col; 
	if(parseInt(num)%2 == 0) { col = "#ececec"; } else { col = "#ffffff"; } 
		document.getElementById('art_rush'+num).style.backgroundColor=col;
		document.getElementById('art_ord'+num).style.backgroundColor=col;
		document.getElementById('art_cust'+num).style.backgroundColor=col;
		document.getElementById('art_desc'+num).style.backgroundColor=col;
	}*/
}
}






function make_green(val,num, nm, ordid)
{ 
index = num;
var name = val.name; 
if(val.checked == 1)
{
		
	xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="af2_ajax_return.php";
url=url+"?q=toggle&col="+name+"&state=yes&ord="+ordid; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_toggle_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
	document.getElementById(nm+index).style.backgroundColor='#2DEA4E';
}
else
{
		
	xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="af2_ajax_return.php";
url=url+"?q=toggle&col="+name+"&state=no&ord="+ordid; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_toggle_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
	var col; 
	if(parseInt(index)%2 == 0) { col = "#ececec"; } else { col = "#ffffff"; } 
	document.getElementById(nm+index).style.backgroundColor=col;
		
}
}
/* ############################################################### ART FULLFILLMENT ######################################################## */
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var ret_area;

function update_task(taskid,area,index)
{
ret_area = area+'tasks'+index;
var msg=document.getElementById('task_msg'+area+index).value;  

     msg = msg.replace('#','%23');
	 msg = msg.replace('&','%26');
	 msg = msg.replace('+','%2b');
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="task_ajax_return.php";
url=url+"?q=update_task&taskid="+taskid+"&msg="+msg; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_task_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function update_task_return()
{

if (xmlhttp.readyState==4)
{
document.getElementById(ret_area).innerHTML=xmlhttp.responseText;	
}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////MOVE TASK/////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function move_task( pos, curr, sec,  iid,live)
{
	var cat=document.getElementById('task_cat').value;
if(pos!= 0) {

	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="task_ajax_return.php";
		url=url+"?q=change_order&pos="+pos+"&curr="+curr+"&sec="+sec+"&iid="+iid+"&cat="+cat+"&live="+live; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged5;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}
}

function stateChanged5()
{

if (xmlhttp.readyState==4)
{
	
document.getElementById("task_area").innerHTML=xmlhttp.responseText;

}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////MOVE TASK ACTIVE/////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function move_task_active( pos, curr, sec,  iid)
{
var cat=document.getElementById('task_cat').value;	
if(pos!= 0) {

	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="task_ajax_return.php";
		url=url+"?q=change_order&pos="+pos+"&curr="+curr+"&sec="+sec+"&iid="+iid+"&cat="+cat; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged6;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}
}

function stateChanged6()
{

if (xmlhttp.readyState==4)
{
	
document.getElementById("active_area").innerHTML=xmlhttp.responseText;

}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function close_task(taskid,secid, x, live)
{
	var cat=document.getElementById('task_cat').value;
if(document.getElementById("close"+x).checked = true)
{ 
	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="task_ajax_return.php";
		url=url+"?q=close_task&taskid="+taskid+"&secid="+secid+"&cat="+cat+"&live="+live; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=closetask;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}
}

function closetask()
{

if (xmlhttp.readyState==4)
{	
	//alert(xmlhttp.responseText);
//	var theResponse = xmlHttp.responseText.split('@');
//document.getElementById('task_area').innerHTML = theResponse[0];
//document.getElementById('active_area').innerHTML = theResponse[1];
	//alert(xmlhttp.responseText);
	//document.getElementById("task_area").innerHTML="Can you hear me now?"; 
	
	try{
	var theResponse = JSON.parse(xmlhttp.responseText); 
	}
	catch(err)
	{
	alert("Error in JSON response format");	
	}
	document.getElementById('task_area').innerHTML = theResponse.firstResponse; 
	document.getElementById('active_area').innerHTML = theResponse.secondResponse;
}
}

//////////////////////////////////////////////////////////////////////////////////////MOVE TASK/////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function make_task_active( taskid,  tasktype)
{
	var taskcat=document.getElementById('task_cat').value;
	var tsec = document.getElementById("get_tsec").value;
if(tsec != '') {

	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="task_ajax_return.php";
		url=url+"?q=make_task_active&taskid="+taskid+"&secid="+tsec+"&cat="+taskcat+"&type="+tasktype; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=showactivetask;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}
else{ alert("Please Choose a Task Section."); }
}

function showactivetask()
{

if (xmlhttp.readyState==4)
{
document.getElementById("active_area").innerHTML=xmlhttp.responseText;

}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function make_task_inactive( hiliteid , taskid)
{
	var taskcat=document.getElementById('task_cat').value;
	var tsec = document.getElementById("get_tsec").value;
if(tsec != '') {

	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="task_ajax_return.php";
		url=url+"?q=make_task_inactive&hid="+hiliteid+"&taskid="+taskid+"&secid="+tsec+"&cat="+taskcat; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=showinactivetask;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}
else{ alert("Please Choose a Task Section."); }
}

function showinactivetask()
{

if (xmlhttp.readyState==4)
{
document.getElementById("active_area").innerHTML=xmlhttp.responseText;

}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}// JavaScript Document

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////