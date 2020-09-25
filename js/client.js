// JavaScript Document
//HIDE MODULES
var vendor3=0;
function hide_modules()
{



var url_start="http://localhost/system/view/";


document.getElementById('new_sec').style.display='none';


if(document.getElementById('highlight_input').value!='')
{
	document.getElementById('vendor3').style.display='';
	vendor3=1;
	
}
else
	document.getElementById('vendor3').style.display='none';
	

}

function art_hide_modules()
{
	
//document.getElementById('att_wrap').style.display='none';	
//document.getElementById('loader').innerHTML='';

}
function hide_att()
{
document.getElementById('att_wrap').style.display='none';	
return true;
}

function hide(layer)
{

document.getElementById(layer).style.display='none';
document.getElementById(layer).innerHTML='';
return true;
}


function calculate_profit(temp)
{
	
	for( var i = 0; i <12; i++ )
	{
		var a = document.getElementById('p'+i).value;
		var b = document.getElementById('v'+temp+i).value;
		var c = document.getElementById('q'+i).value;
		document.getElementById('profit'+i).value=0;
		document.getElementById('pct'+i).value=0;
		if(a != '' && b !='' && c!='')
		{
		var profit=(parseFloat(a) - parseFloat(b)) * parseInt(c);
		document.getElementById('profit'+i).value=profit;
		var pct=(parseFloat(a) - parseFloat(b)) / parseFloat(a);
		document.getElementById('pct'+i).value=(Math.round(pct*100)/100) * 100 + '%';
		
		
		}
	}
	
}
function calculate_yahoo()
{
	var str=document.getElementById('p0').value;
	for( var i =1; i < 12; i++ )
	{
		if(document.getElementById('q'+i).value!='')
		{
			var a = document.getElementById('q'+i).value;
			var b = document.getElementById('p'+i).value;
			var c = parseFloat(a)* parseFloat(b);
			str+=" "+a+" "+(Math.round(c*100)/100);
		}
	}
	document.getElementById('yahoo').innerHTML=str;
	
	
	chosen="";
	tx= document.getElementsByName('group');

for (i = 0; i <3; i++) {
if (tx[i].checked) {
chosen = tx[i].value;

}
}

if (chosen == "") {
alert("No Vendor Chosen")
}
else {
calculate_profit(chosen);
}

	
}
/*
function updateClock ( )
{
  var currentTime = new Date ( );
 
  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );
 
  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
 
  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
 
  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
 
  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;
 
  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes +  timeOfDay;
 
  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}*/
 
function __dt(ob)
{
	var a = $(ob).val(); 
	if(a.length == 6)
    $(ob).val(a.substring(0,2)+'/'+a.substring(2,4)+'/'+a.substring(4,6));
}
function toggle_vendor3()
{
	if(vendor3==0)
	{
		document.getElementById('vendor3').style.display='';	
	
		vendor3=1;
	}
	else
	{
		document.getElementById('vendor3').style.display='none';
	
		vendor3=0;
	}

}

/*JAVASCRIPT FOR CHANGING ADDRESS TO INTERNATIONAL TYPE AND BACK TO USA TYPE*/
function change_add(value,ind)
{

var index=ind;
if(value=="usa")
{
document.getElementById('change_address' + index).innerHTML="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td><input type=\"text\" size=\"32\" name=\"vadd" + index + "_line1\" /></td></tr><tr><td colspan=\"2\"><input type=\"text\" size=\"32\" name=\"vadd" + index + "_line1\" /></td></tr><tr><td colspan=\"2\"><input type=\"text\" size=\"17\" name=\"vadd" + index + "_line1\"  />&nbsp;&nbsp;<select name=\"vadd" + index + "_state\"><option selected=\"selected\">MO</option></select></td></tr><tr><td colspan=\"2\" align=\"right\" id=\"small_font_vendors\">zip code:&nbsp;&nbsp;<input type=\"text\" size=\"10\" name=\"vadd" + index + "_zip\" /></td></tr> </table>"; 
}
else
{
document.getElementById('change_address' + index).innerHTML="<table><tr><td><input type=\"text\" size=\"32\" name=\"vadd" + index + "_line1\" /></td></tr><tr><td><input type=\"text\" size=\"32\" name=\"vadd" + index +"_line2\" /></td></tr><tr><td><input type=\"text\" size=\"32\" name=\"vadd" + index +"_line3\" /></td></tr><tr><td><input type=\"text\" size=\"32\" name=\"vadd" + index +"_line4\" /></td></tr></table>";
		 }
}
/*END OF JAVASCRIPT FOR CHANGING ADDRESS TO INTERNATIONAL TYPE AND BACK TO USA TYPE*/


