

// Ajax loading HTML
var loading_html = '<img src="'+base_url+'img/ajax_loader.gif" /> <em>loading...</em>';
var gst_quick_invoice; 
function messageEffect(opt)
{
    $(opt).insertAfter( $(opt) )
        .fadeIn('slow')
        .animate({opacity: 1.0}, 8500)
        .fadeOut('slow', function() {   $(this).hide();} );        

}

function open_dialog(div_id, the_title, the_height, the_width, the_modal, the_autoOpen, the_show, the_hide )
{
       $('#'+div_id).dialog({ 
                            height:the_height,
                            width:the_width, 
                            modal: the_modal, 
                            autoOpen: the_autoOpen,
                            show: the_show, //used for animated
                            hide: the_hide // used for animated
                            });
       $('#'+div_id).dialog({ title: the_title });
       $('#'+div_id).dialog('open');
}
function open_dialog_ajax(url, div_id, the_title, the_height, the_width, the_modal, the_autoOpen, the_show, the_hide )
{
       $('#'+div_id).dialog({ 
                            height:the_height,
                            width:the_width, 
                            modal: the_modal, 
                            autoOpen: the_autoOpen,
                            show: the_show, //used for animated
                            hide: the_hide // used for animated
                            });
       $('#'+div_id).dialog({ title: the_title });
       $('#'+div_id).dialog('open');
       ajax_load(url,div_id);                 
}


function ajax_post(turl,form,update_div, msg_id)
{
    var sTimeStamp= new Date().getTime();
    turl = turl+"?time="+sTimeStamp;
    var fdata = decodeURIComponent($(form).serialize());
    
    loadingImg(update_div, true); 
    $.ajax({
        url: turl,
        data: fdata,
        dataType: "html",
        type: "POST",
        cache: false,
        success: function(data){ 
                    
                    var d = data;
                    $("#"+update_div).html(d);  
                    if(msg_id != 'undefined')
                    {   
                        $("#"+msg_id).addClass("message");
                        messageEffect("#"+msg_id);
                    }
                    }
    });            
    
return false;
}
function loadingImg(div_id,flag)
{                  
    if(flag == true) $("#"+div_id).html(loading_html);   
    else $("#"+div_id).html("");
}
function ajax_load(url,div)
{              
    loadingImg(div, true);
    $("#"+div).load(url);
}
function ajax_load_confirm(url, div, msg){
    if(confirm(msg)){
        ajax_load(url,div);
    }
}
function ajax_append(turl, div_id, loading_div)
{
    loadingImg(loading_div, true); 
    $.ajax({
        url: turl,
        data: "",
        dataType: "html",
        type: "POST",
        cache: false,
        success: function(data){ 
                        $("#"+div_id).append(data);
                        loadingImg(loading_div, false); 
                    }
    });
    
    
}

function ajax_load_dropdown(url, value, divid)
{
    if(value == "")
    {
        $("#"+divid).html("");
        return;
    }
    url = url + "/" + value;
    ajax_load(url,divid);
}

function generate_quote_gst(url, value, divid, url2)
{
    if(value == "")
    {
        $("#"+divid).html("");
        return;
    }
    url = url + "/" + value;
    ajax_load(url,divid);
    url2 = url2 + "/" + value;
    $.ajax({
        url: url2,
        data: "",
        dataType: "html",
        type: "GET",
        cache: false,
        success: function(data){ 
                     gst_quick_invoice = data;
                                         }
    });

    }

function ajax_set_text_field_value(turl, value, field_id, load_id)
{
    if(value == "")
    {
        $("#"+field_id).val(" ");
        return false;
    }
    loadingImg(load_id, true); 
    turl = turl + "/" + value;
   $.ajax({
        url: turl,
        data: "",
        dataType: "html",
        type: "GET",
        cache: false,
        success: function(data){ 
                        
                        $("#"+field_id).val(data);
                        loadingImg(load_id, false); 
                    }
    });

}
function toggle(div_id)
{
    $("#"+div_id).toggle("slow");
}

