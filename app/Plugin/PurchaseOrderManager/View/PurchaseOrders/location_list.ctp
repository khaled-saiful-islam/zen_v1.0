<div style="width: 400px;">
	<h2 style="float: left; margin-right: 15px;">Location Setup</h2>
	<div style="float: left; width: 150px; position: relative; top: 22px;">
		<?php 
			echo $this->Html->link('<i class="icon-plus icon-blue"></i> Add Location', array('controller' => 'purchase_orders','action' => 'location_add'), array('escape' => false));
		?>
	</div>
</div>
<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
	<thead>
		<tr class="grid-header">
			<th><?php echo h('Type'); ?></th>
			<th><?php echo h('Address'); ?></th>
			<th><?php echo h('City'); ?></th>
			<th><?php echo h('Province'); ?></th>
			<th><?php echo h('Postal Code'); ?></th>
			<th><?php echo h('Country'); ?></th>
			<th class="actions"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $locations as $location ): ?>
			<tr>
				<td>
					<?php echo h($location['GeneralSetting']['name']);?>
					&nbsp;
				</td>
				<td>
					<?php echo h($location['GeneralSetting']['address']);?>
					&nbsp;
				</td>
				<td>
					<?php echo h($location['GeneralSetting']['city']); ?>
					&nbsp;
				</td>
				<td>
					<?php echo h($location['GeneralSetting']['province']); ?>
					&nbsp;
				</td>
				<td>
					<?php echo h($location['GeneralSetting']['postal_code']); ?>
					&nbsp;
				</td>
				<td>
					<?php echo h($location['GeneralSetting']['country']); ?>
					&nbsp;
				</td>
				<td>
					<?php 
						echo $this->Html->link('', array('controller' => 'purchase_orders','action' => 'location_edit', $location['GeneralSetting']['id']), array('class' => 'icon-edit'));
					?>
				</td>
			</tr>
<?php endforeach; ?>
	</tbody>
</table>