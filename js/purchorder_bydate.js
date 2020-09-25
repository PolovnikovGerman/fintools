var itemsperpage=30;
$(document).ready(function(){
    $('#loader').css('display','none');
    initPagination();
});

function initPagination() {
    // count entries inside the hidden content
    var num_entries = $('#totalrec').val();
    var perpage = itemsperpage;    
    var curpage=$("#curpage").val();    
    // Create content inside pagination element
    $("#Pagination").pagination(num_entries, {
        current_page:curpage,
        callback: pageselectCallback,
        items_per_page: perpage, // Show only one item per page
        load_first_page: true,
        num_edge_entries : 1,
        num_display_entries : 5,
        prev_text : '<<',
        next_text : '>>'
    });
 }

function pageselectCallback(page_index, jq){    
    var perpage = itemsperpage;    
    $("#curpage").val(page_index);
    var url="/system/controller/podate_content.php";
    $("#loader").css('display','block');    
    $.post(url,{'offset':page_index,'limit':perpage},function(response){        
        $("#loader").css('display','none');
        if (response.errors=='') {
            $('#order_area').empty().append(response.data.content);
        } else {
            
        }
        

    },'json');
    return false;
}
