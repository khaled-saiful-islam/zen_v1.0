<style type="text/css">
	
	table td {
    font-size: 13px;
	}
	.dashed-underline{
		border-bottom: 1px dashed #000!important;
	}
	table#shipping_info
	{
		border-collapse:collapse;
	}
	table#shipping_info, table#shipping_info td,table#shipping_info th
	{
		border:1px solid black;
	}
	table#shipping_info
	{
		width:100%;
	}
	table#shipping_info td
	{
		height:50px;
		width: 25%;
		text-align: center;
		font-weight: bold!important;
		padding-top: 10px;
	}
	table#shipping_info th{
		width: 25%;
		background-color: #bebebe!important;
		color: white!important;
		font-size: 16px!important;
	}
</style>
<?php
	$gst = $this->InventoryLookup->findGST();
	$pst = $this->InventoryLookup->FindPST();
?>

<div class="quotes report-print">	
  <fieldset style="position: relative; top: -120px;">
		<div style="text-align: right; font-size: 16px;">Purchase Order# &nbsp;&nbsp;&nbsp;<span style="font-size: 25px; font-weight: bold;"><?php echo h($purchaseorder['PurchaseOrder']['purchase_order_num']); ?></span></div>
		<div style="text-align: right; font-size: 16px;">Job Number &nbsp;&nbsp;&nbsp;<span style="font-size: 25px; font-weight: bold;"><?php echo h($purchaseorder['WorkOrder']['work_order_number']); ?></span></div>
    <div style="font-style: italic; font-weight: bold; color: #800000!important; width: 100%;" class="text-right sub-title">PURCHASE ORDER</div>
		<div style="float: right; font-size: 16px;">
		<?php
			if (isset($reportDate)) {
				if (is_int($reportDate)) {
					echo h(date('D, M j, Y', $reportDate));
				} else {
					echo h($reportDate);
				}
			}
		?>
	</div>
	<div style="clear: both;"></div>
    <div class="tab-content">
      <fieldset id="quote-basic-info-detail" class="sub-content-detail">
        <table>
          <tr>
            <th style="font-size: 16px;" class="text-left">Supplier</th>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <table class="table-report-compact">
                <tr>
                  <th>Name: </th>
                  <td>
                    <?php echo h($purchaseorder['Supplier']['name']); ?>&nbsp;
                  </td>
                </tr>
                <tr>
                  <th><?php echo __('Address'); ?>:</th>
                  <td>
                    <?php echo h($purchaseorder['Supplier']['address']); ?>
                    &nbsp;
                  </td>
                </tr>
								<tr>
									<th><?php echo __('City'); ?>:</th>
									<td>
										<?php echo $purchaseorder['Supplier']['city'].",";?>
										&nbsp;
									</td>
									<th><?php echo __('Pro/State'); ?>:</th>
									<td>
										<?php echo $purchaseorder['Supplier']['province'];?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<th><?php echo __('Phone'); ?>:</th>
									<td>
										<?php echo $purchaseorder['Supplier']['phone']." <br/><br/>Ext: ".$purchaseorder['Supplier']['phone_ext'];?>
										&nbsp;
									</td>
									<th><?php echo __('Postal/Zip'); ?>:</th>
									<td>
										<?php echo $purchaseorder['Supplier']['postal_code'];?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<th><?php echo __('Fax'); ?>:</th>
									<td>
										<?php echo $purchaseorder['Supplier']['fax_number'];?>
										&nbsp;
									</td>
								</tr>
              </table>
            </td>
            <td>
							<span style="font-size: 16px; display: block; position: relative; top: -20px; font-weight: bold;" class="text-left">Ship to</span>
              <table class="table-report-compact" style="float: right; margin-top: -10px;">
                <tr>
                  <th>Name:</th>
                  <td>
                    <?php echo $purchaseorder['PurchaseOrder']['name_ship_to'];?>
                    &nbsp;
                  </td>
                </tr>
								<tr>
									<th>Address:</th>
									<td>
										<?php echo $purchaseorder['PurchaseOrder']['address'];?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<th>City:</th>
									<td>
										<?php echo $purchaseorder['PurchaseOrder']['city'];?>
										&nbsp;
									</td>
									<th>Pro/State:</th>
									<td>
										<?php echo $purchaseorder['PurchaseOrder']['province'];?>
										&nbsp;
									</td>
								</tr>
								 <tr>
										<th>Phone:</th>
										<td>
											<?php echo $purchaseorder['PurchaseOrder']['phone']." <br/><br/>Ext: ".$purchaseorder['PurchaseOrder']['phone_ext'];?>
											&nbsp;
										</td>
										<th>Postal/Zip:</th>
									<td>
										<?php echo $purchaseorder['PurchaseOrder']['postal_code'];?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<th>Fax:</th>
									<td>
										<?php echo $purchaseorder['PurchaseOrder']['fax'];?>
										&nbsp;
									</td>
								</tr>
              </table>
            </td>
          </tr>
        </table>
      </fieldset>
			
			<table style="margin-top: 10px;" id="shipping_info">
				<tr>
					<th>Ship When</th>
					<th>Ship Via</th>
					<th>F.O.B Point</th>
					<th>Terms</th>
				</tr>
				<tr>
					<td><?php echo $this->Util->formatDate(h($purchaseorder['PurchaseOrder']['shipment_date'])); ?></td>
					<td><?php echo h($purchaseorder['PurchaseOrder']['shipment_via']); ?></td>
					<td><?php echo h($purchaseorder['PurchaseOrder']['f_o_b_point']); ?></td>
					<td><?php echo h($purchaseorder['PurchaseOrder']['term']); ?></td>
				</tr>				
			</table>
			
			<?php $order_items = $this->InventoryLookup->PurchaseOrderItem($purchaseorder['PurchaseOrder']['id']); ?>
      <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
        <div style="margin-top: 10px;" class="cabinet-list">
          <table id="cabinet-list" class="cabinet-list table-report-listing">
            <thead>
              <tr class="dashed-underline">
                <th class="text-left quantity">Qty</th>
                <th class="text-left small">Order Name</th>
                <th class="text-left">Description</th>
                <th class="small" style="text-align: right;">Each</th>
								<th class="small" style="text-align: right;">Total</th>
              </tr>
            </thead>
            <tbody>
							<?php
							$sub_total = 0;
							$item_total_cost = 0.00;
							$item_count = 0;
              if (!empty($order_items)) {
                foreach ($order_items as $order_item) {
									$item_info = explode('|', $order_item['PurchaseOrderItem']['code']);
									$item_type = $item_info[1];
                  ?>
                  <tr>
										<td class="text-left quantity">
											<?php 
												echo h($order_item['PurchaseOrderItem']['quantity']); 
												$item_count = $item_count + $order_item['PurchaseOrderItem']['quantity'];
											?>
										</td>
										<td class="text-left normal">
											<?php
											switch ($item_type) {
												case 'item':
													echo h($order_item['Item']['number']);
													break;
												case 'cabinet':
													echo h($order_item['Cabinet']['name']);
													break;
												case 'door':
												case 'drawer':
												case 'wall_door':
													echo h($order_item['Door']['door_style']);
													break;
											}
											?>
										</td>
										<td class="text-left">
											<?php
											switch ($item_type) {
												case 'item':
													echo h($order_item['Item']['description']);
													break;
												case 'cabinet':
													echo h($order_item['Cabinet']['description']);
													break;
												case 'door':
													echo h($order_item['Door']['door_style']);
													break;
												case 'drawer':
													echo h($order_item['Door']['drawer_code']);
													break;
												case 'wall_door':
													echo h($order_item['Door']['wall_door_code']);
													break;
											}
											?>
										</td>
										<td class="small" style="text-align: right;">
											<?php
											switch ($item_type) {
												case 'item':
													echo h($order_item['Item']['price']);
													break;
												case 'cabinet':
													echo h($order_item['Cabinet']['manual_unit_price']);
													break;
												case 'door':
													echo h($order_item['Door']['door_price_each']);
													break;
												case 'drawer':
													echo h($order_item['Door']['drawer_price_each']);
													break;
												case 'wall_door':
													echo h($order_item['Door']['wall_door_price_each']);
													break;
											}
											?>
										</td>
										<td class="small" style="text-align: right;">
											<?php
											switch ($item_type) {
												case 'item':
													$cost = number_format($order_item['PurchaseOrderItem']['quantity'] * $order_item['Item']['price'], 2, '.', '');
													$item_total_cost += $cost;
													$sub_total += $cost;
													echo $cost;
													break;
												case 'cabinet':
													$cost = number_format($order_item['PurchaseOrderItem']['quantity'] * $order_item['Cabinet']['manual_unit_price'], 2, '.', '');
													$item_total_cost += $cost;
													$sub_total += $cost;
													echo $cost;
													break;
												case 'door':
													$cost = number_format($order_item['PurchaseOrderItem']['quantity'] * $order_item['Door']['door_price_each'], 2, '.', '');
													$item_total_cost += $cost;
													$sub_total += $cost;
													echo $cost;
													break;
												case 'drawer':
													$cost = number_format($order_item['PurchaseOrderItem']['quantity'] * $order_item['Door']['drawer_price_each'], 2, '.', '');
													$item_total_cost += $cost;
													$sub_total += $cost;
													echo $cost;
													break;
												case 'wall_door':
													$cost = number_format($order_item['PurchaseOrderItem']['quantity'] * $order_item['Door']['wall_door_price_each'], 2, '.', '');
													$item_total_cost += $cost;
													$sub_total += $cost;
													echo $cost;
													break;
											}
											?>
										</td>
                  </tr>
                  <?php
                }
              } else {
                ?>
                <tr>
                  <td class="text-center" colspan="6">There is no Purchase Order</td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
					<div style="font-family: courier new; font-size: 13px; margin-top: 10px; min-height: 50px;"><span>Item Count: </span><?php echo $item_count; ?></div>
        </div>
      </fieldset>
			
			<div style="border-top: 1px solid black; border-bottom: 1px solid black; padding-bottom: 15px;">
				<div style="float: left; width: 55%; margin-top: 5px;">
					<div style="font-size: 16px; margin-bottom: 5px;">Payment Details</div>
					<div>
						<table style="width: 65%" class="table-report-PO">
                <tr>
                  <th>Payment Type: </th>
                  <td>
                    <?php echo h($purchaseorder['PurchaseOrder']['payment_type']); ?>&nbsp;
                  </td>
                </tr>
                <tr>
                  <th>Name (on CC): </th>
                  <td>
                    <?php echo h($purchaseorder['PurchaseOrder']['name_cc']); ?>
                    &nbsp;
                  </td>
                </tr>
								<tr>
									<th>Credit Card#: </th>
									<td>
										<?php echo $purchaseorder['PurchaseOrder']['cc_num'];?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<th>Expiry Date: </th>
									<td>
										<?php echo $this->Util->formatDate($purchaseorder['PurchaseOrder']['expiry_date']);?>
										&nbsp;
									</td>
								</tr>
              </table>
					</div>
				</div>
				<div style="float: right; width: 30%; margin-top: 5px;">
					<table id="po-report-total-section-left">
						<tr>
							<td style="text-align: right; color: #00008E!important;"><b>SubTotal </b></td>
							<td style="width: 70px; text-align: right;"><b><?php echo number_format($sub_total, 2); ?></b></td>
						</tr>
						<tr>
							<td style="text-align: right; color: #00008E!important;"><b>Shipping & Handling </b></td>
							<td style="width: 70px; text-align: right;"><b><?php echo $purchaseorder['PurchaseOrder']['shipping_handling']; ?></b></td>
						</tr>
						<tr>
							<?php
								$show_gst = $sub_total * ($gst / 100);
								$show_pst = $sub_total * ($pst / 100);
							?>
							<td style="text-align: right; color: #00008E!important;"><b>Taxes G.S.T. </b></td>
							<td style="width: 70px; text-align: right;"><b><?php echo number_format($show_gst, 2); ?></b></td>
						</tr>
						<tr>
							<td style="text-align: right; color: #00008E!important;"><b>P.S.T. </b></td>
							<td style="width: 70px; text-align: right;"><b><?php echo number_format($show_pst, 2); ?></b></td>
						</tr>
						<?php
							$total_amount_po = $sub_total + $sub_total * ($gst / 100) + $sub_total * ($pst / 100);
						?>
						<tr>
							<td style="text-align: right; border-top: 1px solid #000;"><span style="display: block; margin-right: 50px; font-size: 18px; font-weight: bold;">TOTAL </span></td>
							<td style="width: 70px; text-align: right; border-top: 1px solid #000;"><span style="display: block;font-size: 18px;"><?php echo number_format($total_amount_po, 2); ?></span></td>
						</tr>
					</table>
				</div>
				<div style="clear: both;"></div>
			</div>
			
			<div>
				<div style="font-size: 16px; margin-bottom: 5px; margin-top: 5px;">Notes</div>
				<div style="float: left; width: 33%; border: 1px solid #000; min-height: 100px; font-size: 14px; padding: 10px;">
					<?php echo $purchaseorder['PurchaseOrder']['note'];?>
				</div>
				<div style="clear: both;"></div>
				<div style="text-align: center; font-size: 18px; color: red; margin-top: 10px;">* * * Please confirm PO within 48Hrs with confirmed ETA * * *</div>
			</div>
    </div>

  </fieldset>
</div>
