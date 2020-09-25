// JavaScript Document

var xmlhttp;
var index;

function clean_string(st)
{
st = st.replace('#','%23');
st = st.replace('&','%26');
st = st.replace('+','%2b');
return st;
}

function update_master(val, ordid, chid)
{
	$('#loader').html('<img src="../images/loader.gif">');
index=val;

var v_c = clean_string(document.getElementById('_cust'+val).value);
var v_d = clean_string(document.getElementById('_desc'+val).value);
//var v_v = clean_string(document.getElementById('_ven'+val).value);
//var v_sh = clean_string(document.getElementById('_shdate'+val).value);
var v_s = clean_string(document.getElementById('_shnotes'+val).value);
var v_n = clean_string(document.getElementById('_notes'+val).value);



xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="fl_ajax_return.php";
url=url+"?q=update_master&cust="+v_c+"&dsc="+v_d+"&notes="+v_n+"&val="+val+"&ord="+ordid+"&shnotes="+v_s+"&chid="+chid;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_master_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function update_master_return()
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

	document.getElementById('af_cust'+index).innerHTML = theResponse.one;
	document.getElementById('af_desc'+index).innerHTML = theResponse.two;
		$('#af_notes'+index).html(theResponse.three.substring(0,25));
		//var a = theResponse.three.substring(0,30); alert(a);
		//document.getElementById('af_ven'+index).innerHTML = theResponse.four;
	//document.getElementById('af_shdate'+index).innerHTML = theResponse.five;
		$('#af_shnotes'+index).html(theResponse.six.substring(0,10));
		//if(theResponse.five != '')
		//document.getElementById('af_shdate'+index).style.backgroundColor='#ff2a00';
		/*if(theResponse.four != '')
		{
			//document.getElementById('af_ven'+index).style.backgroundColor='#ff2a00';
			document.getElementById('af_po'+index).style.backgroundColor='#ff2a00';
		}
		else
		{
			if((parseInt(index) % 2) == 0)
			{
			//document.getElementById('af_ven'+index).style.backgroundColor='#ececec';
			document.getElementById('af_po'+index).style.backgroundColor='#ececec';
			}
			else
			{
			//document.getElementById('af_ven'+index).style.backgroundColor='#ffffff';
			document.getElementById('af_po'+index).style.backgroundColor='#ffffff';
			}
		}*/
$('#loader').html('');
}
}


