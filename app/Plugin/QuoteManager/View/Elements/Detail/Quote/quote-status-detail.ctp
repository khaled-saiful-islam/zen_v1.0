<?php if ($quote['Quote']['status'] != "Approve") { ?>
  <?php if ($edit) { ?>
    <div class="detail actions">
      <?php echo $this->Html->link('Change Status', '#', array('class' => 'quote-status-link btn btn-success', 'title' => __('Change Status'))); ?>
    </div>
  <?php } ?>
  <?php
  $day = "";
  $month = "";
  $year = "";
  if (count($quote['QuoteStatus']) > 0) {
    $last_date = $quote['QuoteStatus'][(count($quote['QuoteStatus']) - 1)]['status_date'];
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
}
?>
<?php if ($quote['Quote']['status'] == "Approve") { ?>
  <script type="text/javascript">
    $(function(){
      $('#quote-counter-top-detail div.actions').hide();
      $('#quote-extra-hardware-detail div.actions').hide();
      $('#quote-glass-doors-shelf-detail div.actions').hide();
      $('#quote-installer-paysheet-detail div.actions').hide();
      $('#quote-basic-info-detail .btn-success').hide();
    });
  </script>
<?php } ?>

<div id="quote_status_div" style="display: none; margin-bottom: 40px;">
  <?php echo $this->Form->create('Quote', array('url' => array('action' => 'edit', $quote['Quote']['id'], 'status'), 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'quote-status-form ajax-form-submit')); ?>
  <table class="table-form-big">
    <tbody>
      <tr>
        <th>
          <label for="">Status:</label>
        </th>
        <td>
          <?php echo $this->Form->input('QuoteStatus.status', array('placeholder' => 'Status', 'class' => 'required form-select quote-status-option', 'options' => array('On Progress'=>'On Progress','Review' => 'Review', 'Change' => 'Change', 'Approve' => 'Approve', 'Cancel' => 'Cancel'))); ?>
          <?php echo $this->Form->input('QuoteStatus.user_id', array('type' => 'hidden', 'value' => $user_id)); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label for="">Status Date:</label>
        </th>
        <td>
          <?php echo $this->Form->input('QuoteStatus.status_date', array('type' => 'text', 'placeholder' => 'Status Date', 'class' => 'quote-status-date')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label for="">Comment:</label>
        </th>
        <td>
          <?php echo $this->Form->input('QuoteStatus.comment', array('placeholder' => 'Comment', 'class' => 'required', 'cols' => '80', 'rows' => '3')); ?>
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
  <?php if ($quote['QuoteStatus']) { ?>
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
        arsort($quote_status);
        //debug($quote_status);
        foreach ($quote_status as $item):
          ?>
          <tr>
            <td><?php echo h($item['QuoteStatus']['status']); ?>&nbsp;</td>
            <td>
              <?php
              /**
               * show the link if and only if it is in editable view mode
               * otherwise just show the date as text only
               */
//              debug($item['QuoteStatus']);
              if (!is_null($item['QuoteStatus']['quote_vid']) && $edit) {
                echo $this->Html->link(
                        h($this->Util->formatDate($item['QuoteStatus']['status_date'])), array('controller' => 'quotes', 'action' => 'print_detail', $item['QuoteStatus']['quote_vid']), array('class' => 'open-link table-first-column-color', 'data_target' => 'quote_log')
                );
              } else {
                echo h($this->Util->formatDate($item['QuoteStatus']['status_date']));
              }
              ?>
              &nbsp;
            </td>
            <td><?php echo h($item['QuoteStatus']['comments']); ?>&nbsp;</td>
            <td><?php echo h($item['User']['first_name'].' '.$item['User']['last_name']); ?>&nbsp;</td>
            <td><?php echo h($this->Util->formatDate($item['QuoteStatus']['created'])); ?>&nbsp;</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php } else { ?>
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
  $(".quote-status-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#quote-status-detail'});
</script>
