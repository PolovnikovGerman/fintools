$(document).ready(function() {
						   
						   		$('#sb_search').click(function(){
															  
															   if($('#auto').val() != '')
															   $.post('../model/search2.php',{term: $('#auto').val()},function(data)
																														{
																															
																															 obj=JSON.parse(data);
																															 
																															 $('.disp').html(obj.disp);


													 
																														});
																						
																else
																alert('Enter search string');
															   });
						   
						   });