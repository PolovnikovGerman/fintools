$(document).ready(function() {
						  
						    
							$('.cssTabs ul li').click(function(){
														 
														 $('.cssTabs ul li').removeClass('cssTabs_active');
														 $(this).addClass('cssTabs_active');
															 });
							
							
							
						   
						   });

function fillEditData(id, org)
{
	$.post('../model/surveys_model.php',{q:'showSurvey', id: id, org:org},function(data){
																		  
																		  var obj = JSON.parse(data);
																		  $('textarea[name="ans1"]').val(obj.ans1);
																		  $('textarea[name="ans2"]').val(obj.ans2);
																		  $('textarea[name="ans3"]').val(obj.ans3);
																		  $('textarea[name="ans4"]').val(obj.ans4);
																		  });
}