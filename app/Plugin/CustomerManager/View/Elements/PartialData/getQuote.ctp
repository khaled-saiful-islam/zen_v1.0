<h4>Quote Detail</h4>
<div class="detail actions">
	<?php echo $this->Html->link('Back', array('controller' => 'builder_projects', 'action' => 'getQuoteAndWO', $quote['Quote']['project_id'], $customer_id), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<div class="">	
	<table class="table-form-big">
			<tr>
				<th><?php echo __('Quote Number'); ?>:</th>
				<td colspan="6">
					<?php echo h($quote['Quote']['quote_number']); ?>
					&nbsp;
				</td>
			</tr>
			<tr>
				</td>
				<th><label for="QuoteCustomerId">Customer: </label></th>
				<td colspan="3">
					<?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
				</td>
				<th><?php echo __('Sales Person'); ?>:</th>
				<td colspan="2">
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
					&nbsp;
				</td>
			</tr>
			<tr>
				<th rowspan="3"><?php echo __('Address'); ?>:</th>
				<td rowspan="3" colspan="3">
					<?php echo $this->InventoryLookup->address_format(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
					&nbsp;
				</td>
				<th><?php echo __('Job Detail'); ?>:</th>
				<td>
					<?php echo h($quote['Quote']['job_detail']); ?>
					&nbsp;
				</td>
			</tr>
			<tr>
				<th><?php echo __('Est Shipping'); ?>:<label class="wide-width-date">(dd/mm/yyyy)</label></th>
				<td rowspan="3" colspan="3">
					<?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?>
					&nbsp;
				</td>
			</tr>
		</table>
		<table class="table-form-big" style="margin-top: 5px;">
			<tr>
				<th style="width: 85px;"><label for="QuoteCustomerId">Skid Number: </label></th>
				<td colspan="3">
					<?php echo $quote['Quote']['skid_number']; ?>&nbsp;
				</td>
				<th style="width: 78px;"><?php echo __('Skid Weight'); ?>:</th>
				<td colspan="2">
					<?php 
						echo $quote['Quote']['skid_weight']; ?>
					&nbsp;
				</td>
			</tr>
		</table>
		<table class="table-form-big" style="margin-top: 5px;">
			<tr>
				<th style="width: 85px;"><label>First Measure: </label></th>
				<td colspan="3">
					<?php echo $this->Util->formatDate($quote['Quote']['first_date_measure']); ?>&nbsp;
				</td>
				<th style="width: 78px;"><label>Second Measure: </label></th>
				<td colspan="2">
					<?php 
						echo $this->Util->formatDate($quote['Quote']['second_date_measure']); ?>&nbsp;
				</td>
			</tr>
		</table>
		<table class="table-form-big" style="margin-top: 5px;">
			<tr>
				<th style="width: 85px;"><label for="QuoteCustomerId">Interior: </label></th>
				<td colspan="3">
					<?php 
						if($quote['Quote']['is_interior_melamine'] == 1)
							echo "White Interior Melamine";
						if($quote['Quote']['is_interior_melamine'] == 0)
							echo "";
					?>&nbsp;
				</td>
			</tr>
		</table>
 </div>