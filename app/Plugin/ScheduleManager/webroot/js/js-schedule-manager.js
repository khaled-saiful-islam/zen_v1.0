var json_price = [];
var json_title = [];
var s_date = new Date();
var e_date = new Date();
var all_Day = "";
var app_even_data = [];
var app_event_id = 0;
var app_all_data = [];
var calendar_all_event_data = [];

$(function() {
  var item_total = 0.00;
  var extra_cost = 0.00;
  var gst_value = 0.00;
  
  // cabinet items dynamic add/remove section
  $('.service-entry-form table .add-more').live("click", function(){
    //console.log('hi');
    $('#add_item_service form')[0].reset();
    $("#add_item_service form").validate();
    $('#add_item_service').modal();
    $('#add_item_service .item-quantity').val('');
    $('#add_item_service select.service-code').val('');
    $('#add_item_service select.reason').val('');
  });
  $('#add_item_service select.service-code').live('change',function(){
    description = $(this).parents('table').find("select.description option[value='"+$(this).val()+"']").text();
    price = $(this).parents('table').find("select.price option[value='"+$(this).val()+"']").text();
    po_number = $(this).parents('table').find("select.po_number option[value='"+$(this).val()+"']").text();
    po_id = $(this).parents('table').find("select.po_id option[value='"+$(this).val()+"']").text();
    
    $("#add_item_service #item_description").val(description);
    $("#add_item_service #item_price").val(price);
    $("#add_item_service .item-po-number").val(po_number);
    $("#add_item_service .item-po-id").val(po_id);
  });

  $('.service-entry-form table .remove').live("click", function(element){
    element.preventDefault();    
    tmp_total = $(this).parent('td').parent('tr').find('.data-per-item-total-cost').html();
    tmp_sub_total = $(this).parent('td').parent('tr').parent('tbody').find('.data-item-total-cost').html();    
    removeRow(this);
    item_total= (parseFloat(tmp_sub_total)-parseFloat(tmp_total)).toFixed(2); 
    $('.data-item-total-cost').html(item_total);
    //console.log(total_cost_with_gst());
    $('input.total-cost').val(total_cost_with_gst());
  });  
  
  
  
  
  $('#add_item_service .save').live("click", function(element){
    //$("#add_item_service form").validate({ignore: null});
    $("#add_item_service form").valid();
    if($('#add_item_service .item-quantity').hasClass('valid') && ($('#add_item_service select.service-code').val() != ''))  {
    
      // clone row
      newRow = addRowHidden('.service-entry-form table .add-more');
      fixServiceItemRow(newRow);
    
      quantity = parseFloat($('#add_item_service .item-quantity').val()).toFixed(2);
      item_code = $('#add_item_service select.service-code').val();
      item_cost = parseFloat($('#add_item_service .item-price').val()).toFixed(2);
      per_item_total_cost = parseFloat(item_cost*quantity).toFixed(2);
      item_title = $('#add_item_service .item-description').val();
      item_code_text = $('#add_item_service select.service-code option:selected').text();     
      item_po_id = $('#add_item_service .item-po-id').val();  
      item_po_number = $('#add_item_service select.po_number option:selected').text();
      item_reason_id = $('#add_item_service select.reason').val();  
      item_reason_title = $('#add_item_service select.reason option:selected').text(); 
      
      var item_arr = item_code.split('|');
      item_id = (item_arr[1]=='item')?item_arr[0]:0;
      cabite_id = (item_arr[1]=='cabinet')?item_arr[0]:0;
      door_id = (item_arr[1]=='door' || item_arr[1]=='drawer' || item_arr[1]=='wall_door')?item_arr[0]:0;
      
      // reset the form elements for future use
      //$("#add_item_service input[type='text']").val('');
      //$('#add_item_service select').val('');
      //console.log(item_po_id);
      //console.log(item_reason_id);
      // set public value
      newRow.find('.data-quantity').html(quantity);
      newRow.find('.data-code').html(item_code_text);
      newRow.find('.data-each-cost').html(item_cost);
      newRow.find('.data-per-item-total-cost').html(per_item_total_cost);
      newRow.find('.data-title').html(item_title);
      $('.data-item-total-cost').html(item_total_cost());
      newRow.find('.data-reason').html(item_reason_title);
      newRow.find('.data-purchase-order-number').html(item_po_number);
      //$('input.total-cost').val(total_cost_with_gst());
      
      // set index properly
      newRow.find('input.quantity').val(quantity);
      newRow.find('input.code').val(item_code);
      //newRow.find('input.each-cost').val(item_arr[2]);
      //newRow.find('input.cabinet_order_id').val('');
      newRow.find('input.item_id').val(item_id);
      newRow.find('input.cabinet_id').val(cabite_id);
      newRow.find('input.door_id').val(door_id);
      newRow.find('input.reason').val(item_reason_id);
      newRow.find('input.purchase_order_id').val(item_po_id);
  
      // close modal
      $('#add_item_service form')[0].reset();
      $('#add_item_service .item-quantity').val('');
      $('#add_item_service select.service-code').val('');
      $('#add_item_service select.reason').val('');
      $('#add_item_service').modal('hide');
    }
  }); 
  
  /*---------------------------------------------------- Appointment --------------------------------------------------*/
  
  
  $('.installer-link').live('click',function(){
    //$('#installer_holidays_div').toggle('slow');
    });
  $( "#installer_holidays_date").datepicker({
    dateFormat:"dd mm yy"
  });
  
  /*--------------------------------- installer-schedule Status --------------------------------------------*/
  $('.installer-schedule-status-link').live('click',function(){
    $('#installer_schedule_status_div').toggle('slow');
  });
  $('.installer-schedule-status-link-cancel').live('click',function(){
    $('#installer_schedule_status_div').toggle('slow');
  });
  
  
});

