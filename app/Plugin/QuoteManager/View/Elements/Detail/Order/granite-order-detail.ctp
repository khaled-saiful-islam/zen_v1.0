<?php 

//$total_cost = 0.00;
//debug($quote);

?>
<div class="granite-order-detail">    
  <table class="table-form-big table-form-big-margin cabinet-order-form-table" style="min-width: 94%;">
    <tr>
      <th colspan="5">
        <label class="table-data-title">Granite Order</label>
      </th>
      <th colspan="5" >
        <?php
        if ($edit) {
          echo $this->Html->link('Edit Granite Order', array('controller' => 'granite_orders', 'action' => 'edit_order', $quote['Quote']['id']), array('data-target' => '#quote-basic-info-detail', 'class' => 'btn ajax-sub-content btn-success right', 'title' => __('View'), 'style' => 'font-weight: normal;'));
        }
        ?>
      </th>
    </tr>
  </table>
  <table class='table-form-big' style="min-width: 94%;">
      <tr>
        <th><label for="">Granite:</label></th>
        <td><?php echo h($quote['GraniteOrder'][0]['granite']); ?></td>
        <th><label for="">Edge Profile: </label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['edge_profile']); ?>
        </td>
      </tr>
      <tr>
        <th><label for="">Sqft Labour:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['sqft_labour']); ?>
        </td>
        <th><label for="">Slab:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['slab']); ?>          
        </td>
      </tr>
      <tr>
        <th><label for="">Cost:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['cost']); ?>           
        </td>        
        <th><label for="">Radius:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['radius']); ?>          
        </td>        
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin" style="min-width: 94%;">
      <tr>
        <th class="wide-width"><label>Blacksplash (up to 6&quot;):</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['backsplash_up_to_six']); ?>           
        </td>
        <th class="wide-width"><label>Kitchen Under Mount:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['kitchen_under_mount']); ?>            
        </td>
        <th class="wide-width"><label>Cook Top Cutout:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['cook_top_cutout']); ?>            
        </td>
      </tr>
      <tr>
        <th class="wide-width"><label>Blacksplash (over 6&quot;):</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['backsplash_over_six']); ?>           
        </td>
        <th class="wide-width"><label>Kitchen Top Mount:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['kitchen_top_mount']); ?>          
        </td>
        <th class="wide-width"><label>Electrical Cutout:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['electrical_cutout']); ?>                    
        </td>
      </tr>
      <tr>
        <th class="wide-width"><label>Island with Raised bar:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['island_with_raised_bar']); ?>                              
        </td>
        <th class="wide-width"><label>Vanity Under Mount Snik:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['vanity_under_mount_sink']); ?>
          
        </td>
        <th class="wide-width"><label>T/M to U/M Conversion:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['tm_to_um_conversion']); ?>          
        </td>
      </tr>
      <tr>
        <th class="wide-width"><label>Island no Raised bar:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['island_no_raised_bar']); ?>           
        </td>
        <th class="wide-width"><label>Vanity Top Mount Snik:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['vanity_top_mount_sink']); ?>
        </td>
        <th><label>&nbsp;</label></th>
        <td>
          &nbsp;
        </td>
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin" style="min-width: 94%;">
      <tr>
        <th class="wide-width"><label>Travel Charge:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['travel_charge']); ?>          
        </td>
        <th class="wide-width"><label>Return Trips:</label></th>
        <td>
          <?php echo h($quote['GraniteOrder'][0]['return_trip']); ?>           
        </td>        
      </tr>
      <tr>
        <th><label for="">GST(%):</label></th>
        <td>
          <?php echo number_format($total_cost['gst_cost'],'2','.',''); ?>          
        </td>
        <th><label for="">Total Cost:</label></th>
        <td>
          <?php echo number_format($total_cost['total_cost'],'2','.',''); ?>           
        </td>
      </tr>
      <tr>
        <th><label>Discount</label></th>
        <td colspan="3">
          <?php echo h($quote['GraniteOrder'][0]['discount']); ?>
        </td>
      </tr>
    </table>
</div>
<h2 style="font-size: 13px; float:left;"><?php echo __('Granite Order Item List'); ?></h2>
<?php

$order_items = $this->InventoryLookup->GraniteOrderItem($quote['GraniteOrder'][0]['id']);
//debug($order_items);
if (!empty($order_items)) {
  ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing" style="min-width: 94%;">
    <thead>
      <tr class="grid-header">
        <th><?php echo __('Item Name'); ?></th>
        <th><?php echo __('Item Type'); ?></th>
        <th><?php echo __('Quantity'); ?></th>
        <th><?php echo __('Item Cost'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($order_items as $order_item) {
        $item_info = explode('|', $order_item['GraniteOrderItem']['code']);
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
            <?php echo h($order_item['GraniteOrderItem']['quantity']); ?>
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
                $cost = number_format($order_item['GraniteOrderItem']['quantity'] * $order_item['Item']['price'], 2, '.', '');
                
                echo $cost;
                break;
              case 'cabinet':
                $cost = number_format($order_item['GraniteOrderItem']['quantity'] * $order_item['Cabinet']['manual_unit_price'], 2, '.', '');
                
                echo $cost;
                break;
              case 'door':
                $cost = number_format($order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['door_price_each'], 2, '.', '');
                
                echo $cost;
                break;
              case 'drawer':
                $cost = number_format($order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['drawer_price_each'], 2, '.', '');
                
                echo $cost;
                break;
              case 'wall_door':
                $cost = number_format($order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['wall_door_price_each'], 2, '.', '');
                
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
        <td colspan="3" class="text-right" style="font-weight: bold;">
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