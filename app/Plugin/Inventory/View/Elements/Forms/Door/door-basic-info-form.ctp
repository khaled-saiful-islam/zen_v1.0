<div id="door-basic-information" class="sub-content-detail">
  <fieldset>
    <?php if ($edit) { ?>
    <legend class="inner-legend">Edit Door</legend>
    <?php } ?>
<!--<table class="table table-bordered table-striped table-form-compact">-->
    <table class="table-form-big">
      <tr>
        <th><label for="DoorDoorStyle">Door Style:</label></th>
        <td><?php echo $this->Form->input('door_style', array('class' => 'required','placeholder'=>'Door Style')); ?></td>
        <th><label for="DoorCode">Door Code:</label></th>
        <td><?php echo $this->Form->input('code', array('class' => 'required','placeholder'=>'Door Code')); ?></td>

      </tr>
      <tr>
        <th><label for="DoorWoodSpecies">Wood Species:</label></th>
        <td><?php echo $this->Form->input('wood_species', array('class' => 'door-input-width required form-select','placeholder'=>'Wood Species', 'options' => $this->InventoryLookup->InventoryLookup('wood_species'))); ?></td>
        <th><label for="DoorCostMarkupFactor">Cost Markup Factor:</label></th>
        <td><?php echo $this->Form->input('cost_markup_factor', array('class' => 'door-input-width','placeholder'=>'Cost Factor')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorMinimumSqftSize">Minimum Sqft Size:</label></th>
        <td><?php echo $this->Form->input('minimum_sqft_size', array('class' => 'door-input-width','placeholder'=>'Minimum Size')); ?></td>
        <th><label for="DoorCustomSizeMarkup">Custom Size Markup:</label></th>
        <td><?php echo $this->Form->input('custom_size_markup', array('class' => 'door-input-width','placeholder'=>'Size Markup')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorSupplierId">Supplier:</label></th>
        <td><?php echo $this->Form->input('supplier_id', array('placeholder'=>'Supplier','empty' => true,'class'=>'form-select')); ?></td>
        <th><label for="DoorOutsideProfile">Outside Profile:</label></th>
        <td colspan="3"><?php echo $this->Form->input('cab_outside_profile', array('class' => 'required','placeholder'=>'Outside Profile')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorRoundMethod">Rounding Method:</label></th>
        <td><?php echo $this->Form->input('rounding_method', array('placeholder'=>'Doors Rounding Method','empty' => true,'class' => 'form-select','options' => $this->InventoryLookup->InventoryLookup('doors_rounding_method'))); ?></td>
        <th><label for="DoorProducLine">Product Line:</label></th>
        <td colspan="3"><?php echo $this->Form->input('product_line', array('placeholder'=>'Doors Product Line','empty' => true,'class' => 'form-select','options' => $this->InventoryLookup->InventoryLookup('doors_product_line'))); ?></td>
      </tr>
    </table>
      <table class="table-form-big table-form-big-margin">
      <tr>
        <th colspan="2">
          <label class="table-data-title">Top Door</label>
        </th>
        <th colspan="2">
          <label class="table-data-title">Bottom Door</label>
        </th>
      </tr>
      <tr>
        <th><label for="DoorWallDoorPrice">Price(Sqft):</label></th>
        <td><?php echo $this->Form->input('wall_door_price', array('placeholder'=>'Price(Sqft)','class' => 'door-input-width')); ?></td>
        <th><label for="DoorDoorPrice">Price(Sqft):</label></th>
        <td><?php echo $this->Form->input('door_price', array('placeholder'=>'Price(Sqft)','class' => 'door-input-width')); ?></td>

      </tr>
      <tr>
        <th><label for="DoorWallDoorPriceEach">Price(Each):</label></th>
        <td><?php echo $this->Form->input('wall_door_price_each', array('placeholder'=>'Price(Each)','class' => 'door-input-width')); ?></td>
        <th><label for="DoorDoorPriceEach">Price(Each):</label></th>
        <td><?php echo $this->Form->input('door_price_each', array('placeholder'=>'Price(Each)','class' => 'door-input-width')); ?></td>

      </tr>
      <tr>
        <th><label for="DoorWallDoorCode">Code:</label></th>
        <td><?php echo $this->Form->input('wall_door_code', array('placeholder'=>'Code','class' => 'door-input-width')); ?></td>
        <th><label for="DoorDoorCode">Code:</label></th>
        <td><?php echo $this->Form->input('door_code', array('placeholder'=>'Code','class' => 'door-input-width')); ?></td>

      </tr>
      <tr>
        <th colspan="2">
          <label class="table-data-title">Drawer</label>
        </th>
        <th colspan="2">
          <label class="table-data-title">Lower Drawer</label>
        </th>
      </tr>
      <tr>
        <th><label for="DoorDrawerPrice">Price(Sqft):</label></th>
        <td><?php echo $this->Form->input('drawer_price', array('placeholder'=>'Price(Sqft)','class' => 'door-input-width')); ?></td>
        <th><label for="DoorLowerDrawerPrice">Price(Sqft):</label></th>
        <td><?php echo $this->Form->input('lower_drawer_price', array('placeholder'=>'Price(Sqft)','class' => 'door-input-width')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorDrawerPriceEach">Price(Each):</label></th>
        <td><?php echo $this->Form->input('drawer_price_each', array('placeholder'=>'Price(Each)','class' => 'door-input-width')); ?></td>
        <th><label for="DoorLowerDrawerPriceEach">Price(Each):</label></th>
        <td><?php echo $this->Form->input('lower_drawer_price_each', array('placeholder'=>'Price(Each)','class' => 'door-input-width')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorDrawerCode">Code:</label></th>
        <td><?php echo $this->Form->input('drawer_code', array('placeholder'=>'Code','class' => 'door-input-width')); ?></td>
        <th><label for="DoorLowerDrawerCode">Code:</label></th>
        <td><?php echo $this->Form->input('lower_drawer_code', array('placeholder'=>'Code','class' => 'door-input-width')); ?></td>
      </tr>
    </table>
  </fieldset>
</div>