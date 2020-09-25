
$(document).ready(function() {
getProjects('off');
clearEditData();

$(".taskArea").sortable({update : function() {
											if($("input[name=hideCompleted]").is(':checked'))
											alert('Cannot Sort with Hide Completed checked. Please uncheck Hide Completed to sort tasks.');
											else{
											serial = $('.taskArea').sortable('toArray');
											var projID = $('#projID').val();
											$.post('dev_ajax_return.php',{q: 'sortTask', task:serial, projID: projID},function(data){});
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
$.post('dev_ajax_return.php', { q: 'getProjects', status: status}, function(data){
														var obj =JSON.parse(data); 
														$('#projectGrid').html(obj.projectList);
														});
};
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
								$.post("dev_ajax_return.php",{q:'showProject', status: 'off', id : projID}, function(data){ 
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
												$.post("dev_ajax_return.php",{q:'showProject', status : 'on', id : projID}, function(data){ 
																									var obj = JSON.parse(data); 
																									$("#projectLink").html(obj.projectLink);
																									
																									$("#projID").val(projID);

																									$(".taskArea").html(obj.taskText);
																									$('#loader').html('');
																									});	
												
												
											}
									else
											{
												$.post("dev_ajax_return.php",{q:'showProject', status : 'off', id : projID}, function(data){ 
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
											  $.post("dev_ajax_return.php",{ q:'closeProject', status:'off', projID : projID }, function(){
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
											 $.post("dev_ajax_return.php",{ q:'closeProject', status:'on', projID : projID }, function(){
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
						
						$.post('dev_ajax_return.php',{
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
															if($("input[name=hideClosed]").is(':checked'))
																getProjects('on');
															else
																getProjects('off');
															$('#loader').html('');
															});

						
					});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(".addTask").live('click',function(){
									loaderOn();
									var task = $('#taskText').val();
									if(task.length > 0){
//									var head = $('#devHead').val(); 
									if($("input[name=head]").is(':checked'))
										var head = 'head';
									else
										var head = 'task';
										
									
									var projID = $('#projID').val(); 
									
									$.post('dev_ajax_return.php',{q:'addTask', projID : projID,  task : task, type : head }, function(data)
																												  { 
																													  var obj = JSON.parse(data); 
																													  if(!obj.error && obj.db)
																													  $(".taskArea").append(obj.task);
																													  else
																													  alert('Error');
																													  
																													  $('#taskText').val('');
																													  $("input[name='head']").attr('checked',false);
																													  loaderOff();
																													  
																												  });
									}
									else
									{
									alert('Cannot Add empty Task');
									loaderOff();
									}
									});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(".check").live('click',function(){
								  var taskID = $(this).attr('id');
								  if($(this).is(':checked')){
								  $.post('dev_ajax_return.php',{ q:'toggleTask', status : 'off', taskID: taskID}, function(data)
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
									$.post('dev_ajax_return.php',{ q:'toggleTask', status : 'on', taskID: taskID}, function(data)
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
							 $.post('dev_ajax_return.php', {
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
	

$.post('dev_ajax_return.php', {q : 'showAttach', id:id }, function(data)
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


function remove(val,type)
{	
	
	var ans = confirm('Confirm Delete Action?');
	if(ans){
		loaderOn();
$('#'+type+val).remove();	
$.post('dev_ajax_return.php', { q: 'remove' , ID : val, type : type} );
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

var innerhtml = '<div class=editTaskHead ><b>Edit task</b><div style="float:right" onclick=hide("att_wrap");><img src="../images/close.gif"></div></div><div class=editTaskBody><table width=100% border=0><tr><td><b>Head</b></td><td><b>Task Description</b></td></tr><tr><td><input type=checkbox name=editTaskType '+type+'></td><td><textarea rows=2 cols=60 id=editTaskDesc>'+$('#taskDesc_'+taskID).html()+'</textarea></td></tr><tr><td colspan=2 align=right><input type=button id=editTask_'+taskID+' class=editTaskSave value=Save></td></tr></table></div>';
$('#att_wrap').html(innerhtml).css('display','');

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
										 $.post("dev_ajax_return.php",{q:'editTask', taskID : taskID, taskType : taskType, taskDesc:taskDesc}, function(data){
																																	 
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