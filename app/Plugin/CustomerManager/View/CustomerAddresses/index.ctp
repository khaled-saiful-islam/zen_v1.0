<div class="addresses index">
  <h2><?php echo __('CustomerAddresses'); ?></h2>
  <table cellpadding="0" cellspacing="0" class="table table-bordered listing">
    <thead>
      <tr class="grid-header">
				<th><?php echo h('Title'); ?></th>
        <th><?php echo h('Name'); ?></th>
        <th><?php echo h('Email'); ?></th>
        <th><?php echo h('Address'); ?></th>
        <th><?php echo h('Phone'); ?></th>
        <th class="actions"><?php echo __(''); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($customer_addresses as $customer_address):
        $full_name = h($customer_address['first_name']) . ' ' . h($customer_address['last_name']);
        ?>
        <tr>
					<td>
            <?php echo __($customer_address['title']); ?>
          </td>
          <td>
            <?php echo $full_name; ?>
          </td>
          <td> 
            <?php echo __($customer_address['email']); ?>
            &nbsp;
          </td>
          <td>
            <div class="marT5" style="font-weight: bold;">
              <?php
              $add_type = $this->InventoryLookup->CustomerAddressType($customer_address['address_type_id']);
              echo __($add_type[$customer_address['address_type_id']]) . " Address:";
              ?>
              &nbsp;
            </div>
            <?php echo __($customer_address['address']); ?><br/>
            <div class="marT5">
              <?php echo __($customer_address['city']); ?>,
              <?php echo __($customer_address['province']); ?>
            </div>
            <div class="marT5">
              Canada-<?php echo __($customer['Customer']['postal_code']); ?>
            </div>
            &nbsp;
          </td>
          <td>
            <div class="marT5">
              <label class="no-width">Phone: 
                <?php echo __($customer_address['phone']); ?>&nbsp;
                Ext:<?php echo __($customer_address['phone_ext']); ?>&nbsp;<br/>
                <label class="no-width">Cell: 
                  <?php echo __($customer_address['cell']); ?>&nbsp;<br/>
                  <label class="no-width">Fax:
                    <?php echo __($customer_address['fax_number']); ?>&nbsp;
                  </label>
                </label>
            </div>
            &nbsp;
          </td>
          <td class="actions">
            <?php //echo $this->Html->link(__(''), array('controller' => 'customer_addresses', 'action' => DETAIL, $customer_address['id']), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content icon-file', 'title' => __('View Detail Contact'))); ?>
            <?php echo $this->Html->link(__(''), array('controller' => 'customer_addresses', 'action' => 'edit_sub', $customer_address['id'], $customer_id), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content icon-edit', 'title' => __('Edit Contact'))); ?>
            <!--<?php echo $this->Html->link(__(''), array('controller' => 'customer_addresses', 'action' => DELETE, $customer_address['id'], $customer_id), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content icon-trash', 'title' => __('Delete Contact')), __('Are you sure you want to delete # ' . $full_name . '?')); ?>-->
            <?php echo $this->Form->postLink(__(''), array('controller' => 'customer_addresses', 'action' => DELETE, $customer_address['id'], $customer_id), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete Contact')), __('Are you sure you want to delete # %s?', $full_name)); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>