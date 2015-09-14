<div class="detail actions">
  <?php echo $this->Html->link('Edit', array('action' => EDIT, $service['ServiceEntry']['id'], 'basic'), array('data-target' => '#service-entry-basic-info-detail', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<?php //debug($service); ?>
<table class="table-form-big">  
  <tr>
    <th>
      <label>Job Number:</label>
    </th>
    <td colspan="3">
      <?php echo h($service['WorkOrder']['work_order_number']); ?>
    </td>
  </tr>
  <tr>
    <th>
      <label>Created Date:</label>
      <label class="wide-width-date">(dd/mm/yyyy)</label>
    </th>
    <td>
      <?php echo h($this->Util->formatDate($service['ServiceEntry']['created'])); ?>
    </td>
    <th>
      <label>Booked for:</label>
      <label class="wide-width-date">(dd/mm/yyyy)</label>
    </th>
    <td>
      <?php echo h($this->Util->formatDate($service['ServiceEntry']['booked_for'])); ?>
    </td>
  </tr>
  <tr>
    <th>
      <label>Description:</label>
    </th>
    <td colspan="3">
      <?php echo h($service['ServiceEntry']['description']); ?>
    </td>
  </tr>
</table>
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
