<div class="invoices form">
<?php echo $this->Form->create('Invoice');?>
	<fieldset>
		<legend><?php echo __('Edit Invoice'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('invoice_no');
		echo $this->Form->input('invoice_of');
		echo $this->Form->input('ref_id');
		echo $this->Form->input('data_set');
		echo $this->Form->input('total');
		echo $this->Form->input('invoice_statuses_id');
		echo $this->Form->input('created_by');
		echo $this->Form->input('modified_by');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Invoice.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Invoice.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Invoice Statuses'), array('controller' => 'invoice_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Statuses'), array('controller' => 'invoice_statuses', 'action' => 'add')); ?> </li>
	</ul>
</div>
