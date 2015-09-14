<?php
	$randNum = uniqid(rand(100000,999999),true);
	$uni_rand_num = explode('.', $randNum);
?>

<?php $item_total_cost = 0;     ?>
<div class="suppliers form">

    <?php
	$all_items = $this->InventoryLookup->ListAllTypesOfItems();
	$main_item_list = $all_items['main_list'];
	$price_list = $all_items['price_list'];
	$title_list = $all_items['title_list'];
	//pr($all_items);pr($main_item_list);pr($price_list);pr($title_list);
    ?>

    <?php echo $this->Form->create('PurchaseOrder', array( 'inputDefaults' => array( 'label' => false, 'div' => false ), 'class' => 'ajax-form-submit purchase-order-form' )); ?>
    <fieldset>
	<legend <?php if( $edit ) { ?>class="edit-legend"<?php } ?> ><?php echo __($legend); ?></legend>
	<table class='table-form-big'>
	    <tr>
		<th><label for="SupplierEmail">Pick Supplier: </label></th>
		<td><?php echo $this->Form->input('supplier_id', array( 'placeholder' => 'Name', 'class' => 'input-medium test', "options" => $this->InventoryLookup->Supplier(), 'empty' => "--Select--" )); ?></td>
		<th><label for="SupplierFirstName">Order Information: </label></th>
		<td>
		    <?php echo $this->Form->input('order_category', array( 'placeholder' => 'Order / Category', 'class' => 'input-medium', 'options' => $this->InventoryLookup->getOrderInfo(), 'empty' => '--Select--' )); ?>
		</td>
	    </tr>
	    <tr>
		<th><label for="SupplierPhone">Supplier's Info: </label></th>
		<td>
		    <div class="marT5">
			<?php echo $this->Form->input('vendor_name', array( 'placeholder' => 'Name', 'class' => 'input-xlarge vendor_name', "value" => isset($PO['Supplier']['name']) ? $PO['Supplier']['name'] : "" )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('vendor_address', array( 'placeholder' => 'Address', 'class' => 'input-xlarge vendor_address', "value" => isset($PO['Supplier']['address']) ? $PO['Supplier']['address'] : "" )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('vendor_city', array( 'placeholder' => 'City', 'class' => 'input-small vendor_city', "value" => isset($PO['Supplier']['city']) ? $PO['Supplier']['city'] : "" )); ?>
			<?php echo $this->Form->input('vendor_province', array( 'placeholder' => 'Province', 'class' => 'input-small vendor_province', "value" => isset($PO['Supplier']['province']) ? $PO['Supplier']['province'] : "" )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('vendor_phone', array( 'placeholder' => 'Phone', 'class' => 'input-small vendor_phone', "value" => isset($PO['Supplier']['phone']) ? $PO['Supplier']['phone'] : "" )); ?>
			<?php echo $this->Form->input('vendor_postal_code', array( 'placeholder' => 'Postal Code', 'class' => 'input-small vendor_postal_code', "value" => isset($PO['Supplier']['postal_code']) ? $PO['Supplier']['postal_code'] : "" )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('vendor_fax', array( 'placeholder' => 'Fax', 'class' => 'input-small vendor_fax', "value" => isset($PO['Supplier']['fax_number']) ? $PO['Supplier']['fax_number'] : "" )); ?>
			<?php echo $this->Form->input('vendor_email', array( 'placeholder' => 'Email', 'class' => 'input-small vendor_email', "value" => isset($PO['Supplier']['email']) ? $PO['Supplier']['email'] : "" )); ?>
		    </div>
		    <!--	    <div class="marT5">
		    <?php echo $this->Form->input('vendor_email', array( 'placeholder' => 'Email', 'class' => 'input-medium', "value" => isset($PO['Supplier']['name']) ? $PO['Supplier']['name'] : "" )); ?>
			      </div>-->
		</td>
		<th><label for="SupplierAddress">Shipping To: </label></th>

		<td>
		    <div class="marT5">
			<?php echo $this->Form->input('name_ship_to', array( 'placeholder' => 'Name', 'class' => 'input-xlarge' )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('address', array( 'placeholder' => 'Address', 'class' => 'input-xlarge' )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('city', array( 'placeholder' => 'City', 'class' => 'input-small' )); ?>
			<?php echo $this->Form->input('province', array( 'placeholder' => 'Province', 'class' => 'input-small' )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('phone', array( 'placeholder' => 'Phone', 'class' => 'input-small' )); ?>
			<?php echo $this->Form->input('postal_code', array( 'placeholder' => 'Postal Code', 'class' => 'input-small' )); ?>
		    </div>
		</td>
	    </tr>
	    <tr>
		<th><label>Shipping Information: </label></th>
		<td>
		    <div class="marT5">
			<?php echo $this->Form->input('shipment_date', array( 'placeholder' => 'Shipping Date', 'type' => 'text', 'class' => 'input-small dateP', "value" => isset($PO['PurchaseOrder']['shipment_date']) ? $this->Util->formatDate($PO['PurchaseOrder']['shipment_date']) : "" )); ?>
			<?php echo $this->Form->input('f_o_b_point', array( 'placeholder' => 'F.O.B Point', 'class' => 'input-small' )); ?>
		    </div>
		    <div class="marT5">
			<?php echo $this->Form->input('shipment_via', array( 'placeholder' => 'Shipping Via', 'class' => 'input-small' )); ?>
			<?php echo $this->Form->input('term', array( 'placeholder' => 'Terms', 'class' => 'input-small' )); ?>
		    </div>
		</td>
		<th><label for="SupplierTerms">Payment: </label></th>
		<td>
		    <div class="marT5">
			<?php echo $this->Form->input('order_subtotal', array( 'placeholder' => 'Order Sub-Total', 'class' => 'input-small total-cost','readonly'=>true )); ?>
			<?php echo $this->Form->input('shipping_handling', array( 'placeholder' => 'Shipping & Handling', 'class' => 'input-medium shipping_handling' )); ?>
		    </div>
		    <div class="marT5">

			<?php echo $this->Form->input('tax_gst', array( 'placeholder' => 'Taxes (G.S.T)', 'class' => 'input-small gst','readonly'=>true )); ?>
			<?php echo $this->Form->input('tax_pst', array( 'placeholder' => 'Taxes (P.S.T)', 'class' => 'input-small pst','readonly'=>true  )); ?>
			<?php echo $this->Form->input('total_amount', array( 'placeholder' => 'Total Amount', 'class' => 'input-small total_amount','readonly'=>true )); ?>
		    </div>
		</td>
	    </tr>

	    <tr>
				<th><label for="SupplierNotes">Notes: </label></th>
				<td><?php echo $this->Form->input('note', array( 'rows' => 2, 'cols' => 45, 'class' => 'wide-input' )); ?></td>
				<th><label for="SupplierNotesOnPo">Payment Info: </label></th>
				<td>
						<div class="marT5">
					<?php echo $this->Form->input('payment_type', array( 'class' => 'input-medium', 'options' => $this->InventoryLookup->getPaymentType(), 'empty' => '--Payment Type--' )); ?>
					<?php echo $this->Form->input('name_cc', array( 'placeholder' => 'Name', 'class' => 'input-medium' )); ?>
						</div>
						<div class="marT5">
					<?php echo $this->Form->input('cc_num', array( 'placeholder' => 'CC#', 'class' => 'input-medium' )); ?>
					<?php echo $this->Form->input('expiry_date', array( 'placeholder' => 'Expiry Date', 'class' => 'input-small dateP', 'type' => 'text', "value" => isset($PO['PurchaseOrder']['expiry_date']) ? $this->Util->formatDate($PO['PurchaseOrder']['expiry_date']) : "" )); ?>
						</div>
				</td>
	    </tr>
			<tr>
				<th><label for="SupplierGstRate">Issued On </label></th>
				<td><?php echo $this->Form->input('issued_on', array( 'class' => 'input-medium dateP', 'placeholder' => 'Issued Date', 'type'=>'text')); ?></td>
				<th><label for="SupplierGstRate">Issued By </label></th>
				<td>
					<?php
						echo $this->Form->input('issued_by', array( 'class' => 'input-medium', 'placeholder'=>'Issued Name'));
					?>
				</td>
	    </tr>
	    <tr>
				<th><label for="SupplierGstRate">Quote No: </label></th>
				<td><?php echo $this->Form->input('quote_id', array( 'class' => 'input-medium wo', 'options' => $this->InventoryLookup->Quote(), 'empty' => '--Select--' )); ?></td>
				<th><label for="SupplierGstRate">Purchase Order Number </label></th>
				<td>
					<?php
							if(isset($PO['PurchaseOrder']['id']))
							{
								echo $this->Form->input('purchase_order_num', array( 'class' => 'input-medium po_order_num', 'readonly'=> true ));
							}
							else {
								echo $this->Form->input('purchase_order_num', array( 'class' => 'input-medium po_order_num', 'style'=>'display:none' ));
								echo "It will generated by the System";
							}
					?>
				</td>
	    </tr>
	</table>

    <!--Job Order Information-->
	<legend <?php if( $edit ) { ?>class="edit-legend"<?php } ?> ><?php echo __("Purchase Order Details"); ?></legend>
	<div style="float: left;"><?php echo __("Job Order Information"); ?></div>
	<div style="clear: both;"></div>
	<table class='table-form-big'>
	    <tr>
				<th><label for="SupplierEmail">Name: </label></th>
				<td><?php echo $this->Form->input('job_name', array( 'class' => 'input-medium job_name', "value" => isset($PO['Quote']['job_name']) ? $PO['Quote']['job_name'] : "", "readonly"=>true )); ?></td>
				<th><label for="SupplierFirstName">Sales Persons: </label></th>
				<td>
						<?php echo $this->Form->input('sales_person', array( 'class' => 'input-medium sales_person' , "value" => isset($PO['Quote']['sales_person']) ? $PO['Quote']['sales_person'] : "", "readonly"=>true)); ?>
				</td>
	    </tr>
	    <tr>
				<th><label for="SupplierFirstName">Address: </label></th>
				<td>
						<?php echo $this->Form->input('job_address', array( 'class' => 'input-xlarge job_address', "value" => isset($PO['Quote']['address']) ? $PO['Quote']['address'] : "", "readonly"=>true )); ?>
				</td>
				<th><label for="SupplierFirstName">City & Province: </label></th>
				<td>
						<div class="marT5">
					<?php echo $this->Form->input('job_city', array( 'placeholder' => 'City', 'class' => 'input-small job_city', "value" => isset($PO['Quote']['city']) ? $PO['Quote']['city'] : "", "readonly"=>true )); ?>
					<?php echo $this->Form->input('job_province', array( 'placeholder' => 'Province', 'class' => 'input-small job_province' , "value" => isset($PO['Quote']['province']) ? $PO['Quote']['province'] : "", "readonly"=>true)); ?>
						</div>
				</td>
	    </tr>
	</table>
    </fieldset>

   <div class="item-notes-po">
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>
					<th class="text-center">Quantity</th>
          <th>Code</th>
					<th>Description</th>
          <th class="text-center">Each Cost</th>
          <th class="text-center">Total Cost</th>
          <th class="text-center">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
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
          </td>
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

                echo "<span class='data-code'>{$main_item_list[$this->data['PurchaseOrderItem'][$index]['code']]}</span>";
                ?>
              </td>
              <td>
                <?php
                echo $index;
                echo "<span class='data-title'>{$title_list[$this->data['PurchaseOrderItem'][$index]['code']]}</span>";
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
                $per_item_total_cost = number_format($each_cost * $quantity, 2, '.', '');
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
            <td colspan="4" class="text-right" style="font-weight: bold;">Total:</td>
            <td class="text-right">
              <span class='data-item-total-cost'><?php echo $item_total_cost; ?></span>
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
          <td colspan="6">
            <input type="button" class="btn btn-info add-more" value="Add Item" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>

    <div class="align-left align-top-margin">
	<?php echo $this->Form->input('Save', array( 'type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save' )); ?>
    </div>
    <?php if( !isset($this->request->data['Supplier']['id']) ) { ?>
        <div class="align-left align-top-margin">
	    <?php echo $this->Html->link('Cancel', array( 'action' => 'index' ), array( 'data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel') )); ?>
        </div>
	<?php
    }
    else {
	?>
        <div class="align-left align-top-margin">
	    <?php echo $this->Html->link('Cancel', array( 'action' => DETAIL, $this->request->data['PurchaseOrder']['id'] ), array( 'data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel') )); ?>
        </div>
    <?php } ?>
    <?php echo $this->Form->end(); ?>

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
              <div class="ui-widget combobox">
                <?php echo $this->Form->input("code", array("type" => "select", 'placeholder' => 'Item Number', 'empty' => true, 'options' => $main_item_list, "class" => "code required user-input")); ?>
              </div>
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
              <input id="item_description" name="item_description" placeholder="Item Description" readonly="readonly" class="item-description required" type='text' />
              <?php echo $this->Form->input("description", array("type" => "select",'options' => $title_list, "class" => "description user-input",'style'=>'display:none')); ?>
            </td>
            <th>
              <label class="label-text">Price:</label> &nbsp;
            </th>
            <td>
              <input id="item_price" name="item_price" placeholder="Item Price" readonly="readonly" class="item-price required" type='text' />
              <?php echo $this->Form->input("price", array("type" => "select", 'options' => $price_list,"class" => "price user-input",'style'=>'display:none')); ?>
            </td>
          </tr>
<!--          <tr>
            <th>
              <label style="text-align: left; font-weight: bold;clear: both;">Door Information:</label>
            </th>
            <td>
              <div class="radio door-option">
                <?php echo $this->Form->radio("door_information", $this->InventoryLookup->InventoryLookup('order_door_information'), array("class" => "door_information user-input", 'legend' => false)); ?>
              </div>
            </td>
            <td colspan="2">
              <div class="door-information">
                <?php echo $this->Form->input('open_frame_door', array('type' => 'checkbox', 'value' => '1', 'hiddenField' => '0', 'label' => 'Open Frame Door', 'div' => true)); ?>
                <?php echo $this->Form->input('do_not_drill_door', array('type' => 'checkbox', 'value' => '1', 'hiddenField' => '0', 'label' => 'Do Not Drill Door', 'div' => true)); ?>
                <?php echo $this->Form->input('no_doors', array('type' => 'checkbox', 'value' => '1', 'hiddenField' => '0', 'label' => 'No Doors', 'div' => true)); ?>
              </div>
            </td>
          </tr>          -->
        </table>
      </form>
    </div>
    <div class="modal-footer">
      <button class="save btn btn-primary">Add</button>
    </div>
  </div>

</div>

<script type="text/javascript">
$(function() {
	var rand = "<?php echo $uni_rand_num[1]; ?>";
	$('.po_order_num').val(rand);

	$(".supplier-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});

	$("#po-item-list-form .code").combobox();

	$('.test').change(function() {
	    var supplier_id = $('.test').val();
	    //alert(khaled);

	    $.ajax({
		url: '<?php
			    echo $this->Util->getURL(array(
				'controller' => "purchase_orders",
				'action' => 'getSupplier',
				'plugin' => 'purchase_order_manager',
			    ))
			    ?>/'+supplier_id,
		type: 'POST',
		data: '',
		dataType: "json",
		success: function( response ) {
		    $(".vendor_name").val(response.Supplier.name);
		    $(".vendor_address").val(response.Supplier.address);
		    $(".vendor_city").val(response.Supplier.city);
		    $(".vendor_province").val(response.Supplier.province);
		    $(".vendor_phone").val(response.Supplier.phone);
		    $(".vendor_postal_code").val(response.Supplier.postal_code);
		    $(".vendor_fax").val(response.Supplier.fax_number);
		    $(".vendor_email").val(response.Supplier.email);
				$(".gst").val(response.Supplier.gst_rate);
				$(".pst").val(response.Supplier.pst_rate);

				var s_total = $(".total-cost").val();
				var pst = $(".pst").val();
				var gst = $(".gst").val();
				var shipping_handling = $(".shipping_handling").val();

				var amount = parseFloat(isNaN(s_total) || s_total == '' ? 0 : s_total) + parseFloat(isNaN(pst) || pst == '' ? 0 : pst) + parseFloat(isNaN(gst) || gst == '' ? 0 : gst) + parseFloat(isNaN(shipping_handling) || shipping_handling == '' ? 0 : shipping_handling);

				$(".total_amount").val(amount);
		}
	    });
	});

	$('.wo').change(function() {
	    var q_id = $('.wo').val();

	    $.ajax({
		url: '<?php
			    echo $this->Util->getURL(array(
				'controller' => "purchase_orders",
				'action' => 'getQuote',
				'plugin' => 'purchase_order_manager',
			    ))
			    ?>/'+q_id,
		type: 'POST',
		data: '',
		dataType: "json",
		success: function( response ) {
		    $(".job_name").val(response.Quote.job_name);
		    $(".job_address").val(response.Quote.address);
		    $(".job_city").val(response.Quote.city);
		    $(".job_province").val(response.Quote.province);
		    $(".sales_person").val(response.Quote.sales_person);
		}
	    });
	});

	$('.add-more').live("click", function(){
	    $("#add_order_item_po form").validate();
	    $('#add_order_item_po').modal();
	    $('#add_order_item_po .quantity').val('');
	    $('#add_order_item_po .code').val('');
	});

	$(".purchase-order-form").validate();
	//$(".purchase-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
	$("#add_order_item_po .code").combobox();

	$('.shipping_handling').change(function() {
		var s_total = $(".total-cost").val();
		var pst = $(".pst").val();
		var gst = $(".gst").val();
		var shipping_handling = $(".shipping_handling").val();

		var amount = parseFloat(isNaN(s_total) || s_total == '' ? 0 : s_total) + parseFloat(isNaN(pst) || pst == '' ? 0 : pst) + parseFloat(isNaN(gst) || gst == '' ? 0 : gst) + parseFloat(isNaN(shipping_handling) || shipping_handling == '' ? 0 : shipping_handling);

		$(".total_amount").val(amount);

	})
	$('.total-cost').change(function() {
		var s_total = $(".total-cost").val();
		var pst = $(".pst").val();
		var gst = $(".gst").val();
		var shipping_handling = $(".shipping_handling").val();

		var amount = parseFloat(isNaN(s_total) || s_total == '' ? 0 : s_total) + parseFloat(isNaN(pst) || pst == '' ? 0 : pst) + parseFloat(isNaN(gst) || gst == '' ? 0 : gst) + parseFloat(isNaN(shipping_handling) || shipping_handling == '' ? 0 : shipping_handling);

		$(".total_amount").val(amount);

	})
	$('.pst').change(function() {
		var s_total = $(".total-cost").val();
		var pst = $(".pst").val();
		var gst = $(".gst").val();
		var shipping_handling = $(".shipping_handling").val();

		var amount = parseFloat(isNaN(s_total) || s_total == '' ? 0 : s_total) + parseFloat(isNaN(pst) || pst == '' ? 0 : pst) + parseFloat(isNaN(gst) || gst == '' ? 0 : gst) + parseFloat(isNaN(shipping_handling) || shipping_handling == '' ? 0 : shipping_handling);

		$(".total_amount").val(amount);

	})
	$('.gst').change(function() {
		var s_total = $(".total-cost").val();
		var pst = $(".pst").val();
		var gst = $(".gst").val();
		var shipping_handling = $(".shipping_handling").val();

		var amount = parseFloat(isNaN(s_total) || s_total == '' ? 0 : s_total) + parseFloat(isNaN(pst) || pst == '' ? 0 : pst) + parseFloat(isNaN(gst) || gst == '' ? 0 : gst) + parseFloat(isNaN(shipping_handling) || shipping_handling == '' ? 0 : shipping_handling);

		$(".total_amount").val(amount);

	})

});
</script>
