<?php
	$app = $this->InventoryLookup->getScheduleColor('Appointment');
	$ser = $this->InventoryLookup->getScheduleColor('Service');
	$ins = $this->InventoryLookup->getScheduleColor('Installation');
?>
<div class="appointments index">
	<div class="calendar-left">
    <ul>
      <li>
        <span style="background-color:<?php echo "#" . $ins; ?>" class="instal-color"></span> 
        <span class="text">Installation</span> 
      </li>
      <li>
        <span style="background-color:<?php echo "#" . $ser; ?>" class="service-color"></span> 
        <span class="text">Service</span> 
      </li>
      <li>
        <span style="background-color:<?php echo "#" . $app; ?>" class="appo-color"></span> 
        <span class="text">Appointment</span> 
      </li>
    </ul>
  </div> 
	
  <script type="text/javascript" >
    //    app_all_data = <?php echo json_encode($appointment); ?>;    
    //    app_even_data = <?php // echo json_encode($this->InventoryLookup->fullCalenderJsonFormate($appointment));    ?>;    
    app_even_data = '<?php
  echo $this->Util->getURL(array(
      'controller' => "appointments",
      'action' => 'calendar_data',
      'plugin' => 'schedule_manager',
  ));
  ?>';    
    
    app_all_data = '<?php
  echo $this->Util->getURL(array(
      'controller' => "appointments",
      'action' => 'appointment_event_data',
      'plugin' => 'schedule_manager',
  ));
  ?>';    
    
  </script>
  <div id="appointment"></div>
