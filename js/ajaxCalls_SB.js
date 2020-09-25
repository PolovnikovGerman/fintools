// JavaScript Document
$(document).ready(function() {
		$('input').attr('readonly','readonly');				  
	 $( "#sortable" ).disableSelection();
	$("#sortable").sortable({update : function() {
											var catID = 0;
											serial = $('#sortable').sortable('toArray');
											catID = $("input[name='sbCatID']").val();
											if(catID == 0)
											alert('Category ID missing');
											else
											$.post('../model/brandSB_model.php',{q: 'putSortItem', catID : catID, serial: serial},function(data){});
											
										   }

										});					   
$('.menuSB').click(function() 
					{
						var id = $(this).attr('id');
						
						
						
						$('.SBPricing').css('display','none');
						$('.SBImages').css('display','none');
						$('.SBData').css('display','none');
						$('.SBAttributes').css('display','none');
						$('.'+$(this).attr('id')).css('display','');
						
						
						$('li').removeClass('live');
						$(this).addClass('live');
					});
$('.sbCategory').click(function()
								{
									$('#loader').html('<img src="../images/loader.gif">');
									
									$('td').removeClass('catActive');
									$(this).addClass('catActive');
									$('#loader').html('<img src="../images/loader.gif">');
									var cID = $(this).attr('id'); 
									
									if(cID)
									{
										
										$("input[name='sbCatID']").val(cID);
										
										$.post('../model/brandSB_model.php',{q:'getCategoryItems',catID : cID},function(data)
																														{
																															
																															var obj = JSON.parse(data);
																															$("#sortable").html(obj.catItems).addClass('sbCatSortStyle');
																															$("#sbItems").html(obj.sbItems);
																															
																															$('#loader').html('');
																														});
								    }
									else
										alert('Invalid Handle.');
											  
									
									$('#loader').html('');
								});

$('.sbCheck').live('click',function()
						{
						$('#loader').html('<img src="../images/loader.gif">');
						if($(this).val() != '')
						{
							//check first if category has been selected or not
							if($(this).is(':checked'))
							{
								if($("input[name='sbCatID']").val() != 0)
								{
								$.post('../model/brandSB_model.php',{q:'putItemOnCat',itemID: $(this).val(), catID: $("input[name='sbCatID']").val() }, function(data)
																														 {
																													          
																															  $("#sortable").html(data);
																															  $('#loader').html('');
																														 });
								}
								else
								{
									alert('No Category Selected.');
									$('#loader').html('');
									$(this).attr('checked',false);
								}
							}
							else 
							{
								if($("input[name='sbCatID']").val() != 0)
								{
									$.post('../model/brandSB_model.php',{q:'removeItemOnCat',itemID: $(this).val(), catID: $("input[name='sbCatID']").val()}, function(data)
																														 {
																													          
																															  $("#sortable").html(data);
																															  $('#loader').html('');
																														 });							
								}
								else
								{
									alert('No Category Selected.');
									$('#loader').html('');
									$(this).attr('checked',true);
								}
							}
						}//close of if
						else
						alert('ID Missing');
						});
$('#loader').html('');
});//end of jquery beg