function all_schedule_calendar(){
  $('#full_calender').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    defaultView: 'month',
    selectable: false,
    selectHelper: false,
    events: calendar_all_event_data,
    next: function(){
    },
    eventClick: function(calEvent, jsEvent, view) {
    //      console.log(calEvent);
    //      console.log(jsEvent);
    //      console.log(view);
    },
    eventRender: function(event, element) {
      //      console.log(event);
      element.qtip({
        content: event.description,
        position: {
          corner: {
            target: 'bottomLeft',
            tooltip: 'topLeft'
          },
          adjust: {
            screen: true
          }
        },
        style: {
          name: 'blue',
          width: 300,
          height: "auto",
          color: "#000000",
          textAlign: 'left',
          tip: 'topLeft',
          background: event.color
        }

      });
    }
  });
}

function appointment_calendar(){
  $('#appointment').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
//    defaultView: 'agendaWeek',
    selectable: true,
    selectHelper: true,
    eventColor: '#bce8f1',
    select: function(startDate, endDate, allDay, jsEvent, view) {      
      s_date = startDate;
      e_date = endDate;
      all_Day = allDay;
      booking_date = $.fullCalendar.formatDate(startDate,'dddd, MMMM d,yyyy');
      start_hours = $.fullCalendar.formatDate(startDate,'hh:mm tt');
      s_hours = $.fullCalendar.formatDate(startDate,'hh:mm');
      e_hours = $.fullCalendar.formatDate(endDate,'hh:mm');
      diff_time = time_diff(startDate,endDate);//;
      //console.log(startDate);
      
      $('#add_appointment form')[0].reset();
      $('#add_appointment form input.booking-on').val(booking_date);
      $('#add_appointment form input.booking-on-time').val(start_hours);
      $('#add_appointment form input.hours').val(diff_time);
      //$('#add_appointment form input.start-date').val($.fullCalendar.formatDate(startDate,'yyyy-MM-dd hh:mm:ss tt'));
      //$('#add_appointment form input.end-date').val($.fullCalendar.formatDate(endDate,'yyyy-MM-dd hh:mm:ss tt'));
      
      $('#add_appointment').modal();
    },
    editable: true,
    events: app_even_data,
    eventResizeStop: function(event, jsEvent, ui, view){       
      
    },
    eventResize : function(event){
      ajax_call_resize_data(event.id,$.fullCalendar.formatDate(event.start,'dddd, MMMM d,yyyy hh:mm tt'),$.fullCalendar.formatDate(event.end,'dddd, MMMM d,yyyy hh:mm tt'),'edit');
    },
    eventDrop : function(event){
      ajax_call_resize_data(event.id,$.fullCalendar.formatDate(event.start,'dddd, MMMM d,yyyy hh:mm tt'),$.fullCalendar.formatDate(event.end,'dddd, MMMM d,yyyy hh:mm tt'),'edit');
    },
    eventClick: function(event, jsEvent, view) {  
//      app_event_id = event.id; 
//      $.ajax({
//        url: app_all_data,
//        type: 'POST',
//        data: {
//          event_id:event.id
//        },
//        dataType: "json",
//        success: function( response ) {
//            $('#add_appointment').modal(); 
//            $('#add_appointment form select.work-order-id').val(response.work_order_id);
//            $('#add_appointment form input.job-name').val(response.job_name);
//            $('#add_appointment form input.app-id').val(response.id);
//            $('#add_appointment form input.address').val(response.address);
//            $('#add_appointment form input.city').val(response.city);
//            $('#add_appointment form input.province').val(response.province);
//            $('#add_appointment form input.postal_code').val(response.postal_code);
//            $('#add_appointment form input.country').val(response.country);
//            $('#add_appointment form select.service-tech-id').val(response.service_tech_id);
//            //console.log(new Date('2013-03-12T08:25:00+00:00'));
//            //console.log(value.Appointment.start_date);
//            //console.log(value.Appointment.end_date.toString());
//            start_date = $.fullCalendar.parseDate(response.start_date);
//            end_date = $.fullCalendar.parseDate(response.end_date);
//            diff_time = time_diff(start_date,end_date);
//            console.log(Date.parse(response.start_date));
//            console.log(start_date);
//            console.log($.fullCalendar.parseDate(response.start_date));
              
//            $('#add_appointment input.booking-on').val($.fullCalendar.formatDate(start_date,'dddd, MMMM d,yyyy'));
//            $('#add_appointment input.booking-on-time').val($.fullCalendar.formatDate(start_date,'hh:mm tt'));
//            $('#add_appointment input.hours').val(diff_time);
//            $('#add_appointment button.save').addClass('update');
//            $('#add_appointment button.update').text('Update');
//            $('#add_appointment button.update').removeClass('save');
//            $('#add_appointment .modal-footer').append("<button class='btn btn-primary delete'>Delete</button>");

//        }                    
//      });
    },
    eventRender: function(event, element) {
      //      console.log(event);
      element.qtip({
        content: event.description,
        position: {
          corner: {
            target: 'bottomLeft',
            tooltip: 'topLeft'
          },
          adjust: {
            screen: true
          }
        },
        style: {
          name: 'blue',
          width: 300,
          height: "auto",
          color: "#000000",
          textAlign: 'left',
          tip: 'topLeft',
          background: '#bce8f1'
        }

      });
    }
  });
}


