<?php
$cabinet = null;
if (isset($this->request->data['Cabinet'])) {
  $cabinet = $this->request->data['Cabinet'];
}
?>
<div id="cabinet_information" class="sub-content-detail">
  <fieldset>
    <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>><?php echo __($legend); ?></legend>
    <table class='table-form-big'>
      <tr>
        <th><label for="CabinetName">Name:</label></th>
        <td colspan="2"><?php echo $this->Form->input('name', array('class' => 'required', 'placeholder' => 'Name')); ?></td>
        <th><label for="CabinetProductType">Cabinet Category:</label></th>
        <td colspan="2">
          <?php
          $product_type = array();
          if ($cabinet['product_type'] && is_array($cabinet['product_type'])) {
            foreach ($cabinet['product_type'] as $lookup_id) {
              $product_type[$lookup_id] = $lookup_id;
            }
          }
          echo $this->Form->input('product_type', array('options' => $this->InventoryLookup->InventoryLookup('cabinet_type'), 'class' => 'form-select required wide-input', 'multiple' => true, 'value' => $product_type));
          ?>
        </td>
      </tr>
			<tr>
        <th><label for="CabinetLabourHours">Labour Hours:</label></th>
<!--        <td colspan="2"><?php echo $this->Form->input('labour_hours', array('class' => 'required', 'placeholder' => 'Labour Hours')); ?></td>-->
				<td colspan="2">
					<?php
					echo $this->Form->input("labour_hours", array(
							"options" => $this->InventoryLookup->getTimeList(),
							"label" => false,
							"class" => "input-medium form-select",
							"empty" => false,
							"div" => false
					));
					?>

				</td>
      </tr>
      <tr>
        <th><label for="CabinetImage">Image:</label></th>
        <td colspan="2">
          <?php echo $this->Form->input('image', array('type' => 'file')); ?>
          <?php echo $this->Form->input('image_dir', array('type' => 'hidden')); ?>
          <?php
          if (!empty($cabinet['image'])) {
            echo $this->Html->image("../files/cabinet/image/{$cabinet['image_dir']}/{$cabinet['image']}");
          } else {
            echo $this->Html->image("../img/no-image.jpg");
          }
          ?>
        </td>
        <th><label for="CabinetDescription">Description:</label></th>
        <td colspan="2">
          <?php echo $this->Form->input('description', array('rows' => 3, 'cols' => 60, 'placeholder' => 'Description')); ?>
        </td>
      </tr>
      <tr>
        <th colspan="6" class="table-separator-right">
          <label class="table-data-title">Actual Dimensions</label>
        </th>
      </tr>
      <tr>
        <th><label for="CabinetActualDimensionsWidth">Width:</label></th>
        <td class="big-table-td-width"><?php echo $this->Form->input('actual_dimensions_width', array('class' => 'small-input', 'placeholder' => 'Width')); ?></td>
        <th><label for="CabinetActualDimensionsHeight">Height:</label></th>
        <td class="big-table-td-width"><?php echo $this->Form->input('actual_dimensions_height', array('class' => 'small-input', 'placeholder' => 'Height')); ?></td>
        <th><label for="CabinetActualDimensionsDepth">Depth:</label></th>
        <td class="big-table-td-width"><?php echo $this->Form->input('actual_dimensions_depth', array('class' => 'small-input', 'placeholder' => 'Depth')); ?></td>
      </tr>
    </table>
  </fieldset>
</div>