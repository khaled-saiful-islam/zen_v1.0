<?php if ($edit) { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Edit', array('action' => EDIT, $door['Door']['id'], 'factory'), array('data-target' => '#door-factory-info-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
  </div>
<?php } ?>
<fieldset class="sub-content-detail">
  <table class="table-form-big">
    <tr>
      <th colspan="4">
        <label class="table-data-title">Factory Information</label>
      </th>
    </tr>
    <tr>
      <th><label for="DoorFactoryMode">Factory Mode: </label></th>
      <td>
        <?php echo h($door['Door']['factory_mode']); ?>
        &nbsp;         
      </td>
      <th><label for="DoorSawMetarial">Saw Material: </label></th>
      <td>
        <?php echo h($door['Door']['saw_metarial']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="DoorRouterCope">Router Cope: </label></th>
      <td>
        <?php echo h($door['Door']['router_cope']); ?>&nbsp;
      </td>
      <th><label for="DoorRouterProfile">Router Profile: </label></th>
      <td>
        <?php echo h($door['Door']['router_profile']); ?>&nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="DoorRouterPanel">Router Panel:</label></th>
      <td>
        <?php echo h($door['Door']['router_panel']); ?>&nbsp;
      </td>
      <th> <label for="DoorOutsideProfile">Outside Profile:</label></th>
      <td>
        <?php echo h($door['Door']['outside_profile']); ?>&nbsp;
      </td>
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
      <td>
        <?php echo h($door['Door']['door_rail_width']); ?>&nbsp;        
      </td>
      <th><label for="DoorDoorRailOffset">Rail Offset:</label></th>
      <td>
        <?php echo h($door['Door']['door_rail_offset']); ?>&nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="DoorDoorStileWidth">Stile Width:</label></th>
      <td>
        <?php echo h($door['Door']['door_stile_width']); ?>&nbsp;
      </td>
      <th><label for="DoorDoorStitleOffset">Stile Offset:</label></th>
      <td>
        <?php echo h($door['Door']['door_stile_offset']); ?>&nbsp;
      </td>
    </tr>
    <tr>
      <th class="door-label-width-big"><label for="DoorDoorPanelWidthOffset">Panel Width Offset:</label></th>
      <td>
        <?php echo h($door['Door']['door_panel_width_offset']); ?>&nbsp;
      </td>
      <th class="door-label-width-big"><label for="DoorDoorPanelHeightOffset">Panel Height Offset:</label></th>
      <td>
        <?php echo h($door['Door']['door_panel_height_offset']); ?>&nbsp;
      </td>
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
      <td>
        <?php echo h($door['Door']['drawer_rail_width']); ?>&nbsp;
      </td>
      <th><label for="DoorDrawerRailOffset">Rail Offset:</label></th>
      <td>
        <?php echo h($door['Door']['drawer_rail_offset']); ?>&nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="DoorDrawerStitleWidth">Stile Width:</label></th>
      <td>
        <?php echo h($door['Door']['drawer_stile_width']); ?>&nbsp;
      </td>
      <th><label for="DoorDrawerStileOffset">Stile Offset:</label></th>
      <td>
        <?php echo h($door['Door']['drawer_stile_offset']); ?>&nbsp;
      </td>
    </tr>
    <tr>
      <th class="door-label-width-big"><label for="DoorDrawerPanelWidthOffset">Panel Width Offset:</label></th>
      <td>
        <?php echo h($door['Door']['drawer_panel_width_offset']); ?>&nbsp;
      </td>
      <th class="door-label-width-big"><label for="DoorDrawerPanelHeightOffset">Panel Height Offset:</label></th>
      <td>
        <?php echo h($door['Door']['drawer_panel_height_offset']); ?>&nbsp;
      </td>
    </tr>
  </table>
</fieldset>
