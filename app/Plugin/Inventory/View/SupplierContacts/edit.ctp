<div class="supplierContacts form">
<?php echo $this->Form->create('SupplierContact');?>
	<fieldset>
		<legend><?php echo __('Edit Supplier Contact'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('supplier_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('address_line_1');
		echo $this->Form->input('address_line_2');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('phone_other');
		echo $this->Form->input('zip');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SupplierContact.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SupplierContact.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Supplier Contacts'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Suppliers'), array('controller' => 'suppliers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Address Types'), array('controller' => 'address_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address Type'), array('controller' => 'address_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
