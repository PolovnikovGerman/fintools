
$(document).ready(function() {
			$( "#projectGrid" ).sortable({update : function() {
											
											if($('#loggedIn').val() == $('#sessUser').val())
											{
											order = $('#projectGrid').sortable('toArray'); 
											var projID = $('#projID').val();
											$.post('../model/dev_model.php',{q: 'sortProjects', order:order, userID : $('#loggedIn').val()},function(data){ });
											}
											else
												alert('Sorting Permission denied.');
											
										}
										 });
			$( "#projectGrid" ).disableSelection();
		
			getProjects('on');
			clearEditData();
			loadInitSection($('#loggedIn').val());
			$("#dialog").dialog({minWidth:500, minHeight:500,autoOpen:false});
			
			$('#changeSection').live('change',function(){
													   loaderOn();
											   
											   if($(this).val())
											   {
											   		var taskID = $('.editTaskSave').attr('id').substring(9);
											   		$.post('../model/dev_model.php',{q:'changeSection',from : $('#projID').val(), to : $(this).val(), taskID : taskID }, function(data){ 
																																							  if(data)
																																							  {
																																							  	$('#changeSection').attr('disabled','disabled');
																																								$('#task_'+taskID).remove();
																																							  }
																																												  });
													loaderOff();
											   }
											   else
											   	alert('No Value on destination section.');
													   
										   });
			$('.getNotes').live('click',function(){
										    loaderOn();
										     var notesID = $(this).attr('id').substring(4); 
											 if(notesID)
											$.post('../model/dev_model.php',{q:'getNotes', notesID: notesID}, function(data){
																												  obj=JSON.parse(data);
																												  $( "#dialog" ).dialog('open');
																												  $('#putNotes').val(obj.dtaskNotes);
																												  $('.saveTaskNotes').attr('id','note'+notesID);

																												  loaderOff();
																												  });
											else
											 alert('ID missing');
										  });

$('.saveTaskNotes').live('click',function(){ 
								   loaderOn();
								   var notesID = $(this).attr('id').substring(4);
								   if(notesID)
								   $.post('../model/dev_model.php',{q:'saveNotes',taskNotes:$('#putNotes').val(), notesID: notesID}, function(data){
																												  if(!data)
																												  	alert('Error in updating Notes.');
																												   else
																												   {
																												   	loaderOff();
																													$('#dialog').dialog('close');
																													$('#taskText').focus();
																												   }
																											   });
								   else
								   	alert('ID missing.');
								   });
			
			if( $('#loggedIn').val() == 1 ||  $('#loggedIn').val() == 2) 			   
				$("#"+'user'+$('#loggedIn').val()).addClass('activeTab');
				
			

$(".tabMenu ul li").click(function(){loaderOn();
								   
								   $(".tabMenu ul li").removeClass('activeTab');
								   $(this).addClass('activeTab');
								   $('#loggedIn').val($(this).attr('id').substring(4));
								   loadInitSection($('#loggedIn').val());
								   getProjects('On');
								   loadInitSection($('#loggedIn').val());
								   });
$(".taskArea").sortable({update : function() {
											if($("input[name=hideCompleted]").is(':checked'))
											alert('Cannot Sort with Hide Completed checked. Please uncheck Hide Completed to sort tasks.');
											else{
											serial = $('.taskArea').sortable('toArray');
											var projID = $('#projID').val();
											$.post('../model/dev_model.php',{q: 'sortTask', task:serial, projID: projID},function(data){});
											}
}


});

$(function() {
		$("#datepicker").datepicker({ dateFormat: 'mm/dd/y', 
									  showButtonPanel: true,
									   beforeShowDay: $.datepicker.noWeekends
									 });
	});

function getProjects(status){
	
	if($('#loggedIn').val()){
$.post('../model/dev_model.php', { q: 'getProjects', status: status, user: $('#loggedIn').val() }, function(data){ 
														var obj =JSON.parse(data); 
														$('#projectGrid').html(obj.projectList);
														});
	}
	else
	alert('Logged In User Session ID missing.');
loaderOff();
};

$(".projName").live('dblclick',function(){
									  $('#loader').html('<img src="../images/loader.gif">');
									   var projID = $('#projID');
									 
									   $('#projName').html('<input type=text id=rename >&nbsp;<input type=button value=save style="background-color:#006600; color:white; font-weight:bold; border:1px #333333 solid;" class=save_btn id=pr_rename>');
									   $('#loader').html('');
									 });
$("#pr_rename").live('click',function(){
									  var rename = $('#rename').val();
									  var projID = $('#projID').val();
									  if(projID != '' && rename != ''){
									  $.post('../model/dev_model.php',{ q: 'renameProject', pr_id : projID, name: rename }, function(data){
																														if(data)
																														{
																														$('#pr_'+projID).html(rename);
																														$('#projName').html(rename);
																														}
																														else
																														alert('Error updating name.');
																													});
										  																	
									  }
									 else
									  alert('Missing Project NAME/ID.');
									  });
$(".devPr").live('click',function(){
								  $('#loader').html('<img src="../images/loader.gif">');
								  hide_att(); 
								  $('#attachDocs').html('<span class="ui-icon ui-icon-folder-open" style="float:right;"   id="uploadAttach"></span>');
								  $('.projectClosed').html(' <input type=checkbox class=projectClosed> Close');
								  
								  $('.devPr').removeClass('live');
								  $(this).addClass('live');
								  var projName = $(this).html();
								  var projID = $(this).attr('id').substring(3); 
								  $('.projectClosed').html(' <input type=checkbox name=projectClosed id='+projID+' class=ckProjectClosed> Close');
								$('.viewCompleted').html('<input type=checkbox class=ckHideCompleted name=hideCompleted id='+projID+' > Hide Completed');
								$.post("../model/dev_model.php",{q:'showProject', status: 'off', id : projID}, function(data){ 
																									var obj = JSON.parse(data); 
																									$('.hide').css('display','');
																									$('#projName').html(projName);
																									$("#projectLink").html(obj.projectLink);
																									
																									$("#projID").val(projID);
																									$("#projNotes").val(obj.projNotes);

																									$(".taskArea").html(obj.taskText);
																									if(obj.projStatus == 'off')
																									$('input[name=projectClosed]').attr('checked', true);

																									$('#loader').html('');
																									});
								  });

$('.ckHideCompleted').live('click',function(){ 
											loaderOn();
													 var projID = $(this).attr('id'); 
											if($("input[name=hideCompleted]").is(':checked'))
											{
												$.post("../model/dev_model.php",{q:'showProject', status : 'on', id : projID}, function(data){ 
																									var obj = JSON.parse(data); 
																									$("#projectLink").html(obj.projectLink);
																									
																									$("#projID").val(projID);

																									$(".taskArea").html(obj.taskText);
																									$('#loader').html('');
																									});	
												
												
											}
									else
											{
												$.post("../model/dev_model.php",{q:'showProject', status : 'off', id : projID}, function(data){ 
																									var obj = JSON.parse(data); 
																									$("#projectLink").html(obj.projectLink);
																									
																									$("#projID").val(projID);

																									$(".taskArea").html(obj.taskText);
																									$('#loader').html('');
																									});
											}
										
											});

$('.ckProjectClosed').live('click',function(){
										  loaderOn();
										  var projID = $(this).attr('id');
										  if($("input[name=projectClosed]").is(':checked'))
										  {
											  $.post("../model/dev_model.php",{ q:'closeProject', status:'off', projID : projID }, function(){
																																		 clearEditData();
																																		 
																																		 if($("input[name=hideClosed]").is(':checked'))
																																				getProjects('on');
																																		else
																																				getProjects('off');
																																		 loaderOff();
																																		 });
										  }
										  else
										  {
											 $.post("../model/dev_model.php",{ q:'closeProject', status:'on', projID : projID }, function(){
																																		 $('#pr_'+projID).removeClass('proj_off');
																																		 $('#pr_'+projID).addClass('proj_on');
																																		 
																																		 loaderOff();
																																		 }); 
										  }
										  });

$('#hideClosed').click(function(){
								loaderOn();
								if($("input[name=hideClosed]").is(':checked')){
									getProjects('on');
									clearEditData();
									loaderOff();
								}
								else{
									getProjects('off');
									clearEditData();
									loaderOff();
								}
								
								});
//devControl Popup for New Project.
$(".load").click(function(){ 
						  $('#loader').html('<img src="../images/loader.gif">');
						  });

$('a.poplight').live('click',function() { 
							$('#loader').html('<img src="../images/loader.gif">');
    var popID = $(this).attr('rel'); //Get Popup Name
    var popURL = $(this).attr('href'); //Get Popup href to define size
    
	
    //Pull Query & Variables from href URL
    var query= popURL.split('?'); 
    var dim= query[1].split('&'); 
    var popWidth = dim[0].split('=')[1]; //Gets the first query string value
	caller = dim[1].split('=')[1]; 
	editID = dim[2].split('=')[1]; 
	
	
	
	clearEditData();
	
    //Fade in the Popup and add close button
    $('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="../images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');
	

    //Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
    var popMargTop = ($('#' + popID).height() + 80) / 2;
    var popMargLeft = ($('#' + popID).width() + 80) / 2;

    //Apply Margin to Popup
    $('#' + popID).css({
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });

    //Fade in Background
    $('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
    $('#fade').css({'filter' : 'alpha(opacity=60)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 
	
    return false;
});

//Close Popups and Fade Layer
$('a.close, #fade, #coolSave').live('click', function() { //When clicking on the close or fade layer...
    $('#fade , .popup_block').fadeOut(function() {
        $('#fade, a.close').remove();  //fade them both out
    });
    return false;
});


////////////////////////////////////////////////////ADDING NEW DEV TASK//////////////////////////////////////////////////////////////////////////////////////////////
$('.addProj').click(function() 
					{
						$('#loader').html('<img src="../images/loader.gif">');
						
						$.post('../model/dev_model.php',{
							   								q:'addProj',
															name:$("input[name='name']").val(),
															desc:$("#desc").val(),
															start:$("input[name='start']").val(),
															notes:$("#notes").val(),
															action:$('#action').val(),
															projID:$('#projID').val(),
															
																													
														
														} , function(data)
															{ 	
															obj=JSON.parse(data); 
															if(!obj.error.status)
															{
																if($("input[name=hideClosed]").is(':checked'))
																	getProjects('on');
																else
																	getProjects('off');
															}
															else
																alert(obj.error.msg);
															
															$('#loader').html('');
															});

						
					});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$('.empAll').click(function(){ 
							if($('.empAll').is(':checked'))
							{
								$('.emp').attr('checked','checked'); 
								$('.emp:checkbox').last().removeAttr('checked');
								$('.emp:checkbox').parent().css('background-color','blue');
								$('.emp:checkbox').parent().css('color','white');
								$('.emp:checkbox').last().parent().css('background-color','#f4f4f4');
								$('.emp:checkbox').last().parent().css('color','#2d2d2d');
								
							}
							else
							{
								$('.emp:checkbox').removeAttr('checked'); 
								$('.emp:checkbox').parent().css('background-color','#f4f4f4');
								$('.emp:checkbox').parent().css('color','#2d2d2d');
							}

							});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(".addTask").live('click',function(){
											
											 var values = $('input:checkbox:checked.emp').map(function () {
  															return this.value;
															}).get();
											 
											 
									loaderOn(); 
									var task = $('#taskText').val();
									var notes = $('#taskNotes').val(); 
									if(task.length > 0){
//									var head = $('#devHead').val(); 
									if($("input[name=head]").is(':checked'))
										var head = 'head';
									else
										var head = 'task';
										
									 
									var projID = $('#projID').val(); 
									
									$.post('../model/dev_model.php',{q:'addTask', projID : projID,  task : task, type : head, notes : notes, values:values }, function(data)
																												  { 
																												  
																													  var obj = JSON.parse(data); 
																													if(obj.show)
																													{
																													  if(!obj.error && obj.db)
																													  {
																													  	$(".taskArea").append(obj.task);
																														$('#taskText').val('');
																													    $('#taskNotes').val('');
																													    $('input[name=head]').prop('checked',false);
																														$('#taskText').focus();
																													  }
																													  else
																													  	alert('Error. Static call sortTask/ Ajax return.');
																													}
																												    else
																													{
																														$('#taskText').val('');
																													    $('#taskNotes').val('');
																													    $('input[name=head]').prop('checked',false);
																														$('#taskText').focus();  
																													}
																												if($('#loggedIn').val() == 1 || $('#loggedIn').val() == 2)
																												{
																												  $('.emp:checkbox').removeAttr('checked'); 

																												  var ind = $('#loggedIn').val(); 
																												  $('#chk'+ind).prop('checked',true);
																												}
																													  loaderOff();
																													  
																												  });
									}
									else
									{
									alert('Cannot Add empty Task');
									loaderOff();
									}
									});

$('.emp').click(function(){

									   if($(this).is(':checked'))
									   {
										   
									   	$(this).parent().css('background-color','blue');
										$(this).parent().css('color','white');
										
									   }
									   else
									   {
										$(this).parent().css('background-color','#f4f4f4');
										$(this).parent().css('color','#2D2D2D');
										
										   
									   }
									   });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(".check").live('click',function(){
								  var taskID = $(this).attr('id');
								  if($(this).is(':checked')){
								  $.post('../model/dev_model.php',{ q:'toggleTask', status : 'off', taskID: taskID}, function(data)
																														   {	
																															  if(data)
																															  {
																																if($("input[name=hideCompleted]").is(':checked'))
																															  	$('#task_'+taskID).remove();
																																else
																																$('#task_'+taskID).css('color','#818181');
																															  }
																															  else
																															  	alert('Error: Status not set or query Failed.');
																														   });
								  
								  
								  }
								  else{
									$.post('../model/dev_model.php',{ q:'toggleTask', status : 'on', taskID: taskID}, function(data)
																														   {
																															  
																															  if(data)
																															  	$('#task_'+taskID).css('color','#000000');
																															  else
																															  	alert('Error: Status not set or query Failed.');
																														   });
								    
								  }
								  
								  });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#addLink").click(function(){ 
							 
							 loaderOn();
							 var id = $('#projID').val();
							 $.post('../model/dev_model.php', {
															q:'addLink',
															id:id,
															linkName: $('#Link').val(),
															}, function(data)
															{
																var obj = JSON.parse(data);
																$('#projectLink').append(obj.Link);
																$('#Link').val('');
																loaderOff();
															});

							 
							 });


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////ATTACH CODE BELOW//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#uploadAttach').live('click',function(){
	
	loaderOn();
	var id = $('#projID').val(); 
	

$.post('../model/dev_model.php', {q : 'showAttach', id:id }, function(data)
																	  {
																				
																		  $("#att_wrap").css('display','').html(data).css('border','2px black solid');
																		  $('#att_wrap').append('<form action="uploadAttach.php" onsubmit=hide_att() target="uploadAttach"  method="post" enctype="multipart/form-data" name="upload_form" ><div id="upload_form"></div><div id="mUpload"><label class="browse">&nbsp;&nbsp;<input type="file" id="element_input"  class="upload" name="fileX[]" size=1 /></label><br /> <br /><input type=hidden name=_id value='+id+'><span id="save_button"><input type="submit" name="uploadAttach" value="Upload" id="save"/></span></div></form>');
	
		var fileMax = 12;
	$('#upload_form').before('<div id="files_list" style="padding:5px;background:#fff;font-size:small;"></div>');
	$("input.upload").change(function(){
	doIt(this, fileMax);
});
																		  loaderOff();
																		  
																	  });




///////////end of init jquery
});



function doIt(obj, fm) 
{
	if( $('input.upload').size() > fm ) 
	{
		alert('Max files is '+fm); obj.value='';return true;
	}
		
	
$(obj).hide();
$(obj).parent().append('<input type="file" class="upload" name="fileX[]" size=1 />').find("input").change(function() {doIt(this, fm)});
var v = obj.value;
	if(v != '') 
	{
		$("div#files_list").append('<div>Enter Name:&nbsp;<input type=text size=10 name=attachName[]> &nbsp;<input type=button class="remove" value="[X]" style="border:none; background:none; font-weight:bold;" /> </div>')
		.find(".remove").click(function(){
		$(this).parent().remove();
		$(obj).remove();
		return true;
		});
	}
 
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

});///////////////////////////////////END OF JQUERY ONLOAD MODULE, ALL JS CALLS OUTSIDE THE JQUERY SCRIPT SHOULD BE DEFINED BELOW AND NOT INSIDE THE ONLOAD JQUERY MODULE
function loadInitSection(secID)
{

								  $('#loader').html('<img src="../images/loader.gif">');
								  hide_att(); 
								  $('#attachDocs').html('<span class="ui-icon ui-icon-folder-open" style="float:right;"   id="uploadAttach"></span>');
								  $('.projectClosed').html(' <input type=checkbox class=projectClosed> Close');
								  
								  $('.devPr').removeClass('live');
								  $('#pr_'+secID).addClass('live');
//								  $('#pr_'+secID).css('background-color','#FFFF66').css('font-weight','bold').css( 'color','#0000ff');
								  var projName = 'Assigned Tasks';
								  var projID = secID;
								  $('.projectClosed').html(' <input type=checkbox name=projectClosed id='+projID+' class=ckProjectClosed> Close');
								$('.viewCompleted').html('<input type=checkbox class=ckHideCompleted name=hideCompleted id='+projID+' > Hide Completed');
								$.post("../model/dev_model.php",{q:'showProject', status: 'off', id : projID}, function(data){ 
																									var obj = JSON.parse(data); 
																									$('.hide').css('display','');
																									$('#projName').html(projName);
																									$("#projectLink").html(obj.projectLink);
																									
																									$("#projID").val(projID);
																									$("#projNotes").val(obj.projNotes);

																									$(".taskArea").html(obj.taskText);
																									if(obj.projStatus == 'off')
																									$('input[name=projectClosed]').attr('checked', true);

																									$('#loader').html('');
																									});
								 	
}

