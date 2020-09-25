// JavaScript Document
$(document).ready(function(){
	$('.edit').live('click',function(event){
									 
									 $(this).parent().remove();
									 $.post('../model/coupons_model.php',{ q:'getCoupon', cID : $(this).attr('id') }, function(data)
																															   {
																																   
																																   obj=JSON.parse(data);
																																   	if(obj.coupStatus == 'yes')
																																   		$('#status').attr('checked','checked');
																																	else
																																		$('#status').attr('checked','');
																																	$('#selectType').val(obj.coupType);
																																	$('#code').val(obj.coupCode);
																																	$('#coupDesc').val(obj.coupDesc);
																																	$('#coupValue').val(obj.coupValue);
																																	$('#selectUnit').val(obj.coupUnit);
																																	$('#save').val('edit');
																																	$('#editID').val(obj.coupID);
					//{"coupID":"2","coupType":"","coupCode":"123","coupDesc":"adfas","coupValue":"12.00","coupUnit":"","coupPortal":"","coupRefresh":"no","coupDateTime":"2011-04-14 13:07:29","coupStatus":"yes"}																											   
																															   });
									 
									 });
	$('.adCoupon').click(function(){
								   
								   if($("input[name='status']").is(':checked'))
								   	   var st = 'yes';
								   else
								   	   var st = 'no';
									  
									  
									  
									  
									   var type = $('#selectType').val();
									   var code = $("input[name='code']").val();
									   var description = $("input[name='description']").val();
									   var value = $("input[name='value']").val();
									   var vUnit = $('#selectUnit').val();
									   var action = $("input[name='addCoupon']").val();
									   var portal = $("input[name='portal']").val();
									   
								 $.post('../model/coupons_model.php',{
																		q:'addCoupon',
																		status: st,
																		type: $('#selectType').val(),
																		code: $("input[name='code']").val(),
																		description: $("input[name='description']").val(),
																		value: $("input[name='value']").val(),
																		vUnit: $('#selectUnit').val(),
																		action: $("input[name='addCoupon']").val(),
																		portal: $("input[name='portal']").val(),
																		editID: $('#editID').val()
																		
																		}, function(data)
												 									{  
																						
																						if(data == false)
																							alert('Error. Could not process request.');
																						else
																						{
													 									obj=JSON.parse(data);
																							if(obj.flag)
																								$('#couponTable tr:first').after('<tr><td>'+st+'</td><td>'+type+'</td><td class=coupCode>'+code+'</td><td>'+description+'</td><td>'+value+'</td><td>'+vUnit+'</td><td class=edit id='+obj.coupID+'><img src="../images/edit_icon1.gif"></td>');
																							else
																								alert('Error. Ajax Query Failed.');

																						clearCoupon();
													 									$('#loader').html('');
																						}//close of else
																					});
													 
								   
								   });//end of addCoupon
	
	
});//end of main jquery

function clearCoupon()
{
	$('#editID').val('');
	$('#code').val('');
	$('#coupDesc').val('');
	$('#coupValue').val('');
	$('#save').val('save');
	$('#status').attr('checked','');
}


 

 
