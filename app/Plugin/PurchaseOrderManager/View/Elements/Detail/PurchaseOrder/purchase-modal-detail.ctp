<div id="item-deparment-information"> 
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="add_item_label" style="font-size: 16px;">
			<?php echo __('Purchase Order'); ?>:&nbsp;<?php echo h($purchaseorder['PurchaseOrder']['purchase_order_num']); ?>
    </h3>
  </div>
	<table class="table-form-big table-form-big-margin">
		<tbody>   
		<th colspan="4">
			<label class="table-data-title"><?php echo __("Job Order Information"); ?></label>
		</th>
		<tr>
			<th><label for="SupplierGstRate">Work Order No: </label></th>
			<td class="quote-title">          
				<?php echo $purchaseorder['PurchaseOrder']['purchase_order_num']; ?>
			</td> 
			<th><label for="SupplierFirstName">Sales Persons: </label></th>
			<td colspan="2">
				<?php
				$sales = unserialize($purchaseorder['Quote']['sales_person']);
				$cnt = count($sales);
				$j = 1;
				for( $i = 0; $i < $cnt; $i++ ) {
					$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
					echo $j . ". " . $sales_person['User']['first_name'] . " " . $sales_person['User']['last_name'] . "</br>";
					$j++;
				}
				?>
				&nbsp;
			</td>
		</tr>
<!--		<tr>       
			<th><label for="PurchaseOrderOrderAddress">Address: </label></th>
			<td colspan="3" class="quote-address">
				<?php
				echo $this->InventoryLookup->address_format($purchaseorder['Quote']['address'], $purchaseorder['Quote']['city'], $purchaseorder['Quote']['province'], $purchaseorder['Quote']['country'], $purchaseorder['Quote']['postal_code']);
				?>
			</td>
		</tr>      -->
		</tbody>
	</table>
	
<table class='table-form-big table-form-big-margin'>
	<tbody>      
		<tr>
			<th colspan="4">
				<label class="table-data-title">Shipping To Information</label>
			</th>
		</tr>
		<tr>
			<th><label for="PurchaseOrderOrderName">Location: </label></th>
			<td>
				<?php echo $purchaseorder['PurchaseOrder']['location_name']; ?>
			</td>
			<th>
				<label for="SupplierGstRate">Issued On </label>
				<label class="wide-width-date">(dd/mm/yyyy)</label>
			</th>
			<td><?php echo $this->Util->formatDate($purchaseorder['PurchaseOrder']['issued_on']); ?></td> 
		</tr>
		<tr>
			<th><label for="PurchaseOrderOrderName">Name: </label></th>
			<td>
				<?php echo $purchaseorder['PurchaseOrder']['name_ship_to']; ?>
			</td>
			<th><label for="SupplierGstRate">Issued By </label></th>          
			<td>
				<?php
				$user_name = $this->InventoryLookup->findUserName($purchaseorder['PurchaseOrder']['issued_by']);
				echo $user_name;
				?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="PurchaseOrderOrderAddress">Address: </label>
			</th>
			<td>            
				<?php echo $this->InventoryLookup->address_format($purchaseorder['PurchaseOrder']['address'], $purchaseorder['PurchaseOrder']['city'], $purchaseorder['PurchaseOrder']['province'], $purchaseorder['PurchaseOrder']['country'], $purchaseorder['PurchaseOrder']['postal_code']); ?>
			</td>
			<th><label for="SupplierNotes">Notes: </label></th>
			<td><?php echo $purchaseorder['PurchaseOrder']['note'] ?></td>
		</tr> 		
		<tr>
			<th>
				<label>Shipping Date: </label>
				<label class="wide-width-date">(dd/mm/yyyy)</label>
			</th>
			<td>
			<?php echo $this->Util->formatDate($purchaseorder['PurchaseOrder']['shipment_date']);?>
			</td>  
			<th>
				<label>F.O.B Point: </label>
			</th>
			<td>
				<?php echo $purchaseorder['PurchaseOrder']['f_o_b_point'] ?>
			</td> 
		</tr>
		<tr>
			<th><label>Ship via: </label></th>
			<td>
				<?php echo $purchaseorder['PurchaseOrder']['shipment_via'] ?>
			</td>
			<th><label>Terms </label></th>
			<td>
				<?php echo $purchaseorder['PurchaseOrder']['term'] ?>
			</td>
		</tr>
	</tbody>
</table>
<table class='table-form-big table-form-big-margin'>
	<tbody>      
		<tr>
			<th colspan="4">
				<label class="table-data-title">Payment Information</label>
			</th>
		</tr>
		<tr>
			<th style="width: 45px;"><label for="SupplierNotesOnPo">Payment Type: </label></th>
			<td>
				<?php echo $purchaseorder['PurchaseOrder']['payment_type'] ?>
			</td>
		</tr>
		<?php if($purchaseorder['PurchaseOrder']['payment_type'] == 'Credit Card'){ ?>
		<tr>
			<th><label>Name:</label></th>
			<td>
			<?php echo $this->Form->input('name_cc', array('placeholder' => 'Name', 'class' => 'input-medium')); ?>
			</td>
		</tr>
		<tr>
			<th>
			<label>CC#:</label>
			</th>
			<td>
			<?php echo $this->Form->input('cc_num', array('placeholder' => 'CC#', 'class' => 'input-medium')); ?>
			</td>
		</tr>
		<tr>
			<th>
			<label>Expiry:</label>
			<label class="wide-width-date">(dd/mm/yyyy)</label>
			</th>
			<td>
			<?php echo $this->Form->input('expiry_date', array('placeholder' => 'DD/MM/YYYY', 'value' => $this->Util->formatDate($purchaseOrder['PurchaseOrder']['expiry_date']), 'class' => 'input-medium dateP', 'type' => 'text')); ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>	
</table>
</div>