<div class="builders form">
  <?php echo $this->Form->create('Builder', array('class' => 'builder-form ajax-form-submit')); ?>
  <?php echo $this->Form->input('id'); ?>
  <?php echo $this->Form->input('number', array('class' => 'required')); ?>
  <?php echo $this->Form->input('name', array('class' => 'required')); ?>
  <?php echo $this->Form->input('status'); ?>
  <?php echo $this->Form->input('suite'); ?>
  <?php echo $this->element('Forms/address-sub-form', array('edit' => false)); ?>
  <?php echo $this->Form->input('phone', array('class' => 'required')); ?>
  <?php echo $this->Form->input('fax'); ?>
  <?php echo $this->Form->input('discount_rate'); ?>
  <?php echo $this->Form->input('customer_type_id'); ?>
  <?php echo $this->Form->input('quotes_validity'); ?>
  <?php echo $this->Form->input('ar_account'); ?>
  <?php echo $this->Form->input('ap_account'); ?>
  <?php echo $this->Form->input('multi_unit'); ?>
  <?php echo $this->Form->input('retail_client'); ?>
  <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".builder-form").validate({ignore: null});
<?php if ($edit) { // do ajax if edit   ?>
    $(".builder-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
<?php } ?>
</script>