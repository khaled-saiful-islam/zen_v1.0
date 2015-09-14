<?php
//debug($schedule_status);
//if ($service['ServiceEntry']['status'] != "Completed") {
?>
<?php if ($edit) { ?>
<div class="detail actions">
  <?php echo $this->Html->link('Change Status', '#', array('class' => 'quote-status-link btn btn-success', 'title' => __('Change Status'))); ?>
</div>
<?php } ?>
<?php
$day = "";
$month = "";
$year = "";
if (count($service['ScheduleStatus']) > 0) {
  $last_date = $service['ScheduleStatus'][(count($service['ScheduleStatus']) - 1)]['status_date'];
  $day = date('j', strtotime($last_date));
  $month = date('m', strtotime($last_date));
  $year = date('Y', strtotime($last_date));
}
?>
<script type="text/javascript">
  set_value('<?php echo $year; ?>','<?php echo $month - 1; ?>','<?php echo $day + 1; ?>');  
  $(function(){
    $('.quote-status-date').datepicker({
      beforeShow: customRange,  
      dateFormat: 'dd/mm/yy'
    });
  });
</script>
<?php
//}
?>
<?php //if ($service['ServiceEntry']['status'] == "Completed") {  ?>
<script type="text/javascript">    
  $(function(){
    //$('#quote-counter-top-detail div.actions').hide();
    //$('#quote-extra-hardware-detail div.actions').hide();
    //$('#quote-glass-doors-shelf-detail div.actions').hide();
    //$('#quote-installer-paysheet-detail div.actions').hide();
    //$('#quote-basic-info-detail .btn-success').hide();
  });
</script>
<?php //}  ?>

<div id="quote_status_div" style="display: none; margin-bottom: 40px;">
  <?php echo $this->Form->create('ServiceEntry', array('url' => array('action' => 'edit', $service['ServiceEntry']['id'], 'status'), 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'quote-status-form ajax-form-submit')); ?>
  <table class="table-form-big">
    <tbody>       
      <tr>
        <th>
          <label for="">Status:</label>
        </th>
        <td>
          <?php echo $this->Form->input('ScheduleStatus.status', array('placeholder' => 'Status', 'class' => 'required form-select quote-status-option', 'options' => array('Review' => 'Review', 'Completed' => 'Completed', 'Signoff' => 'Signoff'))); ?>
          <?php echo $this->Form->input('ScheduleStatus.user_id', array('type' => 'hidden', 'value' => $user_id)); ?>
          <?php echo $this->Form->input('ScheduleStatus.type', array('type' => 'hidden', 'value' => 'Service')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label for="">Status Date:</label>
        </th>
        <td>
          <?php echo $this->Form->input('ScheduleStatus.status_date', array('type' => 'text', 'placeholder' => 'Status Date', 'class' => 'quote-status-date')); ?>
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
    <?php echo $this->Html->link('Cancel', '#', array('class' => 'quote-status-link-cancel btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
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
  
  $(".quote-status-form").validate({ignore: null});
  $(".quote-status-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#service-status-info'});
  
  
</script>
