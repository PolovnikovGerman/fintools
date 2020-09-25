

$(document).ready(function() {


$('.addLead').click(function() 
					{
						$('#loader').html('<img src="../images/loader.gif">');
						var rep =new Array();
						$("input[name='reps[]']:checked").each( function() { rep.push($(this).val()); });
						if($("input[name='needbyPhrase']").val().length >0)
						var needby = $("input[name='needbyPhrase']").val();
						else
						var needby = $("input[name='needby']").val()
									
						
						$.post('leads_ajax_return.php',{
							   								q:'addLead',
															action : $("input[name='action']").val(),
															leadID : $('#leadID').val(),
															reps : rep,
															type : $('input:radio[name=type]:checked').val(),
															company : $("input[name='company']").val(),
															name : $("input[name='name']").val(),
															phone : $("input[name='phone']").val(),
															email : $("input[name='email']").val(),
															items : $("input[name='items']").val(),
															qty : $("input[name='qty']").val(),
															needby : needby,
															notes : $("#notes").val(),
															status : $("#status").val(),
															org : $('#org').val(),
														
														} , function(data)
															{ 	
															obj=JSON.parse(data);

															if(obj.action == 'add')
															{
																//assuming that this is the first lead we are adding i remove noleads display message table rows for both open and DC cats.
																$('#nolead1').remove();
																$('#nolead2').remove();
																//on add you first check if we need to show this lead or not, this depends on which user tab is currently active.
																if(obj.show)
																{ //if show is true check where to display the lead whether on open or closed section
																
																	if(obj.type == 1 || obj.type == 2)
																	$('#leadTable tr:first').before('<tr id='+obj.leadID+' '+obj.bgclr+'><td style=\"font-size:10px;\" align=center>'+obj.date+'</td><td>&nbsp;'+obj.company+'</td><td>&nbsp;'+obj.name+'</td><td align=center>'+obj.qty.substr(0,10)+'</td><td>&nbsp;'+obj.items.substr(0,25)+'</td><td ><a class=info href=#>'+obj.status.substr(0,25)+'<span>'+obj.status+'</span></a></td><td align=center>'+obj.needby.substr(0,10)+'</td><td  align=right><a href="#?w=700&v=edit&id='+obj.leadID+'&org=open" rel="popup_name" class="poplight" ><img src="../images/edit_icon.gif"></a></td></tr>');
																	else//if the type is closed or dead then check if the closed and dead area is set visible by user and if yes display the lead in that area
																		if($('#DC').val() == true)
																			$('#leadDCTable tr:first').before('<tr id='+obj.leadID+' '+obj.bgclr+'><td align=center style=\"font-size:10px;\">'+obj.date+'</td><td>&nbsp;'+obj.company+'</td><td>&nbsp;'+obj.name+'</td><td align=center>'+obj.qty.substr(0,10)+'</td><td>&nbsp;'+obj.items.substr(0,25)+'</td><td ><a class=info href=#>'+obj.status.substr(0,25)+'<span>'+obj.status+'</span></a></td><td align=center>'+obj.needby.substr(0,10)+'</td><td  align=right><a href="#?w=700&v=edit&id='+obj.leadID+'&org=open" rel="popup_name" class="poplight" ><img src="../images/edit_icon.gif"></a></td></tr>');
																}//close of show if show not true just dont do anything
															}//close of adding a lead ajax return
															else if(obj.action == 'edit')
															{// firstly check is you need to show the lead, this depends on which user tab is currently selected, then check type of lead whether open/priority or dead/closed
																if(obj.show && (obj.type == 1 || obj.type == 2) )
																{ //if show is yes and type is of open/priority check where the lead came from
																	if(obj.org == 'dead')
																	{//if the lead came from dead/closed section then first remove the lead from there and add it to the open and priority section as first lead
																		$('#pos'+obj.leadID).remove();
																		$('#leadTable tr:first').before('<tr id='+obj.leadID+' '+obj.bgclr+'><td align=center style=\"font-size:10px;\">'+obj.date+'</td><td>&nbsp;'+obj.company+'</td><td>&nbsp;'+obj.name+'</td><td align=center>'+obj.qty.substr(0,10)+'</td><td>&nbsp;'+obj.items.substr(0,25)+'</td><td ><a class=info href=#>'+obj.status.substr(0,25)+'<span>'+obj.status+'</span></a></td><td align=center>'+obj.needby.substr(0,10)+'</td><td align=right><a href="#?w=700&v=edit&id='+obj.leadID+'&org=open" rel="popup_name" class="poplight" ><img src="../images/edit_icon.gif"></a></td></tr>');
																	}
																	else
																	{//if origin was open/priority itself then just replace the lead with new updated data using its identifier
																		$('#pos'+obj.leadID).html('<td align=center style=\"font-size:10px;\">'+obj.date+'</td><td>&nbsp;'+obj.company+'</td><td>&nbsp;'+obj.name+'</td><td align=center>'+obj.qty.substr(0,10)+'</td><td>&nbsp;'+obj.items.substr(0,25)+'</td><td ><a class=info href=#>'+obj.status.substr(0,25)+'<span>'+obj.status+'</span></a></td><td align=center>'+obj.needby.substr(0,10)+'</td><td align=right><a href="#?w=700&v=edit&id='+obj.leadID+'&org=open" rel="popup_name" class="poplight" ><img src="../images/edit_icon.gif"></a></td>');
																	}
																	$('#pos'+obj.leadID).css('background-color',obj.bgclr.substring(8));//setting the background color for lead replaced with unique identifier
																}
																else
																{	//if show and type condition failed, now check if show is true but the type is either closed or dead
																	if(obj.show && $('#DC').val() == true)
																	{//if show is true and type is closed or dead check to see its origin
																		if(obj.org == 'open')//if origin is open then remove the lead from open section and place it as first lead in closed/dead section
																		{	
																			$('#pos'+obj.leadID).remove();	
																			$('#leadDCTable tr:first').before('<tr id='+obj.leadID+' '+obj.bgclr+'><td align=center style=\"font-size:10px;\">'+obj.date+'</td><td>&nbsp;'+obj.company+'</td><td>&nbsp;'+obj.name+'</td><td align=center>'+obj.qty.substr(0,10)+'</td><td>&nbsp;'+obj.items.substr(0,25)+'</td><td ><a class=info href=#>'+obj.status.substr(0,25)+'<span>'+obj.status+'</span></a></td><td align=center>'+obj.needby.substr(0,10)+'</td><td  align=right><a href="#?w=700&v=edit&id='+obj.leadID+'&org=dead" rel="popup_name" class="poplight" ><img src="../images/edit_icon.gif"></a></td></tr>');
																		}
																		else//if lead origin was from closed section itself then just replace it with its identifier.
																		{
																			$('#pos'+obj.leadID).html('<td align=center style=\"font-size:10px;\">'+obj.date+'</td><td>&nbsp;'+obj.company+'</td><td>&nbsp;'+obj.name+'</td><td align=center>'+obj.qty.substr(0,10)+'</td><td>&nbsp;'+obj.items.substr(0,25)+'</td><td ><a class=info href=#>'+obj.status.substr(0,25)+'<span>'+obj.status+'</span></a></td><td align=center>'+obj.needby.substr(0,10)+'</td><td  align=right><a href="#?w=700&v=edit&id='+obj.leadID+'&org=dead" rel="popup_name" class="poplight" ><img src="../images/edit_icon.gif"></a></td>');	
																		}
																		$('#pos'+obj.leadID).css('background-color',obj.bgclr.substring(8));//setting the background color for lead replaced with unique identifier
																	}
																	else
																		$('#pos'+obj.leadID).remove();	
																}
															}
															
															
															
															$('#loader').html('');
																
															});					
																					
					});//close of addLead click function

                  });//document close

