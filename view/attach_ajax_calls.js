function do_attach(artid,type,chid,chpo)
{
	$('#loader').html('');
	var orderid=artid;
	//document.getElementById('att_wrap').style.display='';
	if(type == 'poart')
	$('#att_wrap').append('<form action="attach_iframe.php" onsubmit=change_icon('+orderid+',\'poart\',\'green\','+chid+',"'+chpo+'") target=\'atchiframe\' method="post" enctype="multipart/form-data" name="upload_form" ><div id="upload_form"></div><div id="mUpload"><label class="browse">&nbsp;&nbsp;<input type="file" id="element_input"  class="upload" name="fileX[]" size=1 /></label><br /> <br /><input type=hidden name=chpo value='+chpo+'><input type=hidden name=artid value='+artid+'><input type=hidden name=chid value='+chid+'><input type=hidden name=_type value='+type+'><span class=crt_po onclick=hide("att_wrap")>&nbsp;&nbsp;&nbsp;<a href="TEMP_UI.php?oid='+artid+'&&chid='+chid+'&&chpo='+chpo+'" target=_blank onclick=change_icon2('+orderid+','+chid+',"'+chpo+'")><span class=blue>Create PO</span></a></span><span id="save_button"><input type="submit" name="upload" value="Upload" id="save"/></span></div></form>');
	else if(type == 'clay' || type == 'prv')
	$('#att_wrap').append('<form action="attach_iframe.php" onsubmit=change_icon('+orderid+',"'+type+'",\"green\",'+chid+',"'+chpo+'") target=\'atchiframe\' method="post" enctype="multipart/form-data" name="upload_form" ><div id="upload_form"></div><div id="mUpload"><label class="browse">&nbsp;&nbsp;<input type="file" id="element_input"  class="upload" name="fileX[]" size=1 /></label><br /> <br /><input type=hidden name=chpo value='+chpo+'><input type=hidden name=artid value='+artid+'><input type=hidden name=chid value='+chid+'><input type=hidden name=_type value='+type+'><img src="../images/reqChangeBtn.jpg" id=reqChangeBtn onclick=reqChange('+chid+',"'+type+'")><textarea  id="reqChangeMsg" style="margin-bottom:5px;" cols=40 rows=1></textarea><span id="save_button"><input type="submit" name="upload" value="Upload" id="save"/></span></div></form>');
	else
	$('#att_wrap').append('<form action="attach_iframe.php" onsubmit=change_icon('+orderid+',"'+type+'",\"green\",'+chid+',"'+chpo+'") target=\'atchiframe\' method="post" enctype="multipart/form-data" name="upload_form" ><div id="upload_form"></div><div id="mUpload"><label class="browse">&nbsp;&nbsp;<input type="file" id="element_input"  class="upload" name="fileX[]" size=1 /></label><br /> <br /><input type=hidden name=chpo value='+chpo+'><input type=hidden name=artid value='+artid+'><input type=hidden name=chid value='+chid+'><input type=hidden name=_type value='+type+'><span id="save_button"><input type="submit" name="upload" value="Upload" id="save"/></span></div></form>');
	
		var fileMax = 12;
	$('#upload_form').before('<div id="files_list" style="padding:5px;background:#fff;font-size:small;"></div>');
	$("input.upload").change(function(){
	doIt(this, fileMax);
});
}
function change_icon2(aid,ch,chpo)
{
$('#icon_'+ch).html('<span onclick=send_data('+aid+',\'poart\',\'yes\','+ch+','+chpo+')><img class=point src=\"../images/open_icon.png\"></span>');
}


function change_icon(artid,ty,color,cid,chpo)
{ 
if(color == 'green')
{
document.getElementById('att_wrap').style.display='none';	
if(ty == 'poart' )
$('#icon_'+cid).html('<span onclick=send_data('+artid+',\''+ty+'\',\'yes\','+cid+','+chpo+')><img class=point src=\"../images/open_icon.png\"></span>');
else if(ty == 'clay' || ty == 'prv' )
$('#icon_'+ty+cid).html('<span onclick=send_data('+artid+',\''+ty+'\',\'yes\','+cid+','+chpo+')><img class=point src=\"../images/open_icon.png\"></span>');
else
$('#icon_'+artid).html('<span onclick=send_data('+artid+',\''+ty+'\',\'yes\')><img class=point src=\"../images/open_icon.gif\"></span>');
}
else if(color == 'red')
{
	
$.get('attach_ajax_return.php?q=change_icon&ordid='+artid+'&&type='+ty+'&&chid='+cid, function(data) {
																								
																						if(data > 0)
																						{
																							if(ty == 'poart' )
																							$('#icon_'+cid).html('<span onclick=send_data('+artid+',"'+ty+'",\'yes\','+cid+')><img class=point src=\"../images/open_icon.png\"></span>');																					else if(ty == 'clay' || ty == 'prv')
																							$('#icon_'+ty+cid).html('<span onclick=send_data('+artid+',"'+ty+'",\'yes\','+cid+')><img class=point src=\"../images/open_icon.gif\"></span>');	
																							else
																							$('#icon_'+artid).html('<span onclick=send_data('+artid+',"'+ty+'",\'yes\')><img class=point src=\"../images/open_icon.gif\"></span>');	
																						}
																						else
																						{
																							if(ty == 'poart'  )
																							$('#icon_'+cid).html('<span onclick=send_data('+artid+',"'+ty+'",0,'+cid+')><img class=point src=\"../images/attch_icon.png\"></span>');																					else if(ty == 'clay' || ty == 'prv')
																							$('#icon_'+ty+cid).html('<span onclick=send_data('+artid+',"'+ty+'",0,'+cid+')><img class=point src=\"../images/attch_icon.png\"></span>');	
																							else
																							$('#icon_'+artid).html('<span onclick=send_data('+artid+',"'+ty+',\'yes\')><img class=point src=\"../images/attch_icon.png\"></span>');	
																						}
															  					//$('#r2_email').html(obj.v_email);

																  
																  });
}//close of if color red
}

