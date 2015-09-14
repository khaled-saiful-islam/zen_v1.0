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
        <?php echo $this->Form->create('Customer', array('url' => array_merge(array('controller' => 'builders', 'action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
              <?php $this->Form->input('customer_type', array('type' => 'hidden', 'value' => '2')); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Builder Name</div>" . $this->Form->input('enhanced_search', array('placeholder' => 'Retail Customer Name', 'class' => 'input-medium')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Email</div>" . $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'wide-small-input')); ?>
            </td>
            <td class="width-min">
              <?php echo "<div class=''>Status</div>" . $this->Form->input('status', array('placeholder' => 'Status', 'empty' => true, 'class' => 'form-select', 'options' => array(0 => 'Inactive', 1 => 'Active'))); ?>
            </td>
            <td>
              <?php echo "<div class=''>Cell Phone</div>" . $this->Form->input('cell', array('placeholder' => '(000) 000-0000', 'class' => 'wide-small-input phone-mask')); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo "<div class=''>Phone</div>" . $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'wide-small-input phone-mask')); ?>
            </td>
            <td>
              <?php echo "<div class=''>City</div>" . $this->Form->input('city', array('placeholder' => 'City', 'class' => 'wide-small-input')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Sales Rep</div>" . $this->Form->input('sales_rep', array('placeholder' => 'Sales Rep', 'class' => ' form-select wide-small-input', 'type' => 'select', 'options' => $this->CustomerLookup->getSalesRepresentatives(), 'empty' => '')); ?>
            </td>
            <td>
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success customer_submit')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('name', 'Name', array('direction' => 'asc')); ?></th>
            <th><?php echo $this->Paginator->sort('email'); ?></th>
            <th class="phone"><?php echo $this->Paginator->sort('cell'); ?></th>
            <th class="phone"><?php echo $this->Paginator->sort('phone'); ?></th>
            <th><?php echo $this->Paginator->sort('city'); ?></th>
            <th>Sales Rep</th>
            <th><?php echo $this->Paginator->sort('status'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($customers as $customer): ?>
            <tr>
              <td>
                <?php
                $customer_name = h($customer['BuilderAccount']['builder_legal_name']);
                echo $this->Html->link($customer_name, array('action' => DETAIL, $customer['Customer']['id']), array('class' => 'table-first-column-color show-tooltip'));
                ?>
                &nbsp;
              </td>
              <td><?php echo h($customer['Customer']['email']); ?>&nbsp;</td>
              <td class="phone"><?php echo h($customer['Customer']['cell']); ?>&nbsp;</td>
              <td class="phone"><?php echo h($customer['Customer']['phone']); ?>&nbsp;<?php if ($customer['Customer']['phone_ext']) echo 'Ext: ' . h($customer['Customer']['phone_ext']); ?></td>
              <td><?php echo h($customer['Customer']['city']); ?>&nbsp;</td>
              <td class="sales_rep">
                <?php
//                App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
//                $sales = new CustomerSalesRepresentetives();
//                $sales_representatives = $sales->find("all", array("conditions" => array("CustomerSalesRepresentetives.customer_id" => $customer['Customer']['id'])));
//
//                foreach ($sales_representatives as $sales) {
//                  $user = $this->CustomerLookup->showSalesRepresentatives($sales['CustomerSalesRepresentetives']['user_id']);
//                  echo $user['User']['first_name'] . " " . $user['User']['last_name'] . "</br>";
//                }
                ?>
								<?php 
									$sales = unserialize($customer['Customer']['sales_representatives']); 
									$cnt = count($sales);
									$j = 1;
									for($i = 0; $i<$cnt; $i++){
										$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
										echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
										$j++;
									}						
								?>
                &nbsp;
              </td>
              <td>
                <?php
                $status = $customer['Customer']['status'] == '1' ? "Active" : "Inactive";
                echo h($status);
                ?>
                &nbsp;
              </td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $customer['Customer']['id']), array('title' => __('View'), 'class' => 'icon-folder-open show-tooltip')); ?>
                <?php echo $this->Form->postLink('', array('action' => DELETE, $customer['Customer']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $customer_name)); ?>
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
        <th><?php echo h('Name'); ?></th>
        <th><?php echo h('E-mail'); ?></th>
        <th class="phone"><?php echo h('Cell'); ?></th>
        <th class="phone"><?php echo h('Phone'); ?></th>
        <th><?php echo h('City'); ?></th>
        <th class="sales_rep"><?php echo h('Sales Rep'); ?></th>
        <th><?php echo h('Status'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($customers as $customer): ?>
        <tr>
          <td>
            <?php
            $customer_name = h($customer['BuilderAccount']['builder_legal_name']);
            echo $customer_name;
            ?>
            &nbsp;
          </td>
          <td><?php echo h($customer['Customer']['email']); ?>&nbsp;</td>
          <td class="phone"><?php echo h($customer['Customer']['cell']); ?>&nbsp;</td>
          <td class="phone"><?php echo h($customer['Customer']['phone']); ?>&nbsp;<?php if ($customer['Customer']['phone_ext']) echo 'Ext: ' . h($customer['Customer']['phone_ext']); ?></td>
          <td><?php echo h($customer['Customer']['city']); ?>&nbsp;</td>
          <td class="sales_rep">
            <?php
//            App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
//            $sales = new CustomerSalesRepresentetives();
//            $sales_representatives = $sales->find("all", array("conditions" => array("CustomerSalesRepresentetives.customer_id" => $customer['Customer']['id'])));
//
//            foreach ($sales_representatives as $sales) {
//              $user = $this->CustomerLookup->showSalesRepresentatives($sales['CustomerSalesRepresentetives']['user_id']);
//              echo $user['User']['first_name'] . " " . $user['User']['last_name'] . "</br>";
//            }
            ?>
						<?php 
							$sales = unserialize($customer['Customer']['sales_representatives']); 
							$cnt = count($sales);
							$j = 1;
							for($i = 0; $i<$cnt; $i++){
								$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
								echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
								$j++;
							}						
						?>
            &nbsp;
          </td>
          <td>
            <?php
            $status = $customer['Customer']['status'] == '1' ? "Active" : "Inactive";
            echo h($status);
            ?>
            &nbsp;
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>
