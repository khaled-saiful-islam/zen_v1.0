<div class="colorMaterials form">
<?php echo $this->Form->create('ColorMaterial');?>
	<fieldset>
		<legend><?php echo __('Add Color Material'); ?></legend>
	<?php
		echo $this->Form->input('color_id');
		echo $this->Form->input('material_id');
		echo $this->Form->input('edgetape_id');
		echo $this->Form->input('color_section_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Color Materials'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Colors'), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color'), array('controller' => 'colors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Materials'), array('controller' => 'materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Color Sections'), array('controller' => 'color_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color Section'), array('controller' => 'color_sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inventory Lookups'), array('controller' => 'inventory_lookups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inventory Lookup'), array('controller' => 'inventory_lookups', 'action' => 'add')); ?> </li>
	</ul>
</div>
