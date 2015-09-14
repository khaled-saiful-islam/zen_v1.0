<div>    
  <table class="table-form-big table-form-big-margin cabinet-order-form-table" style="min-width: 94%;">
    <tr>
      <th colspan="5">
        <label class="table-data-title">Cabinet Order</label>
      </th>
      <th colspan="5" >
        <?php
        if ($edit) {
          echo $this->Html->link('Load Order', array('controller' => 'cabinet_orders', 'action' => 'edit_order', $quote['Quote']['id']), array('data-target' => '#quote-basic-info-detail', 'class' => 'btn ajax-sub-content btn-success right', 'title' => __('View'), 'style' => 'font-weight: normal;'));
        }
        ?>
      </th>
    </tr>
  </table>
  <table class="table-form-big table-form-big-margin cabinet-order-form-table" style="min-width: 94%;">      
    <tr>
      <th><?php echo __('Door Species'); ?>:</th>
      <td>
        <?php echo h($quote['CabinetOrder'][0]['door_species']); ?>
        &nbsp;
      </td>
      <th><?php echo __('Door Style'); ?>:</th>
      <td>
        <?php echo h($quote['CabinetOrder'][0]['door_style']); ?>
        &nbsp;
      </td>
      <td style="text-align: right;">
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Stain Color'); ?>:</th>
      <td>
        <?php echo h($quote['CabinetOrder'][0]['stain_color']); ?>
        &nbsp;
      </td>
      <th><?php echo __('Rush Order'); ?>:</th>
      <td colspan="2" >
        <?php //if ($quote['CabinetOrder'][0]['rush_order']) echo 'Rush Order(4-5 weeks)'; else 'Standard Order Time(8-10 weeks)';  ?>
        <?php echo $this->Form->radio('rush_order', array('0' => 'Standard Order Time(8-10 weeks)', '1' => 'Rush Order(4-5 weeks)'), array('disabled' => 'disabled', 'value' => $quote['CabinetOrder'][0]['rush_order'], 'legend' => false)); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Pog'); ?>:</th>
      <td>
        <?php echo h($quote['CabinetOrder'][0]['pog']); ?>
        &nbsp;
      </td>
      <th><?php echo __('EdgeTapee'); ?>:</th>
      <td colspan="2">
        <?php echo h($quote['CabinetOrder'][0]['edgetape']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Drawers'); ?>:</th>
      <td>
        <?php
        echo h($quote['CabinetOrder'][0]['drawers']);
        ?>
        &nbsp;
      </td>
      <th><?php echo __('Drawer Slides'); ?>:</th>
      <td colspan="2">
        <?php
        if (isset($quote['CabinetOrder'][0]['drawer_slides'])) {
          $drw = $this->InventoryLookup->InventoryLookup('drawer_slide', $quote['CabinetOrder'][0]['drawer_slides']);
          echo h($drw[$quote['CabinetOrder'][0]['drawer_slides']]);
        }
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Delivery'); ?>:</th>
      <td>
        <?php
        if ($quote['CabinetOrder'][0]['delivery']) {
          $dl = $this->InventoryLookup->InventoryLookup('order_delivery_option', $quote['CabinetOrder'][0]['delivery']);
          echo h($dl[$quote['CabinetOrder'][0]['delivery']]);
        }
        ?>
        &nbsp;
      </td>
      <th><?php echo __('Delivery Cost'); ?>:</th>
      <td colspan="2">
        <?php
        echo h($quote['CabinetOrder'][0]['delivery_cost']);
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Extras Glass'); ?>:</th>
      <td>
        <?php
        echo h($quote['CabinetOrder'][0]['extras_glass']);
        ?>
        &nbsp;
      </td>
      <th><?php echo __('Counter Top'); ?>:</th>
      <td colspan="2">
        <?php
        echo h($quote['CabinetOrder'][0]['counter_top']);
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Installation'); ?>:</th>
      <td>
        <?php
        echo h($quote['CabinetOrder'][0]['installation']);
        ?>
        &nbsp;
      </td>
      <th><?php echo __('Discount'); ?>:</th>
      <td colspan="2">
        <?php
        echo h($quote['CabinetOrder'][0]['discount']);
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label>Sub Total</label></th>
      <td colspan="4">        
        <?php echo number_format($total_cost['total_cost'],'2','.',''); ?> 
      </td>
    </tr>
  </table>
</div>
<h2 style="font-size: 13px;float:left;"><?php echo __('Cabinet Order Item List'); ?></h2>
<?php
$order_items = $this->InventoryLookup->CabinetOrderItem($quote['CabinetOrder'][0]['id']);
if (!empty($order_items)) {
  ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th><?php echo __('Item Name'); ?></th>
        <th><?php echo __('Item Type'); ?></th>
        <th><?php echo __('Door Information'); ?></th>
        <th><?php echo __('Open Frame Door'); ?></th>
        <th><?php echo __('Do Not Drill Door'); ?></th>
        <th><?php echo __('No Door'); ?></th>
        <th><?php echo __('Quantity'); ?></th>
        <th><?php echo __('Item Cost'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($order_items as $order_item) {
        $item_info = explode('|', $order_item['CabinetOrderItem']['code']);
        $item_type = $item_info[1];
        ?>
        <tr>
          <td>
            <?php
            switch ($item_type) {
              case 'item':
                echo h($order_item['Item']['number']);
                break;
              case 'cabinet':
                echo h($order_item['Cabinet']['name']);
                break;
              case 'door':
              case 'drawer':
              case 'wall_door':
                echo h($order_item['Door']['door_style']);
                break;
            }
            ?>
          </td>
          <td>
            <?php
            echo h($item_type);
            ?>
          </td>
          <td>
            <?php
            if (isset($order_item['CabinetOrderItem']['door_information'])) {
              $di = $this->InventoryLookup->InventorySpecificLookup('order_door_information', $order_item['CabinetOrderItem']['door_information']);

              echo h($di[$order_item['CabinetOrderItem']['door_information']]);
            }
            ?>
          </td>
          <td>
            <?php echo h($this->InventoryLookup->text_yes_no($order_item['CabinetOrderItem']['open_frame_door'])); ?>
          </td>
          <td>
            <?php echo h($this->InventoryLookup->text_yes_no($order_item['CabinetOrderItem']['do_not_drill_door'])); ?>
          </td>
          <td>
            <?php echo h($this->InventoryLookup->text_yes_no($order_item['CabinetOrderItem']['no_doors'])); ?>
          </td>
          <td>
            <?php echo h($order_item['CabinetOrderItem']['quantity']); ?>
          </td>
          <td>
            <?php
            /**
             * @Sanaul
             * Please store the price in the cabinet item table as item price can be change anytine but we need to keep the track of
             * actual price during the order. Once order is finalize the price can not be changed without super admin permission.
             * Before that, price will be refresh each time to reflect the current price
             * Also do not forget to update the code accordingly, at this moment cabinet and door price showed as 0 only. Need to fix this
             */
            switch ($item_type) {
              case 'item':
                $cost = number_format($order_item['CabinetOrderItem']['quantity'] * $order_item['Item']['price'], 2, '.', '');
                
                echo $cost;
                break;
              case 'cabinet':
                $cost = number_format($order_item['CabinetOrderItem']['quantity'] * $order_item['Cabinet']['manual_unit_price'], 2, '.', '');
                
                echo $cost;
                break;
              case 'door':
                $cost = number_format($order_item['CabinetOrderItem']['quantity'] * $order_item['Door']['door_price_each'], 2, '.', '');
                
                echo $cost;
                break;
              case 'drawer':
                $cost = number_format($order_item['CabinetOrderItem']['quantity'] * $order_item['Door']['drawer_price_each'], 2, '.', '');
                
                echo $cost;
                break;
              case 'wall_door':
                $cost = number_format($order_item['CabinetOrderItem']['quantity'] * $order_item['Door']['wall_door_price_each'], 2, '.', '');
                
                echo $cost;
                break;
            }
            ?>
          </td>
        </tr>

        <?php
      }
      ?>
      <tr>
        <td colspan="7" class="text-right" style="font-weight: bold;">
          Item Total:
        </td>
        <td>
          <?php echo number_format($total_cost['item_cost'],'2','.',''); ?> 
        </td>
      </tr>
    </tbody>
  </table>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th><?php echo __('Item Name'); ?></th>
        <th><?php echo __('Item Type'); ?></th>
        <th><?php echo __('Door Information'); ?></th>
        <th><?php echo __('Open Frame Door'); ?></th>
        <th><?php echo __('Do Not Drill Door'); ?></th>
        <th><?php echo __('No Door'); ?></th>
        <th><?php echo __('Quantity'); ?></th>
        <th><?php echo __('Item Cost'); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="8">
          <label class="text-cursor-normal">No data here</label>
        </td>
      </tr>
    </tbody>
  </table>
<?php } ?>