<?php if ($work_order['WorkOrder']['status'] != "Approve") { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Add', array('plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => 'po_of_work_order', $work_order['Quote']['id'], 'work-order-po', $work_order['WorkOrder']['id'], 'false'), array('data-target' => '#work-order-po-list', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Add'))); ?>
  </div>
<?php } ?>
<div id='sub-content-work-order' style="clear: both;margin-top: 36px;">
  <?php if (!empty($work_order['PurchaseOrder'])) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">      
      <thead>
        <tr class="grid-header">
					<th>PO Number</th>
					<th>PO Date</th>
          <th>Supplier</th>
					<th>Shipment Date</th>
					<th>Payment Type</th>
          <th>Taxes (G.S.T)</th>
          <th>Taxes (P.S.T)</th>
          <th>Total Amount</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach ($work_order['PurchaseOrder'] as $item) { ?>            
          <tr>
						<td>
              <?php //echo h($item['purchase_order_num']); ?>
              <?php echo $this->Html->link(h($item['purchase_order_num']), array('plugin'=>'purchase_order_manager','controller'=>'purchase_orders','action' => DETAIL, $item['id'],'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color', 'title' => __('View'))); ?>
              &nbsp;
            </td>
						<td>
							<?php if(empty($item['issued_on'])) echo "N/A"; ?>
							<?php if(!empty($item['issued_on'])) echo h($this->Util->formatDate($item['issued_on'])); ?>
						</td>
            <td>
              <?php
              $supplier = $this->InventoryLookup->SupplierForView($item['supplier_id']);
              echo h($supplier['Supplier']['name']);
              ?>
            </td>
						<td><?php echo h($this->Util->formatDate($item['shipment_date'])); ?></td>
						<td><?php echo h($item['payment_type']); ?></td>
            <td><?php echo h($item['tax_gst']); ?></td>
            <td><?php echo h($item['tax_pst']); ?></td>
            <td><?php echo number_format(h($item['total_amount']),'2','.',''); ?></td>
            <td class="actions" style="min-width: 100px;">
              <?php //echo $this->Html->link('', array('action' => DETAIL, $item['id']), array('title' => __('View'), 'class' => 'icon-edit show-detail-ajax')); ?>            
              <?php if ($work_order['WorkOrder']['status'] != "Approve") { ?>
                <?php echo $this->Html->link('', array('plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => 'edit_order', $item['id'], 'work-order-po', $work_order['WorkOrder']['id']), array('data-target' => '#work-order-po-list', 'class' => 'icon-edit ajax-sub-content', 'title' => __('Edit'))); ?>
                <?php echo $this->Form->postLink('', array('plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => DELETE, $item['id'], 'work-order-po', $work_order['WorkOrder']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $supplier['Supplier']['name'])); ?>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <table class="table table-bordered table-hover listing" style="width: 50%;">      
      <thead>
        <tr class="grid-header">
          <th>Job&nbsp;Title</th>
          <th>Supplier</th>
          <th>Payment Type</th>
          <th>Total Amount</th>
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
</div>