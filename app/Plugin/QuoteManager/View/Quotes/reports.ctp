<?php
$report_type_options = array(
//                "0" => "All",
    "1" => "Jobs Costing Work in progress",
    "2" => "Jobs Entered in a system",
//    "3" => "Jobs not submitted by sales person",
    "4" => "Orders Approved",
//                "5" => "Job Note"
    "6" => "Orders Pending Approval",
);
?>
<div class="quotes index">
  <fieldset class="content-detail">
    <legend>
      <?php echo __($legend); ?>
      <div class="report-buttons">
        <?php
        $url = $this->params['plugin'] . '/' . $this->params['controller'] . '/reports_print/';
        foreach ($this->params['named'] as $key => $value) {
          $url .= $key . ':' . $value . '/';
        }
        ?>
        <a href="<?php echo $this->webroot . $url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
      </div>
    </legend>
    <div id="search_div">
      <?php // echo $this->Form->create('Quote', array('url' => array_merge(array('action' => 'reports')), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <?php echo $this->Form->create('Quote', array('url' => array_merge(array('action' => 'reports'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big" style="min-width: 200px;">
        <tr>
          <td>
            <div>Report Status/Type</div>
            <?php echo $this->Form->input('report_type', array('empty' => true, 'options' => $report_type_options, 'placeholder' => 'Quote Status', 'class' => 'form-select', 'style' => 'width:250px;', 'value' => @$this->params['named']['report_type'])); ?>
          </td>
          <td>
            <div>Start Date</div>
            <?php echo $this->Form->input('start_date', array('type' => 'text', 'placeholder' => 'Start Date', 'class' => 'start-date', 'value' => @$this->params['named']['start_date'])); ?>
          </td>
          <td>
            <div>End Date</div>
            <?php echo $this->Form->input('end_date', array('type' => 'text', 'placeholder' => 'End Date', 'class' => 'end-date', 'value' => @$this->params['named']['end_date'])); ?>
          </td>
        </tr>
        <tr>
          <td>
            <div>Order Entered by Sales Person</div>
            <?php echo $this->Form->input('sales_person', array('placeholder' => 'Sales Person', 'options' => $this->InventoryLookup->salesPersonList(), 'empty' => true, 'class' => 'form-select', 'value' => @$this->params['named']['sales_person'])); ?>
          </td>
          <td>
            <div>Order Created by</div>
            <?php echo $this->Form->input('created_by', array('placeholder' => 'Sales Person', 'options' => $this->InventoryLookup->userList(), 'empty' => true, 'class' => 'form-select', 'value' => @$this->params['named']['created_by'])); ?>
          </td>
          <td class="width-min">
            <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
          </td>
        </tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>
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
              if ($item['type'] == "Counter Top")
                $counter_top += ($quote_item['price_list'][$item['code']] * $item['quantity']);
              elseif ($item['type'] == "Extra Hardware")
                $extra += ($quote_item['price_list'][$item['code']] * $item['quantity']);
              elseif ($item['type'] == "Glass Door Shelf")
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
            <th>Customer</th>
            <th>Sales Person</th>
            <th>Created by</th>

          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($quotes as $quote):
            ?>
            <tr>
              <td><?php echo h($this->Util->formatDate($quote['Quote']['created'])); ?>&nbsp;</td>
              <td><?php echo $this->Html->link(h($quote['Quote']['quote_number']), array('action' => DETAIL, $quote['Quote']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>&nbsp;</td>
              <td><?php echo h($quote['Quote']['job_detail']); ?>&nbsp;</td>
              <td>
                <?php echo $this->Html->link(h($quote['Customer']['first_name']) . " " . h($quote['Customer']['last_name']), array('plugin' => 'customer_manager', 'controller' => 'customers', 'action' => DETAIL, $quote['Customer']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color')); ?>
              </td>
              <td><?php echo $this->Html->link(h($quote['User']['first_name']) . ' ' . h($quote['User']['last_name']), array('plugin' => 'user_manager', 'controller' => 'users', 'action' => DETAIL, $quote['User']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color')); ?>&nbsp;</td>
              <td><?php echo $this->Html->link(h($quote['UserCreated']['first_name']) . ' ' . h($quote['UserCreated']['last_name']), array('plugin' => 'user_manager', 'controller' => 'users', 'action' => DETAIL, $quote['UserCreated']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color')); ?>&nbsp;</td>
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