// JavaScript Document

$(document).ready(function() {
//Leads Popup for add/edit leads
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
	org = dim[3].split('=')[1];
	
	if(caller == 'edit')
	fillEditData(editID,org);
	else
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



});