function clearEditData()
{
								 
													
												 $("input[name='action']").val('add');
													 $("input[name='name']").val('');
													 
													 $('#desc').val('');
													 $('#notes').val('')
													 $('#projID').val('0');
													 
													 $('#attachDocs').html('');
													 $('#projectLink').html('');
													 $('.taskArea').html('');
													 $('.devPr').removeClass('live');
													 $('.projectClosed').html('');
													 $('.viewCompleted').html('');
													 $('#projName').html('');
													 $('#loader').html('');
													 $('.hide').css('display','none');
													 
							
}
function remove(val,type)
{	
	
	var ans = confirm('Confirm Delete Action?');
	if(ans){
		loaderOn();
$('#'+type+val).remove();	
$.post('../model/dev_model.php', { q: 'remove' , ID : val, type : type} );
	}
	loaderOff();
}

function editTask(taskID, taskType)
{

$('#task_'+taskID).removeClass(taskType);
if(taskType == 'head')
var type = 'checked = checked';
else
var type = '';

$.post("../model/dev_model.php",{q:'getSections'},function(data){
														   
														   
var innerhtml = '<div class=editTaskHead ><b>Edit task</b><div style="float:right" onclick=hide("att_wrap");><img src="../images/close.gif"></div></div><div class=editTaskBody><table width=100% border=0><tr><td><b>Head</b></td><td><b>Task Description</b></td><td><b>Move Task</b></td></tr><tr><td><input type=checkbox name=editTaskType '+type+'></td><td><textarea rows=2 cols=43 id=editTaskDesc>'+$('#taskDesc_'+taskID).html()+'</textarea></td><td valign=top>'+data+'</td></tr><tr align="right"><td colspan=4 align="right" ><input type=button  id=editTask_'+taskID+' class="editTaskSave" value=Save>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></div>';
$('#att_wrap').html(innerhtml).css('display','');
});
}

$(".editTaskSave").live('click',function(){
										 $('#att_wrap').css('display','none');
										 loaderOn();
										 var taskID = $(this).attr('id').substring(9); 
										 var taskDesc = $('#editTaskDesc').val();
										 if($("input[name=editTaskType]").is(':checked'))
										 var taskType = 'head';
										 else
										 var taskType = 'task';
										 $.post("../model/dev_model.php",{q:'editTask', taskID : taskID, taskType : taskType, taskDesc:taskDesc}, function(data){
																																	 
																																	 if(data)
																																	 {
																																		 $('#taskDesc_'+taskID).html(taskDesc);
																																		 $('#task_'+taskID).addClass(taskType);
																																		 
																																		 loaderOff();
																																	 }
																																	 else
																																	 alert('Error in editing Task');
																																	 });
										 });