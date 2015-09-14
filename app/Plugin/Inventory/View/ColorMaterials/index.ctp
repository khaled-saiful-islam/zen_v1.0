<div class="colorMaterials index">
	<h2><?php echo __('Color Materials');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('color_id');?></th>
			<th><?php echo $this->Paginator->sort('material_id');?></th>
			<th><?php echo $this->Paginator->sort('edgetape_id');?></th>
			<th><?php echo $this->Paginator->sort('color_section_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($colorMaterials as $colorMaterial): ?>
	<tr>
		<td><?php echo h($colorMaterial['ColorMaterial']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($colorMaterial['Color']['name'], array('controller' => 'colors', 'action' => 'view', $colorMaterial['Color']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($colorMaterial['Material']['name'], array('controller' => 'materials', 'action' => 'view', $colorMaterial['Material']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($colorMaterial['InventoryLookup']['name'], array('controller' => 'inventory_lookups', 'action' => 'view', $colorMaterial['InventoryLookup']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($colorMaterial['ColorSection']['id'], array('controller' => 'color_sections', 'action' => 'view', $colorMaterial['ColorSection']['id'])); ?>
		</td>
		<td><?php echo h($colorMaterial['ColorMaterial']['created']); ?>&nbsp;</td>
		<td><?php echo h($colorMaterial['ColorMaterial']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $colorMaterial['ColorMaterial']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $colorMaterial['ColorMaterial']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $colorMaterial['ColorMaterial']['id']), null, __('Are you sure you want to delete # %s?', $colorMaterial['ColorMaterial']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Color Material'), array('action' => 'add')); ?></li>
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
