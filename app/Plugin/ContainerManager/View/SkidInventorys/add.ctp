<?php echo $this->Form->create('SkidInventory', array('url' => array('controller' => 'skid_inventorys', 'action' => 'add'),'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'skid-form')); ?>

<?php echo $this->element('Forms/SkidInventory/skid-form', array('legend' => 'Add Skid Inventory', 'edit' => false)); ?>

<?php echo $this->Form->end(); ?>