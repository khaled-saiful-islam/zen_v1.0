<style>
	table td {
    font-size: 12px;
    width: 0%;;
}
</style>
<div class="quotes report-print" style="margin-bottom: 130px;">
  <fieldset>
    <legend style="border-bottom-color: #fff;">
			<span style="font-weight: normal;"><?php echo __('Estimated Delivery Date'); ?><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$this->Util->formatDate($quote['Quote']['est_shipping']); ?></span>
			<div style="color: red; font-size: 22px; font-weight: bold; width: 245px; float: right;" class="text-right"><?php echo $quote['Quote']['delivery']; ?></div>
		</legend>

    <div class="tab-content">
      <fieldset id="quote-basic-info-detail" class="sub-content-detail">
				<?php echo $this->element('Detail/Quote/print_detail', array( 'quote' => $quote, 'edit' => false )); ?>
      </fieldset>
      <div style="color: red; width: 370px; float: right; margin-bottom: 20px; font-size: 20px;" class="red text-right"><?php echo $quote['Quote']['installation']; ?> Production Time</div>
      <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
        <!--<h2 style="font-size: 14px;"><?php echo __('Cabinet'); ?></h2>-->
        <div class="cabinet-list">
          <table id="cabinet-list" class="cabinet-list">
            <thead>
              <tr class="dashed-underline">
                <th class="text-left quantity">Qty</th>
                <th class="text-left small">Code</th>
                <th class="text-left">Description</th>
                <th style="display: block; width: 60px;" class="text-left small">Cabinet Color</th>
                <th class="text-left small">Door Style</th>
                <th class="text-left small">Door Color</th>
                <th class="text-right">Each</th>
                <th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
							<?php
							$total_quote_price = 0;
							$total_quote_price_cabinet = 0;
							$total_quote_price_installation = 0;
							$total_quote_price_discount = 0;
							$extra_total = 0;
							$cabinets = array( );

							if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
								App::import("Model", "Inventory.Cabinet");
								App::import("Model", "Inventory.Item");
								foreach( $quote['CabinetOrder'] as $cabinet_order ) {
									$item_model_ass_chk = new Item();
									$item_detail_info = $item_model_ass_chk->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
									if($item_detail_info['Item']['Department'] == 'Accessories'){
										continue;
									}									

									$cabinet = new Cabinet();
									$item_model = new Item();
									$resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
									switch( $cabinet_order['resource_type'] ) {
										case 'cabinet':
											$resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));
											$resource_detail['Resource']['name'] = $resource_detail['Cabinet']['name'];
											$resource_detail['Resource']['description'] = $resource_detail['Cabinet']['description'];
											$cabinets[] = $resource_detail;
											break;
										
										case 'item':
											$resource_detail = $item_model->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
											if($resource_detail['Item']['Department'] == 'Accessories'){
												break;
											}
											$resource_detail['Resource']['name'] = $resource_detail['Cabinet'][0]['name'];
											$resource_detail['Resource']['description'] = $resource_detail['Cabinet'][0]['description'];
											$cabinets[] = $resource_detail;
											//pr($cabinets);
											break;
										
										default:
											break;
									};//pr($resource_detail);
									?>
									<tr valign="top">
										<td class="text-left quantity"><?php echo $cabinet_order['quantity']; ?></td>
										<td class="text-left small_detail">
											<?php
											echo $resource_detail['Resource']['name'];
											?>
										</td>
										<td class="text-left"><?php echo $resource_detail['Resource']['description']; ?></td>
										<td style="display: block; width: 60px;" class="text-left small">
											<?php
											if( $cabinet_order['cabinet_color'] ) {
												$color = $this->InventoryLookup->ColorDetail($cabinet_order['cabinet_color']);
												if( $color ) {
													echo $color['Color']['code'];
												}
											}
											?>
											&nbsp;
										</td>
										<td class="text-left small">
											<?php
											if( $cabinet_order['door_id'] ) {
												$style = $this->InventoryLookup->DoorStyle2ID($cabinet_order['door_id'], TRUE);
												if( $style ) {
													echo $style;
												}
											}
											?>
										</td>
										<td class="text-left small">
											<?php
											if( $cabinet_order['door_color'] ) {
												$color = $this->InventoryLookup->ColorDetail($cabinet_order['door_color']);
												if( $color ) {
													echo $color['Color']['code'];
												}
											}
											?>
											&nbsp;
										</td>
										<td class="text-right price"><?php echo $this->Util->formatCurrency($cabinet_order['total_cost']); ?></td>
										<td class="text-right price">
											<?php
											$sub_total = $cabinet_order['total_cost'];
											$total_quote_price_cabinet += $sub_total;
											echo $this->Util->formatCurrency($sub_total);
											?>
										</td>
									</tr>
									<?php
								}
							}
							?>
							
							<?php
