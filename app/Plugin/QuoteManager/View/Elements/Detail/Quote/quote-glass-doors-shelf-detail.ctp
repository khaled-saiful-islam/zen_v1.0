<?php if ($edit) { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Add/Edit', array('action' => EDIT, $quote['Quote']['id'], 'door-shelf'), array('data-target' => '#quote-glass-doors-shelf-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
  </div>
<?php } ?>
<fieldset>
  <?php 
  $quote['QuoteGlassDoorShelf'] = array();
  $quote['QuoteGlassDoorShelf'] = $this->InventoryLookup->ListQuoteAllItem(null, $quote['Quote']['id'], 'Glass Door Shelf');
  
  if ($quote['QuoteGlassDoorShelf']) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing" >
      <thead>
        <tr class="grid-header">
          <th class="text-center">Description</th>
          <th class="text-center">Item</th>          
          <th class="text-center">Quantity</th>
          <th class="text-center">Each Cost</th>
          <th class="text-center">Total Cost</th>
          <th class="text-center">Order Number</th> 
          <th class="text-center">Optional Color</th> 
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 0;
        $total_price = 0.00;
        $all_items = $this->InventoryLookup->ListAllTypesOfItems();
        $main_item_list = $all_items['main_list'];
        $price_list = $all_items['price_list'];
        $title_list = $all_items['title_list'];
        foreach ($quote['QuoteGlassDoorShelf'] as $item):
          $count++;
          $total_price+=$item['CabinetOrderItem']['quantity'] * $price_list[$item['CabinetOrderItem']['code']];
          ?>
          <tr>
            <td><?php echo h($title_list[$item['CabinetOrderItem']['code']]); ?>&nbsp;</td>
            <td><?php echo h($main_item_list[$item['CabinetOrderItem']['code']]); ?>&nbsp;</td>            
            <td class="text-center"><?php echo h($item['CabinetOrderItem']['quantity']); ?>&nbsp;</td>
            <td class="text-right"><?php echo h($price_list[$item['CabinetOrderItem']['code']]); ?>&nbsp;</td>
            <td class="text-right"><?php echo number_format($item['CabinetOrderItem']['quantity'] * $price_list[$item['CabinetOrderItem']['code']], 2, '.', ''); ?>&nbsp;</td> 
            <td><?php echo h($item['CabinetOrderItem']['order_number']); ?>&nbsp;</td>
            <td><?php echo h($item['CabinetOrderItem']['optional_color']); ?>&nbsp;</td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" style="text-align: right; font-weight: bold;"> Total Cost: </td>
          <td class="text-right"><?php echo number_format($total_price, 2, '.', ''); ?></td>
          <td colspan="2" >&nbsp;</td>
        </tr>
      </tbody>
    </table>
  <?php }else { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th class="text-center">Description</th>
          <th class="text-center">Item</th>          
          <th class="text-center">Quantity</th>
          <th class="text-center">Each Cost</th>
          <th class="text-center">Total Cost</th>
          <th class="text-center">Order Number</th> 
          <th class="text-center">Optional Color</th> 
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="7">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>  
  <?php } ?>
</fieldset>