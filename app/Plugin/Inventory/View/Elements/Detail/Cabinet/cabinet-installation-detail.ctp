<fieldset>
  <?php if ($edit) { ?>
    <div class="detail actions">
      <?php echo $this->Html->link('Add/Edit', array('action' => EDIT, $cabinet['Cabinet']['id'], 'installation'), array('data-target' => '#cabinet_installation', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
    </div>
  <?php } ?>
  <?php if ($cabinet['CabinetInstallation']) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing" style="width: 60%;">
      <thead>
        <tr class="grid-header">
          <th class="min-witdh"><?php echo h('Installation Code'); ?></th>
          <th class="min-witdh"><?php echo h('Description'); ?></th>
          <th class="min-witdh"><?php echo h('Price'); ?></th>
          <th class="min-witdh"><?php echo h('Price Unit'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 0;
        $total_price = 0;
        foreach ($cabinet['CabinetInstallation'] as $item):
          $count++;
          $total_price+=$item['price'];
          $odd_even = 'odd';
          if (($count % 2) == 0) {
            $odd_even = 'even';
          }
          ?>
          <tr class="<?php //echo $odd_even;   ?>">
            <td><?php echo h($item['name']); ?>&nbsp;</td>
            <td><?php echo h($item['value']); ?>&nbsp;</td>
            <td class="text-right"><?php echo h($this->Util->formatCurrency($item['price'])); ?>&nbsp;</td>
            <td><?php echo h($item['price_unit']); ?>&nbsp;</td>
          </tr>
        <?php endforeach; ?>
  <!--        <tr>
        <td colspan="2" style="text-align: right; font-weight: bold;"> Total Cost: </td>
        <td><?php echo number_format($total_price, 2, '.', ''); ?></td>
        <td>&nbsp;</td>
      </tr>-->
      </tbody>
    </table>
  <?php } else { ?>
    <table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
      <thead>
        <tr class="grid-header">
          <th class="min-witdh"><?php echo h('Installation Code'); ?></th>
          <th class="min-witdh"><?php echo h('Description'); ?></th>
          <th class="min-witdh"><?php echo h('Price'); ?></th>
          <th class="min-witdh"><?php echo h('Price Unit'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="4">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</fieldset>