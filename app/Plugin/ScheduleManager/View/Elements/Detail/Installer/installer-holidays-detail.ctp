<div class="detail actions">
  <?php //echo $this->Html->link('Add Holidays', '#', array('class' => 'installer-link btn btn-success', 'title' => __('Add Holidays'))); ?>
</div>
<div id="installer_holidays_div" style="width: 300px; float: left;">
  <label style="font-weight: bold;">
    Holidays(Click on date to add to list)
  </label>
  <div id="installer_holidays_date">

  </div>  
  <form>
    <?php echo $this->Form->input('Holiday.type', array('type' => 'hidden', 'label' => false, 'div' => false, 'value' => 'Installer', 'class' => 'type')); ?>
    <?php echo $this->Form->input('Holiday.type_holidays_id', array('type' => 'hidden', 'label' => false, 'div' => false, 'value' => $installer['Installer']['id'], 'class' => 'type-holidays-id')); ?>
    <?php echo $this->Form->input('Holiday.holidays_date', array('type' => 'hidden', 'label' => false, 'div' => false, 'value' => '', 'class' => 'holidays-date')); ?>
    <?php echo $this->Form->input('Holiday.created_by', array('type' => 'hidden', 'label' => false, 'div' => false, 'value' => $user_id, 'class' => 'created-by')); ?>
<!--    <input name="type" type="hidden" value="Installer" class="type" />
    <input name="type_holidays_id" type="hidden" value="<?php echo $installer['Installer']['id']; ?>" class="type-holidays-id" />
    <input name="holidays_date" type="hidden" value="" class="holidays-date" />
    <input name="created_by" type="hidden" value="<?php echo $user_id; ?>" class="created-by" />-->
  </form>
</div>
<div id="holidays_date_list" >
  <?php //debug($installer); ?>
  <ul style="list-style: none;">    
    <?php
    if ($installer['Holiday']) {
      foreach ($installer['Holiday'] as $holiday) {
        ?>
        <li style="float: left;">
          <?php echo date('d F Y', strtotime($holiday['holidays_date'])); ?><a href="#" id="<?php echo$holiday['id']; ?>" class="icon-remove remove-date"></a>
        </li>
        <?php
      }
    }
    ?>
  </ul>
</div>

<script type="text/javascript" >
  
  $( "#installer_holidays_date").datepicker({
    dateFormat:"dd mm yy",    
    onSelect: function(dateText, inst) { 
      var dateAsString = dateText; //the first parameter of this function
      var dateAsObject = $(this).datepicker( 'getDate' ); //the getDate method
      dateAsObject = $.datepicker.formatDate('dd MM yy', new Date(dateAsObject))
      $("#installer_holidays_div form input.holidays-date").val(dateAsObject);
      
      $.ajax({
        url: '<?php
    echo $this->Util->getURL(array(
        'controller' => "installers",
        'action' => 'add_holidays',
        'plugin' => 'schedule_manager',
    ))
    ?>/',
            type: 'POST',
            data: $("#installer_holidays_div form").serializeArray(),
            dataType: "json",
            success: function( response ) {
              console.log(response);
              if(response.Error==""){
                content = "<li style='float: left;'>";
                date = response[0]['Holiday']['holidays_date'];
                date = $.datepicker.formatDate('dd MM yy', new Date(date));
                content += date;
                content +="<a href='#' class='icon-remove remove-date' id='"+response[0]['Holiday']['id']+"'></a></li>";
                $('#holidays_date_list ul').append(content);
              }
            }
          });
        }
      });

      $('#holidays_date_list ul li a.remove-date').live('click',function(){
      var main_elm = this;
      id = $(main_elm).attr('id');
      console.log(id);
        $.ajax({
          url: '<?php
    echo $this->Util->getURL(array(
        'controller' => "installers",
        'action' => 'delete_holidays',
        'plugin' => 'schedule_manager',
    ))
    ?>/'+id,
          type: 'POST',
          data: '',
          dataType: "json",
          success: function( response ) {
            console.log(response);
            if(response.Error==""){
              $(main_elm).parents('li').remove();
            }
          }
        });
      });

</script>
