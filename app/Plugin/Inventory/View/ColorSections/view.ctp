<div class="colorSections view">
<h2><?php  echo __('Color Section');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($colorSection['ColorSection']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color'); ?></dt>
		<dd>
			<?php echo $this->Html->link($colorSection['Color']['name'], array('controller' => 'colors', 'action' => 'view', $colorSection['Color']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cost'); ?></dt>
		<dd>
			<?php echo h($colorSection['ColorSection']['cost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Markup'); ?></dt>
		<dd>
			<?php echo h($colorSection['ColorSection']['markup']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($this->Util->formatCurrency($colorSection['ColorSection']['price'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($colorSection['ColorSection']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($colorSection['ColorSection']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($colorSection['ColorSection']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Color Section'), array('action' => 'edit', $colorSection['ColorSection']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Color Section'), array('action' => 'delete', $colorSection['ColorSection']['id']), null, __('Are you sure you want to delete # %s?', $colorSection['ColorSection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Color Sections'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color Section'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors'), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color'), array('controller' => 'colors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Color Materials'), array('controller' => 'color_materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color Material'), array('controller' => 'color_materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Color Materials');?></h3>
	<?php if (!empty($colorSection['ColorMaterial'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Color Id'); ?></th>
		<th><?php echo __('Material Id'); ?></th>
		<th><?php echo __('EdgeTapee Id'); ?></th>
		<th><?php echo __('Color Section Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($colorSection['ColorMaterial'] as $colorMaterial): ?>
		<tr>
			<td><?php echo $colorMaterial['id'];?></td>
			<td><?php echo $colorMaterial['color_id'];?></td>
			<td><?php echo $colorMaterial['material_id'];?></td>
			<td><?php echo $colorMaterial['edgetape_id'];?></td>
			<td><?php echo $colorMaterial['color_section_id'];?></td>
			<td><?php echo $colorMaterial['created'];?></td>
			<td><?php echo $colorMaterial['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'color_materials', 'action' => 'view', $colorMaterial['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'color_materials', 'action' => 'edit', $colorMaterial['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'color_materials', 'action' => 'delete', $colorMaterial['id']), null, __('Are you sure you want to delete # %s?', $colorMaterial['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Color Material'), array('controller' => 'color_materials', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