function update_child(chid)
{
index=chid;
var val=chid;
//var v_v = clean_string(document.getElementById('_ch_ven'+val).value);
//var v_sh = clean_string(document.getElementById('_ch_shdate'+val).value);
var v_s = clean_string(document.getElementById('_ch_shnotes'+val).value);
var v_n = clean_string(document.getElementById('_ch_notes'+val).value);



xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="fl_ajax_return.php";
url=url+"?q=update_child&notes="+v_n+"&val="+val+"&shnotes="+v_s+"&chid="+chid;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=update_child_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function update_child_return()
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

	$('#ch_notes'+index).html(theResponse.one.substring(0,25));
//	document.getElementById('ch_ven'+index).innerHTML = theResponse.two;
	//	document.getElementById('ch_shdate'+index).innerHTML = theResponse.three;
		$('#ch_shnotes'+index).html(theResponse.four.substring(0,10));
		/*if(theResponse.three != '')
		document.getElementById('ch_shdate'+index).style.backgroundColor='#ff2a00';
	if(theResponse.two != '')
		{
			document.getElementById('ch_ven'+index).style.backgroundColor='#ff2a00';
			document.getElementById('ch_po'+index).style.backgroundColor='#ff2a00';
		}
		else
		{
			if((parseInt(index) % 2) == 0)
			{
			document.getElementById('ch_ven'+index).style.backgroundColor='#ececec';
			document.getElementById('ch_po'+index).style.backgroundColor='#ececec';
			}
			else
			{
			document.getElementById('ch_ven'+index).style.backgroundColor='#ffffff';
			document.getElementById('ch_po'+index).style.backgroundColor='#ffffff';
			}
		}*/

}
}
function new_ven()
{
	document.getElementById('att_wrap').style.display='';

document.getElementById('att_wrap').innerHTML="<form action=fullfillment.php method=post><table style=\"font-size:12px;\" width=100% cellspacing=0 cellpadding=3 border=0><tr bgcolor=lightgray><td colspan=3 ><b>ADDING A NEW VENDOR</b></td><td align=right><img onclick=hide('att_wrap') src=\"../images/close.gif\"></tr><tr><td align=right>Name : </td><td align=left><input name=v_name type=text></td><td align=right>Vendor Type : </td><td align=left><select name=v_type><option value=domestic>domestic</option><option value=chinese>chinese</option></select></td></tr><tr><td align=right>Address :</td><td><textarea name=v_address rows=3 cols=10 style=\"overflow:hidden;\" wrap=\"hard\"></textarea></td><td align=right>7 letter Abbr</td><td align=left><input name=v_abbr type=text></td></tr><tr><td align=right>Phone : </td><td align=left><input type=text name=v_phone></td><td align=\"left\" colspan=\"2\">Vendor Memos</td></tr><tr><td align=right>Email Address : </td><td align=left><input name=v_email type=text></td><td colspan=2><textarea name=v_memos rows=4 style=\"overflow:hidden;\" wrap=\"hard\"></textarea></td></tr><tr><td colspan=4 align=right><input name=newven_post type=submit value=save id=save></td></tr></table><form>";
}
function new_ff_ven()
{
	document.getElementById('att_wrap').style.display='';

document.getElementById('att_wrap').innerHTML="<form action=ff_vendors.php method=post><table style=\"font-size:12px;\" width=100% cellspacing=0 cellpadding=3 border=0><tr bgcolor=lightgray><td colspan=3 ><b>ADDING A NEW VENDOR</b></td><td align=right><img onclick=hide('att_wrap') src=\"../images/close.gif\"></tr><tr><td align=right>Name : </td><td align=left><input name=v_name type=text></td><td align=right>Vendor Type : </td><td align=left><select name=v_type><option value=domestic>domestic</option><option value=chinese>chinese</option></select></td></tr><tr><td align=right>Address :</td><td><textarea name=v_address rows=4 cols=18 style=\"overflow:hidden;\" wrap=\"hard\"></textarea></td><td align=left>7 letter Abbr</td><td align=left><input name=v_abbr type=text></td></tr><tr><td align=right>Phone : </td><td align=left><input type=text name=v_phone></td><td align=\"left\" colspan=\"2\">Vendor Memos</td></tr><tr><td align=right valign=bottom>Email Address : </td><td align=left valign=bottom><input name=v_email type=text></td><td colspan=2><textarea name=v_memos rows=4 cols=33 style=\"overflow:hidden;\" wrap=\"hard\"></textarea></td></tr><tr><td colspan=4 align=right><input name=newven_post type=submit value=save id=save></td></tr></table><form>";
}

function edit_af(val,ord,ch)
{
if($('#_cust'+val).val() == null) {
var v_c = document.getElementById('af_cust'+val).innerHTML;
var v_d = document.getElementById('af_desc'+val).innerHTML;
var v_v = document.getElementById('af_ven'+val).innerHTML;
var v_sh = document.getElementById('af_shdate'+val).innerHTML;
//var v_s = document.getElementById('af_shnotes'+val).innerHTML;
//var v_n = document.getElementById('af_notes'+val).innerHTML;

var v_s; var v_n;
$.post('fl_ajax_return.php',{q:'getFullAf',val:ch}, function(data) {
																  var obj = JSON.parse(data);
																   $('#af_shnotes'+val).html('<input id=_shnotes'+val+' value="'+obj.shipnotes+'" name=af_ship_notes size=8>');
																   $('#af_notes'+val).html('<input id=_notes'+val+' value="'+obj.notes+'" name=af_notes size=19>&nbsp;<input  type="button" onclick=update_master('+val+','+ord+','+ch+') value=\"s\" id=\"save\">');
																   $('#af_cust'+val).html('<input id=_cust'+val+' value="'+obj.custName+'" name=af_cust size=12>');
																   $('#af_desc'+val).html('<input id=_desc'+val+' value="'+obj.custDesc+'" name=af_desc size=14>');
																  });

//document.getElementById('af_shdate'+val).innerHTML = "<input id=_shdate"+val+" value=\""+v_sh+"\" name=af_ship_date size=5>";
//document.getElementById('af_shnotes'+val).innerHTML = "<input id=_shnotes"+val+" value=\""+v_s+"\" name=af_ship_notes size=8>";
///document.getElementById('af_ven'+val).innerHTML = "<select name=af_ven id=_ven"+val+"><option value="+v_v+">"+v_v+"</option><option value=min>min</option><option value=kcp>kcp</option><option onclick='new_ven()'>new</option></select>";
//document.getElementById('af_notes'+val).innerHTML = "<input id=_notes"+val+" value=\""+v_n+"\" name=af_notes size=19>&nbsp;<input  type=\"button\" onclick=update_master("+val+","+ord+","+ch+") value=\"s\" id=\"save\">";
}
}


