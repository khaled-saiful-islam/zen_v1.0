<div class="quote_detail_report">
	<div class="first_div">
		<table class="quote_detail_report_table" width="100%">
			<tr>
				<th style="width:20%; padding-left: 20px;">Customer: </th>
				<td style="width:80%">
					<?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
				</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td>
					<?php echo $this->InventoryLookup->address_format_quote_report(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
				</td>
			</tr>
		</table>
	</div>
	<div class="second_div">
		<table class="quote_detail_report_table" width="100%">
			<tr>
				<th style="width:30%; padding-left: 20px;">Sales Person: </th>
				<td style="width:70%;">
					<?php 
						$sales = unserialize($quote['Quote']['sales_person']); 
						$cnt = count($sales);
						$j = 1;
						for($i = 0; $i<$cnt; $i++){
							$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
							echo $sales_person['User']['first_name']. " " . $sales_person['User']['last_name'];
							if($j < $cnt)
								echo " / ";
							$j++;
						}						
					?>
				</td>
			</tr>
			<tr>
				<th style="width:20%; padding-left: 20px;">Job Detail: </th>
				<td style="width:80%">
					<?php echo h($quote['Quote']['job_detail']); ?>
				</td>
			</tr>
		</table>
	</div>
</div>