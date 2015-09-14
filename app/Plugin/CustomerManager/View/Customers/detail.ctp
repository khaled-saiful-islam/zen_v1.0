<div class="customers view">
  <?php
  if (isset($modal) && $modal == "modal") {
    ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="add_item_label" style="font-size: 16px;">
        Customer:&nbsp;<?php echo h($customer['Customer']['first_name']); ?>
        <?php echo h($customer['Customer']['last_name']); ?>
      </h3>
    </div>
    <?php echo $this->element('Detail/Customer/customer-basic-info'); ?>
  <?php } else { ?>
    <fieldset>
      <div style="float: left; width: 95%;"><legend><?php echo $title_prefix . ': '; ?>&nbsp;
        <?php echo h($customer['Customer']['first_name']); ?>
        &nbsp;
        <?php echo h($customer['Customer']['last_name']); ?></legend>
			</div>
			<div class="report-buttons" style="float: right;">
				<?php
				echo $this->Html->link(
								'', array('controller' => 'customers', 'action' => 'print_detail', $customer['Customer']['id']), array('class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information')
				);
				?>
			</div>
			<div style="clear: both;"></div>
      <ul class="nav nav-tabs form-tab-nav" id="item-form-tab-nav">
        <li class="active"><a href="#customer-basic-info" data-toggle="tab"><?php echo __($title_prefix . ' Information'); ?></a></li>
        <li><a href="#customer-address" data-toggle="tab"><?php echo __($title_prefix . ' Contact'); ?></a></li>
        <li><a href="#project" data-toggle="tab"><?php echo __('Project'); ?></a></li>
      </ul>

      <div class="tab-content">
        <fieldset id="customer-basic-info" class="tab-pane active">
          <?php echo $this->element('Detail/Customer/customer-basic-info', array('edit' => true)); ?>
        </fieldset>
        <fieldset id="customer-address" class="tab-pane">
          <?php echo $this->element('Detail/Customer/customer-contact-info', array('edit' => true)); ?>
        </fieldset>
				<fieldset id="project" class="tab-pane">
          <?php echo $this->element('Detail/Customer/project', array('edit' => true)); ?>
        </fieldset>
        <!--<fieldset id="customer-account-credit-info" class="tab-pane">
        <?php echo $this->element('Detail/Customer/customer-account-credit-info'); ?>
        </fieldset>-->
      </div>
    </fieldset>
  <?php } ?>
</div>
<!--<div class="related">
  <h3><?php echo __('Related Sales Representetives'); ?></h3>
<?php if (!empty($customer['SalesRepresentetive'])): ?>
                                  <table cellpadding = "0" cellspacing = "0">
                                  <tr>
                                    <tr><th><?php echo __('Id'); ?></th>
                                    <tr><th><?php echo __('User Id'); ?></th>
                                    <tr><th><?php echo __('Customer Id'); ?></th>
                                    <tr><th><?php echo __('Visit Date'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                  </tr>
  <?php
  $i = 0;
  foreach ($customer['SalesRepresentetive'] as $salesRepresentetive):
    ?>
                                                                    <tr>
                                                                      <td><?php echo $salesRepresentetive['id']; ?></td></tr>
                                                                      <td><?php echo $salesRepresentetive['user_id']; ?></td></tr>
                                                                      <td><?php echo $salesRepresentetive['customer_id']; ?></td></tr>
                                                                      <td><?php echo $salesRepresentetive['visit_date']; ?></td></tr>
                                                                      <td class="actions">
    <?php echo $this->Html->link(__('View'), array('controller' => 'sales_representetives', 'action' => 'view', $salesRepresentetive['id'])); ?>
    <?php echo $this->Html->link(__('Edit'), array('controller' => 'sales_representetives', 'action' => 'edit', $salesRepresentetive['id'])); ?>
    <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sales_representetives', 'action' => 'delete', $salesRepresentetive['id']), null, __('Are you sure you want to delete # %s?', $salesRepresentetive['id'])); ?>
                                                                      </td></tr>
                                                                    </tr>
  <?php endforeach; ?>
                                  </table>
<?php endif; ?>

  <div class="actions">
    <ul>
      <li><?php echo $this->Html->link(__('New Sales Representetive'), array('controller' => 'sales_representetives', 'action' => 'add')); ?> </li>
    </ul>
  </div>
</div>-->