function fillEditData(id,root)
{
	$('#loader').html('<img src="../images/loader.gif">');
	 clearEdit();
	$.post('../model/brandSB_model.php',{q:'getSBData',ID:id}, function(data)
												 { 
													 obj=JSON.parse(data);


													 for( var i = 0; i < obj.media.length ; i++ )
													 {
														 
														if(obj.media[i].sbMediaType == 'img')
														   $('#img'+obj.media[i].sbMediaLoc).html('<img src="'+obj.media[i].sbMediaPath+'"  class="sbImg"  height=60px width=60px>');
														else
															{
													 			$('#imp'+obj.media[i].sbMediaLoc).html('<a href="'+obj.media[i].sbMediaPath+'" target=_blank>&diams;</a>');
																$('#impN'+obj.media[i].sbMediaLoc).val(obj.media[i].sbMediaName);
																$('#impS'+obj.media[i].sbMediaLoc).val(obj.media[i].sbMediaOption);
															}
													 }
													  
													 $("input[name='sbID']").val(obj.sbID);
													 $("input[name='itmID']").val(obj.sbItemID);
													 $('#itemName_tab').html(obj.sbItemID);
													 $("input[name='sbName']").val(obj.sbName);
													 $("input[name='sbWebpage']").val(obj.sbWebpage);
													 $("input[name='sbSize']").val(obj.sbSize);
													 $("input[name='sbColors']").val(obj.sbColors);
													 $("input[name='sbMaterial']").val(obj.sbMaterial);
													 $("input[name='sbWeight']").val(obj.sbWeight);
													 $("input[name='sbLeada']").val(obj.sbLeada);
													 $("input[name='sbLeadb']").val(obj.sbLeadb);
													 $("input[name='sbLeadc']").val(obj.sbLeadc);
													 $("input[name='sbSetup']").val(obj.sbSetup);
													 $("input[name='sbPrints']").val(obj.sbPrints);
													 $("input[name='sbVendor']").val(obj.sbVendor);
													 $("input[name='sbVprice']").val(obj.sbVprice);
													 $("input[name='sbMtitle']").val(obj.sbMtitle);
													 $("input[name='sbTemplate']").val(obj.sbTemplate);
													 
    												 
													 
													 $("textarea[name='sbVnotes']").val(obj.sbVnotes);													 
													 $("textarea[name='sbKeys']").val(obj.sbKeys);
													 $("textarea[name='sbMkeys']").val(obj.sbMkeys);
													 $("textarea[name='sbMdesc']").val(obj.sbMdesc);
													 
													 $("select[name='sbActive'] option[value="+obj.sbActive+"]").attr('selected', 'selected');
													 $("select[name='sbNew'] option[value="+obj.sbNew+"]").attr('selected', 'selected');
													 $("select[name='sbTax'] option[value="+obj.sbTax+"]").attr('selected', 'selected');
													 
													 var loc =  new Array();
													 for(var i =0; i < 6; i++)
													 {
														switch(obj[i].sbType)
														{
															case 'qty':
															loc['qty'] = i;
															$("input[name='sbPrID1']").val(obj[i].sbPrID);
															break;
															case 'price':
															loc['price'] = i;
															$("input[name='sbPrID2']").val(obj[i].sbPrID);
															break;
															case 'sale':
															loc['sale'] = i;
															$("input[name='sbPrID3']").val(obj[i].sbPrID);
															break;
															case 'cmp1':
															loc['cmp1'] = i;
															$("input[name='cmpName1']").val(obj[i].sbPriceName);
															$("input[name='cmpWebpage1']").val(obj[i].sbOption);
															$("input[name='sbPrID4']").val(obj[i].sbPrID);
															break;
															case 'cmp2':
															loc['cmp2'] = i;
															$("input[name='cmpName2']").val(obj[i].sbPriceName);
															$("input[name='cmpWebpage2']").val(obj[i].sbOption);
															$("input[name='sbPrID5']").val(obj[i].sbPrID);
															break;
															case 'cmp3':
															loc['cmp3'] = i;
															$("input[name='cmpName3']").val(obj[i].sbPriceName);
															$("input[name='cmpWebpage3']").val(obj[i].sbOption);
															$("input[name='sbPrID6']").val(obj[i].sbPrID);
															break;
															
														}
														
													 }
												     $("textarea[name='sbAttr[]']").each(function(index){
																								   var temp = eval('obj.sbAttr'+(index+1));
																								   $(this).val(temp);
																								 });
													 $("input[name='sbQty[]']").each(function(index){
																							  			var temp = eval('obj['+loc['qty']+'].sbP'+(index+1));
																										if(temp != 0.00)
																										$(this).val(temp);
																							  		
																							         });
													 $("input[name='sbPrice[]']").each(function(index){
																							  			var temp = eval('obj['+loc['price']+'].sbP'+(index+1));
																										if(temp != 0.00)
																										$(this).val(temp);
																							  		
																							         });
													 $("input[name='sbSale[]']").each(function(index){
																							  			var temp = eval('obj['+loc['sale']+'].sbP'+(index+1));
																										if(temp != 0.00)
																										$(this).val(temp);
																							  		
																							         });
													 $("input[name='sbCmp1[]']").each(function(index){
																							  			var temp = eval('obj['+loc['cmp1']+'].sbP'+(index+1));
																										if(temp != 0.00)
																										$(this).val(temp);
																							  		
																							         });
													 $("input[name='sbCmp2[]']").each(function(index){
																							  			var temp = eval('obj['+loc['cmp2']+'].sbP'+(index+1));
																										if(temp != 0.00)
																										$(this).val(temp);
																							  		
																							         });
													 $("input[name='sbCmp3[]']").each(function(index){
																							  			var temp = eval('obj['+loc['cmp3']+'].sbP'+(index+1));
																										if(temp != 0.00)
																										$(this).val(temp);
																							  		
																							         });
													 
													// $('.buPicArea').html('<img src="'+obj.buPic+'" height=200px width=200px>');
													$('input').attr('readonly','readonly');
													$('#sbSave').css('display','none');
													$('#actEdit').html('Activate Editing').removeClass('actEditGreen').addClass('actEditRed').click(function(){
																																 $('input').prop('readonly','');
																														$('#actEdit').html('Editing Activated').removeClass('actEditRed').addClass('actEditGreen');
																																 $('#sbSave').css('display','');
																																 });
													
												 });
	$('#loader').html('');
}
function clearEdit()
{
	$(":input").val('');
	$(".sbImg").each(function(index){ $(this).attr('src','../images/sbNoImage.jpg');  });
	$('.impLink').each(function(index) { $(this).html('') });
	$(":input").css('border','1px #6c6c6c solid').css('background-color','#ffffff');
	
	$("input[name='SB_save']").val('SAVE');
	$("input[name='SB_type']").val('edit');
	

}
function clearEditData()
{
	$(":input").val('');
	$('input').prop('readonly','');
	$(".sbImg").each(function(index){ $(this).attr('src','../images/sbNoImage.jpg');  });
	$('.impLink').each(function(index) { $(this).html('') });
	$(":input").css('border','1px #6c6c6c solid').css('background-color','#ffffff');
	$('#itemName_tab').html(''); 
	$('#actEdit').html('').removeClass('actEditRed');
	 $('#sbSave').css('display','');
	$("input[name='SB_save']").val('SAVE');
	$("input[name='SB_type']").val('add');
	$('#loader').html('');
}
function checkSBForm()
{
	if($("input[name='SB_type']").val() == 'add')
	{
		var img = $('#image1').val();
		if(img == '')
		{
			alert('Please Enter 1st Image as Main Image.');
			$('#image1').css('border','1px red solid').css('background-color','#FFDEDE');
			return false;
		}
		else
			return true
	}
	else
	{
		//validation for edit upload SB item	
	}
}
