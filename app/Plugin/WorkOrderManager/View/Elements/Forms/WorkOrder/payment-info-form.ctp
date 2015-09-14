<?php 
	$quote_status = $this->InventoryLookup->WorkOrderStatus($work_order['WorkOrder']['id']); 
	if($quote_status != 'Approve'){
?>
<?php echo $this->Form->create('UploadPayment', array('type' => 'file', 'url' => "http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/upload_single_file_payment/{$work_order['WorkOrder']['id']}", 'id' => 'UploadDetailForm')); ?>
<fieldset>
  <legend><?php __('Add Upload'); ?></legend>
  <?php
  echo $this->Form->input('payment_method', array('placeholder' => 'Payment Method','class' => 'required form-select p_method', 'empty' => true,'options' => $this->InventoryLookup->getPaymentMethod()));
  echo $this->Form->input('payment_date', array('class' => 'required dateP', 'type' => 'text'));
	echo $this->Form->input('amount');
	?>
	<div id="payment_cheque" style="display: none;">
		<?php echo $this->Form->input('cheque_no'); ?>
	</div>
	<div id="payment_credit" style="display: none;">
		<?php echo $this->Form->input('credit_card_app_code'); ?>
	</div>
	<?php
		echo $this->Form->input('deposit', array('options' => array('Yes' => 'Yes', 'No' => 'No'), 'class' => 'required form-select', 'empty' => true, 'placeholder' => 'Payment Type'));
	echo $this->Form->input('comment', array('style' => 'width: 300px; height: 100px;'));
  echo $this->Form->input('file', array('type' => 'file'));
  echo $this->Form->input('ref_id', array('type' => 'hidden', 'class' => 'required', 'value' => $work_order['WorkOrder']['quote_id']));
  echo $this->Form->input('ref_model', array('type' => 'hidden', 'class' => 'required', 'value' => 'quotes'));
  ?>
</fieldset>
<?php echo $this->Form->end(__('Upload & Save the file', true)); ?>
<?php } ?>
<script>
  $("#UploadDetailForm").validate({ignore: null});
  //  $(".cabinet-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
  //$("#add_order_item .code").combobox();
  $(document).ready(function() {
    $( "#UploadFile" ).change(function() {
      var file_parts = $(this).val().split('\\');
      var file_name = file_parts[file_parts.length - 1];
//      var file_name_parts = file_name.split('.');
//      var file_title = file_name_parts[file_name_parts.length - 2];
      $('#UploadTitle').val(file_name);
    });
		$('.p_method').bind("change",function(){
			var val = $(this).val();
			if(val=='Cheque'){
				$("#payment_cheque").show();
				$("#payment_credit").hide();
			}
			if(val=='Credit Card'){
				$("#payment_cheque").hide();
				$("#payment_credit").show();
			}
			if(val=='Cash'){
				$("#payment_cheque").hide();
				$("#payment_credit").hide();
			}
		});
  });
</script>