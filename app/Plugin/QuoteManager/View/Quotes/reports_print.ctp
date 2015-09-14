
<div class="quotes index">
  <fieldset class="content-detail">
    <legend>
      <?php echo __($legend); ?>      
    </legend>
    
    <?php if (isset($report_type) && $report_type == 1) { ?>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">          
            <th><?php echo $this->Paginator->sort('quote_number'); ?></th>
            <th><?php echo $this->Paginator->sort('customer_id'); ?>&nbsp;</th>
            <th><?php echo h('Cabinet'); ?></th>
            <th><?php echo h('Counter Top'); ?></th>
            <th><?php echo h('Glass, Door & Shelf'); ?></th>
            <th><?php echo h('Extra'); ?></th>
            <th><?php echo h('Install'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $cabinet_total = 0.00;
          $install_total = 0.00;
          $counter_top_total = 0.00;
          $extra_total = 0.00;
          $glass_door_total = 0.00;
          
          foreach ($quotes as $quote):
            $quote_item = $this->InventoryLookup->ListQuoteItems($quote['Quote']['id']);
//            debug($quote_item);
            $install = 0.00;
            $counter_top = 0.00;
            $extra = 0.00;
            $glass_door = 0.00;

            foreach ($quote['QuoteInstallerPaysheet'] as $item) {
              $install += $item['total'];
            }
            foreach ($quote['CabinetOrderItem'] as $item) {
              if($item['type'] == "Counter Top")
                $counter_top += ($quote_item['price_list'][$item['code']] * $item['quantity']);
              elseif($item['type'] == "Extra Hardware")
                $extra += ($quote_item['price_list'][$item['code']] * $item['quantity']);
              elseif($item['type'] == "Glass Door Shelf")
                $glass_door += ($quote_item['price_list'][$item['code']] * $item['quantity']);
            }
            
            $cabinet_total += $quote['CabinetOrder'][0]['total_cost'];
            $install_total += $install;
            $counter_top_total += $counter_top;
            $extra_total += $extra;
            $glass_door_total += $glass_door;
            
            ?>
            <tr>           
              <td><?php echo h($quote['Quote']['quote_number']); ?>&nbsp;</td>
              <td><?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?></td>       
              <td><?php echo h($quote['CabinetOrder'][0]['total_cost']); ?>&nbsp;</td>
              <td><?php echo number_format($counter_top, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($extra, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($glass_door, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($install, '2', '.', ''); ?>&nbsp;</td>
            </tr>
          <?php endforeach; ?>
            <tr>
              <td colspan="2" class="text-right" style="font-weight: bold;">
                Total:
              </td>
              <td><?php echo number_format($cabinet_total, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($counter_top_total, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($extra_total, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($glass_door_total, '2', '.', ''); ?>&nbsp;</td>
              <td><?php echo number_format($install_total, '2', '.', ''); ?>&nbsp;</td>
            </tr>
        </tbody>
      </table>
    <?php } else { ?>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
            <th><?php echo $this->Paginator->sort('quote_number'); ?></th>
            <th><?php echo $this->Paginator->sort('job_detail'); ?></th>
            <th><?php //echo $this->Paginator->sort('customer_id');   ?>&nbsp;</th>

          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($quotes as $quote):
            ?>
            <tr>           

              <td><?php echo h($this->Util->formatDate($quote['Quote']['created'])); ?>&nbsp;</td>            
              <td><?php echo h($quote['Quote']['quote_number']); ?>&nbsp;</td>
              <td><?php echo h($quote['Quote']['job_detail']); ?>&nbsp;</td>
              <td><?php echo h($quote['UserCreated']['first_name']); ?>&nbsp;<?php echo h($quote['UserCreated']['last_name']); ?></td>       

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php } ?>
  </fieldset>

</div>
<script type="text/javascript" >
  $(".start-date").datepicker({
    dateFormat:"dd-mm-yy"
  });
  $(".end-date").datepicker({
    dateFormat:"dd-mm-yy"
  });
</script>