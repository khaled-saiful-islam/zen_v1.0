<div class="detail actions">
	<?php echo $this->Html->link('Back', array('controller' => 'builders', 'action' => 'ExtraDetail', $customer_id), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<h4>Quote List</h4>
<table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
  <thead>
		<tr class="grid-header">
			<th><?php echo 'Quote Number'; ?></th>
			<th><?php echo 'Customer Name'; ?></th>
			<th><?php echo 'Sales Person'; ?></th>
			<th><?php echo 'EST Shipping'; ?></th>			
			<th class="actions"><?php echo __(''); ?></th>
		</tr>
  </thead>
  <tbody>
    <?php 
		if($Quote_data){
			
			foreach ($Quote_data as $quote): 
				?>
				<tr>
					<td>
						<?php echo $this->Html->link(h($quote['Quote']['quote_number']), array('controller' => 'builder_projects','action' => 'getQuote', $quote['Quote']['id'], $customer_id), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content table-first-column-color', 'title' => __('View'))); ?>
						&nbsp;
					</td>
					<td>
						<?php echo $quote['Customer']['last_name']; ?>
					</td>
					<td>
						<?php 
							$sales = unserialize($quote['Quote']['sales_person']); 
							$cnt = count($sales);
							$j = 1;
							for($i = 0; $i<$cnt; $i++){
								$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
								echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
								$j++;
							}						
						?>
					</td>        
					<td><?php echo h($this->Util->formatDate($quote['Quote']['est_shipping'])); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link('', array('controller' => 'builder_projects','action' => 'getQuote', $quote['Quote']['id'], $customer_id), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content icon-file', 'title' => __('View'))); ?>
					</td>
				</tr>
			<?php 
				endforeach; 
		}
		else {
		?>
				<tbody>
					<tr>
						<td colspan="5">
							<label class="text-cursor-normal">No data here</label>
						</td>
					</tr>
				</tbody>
		<?php		
		}
		?>
  </tbody>
</table>
<!---------------------------------------------------------------------------------------------------------------------------------------------------->
<h4>Work Order List</h4>
<table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
  <thead>
		<tr class="grid-header">
			<th><?php echo 'Work Order Name'; ?></th>
			<th><?php echo 'Customer Name'; ?></th>
			<th><?php echo 'Sales Person'; ?></th>
			<th><?php echo 'EST Shipping'; ?></th>			
			<th class="actions"><?php echo __(''); ?></th>
		</tr>
  </thead>
  <tbody>
    <?php 
		if($WorkOrder_data){
			foreach ($WorkOrder_data as $WorkOrder):
				?>
				<tr>
					<td>
						<?php echo $this->Html->link(h($WorkOrder['WorkOrder']['work_order_number']), array('controller' => 'builder_projects', 'action' => "getWorkOrder", $WorkOrder['WorkOrder']['id'], $customer_id), array('data-target' => '#sub-project-list','class' => 'ajax-sub-content table-first-column-color', 'title' => __('View'))); ?>
						&nbsp;
					</td>
					<td>
						<?php echo $WorkOrder['Customer']['last_name']; ?>
					</td>
					<td>
						<?php 
							$sales = unserialize($WorkOrder['Quote']['sales_person']); 
							$cnt = count($sales);
							$j = 1;
							for($i = 0; $i<$cnt; $i++){
								$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
								echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
								$j++;
							}						
						?>
					</td>
					<td><?php echo h($this->Util->formatDate($WorkOrder['Quote']['est_shipping'])); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link('', array('controller' => 'builder_projects', 'action' => "getWorkOrder", $WorkOrder['WorkOrder']['id'], $customer_id), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content icon-file', 'title' => __('View'))); ?>
					</td>
				</tr>
			<?php 
				endforeach; 
		}
		else
		{
		?>
			<tbody>
				<tr>
					<td colspan="5">
						<label class="text-cursor-normal">No data here</label>
					</td>
				</tr>
			</tbody>	
		<?php		
		}
		?>
  </tbody>
</table>
