<?php if ($work_order['WorkOrder']['status'] != "Approve") { ?>
  <div align="right">
    <?php echo $this->Html->link('Change Status', '#', array('class' => 'wo-status-link btn btn-success', 'title' => __('Change Status'))); ?>
    <?php
    $day = "";
    $month = "";
    $year = "";
    if (count($work_order['WorkOrderStatus']) > 0) {
      $last_date = $work_order['WorkOrderStatus'][(count($work_order['WorkOrderStatus']) - 1)]['status_date'];
      $day = date('j', strtotime($last_date));
      $month = date('m', strtotime($last_date));
      $year = date('Y', strtotime($last_date));
    }
    ?>
    <script type="text/javascript">
      set_value('<?php echo $year; ?>','<?php echo $month-1; ?>','<?php echo $day; ?>');  
      $(function(){
        $('.wo-status-date').datepicker({
          beforeShow: customRange,  
          dateFormat: 'dd/mm/yy'
        });
      });
    </script>
  </div>
<?php } ?>
<?php if ($work_order['WorkOrder']['status'] == "Approve") { ?>
  <script type="text/javascript">    
    $(function(){
      $('#work-order-po-list div.actions').hide();
      $('#work-order-po-list table tr td.actions a').hide();
    });
  </script>
<?php } ?>
<div id="wo_status_div" style="display: none; margin-bottom: 40px;">
  <?php echo $this->Form->create('WorkOrder', array('url' => array('action' => 'edit', $work_order['WorkOrder']['id'], 'status'), 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'work-order-status-form ajax-form-submit')); ?>
  <table class="table-form-big">
    <tbody>       
      <tr>
        <th>
          <label for="">Status:</label>
        </th>
        <td>
          <?php echo $this->Form->input('WorkOrderStatus.status', array('placeholder' => 'Status', 'class' => 'required form-select wo-status-option', 'empty' => false ,'options' => array('Review' => 'Review', 'Change' => 'Change', 'Approve' => 'Approve', 'Cancel' => 'Cancel'))); ?>
          <?php echo $this->Form->input('WorkOrderStatus.user_id', array('type' => 'hidden', 'value' => $user_id)); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label for="">Status Date:</label>
        </th>
        <td>
          <?php echo $this->Form->input('WorkOrderStatus.status_date', array('type' => 'text', 'placeholder' => 'Status Date', 'class' => 'wo-status-date')); ?>
        </td>
      </tr> 
      <tr>
        <th>
          <label for="">Comment:</label>
        </th>
        <td>
          <?php echo $this->Form->input('WorkOrderStatus.comment', array('placeholder' => 'Comment', 'class' => 'required', 'cols' => '80', 'rows' => '3')); ?>
        </td>
      </tr>        
    </tbody>
  </table>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>

  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', '#', array('class' => 'wo-status-link-cancel btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
  </div>

  <?php echo $this->Form->end(); ?>
</div>
<fieldset style="clear: both; margin-top: 15px;">
  <?php if ($work_order['WorkOrderStatus']) { ?>
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
//            debug($workOrder_status);
        arsort($workOrder_status);
        foreach ($workOrder_status as $item):
          ?>
          <tr>
            <td><?php echo h($item['WorkOrderStatus']['status']); ?>&nbsp;</td>
            <td><?php echo h($this->Util->formatDate($item['WorkOrderStatus']['status_date'])); ?>&nbsp;</td>
            <td><?php echo h($item['WorkOrderStatus']['comments']); ?>&nbsp;</td>
            <td><?php echo h($item['User']['first_name']); ?>&nbsp;<?php echo h($item['User']['last_name']); ?></td>            
            <td><?php echo h($this->Util->formatDate($item['WorkOrderStatus']['created'])); ?>&nbsp;</td>
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
  
  $(".work-order-status-form").validate({ignore: null});
  $(".work-order-status-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#work-order-status-detail'});
  
  
</script>