<br/>
<div class="service-report">
  <?php
//debug($service);
//debug($quotes);
  ?>
  <table class="report-left-box-info">
    <tr>
      <th>
        <label>Name</label>
      </th>
      <td colspan="3">
        <?php echo h($quotes['Customer']['first_name']); ?>
        &nbsp;
        <?php echo h($quotes['Customer']['last_name']); ?>
      </td>
    </tr>
    <tr>
      <th>
        <label>Address</label>
      </th>
      <td colspan="3">
        <?php echo h($quotes['Quote']['address']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>City</label>
      </th>
      <td>
        <?php echo h($quotes['Quote']['city']); ?>
        &nbsp;
      </td>
      <th>
        <label>Province</label>
      </th>
      <td>
        <?php echo h($quotes['Quote']['province']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Phone</label>
      </th>
      <td>
        <?php echo h($quotes['Customer']['phone']); ?>
        &nbsp;
        <?php //if (isset($quotes['Customer']['phone_ext'])) echo 'Ext. ' . h($quotes['Customer']['phone_ext']); ?>
      </td>
      <th>
        <label>Postal Code</label>
      </th>
      <td>
        <?php echo h($quotes['Quote']['postal_code']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Sales Person</label>
      </th>
      <td colspan="3">
        <?php echo h($quotes['User']['first_name']); ?>
        &nbsp;
        <?php echo h($quotes['User']['last_name']); ?>
      </td>
    </tr>
    <tr>
      <th>
        <label>Ship Date</label>
      </th>
      <td colspan="3">
        <?php echo $this->Util->formatDate(h($quotes['Quote']['est_shipping'])); ?>
        &nbsp;
      </td>
    </tr>
  </table>

  <table class="report-right-box-info">
    <tr>
      <th>
        <label>Start Date</label>
      </th>
      <td>
        <?php echo date('d/m/Y', strtotime(h($quotes['Quote']['created']))); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Color</label>
      </th>
      <td>
        <?php echo h($quotes['Quote']['color']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Style</label>
      </th>
      <td>
        <?php echo h($quotes['Quote']['style']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>CabOrder#</label>
      </th>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Builder#</label>
      </th>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Builder PO</label>
      </th>
      <td>
        <?php echo h($quotes['Quote']['builder_po']); ?>
        &nbsp;
      </td>
    </tr>  
  </table>

  <table class="service-detail">
    <tr class="top-row">
      <td colspan="4">
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Service Date:</label>
      </th>
      <td>
        <?php echo date('l, d M, Y', strtotime(h($service['ServiceEntry']['created']))); ?>&nbsp;
      </td>
      <th>
        <label>Service Booked for:</label>
      </th>
      <td>
        <?php echo $this->Util->formatDate(h($service['ServiceEntry']['booked_for'])); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Entered By:</label>
      </th>
      <td>
        <?php echo h($service['User']['first_name']); ?>&nbsp;<?php echo h($service['User']['last_name']); ?>
      </td>
      <th class="wide-width">
        <label>Service Resolved On:</label>
      </th>
      <td>
        <?php if (isset($service['ServiceEntry']['resolved_on'])) echo date('l, d M, Y', strtotime(h($service['ServiceEntry']['resolved_on']))); ?>
        &nbsp;
      </td>
    </tr>
  </table>
  <h2 style="float: left; font-size: 14px; margin-left: 32px; width: 100%;">
    <?php echo __('Service Items Information'); ?>
  </h2>
  <table class="table table-bordered table-hover listing table-form-big-margin">
    <thead>
      <tr class="grid-header">          
        <th><?php echo __('Number'); ?></th>
        <th><?php echo __('Description'); ?></th>
        <th><?php echo __('Quantity'); ?></th>
        <th><?php echo __('Each Cost'); ?></th>
        <th><?php echo __('Total Cost'); ?></th>
        <th><?php echo __('Reason'); ?></th>
        <th class="width-medium"><?php echo __('Purchase Order'); ?></th>
      </tr>
    </thead>
    <tbody>        
      <?php
      $total_cost = 0.00;
      $item_total_cost = 0.00;
      if (!empty($service['ScheduleItem'])) {
        foreach ($service['ScheduleItem'] as $index => $value) {
          if ($value['type'] == 'Service') {
            $item_info = explode('|', $value['code']);
            $item_type = $item_info[1];
            ?>
            <tr>
              <td>
                <?php
                switch ($item_type) {
                  case 'item':
                    echo h($service['Item'][$index]['number']);
                    break;
                  case 'cabinet':
                    echo h($service['Cabinet'][$index]['name']);
                    break;
                  case 'door':
                  case 'drawer':
                  case 'wall_door':
                    echo h($service['Door'][$index]['door_style']);
                    break;
                }
                ?>
              </td>
              <td>
                <?php
                switch ($item_type) {
                  case 'item':
                    echo h($service['Item'][$index]['item_title']);
                    break;
                  case 'cabinet':
                    echo h($service['Cabinet'][$index]['description']);
                    break;
                  case 'door':
                  case 'drawer':
                  case 'wall_door':
                    echo h($service['Door'][$index]['door_style']);
                    break;
                }
                ?>
              </td>
              <td>
                <?php echo $service['ScheduleItem'][$index]['quantity']; ?>
              </td>          
              <td>
                <?php
                switch ($item_type) {
                  case 'item':
                    echo number_format($service['Item'][$index]['price'], 2, '.', '');
                    break;
                  case 'cabinet':
                    echo number_format($service['Cabinet'][$index]['manual_unit_price'], 2, '.', '');
                    break;
                  case 'door':
                    echo number_format($service['Door'][$index]['door_price_each'], 2, '.', '');
                  case 'drawer':
                    echo number_format($service['Door'][$index]['drawer_price_each'], 2, '.', '');
                  case 'wall_door':
                    echo number_format($service['Door'][$index]['wall_door_price_each'], 2, '.', '');
                    break;
                }
                ?>

              </td>
              <td>
                <?php
                switch ($item_type) {
                  case 'item':
                    $cost = number_format($service['ScheduleItem'][$index]['quantity'] * $service['Item'][$index]['price'], 2, '.', '');
                    $item_total_cost += $cost;
                    echo $cost;
                    break;
                  case 'cabinet':
                    $cost = number_format($service['ScheduleItem'][$index]['quantity'] * $service['Cabinet'][$index]['manual_unit_price'], 2, '.', '');
                    $item_total_cost += $cost;
                    echo $cost;
                    break;
                  case 'door':
                    $cost = number_format($service['ScheduleItem'][$index]['quantity'] * $service['Door'][$index]['door_price_each'], 2, '.', '');
                    $item_total_cost += $cost;
                    echo $cost;
                    break;
                  case 'drawer':
                    $cost = number_format($service['ScheduleItem'][$index]['quantity'] * $service['Door'][$index]['drawer_price_each'], 2, '.', '');
                    $item_total_cost += $cost;
                    echo $cost;
                    break;
                  case 'wall_door':
                    $cost = number_format($service['ScheduleItem'][$index]['quantity'] * $service['Door'][$index]['wall_door_price_each'], 2, '.', '');
                    $item_total_cost += $cost;
                    echo $cost;
                    break;
                }
                ?>
              </td>
              <td>          
                <?php
                //echo $service['ScheduleItem'][$index]['reason'];
                if (isset($service['ScheduleItem'][$index]['reason']) && !empty($service['ScheduleItem'][$index]['reason'])) {
                  $di = $this->InventoryLookup->InventorySpecificLookup('service_techs', $service['ScheduleItem'][$index]['reason']);

                  echo h($di[$service['ScheduleItem'][$index]['reason']]);
                }
                ?>
              </td>
              <td style="width: 140px;"> 
                <?php echo h($service['PurchaseOrder'][$index]['purchase_order_num']); ?>
              </td>            
            </tr>
            <?php
          }
        }
        ?>
        <tr>
          <td colspan="4" class="text-right" style="font-weight: bold;">
            Total:	
          </td>
          <td>
            <span class='data-item-total-cost'><?php echo number_format($item_total_cost, 2, '.', ''); ?></span>
          </td>
          <td colspan="2">
            &nbsp;
          </td>
        </tr>        
      </tbody>
    <?php } else { ?>
      <tr>
        <td colspan="7" class="text-right" style="font-weight: bold;">
          <label class="text-cursor-normal">No data here</label>
        </td>
      </tr>   
    <?php } ?>
  </table>
  <h2 style="float: left; font-size: 14px; margin-left: 32px; width: 100%;">
    <?php echo __('Service Status Information'); ?>
  </h2>
  <?php echo $this->element('Detail/Service/service-status-info', array('edit' => false)); ?>
  <table style="width: 732px; border: none; margin-top: 20px;margin-bottom: 30px;">
    <tr>
      <td>
        Service Completed By ___________________________________________________________ on ______-______-______
      </td>
    </tr>
  </table>
</div>