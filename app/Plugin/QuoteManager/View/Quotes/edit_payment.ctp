<?php echo $this->Form->create('UploadPayment', array('type' => 'file', 'url' => "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/upload_single_file_payment_edit/{$upload_payment['UploadPayment']['ref_id']}", 'id' => 'UploadDetailForm pay_upload_form')); ?>
<fieldset>
  <legend><?php __('Add Upload'); ?></legend>
  <?php
	echo $this->Form->input('id', array('value' => $id, 'type' => 'hidden'));
  echo $this->Form->input('payment_method', array('readonly' => 'readonly','value' => $upload_payment['UploadPayment']['payment_method'],'class' => 'p_method required form-select', 'empty' => true,'options' => $this->InventoryLookup->getPaymentMethod()));
  echo $this->Form->input('payment_date', array('readonly' => 'readonly','value' => $this->Util->formatDate($upload_payment['UploadPayment']['payment_date']),'class' => 'required', 'type' => 'text'));
	echo $this->Form->input('amount', array('value' => $upload_payment['UploadPayment']['amount'], 'readonly' => 'readonly'));
	?>
	<div id="payment_cheque" style="display: none;">
		<?php echo $this->Form->input('cheque_no', array('value' => $upload_payment['UploadPayment']['cheque_no'], 'readonly' => 'readonly')); ?>
	</div>
	<div id="payment_credit" style="display: none;">
		<?php echo $this->Form->input('credit_card_app_code', array('value' => $upload_payment['UploadPayment']['credit_card_app_code'], 'readonly' => 'readonly')); ?>
	</div>
	<?php
	echo $this->Form->input('deposit', array('value' => $upload_payment['UploadPayment']['deposit'],'readonly' => 'readonly','options' => array('Yes' => 'Yes', 'No' => 'No'), 'class' => 'required form-select'));
	echo $this->Form->input('comment', array('value' => $upload_payment['UploadPayment']['comment'],'readonly' => 'readonly','style' => 'width: 300px; height: 100px;'));
  echo $this->Form->input('file', array('type' => 'file'));
  echo $this->Form->input('ref_id', array('type' => 'hidden', 'class' => 'required', 'value' => $upload_payment['UploadPayment']['ref_id']));
  echo $this->Form->input('ref_model', array('type' => 'hidden', 'class' => 'required', 'value' => 'quotes'));
  ?>
</fieldset>
<input type="submit" class="btn btn-info payment_submit" value="Upload & Save the file" />
<!--<a href="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$upload_payment['UploadPayment']['ref_id']}#payment-info"; ?>">Cancel</a>-->
<?php echo $this->Html->link('Cancel', array('action' => 'quote_payment_view',$upload_payment['UploadPayment']['ref_id']), array('data-target' => '#payment-info','class' => 'btn btn-success btn-padding ajax-sub-content', 'label' => false, 'value' => 'Cancel')); ?>
	<?php echo $this->Form->end(); ?>

<script>
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
</script>