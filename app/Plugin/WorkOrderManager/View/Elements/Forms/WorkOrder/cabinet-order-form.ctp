<div class="cabinetOrders form">
	<?php
	$all_items = $this->InventoryLookup->ListAllTypesOfItems();
	$main_item_list = $all_items['main_list'];
	$price_list = $all_items['price_list'];
	$title_list = $all_items['title_list'];

	$total_cost = 0;

	echo $this->Form->input('current_quote_id', array( 'type' => 'hidden', 'class' => 'hide', 'value' => $quote['Quote']['id'] ));
	?>

	<?php echo $this->Form->create('CabinetOrder', array( 'inputDefaults' => array( ), 'class' => 'cabinet-order-form ajax-form-submit', 'url' => '/quote_manager/cabinet_orders/save_quote_cabinets/' . $quote['Quote']['id'] )); ?>
  <div class="align-left align-top-margin">
		<table class="cabinet-list global-options main-table">
				<tr class="text-left"><th style="width: 110px;">Drawer: </th><td><?php echo $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer']); ?></td></tr>
				<tr class="text-left"><th style="width: 110px;">Drawer Slider: </th><td><?php echo $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer_slide']); ?></td></tr>
				<tr class="text-left"><th style="width: 110px;">Delivery: </th><td style="width: 160px;"><?php echo $quote['Quote']['delivery']; ?></td><td><?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?></td></tr>
				<tr class="text-left"><th style="width: 110px;">Installation: </th><td><?php echo $quote['Quote']['installation']; ?></td></tr>
		</table>
		
    <div class="cabinet-list" id="cabinet-list-after-review">
      <table id="cabinet-list" class="cabinet-list main-table" border="1">
        <thead>
          <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Door</th>
            <th>Door Color</th>
            <th>Material</th>
            <th>Cabinet Color</th>
						<th>Door Option</th>
            <th>Quantity</th>
            <th>Price</th>
            <th style="width:50px;">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
					<?php
					if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
						foreach( $quote['CabinetOrder'] as $cabinet_order ) {
							$temporary_class = $cabinet_order['temporary'] ? ' temporary ' : ($cabinet_order['temporary_delete'] ? ' temporary-delete ' : '');
							?>
							<?php $modal_id = $cabinet_order['id']; ?>
							<tr valign="top" class="<?php echo $temporary_class; ?>">
								<td class="text-left">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['id'], 'class' => 'cabinet_order_id' ));
									echo $this->Form->input($modal_id . '.temporary_delete', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['temporary_delete'] ));
									echo $this->Form->input($modal_id . '.temporary', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['temporary'] ));
									echo $this->Form->input($modal_id . '.resource_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['resource_id'] ));
									echo $this->Form->input($modal_id . '.resource_type', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['resource_type'] ));
									switch( $cabinet_order['resource_type'] ) {
										case 'cabinet':
											echo $this->InventoryLookup->CabinetName2ID($cabinet_order['resource_id'], true);
											break;
										case 'item':
											echo $this->InventoryLookup->ItemTitle2ID($cabinet_order['resource_id'], true);
											break;
										case 'custom_door':
											echo 'CD';
											break;
										case 'custom_panel':
											echo 'CP';
											break;
									}
									?>
								</td>
								<td class="text-left description">
									&nbsp;
									<?php
									if( isset($cabinet_order['description']) && !empty($cabinet_order['description']) ) {
										echo $this->Form->input($modal_id . '.description', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['description'] ));
										echo h($cabinet_order['description']);
									}
									if( isset($cabinet_order['edgetape']) && !empty($cabinet_order['edgetape']) ) {
										echo $this->Form->input($modal_id . '.edgetape', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['edgetape'] ));
									}
									?>
								</td>
								<td class="text-left">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.door_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_id'] ));
									echo $this->InventoryLookup->DoorStyle2ID($cabinet_order['door_id'], true);
									?>
								</td>
								<td class="text-left">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.door_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_color'] ));
									echo $this->InventoryLookup->ColorCode2ID($cabinet_order['door_color'], true);
									?>
								</td>
								<td class="text-left">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.material_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['material_id'] ));
									echo $this->InventoryLookup->MaterialCode2ID($cabinet_order['material_id'], true);
									?>
								</td>
								<td class="text-left">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.cabinet_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['cabinet_color'] ));
									echo $this->InventoryLookup->ColorCode2ID($cabinet_order['cabinet_color'], true);
									?>
								</td>
								<td class="text-right quantity">
									<?php echo $cabinet_order['door_side']; ?>
								</td>
								<td class="text-right quantity">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.quantity', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['quantity'] ));
									echo $cabinet_order['quantity'];
									?>
								</td>
								<td class="text-right price">
									&nbsp;
									<?php
									echo $this->Form->input($modal_id . '.total_cost', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['total_cost'] ));
									echo $this->Util->formatCurrency($cabinet_order['total_cost']);
									?>
								</td>
								<td class="text-left" style="width:50px;">
									&nbsp;
									<?php
									if( $edit ) {
										?>
<!--											<a href="#" class="icon-remove icon-remove-margin remove-cabinet-order-item show-tooltip" title="Remove">&nbsp;</a>-->
											<?php
										if( $cabinet_order['cost_calculation'] ) {
											echo $this->Form->input($modal_id . '.cost_calculation', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['cost_calculation'] ));
											?>
											<a href="#<?php echo $modal_id; ?>" class="icon-info-sign show-tooltip" title="Calculation Detail" data-toggle="modal">&nbsp;</a>
											<div id="<?php echo $modal_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h3>Price Calculation Detail</h3>
												</div>
												<div class="modal-body">
													<p><?php echo $cabinet_order['cost_calculation']; ?></p>
													<p>&nbsp;</p>
												</div>
											</div>
											<?php
										}
									}
									?>
								</td>
								<?php
							}
						}
						?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="align-left align-top-margin">
		<?php // echo $this->Html->link('Cancel', array('controller' => 'quotes', 'action' => DETAIL, $quote['Quote']['id']), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel'));     ?>
  </div>
  <div class="clear"></div>
	<?php echo $this->Form->end(); ?>

  <div id="add-custom-panel-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Add Custom Panel</h3>
    </div>
    <div class="modal-body">
      <p>
				<?php echo $this->element('Forms/Order/cabinet-order-custom-panel-form'); ?>
      </p>
      <p>&nbsp;</p>
    </div>
  </div>

  <div id="add-custom-door-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Add Custom Door</h3>
    </div>
    <div class="modal-body">
      <p>
				<?php echo $this->element('Forms/Order/cabinet-order-custom-door-form'); ?>
      </p>
      <p>&nbsp;</p>
    </div>
  </div>
</div>