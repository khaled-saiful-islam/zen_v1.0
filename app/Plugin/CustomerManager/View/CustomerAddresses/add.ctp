<div class="addresses form">
<?php echo $this->Form->create('CustomerAddress');?>
	<fieldset>
		<legend><?php echo __('Add CustomerAddress'); ?></legend>
	<?php
		echo $this->Form->input('ref_id');
		echo $this->Form->input('ref_type');
		echo $this->Form->input('quote_id');
		echo $this->Form->input('address_type_id');
		echo $this->Form->input('address_line_1');
		echo $this->Form->input('address_line_2');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('phone_other');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>