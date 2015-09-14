<fieldset>
  <legend><?php echo $legend; ?></legend>
	<div class="detail actions">
		<?php echo $this->Html->link('Edit', array('controller' => 'skid_inventorys', 'action' => 'edit', $skidinventory['SkidInventory']['id']), array('class' => 'btn btn-success btn-padding', 'title' => __('Edit'))); ?>
	</div>
	<div class="detail actions" style="padding-right: 20px;">
		<?php echo $this->Html->link('Back', array('controller' => 'skid_inventorys', 'action' => 'index'), array('class' => 'btn btn-success btn-padding', 'title' => __('Back'))); ?>
	</div>
  <div class="work-order form">		
		<table class="table-form-big" width="50%">
			<tr>
				<th>
					<label>Skid NO:</label>
				</th>
				<td>
					<?php echo $skidinventory['SkidInventory']['skid_no']; ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>Weight:</label>
				</th>
				<td>
					<?php echo $skidinventory['SkidInventory']['weight']; ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>Description:</label>
				</th>
				<td>
					<?php echo $skidinventory['SkidInventory']['description']; ?>
				</td>
			</tr>
		</table>
		
  </div>
</fieldset>

<style type="text/css">
	.table-form-big th{
		width: 120px;
	}
</style>