var json_costomer_address = [];
var json_price = [];
var json_title = [];
$(function() {
  var item_total = 0.00;
  var extra_cost = 0.00;
  var gst_value = 0.00;
  
  // cabinet items dynamic add/remove section
  $('.cabinet-order-form table .add-more').live("click", function(){
    //console.log($("#code option[value='1|cabinet']").text());
    $("#add_order_item form").validate();
    $('#add_order_item').modal();
    $('#add_order_item .quantity').val('');
    $('#add_order_item .code').val('');
    $("#add_order_item .door-option input[type=radio]").removeAttr('disabled')
  });
  $('.add-order-item-form select.code').live('change',function(element){
//    element.preventDefault(); 
    value = $(this).val();
    description = $(this).parents('table').find("select.description option[value='"+value+"']").text();
    price = $(this).parents('table').find("select.price option[value='"+value+"']").text();
    
//    console.log(description);
//    console.log(price);
    
    $("#item_description").val(description);
    $("#item_price").val(price);
  });
  
  $('input.total-cost').val(total_cost_with_gst());
  $('.customer').live('change',function(element){
    
    val = $(this).val();
    set_customer_address(json_costomer_address, val);
  });
  $('.cabinet-order-form table .remove').live("click", function(element){
    element.preventDefault();    
    tmp_total = $(this).parent('td').parent('tr').find('.cab-order-data-per-item-total-cost').html();
    tmp_sub_total = $(this).parent('td').parent('tr').parent('tbody').find('.co-data-item-total-cost').html();    
    removeRow(this);
    item_total= (parseFloat(tmp_sub_total)-parseFloat(tmp_total)).toFixed(2); 
    $('.co-data-item-total-cost').html(item_total);
//    console.log(total_cost_with_gst());
    $('input.total-cost').val(total_cost_with_gst());
  });  
  
  $(".door-information .checkbox input[type=checkbox]").live('click',function(){
    
    if($('#open_frame_door').is(':checked')){
      $(this).parent().parent().parent().parent().find(".door-option input[type=radio]").removeAttr('disabled');
    }else{
      if($('#do_not_drill_door').is(':checked') || $('#no_doors').is(':checked')){
        $(this).parent().parent().parent().parent().find(".door-option input[type=radio]").attr('disabled','true');
      }else{
        $(this).parent().parent().parent().parent().find(".door-option input[type=radio]").removeAttr('disabled');
      }
    }      
  });
  
  $(".extra-cost").live('focus',function(){
    extra_cost = parseFloat($(this).val()).toFixed(2); 
  });
  $(".extra-cost").live('change',function(){
    cost = parseFloat($(this).val()).toFixed(2);
    if(!isNaN(cost)){
      //total_cost = parseFloat($('input.total-cost').val()).toFixed(2);
      //total_cost-=extra_cost;
      if(cost>=0){
        $(this).removeClass('custom-error');
        $(this).parent().find(".error").remove();
        $('input.total-cost').val(total_cost_with_gst());        
      }
      else{
        $(this).addClass('custom-error');
        $(this).after("<label generated='true' class='error'>Please enter a valid number.</label>");        
      }
    }
    else{
      $('input.total-cost').val(total_cost_with_gst());
    }
  });
  
  $('#add_order_item .save').live("click", function(element){
    //$("#add_order_item form").validate();
    $(".add-order-item-form").valid();
    if($('#add_order_item .quantity').hasClass('valid') && ($('#add_order_item select.code').val() != ''))  {
    
      // clone row
      newRow = addRowHidden('.cabinet-order-form table .add-more');
      fixCabinetOrderItemRow(newRow);
    
      quantity = parseFloat($('#add_order_item .quantity').val()).toFixed(2);
      item_code = $('#add_order_item select.code').val();
      item_cost = parseFloat($('#add_order_item .item-price').val()).toFixed(2);
      per_item_total_cost = parseFloat(item_cost*quantity).toFixed(2);
      item_title = $('#add_order_item .item-description').val();
      item_code_text = $('#add_order_item select.code option:selected').text();      
      open_frame_door = $('#add_order_item #open_frame_door').is(':checked')?1:0;
      do_not_drill_door = $('#add_order_item #do_not_drill_door').is(':checked')?1:0;
      no_doors = $('#add_order_item #no_doors').is(':checked')?1:0;
      if(open_frame_door)
        door_information = $("#add_order_item .door-option input[type='radio']").is(':checked')?$("#add_order_item .door-option input[type='radio']:checked").val():null;
      else if(do_not_drill_door && no_doors)
        door_information = null;
      else
        door_information = $("#add_order_item .door-option input[type='radio']").is(':checked')?$("#add_order_item .door-option input[type='radio']:checked").val():null;
      
      var item_arr = item_code.split('|');
      item_id = (item_arr[1]=='item')?item_arr[0]:0;
      cabite_id = (item_arr[1]=='cabinet')?item_arr[0]:0;
      door_id = (item_arr[1]=='door' || item_arr[1]=='drawer' || item_arr[1]=='wall_door')?item_arr[0]:0;
      
      // reset the form elements for future use
      $("#add_order_item input[type='text']").val('');
      $("#add_order_item input[type='radio']").removeAttr('checked');
//      $('#add_order_item a.select2-choice').addClass('select2-default');
      
      // set public value
      newRow.find('.cab-order-data-quantity').html(quantity);
      newRow.find('.data-code').html(item_code_text);
      newRow.find('.cab-order-data-each-cost').html(item_cost);
      newRow.find('.cab-order-data-per-item-total-cost').html(per_item_total_cost);
      newRow.find('.data-title').html(item_title);
      //item_total = +item_total + +per_item_total_cost;
      $('.co-data-item-total-cost').html(cab_order_item_total_cost());
      $('input.total-cost').val(total_cost_with_gst());
      
      // set index properly
      newRow.find('input.quantity').val(quantity);
      newRow.find('input.code').val(item_code);
      newRow.find('input.each-cost').val(item_arr[2]);
      newRow.find('input.cabinet_order_id').val('');
      newRow.find('input.item_id').val(item_id);
      newRow.find('input.cabinet_id').val(cabite_id);
      newRow.find('input.door_id').val(door_id);
      newRow.find('input.door_information').val(door_information);
      newRow.find('input.open_frame_door').val(open_frame_door);
      newRow.find('input.do_not_drill_door').val(do_not_drill_door);
      newRow.find('input.no_doors').val(no_doors);
  
      // close modal
      $('#add_order_item form')[0].reset();
      $('#add_order_item').modal('hide');
    }
  }); 
  
  /* -------------------------------- counter top add ----------------------------------*/
  $('#counter_top_items table .add-more').live("click", function(element){
    newRow = addRowHidden(this);
    fixCounterTopItemRow(newRow);
  });
  $('#counter_top_items table .remove').live("click", function(element){
    element.preventDefault();
    tmp_total_cost = total_item_cost(this);
    item_total_cost = $(this).parents('tr').find('.data-item-total-cost').html();
    total_cost = tmp_total_cost-item_total_cost;
    $('#counter_top_items table').find('.data-total-cost').html(total_cost.toFixed(2));
    removeRow(this);
  });
  $('#counter_top_items table .set-item-cost').live('change',function(element){
    val = $(this).parents('tr').find('select.code').val();
    //console.log($(this).parents('tr').find('select.code').val());
    price = set_item_data(json_price, val);
    title = set_item_data(json_title, val);
    $(this).parents('tr').find('.data-title').html(title);
    $(this).parents('tr').find('.data-each-cost').html(price);
    quantity = parseInt($(this).parents('tr').find('.quantity').val());
    if(isNaN(quantity))
      quantity = 0;
    item_total_cost = parseFloat(quantity*price).toFixed(2);
    $(this).parents('tr').find('.data-item-total-cost').html(item_total_cost);
    total_cost = total_item_cost(this);
    $(this).parents('table').find('.data-total-cost').html(total_cost);
  });
  /* -------------------------------- END counter top add ----------------------------------*/
  
  
  /* -------------------------------- (Extra and hardware)/(Glass Door&Shelfs) ----------------------------------*/
  $('#extra_hardware_items table .add-more').live("click", function(element){
    newRow = addRowHidden(this);
    fixExtraHardwareItemRow(newRow);
  });
  $('#extra_hardware_items table .remove').live("click", function(element){
    element.preventDefault();
    tmp_total_cost = total_item_cost(this);
    item_total_cost = $(this).parents('tr').find('.data-item-total-cost').html();
    total_cost = tmp_total_cost-item_total_cost;
    $(this).parents('table').find('.data-total-cost').html(total_cost.toFixed(2));
    removeRow(this);
  });
  
  $('#extra_hardware_items table .set-item-cost').live('change',function(element){
    val = $(this).parents('tr').find('select.code').val();
    //console.log($(this).parents('tr').find('select.code').val());
    price = set_item_data(json_price, val);
    title = set_item_data(json_title, val);
    $(this).parents('tr').find('.data-title').html(title);
    $(this).parents('tr').find('.data-each-cost').html(price);
    quantity = parseInt($(this).parents('tr').find('.quantity').val());
    if(isNaN(quantity))
      quantity = 0;
    item_total_cost = parseFloat(quantity*price).toFixed(2);
    $(this).parents('tr').find('.data-item-total-cost').html(item_total_cost);
    total_cost = total_item_cost(this);
    console.log(total_cost);
    $(this).parents('table').find('.data-total-cost').html(total_cost);
  });
  /* -------------------------------- END (Extra and hardware)/(Glass Door&Shelfs) ----------------------------------*/

  /* -------------------------------- Installer Paysheet ----------------------------------*/
  $('#installer_paysheet_items table .add-more').live("click", function(element){
    newRow = addRowHidden(this);
    fixInstallerPaysheetItemRow(newRow);
  });
  $('#installer_paysheet_items table .remove').live("click", function(element){
    element.preventDefault();
    removeRow(this);
  });
  $("#installer_paysheet_items table .set-cost").live('change',function(){
    quantity = parseInt($(this).parents('tr').find('input.quantity').val());
    cost = parseFloat($(this).parents('tr').find('input.price_each').val()).toFixed(2);
    if(isNaN(cost))
      cost = 0.00;
    if(quantity>=0){
      $(this).parents('tr').find('.custom-error').removeClass('custom-error');
      $(this).parents('tr').find(".error").remove();
      $(this).parents('tr').find('input.total').val(parseFloat(quantity*cost).toFixed(2));      
    }else{
      $(this).addClass('custom-error');
      $(this).after("<label generated='true' class='error'>Please enter a valid number.</label>"); 
    }
  });
  
  /* -------------------------------- END Installer Paysheet ----------------------------------*/

  /*--------------------------------- Quote Status --------------------------------------------*/
  $('.quote-status-link').live('click',function(){
    $('#quote_status_div').toggle('slow');
  });
  $('.quote-status-link-cancel').live('click',function(){
    $('#quote_status_div').toggle('slow');
  });
  
  
  /*-------------------------------------granite order-----------------------------------------------*/
  // cabinet items dynamic add/remove section
  $('.granite-order-form table .add-more').live("click", function(){
    //console.log($("#code option[value='1|cabinet']").text());
    $("#add_granite_order_item form").validate();
    $('#add_granite_order_item').modal();
    $('#add_granite_order_item .quantity').val('');
    $('#add_granite_order_item .code').val('');
  });
  $('.add-granite-order-item-form select.code').live('change',function(element){
//    element.preventDefault(); 
    value = $(this).val();
    description = $(this).parents('table').find("select.description option[value='"+value+"']").text();
    price = $(this).parents('table').find("select.price option[value='"+value+"']").text();
    
//    console.log(description);
//    console.log(price);
    
    $("#item_description").val(description);
    $("#item_price").val(price);
  });
  
  
  $('.granite-order-form table .remove').live("click", function(element){
    element.preventDefault();    
    tmp_total = $(this).parent('td').parent('tr').find('.cab-order-data-per-item-total-cost').html();
    tmp_sub_total = $(this).parent('td').parent('tr').parent('tbody').find('.co-data-item-total-cost').html();    
    removeRow(this);
    item_total= (parseFloat(tmp_sub_total)-parseFloat(tmp_total)).toFixed(2); 
    $('.co-data-item-total-cost').html(item_total);
//    console.log(total_cost_with_gst());
    $('input.total-cost').val(total_cost_with_gst());
  });
  
  $(".granite-order-form .extra-cost").live('focus',function(){
    extra_cost = parseFloat($(this).val()).toFixed(2); 
  });
  $(".granite-order-form .extra-cost").live('change',function(){
    cost = parseFloat($(this).val()).toFixed(2);
    if(!isNaN(cost)){
      //total_cost = parseFloat($('input.total-cost').val()).toFixed(2);
      //total_cost-=extra_cost;
      if(cost>=0){
        $(this).removeClass('custom-error');
        $(this).parent().find(".error").remove();
        $('input.total-cost').val(total_cost_with_gst());        
      }
      else{
        $(this).addClass('custom-error');
        $(this).after("<label generated='true' class='error'>Please enter a valid number.</label>");        
      }
    }
    else{
      $('input.total-cost').val(total_cost_with_gst());
    }
  });
  
  $('#add_granite_order_item .save').live("click", function(element){
    //$("#add_granite_order_item form").validate();
    $(".add-granite-order-item-form").valid();
    if($('#add_granite_order_item .quantity').hasClass('valid') && ($('#add_granite_order_item select.code').val() != ''))  {
    
      // clone row
      newRow = addRowHidden('.granite-order-form table .add-more');
      fixGraniteOrderItemRow(newRow);
    
      quantity = parseInt($('#add_granite_order_item .quantity').val());
      item_code = $('#add_granite_order_item select.code').val();
      item_cost = parseFloat($('#add_granite_order_item .item-price').val()).toFixed(2);
      per_item_total_cost = parseFloat(item_cost*quantity).toFixed(2);
      item_title = $('#add_granite_order_item .item-description').val();
      item_code_text = $('#add_granite_order_item select.code option:selected').text();      
//      open_frame_door = $('#add_granite_order_item #open_frame_door').is(':checked')?1:0;
//      do_not_drill_door = $('#add_granite_order_item #do_not_drill_door').is(':checked')?1:0;
//      no_doors = $('#add_granite_order_item #no_doors').is(':checked')?1:0;
//      if(open_frame_door)
//        door_information = $("#add_granite_order_item .door-option input[type='radio']").is(':checked')?$("#add_granite_order_item .door-option input[type='radio']:checked").val():null;
//      else if(do_not_drill_door && no_doors)
//        door_information = null;
//      else
//        door_information = $("#add_granite_order_item .door-option input[type='radio']").is(':checked')?$("#add_granite_order_item .door-option input[type='radio']:checked").val():null;
//      
      var item_arr = item_code.split('|');
      item_id = (item_arr[1]=='item')?item_arr[0]:0;
      cabite_id = (item_arr[1]=='cabinet')?item_arr[0]:0;
      door_id = (item_arr[1]=='door' || item_arr[1]=='drawer' || item_arr[1]=='wall_door')?item_arr[0]:0;
      
      // reset the form elements for future use
      $("#add_granite_order_item input[type='text']").val('');
//      $("#add_granite_order_item input[type='radio']").removeAttr('checked');
      $('#add_granite_order_item select.code').addClass('select2-default');
      
      // set public value
      newRow.find('.cab-order-data-quantity').html(quantity);
      newRow.find('.data-code').html(item_code_text);
      newRow.find('.cab-order-data-each-cost').html(item_cost);
      newRow.find('.cab-order-data-per-item-total-cost').html(per_item_total_cost);
      newRow.find('.data-title').html(item_title);
      //item_total = +item_total + +per_item_total_cost;
      $('.co-data-item-total-cost').html(cab_order_item_total_cost());
      $('input.total-cost').val(total_cost_with_gst());
      
      // set index properly
      newRow.find('input.quantity').val(quantity);
      newRow.find('input.code').val(item_code);
      newRow.find('input.each-cost').val(item_arr[2]);
      newRow.find('input.granite_order_id').val('');
      newRow.find('input.item_id').val(item_id);
      newRow.find('input.cabinet_id').val(cabite_id);
      newRow.find('input.door_id').val(door_id);
//      newRow.find('input.door_information').val(door_information);
//      newRow.find('input.open_frame_door').val(open_frame_door);
//      newRow.find('input.do_not_drill_door').val(do_not_drill_door);
//      newRow.find('input.no_doors').val(no_doors);
  
      // close modal
      $('#add_granite_order_item form')[0].reset();
      $('#add_granite_order_item').modal('hide');
    }
  }); 
});

