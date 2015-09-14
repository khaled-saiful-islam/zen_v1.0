<fieldset id="sub-content-address-form" class='sub-content-detail'>
  <div class="detail actions">
    <?php echo $this->Html->link('Add Contact', array('controller' => 'customer_addresses', 'action' => 'add_sub', $customer_id), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Add Contact'))); ?>
  </div>
  <?php if ($customer_addresses) { ?>
    <table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
      <thead>
        <tr class="grid-header">
          <th><?php echo h('Title'); ?></th>
					<th><?php echo h('Name'); ?></th>
          <th><?php echo h('Address'); ?></th>
          <th><?php echo h('Phone'); ?></th>
          <th><?php echo h('Email'); ?></th>
          <th class="actions"><?php echo __(''); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($customer_addresses as $customer_address):
          $full_name = h($customer_address['CustomerAddress']['first_name']) . ' ' . h($customer_address['CustomerAddress']['last_name']);
          ?>
          <tr>
						<td>
              <?php echo $customer_address['CustomerAddress']['title']; ?>
            </td>
            <td>
              <?php echo $full_name; ?>
            </td>            
            <td>
              <div class="marT5" style="font-weight: bold;">
                <?php
                $add_type = $this->InventoryLookup->CustomerAddressType($customer_address['CustomerAddress']['address_type_id']);
                echo " Address:";
                ?>
                &nbsp;
              </div>
              <?php echo $this->InventoryLookup->address_format($customer_address['CustomerAddress']['address'], $customer_address['CustomerAddress']['city'], $customer_address['CustomerAddress']['province'], $customer_address['CustomerAddress']['country'], $customer_address['CustomerAddress']['postal_code']); ?>
            </td>
            <td>            
              <?php echo $this->InventoryLookup->phone_format($customer_address['CustomerAddress']['phone'], $customer_address['CustomerAddress']['phone_ext'], $customer_address['CustomerAddress']['cell'], $customer_address['CustomerAddress']['fax_number']); ?>
              &nbsp;
            </td>
            <td> 
              <?php echo __($customer_address['CustomerAddress']['email']); ?>
              &nbsp;
            </td>
            <td class="actions">
              <?php //echo $this->Html->link(__(''), array('controller' => 'customer_addresses', 'action' => DETAIL, $customer_address['id']), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content icon-file', 'title' => __('View Detail Contact')));    ?>
              <?php echo $this->Html->link(__(''), array('controller' => 'customer_addresses', 'action' => 'edit_sub', $customer_address['CustomerAddress']['id'], $customer_id), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content icon-edit', 'title' => __('Edit Contact'))); ?>
              <!--<?php echo $this->Html->link(__(''), array('controller' => 'customer_addresses', 'action' => DELETE, $customer_address['CustomerAddress']['id'], $customer_id), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content icon-trash', 'title' => __('Delete Contact')), __('Are you sure you want to delete # ' . $full_name . '?')); ?>-->
              <?php echo $this->Form->postLink(__(''), array('controller' => 'customer_addresses', 'action' => DELETE, $customer_address['CustomerAddress']['id'], $customer_id), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete Contact')), __('Are you sure you want to delete # %s?', $full_name)); ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php }else { ?>
    <table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
      <thead>
        <tr class="grid-header">
          <th><?php echo h('Name'); ?></th>
          <th><?php echo h('Email'); ?></th>
          <th><?php echo h('Address'); ?></th>
          <th><?php echo h('Phone'); ?></th>
          <th class="actions"><?php echo __(''); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</fieldset>