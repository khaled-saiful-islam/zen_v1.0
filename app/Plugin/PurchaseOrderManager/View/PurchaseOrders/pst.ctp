<h2>Edit P.S.T</h2>
<?php
  echo $this->Form->create('GeneralSetting', array("url" => array("controller" => "purchase_orders", "action" => "gst_add"),'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'purchase-order-form'));
?>
<table class='table-form-big table-form-big-margin' style="min-width: 380px;">
	<tbody>
		<tr>
			<td>
				<?php echo $this->Form->input('id', array( 'type' => 'hidden','class' => 'input-medium', 'label' => false, 'value' => isset($data['GeneralSetting']['id']) ? $data['GeneralSetting']['id'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 25px;"><label for="GeneralSettingName">Name: </label></th>
			<td>
				<?php echo $this->Form->input('name', array( 'readonly' => 'readonly','class' => 'input-medium', 'label' => false, 'value' => isset($data['GeneralSetting']['name']) ? $data['GeneralSetting']['name'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 25px;"><label for="GeneralSettingValue">Value: </label></th>
			<td>
				<?php echo $this->Form->input('value', array( 'class' => 'input-medium', 'label' => false, 'value' => isset($data['GeneralSetting']['value']) ? $data['GeneralSetting']['value'] : '')); ?>
			</td>
		</tr>
	</tbody>	
</table>
<?php echo $this->Form->end('Save'); ?>