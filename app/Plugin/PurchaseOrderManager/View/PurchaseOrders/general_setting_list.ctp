<h2>General Setup</h2>
<table style="width: 400px;" cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
	<thead>
		<tr class="grid-header">
			<th><?php echo h('Type'); ?></th>
			<th class="actions"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $general_info as $info ): ?>
			<tr>
				<td>
					<?php echo h($info['GeneralSetting']['name']);  ?>
					&nbsp;
				</td>
				<td>
					<?php 
						if($info['GeneralSetting']['type'] == 'location'){
							echo $this->Html->link('', array('controller' => 'purchase_orders','action' => 'location_list', $info['GeneralSetting']['id'], $info['GeneralSetting']['type']), array('class' => 'icon-list'));
						}
						if($info['GeneralSetting']['type'] == 'gst') {
							echo $this->Html->link('', array('controller' => 'purchase_orders','action' => 'gst', $info['GeneralSetting']['id']), array('class' => 'icon-edit'));
						}
						if($info['GeneralSetting']['type'] == 'pst') {
							echo $this->Html->link('', array('controller' => 'purchase_orders','action' => 'pst', $info['GeneralSetting']['id']), array('class' => 'icon-edit'));
						}
						if($info['GeneralSetting']['type'] == 'deposit_payment') {
							echo $this->Html->link('', array('controller' => 'purchase_orders','action' => 'deposit_payment', $info['GeneralSetting']['id']), array('class' => 'icon-edit'));
						}
					?>
				</td>
			</tr>
<?php endforeach; ?>
	</tbody>
</table>