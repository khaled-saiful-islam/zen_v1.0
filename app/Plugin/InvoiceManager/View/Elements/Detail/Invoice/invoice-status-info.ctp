<?php 
//debug($invoice);
if ($invoice['Invoice']['invoice_status_id'] != 2) { ?>
  <div align="right">
    <?php if($edit) echo $this->Html->link('Change Status', '#', array('class' => 'invoice-status-link btn btn-success', 'title' => __('Change Status'))); ?>
    <?php
    $day = "";
    $month = "";
    $year = "";
    if (count($status_log) > 0) {
      $last_date = $status_log[(count($status_log) - 1)]['InvoiceLog']['status_date'];
      $day = date('j', strtotime($last_date));
      $month = date('m', strtotime($last_date));
      $year = date('Y', strtotime($last_date));
    }
    ?>
    <script type="text/javascript">
      set_value('<?php echo $year; ?>','<?php echo $month-1; ?>','<?php echo $day; ?>');  
      $(function(){
        $('.invoice-status-date').datepicker({
          beforeShow: customRange,  
          dateFormat: 'dd/mm/yy'
        });
      });
    </script>
  </div>
<?php } ?>

<?php if ($invoice['Invoice']['invoice_status_id'] == 2) { ?>
  <script type="text/javascript">
    $(function(){
//      $('.invoices div.report-buttons a.icon-print').hide();
      $('#invoice_status .btn-success').hide();
    });
  </script>
<?php } ?>

<div id="invoice_status_div" style="display: none; margin-bottom: 40px;">
  <?php echo $this->Form->create('InvoiceLog', array('url' => array('controller'=>'invoices','action' => 'edit', $invoice['Invoice']['id'], 'status'), 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'invoice-status-form ajax-form-submit')); ?>
  <table class="table-form-big">
    <tbody>       
      <tr>
        <th>
          <label for="">Status:</label>
        </th>
        <td>
          <?php echo $this->Form->input('InvoiceLog.invoice_status_id', array('placeholder' => 'Status', 'class' => 'required form-select invoice-status-option', 'options' => $status_list)); ?>
          
        </td>
      </tr>
      <tr>
        <th>
          <label for="">Status Date:</label>
        </th>
        <td>
          <?php echo $this->Form->input('InvoiceLog.status_date', array('type' => 'text', 'placeholder' => 'Status Date', 'class' => 'invoice-status-date')); ?>
        </td>
      </tr> 
      <tr>
        <th>
          <label for="">Comment:</label>
        </th>
        <td>
          <?php echo $this->Form->input('InvoiceLog.comments', array('placeholder' => 'Comment', 'class' => 'required', 'cols' => '80', 'rows' => '3')); ?>
        </td>
      </tr>        
    </tbody>
  </table>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>

  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', '#', array('class' => 'invoice-status-link-cancel btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
  </div>

  <?php echo $this->Form->end(); ?>
</div>
<fieldset style="clear: both; margin-top: 15px;">
  <?php if ($status_log) { ?>
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
        arsort($status_log);
        foreach ($status_log as $item):
          ?>
          <tr>
            <td><?php echo h($item['InvoiceStatus']['name']); ?>&nbsp;</td>
            <td><?php echo h($this->Util->formatDate($item['InvoiceLog']['status_date'])); ?>&nbsp;</td>
            <td><?php echo h($item['InvoiceLog']['comments']); ?>&nbsp;</td>
            <td><?php echo h($item['User']['first_name']); ?>&nbsp;<?php echo h($item['User']['last_name']); ?></td>            
            <td><?php echo h($this->Util->formatDate($item['InvoiceLog']['created'])); ?>&nbsp;</td>
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
  
  $(".invoice-status-form").validate({ignore: null});
  $(".invoice-status-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#invoice_status'});
  
  
</script>