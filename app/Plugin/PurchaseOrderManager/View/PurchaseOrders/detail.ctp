<?php
	$gst = $this->InventoryLookup->findGST();
	$pst = $this->InventoryLookup->FindPST();
?>
<?php if ($modal) { ?>
  <?php
  echo $this->element('Detail/PurchaseOrder/purchase-modal-detail');
  ?>
<?php } else { ?>
  <div class="itemDepartments view">
    <fieldset class="content-detail">
      <legend>
        <?php echo __('Purchase Order'); ?>:&nbsp;<?php echo h($purchaseorder['PurchaseOrder']['purchase_order_num']); ?>
        <div class="report-buttons">
          <?php
            
          if (!empty($purchaseorder['Invoice']['id'])) {
            echo $this->Html->link(
                    '', array('plugin' => 'invoice_manager', 'controller' => 'invoices', 'action' => DETAIL, $purchaseorder['Invoice']['id']), array('class' => 'icon-folder-close ajax-sub-content', 'data-target' => '#MainContent', 'title' => 'Invoice Detail Information')
            );
          } else {
            echo $this->Html->link(
                    '', array('plugin' => 'invoice_manager', 'controller' => 'invoices', 'action' => ADD, $purchaseorder['PurchaseOrder']['id'], 'Purchase Order'), array('class' => 'icon-folder-close ajax-sub-content', 'data-target' => '#MainContent', 'title' => 'Create Invoice')
            );
          }
          ?>
        </div>
				<div style="float: right; font-size: 12px; margin-top: 20px;">
					<?php	
					echo $this->Html->link(
									'<i class="icon-print icon-black"></i> Purchase Order Preview', array( 'controller' => 'purchase_orders', 'action' => 'print_detail', $purchaseorder['PurchaseOrder']['id'] ), array( 'class' => 'open-link', 'title' => 'Print Detail Information', 'style' => 'margin-left: 15px;margin-right: 15px; float: right;',"escape" => false )
					);
					?>
				</div>
      </legend>
      <div id="item-deparment-information">
        <div class="detail actions">
          <?php
						$wo_status = $this->InventoryLookup->getWOStatus($purchaseorder['PurchaseOrder']['work_order_id']);
						if($wo_status != 1 && $purchaseorder['PurchaseOrder']['received'] != 1)
							echo $this->Html->link('Edit Purchase Order', array('action' => EDIT, $purchaseorder['PurchaseOrder']['id']), array('data-target' => '#item-deparment-information', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit Purchase Order'))); 
					?>
        </div>
        <table class="table-form-big" style="min-width: 586px;">
          <tr>
            <th><?php echo __("Supplier's Name"); ?>:</th>
            <td>
							<?php echo h($purchaseorder['Supplier']['name']); ?>&nbsp;
							<a style="margin-left: 5px; position: relative;" href="javascript: toggle('search_div')"><i class='icon-exclamation-sign icon-black'></i></a>
						</td>
            <th class="wide-width"><?php echo __('Purchase Order Number'); ?>:</th>
            <td><?php echo h($purchaseorder['PurchaseOrder']['purchase_order_num']); ?>&nbsp;</td>
          </tr>
        </table>
				<table id='search_div' style="display:<?= isset($_GET['search']) ? "block" : "none" ?>" class="table-form-big table-form-big-margin po-supplier-table-mid-width">
					<tbody>
						<tr>
							<th colspan="4">
								<label class="table-data-title">Supplier's Information</label>
							</th>
						</tr>
						<tr>
							<th><label>Name: </label></th>
							<td class="supplier_name">
								<?php echo h($purchaseorder['Supplier']['name']); ?>
							</td>
							<th><label>E-mail: </label></th>
							<td class="supplier_email">
								<?php echo h($purchaseorder['Supplier']['email']); ?>
							</td>
						</tr>
						<tr>
							<th><label>Phone: </label></th>
							<td class="supplier_phone">
								<?php echo h($purchaseorder['Supplier']['phone'])." "."Ext: ".h($purchaseorder['Supplier']['phone_ext']); ?>
							</td>
							<th><label>Address: </label></th>
							<td class="supplier_address">
								<?php echo $this->InventoryLookup->address_format($purchaseorder['Supplier']['address'], $purchaseorder['Supplier']['city'], $purchaseorder['Supplier']['province'], $purchaseorder['Supplier']['country'], $purchaseorder['Supplier']['postal_code']); ?>
							</td>
						</tr>          
					</tbody>
				</table>
				
				<table class="table-form-big table-form-big-margin" style="min-width: 890px;">
					<tbody>   
					<th colspan="4">
						<label class="table-data-title"><?php echo __("Job Order Information"); ?></label>
					</th>
					<tr>
						<th class="width-change"><label for="SupplierGstRate">Work Order No: </label></th>
						<td class="quote-title">          
							<?php echo $purchaseorder['WorkOrder']['work_order_number']; ?>
						</td> 
						<th class="width-change"><label for="SupplierFirstName">Sales Persons: </label></th>
						<td colspan="2">
							<?php 
								$sales = unserialize($purchaseorder['Quote']['sales_person']); 
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
						<th><label for="PurchaseOrderOrderAddress">Address: </label></th>
						<td colspan="3" class="quote-address">
							<?php
							echo $this->InventoryLookup->address_format($purchaseorder['Quote']['address'], $purchaseorder['Quote']['city'], $purchaseorder['Quote']['province'], $purchaseorder['Quote']['country'], $purchaseorder['Quote']['postal_code']);
							?>
						</td>
					</tr>      
					</tbody>
				</table>
				
				<table class='table-form-big table-form-big-margin' style="min-width: 890px;">
					<tbody>      
						<tr>
							<th colspan="3">
								<label class="table-data-title">Shipping To Information</label>
							</th>
							<th colspan="3"></th>
						</tr>
						<tr>
							<th><label for="PurchaseOrderOrderName">Location: </label></th>
							<td>
								<?php echo $this->InventoryLookup->getDefaultLocaltionName($purchaseorder['PurchaseOrder']['location_name']); ?>
							</td>
						</tr>
						<tr>
							<th><label for="PurchaseOrderOrderName">Name: </label></th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['name_ship_to']; ?>
							</td>
						</tr>
						<tr>
							<th>
								<label for="PurchaseOrderOrderAddress">Address: </label>
							</th>
							<td>            
								<?php echo $this->InventoryLookup->address_format($purchaseorder['PurchaseOrder']['address'], $purchaseorder['PurchaseOrder']['city'], $purchaseorder['PurchaseOrder']['province'], $purchaseorder['PurchaseOrder']['country'], $purchaseorder['PurchaseOrder']['postal_code']); ?>
							</td>
							<th><label for="PurchaseOrderOrderPhone">Phone: </label></th>
							<td>
								<?php echo $this->InventoryLookup->phone_format($purchaseorder['PurchaseOrder']['phone'], $purchaseorder['PurchaseOrder']['phone_ext'], $purchaseorder['PurchaseOrder']['cell'], $purchaseorder['PurchaseOrder']['fax']); ?>
							</td>
						</tr>        
						<tr>
							<th>
								<label>Shipping Date: </label>
								<label>(dd/mm/yyyy)</label>
							</th>
							<td>
							<?php echo $this->Util->formatDate($purchaseorder['PurchaseOrder']['shipment_date']); ?>
							</td>  
							<th>
								<label for="SupplierGstRate">Issued On </label>
								<label>(dd/mm/yyyy)</label>
							</th>
							<td><?php echo $this->Util->formatDate($purchaseorder['PurchaseOrder']['issued_on']); ?></td>    
						</tr>
						<tr>
							<th>
								<label>F.O.B Point: </label>
							</th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['f_o_b_point']; ?>
							</td>          
							<th><label for="SupplierGstRate">Issued By </label></th>
							<td>
								<?php
								$user_name = $this->InventoryLookup->findUserName($loginUser['id']);
								echo $user_name;
								?>
							</td>
						</tr>
						<tr>
							<th><label>Ship via: </label></th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['shipment_via']; ?>
							</td>
							<th><label for="SupplierNotes">Notes: </label></th>
							<td><?php echo $purchaseorder['PurchaseOrder']['note']; ?></td>
						</tr>
						<tr>
							<th><label>Terms </label></th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['term']; ?>
							</td>
						</tr>
					</tbody>
				</table>
				<table class='table-form-big table-form-big-margin' style="min-width: 890px;">
					<tbody>      
						<tr>
							<th colspan="3">
								<label class="table-data-title">Payment Information</label>
							</th>
						</tr>
						<tr>
							<th><label for="SupplierNotesOnPo">Payment Type: </label></th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['payment_type']; ?>
							</td>
						</tr>
						<?php if($purchaseorder['PurchaseOrder']['payment_type'] == 'Credit Card'){ ?>
						<tr>
							<th><label>Name:</label></th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['name_cc']; ?>
							</td>
						</tr>
						<tr>
							<th>
							<label>CC#:</label>
							</th>
							<td>
								<?php echo $purchaseorder['PurchaseOrder']['cc_num']; ?>
							</td>
						</tr>
						<tr>
							<th>
							<label>Expiry:</label>
							<label>(dd/mm/yyyy)</label>
							</th>
							<td>
								<?php echo $this->Util->formatDate($purchaseorder['PurchaseOrder']['expiry_date']); ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>	
				</table>

        <?php $order_items = $this->InventoryLookup->PurchaseOrderItem($purchaseorder['PurchaseOrder']['id']); ?>
        <table class="table table-bordered table-hover listing">
          <thead>
            <tr class="grid-header">
              <th>Quantity</th>
              <th>Number</th>
              <th>Description</th>
              <th>Each Cost</th>
              <th>Total Cost</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sub_total = 0;
            $item_total_cost = 0.00;
            foreach ($order_items as $order_item) {
              $item_info = explode('|', $order_item['PurchaseOrderItem']['code']);
              $item_type = $item_info[1];
              ?>
              <?php //pr($order_item);  ?>
              <tr>
                <td>
                  <?php echo h($order_item['PurchaseOrderItem']['quantity']); ?>
                </td>
                <td>
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

                <td>
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
                <td style="text-align: right;">
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
                <td style="text-align: right;">
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
            ?>
						<tr>
							<td colspan="4" style="text-align: right;"><b>Subtotal:</b></td>
							<td style="width: 70px; text-align: right; border-top: 2px solid black;"><?php echo number_format($sub_total, 2); ?></td>
						</tr>
						<tr>
							<td colspan="4" style="text-align: right;"><b>Shipping & Handling:</b></td>
							<td style="width: 70px; text-align: right;"><?php echo $purchaseorder['PurchaseOrder']['shipping_handling']; ?></td>
						</tr>
						<tr>
							<td colspan="4" style="text-align: right;"><b>Taxes GST:</b></td>
							<td style="width: 70px; text-align: right;"><?php echo $gst."%"; ?></td>
						</tr>
						<tr>
							<td colspan="4" style="text-align: right;"><b>Taxes PST:</b></td>
							<td style="width: 70px; text-align: right;"><?php echo $pst."%"; ?></td>
						</tr>
						<?php
							$total_amount_po = $sub_total + $sub_total * ($gst / 100) + $sub_total * ($pst / 100);
						?>
						<tr>
							<td colspan="4" style="text-align: right;"><b>Total Amount:</b></td>
							<td style="width: 70px; text-align: right;"><?php echo "<b>".number_format($total_amount_po, 2)."</b>"; ?></td>
						</tr>
          </tbody>
        </table>

      </div>

    </fieldset>    

  </div>
<?php } ?>
<style>
	table.table-form-big tr th{
		width: 100px!important;
	}
</style>