function doIt(obj, fm) 
{
	if( $('input.upload').size() > fm ) 
	{
		alert('Max files is '+fm); obj.value='';return true;
	}
		
	
$(obj).hide();
$(obj).parent().prepend('<input type="file" class="upload" name="fileX[]" size=1 />').find("input").change(function() {doIt(this, fm)});
var v = obj.value;
	if(v != '') 
	{
		$("div#files_list").append('<div>'+v+'&nbsp; &nbsp;<input type=button class="remove" value="[X]" style="border:none; background:none; font-weight:bold;" /> </div>')
		.find("input").click(function(){
		$(this).parent().remove();
		$(obj).remove();
		return true;
		});
	}
 
}
// JavaScript Document



function start()
{
//$(".get_art_files").click(send_data);
}
var ord_id=0;
var chid=0;
var chpo=0;
var type=0;
var perm=0;
function send_data(val,ty_pe,rw,ch_id,ch_po)
{
    if ((ty_pe == 'poart' || ty_pe=='art') && rw == 'no') {
        var params = new Array();
        params.push({name: 'q', value: 'showpoart'});
        params.push({name: 'chid', value: ch_id});
        params.push({name: 'chpo', value: ch_po});
        params.push({name: 'ordid', value: val});
        params.push({name: 'type', value: ty_pe});
        /* q: "showpoart", */
        $.post("attach_ajax_return.php", params, function (data) {
            if (data.errors == '') {
                var arr = data.url;
                var params="width=800,height=720";
                var top=0;
                var left=0;
                var viewparam;
                arr.forEach(function (item, i, arr) {
                    // viewparam="top="+top+",left="+left+",width=800,height=720";
                    viewparam="toolbar=yes,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=800,height=720"
                    top=top+100;
                    left=left+100;
                    window.open(item, 'Win' + i, viewparam);
                    // alert( i + ": " + item + " (массив:" + arr + ")" );
                });
            }
            else
                alert('Server Upload Error');

        }, 'json');

    } else {
        $('#loader').html('<img src="../images/loader.gif">');
        perm = rw;
        ord_id = val;
        chid = ch_id;
        chpo = ch_po;
        type = ty_pe;
	perm=rw;
        $.get('attach_ajax_return.php?q=display_art&&type='+type+'&&chid='+chid+'&&chpo='+chpo+'&&ordid='+ord_id+'&perm='+perm,show_data);
    }
        

	
}

function remove_tr(val,tt,od,cd)
{
	
	var ans = confirm('Confirm Delete Action?');
	if(ans){
$('#'+val).remove();	
$.get('attach_ajax_return.php?q=remove_attach&&att_id='+val);
change_icon(od,tt,'red',cd);
	}
	


}



function show_data(res)
{
	
	//var type = $('#att_type').val(); 
	$("#att_wrap").css('display','').html(res).css('border','2px black solid');
	if(perm == 'yes')
	do_attach(ord_id,type,chid,chpo);
	else
	$('#loader').html(''); 
}

function reqChange(child,type)
{
	
	if(confirm('Confirm Delete All'))
	{
		var mg = $('#reqChangeMsg').val(); 
		if($('#reqChangeMsg').val()  == '')
		alert('Enter Message to Vendor.');
		else
		{
			$('#loader').html('<img src="../images/loader.gif">');
			hide('att_wrap'); 
			$.post('attach_ajax_return.php', { q:"reqChange", msg: mg,type:type, child: child}, function(data) { 
																			   $('#icon_'+type+child).html('<img src="../images/attch_icon.png">').addClass('point');
																			  
																			   $('#loader').html('');
																			   });
		}
	}
}

$(document).ready(start);
