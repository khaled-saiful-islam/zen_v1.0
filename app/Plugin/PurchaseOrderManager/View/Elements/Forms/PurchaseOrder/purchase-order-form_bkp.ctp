<?php
//$randNum = uniqid(rand(100000,999999),true);
//$uni_rand_num = explode('.', $randNum);
//debug($this->data);
if (!empty($this->data))
  $sales_man = $this->InventoryLookup->QuoteForView($this->data['PurchaseOrder']['quote_id']);
?>

<?php $item_total_cost = 0; ?>
<div class="suppliers form">

  <?php
  $workOrder = $this->InventoryLookup->WorkOrderInPo();
  $all_items = $this->InventoryLookup->ListAllTypesOfItems();
  $main_item_list = $all_items['main_list'];
  $price_list = $all_items['price_list'];
  $title_list = $all_items['title_list'];
//  pr($all_items);pr($main_item_list);pr($price_list);pr($title_list);
  ?>
  <?php echo $this->Form->create('PurchaseOrder', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit purchase-order-form')); ?>
  <fieldset>
    <legend <?php if ($edit) { ?>class="edit-legend"<?php } ?> ><?php echo __($legend); ?></legend>
    <table class='table-form-big po-supplier-table-mid-width'>
      <tbody>
        <tr>
          <th><label for="PurchaseOrderSupplierId">Supplier: </label></th>
          <td colspan="2">
						<?php echo $this->Form->input('supplier_id', array('placeholder' => 'Name', 'class' => 'input-medium test form-select required', "options" => $this->InventoryLookup->Supplier(), 'empty' => true,)); ?>
						<a style="margin-left: 5px; position: relative; top: -8px; " href="javascript: toggle('search_div')"><i class='icon-exclamation-sign icon-black'></i></a>
					</td>
          <th><label for="">PO Number: </label></th>
          <td colspan="3">
            <?php
            if (empty($this->data['PurchaseOrder']['purchase_order_num'])) {
              $po_number = $this->InventoryLookup->auto_generate_number('Purchase Order');
              ?>
              <?php echo $this->Form->input('purchase_order_num', array('readonly' => true, 'value' => $po_number)); ?>
            <?php } else {
              ?>
              <?php echo $this->Form->input('purchase_order_num', array('readonly' => true)); ?>
            <?php } ?>
            <?php //echo $this->Form->input('purchase_order_num', array('placeholder' => 'Purchase Order Number', 'class' => 'input-medium', 'readonly' => true, 'value' => date('ish')));  ?>
          </td>
        </tr>
      </tbody>
    </table>
		
    <table id='search_div' style="display:<?= isset($_GET['search']) ? "block" : "none" ?>" class="table-form-big table-form-big-margin po-supplier-table-mid-width">
      <tbody>
        <tr>
          <th colspan="4">
            <label class="table-data-title">Supplier's Information</label>
          </th>
        </tr>
        <tr>
          <th><label for="PurchaseOrderOrderName">Name: </label></th>
          <td class="vendor_name">
            <?php
            if (isset($this->data['PurchaseOrder']['supplier_id']))
              echo $this->data['Supplier']['name'];
            ?>
          </td>
          <th><label for="PurchaseOrderOrderEmail">E-mail: </label></th>
          <td class="vendor_email">
            <?php
            if (isset($this->data['PurchaseOrder']['supplier_id']))
              echo $this->data['Supplier']['email'];
            ?>
          </td>
        </tr>
        <tr>
          <th><label>Phone: </label></th>
          <td class="vendor_phone">
            <?php
            if (isset($this->data['PurchaseOrder']['supplier_id']))
              echo $this->InventoryLookup->address_format($this->data['Supplier']['address'], $this->data['Supplier']['city'], $this->data['Supplier']['province'], $this->data['Supplier']['country'], $this->data['Supplier']['postal_code']);
            ?>
          </td>
          <th><label>Address: </label></th>
          <td class="vendor_address">
            <?php
            if (isset($this->data['PurchaseOrder']['supplier_id']))
              echo $this->InventoryLookup->address_format($this->data['Supplier']['address'], $this->data['Supplier']['city'], $this->data['Supplier']['province'], $this->data['Supplier']['country'], $this->data['Supplier']['postal_code']);
            ?>
          </td>
        </tr>
      </tbody>
    </table>
		<table class="table-form-big table-form-big-margin">
      <tbody>
      <th colspan="4">
        <label class="table-data-title"><?php echo __("Job Order Information"); ?></label>
      </th>
      <tr>
        <th><label for="SupplierGstRate">Work Order no: </label></th>
        <td class="job_name">
          <?php echo $this->Form->input('work_order_id', array('placeholder' => 'Quote Job Title', 'class' => 'input-medium wo form-select required', 'options' => $workOrder, 'empty' => true)); ?>
          <?php echo $this->Form->input('quote_id', array('type' => 'hidden', 'class' => 'quote-id')); ?>
        </td>
        <th><label for="SupplierFirstName">Sales Persons: </label></th>
        <td class="sales_person">
          <?php
          if (isset($this->data['PurchaseOrder']['quote_id']))
            echo $sales_man['User']['first_name'] . ' ' . $sales_man['User']['last_name'];
          ?>
        </td>
      </tr>
      <tr>
        <th><label for="PurchaseOrderOrderAddress">Address: </label></th>
        <td colspan="3" class="job_address">
          <?php
          if (isset($this->data['PurchaseOrder']['quote_id']))
            echo $this->InventoryLookup->address_format($this->data['Quote']['address'], $this->data['Quote']['city'], $this->data['Quote']['province'], $this->data['Quote']['country'], $this->data['Quote']['postal_code']);
          ?>
        </td>
      </tr>
      <tr>

      </tr>
      </tbody>
    </table>
    <table class='table-form-big table-form-big-margin'>
      <tbody>
        <tr>
          <th colspan="3">
            <label class="table-data-title">Shipping To Information</label>
          </th>
          <th colspan="2">
            <label class="table-data-title">Payment Information</label>
          </th>
        </tr>
        <tr>
          <th><label for="PurchaseOrderOrderName">Name: </label></th>
          <td>
            <?php echo $this->Form->input('name_ship_to', array('placeholder' => 'Name', 'class' => '')); ?>
          </td>
          <td class="width-min">
            &nbsp;
          </td>
          <th><label for="SupplierTerms">Order Sub-Total: </label></th>
          <td>
            <?php echo $this->Form->input('order_subtotal', array('type' => 'text', 'placeholder' => 'Order Sub-Total', 'class' => 'input-small order-sub-total', 'readonly' => true)); ?>
          </td>
        </tr>
        <tr>
          <th rowspan="3"><label for="PurchaseOrderOrderPhone">Phone: </label></th>
          <td>
            <?php echo $this->Form->input('ship_to_phone', array('placeholder' => 'Phone', 'class' => 'vendor_phone')); ?>
          </td>
          <td class="width-min">
            &nbsp;
            <?php echo $this->Form->input('ship_to_phone_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>
          </td>
          <th class="width-medium">
            <label>Shipping & Handling:</label>
          </th>
          <td>
            <?php echo $this->Form->input('shipping_handling', array('placeholder' => 'Shipping & Handling', 'class' => 'input-medium shipping_handling')); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php echo $this->Form->input('ship_to_cell', array('placeholder' => 'Cell', 'class' => 'small-wide-input')); ?>
          </td>
          <th>
            <label>Taxes (G.S.T):</label>
          </th>
          <td>
            <?php echo $this->Form->input('tax_gst', array('placeholder' => 'Taxes (G.S.T)', 'class' => 'input-small supplier_gst', 'readonly' => true)); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php echo $this->Form->input('ship_to_fax', array('placeholder' => 'Fax', 'class' => 'vendor_fax')); ?>
          </td>
          <th>
            <label>Taxes (P.S.T):</label>
          </th>
          <td>
            <?php echo $this->Form->input('tax_pst', array('placeholder' => 'Taxes (P.S.T)', 'class' => 'input-small supplier_pst', 'readonly' => true)); ?>
          </td>
        </tr>
        <tr>
          <th rowspan="3"><label for="PurchaseOrderOrderAddress">Address: </label></th>
          <td colspan="2">
            <?php echo $this->Form->input('ship_to_address', array('placeholder' => 'Address', 'class' => 'vendor_address')); ?>
          </td>
          <th>
            <label>Total Amount:</label>
          </th>
          <td>
            <?php echo $this->Form->input('total_amount', array('placeholder' => 'Total Amount', 'class' => 'input-small total_amount', 'readonly' => true)); ?>
          </td>
        </tr>
        <tr>
          <td class="width-min">
            <?php echo $this->Form->input('ship_to_city', array('placeholder' => 'City', 'class' => 'vendor_city')); ?>
          </td>
          <td>
            <?php echo $this->Form->input('ship_to_province', array('placeholder' => 'Province', 'options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
          </td>
          <th><label for="SupplierNotesOnPo">Payment Type: </label></th>
          <td>
            <?php echo $this->Form->input('payment_type', array('placeholder' => 'Payment Type', 'class' => 'required input-medium form-select', 'options' => $this->InventoryLookup->getPaymentType(), 'empty' => true)); ?>
          </td>
        </tr>
        <tr>
          <td class="width-min">
            <?php echo $this->Form->input('ship_to_postal_code', array('placeholder' => 'Postal Code', 'class' => 'vendor_postal_code')); ?>
          </td>
          <td>
            <?php echo $this->Form->input('ship_to_country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => 'input-small')); ?>
          </td>
          <th><label>Name:</label></th>
          <td>
            <?php echo $this->Form->input('name_cc', array('placeholder' => 'Name', 'class' => 'input-medium')); ?>
          </td>
        </tr>
        <tr>
          <th><label>Shipping Date: </label></th>
          <td colspan="2">
            <?php echo $this->Form->input('shipment_date', array('placeholder' => 'Shipping Date', 'type' => 'text', 'class' => 'required dateP')); ?>
          </td>
          <th>
            <label>CC#:</label>
          </th>
          <td>
            <?php echo $this->Form->input('cc_num', array('placeholder' => 'CC#', 'class' => 'input-medium')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label>F.O.B Point: </label>
          </th>
          <td colspan="2">
            <?php echo $this->Form->input('f_o_b_point', array('placeholder' => 'F.O.B Point', 'class' => '')); ?>
          </td>
          <th>
            <label>Expiry:</label>
          </th>
          <td>
            <?php echo $this->Form->input('expiry_date', array('placeholder' => 'Expiry', 'class' => 'input-small dateP', 'type' => 'text')); ?>
          </td>
        </tr>
        <tr>
          <th><label>Ship via: </label></th>
          <td colspan="2">
            <?php echo $this->Form->input('shipment_via', array('placeholder' => 'Ship via', 'class' => '')); ?>
          </td>
          <th><label for="SupplierGstRate">Issued On </label></th>
          <td><?php echo $this->Form->input('issued_on', array('class' => 'input-medium dateP', 'placeholder' => 'Issued Date', 'type' => 'text')); ?></td>
        </tr>
        <tr>
          <th><label>Terms </label></th>
          <td colspan="2">
            <?php echo $this->Form->input('term', array('placeholder' => 'Terms', 'class' => 'input-small')); ?>

          </td>
          <th><label for="SupplierGstRate">Issued By </label></th>
          <td>
            <?php
            echo $this->Form->input('issued_by', array('class' => 'input-medium', 'placeholder' => 'Issued Name'));
            ?>
          </td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <th><label for="SupplierNotes">Notes: </label></th>
          <td><?php echo $this->Form->input('note', array('rows' => 2, 'cols' => 45)); ?></td>
        </tr>
      </tbody>
    </table>

    <!--Job Order Information
    <legend <?php if ($edit) { ?>class="edit-legend"<?php } ?> ><?php echo __("Purchase Order Details"); ?></legend>
    <div style="float: left;"><?php //echo __("Job Order Information");              ?></div>
    <div style="clear: both;"></div>
    <table class='table-form-big'>
      <tr>
        <th><label for="SupplierEmail">Name: </label></th>
        <td><?php //echo $this->Form->input('job_name', array('class' => 'input-medium job_name', "readonly" => true));              ?></td>

      </tr>
      <tr>
        <th><label for="SupplierFirstName">Address: </label></th>
        <td>
    <?php //echo $this->Form->input('job_address', array('class' => 'input-xlarge job_address', "readonly" => true));  ?>
        </td>
        <th><label for="SupplierFirstName">City & Province: </label></th>
        <td>
          <div class="marT5">
    <?php //echo $this->Form->input('job_city', array('placeholder' => 'City', 'class' => 'input-small job_city', "readonly" => true)); ?>
    <?php //echo $this->Form->input('job_province', array('placeholder' => 'Province', 'class' => 'input-small job_province', "readonly" => true));  ?>
          </div>
        </td>
      </tr>
    </table> -->
  </fieldset>

  <div class="item-notes-po">
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>
          <th>Code</th>
          <th>Description</th>
          <th class="text-center">Quantity</th>
          <th class="text-center">Each Cost</th>
          <th class="text-center">Total Cost</th>
          <th class="text-center">&nbsp;</th>
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
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <?php if (!isset($this->request->data['Supplier']['id'])) { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
    </div>
    <?php
  } else {
    ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => DETAIL, $this->request->data['PurchaseOrder']['id']), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
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
              <?php echo $this->Form->input("code", array("type" => "select", 'placeholder' => 'Item Number', 'empty' => true, 'options' => $main_item_list, "class" => "form-select required po-code user-input")); ?>
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

</div>

<script type="text/javascript">
  $(function() {
    //var rand = "<?php //echo $uni_rand_num[1];             ?>";
    //$('.po_order_num').val(rand);
    $(".purchase-order-form").validate({ignore: null});
    $(".purchase-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});

    //$("#po-item-list-form .code").combobox();

    $('.test').change(function() {
      var supplier_id = $('select.test').val();
      //alert(khaled);
      ajaxStart();
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
          //console.log(response);
          $(".vendor_name").html(response.Supplier.name);
          $(".vendor_address").html(response.Supplier.address_formate);
          //$(".vendor_city").val(response.Supplier.city);
          //$(".vendor_province").val(response.Supplier.province);
          $(".vendor_phone").html(response.Supplier.phone_formate);
          //$(".vendor_postal_code").val(response.Supplier.postal_code);
          //$(".vendor_fax").val(response.Supplier.fax_number);
          $(".vendor_email").html(response.Supplier.email);
          $(".supplier_gst").val(response.Supplier.gst_rate);
          $(".supplier_pst").val(response.Supplier.pst_rate);

          var s_total = $(".total-cost").val();
          var pst = $(".pst").val();
          var gst = $(".gst").val();
          var shipping_handling = $(".shipping_handling").val();

          var amount = parseFloat(isNaN(s_total) || s_total == '' ? 0 : s_total) + parseFloat(isNaN(pst) || pst == '' ? 0 : pst) + parseFloat(isNaN(gst) || gst == '' ? 0 : gst) + parseFloat(isNaN(shipping_handling) || shipping_handling == '' ? 0 : shipping_handling);

          $(".total_amount").val(amount);
          ajaxStop();
        }
      });
    });

    $('.wo').change(function() {
      var q_id = $('select.wo').val();
      ajaxStart();
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
          $(".job_address").html(response.Quote.address_formate);
          $(".sales_person").html(response.Quote.sales_person);
          $(".quote-id").val(response.Quote.id);
          var title_option="";
          var price_option="";
          var code_option="";
          start = 0;
          $.each(response.all_item.name_list,function(key,value){
            if(start==0){
              $('#add_order_item_po input.item-description').val(response.all_item.title_list[key]);
              $('#add_order_item_po input.item-price').val(response.all_item.price_list[key]);
              start = 1;
            }
            code_option +="<option value="+key+">"+value+"</option>";
            title_option +="<option value="+key+">"+response.all_item.title_list[key]+"</option>";
            price_option +="<option value="+key+">"+response.all_item.price_list[key]+"</option>";
          });
          //console.log(code_option);
          //console.log(title_option);
          //console.log(price_option);
          $('#add_order_item_po select.description').find('option').remove();
          $('#add_order_item_po select.po-code').find('option').remove();
          $('#add_order_item_po select.price').find('option').remove();

          $('#add_order_item_po select.description').append(title_option);
          $('#add_order_item_po select.po-code').append(code_option);
          $('#add_order_item_po select.price').append(price_option);
          ajaxStop();
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
