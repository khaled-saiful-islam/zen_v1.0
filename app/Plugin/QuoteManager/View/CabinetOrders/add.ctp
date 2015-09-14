<div class="cabinetOrders form">
<?php echo $this->Form->create('CabinetOrder');?>
	<fieldset>
		<legend><?php echo __('Add Cabinet Order'); ?></legend>
	<?php
		echo $this->Form->input('quote_id');
		echo $this->Form->input('door_species');
		echo $this->Form->input('door_style');
		echo $this->Form->input('stain_color');
		echo $this->Form->input('rush_order');
		echo $this->Form->input('pog');
		echo $this->Form->input('edgetape');
		echo $this->Form->input('drawers');
		echo $this->Form->input('drawer_slides');
		echo $this->Form->input('delivery');
		echo $this->Form->input('delivery_cost');
		echo $this->Form->input('extras_glass');
		echo $this->Form->input('counter_top');
		echo $this->Form->input('installation');
		echo $this->Form->input('discount');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cabinet Orders'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Quotes'), array('controller' => 'quotes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Quote'), array('controller' => 'quotes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cabinet Order Items'), array('controller' => 'cabinet_order_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cabinet Order Item'), array('controller' => 'cabinet_order_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
