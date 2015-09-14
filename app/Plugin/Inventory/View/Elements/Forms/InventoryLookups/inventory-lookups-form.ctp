<div class="inventoryLookups form">
  <?php echo $this->Form->create('InventoryLookup', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'inventory-lookup-form ajax-form-submit')); ?>
  <fieldset>
    <legend <?php if ($edit) { ?>class="inner-legend" <?php } ?>><?php echo __($legend); ?></legend>
    <table class='table-form-big'>

      <?php if (!$type_config['name']['hidden']) { ?>
        <tr>
          <th><label for="InventoryLookupLookupType"><?php echo isset($type_config['name']['label']) ? h($type_config['name']['label']) : 'Name' ?>:</label></th>
          <td ><?php echo $this->Form->input('name', array('class' => 'wide-input')); ?></td>
        </tr>
      <?php } ?>

      <?php if (!$type_config['value']['hidden']) { ?>
        <tr>
          <th><label for="InventoryLookupLookupType"><?php echo isset($type_config['value']['label']) ? h($type_config['value']['label']) : 'Value' ?>:</label></th>
          <td ><?php echo $this->Form->input('value', array('class' => 'wide-input')); ?></td>
        </tr>
      <?php } ?>

      <?php if (!$type_config['price']['hidden']) { ?>
        <tr>
          <th><label for="InventoryLookupLookupType"><?php echo isset($type_config['price']['label']) ? h($type_config['price']['label']) : 'Price' ?>:</label></th>
          <td ><?php echo $this->Form->input('price', array('class' => 'wide-input')); ?></td>
        </tr>
      <?php } ?>

      <?php if (!$type_config['price_unit']['hidden']) { ?>
        <tr>
          <th><label for="InventoryLookupLookupType"><?php echo isset($type_config['price_unit']['label']) ? h($type_config['price_unit']['label']) : 'Price Unit' ?>:</label></th>
          <td ><?php echo $this->Form->input('price_unit', array('class' => 'form-select wide-input', 'empty' => true, 'options' => array('each' => 'Each', 'sqft' => 'SQFT'))); ?></td>
        </tr>
      <?php } ?>

      <?php if (!$type_config['parent_lookup']['hidden']) { ?>
        <tr>
          <th><label for="InventoryLookupLookupType"><?php echo isset($type_config['parent_lookup']['label']) ? h($type_config['parent_lookup']['label']) : 'Parent Setting' ?>:</label></th>
          <td><?php echo $this->Form->input('parent_lookup', array('placeholder' => (isset($type_config['parent_lookup']['label']) ? h($type_config['parent_lookup']['label']) : 'Parent Setting'), 'options' => $this->InventoryLookup->InventoryLookup($type_config['parent_lookup']['lookup_type'], true), 'empty' => true, 'class' => 'form-select select-parent-lookup')); ?></td>
        </tr>
      <?php } ?>

      <?php if (!$type_config['department_id']['hidden']) { ?>
        <tr>
          <th><label for="InventoryLookupLookupType"><?php echo isset($type_config['department_id']['label']) ? h($type_config['department_id']['label']) : 'Department' ?>:</label></th>
          <td><?php echo $this->Form->input('department_id', array('placeholder' => (isset($type_config['department_id']['label']) ? h($type_config['department_id']['label']) : 'Department'), 'options' => $this->InventoryLookup->ItemDepartment(), 'empty' => true, 'class' => 'form-select select-parent-lookup wide-input', 'multiple' => true)); ?></td>
        </tr>
      <?php } ?>

      <?php
      $lookup_type_hide_class = '';
      if ($type_config['lookup_type']['hidden']) {
        $lookup_type_hide_class = 'hide';
      }
      ?>
      <tr class="<?php echo $lookup_type_hide_class; ?>">
        <th><label for="InventoryLookupLookupType">Type:</label></th>
        <td><?php echo $this->Form->input('lookup_type', array('class' => 'form-select', 'options' => $this->InventoryLookup->InventoryLookupTypesStatic($type_value))); ?></td>
      </tr>
    </table>
  </fieldset>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', array('action' => 'index', $type), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".inventory-lookup-form").validate({ignore: null});
  //  $(".inventory-lookup-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
</script>