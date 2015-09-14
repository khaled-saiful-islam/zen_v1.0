<?php if ($edit) { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Edit', array('action' => EDIT, $door['Door']['id']), array('data-target' => '#door-basic-info-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
  </div>
<?php } ?>
<table class="table-form-big">
  <tr>
    <th><label for="DoorDoorStyle">Door Style:</label></th>
    <td>
      <?php echo h($door['Door']['door_style']); ?>&nbsp;
    </td>
    <th><label for="DoorCode">Door Code:</label></th>
    <td>
      <?php echo h($door['Door']['code']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorWoodSpecies">Wood Species:</label></th>
    <td>
      <?php
      $wood_species = $this->InventoryLookup->InventorySpecificLookup('wood_species', $door['Door']['wood_species']);
      if (isset($wood_species[$door['Door']['wood_species']])) {
        echo h($wood_species[$door['Door']['wood_species']]);
      }
      ?>
      &nbsp;
    </td>
    <th><label for="DoorCostMarkupFactor">Cost Markup Factor:</label></th>
    <td>
      <?php echo h($door['Door']['cost_markup_factor']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th class="width-medium"><label for="DoorMinimumSqftSize">Minimum Sqft Size:</label></th>
    <td>
      <?php echo h($door['Door']['minimum_sqft_size']); ?>&nbsp;
    </td>
    <th class="width-medium"><label for="DoorCustomSizeMarkup">Custom Size Markup:</label></th>
    <td>
      <?php echo h($door['Door']['custom_size_markup']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorSupplierId">Supplier:</label></th>
    <td>
      <?php echo $this->Html->link(h($door['Supplier']['name']), array('controller' => 'suppliers', 'action' => DETAIL, $door['Supplier']['id']), array('class' => 'show-detail-ajax')); ?>&nbsp;
    </td>
    <th><label for="DoorOutsideProfile">Outside Profile:</label></th>
    <td colspan="3">
      <?php echo h($door['Door']['cab_outside_profile']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorRoundMethod">Rounding Method:</label></th>
    <td>
      <?php
      if ($door['Door']['rounding_method']) {
        $rm = $this->InventoryLookup->InventoryLookup('doors_rounding_method', $door['Door']['rounding_method']);
        echo h($rm[$door['Door']['rounding_method']]);
      }
      ?>
      &nbsp;
    </td>
    <th><label for="DoorProducLine">Product Line:</label></th>
    <td colspan="3">
      <?php
      if ($door['Door']['product_line']) {
        $rm = $this->InventoryLookup->InventoryLookup('doors_product_line', $door['Door']['product_line']);
        echo h($rm[$door['Door']['product_line']]);
      }
      ?>
      &nbsp;
    </td>
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
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['wall_door_price']); ?>&nbsp;
    </td>
    <th><label for="DoorDoorPrice">Price(Sqft):</label></th>
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['door_price']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorWallDoorPriceEach">Price(Each):</label></th>
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['wall_door_price_each']); ?>&nbsp;
    </td>
    <th><label for="DoorDoorPriceEach">Price(Each):</label></th>
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['door_price_each']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorWallDoorCode">Code:</label></th>
    <td>
      <?php echo h($door['Door']['wall_door_code']); ?>&nbsp;
    </td>
    <th><label for="DoorDoorCode">Code:</label></th>
    <td>
      <?php echo h($door['Door']['door_code']); ?>&nbsp;
    </td>

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
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['drawer_price']); ?>&nbsp;
    </td>
    <th><label for="DoorLowerDrawerPrice">Price(Sqft):</label></th>
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['lower_drawer_price']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorDrawerPriceEach">Price(Each):</label></th>
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['drawer_price_each']); ?>&nbsp;
    </td>
    <th><label for="DoorLowerDrawerPriceEach">Price(Each):</label></th>
    <td>
      <?php echo $this->Util->formatCurrency($door['Door']['lower_drawer_price_each']); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <th><label for="DoorDrawerCode">Code:</label></th>
    <td>
      <?php echo h($door['Door']['drawer_code']); ?>&nbsp;
    </td>
    <th><label for="DoorLowerDrawerCode">Code:</label></th>
    <td>
      <?php echo h($door['Door']['lower_drawer_code']); ?>&nbsp;
    </td>
  </tr>
</table>
