// JavaScript Document
function checkBuForm()
{
if( ($("input[name='buItemID']").val() == ' ' || $("input[name='buItemID']").val() == 0) && ($("input[name='buName']").val() == ' ' || $("input[name='buName']").val() == 0) )
	{
		$("input[name='buItemID']").css('border','1px red solid').css('background-color','#FFDEDE');
		$("input[name='buName']").css('border','1px red solid').css('background-color','#FFDEDE');
		
		return false;
	}
else if( ($("input[name='buItemID']").val() == ' ' || $("input[name='buItemID']").val() == 0) )
	{
		$("input[name='buItemID']").css('border','1px red solid').css('background-color','#FFDEDE');
		return false;
	}
else if( ($("input[name='buName']").val() == ' ' || $("input[name='buName']").val() == 0) )
	{
		$("input[name='buName']").css('border','1px red solid').css('background-color','#FFDEDE');
		return false;
	}
else 
	 	return true;
}

function fillEditData(id,root)
{
	
	$.post('../model/brandBU_model.php',{q:'getBUData',ID:id}, function(data)
												 { 
													 obj=JSON.parse(data);
													 $("input[name='buID']").val(obj.buID);
													 $("input[name='buItemID']").val(obj.buItemID);
													 $("input[name='buName']").val(obj.buName);
													 $("input[name='buCat']").val(obj.buCat);
													 $("input[name='buSize']").val(obj.buSize);
													 $("input[name='buText']").val(obj.buText);
													 $("input[name='buCut']").val(obj.buCut);
													 $("input[name='buWeight']").val(obj.buWeight);
													 $("input[name='buPrint']").val(obj.buPrint);
													 $("input[name='price1']").val(obj.p1);
													 $("input[name='price10']").val(obj.p10);
													 $("input[name='price25']").val(obj.p25);
													 $("input[name='price50']").val(obj.p50);
													 $("input[name='price100']").val(obj.p100);
													 $("input[name='price250']").val(obj.p250);
													 $("input[name='price500']").val(obj.p500);
													 $("input[name='price1000']").val(obj.p1000);
													 $("input[name='price2500']").val(obj.p2500);
													 $("input[name='price5000']").val(obj.p5000);
													 $("input[name='price10k']").val(obj.p10k);
													 $("input[name='price20k']").val(obj.p20k);
													 $("input[name='price50k']").val(obj.p50k);
													 $("input[name='price100k']").val(obj.p100k);
													 $('.buPicArea').html('<img src="'+obj.buPic+'" height=200px width=200px>');
													 $("input[name='BU_type']").val('edit');
													 
													 $('input').attr('readonly','readonly');
													$('#buSave').css('display','none');
													$('#actEdit').html('Activate Editing').removeClass('actEditGreen').addClass('actEditRed').click(function(){
																																 $('input').attr('readonly','');
																																 $('#actEdit').html('Editing Activated').removeClass('actEditRed').addClass('actEditGreen');
																																 $('#buSave').css('display','');
																																 });
													 
												 });
	$('#loader').html('');
}

function clearEditData()
{
 	$(":input").val('');
	$(":input").css('border','1px #6c6c6c solid').css('background-color','#ffffff');
	$("input[name='BU_save']").val('SAVE');
	$('.buPicArea').html('');
	$('#actEdit').html('').removeClass('actEditRed');
	 $('#sbSave').css('display','');
	$("input[name='BU_type']").val('add');
	$('#loader').html('');
}

