<div class="customers index">
  <fieldset class="content-detail">
    <legend><?php echo __('Purchase Receive'); ?></legend>
    <div align="right">
      <a class="search_link" href="#">
        <span class="search-img">Search</span>
      </a>
    </div>
    <div id="search_div">
      <?php echo $this->Form->create('PurchaseOrder', array('url' => array_merge(array('action' => 'received_view'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big search_div">
        <tr>
					<td>
						<?php echo $this->Form->input('purchase_order_num', array('placeholder' => 'PO Number', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->PurchaseOrder())); ?>
					</td>
					<td>
						<?php echo $this->Form->input('work_order_number', array('placeholder' => 'Work Order', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->getWorkOrder())); ?>
					</td>
					<td>
						<?php echo $this->Form->input('supplier_id', array('placeholder' => 'Vendor', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->Supplier())); ?>
					</td>
					<td>
						<?php echo $this->Form->input('issued_by', array('placeholder' => 'Issued By', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->getUserForPOReceive())); ?>
					</td>
					<td>
						<?php echo $this->Form->input('received', array('placeholder' => 'Status', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->getReceivedStatus())); ?>
					</td>
					<td class="width-min">
						<?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success', 'style' => 'margin-top: 0px!important;')); ?>
					</td>
				</tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>        
        <tr class="grid-header">
					<th><?php echo $this->Paginator->sort('purchase_order_num ', 'PO Number', array('direction' => 'asc')); ?></th>
					<th><?php echo $this->Paginator->sort('work_order_id ', 'WO Number'); ?></th>
					<th><?php echo $this->Paginator->sort('supplier_id', 'Vendor'); ?></th>
					<th><?php echo $this->Paginator->sort('issued_on', 'Issued On'); ?></th>
					<th><?php echo $this->Paginator->sort('issued_by', 'Issued By'); ?></th>
<!--            <th><?php echo $this->Paginator->sort('received', 'Received'); ?></th>-->
					<th><?php echo $this->Paginator->sort('received', 'Status'); ?></th>
					<th><?php echo $this->Paginator->sort('issued_by', 'Received By'); ?></th>
					<th><?php echo $this->Paginator->sort('total_amount', 'Total Amount'); ?></th>
					<th class="actions"><?php echo __(''); ?></th>
				</tr>
      </thead>
      <tbody>
        <?php foreach ($purchaseorders as $purchaseorder): ?>
          <tr>
						<td>              
							<?php echo $this->Html->link(h($purchaseorder['PurchaseOrder']['purchase_order_num']), array('action' => DETAIL, $purchaseorder['PurchaseOrder']['id']), array('title' => __($purchaseorder['Quote']['job_name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax')); ?>            
							&nbsp;
						</td>
						<td>
							<?php echo h($purchaseorder['WorkOrder']['work_order_number']); ?>
						</td>
						<td>              
							<?php echo $this->Html->link(h($purchaseorder['Supplier']['name']), array('plugin' => 'inventory', 'controller' => 'suppliers', 'action' => DETAIL, $purchaseorder['PurchaseOrder']['supplier_id'], 'modal'), array('title' => __($purchaseorder['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>            
						</td>
						<td><?php echo h($this->Util->formatDate($purchaseorder['PurchaseOrder']['issued_on'])); ?>&nbsp;</td>
						<td><?php echo h($this->InventoryLookup->getUserForPO($purchaseorder['PurchaseOrder']['issued_by'])); ?>&nbsp;</td>
<!--              <td>
							<?php
							if ($purchaseorder['PurchaseOrder']['received'] == 1) {
								echo "Yes";
							} else {
								echo "No";
							}
							?>&nbsp;
						</td>-->
						<td>
							<?php
							if ($purchaseorder['PurchaseOrder']['received'] == 0) {
								echo "Open";
							} 
							if ($purchaseorder['PurchaseOrder']['received'] == 1) {
								echo "Received";
							}
							if ($purchaseorder['PurchaseOrder']['received'] == 2) {
								echo "Partial Received";
							}
							?>&nbsp;
						</td>
						<td><?php echo h($this->InventoryLookup->getUserForPO($purchaseorder['PurchaseOrder']['received_by'])); ?>&nbsp;</td>
						<td><?php echo h($purchaseorder['PurchaseOrder']['total_amount']); ?>&nbsp;</td>
						<td class="actions">
							<?php //echo $this->Html->link('', array('action' => DETAIL, $purchaseorder['PurchaseOrder']['id']), array('title' => __('View'), 'class' => 'icon-file show-detail-ajax dialog')); ?>
							<?php
							if ($purchaseorder['PurchaseOrder']['received'] != 1) {
								echo $this->Html->link('', array('action' => 'received_save_list', $purchaseorder['PurchaseOrder']['id']), array('title' => __('Received'), 'class' => 'icon-download', 'confirm' => 'Are you want to Received?'));
							}
							else {
								echo "&nbsp;";
							}
							?>     
							<?php //echo $this->Form->postLink('', array('action' => DELETE, $purchaseorder['PurchaseOrder']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?')); 
							?>
						</td>
					</tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php echo $this->element('Common/paginator'); ?>
  </fieldset>  
</div>

<script type="text/javascript">
    
  $('.customer-combobox').combobox();
	POJS.getDialog($(".dialog"));
    
</script>