function printContent(div_id)
{
    var DocumentContainer = document.getElementById(div_id);
    var html = '<html><head>'+
               '<link href="../../../css/style_report.css" rel="stylesheet" type="text/css" />'+
               '</head><body style="background:#ffffff;">'+
               DocumentContainer.innerHTML+
               '</body></html>';

    var WindowObject = window.open("", "PrintWindow",
    "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
    WindowObject.document.writeln(html);
    WindowObject.document.close();
    WindowObject.focus();
    WindowObject.print();
    WindowObject.close();
    document.getElementById('print_link').style.display='block';
}
var counter_textbox = 2;
function add_more_text_box(name, size, write_div){
    $("#"+write_div).append("<div class='padding_5' id=\"div"+counter_textbox+"\"> <input type='text' name='"+name+"' size='"+size+"' />&nbsp;<a href='javascript: removeElm(\"#div"+counter_textbox+"\");' class='remove_link'>remove</a></div>");
    counter_textbox++;
}
function removeElm(id){
    $(id).empty().remove();
}
function generateUsername(fn,ln,un){
    
    var str = $("#"+fn).val();
    var fname = str.substring(0,3); 
    
    var uno = un.substring(5,9);
    var unop = un.substring(3,7);
    
    var lname = ln.substring(0,3); 
    
    var name = fname + uno + lname;
    var password = fname + unop;
    
    var uval = $("#username").val();
    var pval = $("#password").val();
    
    if(!uval){ 
    $("#username").val(name);
    }
    if(!pval){      
    $("#password").val(password);
    }
}
function calculateHours(id1, id2, total_txt_fld_id, error_msg_id,max_time){
    var start_time = $("#"+id1+" option:selected").text();
    var end_time = $("#"+id2+" option:selected").text();

    //Extract Time 
    start_time_hour = start_time.substr(0,2);
    start_time_min = start_time.substr(3,2);
    start_time_ap = start_time.substr(6,2);
    // Extract Time
    end_time_hour = end_time.substr(0,2);
    end_time_min = end_time.substr(3,2);
    end_time_ap = end_time.substr(6,2);


    if(start_time_ap == "am" && start_time_hour == "12"){ 
        start_time_hour = 0;
    }
    if(end_time_ap == "am" && end_time_hour == "12"){
        end_time_hour = 0;
    }

    
    if(start_time_ap == "pm" && start_time_hour != "12"){ 
        start_time_hour = Number(start_time_hour)+12
    }
    if(end_time_ap == "pm" && end_time_ap != "12"){
        end_time_hour = Number(end_time_hour)+12
    }
    
    var flag = ((Number(end_time_hour)*60) + Number(end_time_min)) -  ((Number(start_time_hour)*60) + Number(start_time_min));
    if(flag < 0){
        $('#'+id2+' option').attr('selected', false);
        $('#'+total_txt_fld_id).val("");
         $("#"+error_msg_id).addClass("error");
         $("#"+error_msg_id).text("Time In can't grater than Time Out");
        return;
    }
    
    var total_min = Math.abs( ((Number(end_time_hour)*60) + Number(end_time_min)) - ( (Number(start_time_hour)*60) + Number(start_time_min) )); 
    
    var estimated_hour, estimated_min;
    if(total_min < 60){
        estimated_hour = 0;
        estimated_min = total_min;
    }else{
        estimated_hour = total_min/60;
        //estimated_min = parseInt(total_min%60);
    }
    
    var total = estimated_hour;//+"."+estimated_min;
		$("#"+total_txt_fld_id).val(total);				
		
		var max_hours = parseInt(max_time);
		if(max_hours < total){
			$('#totalTimeId').val("");
			alert("Do not Exceed maximum hours. Maximum Hours is "+max_time);
			return false;
		}
		else{
			$('#totalTimeId').val(total);
		}
		
		$("#"+error_msg_id).removeClass("error");
		$("#"+error_msg_id).text("");
}
function  isIntegerFloatNegative( strValue ) {
  var objRegExp  =  /(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/;

  return objRegExp.test(strValue);
}

function calcPrice(qtyID, unitPriceID, totalPriceID){

    var qty = $("#"+qtyID).val();
    var unit_price = $("#"+unitPriceID).val();
    var total_price = $("#"+totalPriceID).val();
    
    
    if(unit_price == '' || unit_price == 0 || unit_price == 'undefined' || !isIntegerFloatNegative(unit_price)) unit_price = 0;
   
    //if(unit_price == "") unit_price = 1;
     
    if(qty == "" || qty == 0 || qty == 'undefined' || !isIntegerFloatNegative(qty)) qty = 0;
     
    var price = qty*unit_price;
    $("#"+totalPriceID).val(price);

}

function calcPriceTimeSheet(qtyID, unitPriceID, totalPriceID){

    var qty = $("#"+qtyID).val();
    var unit_price = $("#"+unitPriceID).val();
    var total_price = $("#"+totalPriceID).val();
    
    
    if(unit_price == '' || unit_price == 0 || unit_price == 'undefined' || !isIntegerFloatNegative(unit_price)) unit_price = 0;
   
    //if(unit_price == "") unit_price = 1;
     
    if(qty == "" || qty == 0 ) qty = 0;
     
    var price = qty*unit_price;
    $("#"+totalPriceID).val(price);

}


function open_popup(url, title, options)
{
    window.open(url, "NewWindow", options);
}

function calculateTime(id1, id2, total_txt_fld_id,error_msg_id, max_time){
    
    var start_time = $("#"+id1).val();
    var end_time = $("#"+id2).val();
    
    var total = start_time - end_time;
    
    if(total < 0){
        $('#'+id2+' option').attr('selected', false);
        $('#'+total_txt_fld_id).val("");
         $("#"+error_msg_id).addClass("error");
         $("#"+error_msg_id).text("Break Time can't grater than Hours");
        return;
    }
		$("#errorMsgId2").css("display","none");
		
		var max_hours = parseInt(max_time);
		if(max_hours < total){
			$("#"+total_txt_fld_id).val("");
			alert("Do not Exceed maximum hours. Maximum Hours is "+max_time);
			return false;
		}
		else{
			$("#"+total_txt_fld_id).val(total);
		}
		
    //$("#"+total_txt_fld_id).val(total);
}