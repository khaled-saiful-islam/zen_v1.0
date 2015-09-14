<fieldset>
  <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>><?php echo $legend; ?></legend>
  <div class="work-order form">
    <?php echo $this->Form->create('WorkOrder', array('inputDefaults' => array('div' => false, 'label' => false), 'class' => 'work-order-form')); ?>
    <script type="text/javascript">

      work_order_job_title('form.work-order-form .job-title',<?php echo $this->InventoryLookup->select2_multi_json_format($quote_info); ?>);

    </script>
    <table class="table-form-big">
      <tbody>
        <tr>
          <th>
            <label for="WorkOrderQuoteId">Job Title:</label>
          </th>
          <td>
            <?php echo $this->Form->input('quote_id', array('type' => 'text', 'class' => 'job-title required')); ?>
            <?php echo $this->Form->input('work_order_number', array('type'=>'hidden')); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="align-left align-top-margin">
      <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
    </div>
    <?php if (!$edit) { ?>
      <div class="align-left align-top-margin">
        <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
      </div>
    <?php } else { ?>
      <div class="align-left align-top-margin">
        <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
      </div>
    <?php } ?>
    <?php echo $this->Form->end(); ?>
  </div>

</fieldset>
<script type="text/javascript">

  work_order_job_title('form.work-order-form .job-title',<?php echo $this->InventoryLookup->select2_multi_json_format($quote_info); ?>);

  $(".work-order-form").validate({ignore: null});
<?php if ($edit && !empty($section)) { // do ajax if edit              ?>
    $(".work-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
<?php } ?>

</script>