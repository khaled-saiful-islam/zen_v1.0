<?php
//debug($purchaseOrder);
$gst = $this->InventoryLookup->findGST();
$pst = $this->InventoryLookup->FindPST();

if(!empty($purchaseOrder['PurchaseOrder']['quote_id']))
  $quote = $this->InventoryLookup->QuoteForView($purchaseOrder['PurchaseOrder']['quote_id']);

if ($section == "work-order-po") {
  $all_items = $this->InventoryLookup->ListQuoteItems($purchaseOrder['Quote']['id']);
  $all_items = $this->InventoryLookup->AdjustPOItem($all_items);
  //debug($all_items);
  $main_item_list = $all_items['quantity_list'];
  $price_list = $all_items['price_list'];
  $title_list = $all_items['title_list'];
  $name_list = $all_items['name_list'];
  $restrictedSupplier = $this->InventoryLookup->RestrictedSupplierOfPO($work_id);

  $supplier_list = $this->InventoryLookup->SupplierAndItemInfo();
//  foreach ($restrictedSupplier as $supplier) {
//    unset($supplier_list[$supplier]);
//  }
  ?>
  <script type="text/javascript">
        
    supplier_info = <?php echo json_encode($supplier_list); ?>;
    quantity_info = <?php echo json_encode($main_item_list); ?>;
    price_info = <?php echo json_encode($price_list); ?>;
    title_info = <?php echo json_encode($title_list); ?>;
    item_name_info = <?php echo json_encode($name_list); ?>;

  </script>
  <?php
} else {
  $all_items = $this->InventoryLookup->ListAllTypesOfItems();
  $main_item_list = $all_items['main_list'];
  $price_list = $all_items['price_list'];
  $title_list = $all_items['title_list'];
}
?>

<?php $item_total_cost = 0; ?>
<div class="suppliers form">
  <?php
  //debug($edit);
  echo $this->Form->create('PurchaseOrder', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit purchase-order-form'));
  ?>
  <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $purchaseOrder['PurchaseOrder']['id'])); ?>
  <fieldset>
    <?php if ($edit) { ?>
      <legend class="edit-legend" >Edit Purchase Order</legend>
    <?php } else { ?>
      <legend >Add Purchase Order</legend>
    <?php } ?>
    <table class='table-form-big po-supplier-table-mid-width'>
      <tbody>
        <tr>
          <th><label for="PurchaseOrderSupplierId">Supplier: </label></th>
          <td colspan="2">
            <?php echo $this->Form->input('supplier_id', array('placeholder' => 'Name', 'class' => 'medium-input-select required form-select supplier-select', "options" => $this->InventoryLookup->Supplier(), 'empty' => true, 'readonly' => 'readonly')); ?>
						<a style="margin-left: 5px; position: relative; top: -8px; " href="javascript: toggle('search_div')"><i class='icon-exclamation-sign icon-black'></i></a>
          </td>

          <th><label for="PurchaseOrderOrderCategory">PO Number: </label></th>
          <td colspan="3">
            <?php echo $this->Form->input('purchase_order_num', array('readonly' => true)); ?>
            <?php echo $this->Form->input('quote_id', array('type' => 'hidden')); ?>
            <?php echo $this->Form->input('work_order_id', array('type' => 'hidden')); ?>
          </td>        
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
            <?php echo $purchaseOrder['Supplier']['name']; ?>
          </td>
          <th><label>E-mail: </label></th>
          <td class="supplier_email">
            <?php echo $purchaseOrder['Supplier']['email']; ?>
          </td>
        </tr>
        <tr>
          <th><label>Phone: </label></th>
          <td class="supplier_phone">
            <?php echo $this->InventoryLookup->phone_format($purchaseOrder['Supplier']['phone'], $purchaseOrder['Supplier']['phone_ext'], $purchaseOrder['Supplier']['cell'], $purchaseOrder['Supplier']['fax_number']); ?>
          </td>
          <th><label>Address: </label></th>
          <td class="supplier_address">
            <?php echo $this->InventoryLookup->address_format($purchaseOrder['Supplier']['address'], $purchaseOrder['Supplier']['city'], $purchaseOrder['Supplier']['province'], $purchaseOrder['Supplier']['country'], $purchaseOrder['Supplier']['postal_code']); ?>
          </td>
        </tr>          
      </tbody>
    </table>
			<?php //pr($purchaseOrder); ?>
		<table class="table-form-big table-form-big-margin" style="min-width: 890px;">
      <tbody>   
      <th colspan="4">
        <label class="table-data-title"><?php echo __("Job Order Information"); ?></label>
      </th>
      <tr>
        <th><label for="SupplierGstRate">Work Order No: </label></th>
        <td class="quote-title">          
          <?php echo $purchaseOrder['PurchaseOrder']['purchase_order_num']; ?>
        </td> 
        <th><label for="SupplierFirstName">Sales Persons: </label></th>
        <td colspan="2">
					<?php 
						$sales = unserialize($purchaseOrder['Quote']['sales_person']); 
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
          echo $this->InventoryLookup->address_format($purchaseOrder['Quote']['address'], $purchaseOrder['Quote']['city'], $purchaseOrder['Quote']['province'], $purchaseOrder['Quote']['country'], $purchaseOrder['Quote']['postal_code']);
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
          <th colspan="3">
