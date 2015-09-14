<div id="cabinet_pricing" class="tab-pane">
  <fieldset>
    <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>>Edit Cabinet Pricing and Accessibility</legend>
    <table class='table-form-big'>
      <tr>
        <th colspan="4">
          <label class="table-data-title">Pricing Information</label>
        </th>
      </tr>
      <tr>
        <th for="CabinetTaping">Taping(feet):</th>
        <td><?php echo $this->Form->input('taping', array('class' => 'small-input numeric','placeholder'=>'Tapping')); ?>&nbsp;($0.20 per foot)</td>
        <th for="CabinetDrilling">Drilling:</th>
        <td><?php echo $this->Form->input('drilling', array('class' => 'small-input','placeholder'=>'Drilling')); ?></td>
      </tr>
      <tr>
        <th for="CabinetbackCutting">Back Cutting:</th>
        <td><?php echo $this->Form->input('back_cutting', array('class' => 'small-input','placeholder'=>'Cutting')); ?></td>
        <th for="CabinetAssemblyBoxCount" class="width-medium">Assembly Box Count:</th>
        <td><?php echo $this->Form->input('assembly_box_count', array('class' => 'small-input','placeholder'=>'Count')); ?></td>
      </tr>
      <tr>
        <th for="CabinetLeftGablePrice">Left Gable Price:</th>
        <td><?php echo $this->Form->input('left_gable_price', array('class' => 'money-input','placeholder'=>'Left Gable Price')); ?></td>
        <th for="CabinetRightGablePrice">Right Gable Price:</th>
        <td><?php echo $this->Form->input('right_gable_price', array('class' => 'money-input','placeholder'=>'Left Gable Price')); ?></td>
      </tr>
      <tr>
        <th for="CabinetManualUnitPrice" class="width-medium">Manual Unit Price:</th>
        <td colspan="3"><?php echo $this->Form->input('manual_unit_price', array('class' => 'money-input','placeholder'=>'Manual Unit Price')); ?></td>
      </tr>
    </table>
<!--    <table class="table-form-big table-form-big-margin">
      <tr>
        <th colspan="4">
          <label class="table-data-title">Accessibility Information</label>
        </th>
      </tr>
      <tr>
        <th for="CabinetItemAccess">Item Access:</th>
        <td><?php echo $this->Form->input('item_access', array('options' => $this->InventoryLookup->option_public_access(),'class' => 'form-select')); ?></td>
        <th for="CabinetProducLine">Product Line:</th>
        <td><?php echo $this->Form->input('product_line', array('placeholder'=>'Product Line','options' => $this->InventoryLookup->InventoryLookup('product_line'), 'empty' => true,'class' => 'form-select')); ?></td>
      </tr>
      <tr>
        <th>&nbsp;</th>
        <td colspan="3" class="radio-lable">
          <?php echo $this->Form->input('include_on_door_list', array('label' => 'Include On Door List', 'div' => true)); ?>
          <?php echo $this->Form->input('include_on_finishing_list', array('label' => 'Include On Finishing List', 'div' => true)); ?>
        </td>
      </tr>
    </table>-->
  </fieldset>
</div>