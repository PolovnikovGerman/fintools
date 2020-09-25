var xmlhttp;
function update(l_id)
{
	
	
	var status=document.getElementById("status").value;
	
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="ajax_return.php";
url=url+"?q=99&st="+status+"&ven_id="+l_id; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged2;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged2()
{
if (xmlhttp.readyState==4)
{
	
document.getElementById("update_history").innerHTML=xmlhttp.responseText;
document.getElementById("status").value='';
}
}// JavaScript Document
var pos;
function delete_template(aa_id,p)
{

	pos=p;
	var ans = confirm("Confirm Delete!");
	if(ans)
	{
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="ajax_return.php";
		url=url+"?q=88&place="+p+"&aaid="+aa_id; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged3;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		
	}
}

function stateChanged3()
{
if (xmlhttp.readyState==4)
{
	
document.getElementById('is_attach'+pos).innerHTML=xmlhttp.responseText;


}
}// Ja

var ps;
function rm_img(image_id, position)
{
ps=position; 
var ans=confirm("Confirm Delete!");
if(ans)
{ 
	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="ajax_return.php";
		url=url+"?q=77&imgid="+image_id;  
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged5;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}//end of if
}

function stateChanged5()
{
if (xmlhttp.readyState==4)
{
	alert("hi");
document.getElementById('title'+ps).innerHTML=xmlhttp.responseText;
document.getElementById('img'+ps).src="../images/noimage.jpg";
	

}
}// Ja


function update_items(l_id)
{
	
	
	var status=document.getElementById("status").value;
	
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="ajax_return.php";
url=url+"?q=97&st="+status+"&ven_id="+l_id; 
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged4;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged4()
{
if (xmlhttp.readyState==4)
{
	
document.getElementById("update_history").innerHTML=xmlhttp.responseText;
document.getElementById("status").value='';
}
}// JavaScript Document


function move_section( pos, curr, gr, iid)
{


	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="ajax_return.php";
		url=url+"?q=63&pos="+pos+"&curr="+curr+"&gr="+gr+"&iid="+iid; 
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged5;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}

function stateChanged5()
{

if (xmlhttp.readyState==4)
{
document.getElementById("ret_section").innerHTML=xmlhttp.responseText;	
}
}

function remove_sec_item(itemid , secid)
{
alert(secid);
alert(itemid);

	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="ajax_return.php";
		url=url+"?q=53&sc="+secid+"&itm="+itemid; alert(url);
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged6;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
}
function stateChanged6()
{

if (xmlhttp.readyState==4)
{
document.getElementById("ret_section").innerHTML=xmlhttp.responseText;	
}
}
var imp_pos;
var place;
function delete_imprint(impid,plc)
{
	imp_pos=impid;
	place = plc;
	var ans=confirm("Confirm Delete!");
	if(ans)
	{
	
	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		}
		var url="ajax_return.php";
		url=url+"?q=28&impid="+imp_pos;  
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged8;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
}
function stateChanged8()
{

if (xmlhttp.readyState==4)
{
document.getElementById(imp_pos).innerHTML=xmlhttp.responseText;	
document.getElementById("loc"+imp_pos).innerHTML="<span id=subhead_white>"+place+"&nbsp;&nbsp;</span><input type=text size=10  name=iw_imploc[]  >";
document.getElementById("size"+imp_pos).innerHTML="<input type=text size=8  name=iw_impsize[]  >";
}
}

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



