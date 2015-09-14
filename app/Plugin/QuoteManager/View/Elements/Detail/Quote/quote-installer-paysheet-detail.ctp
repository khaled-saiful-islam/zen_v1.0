<?php if ($edit) { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Add/Edit', array('action' => EDIT, $quote['Quote']['id'], 'installer-paysheet'), array('data-target' => '#quote-installer-paysheet-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
  </div>
<?php } ?>
<fieldset>
  <?php if ($quote['QuoteInstallerPaysheet']) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th>Quantity</th>
          <th>Task Description</th>
          <th>Unit</th>
          <th>Price&nbsp;Each</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 0;
        $total = 0.00;
        foreach ($quote['QuoteInstallerPaysheet'] as $item):
          $count++;
          $total += $item['total'];
          ?>
          <tr>
            <td><?php echo h($item['quantity']); ?>&nbsp;</td>
            <td><?php echo h($item['task_description']); ?>&nbsp;</td>
            <td><?php echo h($item['unit']); ?>&nbsp;</td>
            <td><?php echo h($item['price_each']); ?>&nbsp;</td>
            <td><?php echo number_format($item['total'], 2, '.', ''); ?>&nbsp;</td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" class="text-right">
            <label>Total:</label>
          </td>
          <td>
            <?php echo number_format($total, 2, '.', ''); ?>
          </td>
        </tr>
      </tbody>
    </table>
  <?php }else { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th>Quantity</th>
          <th>Task Description</th>
          <th>Unit</th>
          <th>Price&nbsp;Each</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>  
  <?php } ?>
</fieldset>