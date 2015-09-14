<?php if ($supplier_contacts) { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
    <thead>
      <tr class="grid-header">
        <th><?php echo h('Name'); ?></th>
        <th><?php echo h('Address'); ?></th>
        <th><?php echo h('Phone'); ?></th>
        <th><?php echo h('Email'); ?></th>
        <th class="actions"><?php echo __(''); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($supplier_contacts as $supplier_contact):
        $fullname = h($supplier_contact['SupplierContact']['first_name']) . ' ' . h($supplier_contact['SupplierContact']['last_name'])
        ?>
        <tr>
          <td>
            <?php echo $fullname; ?>
          </td>
          <td>
            <?php echo $this->InventoryLookup->address_format($supplier_contact['SupplierContact']['address'], $supplier_contact['SupplierContact']['city'], $supplier_contact['SupplierContact']['province'], $supplier_contact['SupplierContact']['country'], $supplier_contact['SupplierContact']['postal_code']); ?>
          </td>
          <td>
            <?php echo $this->InventoryLookup->phone_format($supplier_contact['SupplierContact']['phone'], $supplier_contact['SupplierContact']['phone_ext'], $supplier_contact['SupplierContact']['cell'], $supplier_contact['SupplierContact']['fax_number']); ?>
            &nbsp;
          </td>
          <td>
            <?php echo __($supplier_contact['SupplierContact']['email']); ?>
            &nbsp;
          </td>
          <td class="actions">
            <?php //echo $this->Html->link(__(''), array('controller' => 'supplier_contacts', 'action' => DETAIL, $supplier_contact['SupplierContact']['id']), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content icon-file', 'title' => __('View Detail Contact'))); ?>
            <?php echo $this->Html->link(__(''), array('controller' => 'supplier_contacts', 'action' => 'edit_sub', $supplier_contact['SupplierContact']['id'], $supplier_id), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content icon-edit', 'title' => __('Edit Contact'))); ?>
            <?php echo $this->Form->postLink(__(''), array('controller' => 'supplier_contacts', 'action' => DELETE, $supplier_contact['SupplierContact']['id'], $supplier_id), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete Contact')), __('Are you sure you want to delete # %s?', $fullname)); ?>
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
        <th><?php echo h('Address'); ?></th>
        <th><?php echo h('Phone'); ?></th>
        <th><?php echo h('Email'); ?></th>
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