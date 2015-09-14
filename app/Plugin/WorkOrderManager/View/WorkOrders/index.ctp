<?php
if ($paginate) {
  ?>
  <div class="customers index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __($legend); ?>
        <div class="report-buttons">
          <?php
            $url = $this->params['plugin'].'/'.$this->params['controller'].'/listing_report_print/';
            foreach($this->params['named'] as $key=>$value){
              $url .= $key.':'.$value.'/';
            }
          ?>
          <a href="<?php echo $this->webroot.$url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
        </div>
      </legend>
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('WorkOrder', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <div>Work Order Number</div>
              <?php echo $this->Form->input('work_order_number', array('placeholder' => 'Work Order Number')); ?>
            </td>
						<td>
              <div>Customer Name</div>
              <?php echo $this->Form->input('customer_id', array('placeholder' => 'Customer', 'options' => $this->InventoryLookup->Customer(), 'empty' => true, 'class' => 'form-select')); ?>
            </td>
						<td>
              <?php echo "<div class=''>Sales Rep</div>" . $this->Form->input('sales_rep', array('placeholder' => 'Sales Rep', 'class' => ' form-select wide-small-input', 'type' => 'select', 'options' => $this->InventoryLookup->getSalesRepresentatives(), 'empty' => '')); ?>
            </td>
						<td>
              <div>Est Shipping</div>
              <?php echo $this->Form->input('est_shipping', array('placeholder' => 'EST Shipping', 'class' => 'est_date')); ?>
            </td>
            <td>
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <?php
      //debug($workorders);
      ?>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('work_order_number'); ?></th>
						<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
						<th><?php echo "Work Order Created Date";//echo $this->Paginator->sort('created'); ?></th>
<!--            <th><?php echo $this->Paginator->sort('number'); ?></th>-->
            <th><?php echo $this->Paginator->sort('sales_person'); ?></th>
            <th><?php echo $this->Paginator->sort('est_shipping'); ?></th>
<!--            <th><?php echo $this->Paginator->sort('cabinet_cost'); ?></th>
            <th><?php echo $this->Paginator->sort('door_cost'); ?></th>
            <th><?php echo $this->Paginator->sort('drawer_cost'); ?></th>-->
<!--            <th><?php echo $this->Paginator->sort('reference'); ?></th>-->
<!--            <th><?php echo $this->Paginator->sort('created_by'); ?></th>-->
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
//          debug($workorders);
          foreach ($workorders as $workorder): ?>
            <tr>
              <td>
                <?php echo $this->Html->link(h($workorder['WorkOrder']['work_order_number']), array('action' => DETAIL, $workorder['WorkOrder']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>
                &nbsp;
              </td>
							<td>
                <?php echo @$this->Html->link(h($workorder['Quote']['Customer']['first_name']) . " " . h($workorder['Quote']['Customer']['last_name']), array('plugin' => 'customer_manager', 'controller' => 'customers', 'action' => DETAIL, $workorder['Quote']['Customer']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color', 'title' => __('View'))); ?>
              </td>
							<td><?php echo h($this->Util->formatDate($workorder['WorkOrder']['created'])); ?>&nbsp;</td>
<!--              <td>
                <?php echo $this->Html->link(h($workorder['Quote']['quote_number']), array('plugin' => 'quote_manager', 'controller' => 'quotes', 'action' => DETAIL, $workorder['Quote']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color', 'title' => __('View'))); ?>
                &nbsp;
              </td>-->
              <td>
								<?php 
									$sales = unserialize($workorder['Quote']['sales_person']); 
									$cnt = count($sales);
									$j = 1;
									for($i = 0; $i<$cnt; $i++){
										$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
										echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
										$j++;
									}						
								?>
							</td>
              <td><?php echo h($this->Util->formatDate($workorder['Quote']['est_shipping'])); ?>&nbsp;</td>
<!--              <td><?php echo h($workorder['Quote']['cabinet_cost']); ?>&nbsp;</td>
              <td><?php echo h($workorder['Quote']['door_cost']); ?>&nbsp;</td>
              <td><?php echo h($workorder['Quote']['drawer_cost']); ?>&nbsp;</td>-->
<!--              <td><?php echo h($workorder['Quote']['reference']); ?></td>-->
              <?php if(!isset($workorder['WorkOrder']['created_by']) || $workorder['WorkOrder']['created_by']==0){ ?>
              <td><?php echo "Auto Task"; ?></td>
              <?php } else { ?>
<!--              <td><?php echo $workorder['User']['first_name']; ?>&nbsp;<?php echo $workorder['User']['last_name']; ?></td>-->
              <?php } ?>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $workorder['WorkOrder']['id']), array('class' => 'icon-file', 'title' => __('View'))); ?>
                <?php //echo $this->Html->link('', array('action' => 'edit', $workorder['WorkOrder']['id']), array('class' => 'icon-edit show-detail-ajax', 'title' => __('Edit'))); ?>

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
        <th><?php echo h('Work Order Number'); ?></th>
        <th><?php echo h('Job Name'); ?></th>
        <th><?php echo h('Sales Person'); ?></th>
        <th><?php echo h('Customer'); ?></th>
        <th><?php echo h('Reference'); ?></th>
        <th><?php echo h('Est Shipping'); ?></th>
        <th><?php echo h('Cabinet Cost'); ?></th>
        <th><?php echo h('Door Cost'); ?></th>
        <th><?php echo h('Drawer Cost'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($workorders as $workorder): ?>
        <tr>
          <td>
            <?php echo h($workorder['WorkOrder']['work_order_number']); //echo $this->Html->link(h($workorder['WorkOrder']['work_order_number']), array('action' => DETAIL, $workorder['WorkOrder']['id']), array('class' => 'show-detail-ajax table-first-column-color', 'title' => __('View'))); ?>
            &nbsp;
          </td>
          <td>
            <?php echo h($workorder['Quote']['job_name']); //echo $this->Html->link(h($workorder['Quote']['job_name']), array('plugin' => 'quote_manager', 'controller' => 'quotes', 'action' => DETAIL, $workorder['Quote']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color', 'title' => __('View'))); ?>
            &nbsp;
          </td>
          <td>
						<?php 
							$sales = unserialize($workorder['Quote']['sales_person']); 
							$cnt = count($sales);
							$j = 1;
							for($i = 0; $i<$cnt; $i++){
								$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
								echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
								$j++;
							}						
						?>
					</td>
          <td>
            <?php echo @h($workorder['Quote']['Customer']['first_name']) . " " . @h($workorder['Quote']['Customer']['last_name']); //echo $this->Html->link(h($workorder['Quote']['Customer']['first_name']) . " " .h($workorder['Quote']['Customer']['last_name']), array('plugin' => 'customer_manager', 'controller' => 'customers', 'action' => DETAIL, $workorder['Quote']['Customer']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color', 'title' => __('View'))); ?>
          </td>
          <td><?php echo h($workorder['Quote']['reference']); ?>&nbsp;</td>
          <td><?php echo h($this->Util->formatDate($workorder['Quote']['est_shipping'])); ?>&nbsp;</td>
          <td><?php echo h($workorder['Quote']['cabinet_cost']); ?>&nbsp;</td>
          <td><?php echo h($workorder['Quote']['door_cost']); ?>&nbsp;</td>
          <td><?php echo h($workorder['Quote']['drawer_cost']); ?>&nbsp;</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>
<script type="text/javascript" >
  $(".est_date").datepicker({
    dateFormat:"dd-mm-yy"
  });
</script>