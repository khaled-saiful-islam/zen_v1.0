<h2>Schedule Color Setup</h2>
<table style="width: 400px;" cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
	<thead>
		<tr class="grid-header">
			<th><?php echo h('Type'); ?></th>
			<th><?php echo h('BackGround Color'); ?></th>
			<th class="actions"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $ScheduleColorData as $info ): ?>
			<tr>
				<td>
					<?php echo h($info['ScheduleColor']['type']);  ?>
					&nbsp;
				</td>
				<td>
					<div style="width: 30px;border: 2px solid #000000; background-color:<?php echo "#" . $info['ScheduleColor']['bgcolor']; ?>">&nbsp;</div>
					&nbsp;
				</td>
				<td>
					<?php 
						echo $this->Html->link('', array('controller' => 'appointments','action' => 'edit_color', $info['ScheduleColor']['id'], $info['ScheduleColor']['type']), array('class' => 'icon-edit'));
					?>
				</td>
			</tr>
<?php endforeach; ?>
	</tbody>
</table>