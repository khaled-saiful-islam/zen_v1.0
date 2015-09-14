<div class="builders view">
<h2><?php  echo __('Builder');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Suite'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['suite']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address 1'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['address_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address 2'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['address_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fax'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['fax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Rate'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['discount_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($builder['CustomerType']['name'], array('controller' => 'customer_types', 'action' => 'view', $builder['CustomerType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quotes Validity'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['quotes_validity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ar Account'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['ar_account']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ap Account'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['ap_account']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Multi Unit'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['multi_unit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Retail Client'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['retail_client']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($builder['Builder']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Builder'), array('action' => 'edit', $builder['Builder']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Builder'), array('action' => 'delete', $builder['Builder']['id']), null, __('Are you sure you want to delete # %s?', $builder['Builder']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Builders'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Builder'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customer Types'), array('controller' => 'customer_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer Type'), array('controller' => 'customer_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Quotes'), array('controller' => 'quotes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Quote'), array('controller' => 'quotes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Quotes');?></h3>
	<?php if (!empty($builder['Quote'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Job Name'); ?></th>
		<th><?php echo __('Address 1'); ?></th>
		<th><?php echo __('Address 2'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('State'); ?></th>
		<th><?php echo __('Zip'); ?></th>
		<th><?php echo __('Country'); ?></th>
		<th><?php echo __('Builder Id'); ?></th>
		<th><?php echo __('Builder Po'); ?></th>
		<th><?php echo __('Builder Job'); ?></th>
		<th><?php echo __('Reference'); ?></th>
		<th><?php echo __('Est Shipping'); ?></th>
		<th><?php echo __('Sales Person'); ?></th>
		<th><?php echo __('Job Detail'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($builder['Quote'] as $quote): ?>
		<tr>
			<td><?php echo $quote['id'];?></td>
			<td><?php echo $quote['job_name'];?></td>
			<td><?php echo $quote['address_1'];?></td>
			<td><?php echo $quote['address_2'];?></td>
			<td><?php echo $quote['city'];?></td>
			<td><?php echo $quote['state'];?></td>
			<td><?php echo $quote['zip'];?></td>
			<td><?php echo $quote['country'];?></td>
			<td><?php echo $quote['builder_id'];?></td>
			<td><?php echo $quote['builder_po'];?></td>
			<td><?php echo $quote['builder_job'];?></td>
			<td><?php echo $quote['reference'];?></td>
			<td><?php echo $quote['est_shipping'];?></td>
			<td><?php echo $quote['sales_person'];?></td>
			<td><?php echo $quote['job_detail'];?></td>
			<td><?php echo $quote['created'];?></td>
			<td><?php echo $quote['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'quotes', 'action' => 'view', $quote['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'quotes', 'action' => 'edit', $quote['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'quotes', 'action' => 'delete', $quote['id']), null, __('Are you sure you want to delete # %s?', $quote['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Quote'), array('controller' => 'quotes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
