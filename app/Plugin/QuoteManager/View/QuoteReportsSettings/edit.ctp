<div class="quoteReportsSettings form">
  <?php echo $this->Form->create('QuoteReportsSetting'); ?>
  <fieldset>
    <legend><?php echo __('Edit Quote Reports Setting'); ?></legend>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('report_name', array('readonly' => true));
    $department = unserialize($this->request->data['QuoteReportsSetting']['departments']);
    echo $this->Form->input('departments', array('type' => 'select', 'class' => 'form-select wide-input', 'multiple' => true, 'options' => $this->InventoryLookup->ItemDepartment(), 'value' => $department));
    ?>
  </fieldset>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', array('action' => DETAIL, $id), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>