function time_diff(s_date,e_date){
  diff = 0;
  if(s_date>e_date){
    diff = (s_date.getTime() - e_date.getTime())/(60*1000);    
  }else if(e_date>s_date){
    diff = (e_date.getTime() - s_date.getTime())/(60*1000);
  }

  if(parseInt(diff/60)==0)
    diff = '00:'+parseInt(diff%60);
  else{
    if(parseInt(diff%60)==0)
      diff = parseInt(diff/60)+':00';
    else
      diff = parseInt(diff/60)+':'+parseInt(diff%60);
  }
  return diff;
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

function addRowHidden(element) {
  parent = $(element).parents('table');
  clone = parent.find('.clone-row:first').clone().insertAfter(parent.find('.clone-row:last'));
  clone.find('.text input.user-input').val('');
  clone.find('.text input.user-input').addClass('hide');
  clone.find('.remove').removeClass('hide');
  return clone;
}


function fixServiceItemRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  //console.log(last_row.find('input.code'));
  index = last_row.find('input.code').attr('id').split('ScheduleItem')[1].split('Code')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // set index properly
  jqElement.find('input.quantity').attr('name', 'data[ScheduleItem][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', 'ScheduleItem' + index + 'ItemQuantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('input.code').attr('name', 'data[ScheduleItem][' + index + '][code]');
  jqElement.find('input.code').attr('id', 'ScheduleItem' + index + 'Code');
  jqElement.find('input.code').val('');  
  
  jqElement.find('input.schedule_id').attr('name', 'data[ScheduleItem][' + index + '][schedule_id]');
  jqElement.find('input.schedule_id').attr('id', 'ScheduleItem' + index + 'ScheduleId');
  jqElement.find('input.schedule_id').val('');
  
  jqElement.find('input.item_id').attr('name', 'data[ScheduleItem][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', 'ScheduleItem' + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  
  jqElement.find('input.cabinet_id').attr('name', 'data[ScheduleItem][' + index + '][cabinet_id]');
  jqElement.find('input.cabinet_id').attr('id', 'ScheduleItem' + index + 'CabinetId');
  jqElement.find('input.cabinet_id').val('');
  
  jqElement.find('input.door_id').attr('name', 'data[ScheduleItem][' + index + '][door_id]');
  jqElement.find('input.door_id').attr('id', 'ScheduleItem' + index + 'DoorId');
  jqElement.find('input.door_id').val('');
  
  //jqElement.find('input.type').attr('name', 'data[ScheduleItem][' + index + '][type]');
  //jqElement.find('input.type').attr('id', 'ScheduleItem' + index + 'Type');
  
  jqElement.find('input.purchase_order_id').attr('name', 'data[ScheduleItem][' + index + '][purchase_order_id]');
  jqElement.find('input.purchase_order_id').attr('id', 'ScheduleItem' + index + 'PurchaseOrderId');
  jqElement.find('input.purchase_order_id').val('');
  
  jqElement.find('input.reason').attr('name', 'data[ScheduleItem][' + index + '][reason]');
  jqElement.find('input.reason').attr('id', 'ScheduleItem' + index + 'Reason');
  jqElement.find('input.reason').val('');
    
  jqElement.find('.data-code').html('');
  jqElement.find('.data-title').html('');
  jqElement.find('.data-quantity').html('');
  jqElement.find('.data-each-cost').html('');
  jqElement.find('.data-per-item-total-cost').html('');
  jqElement.find('.data-reason').html('');
  jqElement.find('.data-purchase-order-number').html('');
  
  
  jqElement.removeClass('hide');
}
