<?php echo $this->Form->create('SkidInventory', array('url' => array('controller' => 'skid_inventorys', 'action' => 'edit', $skidinventory['SkidInventory']['id']),'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'container-form')); ?>

<?php
	if(isset($skidinventory['SkidInventory']['id'])){
		echo $this->Form->hidden('id', array('value' => $skidinventory['SkidInventory']['id']));
	}
?>
<?php echo $this->element('Forms/SkidInventory/skid-form', array('legend' => 'Edit Skid Inventory', 'edit' => false)); ?>

<?php echo $this->Form->end(); ?>