<div class="quoteReportsSettings form">
<?php echo $this->Form->create('QuoteReportsSetting');?>
	<fieldset>
		<legend><?php echo __('Add Quote Reports Setting'); ?></legend>
	<?php
		echo $this->Form->input('report_name');
		echo $this->Form->input('report_function');
		echo $this->Form->input('departments');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>