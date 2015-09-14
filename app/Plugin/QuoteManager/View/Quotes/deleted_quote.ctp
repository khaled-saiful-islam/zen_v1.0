<?php
if ($paginate) {
  ?>
  <div class="quotes index">
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
          <a href="<?php echo $this->webroot.$url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
        </div>
      </legend>
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
<!--      <div id="search_div">
        <?php echo $this->Form->create('Quote', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <div>Customer Name</div>
              <?php echo $this->Form->input('customer_id', array('placeholder' => 'Customer', 'options' => $this->InventoryLookup->Customer(), 'empty' => true, 'class' => 'form-select')); ?>
            </td>
            <td>
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>-->
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('quote_number'); ?></th>
            <th><?php echo $this->Paginator->sort('sales_person'); ?></th>
            <th><?php echo $this->Paginator->sort('customer_id'); ?></th>
            <th><?php echo $this->Paginator->sort('est_shipping'); ?></th>            
            <th><?php echo $this->Paginator->sort('deleted_by'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($quotes as $quote): ?>
            <tr>
              <td>
                <?php //echo $this->Html->link(h($quote['Quote']['quote_number']), array('action' => DETAIL, $quote['Quote']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>
								<?php echo $this->Html->link(h($quote['Quote']['quote_number']), array('action' => DETAIL, $quote['Quote']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color')); ?>
								&nbsp;
              </td>
              <td>
								<?php 
									$sales = unserialize($quote['Quote']['sales_person']); 
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
                <?php echo $this->Html->link(h($quote['Customer']['first_name']) . " " . h($quote['Customer']['last_name']), array('plugin' => 'customer_manager', 'controller' => 'customers', 'action' => DETAIL, $quote['Customer']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color')); ?>
              </td>
              <td><?php echo h($this->Util->formatDate($quote['Quote']['est_shipping'])); ?>&nbsp;</td>
              <td width="150"><?php echo $this->InventoryLookup->FinduserQuote($quote['Quote']['deleted_by']); ?>&nbsp;</td>
              <td class="actions">
                <?php //echo $this->Html->link('', array('action' => DETAIL, $quote['Quote']['id']), array('class' => 'icon-file', 'title' => __('View'))); ?>
                <?php if ($quote['Quote']['status'] != "Approve" && $quote['Quote']['delete'] != 1) { ?>
                  <?php echo $this->Form->postLink('', array('action' => DELETE, $quote['Quote']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $quote['Quote']['id'])); ?>
                <?php } ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
  </div>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th><?php echo h('Quote Number'); ?></th>
        <th><?php echo h('Sales Person'); ?></th>
        <th><?php echo h('Customer'); ?></th>
        <th><?php echo h('Est Shipping'); ?></th>
        <th><?php echo h('Cabinet Cost'); ?></th>
        <th><?php echo h('Door Cost'); ?></th>
        <th><?php echo h('Drawer Cost'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($quotes as $quote):?>
        <tr>
          <td>
            <?php echo h($quote['Quote']['quote_number']); ?>
            &nbsp;
          </td>
          <td>
						<?php 
							$sales = unserialize($quote['Quote']['sales_person']); 
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
            <?php echo h($quote['Customer']['first_name']) . " " . h($quote['Customer']['last_name']); //echo $this->Html->link(h($quote['Customer']['first_name']) . " " . h($quote['Customer']['last_name']), array('plugin' => 'customer_manager', 'controller' => 'customers', 'action' => DETAIL, $quote['Customer']['id'], 'modal'), array('class' => 'show-detail-ajax-modal table-first-column-color')); ?>
          </td>
          <td><?php echo h($this->Util->formatDate($quote['Quote']['est_shipping'])); ?>&nbsp;</td>
          <td><?php echo h($quote['Quote']['cabinet_cost']); ?>&nbsp;</td>
          <td><?php echo h($quote['Quote']['door_cost']); ?>&nbsp;</td>
          <td><?php echo h($quote['Quote']['drawer_cost']); ?>&nbsp;</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>