//							if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
//								App::import("Model", "Inventory.Cabinet");
//								App::import("Model", "Inventory.Item");
//								foreach( $quote['CabinetOrder'] as $cabinet_order ) {
//									$cabinet = new Cabinet();
//									$item_model = new Item();
//									$resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
//									switch( $cabinet_order['resource_type'] ) {
//										case 'cabinet':
//											$resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));
//											$resource_detail['Resource']['name'] = $resource_detail['Cabinet']['name'];
//											$resource_detail['Resource']['description'] = $resource_detail['Cabinet']['description'];
//											$cabinets[] = $resource_detail;
//											break;
//										
//										case 'item':
//											$resource_detail = $item_model->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
//											$resource_detail['Resource']['name'] = $resource_detail['Cabinet'][0]['name'];
//											$resource_detail['Resource']['description'] = $resource_detail['Cabinet'][0]['description'];
//											$cabinets[] = $resource_detail;
//											//pr($cabinets);
//											break;
//										
//										default:
//											break;
//									};
//									if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) && ($cabinet_order['resource_type'] == 'cabinet') ) {
//										foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
//											if( $cabinet_item['accessories'] ) { // show accessories only
												?>
<!--												<tr valign="top">
													<td class="text-left quantity" ><?php echo $cabinet_item['item_quantity']; ?></td>
													<td class="text-left small">
														<?php
														$item = $this->InventoryLookup->ItemDetail($cabinet_item['item_id']);
														echo $item['Item']['item_title'];
														?>
													</td>
													<td class="text-left"><?php echo $item['Item']['description']; ?></td>
													<td class="text-left small">&nbsp;</td>
													<td class="text-left small">&nbsp;</td>
													<td class="text-left small">&nbsp;</td>
													<td class="text-right price"><?php echo $this->Util->formatCurrency($item['Item']['price']); ?></td>
													<td class="text-right price">
														<?php
														$sub_total = $item['Item']['price'] * $cabinet_item['item_quantity'];
														$total_quote_price_cabinet += $sub_total;
														echo $this->Util->formatCurrency($sub_total);
														?>
													</td>
												</tr>-->
												<?php
//											}
//										}
//									}
//								}
//							}
							?>
							<tr style="border-bottom: 1px solid #acacac;" valign="top">
                <td class="text-left quantity" >&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-right price">&nbsp;</td>
                <td class="text-right price">&nbsp;</td>
              </tr>
              <tr valign="top">
                <td class="text-left quantity" >&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td style="width: 120px!important;" class="text-right price"><b>Cabinet Total:</b> </td>
                <td class="text-right price bold"><?php echo "$" . $this->Util->formatCurrency($total_quote_price_cabinet); ?></td>
              </tr>
							
							<tr style="border-bottom: 1px solid #acacac;" valign="top">
								<td style="width: 80px;" class="text-left quantity">Extra / Accessories</td>
							</tr>
						<?php
							if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
								App::import("Model", "Inventory.Cabinet");
								App::import("Model", "Inventory.Item");
								foreach( $quote['CabinetOrder'] as $cabinet_order ) {
									$cabinet = new Cabinet();
									$item_model = new Item();
									$resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
									switch( $cabinet_order['resource_type'] ) {
										case 'cabinet':
											$resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));
											$resource_detail['Resource']['name'] = $resource_detail['Cabinet']['name'];
											$resource_detail['Resource']['description'] = $resource_detail['Cabinet']['description'];
											$cabinets[] = $resource_detail;
											break;
										
										case 'item':
											$resource_detail = $item_model->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
											$resource_detail['Resource']['name'] = $resource_detail['Cabinet'][0]['name'];
											$resource_detail['Resource']['description'] = $resource_detail['Cabinet'][0]['description'];
											$cabinets[] = $resource_detail;
											//pr($cabinets);
											break;
										
										default:
											break;
									};//pr($resource_detail);
									if( (isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) && ($cabinet_order['resource_type'] == 'cabinet')) ) {
										foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
											if( $cabinet_item['accessories'] ) { // show accessories only
												?>
												<tr valign="top">
													<td class="text-left quantity" ><?php echo $cabinet_item['item_quantity']; ?></td>
													<td class="text-left small">
														<?php
														$item = $this->InventoryLookup->ItemDetail($cabinet_item['item_id']);
														echo $item['Item']['item_title'];
														?>
													</td>
													<td class="text-left"><?php echo $item['Item']['description']; ?></td>
													<td class="text-left small">&nbsp;</td>
													<td class="text-left small">&nbsp;</td>
													<td class="text-left small">&nbsp;</td>
													<td class="text-right price">&nbsp;<?php //echo $this->Util->formatCurrency($item['Item']['price']); ?></td>
													<td class="text-right price">
														<?php
														$sub_total_accessories = $item['Item']['price'] * $cabinet_item['item_quantity'];
														$extra_total += $sub_total_accessories;
														//echo $this->Util->formatCurrency($sub_total_accessories);
														?>
													</td>
												</tr>
												<?php
											}
										}
									}
									if(isset($resource_detail['Item']['Department']) && $cabinet_order['resource_type'] == 'item' ){
									?>
									<tr valign="top">
											<td class="text-left quantity" ><?php echo $cabinet_order['quantity']; ?></td>
											<td class="text-left small">
												<?php
												$item = $this->InventoryLookup->ItemDetail($resource_detail['Item']['id']);
												echo $item['Item']['item_title'];
												?>
											</td>
											<td class="text-left"><?php echo $item['Item']['description']; ?></td>
											<td class="text-left small">&nbsp;</td>
											<td class="text-left small">&nbsp;</td>
											<td class="text-left small">&nbsp;</td>
											<td class="text-right price">&nbsp;<?php //echo $this->Util->formatCurrency($item['Item']['price']); ?></td>
											<td class="text-right price">
												<?php
												$sub_total_accessories = $resource_detail['Item']['price'] * $cabinet_order['quantity'];
												$extra_total += $sub_total_accessories;
												//echo $this->Util->formatCurrency($sub_total_accessories);
												?>
											</td>
										</tr>	
									<?php		
									}
								}
							}?>
							<tr style="border-bottom: 1px solid #acacac;" valign="top"></tr>
							<tr valign="top">
								<td class="text-left quantity" >&nbsp;</td>
								<td class="text-left small">&nbsp;</td>
								<td class="text-left">&nbsp;</td>
								<td class="text-left small">&nbsp;</td>
								<td class="text-left small">&nbsp;</td>
								<td class="text-left small">&nbsp;</td>
								<td class="text-right price"><b>Extra Total:</b> </td>
								<td class="text-right price bold"><?php echo "$" . $this->Util->formatCurrency($extra_total); ?></td>
							</tr>
							<tr style="border-bottom: 1px solid #acacac;" valign="top"></tr>
