<h2>Edit Location</h2>
<?php
  echo $this->Form->create('GeneralSetting', array("url" => array("controller" => "purchase_orders", "action" => "location_add"),'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'purchase-order-form'));
?>
<table class='table-form-big table-form-big-margin' style="min-width: 890px;">
	<tbody>
		<tr>
			<td>
				<?php echo $this->Form->input('id', array( 'type' => 'hidden','class' => 'input-medium', 'value' => isset($data['GeneralSetting']['id']) ? $data['GeneralSetting']['id'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 45px;"><label for="address">Title: </label></th>
			<td>
				<?php echo $this->Form->input('name', array( 'placeholder' => 'Title', 'class' => 'input-medium required', 'label' => false, 'value' => isset($data['GeneralSetting']['name']) ? $data['GeneralSetting']['name'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 45px;"><label for="address">Name: </label></th>
			<td>
				<?php echo $this->Form->input('name_address', array( 'placeholder' => 'Name', 'class' => 'input-medium required', 'label' => false, 'value' => isset($data['GeneralSetting']['name_address']) ? $data['GeneralSetting']['name_address'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 45px;"><label for="address">Address: </label></th>
			<td>
				<?php echo $this->Form->input('address', array( 'placeholder' => 'Address', 'class' => 'wide-input required', 'label' => false, 'value' => isset($data['GeneralSetting']['address']) ? $data['GeneralSetting']['address'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th><label for="city">City:</label></th>
			<td>
				<?php echo $this->Form->input('city', array( 'placeholder' => 'City', 'class' => 'input-medium', 'label' => false , 'value' => isset($data['GeneralSetting']['city']) ? $data['GeneralSetting']['city'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="province">Province:</label>
			</th>
			<td>
				<?php echo $this->Form->input('province', array( 'placeholder' => 'Province', 'class' => 'input-medium', 'label' => false , 'value' => isset($data['GeneralSetting']['province']) ? $data['GeneralSetting']['province'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="postal_code">Postal Code:</label>
			</th>
			<td>
				<?php echo $this->Form->input('postal_code', array( 'placeholder' => 'Postal Code', 'class' => 'input-medium', 'label' => false, 'value' => isset($data['GeneralSetting']['postal_code']) ? $data['GeneralSetting']['postal_code'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="country">Country:</label>
			</th>
			<td>
				<?php echo $this->Form->input('country', array( 'placeholder' => 'Country', 'class' => 'input-medium', 'label' => false , 'value' => isset($data['GeneralSetting']['country']) ? $data['GeneralSetting']['country'] : '')); ?>
			</td>
		</tr>
	</tbody>	
</table>
<?php echo $this->Form->end('Save'); ?>