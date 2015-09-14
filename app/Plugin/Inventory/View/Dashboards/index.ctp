<div class="customers index">
  <fieldset class="content-detail">
    <legend><?php echo __('Dashboard'); ?></legend>
  </fieldset> 
	<?php //echo $this->Html->link('Data Migration', array('controller' => 'data_migrations','action' => 'getEdgeTape'), array()); ?> 
  <table class="table-form-big" style="width: 100%;">
    <tr>
      <th>
        <label>Quote</label>
      </th>
      <th>
        <label>Work Order</label>
      </th>
      <th>
        <label>Purchase Order</label>
      </th>
    </tr>
    <tr>
      <td>
        <table cellpadding="0" cellspacing="0" class="table-form-big" style="min-width: 300px;">
          <thead>
            <tr class="grid-header">
              <th><?php echo __('Quote Number'); ?></th>
              <th><?php echo __('Status'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            arsort($quoteDataList);
            $count = 0;
            foreach ($quoteDataList as $quote):
              ?>
              <tr>
                <td>
                  <?php echo h($quote['Quote']['quote_number']); ?>
                  &nbsp;
                </td>
                <td>
                  <?php echo h($quote['Quote']['status']); ?>
                </td>              
              </tr>
              <?php
              if ($count > 9)
                break;
              $count++;
            endforeach;
            ?>
          </tbody>
        </table>
      </td>
      <td>
        <table cellpadding="0" cellspacing="0" class="table-form-big" style="min-width: 300px;">
          <thead>
            <tr class="grid-header">
              <th><?php echo __('WO Number'); ?></th>
              <th><?php echo __('Status'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            arsort($workOrderDataList);
            foreach ($workOrderDataList as $wo):
              ?>
              <tr>
                <td>
                  <?php echo h($wo['WorkOrder']['work_order_number']); ?>
                  &nbsp;
                </td>
                <td>
                  <?php echo h($wo['WorkOrder']['status']); ?>
                </td>              
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </td>
      <td>
        <table cellpadding="0" cellspacing="0" class="table-form-big" style="min-width: 300px;">
          <thead>
            <tr class="grid-header">
              <th><?php echo __('PO Number'); ?></th>
              <th><?php echo __('Status'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            arsort($purchaseOrderDataList);
            foreach ($purchaseOrderDataList as $po):
              ?>
              <tr>
                <td>
                  <?php echo h($po['PurchaseOrder']['purchase_order_num']); ?>
                  &nbsp;
                </td>
                <td>
                  <?php echo (h($po['PurchaseOrder']['received']) == 1) ? 'Received' : 'Not Received'; ?>
                </td>              
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
</div>

