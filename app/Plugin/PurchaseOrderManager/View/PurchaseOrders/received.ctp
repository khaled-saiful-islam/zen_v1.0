<?php 
$workOrder = $this->InventoryLookup->WorkOrderInPo();
echo $this->Form->create('PurchaseOrder', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit purchase-order-form')); ?>
<fieldset>
  <legend>Purchase Received Form</legend>
  <table class='table-form-big'>	    
    <tr>
      <th><label for="QuoteCustomerId">PO Number: </label></th>
      <td>
        <?php echo $this->Form->input('purchase_order_num', array('options' => $this->InventoryLookup->PurchaseOrder(), 'empty' => true, 'class' => 'po_num form-select', 'placeholder' => 'PO Number')); ?>
        <?php //echo $this->Form->input('id', array('options' => $this->InventoryLookup->PurchaseOrder(), 'empty' => true, 'class' => 'po_num form-select')); ?>
      </td>
      <th><label for="SupplierGstRate">Load#</label></th>
      <td>
        <?php
        echo $this->Form->input('load', array('class' => 'input-medium'));
        ?>
      </td>        
    </tr>
<!--    <tr>
      <th><label for="SupplierGstRate">Job Name: </label></th>
      <td>
        <?php
        echo $this->Form->input('work_order_id', array('options' => $workOrder, 'empty' => true, 'class' => 'form-select wo-number', 'placeholder' => 'Job Name'));
        ?>
      </td>
      <th><label for="SupplierGstRate">Order#</label></th>
      <td>
        <?php
        echo $this->Form->input('order', array('class' => 'input-medium'));
        ?>
      </td>
    </tr>-->
  </table>	    
</fieldset>

<?php
echo $this->Html->link('Received', array(), array(
    "escape" => false,
    "id" => "click_for_issued",
    "class" => "btn btn-success",
    "style" => "margin-left: 10px;"
));
?>

<?php echo $this->Form->end(); ?>      
<div class="item-notes-po">
  <table class="table-form-big table-form-big-margin">
    <thead>
      <tr>
        <th>PO#</th>
        <th>Vendor Name</th>
        <th>Issued On</th>          
        <th>Issued By</th>
        <th>Received</th>
        <th>Total Amount</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div id="po"></div></td>
        <td><div id="vendor_name"></div></td>
        <td><div id="issued_on"></div></td>
        <td><div id="issued_by"></div></td>
        <td><div id="received"></div></td>
        <td><div id="total_amount"></div></td>
        <td>
            <div id="actions"></div>
        </td>
      </tr>
    </tbody>
  </table>
  <div id="po"></div>
</div>
<script type="text/javascript">
	
  $('.po_num').change(function() {
    var po_num = $('select.po_num').val();
		ajaxStart();
    $.ajax({
      url: '<?php
		echo $this->Util->getURL(array(
    'controller' => "purchase_orders",
    'action' => 'getPO',
    'plugin' => 'purchase_order_manager',
))
?>/'+po_num,
      type: 'POST',
      data: '',
      dataType: "json",
      success: function( response ) {
        var res = response.PurchaseOrder.received;
        $("#po").html(response.PurchaseOrder.purchase_order_num); 
        $("#vendor_name").html(response.Supplier.name);
        $("#issued_on").html(response.PurchaseOrder.issued_on); 
        $("#issued_by").html(response.PurchaseOrder.issued_by);
        $("#received").val(response.PurchaseOrder.received);
        $("#total_amount").html(response.PurchaseOrder.total_amount);
        if(res == 0)
        {
          $("#received").html('NO');
          $("#actions").html("<a onclick=\"return confirm('Are you want to Received?');\" class='icon-download' title='Received' href='<?php
					echo $this->Util->getURL(array(
							'controller' => "purchase_orders",
							'action' => 'received_save_list',
							'plugin' => 'purchase_order_manager',
					))
					?>/"+response.PurchaseOrder.id+"'></a>");
        }
        if(res == 1)
        {
          $("#received").html('Yes');
        }
				ajaxStop();
      }
    });	
  });
  
  $('.wo-number').change(function() {
    var po_num = $('select.wo-number').val();
		ajaxStart();
    $.ajax({
      url: '<?php
echo $this->Util->getURL(array(
    'controller' => "purchase_orders",
    'action' => 'getWorkOrderOfPO',
    'plugin' => 'purchase_order_manager',
))
?>/'+po_num,
      type: 'POST',
      data: '',
      dataType: "json",
      success: function( response ) {
//        var res = response.PurchaseOrder.received;
//        $("#po").html(response.PurchaseOrder.purchase_order_num); 
//        $("#vendor_name").html(response.Supplier.name);
//        $("#issued_on").html(response.PurchaseOrder.issued_on); 
//        $("#issued_by").html(response.PurchaseOrder.issued_by);
//        $("#received").val(response.PurchaseOrder.received);
//        $("#total_amount").html(response.PurchaseOrder.total_amount);
//        if(res == 0)
//        {
//          $("#received").html('NO');
//          $("#actions").html("<a onclick=\"return confirm('Are you want to Received?');\" class='icon-download' title='Received' href='<?php
/*echo $this->Util->getURL(array(
    'controller' => "purchase_orders",
    'action' => 'received_save_list',
    'plugin' => 'purchase_order_manager',
))*/
?>///"+response.PurchaseOrder.id+"'></a>");
//        }
//        else
//        {
//          $("#received").html('Yes');
//        }
    ajaxStop();  
		}
    });	
  });
  
  $('#click_for_issued').click(function(){
    var id_po_select = $('select.po_num').val()
    var id_po_received = $('#received').val()
			
    if(id_po_select > 0 && id_po_received != 1)
    {
			ajaxStart();
      $.ajax({
        url: '<?php
echo $this->Util->getURL(array(
    'controller' => "purchase_orders",
    'action' => 'received_save',
    'plugin' => 'purchase_order_manager',
))
?>/'+id_po_select,
        type: 'POST',
        data: '',
        dataType: "json",
        success: function( response ) {
          console.log(response);
          var res = response.PurchaseOrder.received;
          $("#po").html(response.PurchaseOrder.purchase_order_num); 
          $("#vendor_name").html(response.Supplier.name);
          $("#issued_on").html(response.PurchaseOrder.issued_on); 
          $("#issued_by").html(response.PurchaseOrder.issued_by);
          //$("#received").html(response.PurchaseOrder.received);
          $("#total_amount").html(response.PurchaseOrder.total_amount);
          $("#actions").html();
          
          if(res == 0)
          {
            $("#received").html('NO');
            $("#actions").html("<a onclick='return confirm('Are you want to Received?');' class='icon-download' title='Received' href='<?php
echo $this->Util->getURL(array(
    'controller' => "purchase_orders",
    'action' => 'received_save_list',
    'plugin' => 'purchase_order_manager',
))
?>/"+response.PurchaseOrder.id+"'></a>");
          }
          else
          {
            $("#received").html('Yes');
          }
					ajaxStop();
        }
      });
    }
    else
    {
      alert("Please Select PO Number");
    }
  });
</script>