/*JAVASCRIPT FOR CHANGING ADDRESS TO INTERNATIONAL TYPE AND BACK TO USA TYPE*/
var cc=4;
function add_contact()
{
	
	
	document.getElementById('c'+cc).innerHTML="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" ><tr><td><input type=\"text\" name=\"vcon"+cc+"_name\" /></td><td><input type=\"text\" name=\"vcon"+cc+"_tel\" size=\"13\" /></td> <td><input type=\"text\" name=\"vcon"+cc+"_fax\" size=\"3\" /></td><td><input type=\"text\" name=\"vcon"+cc+"_email\" /></td><td><input type=\"text\" name=\"vcon"+cc+"_notes\" /></td>   <td width=\"30px\"><input type=\"checkbox\" name=\"vcon"+cc+"_poemail\" value=\"yes\"  /></td><td width=\"25px\"><input type=\"checkbox\"  name=\"vcon"+cc+"_pofax\" value=\"yes\" /></td><td  width=\"30px\"><input type=\"checkbox\" name=\"vcon"+cc+"_artemail\"  value=\"yes\"/></td></tr></table><div id=\"c"+(++cc)+"\"></div>";

	document.getElementById('hidden').innerHTML="<input type=\"hidden\" value="+cc+" name=\"con_size\">";
		
	
}

function yellowddd(id)
{
$('#'+id).css('background-color','white');	
}
function yellow(id)
{

	if($('#'+id).val().length > 0)
	$('#'+id).css('background-color','white');
	else
	$('#'+id).css('background-color','#ffffa8');

}
function yellowdd(id,val)
{
	if(val != 0)
	$('#'+id).css('background-color','white');
	else
	$('#'+id).css('background-color','#ffffa8');
	
}

function r2_validate()
{
	var msg = '';
	var flag = true; 
	if($('#r2_vendor').val() == 0)
	{
	flag = false;
	msg+="Select a vendor\n";
	}
	
	if($('#r2_ship_date').val().length == 0)
	{
	flag = false;
	msg+="Enter a Ship Date\n";
	}
	if($('#r2_ship_act').val() == 0)
	{
	flag = false;
	msg+="Enter a Ship act\n";
	}
	if($('#r2_d1_date').val().length == 0)
	{
	flag = false;
	msg+="Enter a delivery date\n";
	}
	if($('#r2_d1_type').val() == 0)
	{
	flag = false;
	msg+="Enter a delivery method\n";
	}
	if($('#r2_d1_add').val().length == 0)
	{
	flag = false;
	msg+="Enter a delivery address\n";
	}
	if($('#r2_bill').val() == 0)
	{
	flag = false;
	msg+="Enter Bill Method\n";
	}
	if($("table.checklist").find("input:checked").length != 10)
	{
		msg+="Update Checklist\n";
		flag = false;
	}
	if($("#firstitem").val().length == 0)
	{
		msg+="Enter #1 ItemID\n";
		flag = false;
	}
		if($("#r2_qty0").val().length == 0)
	{
		msg+="Enter #1 Qty\n";
		flag = false;
	}
	if(!flag)
	alert(msg);
	
	return flag;
	
}





function validate_form()
{
	
if(document.getElementById('vendor_name').value=='')
{
	alert("Vendor Name Mandotory");
return false;
}

return true;
	
}

