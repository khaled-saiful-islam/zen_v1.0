<table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
  <thead>
    <tr class="grid-header">
      <th><?php echo h('Name'); ?></th>
			<th><?php echo h('Title'); ?></th>
      <th><?php echo h('Email'); ?></th>
      <th><?php echo h('Phone'); ?></th>
      <th><?php echo h('Address'); ?></th>
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
          <?php echo $full_name; ?>
        </td>
				<td>
          <?php echo $customer_address['title']; ?>
        </td>
        <td>
          <?php echo h($customer_address['email']); ?>
          &nbsp;
        </td>
        <td>
          <?php echo $this->InventoryLookup->phone_format($customer_address['phone'], $customer_address['phone_ext'], $customer_address['cell'], $customer_address['fax_number']); ?>
          &nbsp;
        </td>
        <td>
          <?php echo $this->InventoryLookup->address_format($customer_address['address'], $customer_address['city'], $customer_address['province'], $customer_address['country'], $customer_address['postal_code']); ?>
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