function fillEditData(id,org)
{
	var hist;
$.post('leads_ajax_return.php',{q:'getLead',id:id}, function(data)
												 { 
													 obj=JSON.parse(data);
													 
													 if(obj.ck)
													 for(i=0;i<obj.ck.length;i++)
													 $('#ck'+obj.ck[i]).attr('checked',true);
													 
													 if(obj.lhID)
													 {
													 	hist='<table>';
													 	for(i=0;i<obj.lhID.length;i++)
														{
													 		hist+='<tr><td class=histHead>'+obj.lhUser[i]+' - '+obj.lhWhen[i]+'</td></tr>';
															hist+='<tr><td class=histChild>'+obj.lhMsg[i]+'</td></tr>';
														}
													 	hist+='</table>';
													 	
													 	$('#historyDisplay').html(hist);
													 }
													 else
													 	$('#historyDisplay').html('');
													 
													 //$('#type2').attr('checked',false);
													 $('#type'+obj.leadType).attr('checked',true);
													 $("input[name='action']").val('edit');
													 $("input[name='company']").val(obj.leadCompany);
													 $("input[name='name']").val(obj.leadName);
													 $("input[name='phone']").val(obj.leadPhone);
													 $("input[name='email']").val(obj.leadEmail);
													 $("input[name='items']").val(obj.leadItem);
													 $("input[name='qty']").val(obj.leadQty);
													 if(obj.phrase){
													 $("input[name='needbyPhrase']").val(obj.leadNeedBy);
													 $("input[name='needby']").val('');
													 }
													 else
													 {
													 $("input[name='needby']").val(obj.leadNeedBy);
													 $("input[name='needbyPhrase']").val('');
													 }
													 $('#notes').val(obj.leadNotes);
													 $('#status').val(obj.leadStatus);
													 $('#leadID').val(obj.leadID);
													 $('#org').val(org);
													 $('#loader').html('');
													 
												 });


}

function clearEditData()
{
								 
													 //$('#type2').attr('checked',false);
													 var userID = $('#userID').val();
													 $('#ck1').attr('checked',false);
													 $('#ck2').attr('checked',false);
													 $('#ck4').attr('checked',false);
													 $('#ck8').attr('checked',false);
													 $('#ck12').attr('checked',false);
													 $('#historyDisplay').html('');
													 
													// if(!userID)
													// $('#ck4').attr('checked',true);
													// else
													 $('#ck'+userID).attr('checked',true);
													 
													 $('#type2').attr('checked',true);
													 $("input[name='action']").val('add');
													 $("input[name='company']").val('');
													 $("input[name='name']").val('');
													 $("input[name='phone']").val('');
													 $("input[name='email']").val('');
													 $("input[name='items']").val('');
													 $("input[name='qty']").val('');
													 $("input[name='needby']").val('');
													 $("input[name='needbyPhrase']").val('');
													 $('#notes').val('');
													 $('#status').val('');
													 $('#leadID').val('0');
													 $('#org').val('open');
													 $('#loader').html('');
													 
							
}

