<?php 
	$quote_status = $this->InventoryLookup->QuoteStatus($quote['Quote']['id']); 
	if($quote_status != 'Review' && $quote['Quote']['delete'] == 0){
?>
<?php echo $this->Form->create('Upload', array('type' => 'file', 'url' => "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/upload_single_file/{$quote['Quote']['id']}", 'id' => 'UploadDetailForm')); ?>
<fieldset>
  <legend><?php __('Add Upload'); ?></legend>
  <?php
  echo $this->Form->input('title', array('class' => 'required'));
  echo $this->Form->input('description');
  echo $this->Form->input('file', array('type' => 'file', 'class' => 'required'));
  echo $this->Form->input('ref_id', array('type' => 'hidden', 'class' => 'required', 'value' => $quote['Quote']['id']));
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
  });
</script>