<?php if ($installerSchedule['InstallerSchedule']['status'] != "Installed") { ?>
  <?php if ($edit) { ?>
    <div class="detail actions">
      <?php echo $this->Html->link('Change Status', '#', array('class' => 'installer-schedule-status-link btn btn-success', 'title' => __('Change Status'))); ?>
    </div>
  <?php } ?>
  <?php
  $day = "";
  $month = "";
  $year = "";
  if (count($installerSchedule['ScheduleStatus']) > 0) {
    $last_date = $installerSchedule['ScheduleStatus'][(count($installerSchedule['ScheduleStatus']) - 1)]['status_date'];
    $day = date('j', strtotime($last_date));
    $month = date('m', strtotime($last_date));
    $year = date('Y', strtotime($last_date));
  }
  ?>
  <script type="text/javascript">
    set_value('<?php echo $year; ?>','<?php echo $month-1; ?>','<?php echo $day+1; ?>');  
    $(function(){
      $('.installer-schedule-status-date').datepicker({
        beforeShow: customRange,  
        dateFormat: 'dd/mm/yy'
      });
    });
  </script>
  <?php
}
?>
<?php if ($installerSchedule['InstallerSchedule']['status'] == "Installed") { ?>
<script type="text/javascript">    
    $(function(){
      $('#installer-schedule-status-detail div.actions').hide();
      $('#installer-schedule-basic-detail div.actions').hide();
    });
  </script>
<?php } ?>
  
<div id="installer_schedule_status_div" style="display: none; margin-bottom: 40px;">
  <?php echo $this->Form->create('InstallerSchedule', array('url' => array('action' => 'edit', $installerSchedule['InstallerSchedule']['id'], 'status'), 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'installer-schedule-status-form ajax-form-submit')); ?>
  <table class="table-form-big">
    <tbody>       
      <tr>
        <th>
          <label for="">Status:</label>
        </th>
        <td>
          <?php echo $this->Form->input('ScheduleStatus.status', array('placeholder' => 'Status', 'class' => 'required form-select installer-schedule-status-option', 'options' => array('Review' => 'Review', 'Change' => 'Change', 'Installed' => 'Installed'))); ?>
          <?php echo $this->Form->input('ScheduleStatus.user_id', array('type' => 'hidden', 'value' => $user_id)); ?>
          <?php echo $this->Form->input('ScheduleStatus.type', array('type' => 'hidden', 'value' => 'Installer Schedule')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label for="">Status Date:</label>
        </th>
        <td>
          <?php echo $this->Form->input('ScheduleStatus.status_date', array('type' => 'text', 'placeholder' => 'Status Date', 'class' => 'required installer-schedule-status-date')); ?>
        </td>
      </tr> 
      <tr>
        <th>
          <label for="">Comment:</label>
        </th>
        <td>
          <?php echo $this->Form->input('ScheduleStatus.comment', array('placeholder' => 'Comment', 'class' => 'required', 'cols' => '80', 'rows' => '3')); ?>
        </td>
      </tr>        
    </tbody>
  </table>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>

  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', '#', array('class' => 'installer-schedule-status-link-cancel btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
  </div>

  <?php echo $this->Form->end(); ?>
</div> 

<fieldset>
  <?php if ($schedule_status) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th>Status</th>
          <th>Status Date</th>
          <th>Comments</th>
          <th>Posted&nbsp;By</th>          
          <th>Posted&nbsp;Date</th>
        </tr>
      </thead>
      <tbody> 
        <?php
        arsort($schedule_status);
        foreach ($schedule_status as $item):
          ?>
          <tr>
            <td><?php echo h($item['ScheduleStatus']['status']); ?>&nbsp;</td>
            <td><?php echo h($this->Util->formatDate($item['ScheduleStatus']['status_date'])); ?>&nbsp;</td>
            <td><?php echo h($item['ScheduleStatus']['comments']); ?>&nbsp;</td>
            <td><?php echo h($item['User']['first_name'].' '.$item['User']['last_name']); ?>&nbsp;</td>
            <td><?php echo h($this->Util->formatDate($item['ScheduleStatus']['created'])); ?>&nbsp;</td>
          </tr>
        <?php endforeach; ?>        
      </tbody>
    </table>
  <?php }else { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th>Status</th>
          <th>Status Date</th>
          <th>Comments</th>
          <th>Posted&nbsp;By</th>          
          <th>Posted&nbsp;Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>  
  <?php } ?>
</fieldset>
<script type="text/javascript">
  
  $(".installer-schedule-status-form").validate({ignore: null});
  $(".installer-schedule-status-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#installer-schedule-status-detail'});
  
  
</script>
