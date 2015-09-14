<div id="door-factory-information" class="sub-content-detail">
  <fieldset>
    <?php if ($edit) { ?>
    <legend class="inner-legend">Edit Factory Information</legend>
    <?php } ?>
    <script type="text/javascript">
      
        select_own_db_data('door-factory-mood',<?php echo $this->InventoryLookup->select2_json_format($factory); ?>);
        select_own_db_data('door-saw-material',<?php echo $this->InventoryLookup->select2_json_format($saw_metarial); ?>);
        
    </script>
    <table class="table-form-big">
      <tr>
        <th colspan="4">
          <label class="table-data-title">Factory Information</label>
        </th>
      </tr>
      <tr>
        <th><label for="DoorFactoryMode">Factory Mode: </label></th>
        <td>
          <?php 
            echo $this->Form->input('factory_mode', array('class' => 'door-factory-mood'));
          ?>          
        </td>
        <th><label for="DoorSawMetarial">Saw Material: </label></th>
        <td>
          <?php echo $this->Form->input('saw_metarial', array('class' => 'door-saw-material')); ?>
          <?php //echo $this->Form->input("saw_metarial", array("type" => "select", 'empty' => true, 'options' => $saw_metarial, "class" => "door-combobox required user-input")); ?>
        </td>
      </tr>
      <tr>
        <th><label for="DoorRouterCope">Router Cope: </label></th>
        <td><?php echo $this->Form->input('router_cope', array('placeholder' => 'Router Cope')); ?></td>
        <th><label for="DoorRouterProfile">Router Profile: </label></th>
        <td><?php echo $this->Form->input('router_profile', array('placeholder' => 'Router Profile')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorRouterPanel">Router Panel:</label></th>
        <td><?php echo $this->Form->input('router_panel', array('placeholder' => 'Router Panel')); ?></td>
        <th> <label for="DoorOutsideProfile">Outside Profile:</label></th>
        <td><?php echo $this->Form->input('outside_profile', array('placeholder' => 'Outside Profile')); ?></td>
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin">
      <tr>
        <th colspan="4">
          <label class="table-data-title">Door Information</label>
        </th>
      </tr>
      <tr>
        <th><label for="DoorDoorRailWidth">Rail Width:</label></th>
        <td><?php echo $this->Form->input('door_rail_width', array('class' => 'required', 'placeholder' => 'Rail Width')); ?></td>
        <th><label for="DoorDoorRailOffset">Rail Offset:</label></th>
        <td><?php echo $this->Form->input('door_rail_offset', array('class' => 'required', 'placeholder' => 'Rail Offset')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorDoorStileWidth">Stile Width:</label></th>
        <td><?php echo $this->Form->input('door_stile_width', array('class' => 'required', 'placeholder' => 'Stile Width')); ?></td>
        <th><label for="DoorDoorStitleOffset">Stile Offset:</label></th>
        <td><?php echo $this->Form->input('door_stile_offset', array('class' => 'required', 'placeholder' => 'Stile Offset')); ?></td>
      </tr>
      <tr>
        <th class="door-label-width-big"><label for="DoorDoorPanelWidthOffset">Panel Width Offset:</label></th>
        <td><?php echo $this->Form->input('door_panel_width_offset', array('class' => 'required', 'placeholder' => 'Panel Width Offset')); ?></td>
        <th class="door-label-width-big"><label for="DoorDoorPanelHeightOffset">Panel Height Offset:</label></th>
        <td><?php echo $this->Form->input('door_panel_height_offset', array('class' => 'required', 'placeholder' => 'Panel Height Offset')); ?></td>
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin">
      <tr>
        <th colspan="4">
          <label class="table-data-title">Drawer Information</label>
        </th>
      </tr>
      <tr>
        <th><label for="DoorDrawerRailWidth">Rail Width:</label></th>
        <td><?php echo $this->Form->input('drawer_rail_width', array('class' => 'required', 'placeholder' => 'Rail Width')); ?></td>
        <th><label for="DoorDrawerRailOffset">Rail Offset:</label></th>
        <td><?php echo $this->Form->input('drawer_rail_offset', array('class' => 'required', 'placeholder' => 'Rail Offset')); ?></td>
      </tr>
      <tr>
        <th><label for="DoorDrawerStitleWidth">Stile Width:</label></th>
        <td><?php echo $this->Form->input('drawer_stile_width', array('class' => 'required', 'placeholder' => 'Stile Width')); ?></td>
        <th><label for="DoorDrawerStileOffset">Stile Offset:</label></th>
        <td><?php echo $this->Form->input('drawer_stile_offset', array('class' => 'required', 'placeholder' => 'Stile Offset')); ?></td>
      </tr>
      <tr>
        <th class="door-label-width-big"><label for="DoorDrawerPanelWidthOffset">Panel Width Offset:</label></th>
        <td><?php echo $this->Form->input('drawer_panel_width_offset', array('class' => 'required', 'placeholder' => 'Panel Width Offset')); ?></td>
        <th class="door-label-width-big"><label for="DoorDrawerPanelHeightOffset">Panel Height Offset:</label></th>
        <td><?php echo $this->Form->input('drawer_panel_height_offset', array('class' => 'required', 'placeholder' => 'Panel Height Offset')); ?></td>
      </tr>
    </table>
  </fieldset>
</div>