function customRange(a) {  
  var b = new Date();  
  var c = new Date(wo_year, wo_month, wo_date);
//  var m = new Date(wo_year, wo_month, wo_date);
//  m.setDate(m.getDate() + 1)
//  console.log(m);
  return {  
    minDate: c
  }  
}  
function set_value(year,month,date){
//  console.log(year);
  wo_year = year;
  wo_month = month;
  wo_date = date;
}

function total_item_cost(element){
  total_cost = 0.00;
  console.log($(element).parents('table').find('.data-item-total-cost'));
  $(element).parents('table').find('.data-item-total-cost').each(function(index,value){    
    val = parseFloat($(value).html()).toFixed(2);
    if(isNaN(val))
      val=0.00;
    total_cost = +total_cost + +val;
  });
  return parseFloat(total_cost).toFixed(2);
}
function set_customer_address(obj,serach){
  if(serach){
    $.each(obj, function(index,val_obj1){        
      $.each(val_obj1, function(index,val_obj2){
        //console.log(val_obj2.id);
        if(val_obj2.id==serach){
          $.each(val_obj2, function(index,val_obj3){          
            $('input.'+index).val(val_obj3);
          });
        }
      });
    });
  }
}
function set_item_data(obj,serach){
  return_value ="";
  if(serach){
    $.each(obj, function(index,val_obj1){        
      if(index==serach){
        return_value = val_obj1;
      }
    });    
  }
  return return_value;
}
function item_total_cost(element){
  total_cost = 0.00;  
  
  $(".data-per-item-total-cost").each(function(index,value){    
    val = parseFloat($(value).html()).toFixed(2);    
    if(isNaN(val))
      val=0.00;
    total_cost = +total_cost + +val;
  });
  
  return parseFloat(total_cost).toFixed(2);
}

