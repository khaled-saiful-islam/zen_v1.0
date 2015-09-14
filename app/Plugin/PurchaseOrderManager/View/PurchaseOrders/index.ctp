<?php
if ($paginate) {
  ?>
  <div class="customers index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __($legend); ?>
        <div class="report-buttons">
          <?php
          $url = $this->params['plugin'] . '/' . $this->params['controller'] . '/listing_report_print/';
          foreach ($this->params['named'] as $key => $value) {
            $url .= $key . ':' . $value . '/';
          }
          ?>
          <a href="<?php echo $this->webroot . $url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
        </div>
      </legend>
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('PurchaseOrder', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <div>Purchase Order Number</div>
              <?php echo $this->Form->input('purchase_order_num', array('placeholder' => 'Purchase Order Number')); ?>
            </td>
            <td>
              <div>Work Order Number</div>
              <?php echo $this->Form->input('work_order_number', array('placeholder' => 'Work Order Number', 'type' => 'text')); ?>
            </td>
            <td>
              <div>Quote Number</div>
              <?php echo $this->Form->input('quote_number', array('placeholder' => 'Quote Number', 'type' => 'text')); ?>
            </td>
            <td>
              <div>Supplier</div>
              <?php echo $this->Form->input('supplier_id', array('placeholder' => 'Supplier', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->Supplier())); ?>
            </td>
            <td class="width-min">
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('purchase_order_num', 'Purchase Order Number', array('direction' => 'asc')); ?></th>
            <th><?php echo $this->Paginator->sort('work_order_id', 'Work Order Number'); ?></th>
            <th><?php echo $this->Paginator->sort('quote_number', 'Quote Number'); ?></th>
            <th><?php echo __("Supplier's Name"); ?></th>
            <th><?php echo __("Shipment Date"); ?></th>
            <th><?php echo __("Total Amount"); ?></th>
            <th class="actions"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($purchaseorders as $purchaseorder): ?>
            <tr>
              <td>
                <?php echo $this->Html->link(h($purchaseorder['PurchaseOrder']['purchase_order_num']), array('action' => DETAIL, $purchaseorder['PurchaseOrder']['id']), array('title' => __($purchaseorder['Quote']['job_name']), 'class' => 'table-first-column-color show-tooltip')); ?>
                &nbsp;
              </td>
              <td>
                <?php //echo $this->Html->link($purchaseorder['WorkOrder']['work_order_number'], array('plugin'=>'workorder_manager','controller'=>'work_orders','action' => DETAIL, $purchaseorder['WorkOrder']['id'],'modal'), array('title' => __($purchaseorder['Quote']['job_name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
                <?php echo h($purchaseorder['WorkOrder']['work_order_number']); ?>
                &nbsp;
              </td>
              <td>
                <?php echo $this->Html->link(h($purchaseorder['Quote']['quote_number']), array('plugin' => 'work_order_manager', 'controller' => 'work_orders', 'action' => DETAIL, $purchaseorder['WorkOrder']['id'], 'modal'), array('title' => __($purchaseorder['Quote']['quote_number']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
                &nbsp;
              </td>
              <td>
                <?php //echo h($purchaseorder['Supplier']['name']); ?>&nbsp;
                <?php echo $this->Html->link(h($purchaseorder['Supplier']['name']), array('plugin' => 'inventory', 'controller' => 'suppliers', 'action' => DETAIL, $purchaseorder['PurchaseOrder']['supplier_id'], 'modal'), array('title' => __($purchaseorder['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
                &nbsp;
              </td>
              <td><?php echo h($this->Util->formatDate($purchaseorder['PurchaseOrder']['shipment_date'])); ?>&nbsp;</td>
              <td><?php echo "$".number_format(h($purchaseorder['PurchaseOrder']['total_amount']), '2'); ?>&nbsp;</td></td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $purchaseorder['PurchaseOrder']['id']), array('title' => __('View'), 'class' => 'icon-file')); ?>
                <?php echo $this->Form->postLink('', array('action' => DELETE, $purchaseorder['PurchaseOrder']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?')); ?>

                <?php
                if (!empty($purchaseorder['Invoice']['id'])) {
                  echo $this->Html->link(
                          '', array('plugin' => 'invoice_manager', 'controller' => 'invoices', 'action' => DETAIL, $purchaseorder['Invoice']['id']), array('class' => 'icon-folder-close ajax-sub-content', 'data-target' => '#MainContent', 'title' => 'Invoice Detail Information')
                  );
                } else {
                  echo $this->Html->link(
                          '', array('plugin' => 'invoice_manager', 'controller' => 'invoices', 'action' => ADD, $purchaseorder['PurchaseOrder']['id'], 'Purchase Order'), array('class' => 'icon-folder-close ajax-sub-content', 'data-target' => '#MainContent', 'title' => 'Create Invoice')
                  );
                }
                ?>

              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php echo $this->element('Common/paginator'); ?>
    </fieldset>
  </div>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th><?php echo h('Purchase Order Number'); ?></th>
        <th><?php echo h('Work Order Number'); ?></th>
        <th><?php echo h('Job Name'); ?></th>
        <th><?php echo h("Supplier's Name"); ?></th>
        <th><?php echo h("Status"); ?></th>
        <th><?php echo h("Total Amount"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($purchaseorders as $purchaseorder): ?>
        <tr>
          <td>
            <?php echo h($purchaseorder['PurchaseOrder']['purchase_order_num']); //echo $this->Html->link(h($purchaseorder['PurchaseOrder']['purchase_order_num']), array('action' => DETAIL, $purchaseorder['PurchaseOrder']['id']), array('title' => __($purchaseorder['Quote']['job_name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax'));  ?>
            &nbsp;
          </td>
          <td>
            <?php //echo $this->Html->link($purchaseorder['WorkOrder']['work_order_number'], array('plugin'=>'workorder_manager','controller'=>'work_orders','action' => DETAIL, $purchaseorder['WorkOrder']['id'],'modal'), array('title' => __($purchaseorder['Quote']['job_name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal'));  ?>
            <?php echo h($purchaseorder['WorkOrder']['work_order_number']); ?>
            &nbsp;
          </td>
          <td>
            <?php echo h($purchaseorder['Quote']['job_name']); //echo $this->Html->link(h($purchaseorder['Quote']['job_name']), array('plugin' => 'work_order_manager', 'controller' => 'work_orders', 'action' => DETAIL, $purchaseorder['WorkOrder']['id'], 'modal'), array('title' => __($purchaseorder['Quote']['job_name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal'));  ?>
            &nbsp;
          </td>
          <td>
            <?php echo h($purchaseorder['Supplier']['name']); ?>&nbsp;
            <?php //echo $this->Html->link(h($purchaseorder['Supplier']['name']), array('plugin' => 'inventory', 'controller' => 'suppliers', 'action' => DETAIL, $purchaseorder['PurchaseOrder']['supplier_id'], 'modal'), array('title' => __($purchaseorder['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
            &nbsp;
          </td>
          <td>
            <?php //echo h($this->Util->formatDate($purchaseorder['PurchaseOrder']['shipment_date']));  ?>&nbsp;
            <?php
            if ($purchaseorder['PurchaseOrder']['received'] == 1) {
              echo "Closed";
            } else {
              echo "Open";
            }
            ?>&nbsp;
          </td>
          <td><?php echo h($purchaseorder['PurchaseOrder']['total_amount']); ?>&nbsp;</td></td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>

