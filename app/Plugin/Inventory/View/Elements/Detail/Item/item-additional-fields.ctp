<?php
	$data = $this->InventoryLookup->getItemAdditionDetail($id);
	if(!empty($data)){ 
		echo $this->Form->create('ItemAdditionalDetail', array("url" => array("plugin" => "inventory", "controller" => "items", "action" => "item_additional_detail",$id),'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'item-core-form ajax-form-submit', 'type' => 'post'));
		echo $this->Form->input('id', array('type' => 'hidden', 'value' => isset($data['ItemAdditionalDetail']['id']) ? $data['ItemAdditionalDetail']['id'] : ''));
?>
<table class='table-form-big'>
	<tr>
		<th><label for="ItemAdditionalDetailKeyFeature">Key Features: </label></th>
		<td><?php echo $this->Form->input('key_feature', array('value' => isset($data['ItemAdditionalDetail']['key_feature']) ? $data['ItemAdditionalDetail']['key_feature'] : '','class' => 'input-medium', 'placeholder' => 'Key Features','type' => 'textarea','rows' => '3')); ?></td>
		<th><label for="ItemAdditionalDetailDesigner">Designer: </label></th>
		<td><?php echo $this->Form->input('designer', array('value' => isset($data['ItemAdditionalDetail']['designer']) ? $data['ItemAdditionalDetail']['designer'] : '','class' => 'input-medium', 'placeholder' => 'Designer','type' => 'textarea','rows' => '3')); ?></td>
	</tr>
	<tr>
		<th><label for="ItemAdditionalDetailPackageInformation">Package Information: </label></th>
		<td><?php echo $this->Form->input('package_information', array('value' => isset($data['ItemAdditionalDetail']['package_information']) ? $data['ItemAdditionalDetail']['package_information'] : '','class' => 'input-medium', 'placeholder' => 'Package Information','type' => 'textarea','rows' => '3')); ?></td>
		<th><label for="ItemAdditionalDetailGoodToKnow">Good to know: </label></th>
		<td><?php echo $this->Form->input('good_to_know', array('value' => isset($data['ItemAdditionalDetail']['good_to_know']) ? $data['ItemAdditionalDetail']['good_to_know'] : '','class' => 'input-medium', 'placeholder' => 'Good to know','type' => 'textarea','rows' => '3')); ?></td>
	</tr>
	<tr>
		<th><label for="ItemAdditionalDetailCareInstruction">Care instructions: </label></th>
		<td><?php echo $this->Form->input('care_instruction', array('value' => isset($data['ItemAdditionalDetail']['care_instruction']) ? $data['ItemAdditionalDetail']['care_instruction'] : '','class' => 'input-medium material_cost', 'placeholder' => 'Care Instructions','type' => 'textarea','rows' => '3')); ?></td>
		<th><label for="ItemAdditionalDetailProductDescription">Product Description: </label></th>
		<td><?php echo $this->Form->input('product_description', array('value' => isset($data['ItemAdditionalDetail']['product_description']) ? $data['ItemAdditionalDetail']['product_description'] : '','class' => 'input-medium material_markup', 'placeholder' => 'Product Description','type' => 'textarea','rows' => '3')); ?></td>
	</tr>
</table>
	
<?php
		echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save'));
		echo $this->Form->end();
	}
	else {
		echo $this->Form->create('ItemAdditionalDetail', array("url" => array("plugin" => "inventory", "controller" => "items", "action" => "item_additional_detail", $id),'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'item-core-form ajax-form-submit', 'type' => 'post'));
?>
<table class='table-form-big'>
	<tr>
		<th><label for="ItemAdditionalDetailKeyFeature">Key Features: </label></th>
		<td><?php echo $this->Form->input('key_feature', array('class' => 'input-large', 'placeholder' => 'Key Features', 'type' => 'textarea','rows' => '3')); ?></td>
		<th><label for="ItemAdditionalDetailDesigner">Designer: </label></th>
		<td><?php echo $this->Form->input('designer', array('class' => 'input-large', 'placeholder' => 'Designer','type' => 'textarea','rows' => '3')); ?></td>
	</tr>
	<tr>
		<th><label for="ItemAdditionalDetailPackageInformation">Package Information: </label></th>
		<td><?php echo $this->Form->input('package_information', array('class' => 'input-large', 'placeholder' => 'Package Information','type' => 'textarea','rows' => '3')); ?></td>
		<th><label for="ItemAdditionalDetailGoodToKnow">Good to know: </label></th>
		<td><?php echo $this->Form->input('good_to_know', array('class' => 'input-large', 'placeholder' => 'Good to know','type' => 'textarea','rows' => '3')); ?></td>
	</tr>
	<tr>
		<th><label for="ItemAdditionalDetailCareInstruction">Care instructions: </label></th>
		<td><?php echo $this->Form->input('care_instruction', array('class' => 'input-large material_cost', 'placeholder' => 'Care Instructions','type' => 'textarea','rows' => '3')); ?></td>
		<th><label for="ItemAdditionalDetailProductDescription">Product Description: </label></th>
		<td><?php echo $this->Form->input('product_description', array('class' => 'input-large material_markup', 'placeholder' => 'Product Description','type' => 'textarea','rows' => '3')); ?></td>
	</tr>
</table>
<?php
		echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save'));
		echo $this->Form->end();
	}
?>