function cab_order_item_total_cost(){
  total_cost = 0.00;  
  
  $(".cab-order-data-per-item-total-cost").each(function(index,value){    
    val = parseFloat($(value).html()).toFixed(2);    
    if(isNaN(val))
      val=0.00;
    total_cost = +total_cost + +val;
  });
  
  return parseFloat(total_cost).toFixed(2);
}

function total_cost_with_gst(){
  total_cost = 0.00;
  gst_value = $('.gst_value').val();
  $(".extra-cost").each(function(index,value){    
    val = parseFloat($(value).val()).toFixed(2);
    if(isNaN(val))
      val=0.00;
    total_cost = +total_cost + +val;
  });
  $(".cab-order-data-per-item-total-cost").each(function(index,value){    
    val = parseFloat($(value).html()).toFixed(2);
    if(isNaN(val))
      val=0.00;
    total_cost = +total_cost + +val;
  });
  gst = parseFloat((gst_value*total_cost)/100).toFixed(2);
  total_cost = +total_cost + +gst;
  
  return parseFloat(total_cost).toFixed(2);
}
function addRowHidden(element) {
  parent = $(element).parents('table');
  clone = parent.find('.clone-row:first').clone().insertAfter(parent.find('.clone-row:last'));
  clone.find('.text input.user-input').val('');
  clone.find('.text input.user-input').addClass('hide');
  clone.find('.remove').removeClass('hide');
  return clone;
}


function fixCabinetOrderItemRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  index = last_row.find('input.code').attr('id').split('CabinetOrderItem')[1].split('Code')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // set index properly
  jqElement.find('input.quantity').attr('name', 'data[CabinetOrderItem][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', 'CabinetOrderItem' + index + 'ItemQuantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('input.code').attr('name', 'data[CabinetOrderItem][' + index + '][code]');
  jqElement.find('input.code').attr('id', 'CabinetOrderItem' + index + 'Code');
  jqElement.find('input.code').val('');  
  
  jqElement.find('input.cabinet_order_id').attr('name', 'data[CabinetOrderItem][' + index + '][cabinet_order_id]');
  jqElement.find('input.cabinet_order_id').attr('id', 'CabinetOrderItem' + index + 'CabinetOrderId');
  jqElement.find('input.cabinet_order_id').val('');
  
  jqElement.find('input.item_id').attr('name', 'data[CabinetOrderItem][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', 'CabinetOrderItem' + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  
  jqElement.find('input.cabinet_id').attr('name', 'data[CabinetOrderItem][' + index + '][cabinet_id]');
  jqElement.find('input.cabinet_id').attr('id', 'CabinetOrderItem' + index + 'CabinetId');
  jqElement.find('input.cabinet_id').val('');
  
  jqElement.find('input.door_id').attr('name', 'data[CabinetOrderItem][' + index + '][door_id]');
  jqElement.find('input.door_id').attr('id', 'CabinetOrderItem' + index + 'DoorId');
  jqElement.find('input.door_id').val('');
  
  jqElement.find('input.door_information').attr('name', 'data[CabinetOrderItem][' + index + '][door_information]');
  jqElement.find('input.door_information').attr('id', 'CabinetOrderItem' + index + 'DoorInformation');
  jqElement.find('input.door_information').val('');
  
  jqElement.find('input.open_frame_door').attr('name', 'data[CabinetOrderItem][' + index + '][open_frame_door]');
  jqElement.find('input.open_frame_door').attr('id', 'CabinetOrderItem' + index + 'OpenFrameDoor');
  jqElement.find('input.open_frame_door').val('');
  
  jqElement.find('input.do_not_drill_door').attr('name', 'data[CabinetOrderItem][' + index + '][do_not_drill_door]');
  jqElement.find('input.do_not_drill_door').attr('id', 'CabinetOrderItem' + index + 'DoNotDrillDoor');
  jqElement.find('input.do_not_drill_door').val('');
  
  jqElement.find('input.no_doors').attr('name', 'data[CabinetOrderItem][' + index + '][no_doors]');
  jqElement.find('input.no_doors').attr('id', 'CabinetOrderItem' + index + 'NoDoors');
  jqElement.find('input.no_doors').val('');
  
  jqElement.find('.cab-order-data-quantity').html('');
  jqElement.find('.data-code').html('');
  jqElement.find('.cab-order-data-each-cost').html('');
  jqElement.find('.cab-order-data-per-item-total-cost').html('');
  
  jqElement.removeClass('hide');
}

function fixGraniteOrderItemRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
//  console.log(last_row.find('input.code').attr('id').split('GraniteOrderItem'));
  index = last_row.find('input.code').attr('id').split('GraniteOrderItem')[1].split('Code')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // set index properly
  jqElement.find('input.quantity').attr('name', 'data[GraniteOrderItem][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', 'GraniteOrderItem' + index + 'ItemQuantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('input.code').attr('name', 'data[GraniteOrderItem][' + index + '][code]');
  jqElement.find('input.code').attr('id', 'GraniteOrderItem' + index + 'Code');
  jqElement.find('input.code').val('');  
  
  jqElement.find('input.granite_order_id').attr('name', 'data[GraniteOrderItem][' + index + '][granite_order_id]');
  jqElement.find('input.granite_order_id').attr('id', 'GraniteOrderItem' + index + 'GraniteOrderId');
  jqElement.find('input.granite_order_id').val('');
  
  jqElement.find('input.item_id').attr('name', 'data[GraniteOrderItem][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', 'GraniteOrderItem' + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  
  jqElement.find('input.cabinet_id').attr('name', 'data[GraniteOrderItem][' + index + '][cabinet_id]');
  jqElement.find('input.cabinet_id').attr('id', 'GraniteOrderItem' + index + 'CabinetId');
  jqElement.find('input.cabinet_id').val('');
  
  jqElement.find('input.door_id').attr('name', 'data[GraniteOrderItem][' + index + '][door_id]');
  jqElement.find('input.door_id').attr('id', 'GraniteOrderItem' + index + 'DoorId');
  jqElement.find('input.door_id').val('');
  
  jqElement.find('.cab-order-data-quantity').html('');
  jqElement.find('.data-code').html('');
  jqElement.find('.cab-order-data-each-cost').html('');
  jqElement.find('.cab-order-data-per-item-total-cost').html('');
  
  jqElement.removeClass('hide');
}

function fixCounterTopItemRow(jqElement){
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  index = last_row.find('select.code').attr('id').split('CabinetOrderItem')[1].split('Code')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // remove select2 garbage
  jqElement.find('.select2-container').remove();
  
  // set index properly
  jqElement.find('input.quote_id').attr('name', 'data[CabinetOrderItem][' + index + '][quote_id]');
  jqElement.find('input.quote_id').attr('id', 'CabinetOrderItem' + index + 'QuoteId');
  //jqElement.find('input.quote_id').val('');
  
  jqElement.find('input.item_id').attr('name', 'data[CabinetOrderItem][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', 'CabinetOrderItem' + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  
  jqElement.find('input.cabinet_id').attr('name', 'data[CabinetOrderItem][' + index + '][cabinet_id]');
  jqElement.find('input.cabinet_id').attr('id', 'CabinetOrderItem' + index + 'CabinetId');
  jqElement.find('input.cabinet_id').val('');
  
  jqElement.find('input.door_id').attr('name', 'data[CabinetOrderItem][' + index + '][door_id]');
  jqElement.find('input.door_id').attr('id', 'CabinetOrderItem' + index + 'DoorId');
  jqElement.find('input.door_id').val(''); 
  
  jqElement.find('input.used_in').attr('name', 'data[CabinetOrderItem][' + index + '][used_in]');
  jqElement.find('input.used_in').attr('id', 'CabinetOrderItem' + index + 'UsedIn');
  jqElement.find('input.used_in').val('');
  
  jqElement.find('input.quantity').attr('name', 'data[CabinetOrderItem][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', 'CabinetOrderItem' + index + 'Quantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('select.code').attr('name', 'data[CabinetOrderItem][' + index + '][code]');
  jqElement.find('select.code').attr('id', 'CabinetOrderItem' + index + 'Code');
  jqElement.find('select.code').val('');  
  
  jqElement.find('input.order_number').attr('name', 'data[CabinetOrderItem][' + index + '][order_number]');
  jqElement.find('input.order_number').attr('id', 'CabinetOrderItem' + index + 'OrderNumber');
  jqElement.find('input.order_number').val('');
  
  // set select2 functionality
  jqElement.find("select.code").select2();
  
  jqElement.find('.data-title').html('');
  jqElement.find('.data-each-cost').html('0.00');
  jqElement.find('.data-item-total-cost').html('0.00');
  
  jqElement.removeClass('hide');
}

function fixExtraHardwareItemRow(jqElement){
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  //console.log(jqElement.parents('div#extra_hardware_items').find('.form_type'));
  model_str = jqElement.parents('div#extra_hardware_items').find('.form_type').val();
  index = last_row.find('select.code').attr('id').split(model_str)[1].split('Code')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // remove select2 garbage
  jqElement.find('.select2-container').remove();
  
  // set index properly
  jqElement.find('input.quote_id').attr('name', 'data['+ model_str +'][' + index + '][quote_id]');
  jqElement.find('input.quote_id').attr('id', model_str + index + 'QuoteId');
  //jqElement.find('input.quote_id').val('');
  
  jqElement.find('input.item_id').attr('name', 'data['+ model_str +'][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', model_str + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  
  jqElement.find('input.cabinet_id').attr('name', 'data['+ model_str +'][' + index + '][cabinet_id]');
  jqElement.find('input.cabinet_id').attr('id', model_str + index + 'CabinetId');
  jqElement.find('input.cabinet_id').val('');
  
  jqElement.find('input.door_id').attr('name', 'data['+ model_str +'][' + index + '][door_id]');
  jqElement.find('input.door_id').attr('id', model_str + index + 'DoorId');
  jqElement.find('input.door_id').val(''); 
  
  jqElement.find('input.optional_color').attr('name', 'data['+ model_str +'][' + index + '][optional_color]');
  jqElement.find('input.optional_color').attr('id', model_str + index + 'OptionalColor');
  jqElement.find('input.optional_color').val('');
  
  jqElement.find('input.quantity').attr('name', 'data['+ model_str +'][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', model_str + index + 'Quantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('select.code').attr('name', 'data['+ model_str +'][' + index + '][code]');
  jqElement.find('select.code').attr('id', model_str + index + 'Code');
  jqElement.find('select.code').val('');  
  
  jqElement.find('input.order_number').attr('name', 'data['+ model_str +'][' + index + '][order_number]');
  jqElement.find('input.order_number').attr('id', model_str + index + 'OrderNumber');
  jqElement.find('input.order_number').val('');
  
  // set select2 functionality
  jqElement.find("select.code").select2();
  
  jqElement.find('.data-title').html('');
  jqElement.find('.data-each-cost').html('0.00');
  jqElement.find('.data-item-total-cost').html('0.00');
  
  jqElement.removeClass('hide');
}

function fixInstallerPaysheetItemRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  index = last_row.find('input.quantity').attr('id').split('QuoteInstallerPaysheet')[1].split('Quantity')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // set index properly
  jqElement.find('input.quote_id').attr('name', 'data[QuoteInstallerPaysheet][' + index + '][quote_id]');
  jqElement.find('input.quote_id').attr('id', 'QuoteInstallerPaysheet' + index + 'QuoteId');
  
  jqElement.find('input.quantity').attr('name', 'data[QuoteInstallerPaysheet][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', 'QuoteInstallerPaysheet' + index + 'Quantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('input.task_description').attr('name', 'data[QuoteInstallerPaysheet][' + index + '][task_description]');
  jqElement.find('input.task_description').attr('id', 'QuoteInstallerPaysheet' + index + 'TaskDescription');
  jqElement.find('input.task_description').val('');  
  
  jqElement.find('input.unit').attr('name', 'data[QuoteInstallerPaysheet][' + index + '][unit]');
  jqElement.find('input.unit').attr('id', 'QuoteInstallerPaysheet' + index + 'Unit');
  jqElement.find('input.unit').val('');
  
  jqElement.find('input.price_each').attr('name', 'data[QuoteInstallerPaysheet][' + index + '][price_each]');
  jqElement.find('input.price_each').attr('id', 'QuoteInstallerPaysheet' + index + 'PriceEach');
  jqElement.find('input.price_each').val('');
  
  jqElement.find('input.total').attr('name', 'data[QuoteInstallerPaysheet][' + index + '][total]');
  jqElement.find('input.total').attr('id', 'QuoteInstallerPaysheet' + index + 'Total');
  jqElement.find('input.total').val('');
  
  jqElement.removeClass('hide');
}

(function( $ ) {
  $.widget( "ui.combobox", {
    _create: function() {
      var input,
      that = this,
      select = this.element.hide(),
      selected = select.children( ":selected" ),
      value = selected.val() ? selected.text() : "",
      wrapper = this.wrapper = $( "<span>" )
      .addClass( "ui-combobox" )
      .insertAfter( select );
 
      function removeIfInvalid(element) {
        var value = $( element ).val(),
        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
        valid = false;
        select.children( "option" ).each(function() {
          if ( $( this ).text().match( matcher ) ) {
            this.selected = valid = true;
            return false;
          }
        });
        if ( !valid ) {
          // remove invalid value, as it didn't match anything
          $( element )
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
          select.val( "" );
          setTimeout(function() {
            input.tooltip( "close" ).attr( "title", "" );
          }, 2500 );
          input.data( "autocomplete" ).term = "";
          return false;
        }
      }
 
      input = $( "<input>" )
      .appendTo( wrapper )
      .val( value )
      .attr( "title", "" )
      .addClass( "ui-state-default ui-combobox-input" )
      .autocomplete({
        delay: 0,
        minLength: 0,
        source: function( request, response ) {
          var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
          response( select.children( "option" ).map(function() {
            var text = $( this ).text();
            if ( this.value && ( !request.term || matcher.test(text) ) )
              return {
                label: text.replace(
                  new RegExp(
                    "(?![^&;]+;)(?!<[^<>]*)(" +
                    $.ui.autocomplete.escapeRegex(request.term) +
                    ")(?![^<>]*>)(?![^&;]+;)", "gi"
                    ), "<strong>$1</strong>" ),
                value: text,
                option: this
              };
          }) );
        },
        select: function( event, ui ) {
          ui.item.option.selected = true;
          that._trigger( "selected", event, {
            item: ui.item.option
          });
          $("#item_description").val($("#description option[value='"+ui.item.option.value+"']").text());
          $("#item_price").val($("#price option[value='"+ui.item.option.value+"']").text());
        },
        change: function( event, ui ) {
          if ( !ui.item ) {
            return removeIfInvalid( this );
          }
        }
      })
      .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
      input.data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + item.label + "</a>" )
        .appendTo( ul );
      };
 
      $( "<a>" )
      .attr( "tabIndex", -1 )
      .attr( "title", "Show All Items" )
      .tooltip()
      .appendTo( wrapper )
      .button({
        icons: {
          primary: "ui-icon-triangle-1-s"
        },
        text: false
      })
      .removeClass( "ui-corner-all" )
      .addClass( "ui-corner-right ui-combobox-toggle" )
      .click(function() {
        // close if already visible
        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
          input.autocomplete( "close" );
          removeIfInvalid( input );
          return;
        }
 
        // work around a bug (likely same cause as #5265)
        $( this ).blur();
 
        // pass empty string as value to search for, displaying all results
        input.autocomplete( "search", "" );
        input.focus();
      });
 
      input
      .tooltip({
        position: {
          of: this.button
        },
        tooltipClass: "ui-state-highlight"
      });
    },
 
    destroy: function() {
      this.wrapper.remove();
      this.element.show();
      $.Widget.prototype.destroy.call( this );
    }
  });
})( jQuery );