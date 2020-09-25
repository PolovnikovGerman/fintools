
$(document).ready(function() {

$("#dialog").dialog({minWidth:500, minHeight:500,autoOpen:false});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

});///////////////////////////////////END OF JQUERY ONLOAD MODULE, ALL JS CALLS OUTSIDE THE JQUERY SCRIPT SHOULD BE DEFINED BELOW AND NOT INSIDE THE ONLOAD JQUERY MODULE

function addRev(revID, poID )
{
loaderOn();
if($('#PO'+poID).val() > 0 && $('#PO'+poID).val() != '')
{
	var poVal = $('#PO'+poID).val(); var poStatus = true; var orderID = poID;
}
else
{
	var poStatus = false; var poVal = 0; var orderID = 0;
}

$.post("revenue_ajax_return.php",{q:'addRevenue', revAmt: $('#rev'+revID).val(),revShip: $('#ship'+revID).val(), revTax: $('#tax'+revID).val(), revID : revID, poVal : poVal, poStatus : poStatus, orderID : orderID}, function(data){ 
																									var obj = JSON.parse(data); 
																									if(!obj.error){
																									$('#revAmt'+revID).html(obj.revAmt);
																									$('#revShip'+revID).html(obj.revShip);
																									$('#revTax'+revID).html(obj.revTax);
																									if(poStatus)
																									$('#revPO'+poID).html(poVal);
																									$('#revSubmit'+revID).html('<span onclick=editRev('+revID+')>edit</span>');
																									
																									
																									}
																									else
																									alert('Error updating');
																									
																								loaderOff();
	
																									});
loaderOff();
}

function editRev(revID, poID)
{
	loaderOn();
var revAmt = $('#revAmt'+revID).html();
var revShip = $('#revShip'+revID).html();
var revTax = $('#revTax'+revID).html();

$('#revAmt'+revID).html('<input type=text value='+revAmt+'  id=rev'+revID+'  size=5>');
$('#revShip'+revID).html('<input type=text value='+revShip+'  id=ship'+revID+'  size=5>');
$('#revTax'+revID).html('<input type=text value='+revTax+'  id=tax'+revID+'  size=5>');
$('#revSubmit'+revID).html('<input type=button onclick=addRev('+revID+','+poID+') class=saveButton value=s >');
loaderOff();

}

$('.getRevNotes').live('click',function(){
										    loaderOn();
										     var notesDate = $(this).prop('id').substring(4); 
											 if(notesDate)
											$.post('revenue_ajax_return.php',{q:'getRevNotes', notesDate: notesDate}, function(data){
																												  obj=JSON.parse(data);
																												  $( "#dialog" ).dialog('open');
																												  $('#revNotes').val(obj.notesText);
																												  $('.saveRevNotes').prop('id','note'+notesDate);

																												  loaderOff();
																												  });
											else
											 alert('ID missing');
										  });

$('.saveRevNotes').live('click',function(){ 
								   loaderOn();
								   var notesDate = $(this).prop('id').substring(4); 
								   if(notesDate)
								   $.post('revenue_ajax_return.php',{q:'saveRevNotes',revNotes:$('#revNotes').val(), notesDate: notesDate}, function(data){ 
																												  if(!data)
																												  	alert('Error in updating Notes.');
																												   else
																												   {
																												   	loaderOff();
																													$('#dialog').dialog('close');

																												   }
																											   });
								   else
								   	alert('ID missing.');
								   });