function DisplayContent( textid, bg )
{
	
	window.location.href = window.location.pathname + "?section_id=" + textid + "&bg=" +bg;
		
}
function DisplayPage(pg)
{
		$('#loader').html('<img src="../images/loader.gif">');
		window.location.href = window.location.pathname + "?page=" + pg; 
}
function DisplayDCPage(pg)
{
		$('#loader').html('<img src="../images/loader.gif">');
		window.location.href = window.location.pathname + "?pageDC=" + pg; 
}
function display_rev(val )
{
	
	window.location.href = window.location.pathname + "?rev=" + val;
		
}
function display_profit(val )
{
	
	window.location.href = window.location.pathname + "?prOrdNum=" + val;
		
}
function display_or(val )
{
	
	window.location.href = window.location.pathname + "?or=" + val;
		
}
function DisplaySection( textid )
{
	var cat=document.getElementById('task_cat').value;
	window.location.href = window.location.pathname + "?tsec=" + textid+"&cat="+cat;
		
}

function valid_ckbox()
{
	
	var chks=document.getElementsByName('chk[]');
	
	for (var i in chks)
	{
		if(chks[i].checked == true)
		return true;
	}
alert("No Items Checked");
	return false;
}
function edit_task(index, ret, taskid)
{
	
	if(document.getElementById('task_msg'+ret+index)== null)
	{
var value = document.getElementById(ret+'tasks'+index).innerHTML;
document.getElementById(ret+'tasks'+index).innerHTML = "<textarea id=\"task_msg"+ret+index+"\" rows=\"1\" class=task_msg cols=\"100\">"+value+"</textarea>&nbsp;<input  type=\"button\" onclick=\"update_task("+taskid+",'"+ret+"',"+index+")\" value=\"save\" id=\"save\">"; 
document.getElementById('task_msg'+ret+index).focus();
	}
}

function addsection()
{
	document.getElementById('new_sec').style.display="";
	document.getElementById('new_sec').innerHTML="<form name=addsec action=items_list.php method=post>enter&nbsp;name&nbsp;<input type=text name=sec_name>&nbsp;&nbsp;<input type=submit name=create id=save value=create></form>";
}
function task_section_add()
{
	var task_cat=document.getElementById('task_cat').value; 
	document.getElementById('new_sec').style.display="";
	document.getElementById('new_sec').innerHTML="<form name=addsec action=task.php method=post>enter&nbsp;name&nbsp;<input type=text name=task_sec_name id=newsec>&nbsp;&nbsp;<input type=hidden value="+task_cat+" name=task_cat><input type=submit name=create_sec id=save value=create></form>";
	document.getElementById('newsec').focus();
}

function task_cat_add()
{
	
	document.getElementById('new_sec').style.display="";
	document.getElementById('new_sec').innerHTML="<form name=addsec action=task.php method=post>enter&nbsp;name&nbsp;<input type=text name=task_cat_name id=newsec>&nbsp;&nbsp;<input type=submit name=create_cat id=save value=create></form>";
	document.getElementById('newsec').focus();
}

function task_section_close()
{
document.getElementById('new_sec').style.display='none';	
}

function loaderOn()
{
	$('#loader').html('<img src="../images/loader.gif">');
}
function loaderOff()
{
 $('#loader').html('');	
}
function show_json(data)
{
	alert(data);
	
}
function ajax_replace(msg)
{
	
 	 msg = msg.replace('#','%23');
	 msg = msg.replace('&','%26');
	 msg = msg.replace('+','%2b');	
	 return msg;
}

function changecss(theClass,element,value) {
	
	 var cssRules;

	 var added = false;
	 for (var S = 0; S < document.styleSheets.length; S++){

    if (document.styleSheets[S]['rules']) {
	  cssRules = 'rules';
	 } else if (document.styleSheets[S]['cssRules']) {
	  cssRules = 'cssRules';
	 } else {
	  //no rules found... browser unknown
	 }

	  for (var R = 0; R < document.styleSheets[S][cssRules].length; R++) {
	   if (document.styleSheets[S][cssRules][R].selectorText == theClass) {
	    if(document.styleSheets[S][cssRules][R].style[element]){
	    document.styleSheets[S][cssRules][R].style[element] = value;
	    added=true;
		break;
	    }
	   }
	  }
	  if(!added){
	  if(document.styleSheets[S].insertRule){
			  document.styleSheets[S].insertRule(theClass+' { '+element+': '+value+'; }',document.styleSheets[S][cssRules].length);
			} else if (document.styleSheets[S].addRule) {
				document.styleSheets[S].addRule(theClass,element+': '+value+';');
			}
	  }
	 }
	}