<!--            <label class="table-data-title">Payment Information</label>-->
          </th>
        </tr>
				<tr>
          <th><label for="PurchaseOrderOrderName">Location: </label></th>
          <td>
            <?php echo $this->Form->input('location_name', array('class' => 'input-medium form-select location_name', 'options' => $workOrder = $this->InventoryLookup->getLocation())); ?>
          </td>
        </tr>
        <tr>
          <th><label for="PurchaseOrderOrderName">Name: </label></th>
          <td>
            <?php echo $this->Form->input('name_ship_to', array('placeholder' => 'Name', 'class' => '')); ?>
          </td>
        </tr>
				<tr>
          <th rowspan="3">
            <label for="PurchaseOrderOrderAddress">Address: </label>
          </th>
          <td colspan="2">            
            <?php echo $this->Form->input('address', array('placeholder' => 'Address', 'class' => 'vendor_address wide-input')); ?>
          </td>
					<th rowspan="3"><label for="PurchaseOrderOrderPhone">Phone: </label></th>
          <td>
            <label class="wide-width">Phone:</label>
            <?php echo $this->Form->input('phone', array('placeholder' => 'Phone', 'class' => 'phone-mask vendor_phone input-medium phone-mask')); ?>
          </td>
          <td class="width-min">
            <label class="wide-width">Extension:</label>
            <?php echo $this->Form->input('phone_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>
            &nbsp;
          </td>
        </tr>
				<tr>
          <td class="width-min">
            <label class="wide-width">City:</label>
            <?php echo $this->Form->input('city', array('placeholder' => 'City', 'class' => 'vendor_city input-medium')); ?>
          </td>
          <td>
            <label class="wide-width">Province:</label>
            <?php echo $this->Form->input('province', array('placeholder' => 'Province', 'style' => 'width:120px;')); ?>            
          </td>
					<td colspan="2">
            <label class="wide-width">Cell:</label>
            <?php echo $this->Form->input('cell', array('placeholder' => 'Cell', 'class' => 'phone-mask input-medium phone-mask')); ?>            
          </td>
        </tr>  
        <tr>
          <td class="width-min">
            <label class="wide-width">Postal Code:</label>
            <?php echo $this->Form->input('postal_code', array('placeholder' => 'Postal Code', 'class' => 'vendor_postal_code input-medium')); ?>
          </td>
          <td>
            <label class="wide-width">Country:</label>
            <?php echo $this->Form->input('country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => 'input-small')); ?>
          </td>
					<td colspan="2">
            <label class="wide-width">Fax:</label>
            <?php echo $this->Form->input('fax', array('placeholder' => 'Fax', 'class' => 'phone-mask vendor_fax phone-mask input-medium')); ?>
          </td> 
        </tr>		
				<tr>
					<th>
						<label>Shipping Date: </label>
						<label class="wide-width-date">(dd/mm/yyyy)</label>
					</th>
					<td colspan="2">
					<?php echo $this->Form->input('shipment_date', array('placeholder' => 'DD/MM/YYYY', 'value' => $this->Util->formatDate($purchaseOrder['PurchaseOrder']['shipment_date']), 'type' => 'text', 'class' => 'dateP required')); ?>
					</td>  
					<th>
						<label for="SupplierGstRate">Issued On </label>
						<label class="wide-width-date">(dd/mm/yyyy)</label>
					</th>
					<td><?php echo $this->Form->input('issued_on', array('class' => 'input-medium', 'value' => $this->Util->formatDate($purchaseOrder['PurchaseOrder']['issued_on']), 'placeholder' => 'DD/MM/YYYY', 'type' => 'text', 'readonly' => 'readonly')); ?></td>    
				</tr>
        <tr>
          <th>
            <label>F.O.B Point: </label>
          </th>
          <td colspan="2">
            <?php echo $this->Form->input('f_o_b_point', array('placeholder' => 'F.O.B Point', 'class' => '')); ?>
          </td>          
          <th><label for="SupplierGstRate">Issued By </label></th>          
					<td>
            <?php
						$user_name = $this->InventoryLookup->findUserName($purchaseOrder['PurchaseOrder']['issued_by']);
						echo $user_name;
            ?>
          </td>
        </tr>
        <tr>
          <th><label>Ship via: </label></th>
          <td colspan="2">
            <?php echo $this->Form->input('shipment_via', array('placeholder' => 'Ship via', 'class' => '')); ?>
          </td>
          <th><label for="SupplierNotes">Notes: </label></th>
          <td><?php echo $this->Form->input('note', array('rows' => 2, 'cols' => 45)); ?></td>
        </tr>
        <tr>
          <th><label>Terms </label></th>
          <td>
            <?php echo $this->Form->input('term', array('placeholder' => 'Terms', 'class' => '')); ?>
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
					<th style="width: 45px;"><label for="SupplierNotesOnPo">Payment Type: </label></th>
					<td>
					<?php echo $this->Form->input('payment_type', array('placeholder' => 'Payment Type','class' => 'input-medium p_method form-select required', 'options' => $this->InventoryLookup->getPaymentType(), 'empty' => true)); ?>
					</td>
				</tr>
				<tr id="PoPayName" style="display: none;">
					<th><label>Name:</label></th>
					<td>
					<?php echo $this->Form->input('name_cc', array('placeholder' => 'Name', 'class' => 'input-medium')); ?>
					</td>
				</tr>
				<tr id="PoCC" style="display: none;">
					<th>
					<label>CC#:</label>
					</th>
					<td>
					<?php echo $this->Form->input('cc_num', array('placeholder' => 'CC#', 'class' => 'input-medium')); ?>
					</td>
				</tr>
				<tr id="PoExpiryDate" style="display: none;">
					<th>
					<label>Expiry:</label>
					<label class="wide-width-date">(dd/mm/yyyy)</label>
					</th>
					<td>
					<?php echo $this->Form->input('expiry_date', array('placeholder' => 'DD/MM/YYYY', 'value' => $this->Util->formatDate($purchaseOrder['PurchaseOrder']['expiry_date']), 'class' => 'input-medium dateP', 'type' => 'text')); ?>
					</td>
				</tr>
			</tbody>	
		</table>
  </fieldset>

  <div class="item-row-po">
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>
          <th>Code</th>
          <th>Description</th> 
          <th class="text-center">Quantity</th>                   
          <th class="text-center">Each Cost</th>
          <th class="text-center">Total Cost</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
          <td>
            <?php
            echo $this->Form->input("PurchaseOrderItem.-1.item_id", array("type" => "hidden", "class" => "item_id user-input"));
            echo $this->Form->input("PurchaseOrderItem.-1.purchase_order_id", array("type" => "hidden", "class" => "purchase_order_id user-input"));
            echo $this->Form->input("PurchaseOrderItem.-1.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
            echo $this->Form->input("PurchaseOrderItem.-1.door_id", array("type" => "hidden", "class" => "door_id user-input"));

            echo $this->Form->input("PurchaseOrderItem.-1.code", array(
                "class" => "code user-input",
                "placeholder" => "Code",
                "label" => false,
                "type" => "hidden"
            ));

            $code = '';
            if (isset($this->data['PurchaseOrderItem'][0]['code'])) {
              $code = $main_item_list[$this->data['PurchaseOrderItem'][0]['code']];
            }
            echo "<span class='data-code'>{$code}</span>";
            ?>
          </td>
          <td>
            <span class='data-title'></span>
          </td>
          <td class="text-center">
            <?php
            echo $this->Form->input("PurchaseOrderItem.-1.quantity", array(
                "class" => "quantity user-input",
                "placeholder" => "Quantity",
                "label" => false,
                "type" => "hidden"
            ));

            $quantity = '';
            if (isset($this->data['PurchaseOrderItem'][0]['quantity'])) {
              $quantity = $this->data['PurchaseOrderItem'][0]['quantity'];
            }
            echo "<span class='data-quantity'>{$quantity}</span>";
            ?>
          </td>
          <td class="text-right">
            <?php
            echo "<span class='data-each-cost'></span>";
            ?>
          </td>
          <td class="text-right">
            <?php
            echo "<span class='data-per-item-total-cost'></span>";
            ?>            
          </td>
          <td>
            <a href="#" class="icon-remove hide remove"></a>
          </td
        </tr>
        <?php
//debug($title_list);
        if (!empty($this->data['PurchaseOrderItem'])) {
          //$item_total_cost = 0;
          foreach ($this->data['PurchaseOrderItem'] as $index => $value) {
//            if ($index == 0)
//              continue; // skip the first 1 as it is already in place
            ?>
            <tr class="clone-row">
              <td>
                <?php
                echo $this->Form->input("PurchaseOrderItem.{$index}.purchase_order_id", array("type" => "hidden", "class" => "purchase_order_id user-input"));
                echo $this->Form->input("PurchaseOrderItem.{$index}.item_id", array("type" => "hidden", "class" => "item_id user-input"));
                echo $this->Form->input("PurchaseOrderItem.{$index}.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
                echo $this->Form->input("PurchaseOrderItem.{$index}.door_id", array("type" => "hidden", "class" => "door_id user-input"));

                echo $this->Form->input("PurchaseOrderItem.{$index}.code", array(
                    "class" => "code user-input",
                    "placeholder" => "Code",
                    "label" => false,
                    "type" => "hidden"
                ));

                echo "<span class='data-code'>{$name_list[$this->data['PurchaseOrderItem'][$index]['code']]}</span>";
                ?>
              </td> 
              <td>
                <?php
                //echo $index;
                echo "<span class='data-title'>{$title_list[$this->data['PurchaseOrderItem'][$index]['code']]}</span>";
                ?>
              </td>
              <td class="text-center">
                <?php
                echo $this->Form->input("PurchaseOrderItem.{$index}.quantity", array(
                    "class" => "quantity user-input",
                    "placeholder" => "Quantity",
                    "label" => false,
                    "type" => "hidden"
                ));

                echo "<span class='data-quantity'>{$this->data['PurchaseOrderItem'][$index]['quantity']}</span>";
                ?>
              </td> 
              <td class="text-right">
                <?php
                $each_cost = $price_list[$this->data['PurchaseOrderItem'][$index]['code']];
                echo "<span class='data-each-cost'>{$each_cost}</span>";
                ?>                
              </td>
              <td class="text-right">
                <?php
                $per_item_total_cost = number_format($each_cost * $this->data['PurchaseOrderItem'][$index]['quantity'], 2, '.', '');
                
                $item_total_cost += $per_item_total_cost;
                echo "<span class='data-per-item-total-cost'>{$per_item_total_cost}</span>";
                ?>                
              </td>
              <td>
                <a href="#" class="icon-remove remove"></a>
              </td>
            </tr>
            <?php
          }
          ?>
          <tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Subtotal:</td>
            <td class="text-right">
              <span class='data-item-total-cost'><?php echo number_format($item_total_cost, 2, '.', ''); ?></span>
							<?php echo $this->Form->input('order_subtotal', array('id' => 'row_remove_item','class' => 'input-small order_sub_total', 'value' => $item_total_cost, 'type' => 'hidden')); ?>
						</td>
            <td>&nbsp;</td>
          </tr>
					<tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Shipping & Handling:</td>
            <td class="text-right">
							<?php echo $this->Form->input('shipping_handling', array('class' => 'input-small shipping')); ?>
            </td>
            <td>&nbsp;</td>
          </tr>
					<tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Taxes GST:</td>
            <td class="text-right">
							<?php echo $this->Form->input('tax_gst', array('class' => 'input-small po_gst', 'value' => $gst, 'type' => 'hidden')); ?>
              <span><?php echo $gst."%"; ?></span>	
            </td>
            <td>&nbsp;</td>
          </tr>
					<tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Taxes PST:</td>
            <td class="text-right">
							<?php echo $this->Form->input('tax_pst', array('class' => 'input-small po_pst', 'value' => $pst, 'type' => 'hidden')); ?>
              <span><?php echo $pst."%"; ?></span>	
            </td>
            <td>&nbsp;</td>
          </tr>
					<tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Total Amount:</td>
            <td class="text-right">
              <?php echo $this->Form->input('total_amount', array('class' => 'input-small total_amount_for_po', 'readonly' => 'readonly')); ?>
            </td>
            <td>&nbsp;</td>
          </tr>
          <?php
        } else {
          ?>
          <tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Total:</td>
            <td class="text-right">
              <span class='data-item-total-cost' >0.00</span>	
            </td>
            <td>&nbsp;</td>
          </tr>
        <?php } ?>
        <tr>
          <td colspan="5">
            <input type="button" class="btn btn-info add-more" value="Add Item" />	
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>        
  </div>

  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', array('plugin' => 'work_order_manager', 'controller' => 'work_orders', 'action' => 'detail_section', $work_id, $section), array('data-target' => '#work-order-po-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>
<div id="add_order_item_po" class="modal hide fade modal-width" data-backdrop="false" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="add_item_label">Add Item</h3>
  </div>
  <div class="modal-body">
    <form>
      <table class="table-form-big">
        <tr>
          <th>
            <label class="label-text">Item Number:</label> &nbsp;
          </th>
          <td>          
            <?php echo $this->Form->input("code", array("type" => "select", 'placeholder' => 'Item Number', 'empty' => true, 'options' => $name_list, "class" => "form-select required po-code user-input")); ?>
          </td>
          <th>
            <label class="label-text">Quantity:</label> &nbsp;
          </th>
          <td>
            <input placeholder="Quantity" class="quantity required number" type='text' />
          </td>            
        </tr>
        <tr>
          <th>
            <label class="label-text">Item Description:</label> &nbsp;
          </th>
          <td>  
            <input id="item_description" name="item_description" placeholder="Item Description" readonly="readonly" class="item-description" type='text' />
            <?php echo $this->Form->input("description", array("type" => "select", 'options' => $title_list, "class" => "description user-input", 'style' => 'display:none')); ?>
          </td>
          <th>
            <label class="label-text">Price:</label> &nbsp;
          </th>
          <td>   
            <input id="item_price" name="item_price" placeholder="Item Price" readonly="readonly" class="item-price" type='text' />
            <?php echo $this->Form->input("price", array("type" => "select", 'options' => $price_list, "class" => "price user-input", 'style' => 'display:none')); ?>
          </td>
        </tr>

      </table>
    </form>
  </div>
  <div class="modal-footer">
    <button class="save btn btn-primary">Add</button>
  </div>
</div>
<script type="text/javascript">
	$('.p_method').bind("change",function(){
		var val = $(this).val();
		if(val=='Credit Card'){
			$("#PoPayName").show();
			$("#PoCC").show();
			$("#PoExpiryDate").show();
		}
		if(val=='Cheque'){
			$("#PoPayName").hide();
			$("#PoCC").hide();
			$("#PoExpiryDate").hide();
		}
		if(val=='On Account'){
			$("#PoPayName").hide();
			$("#PoCC").hide();
			$("#PoExpiryDate").hide();
		}
		if(val=='Cash'){
			$("#PoPayName").hide();
			$("#PoCC").hide();
			$("#PoExpiryDate").hide();
		}
	});
	
	$('.shipping').bind("change", function(){
		var amount = 0;
		
		var ship = parseFloat($(this).val());
		var sub = parseFloat($('.order_sub_total').val());
		var gst = parseFloat($('.po_gst').val());
		var pst = parseFloat($('.po_pst').val());
		
		var real_gst = parseFloat(sub * (gst/100));
		var real_pst = parseFloat(sub * (pst/100));
		
		amount = ship + sub + real_gst + real_pst;
		$('#total_amount_for_item').html(amount.toFixed(2));
		$('.total_amount_for_po').val(amount.toFixed(2));
	});
	
	$('.location_name').bind("change", function(){
		var location_id = $(this).val();
		ajaxStart();
		$.ajax({
        url: '<?php
              echo $this->Util->getURL(array(
                  'controller' => "purchase_orders",
                  'action' => 'getLocationData',
                  'plugin' => 'purchase_order_manager',
              ))
              ?>/'+location_id,
        type: 'POST',
        data: '',
        dataType: "json",
        success: function( response ) {
					$("#PurchaseOrderNameShipTo").val(response.GeneralSetting.name_address);
          $("#PurchaseOrderAddress").val(response.GeneralSetting.address);
          $("#PurchaseOrderCity").val(response.GeneralSetting.city);
          $("#PurchaseOrderProvince").val(response.GeneralSetting.province);
					$("#PurchaseOrderPostalCode").val(response.GeneralSetting.postal_code);
					$("#PurchaseOrderCountry").val(response.GeneralSetting.country);
          ajaxStop();
        }
      });
	});
  $(".purchase-order-form").validate({ignore: null});
  $(".purchase-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#work-order-po-list'});
</script>