</div>
<div id="add_appointment" class="modal hide fade modal-width" data-keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="add_label">Add Appointment</h3>
  </div>
  <div class="modal-body">
    <?php //echo $this->Form->create('Appointment', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'appointment-form')); ?>
    <form>
      <table class="table-form-big">
        <tr>
          <th>
            <label>
              Job Number:
            </label>
          </th>
          <td colspan="3">
            <?php
            $defaultWorkOrders = 0;
            foreach ($workOrders as $key => $value) {
              $defaultWorkOrders = $key;
              break;
            }
            echo $this->Form->input('Appointment.work_order_id', array('empty' => true,'label' => false, 'div' => false, 'placeholder' => 'Job Number', 'options' => $workOrders, 'class' => 'required work-order-id'));
            ?>
            <?php echo $this->Form->input('Appointment.created_by', array('type' => 'hidden', 'value' => $user_id)); ?>
            <?php echo $this->Form->input('Appointment.start_date', array('type' => 'hidden', 'class' => 'start-date')); ?>
            <?php echo $this->Form->input('Appointment.end_date', array('type' => 'hidden', 'class' => 'end-date')); ?>
            <?php echo $this->Form->input('Appointment.id', array('type' => 'hidden', 'class' => 'app-id')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label>Address:</label>
          </th>
          <td colspan="3" class="">
            <?php echo $this->Form->input('Appointment.address', array('label' => false, 'div' => false, 'placeholder' => 'Address', 'class' => 'form-select address wide-input')); ?>
          </td>
        </tr>
        <tr>
          <th>
            &nbsp;
          </th>
          <td>
            <?php echo $this->Form->input('Appointment.city', array('label' => false, 'div' => false, 'placeholder' => 'City', 'class' => 'form-select city')); ?>
          </td>
          <td colspan="2">            
            <?php echo $this->Form->input('Appointment.province', array('label' => false, 'div' => false, 'options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select province', 'style' => 'width:120px;')); ?>
          </td>
        </tr>
        <tr>
          <th>
            &nbsp;
          </th>
          <td>
            <?php echo $this->Form->input('Appointment.postal_code', array('label' => false, 'div' => false, 'placeholder' => 'Postal Code', 'class' => 'form-select postal-code')); ?>
          </td>
          <td colspan="2">
            <?php echo $this->Form->input('Appointment.country', array('label' => false, 'div' => false, 'value' => 'Canada', 'readonly' => 'readonly', 'class' => 'country')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label>Service Tech:</label>
          </th>
          <td colspan="3">
            <?php echo $this->Form->input('Appointment.service_tech_id', array('label' => false, 'div' => false, 'placeholder' => 'Service Tech', 'options' => $this->InventoryLookup->InventoryLookup('service_techs'), 'class' => 'required form-select service-tech-id')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label>Booking on:</label>
          </th>
          <td>
            <?php echo $this->Form->input('Appointment.booking_on', array('label' => false, 'div' => false, 'type' => 'text', 'placeholder' => 'Booking on', 'class' => 'booking-on')); ?>
          </td>
          <td style="width: 8px;">
            at
          </td>
          <td>
            <?php echo $this->Form->input('Appointment.booking_on_time', array('label' => false, 'div' => false, 'type' => 'text', 'placeholder' => 'Start Time', 'class' => 'booking-on-time')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label>How Long:(00:00)</label>
          </th>
          <td>
            <?php echo $this->Form->input('Appointment.hours', array('label' => false, 'div' => false, 'placeholder' => 'Hours', 'class' => 'hours')); ?>
          </td>
          <td colspan="2">
            hrs
          </td>
        </tr>
      </table>
    </form>
  </div>
  <div class="modal-footer">
    <button class="save btn btn-primary">Add</button>
  </div>
</div>
<script type="text/javascript" >
  
	$(document).ready(function() {
		$("#AppointmentWorkOrderId").select2({
				placeholder: "--Please Slect--"
		});
				
		$('#AppointmentWorkOrderId').change(function() {
      var wo_id = $('select#AppointmentWorkOrderId').val();

      $.ajax({
        url: '<?php
					echo $this->Util->getURL(array(
							'controller' => "appointments",
							'action' => 'getWOAddress',
							'plugin' => 'schedule_manager',
					))
					?>/'+wo_id,
									type: 'POST',
									data: '',
									dataType: "json",
									success: function( response ) {
										$("#AppointmentAddress").val(response.Quote.address);
										$("#AppointmentCity").val(response.Quote.city);
										$("#AppointmentProvince").val(response.Quote.province);
										$("#AppointmentPostalCode").val(response.Quote.postal_code);
										$("#AppointmentCountry").val(response.Quote.country);
									}
					});
			});
		
	 });
  appointment_calendar();
  
  $(".booking-on").datepicker({
    dateFormat:"DD, MM d,yy"
  });
  $(".booking-on-time").timepicker({
    timeFormat: "hh:mm tt"
  });
	$(".hours").timepicker({
  }); 
  
  function ajax_call_resize_data(id,start_date,end_date,event_type){
    //console.log(id);
    //console.log(end_date);
    $.ajax({
      url: '<?php
            echo $this->Util->getURL(array(
                'controller' => "appointments",
                'action' => 'edit',
                'plugin' => 'schedule_manager',
            ))
            ?>/'+id,
                  type: 'POST',
                  data: {start_date:start_date,end_date:end_date,'event_type':event_type},
                  dataType: "json",
                  success: function( response ) {
                    //console.log(response); 
                    if(response.Error==""){
                      $('#appointment').fullCalendar('removeEvents',response[0]['id']);
                      $('#appointment').fullCalendar('renderEvent',
                      {
                        id: response[0]['id'],
                        title: response[0]['work_order_number'],
                        start: response[0]['start_date'],
                        end: response[0]['end_date'],
                        description: response[0]['description'],
                        allDay: false
                      },
                      false // make the event "stick"
                      ); 
                        $('.qtip').remove();
                    }                      
                  }
                });	
              }  
              $('#add_appointment .save').live('click',function(e) {
                if($("#add_appointment form").valid()){
                  
                  $.ajax({
                    url: '<?php
            echo $this->Util->getURL(array(
                'controller' => "appointments",
                'action' => 'add',
                'plugin' => 'schedule_manager',
            ))
            ?>/',
                    type: 'POST',
                    data: $("#add_appointment form").serializeArray(),
                    dataType: "json",
                    success: function( response ) {
                                            console.log(response); 
                      if(response.Error==""){
                        $('#add_appointment').modal('hide');
                        //                        job_number = job_number = response[0]['Appointment']['work_order_number'];
                        //                        job_name = response[0]['Appointment']['job_name'];
                        $('#appointment').fullCalendar('renderEvent',
                        {
                          id: response[0]['id'],
                          title: response[0]['work_order_number'],
                          start: response[0]['start_date'],
                          end: response[0]['end_date'],
                          description: response[0]['description'],
													color: response[0]['color'],
                          allDay: false
                        },
                        false // make the event "stick"
                      );    
                        
                        //$('#appointment').fullCalendar('unselect');
                        $('#add_appointment form')[0].reset();
                      }
                    }
                  });	
                }
              }); 

              $('#add_appointment .update').live('click',function() {
                if($("#add_appointment form").valid()){
	
                  $.ajax({
                    url: '<?php
            echo $this->Util->getURL(array(
                'controller' => "appointments",
                'action' => 'edit',
                'plugin' => 'schedule_manager',
            ))
            ?>/'+app_event_id,
                    type: 'POST',
                    data: $("#add_appointment form").serializeArray(),
                    dataType: "json",
                    success: function( response ) {
                      
                      //console.log(response); 
                      if(response.Error==""){
                        $('#add_appointment').modal('hide');
                        //                        job_number = response[0]['Appointment']['work_order_number'];
                        //                        job_name = response[0]['Appointment']['job_name'];
                        $('#appointment').fullCalendar('removeEvents',app_event_id);
                        
                        $('#appointment').fullCalendar('renderEvent',
                        {
                          id: response[0]['id'],
                          title: response[0]['work_order_number'],
                          start: response[0]['start_date'],
                          end: response[0]['end_date'],
                          description: response[0]['description'],
                          allDay: false
                        },
                        false // make the event "stick"
                      );  
                        //$('#appointment').fullCalendar( 'refetchEvents' )
                        
                        //$('#appointment').fullCalendar('unselect');
                        $('#add_appointment form')[0].reset();
                        $('#add_appointment button.update').addClass('save');
                        $('#add_appointment button.save').text('Add');
                        $('#add_appointment button.save').removeClass('update');
                        $('#add_appointment button.delete').remove();
                      }
                    }
                  });	
                }
              }); 
              
              $('#add_appointment .close').live('click',function(){
                
                $('#appointment').fullCalendar('unselect');
                $('#add_appointment form')[0].reset();
                $('#add_appointment .modal-footer button.update').addClass('save');
                $('#add_appointment .modal-footer button.save').text('Add');
                $('#add_appointment .modal-footer button.save').removeClass('update');
                $('#add_appointment .modal-footer button.delete').remove();
              });
              
              $('#add_appointment .delete').live('click',function() {	
                $.ajax({
                  url: '<?php
            echo $this->Util->getURL(array(
                'controller' => "appointments",
                'action' => 'delete',
                'plugin' => 'schedule_manager',
            ))
            ?>/'+app_event_id,
                  type: 'POST',
                  data: $("#add_appointment form").serializeArray(),
                  dataType: "json",
                  success: function( response ) {
                    //console.log(response);
                    
                    if(response.Error==""){
                      $('#add_appointment').modal('hide');
                      $('#appointment').fullCalendar('removeEvents',app_event_id);
          
                      $('#appointment').fullCalendar('unselect');
                      $('#add_appointment form')[0].reset();
                      $('#add_appointment .modal-footer button.update').addClass('save');
                      $('#add_appointment .modal-footer button.save').text('Add');
                      $('#add_appointment .modal-footer button.save').removeClass('update');
                      $('#add_appointment .modal-footer button.delete').remove();
                    }
                  }
                });	
              }); 
  
              
</script>