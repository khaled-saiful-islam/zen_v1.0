<?php if ($edit) { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Add/Edit', array('action' => EDIT, $quote['Quote']['id'], 'counter-top'), array('data-target' => '#quote-counter-top-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
  </div>
<?php } ?>
<fieldset>
  <?php
  $quote['CounterTop'] = array();
  $quote['CounterTop'] = $this->InventoryLookup->ListQuoteAllItem(null, $quote['Quote']['id'], 'Counter Top');

//  debug($quote);
  if ($quote['CounterTop']) {
    ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th class="text-center"><?php echo __('To be used in'); ?></th>
          <th class="text-center"><?php echo __('Item'); ?></th>
          <th class="text-center"><?php echo __('Description'); ?></th>
          <th class="text-center"><?php echo __('Quantity'); ?></th>
          <th class="text-center"><?php echo __('Each Cost'); ?></th>
          <th class="text-center"><?php echo __('Total Cost'); ?></th>
          <th class="text-center"><?php echo __('Order Number'); ?></th>
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
        foreach ($quote['CounterTop'] as $item):
          $count++;
          $total_price+=$item['CabinetOrderItem']['quantity'] * $price_list[$item['CabinetOrderItem']['code']];
          ?>
          <tr>
            <td><?php echo h($item['CabinetOrderItem']['used_in']); ?>&nbsp;</td>
            <td><?php echo h($main_item_list[$item['CabinetOrderItem']['code']]); ?>&nbsp;</td>
            <td><?php echo h($title_list[$item['CabinetOrderItem']['code']]); ?>&nbsp;</td>
            <td class="text-center"><?php echo h($item['CabinetOrderItem']['quantity']); ?>&nbsp;</td>
            <td class="text-right"><?php echo h($price_list[$item['CabinetOrderItem']['code']]); ?>&nbsp;</td>
            <td class="text-right"><?php echo number_format($item['CabinetOrderItem']['quantity'] * $price_list[$item['CabinetOrderItem']['code']], 2, '.', ''); ?>&nbsp;</td> 
            <td><?php echo h($item['CabinetOrderItem']['order_number']); ?>&nbsp;</td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="5" style="text-align: right; font-weight: bold;"> Total Cost: </td>
          <td class="text-right"><?php echo number_format($total_price, 2, '.', ''); ?></td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
  <?php }else { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th class="text-center"><?php echo __('To be used in'); ?></th>
          <th class="text-center"><?php echo __('Item'); ?></th>
          <th class="text-center"><?php echo __('Description'); ?></th>
          <th class="text-center"><?php echo __('Quantity'); ?></th>
          <th class="text-center"><?php echo __('Each Cost'); ?></th>
          <th class="text-center"><?php echo __('Total Cost'); ?></th>
          <th class="text-center"><?php echo __('Order Number'); ?></th>
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