<fieldset>
  <legend <?php if ($edit) { ?>class="inner-legend"<?php } ?>><?php echo __('Edit Item Detail'); ?></legend>
  <?php
  $select_data = array();
  foreach ($this->data['ItemOption'] as $item) {
    $select_data[$item['id']] = $item['name'];
  }
  ?>
  <script type="text/javascript">

    work_order_job_title('form.item-core-form .item-option',<?php echo $this->InventoryLookup->select2_multi_json_format($this->InventoryLookup->InventoryLookup('item_option')); ?>,<?php echo $this->InventoryLookup->select2_multi_json_format($select_data); ?>);

  </script>
  <table class='table-form-big'>
    <tr>
      <th><label for="ItemMinimum">Minimum:</label></th>
      <td><?php echo $this->Form->input('minimum', array('class' => 'small-input')); ?></td>
    </tr>
    <tr>
      <th><label for="ItemMaximum">Maximum:</label></th>
      <td><?php echo $this->Form->input('maximum', array('class' => 'small-input')); ?></td>
    </tr>
    <tr>
      <th><label for="ItemItemOption">Item Option:</label></th>
      <td colspan="3">
        <?php echo $this->Form->input('ItemOption', array('type' => 'text', 'class' => 'item-option')); ?>
        <?php //echo $this->Form->input('ItemOption', array('options'=>$this->InventoryLookup->InventoryLookup('item_option'),'class' => 'multiselect')); ?>
      </td>
    </tr>
  </table>
</fieldset>