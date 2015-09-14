<div class="colorSections index">
	<h2><?php echo __('Color Sections');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('color_id');?></th>
			<th><?php echo $this->Paginator->sort('cost');?></th>
			<th><?php echo $this->Paginator->sort('markup');?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($colorSections as $colorSection): ?>
	<tr>
		<td><?php echo h($colorSection['ColorSection']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($colorSection['Color']['name'], array('controller' => 'colors', 'action' => 'view', $colorSection['Color']['id'])); ?>
		</td>
		<td><?php echo h($colorSection['ColorSection']['cost']); ?>&nbsp;</td>
		<td><?php echo h($colorSection['ColorSection']['markup']); ?>&nbsp;</td>
		<td><?php echo h($colorSection['ColorSection']['price']); ?>&nbsp;</td>
		<td><?php echo h($colorSection['ColorSection']['type']); ?>&nbsp;</td>
		<td><?php echo h($colorSection['ColorSection']['created']); ?>&nbsp;</td>
		<td><?php echo h($colorSection['ColorSection']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $colorSection['ColorSection']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $colorSection['ColorSection']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $colorSection['ColorSection']['id']), null, __('Are you sure you want to delete # %s?', $colorSection['ColorSection']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Color Section'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Colors'), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color'), array('controller' => 'colors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Color Materials'), array('controller' => 'color_materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color Material'), array('controller' => 'color_materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
