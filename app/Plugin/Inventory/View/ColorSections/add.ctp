<div class="colorSections form">
<?php echo $this->Form->create('ColorSection');?>
	<fieldset>
		<legend><?php echo __('Add Color Section'); ?></legend>
	<?php
		echo $this->Form->input('color_id');
		echo $this->Form->input('cost');
		echo $this->Form->input('markup');
		echo $this->Form->input('price');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Color Sections'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Colors'), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color'), array('controller' => 'colors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Color Materials'), array('controller' => 'color_materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color Material'), array('controller' => 'color_materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
