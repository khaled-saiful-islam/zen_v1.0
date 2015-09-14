<div class="colorMaterials view">
<h2><?php  echo __('Color Material');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($colorMaterial['ColorMaterial']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color'); ?></dt>
		<dd>
			<?php echo $this->Html->link($colorMaterial['Color']['name'], array('controller' => 'colors', 'action' => 'view', $colorMaterial['Color']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Material'); ?></dt>
		<dd>
			<?php echo $this->Html->link($colorMaterial['Material']['name'], array('controller' => 'materials', 'action' => 'view', $colorMaterial['Material']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inventory Lookup'); ?></dt>
		<dd>
			<?php echo $this->Html->link($colorMaterial['InventoryLookup']['name'], array('controller' => 'inventory_lookups', 'action' => 'view', $colorMaterial['InventoryLookup']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color Section'); ?></dt>
		<dd>
			<?php echo $this->Html->link($colorMaterial['ColorSection']['id'], array('controller' => 'color_sections', 'action' => 'view', $colorMaterial['ColorSection']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($colorMaterial['ColorMaterial']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($colorMaterial['ColorMaterial']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Color Material'), array('action' => 'edit', $colorMaterial['ColorMaterial']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Color Material'), array('action' => 'delete', $colorMaterial['ColorMaterial']['id']), null, __('Are you sure you want to delete # %s?', $colorMaterial['ColorMaterial']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Color Materials'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color Material'), array('action' => 'add')); ?> </li>
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
