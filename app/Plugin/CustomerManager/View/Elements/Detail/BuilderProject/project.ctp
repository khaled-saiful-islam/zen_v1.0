<div class="detail actions">
	<?php echo $this->Html->link('Edit', array('controller' => 'builder_projects', 'action' => 'edit', $builderproject_data['BuilderProject']['id']), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<div class="detail actions" style="padding-right: 20px;">
	<?php echo $this->Html->link('Back', array('controller' => 'builder_projects', 'action' => 'getList', $builderproject_data['BuilderProject']['customer_id']), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Back'))); ?>
</div>
<h4>Project Detail</h4>
	<table class="customer_quote_form">
		<tr>
			<th>Project: </th>
			<td>
				<?php echo $builderproject_data['BuilderProject']['project_name']; ?>
			</td>
		</tr>
		<tr>
			<th>Site Address: </th>
			<td>
				<?php echo $this->InventoryLookup->address_format($builderproject_data['BuilderProject']['site_address'], $builderproject_data['BuilderProject']['city'], $builderproject_data['BuilderProject']['province'], $builderproject_data['BuilderProject']['postal_code'], $builderproject_data['BuilderProject']['country']); ?>
			</td>
		</tr>
		<tr>
			<th>Contact Person: </th>
			<td>
				<?php echo $builderproject_data['BuilderProject']['contact_person']; ?>
			</td>
		</tr>
		<tr>
			<th>Phone: </th>
			<td>
				<?php echo $builderproject_data['BuilderProject']['contact_person_phone']; ?>
			</td>
		</tr>
		<tr>
			<th>Cell: </th>
			<td>
				<?php echo $builderproject_data['BuilderProject']['contact_person_cell']; ?>
			</td>
		</tr>
		<tr>
			<th style="width: 150px!important;">Multi Family Pricing:</th>
			<td>
					<?php 
						if($builderproject_data['BuilderProject']['multi_family_pricing'] == 1)
							echo "Yes"; 
						else {
							echo "No";
						}
					?>
			</td>
		</tr>
		<tr>
			<th>Builder Name: </th>
			<td>
				<?php
					echo $this->InventoryLookup->findCustomer($builderproject_data['BuilderProject']['customer_id']);
				?>
			</td>
		</tr>
		<tr>
			<th>Comments: </th>
			<td><?php echo $builderproject_data['BuilderProject']['comment']; ?></td>
		</tr>
	</table>
