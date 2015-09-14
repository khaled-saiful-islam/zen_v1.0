<div class="appointments calendar">
  <script type="text/javascript" >
    
//    calendar_all_event_data = <?php //echo json_encode($calendarData); ?>;  
    calendar_all_event_data = '<?php
      echo $this->Util->getURL(array(
          'controller' => "appointments",
          'action' => 'calendar_data',
          'plugin' => 'schedule_manager',
      ));
      ?>';
    
  </script>
  <div class="calendar-left">
    <ul>
      <li>
        <span class="instal-color"></span> 
        <span class="text">Installation</span> 
      </li>
      <li>
        <span class="service-color"></span> 
        <span class="text">Service</span> 
      </li>
      <li>
        <span class="appo-color"></span> 
        <span class="text">Appointment</span> 
      </li>
    </ul>
  </div>  
  <div class="clear"></div>
  <div class="calendar-right">
    <div id="full_calender">

    </div>
  </div>  

</div>
<script type="text/javascript" >
  
  all_schedule_calendar();
  
  $('.fc-button-next span').click(function(){

  });
  $('.fc-button-prev span').click(function(){

  });


  
  
</script>