function edit_ch(ch)
{
if($('#_ch_notes'+ch).val() == null)	{
	var val=ch;
//var v_v = document.getElementById('ch_ven'+val).innerHTML;
//var v_sh = document.getElementById('ch_shdate'+val).innerHTML;
var v_s = document.getElementById('ch_shnotes'+val).innerHTML;
var v_n = document.getElementById('ch_notes'+val).innerHTML;

$.post('fl_ajax_return.php',{q:'getFullAf',val:ch}, function(data) {
																  var obj = JSON.parse(data);

//document.getElementById('ch_shdate'+val).innerHTML = "<input id=_ch_shdate"+val+" value=\""+v_sh+"\" name=ch_ship_date size=5>";
$('#ch_shnotes'+val).html("<input id=_ch_shnotes"+val+" value=\""+obj.shipnotes+"\" name=ch_ship_notes size=8>");
//document.getElementById('ch_ven'+val).innerHTML = "<select name=ch_ven id=_ch_ven"+val+"><option></option><option value="+v_v+">"+v_v+"</option><option value=min>min</option><option value=kcp>kcp</option></select>";
$('#ch_notes'+val).html("<input id=_ch_notes"+val+" value=\""+obj.notes+"\" name=ch_notes size=16>&nbsp;<input  type=\"button\" onclick=update_child("+val+")  value=\"s\" id=\"save\">");
															 });
}
}
function edit_chn(ch)
{
	if($('#_chn_notes'+ch).val() == null)
	{
		var val_sh = $('#chn_sh'+ch).html();
		var val_notes = $('#chn_notes'+ch).html();

		$.post('fl_ajax_return.php',{q:'getFullChn',id:ch}, function(data) {
																  var obj = JSON.parse(data);

		$('#chn_sh'+ch).html('<textarea id=_chn_sh'+ch+' class=small_font cols=7 rows=10>'+obj.shipNotes+'</textarea>').css('font-size','8px');
		$('#chn_notes'+ch).html('<textarea id=_chn_notes'+ch+'  class=small_font cols=16 rows=10  name=chn_notes>'+obj.chnNotes+'</textarea>&nbsp;<input  type=\"button\" onclick=update_chn('+ch+')  value=\"s\" id=\"save\">').css('font-size','8px');

	});
}
}
function update_chn(val)
{
$('#loader').html('<img src="../images/loader.gif">');
$.post('fl_ajax_return.php',{q:'update_chn',child : val, shipCust : $('#_chn_sh'+val).val(), notes : $('#_chn_notes'+val).val()} , function(data){
																																			var obj=JSON.parse(data);
															$('#chn_sh'+val).html('<a class=info >'+obj.ch_ship_notes.substring(0,10)+'<span>'+obj.ch_ship_notes+'</span></a>').css('font-size','11px');
															$('#chn_notes'+val).html('<a class=info >'+obj.ch_notes.substring(0,22)+'<span>'+obj.ch_notes+'</span></a>').css('font-size','11px');
																																			$('#loader').html('');
																																			});
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
var url="fl_ajax_return.php";
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
var url="fl_ajax_return.php";
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


function r2_hist_post(cid)
{
	$('#loader').html('<img src="../images/loader.gif">');
	var msg = $('#hist_msg').val();
	$.post('fl_ajax_return.php', { q:"post_history", msg: msg, cid: cid}, function(data) {
																			   $('#histTable tr:first').before(data);
																			   $('#hist_msg').val('');
																			   	$('#loader').html('');
																			   });
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
function child_toggle(chid, val,ind,  col)
{
index = chid;
var state;

	if(confirm("Are you Sure?")){


if(val.checked == 1 && col == 'ch_issue_ck')
{
	state = 'yes';
	document.getElementById(col+chid).style.backgroundColor='#fdae03';
}
else if(val.checked == 1 && col!='ch_issue_ck')
{
	state = 'yes';
	document.getElementById(col+chid).style.backgroundColor='#ff2a00';
}
else
{
	state = 'no';
	if(parseInt(ind)%2 == 0) { var colr = "#ececec"; } else { var colr = "#ffffff"; }
	document.getElementById(col+chid).style.backgroundColor=colr;
}

xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="fl_ajax_return.php";
url=url+"?q=child_toggle&chid="+chid+"&state="+state+"&col="+col;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=child_toggle_return;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

}
else{
if(val.checked == 1)
	val.checked = 0;
else
	val.checked = 1;
}
}
function child_toggle_return()
{

if (xmlhttp.readyState==4)
{
//alert(xmlhttp.responseText);
}
}

//////////////////////////////////////////////////////////////////////////////////////MOVE TASK/////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function add_PO(ind, chid, title, oid)
{
if(title == 'B') ti = 'C'; if(title == 'C') ti = 'D'; 	 if(title == 'D') ti = 'E';
chid++; v=ind+1;

if(title == 'E'){ return false; }
else
document.getElementById('po_child'+chid).innerHTML="<div id=po_child"+chid+"><table width=970px border=0 cellpadding=0 cellspacing=0 class=task_today_entry ><tr align=\"center\"><td width=\"45px\"  >&nbsp;</td><td width=\"120px\"  >&nbsp;</td><td width=\"115px\"  >&nbsp;</td><td width=\"35px\"  >&nbsp;</td><td width=\"35px\"  >&nbsp;</td><td width=\"70px\"  >&nbsp;</td><td width=\"35px\" id=ch_po"+chid+"  ><span onclick=onclick=add_PO(v,"+chid+",'"+ti+"',"+oid+")>"+title+"</td><td width=\"75px\"  >&nbsp;</td><td width=\"35px\" id=ch_placed_ck"+chid+" ><span id=icon_"+chid+" onclick=send_data("+oid+",'poart','yes',"+chid+",'"+title+"')><img src=\"../images/attch_icon.png\" ></span></td><td width=\"35px\"  id=ch_conf_ck"+chid+"><input type=checkbox  onclick=\"child_toggle("+chid+",this,"+ind+",'ch_conf_ck')\"></td><td width=\"100px\"  align=\"left\"  id=ch_ship_ck"+chid+"  ><input type=checkbox  onclick=\"child_toggle("+chid+",this,"+ind+",'ch_ship_ck')\"><span id=ch_shnotes"+chid+"   ondblclick=edit_ch("+chid+")><input id=_ch_shnotes"+chid+" type=text size=8></span></td><td width=\"35px\" id=ch_cust_ck"+chid+"><input type=checkbox onclick=\"child_toggle("+chid+",this,"+ind+",'ch_cust_ck')\"></td><td width=\"35px\"  id=ch_issue_ck"+chid+"  ><input type=checkbox  onclick=\"child_toggle("+chid+",this,"+ind+",'ch_issue_ck')\"></td><td width=\"175px\"  id=ch_notes"+chid+"   ondblclick=edit_ch("+chid+")><input id=_ch_notes"+chid+" type=text size=16><input  type=\"button\" onclick=update_child("+chid+")  value=\"s\" id=\"save\"></td></tr></table></div>";


}


function get_ven_details(val)
{
if(val != 0)
$.get('fl_ajax_return.php?q=getvendetails&val='+val, function(data) {
															  		var obj=JSON.parse(data);
																	document.getElementById('r2_ven_add').value=obj.v_address;
																	$('#r2_venmemos').html(obj.v_memos);
																	$('#r2_ph').html(obj.v_phone);
																	$('#r2_email').html(obj.v_email);

																  });
else
{
	document.getElementById('r2_ven_add').value='';
																	$('#r2_venmemos').html('');
																	$('#r2_ph').html('');
																	$('#r2_email').html('');

}
}

function get_item_details(val,index)
{

$('#loader').html('<img src="../images/loader.gif">');
if(val!='' && val.length > 0)
$.get('fl_ajax_return.php?q=getitemdetails&val='+val, function(data) {

																	var obj=JSON.parse(data);

																	$('#r2_desc'+index).html('<input class=\"normal_font nobg\" type=text size=60 name=r2_desc'+index+' value="'+obj.i_desc+'">');
																	if(index == 0)
																	$('#r2_qty_cover'+index).html('<input class=\"yellow normal_font nobg\"  id=r2_qty'+index+' name=r2_qty'+index+' size=3 type=text>');
																	else
																	$('#r2_qty_cover'+index).html('<input class=\"normal_font nobg\" id=r2_qty'+index+' name=r2_qty'+index+' size=3 type=text>');

																	$('#r2_price_cover'+index).html('<input class=\"normal_font nobg\" id=r2_price'+index+' name=r2_price'+index+' size=3 type=text value='+obj.i_price+'>');
																	$('#r2_pref_ven'+index).html('<i>'+obj.i_ven+'</i>');
																	if(obj.i_oth_ven != ''){
																	$('#att_wrap').html('<table width=100% cellspacing=0 ><tr bgcolor=#f89898><td align=center><b>Notes</b></td><td align=right><img onclick=hide("att_wrap") src=\"../images/close.gif\"></td></tr><tr><td colspan=2>'+obj.i_oth_ven+'</td></tr></table>').addClass('jrPopup').css('display','');
																	$('#r2_notes'+index).html('<a class=info href=#><img src=\"../images/magnify.gif\"><span>'+obj.i_oth_ven+'</span></a>');
																	}
																  $('#loader').html('');
																  });
else
{
	$('#r2_desc'+index).html('');
	if(index == 0)
	$('#r2_qty_cover'+index).html('<input type=text size=2 class=\"yellow nobg\" id=r2_qty0>');
	else
	$('#r2_qty_cover'+index).html('');
	$('#r2_price_cover'+index).html('');
	$('#r2_total'+index).html('');
	$('#r2_pref_ven'+index).html('<input type=text size=2 class=\"normal_font nobg\">');
    $('#loader').html('');
}
}
var vl;
function edit_ven(venid)
{

	$('#loader').html('<img src="../images/loader.gif">');
	$('#vendorMsg').html('');
	$('#ff_v_email').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
        $('#ff_v_additional_email').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
	$('#ff_v_abbr').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
	$('#ff_v_name').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');

	$('#saveVendor').html('<input name=newven_post type="button" onclick=save_ven() value=SAVE id=save>&nbsp;&nbsp;&nbsp;');
	$('#td_'+vl).css('background-color','white');
	$('#td_'+vl).css('color','black');
	vl = venid;
	$('#td_'+vl).css('background-color','#0000ff');
	$('#td_'+vl).css('color','white');

$.get('fl_ajax_return.php?q=getvendetails&val='+venid, function(data) {
        var obj=JSON.parse(data);
        $('#loader').html('');
        $('#ven_head').html(obj.v_name);
        $('#ff_v_name').val(obj.v_name);
        $('#ff_v_type').val(obj.v_type);
        $('#ff_v_address').val(obj.v_address);
        $('#ff_v_memos').val(obj.v_memos);
        $('#ff_v_phone').val(obj.v_phone);
        $('#ff_v_abbr').val(obj.v_abbr);
        $('#ff_v_email').val(obj.v_email);
        $('#ff_v_additional_email').val(obj.v_additional_email)
        $('#ven_id').val(obj.v_id);
        $('#ff_ven_name').html(obj.v_name);
});

}
function addNewVen()
{
	$('#ff_ven_name').html('New Vendor').css('background-color','#0000ff').css('color','white').css('font-weight','bold');
	$('#td_'+vl).css('background-color','white');
	$('#td_'+vl).css('color','black');
	$('#vendorMsg').html('');
	$('#ff_v_email').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
        $('#ff_v_additional_email').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
	$('#ff_v_abbr').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
	$('#ff_v_name').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');

    $('#ff_v_name').val('');
    $('#ff_v_type').val('');
    $('#ff_v_address').val('');
    $('#ff_v_memos').val('');
    $('#ff_v_phone').val('');
    $('#ff_v_abbr').val('');
    $('#ff_v_email').val('');
    $('#ff_v_additional_email').val('')
    $('#saveVendor').html('<input name=newven_post type="button" onclick=saveNewVen() value=SAVE id=save>&nbsp;&nbsp;&nbsp;');

}
function checkVendorFields()
{
$('#vendorMsg').html('').css('color','red');
	$('#ff_v_email').css('border','1px #c0c0c0 solid').css('background-color','#FFffff').css('color','#2d2d2d');
	$('#ff_v_abbr').css('border','1px #c0c0c0 solid').css('background-color','#FFffff').css('color','#2d2d2d');
	$('#ff_v_name').css('border','1px #c0c0c0 solid').css('background-color','#FFffff').css('color','#2d2d2d');

var ret = true;
if($('#ff_v_email').val().length < 5 )
{
	$('#vendorMsg').html('Enter Marked Field(s).').css('color','red');
	$('#ff_v_email').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
	ret = false;
}
if(!$('#ff_v_name').val().length > 0)
{
	$('#vendorMsg').html('Enter Marked Field(s).').css('color','red');
	$('#ff_v_name').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
	ret = false;
}
if(!$('#ff_v_abbr').val().length > 0)
{
	$('#vendorMsg').html('Enter Marked Field(s).').css('color','red');
	$('#ff_v_abbr').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
	ret = false;
}
return ret;
}
function saveNewVen()
{
    if(checkVendorFields()){
        $('#loader').html('<img src="../images/loader.gif">');
        $('#vendorMsg').html('');
        $('#ff_v_email').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
        $('#ff_v_abbr').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');

        var name=$('#ff_v_name').val();
        var type=$('#ff_v_type').val();
        var address=$('#ff_v_address').val();
        var memos=$('#ff_v_memos').val();
        var phone=$('#ff_v_phone').val();
        var abbr=$('#ff_v_abbr').val();
        //var email=$('#ff_v_email').val();
        //$('#vl_'+vl).html(name);
        //$('#ff_ven_name').html('');
        $.post("fl_ajax_return.php",{
            q:"addNewVendor",
            name: name,
            type: type,
            address: address,
            memos: memos,
            phone: phone,
            abbr: abbr,
            email: $('#ff_v_email').val(),
            addemail: $('#ff_v_additional_email').val()
            }, function(data) {
            var vv = parseInt(data);
            if(vv == 1)
            {
                $('#vendorMsg').html('Below entered Email already exists. Please enter another Email Id.').css('color','red');
                $('#ff_v_email').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#loader').html('');
            }
            else if(vv == 3)
            {
                $('#vendorMsg').html('Below entered Email & Abbreviation already exists. Please enter another Email Id & Abbreviation.').css('color','red');
                $('#ff_v_email').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#ff_v_abbr').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#loader').html('');
            }
            else if(vv == 2)
            {
                $('#vendorMsg').html('Below entered Abbreviation already exists. Please enter another Abbreviation.').css('color','red');
                $('#ff_v_abbr').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#loader').html('');
            }
            else if(vv > 3){


                vl=vv;


                $('#vendorListTable tr:first').before('<tr><td style=\"border-bottom:1px #c0c0c0 solid;cursor:pointer;\" width=234px  id=td_'+vv+' onclick=edit_ven('+vv+',0)>&nbsp;&nbsp;&nbsp;<span class=ven_list id=vl_'+vv+'>'+name+'</span></td></tr>').addClass('point');
                $('#saveVendor').html('<input name=newven_post type="button" onclick=save_ven() value=SAVE id=save>&nbsp;&nbsp;&nbsp;');
                $('#ff_ven_name').html(name).css('background-color','#0000ff').css('color','white').css('font-weight','bold');
                $('#td_'+vv).css('background-color','#0000ff');
                $('#td_'+vv).css('color','white');
                $('#ven_id').val(vv);
                $('#loader').html('');
                $('#fadeMessage').html('Vendor Added').css('display','').addClass('fadeMessage').fadeOut(3000,0);


            }


        });
    }

}
function save_ven()
{
    if(checkVendorFields()){
        $('#loader').html('<img src="../images/loader.gif">');

        $('#vendorMsg').html('');
        $('#ff_v_email').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
        $('#ff_v_abbr').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');
        $('#ff_v_name').css('border','1px #6C6C6C solid').css('background-color','white').css('color','#2d2d2d');

        var venid=$('#ven_id').val();
        var name=$('#ff_v_name').val();
        var type=$('#ff_v_type').val();
        var address=$('#ff_v_address').val();
        var memos=$('#ff_v_memos').val();
        var phone=$('#ff_v_phone').val();
        var abbr=$('#ff_v_abbr').val();
        //var email=$('#ff_v_email').val();
        //$('#vl_'+vl).html(name);
        //$('#ff_ven_name').html('');
        $.post("fl_ajax_return.php",{
            q:"save_vendors",
            val: venid ,
            name: name,
            type: type,
            address: address,
            memos: memos,
            phone: phone,
            abbr: abbr,
            email: $('#ff_v_email').val(),
            addemail: $('#ff_v_additional_email').val()
            }, function(data) {
            var vv = parseInt(data);
            if(vv == 1)
            {
                $('#vendorMsg').html('Below entered Email already exists. Please enter another Email Id.').css('color','red');
                $('#ff_v_email').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#loader').html('');
            }
            else if(vv == 3)
            {
                $('#vendorMsg').html('Below entered Email & Abbreviation already exists. Please enter another Email Id & Abbreviation.').css('color','red');
                $('#ff_v_email').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#ff_v_abbr').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#loader').html('');
            }
            else if(vv == 2)
            {
                $('#vendorMsg').html('Below entered Abbreviation already exists. Please enter another Abbreviation.').css('color','red');
                $('#ff_v_abbr').css('border','1px #CA240D dashed').css('background-color','#FFEFD7').css('color','blue');
                $('#loader').html('');
            }
            if(vv > 3){
                $('#td_'+vl).html('&nbsp;&nbsp;&nbsp;'+name).addClass('ven_list');

                $('#loader').html('');
                $('#fadeMessage').html('Vendor Added').css('display','').addClass('fadeMessage').fadeOut(3000,0);

            }


        });
    }
}


function tot(ind)
{
		var a = $('#r2_qty'+ind).val();
			var b = $('#r2_price'+ind).val();
			var c = parseFloat(a)* parseFloat(b);
c=Math.round(parseFloat(c)*100)/100;
			if(isNaN(c))
			$('#r2_total'+ind).html('');
			else
			$('#r2_total'+ind).html(c.toFixed(2));
			var sum=0.00;
			for(var i=0;i<10;i++)
			{
				if(isFinite(document.getElementById('r2_total'+i).innerHTML) && document.getElementById('r2_total'+i).innerHTML!='' )
				sum+=parseFloat(document.getElementById('r2_total'+i).innerHTML);
			}
			 document.getElementById('r2_grand').innerHTML='$'+sum.toFixed(2);
			  document.getElementById('r2_grand_total').value=sum.toFixed(2);
}
/*
document.getElementById(whr+chid).innerHTML="<div>
<table width=915px border=0 cellpadding=0 cellspacing=0 class=task_today_entry >
<tr align=\"center\">
<td width=\"45px\"  >&nbsp;</td>
<td width=\"100px\"  >&nbsp;</td>
<td width=\"150px\"  >&nbsp;</td>
<td width=\"35px\"  >&nbsp;</td>
<td width=\"35px\"  >&nbsp;</td>
<td width=\"70px\" id=ch_shdate"+chid+" ><input id=_ch_shdate"+chid+" type=text size=5></td>
<td width=\"35px\"  >"+title+"</td>
<td width=\"75px\" id=ch_ven"+chid+" ><select id=_ch_ven"+chid+" ><option></option></select></td>
<td width=\"35px\"  ><input type=checkbox></td>
<td width=\"35px\" ><input type=checkbox></td>
<td width=\"100px\"  align=\"left\"  ><input type=checkbox><span id=ch_shnotes"+chid+"><input id=_ch_shnotes"+chid+" type=text size=8></span></td>
<td width=\"35px\"  ><input type=checkbox></td>
<td width=\"150px\"  id=ch_notes"+chid+" ><input id=_ch_notes"+chid+" type=text size=16><input  type=\"button\" onclick=update_child("+chid+")  value=\"s\" id=\"save\"></td></tr></table></div>";	*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function edit_ffitems(ind,id)
{

if($('#ffi_itemidin_'+ind).val() == null){
	$("#loader").html('<img src="../images/loader.gif">');
	itemid = $('#ffi_itemid_'+ind).html();
	desc = $('#ffi_desc_'+ind).html();
	price = $('#ffi_price_'+ind).html();
	ven = $('#ffi_ven_'+ind).html();
	notes = $('#ffi_notes_'+ind).html();
	$.post("fl_ajax_return.php",{ q:"get_item_notes", id : itemid }, function(data) {

																	var obj=JSON.parse(data);
																	if(data){

																	$('#ffi_notes_'+ind).html('<textarea cols=59 rows=3  id=ffi_notesin_'+ind+'>'+obj.i_oth_ven+'</textarea>');
																	$('#ffi_itemid_'+ind).html('<input type=text size=6 value=\"'+itemid+'\" id=ffi_itemidin_'+ind+'><input type=hidden value='+id+' id=ffi_idin_'+ind+'>');
$('#ffi_desc_'+ind).html('<input type=text size=33 value=\"'+desc+'\" id=ffi_descin_'+ind+'>');
$('#ffi_price_'+ind).html('<input type=text size=2 value='+price+' id=ffi_pricein_'+ind+'>');
$('#ffi_ven_'+ind).html('<input type=text size=10 value=\"'+ven+'\" id=ffi_venin_'+ind+'>');
//$('#ffi_notes_'+ind).html('<textarea cols=43 rows=3  id=ffi_notesin_'+ind+'>'+notes+'</textarea>');
$('#ffi_submit_'+ind).html('<input type=submit onclick=update_ffitems('+ind+') id=save value=S>');
																$("#loader").html('');
																	}});
}
}
function update_ffitems(ind)
{

	$('#loader').html('<img src="../images/loader.gif">');
	itemid = $('#ffi_itemidin_'+ind).val();
		id = $('#ffi_idin_'+ind).val();
	desc = $('#ffi_descin_'+ind).val();
	price = $('#ffi_pricein_'+ind).val();
	ven = $('#ffi_venin_'+ind).val();
	notes = $('#ffi_notesin_'+ind).val();
	//var email=$('#ff_v_email').val();

	$.post("fl_ajax_return.php",{ q:"save_ff_items", id : id, itemid: itemid , desc: desc, price: price, ven: ven, notes: notes }, function(data) {

																	var obj=JSON.parse(data);
																	if(data){

																	$('#ffi_itemid_'+ind).html(obj.i_itemid);
																	$('#ffi_desc_'+ind).html(obj.i_desc);
																	$('#ffi_price_'+ind).html(obj.i_price);
																	$('#ffi_ven_'+ind).html(obj.i_ven);
																	$('#ffi_notes_'+ind).html(obj.i_oth_ven.substring(0,70));
																	$('#ffi_submit_'+ind).html('');
																	$('#loader').html('');
																	}
																	else
																	alert('Server Upload Error');

																																													  });
}

function add_ffitem()
{
$('#att_wrap').css('display','');


$('#att_wrap').html('<form action=ff_items.php method=post><table style=\"font-size:12px;\" width=100% cellspacing=0 cellpadding=3 border=0><tr bgcolor=lightgray><td colspan=3 ><b>ADDING A NEW ITEM</b></td><td align=right><img onclick=hide(\"att_wrap\") src=\"../images/close.gif\"></tr><tr><td align=right>Item-ID : </td><td align=left><input name=i_itemid type=text></td><td align=right>Description </td><td align=left><input name=i_desc type=text></td></tr><tr><td align=right>Price :</td><td><input type = text name = i_price></td><td align=right>Vendor :</td><td align=left><input name=i_ven type=text></td></tr><tr><td align=right>Notes :</td><td align=left colspan=3><textarea name=i_notes rows=2 cols=63 style=\"overflow:hidden;\" wrap=\"hard\"></textarea></td></tr><tr><td colspan=4 align=right><input name=ffitems_post type=submit value=save id=save></td></tr></table><form>');
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