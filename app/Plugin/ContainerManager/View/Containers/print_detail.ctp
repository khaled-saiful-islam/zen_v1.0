<div style="font-size: 18px; text-align: right; position: relative; top: -55px;">
	<div>Container ID: <?php echo $container['Container']['container_no']; ?></div>
	<div style="color: #7f7c7c; font-size: 16px; margin-top: 10px;">
		<?php
			if (isset($reportDate)) {
				if (is_int($reportDate)) {
					echo h(date('D, M jS, Y - h:i a', $reportDate));
				} else {
					echo h($reportDate);
				}
			}
		?>
	</div>
</div>

<div style="border-top: 1px dashed #000000; border-bottom: 1px dashed #000000; position: relative; top: -35px;">
	<div style="float: left; width: 49%;">
		<table>
			<tr>
				<td style="width: 160px; padding-bottom: 20px; padding-top: 15px; font-weight: bold;">Shipping Company: </td>
				<td style="width: 160px; padding-bottom: 20px; padding-top: 15px;"><?php echo $container['Container']['ship_company']; ?></td>
			</tr>
			<tr>
				<td style="width: 160px; padding-bottom: 15px; font-weight: bold;">Shipping Date: </td>
				<td style="width: 160px; padding-bottom: 15px;"><?php echo $this->Util->formatDate($container['Container']['ship_date']); ?></td>
			</tr>
		</table>
	</div>
	<div style="float: right; border-left: 1px dashed #000000; width: 50%;">
		<table style="margin-left: 20px;">
			<tr>
				<td style="width: 180px; padding-bottom: 20px; padding-top: 15px; font-weight: bold;">Estimated Arrival Date: </td>
				<td style="width: 180px; padding-bottom: 20px; padding-top: 15px;"><?php echo $this->Util->formatDate($container['Container']['ead']); ?></td>
			</tr>
			<tr>
				<td style="width: 180px; padding-bottom: 15px; font-weight: bold;">Received Date: </td>
				<td style="width: 180px; padding-bottom: 15px;"><?php echo $this->Util->formatDate($container['Container']['received_date']); ?></td>
			</tr>
		</table>
	</div>
	<div style="clear: both;"></div>
</div>

<fieldset style="position: relative; top: -20px;" id="quote-basic-info-detail-cabinets" class="sub-content-detail">
	<div style="margin-top: 20px;" class="cabinet-list">
		<table id="cabinet-list" class="cabinet-list" style="width: 100%;">
			<thead>
				<tr class="dashed-underline">
					<th style="font-weight: normal; font-size: 16px;" class="text-left-container">Skid No</th>
					<th style="font-weight: normal; font-size: 16px;" class="text-left-container">Work Orders</th>
					<th style="font-weight: normal; font-size: 16px;" class="text-left-container">Description</th>
					<th style="font-weight: normal; font-size: 16px;" class="text-left-container">Weight</th>
				</tr>
			</thead>
			<tbody>
			<?php	
			$total_weight = 0;
			if (!empty($container['ContainerSkid'])) {
				foreach ($container['ContainerSkid'] as $skid) {
					?>
					<tr>
						<td class="text-left-container"><?php echo $skid['skid_no']; ?></td>
						<td class="text-left-container"><?php echo $skid['work_order_number']; ?></td>
						<td class="text-left-container">
							<?php 
								if(empty($skid['work_order_number'])){
									$data = $this->InventoryLookup->getSkidDescrition($skid['skid_no']);
									echo $data; 
								}
							?>
						</td>
						<td class="text-left-container"><?php echo $skid['weight']; ?></td>
					</tr>
					<?php
					$total_weight += $skid['weight'];
				}
			} else {
				?>
				<tr>
					<td class="text-center" colspan="3">There is no Skid</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	</div>
</fieldset>

<div style="border-top: 1px solid #acacac;;">
	<table id="cabinet-list" class="cabinet-list" style="width: 100%;">
		<tr>
			<td class="text-left-container"><?php echo $cnt_skid; ?></td>
			<td class="text-left-container"><?php echo $wo_cnt; ?></td>
			<td class="text-left-container"><?php echo "&nbsp;"; ?></td>
			<td class="text-left-container"><?php echo $total_weight; ?></td>
		</tr>
	</table>
</div>