<!---------------------------------------------------------------------------------------------------------------------------------------->
							<?php
							if( ($quote['Quote']['installation'] == 'We Installed') && !empty($cabinets) && is_array($cabinets) ) {
								$installation_summery_list = array( );

								foreach( $cabinets as $cabinet ) {
									if( !empty($cabinet['CabinetInstallation']) && is_array($cabinet['CabinetInstallation']) ) {
										foreach( $cabinet['CabinetInstallation'] as $installation ) {
											if( isset($installation_summery_list[$installation['name']]['quantity']) ) {
												$installation_summery_list[$installation['name']]['quantity']++;
											}
											else {
												$installation_summery_list[$installation['name']]['name'] = $installation['name'];
												$installation_summery_list[$installation['name']]['price_unit'] = $installation['price_unit'];
												$installation_summery_list[$installation['name']]['price'] = $installation['price'];
												$installation_summery_list[$installation['name']]['quantity'] = 1;
											}
										}
									}
								}

								if( !empty($installation_summery_list) ) {
									foreach( $installation_summery_list as $installation ) {
										?>
<!--			                    <tr valign="top">
			                      <td class="text-left quantity" ><?php echo $installation['quantity']; ?></td>
			                      <td class="text-left small"><?php echo $installation['name']; ?> (<?php echo $installation['price_unit']; ?>)</td>
			                      <td class="text-left">&nbsp;</td>
			                      <td class="text-left small">&nbsp;</td>
			                      <td class="text-left small">&nbsp;</td>
			                      <td class="text-left small">&nbsp;</td>
			                      <td class="text-right price"><?php echo $this->Util->formatCurrency($installation['price']); ?> </td>
			                      <td class="text-right price">
										<?php
										$sub_total = $installation['price'] * $installation['quantity'];
										$total_quote_price_installation += $sub_total;
										echo $this->Util->formatCurrency($sub_total);
										?>
			                      </td>
			                    </tr>-->
										<?php
									}
								}
							}
							?>
              <tr valign="top">
                <td class="text-left quantity" >&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td style="width: 165px;" class="text-right price"><b>Installation Total:</b></td>
                <td class="text-right price bold"><?php echo $this->Util->formatCurrency($total_quote_price_installation); ?></td>
              </tr>
              <tr valign="top">
                <td class="text-left quantity" >&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-right price"><b>Sub Total:</b> </td>
                <td class="text-right price bold">
									<?php
									$total_quote_price = $total_quote_price_cabinet + $total_quote_price_installation;
									echo $this->Util->formatCurrency($total_quote_price);
									?>
                </td>
              </tr>
              <tr valign="top">
                <td class="text-left quantity" >&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-right price"><b>Discount:</b></td>
                <td class="text-right price bold">
									<?php
									if( $quote['Quote']['delivery'] == '5 – 10 Weeks Delivery' ) {
										$total_quote_price_discount = $total_quote_price * 0.25;	// 25% discount for late delivery
									}
									echo $this->Util->formatCurrency($total_quote_price_discount);
									?>
                </td>
              </tr>
              <tr valign="top">
                <td class="text-left quantity" >&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-left small">&nbsp;</td>
                <td class="text-right price"><b>Total: </b></td>
                <td class="text-right price bold">
									<?php
									$total_quote_price -= $total_quote_price_discount;
									$total_quote_price += $extra_total;
									echo $this->Util->formatCurrency($total_quote_price);
									?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </fieldset>
    </div>
  </fieldset>
</div>
