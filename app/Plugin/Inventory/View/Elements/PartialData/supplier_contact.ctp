<div class="detail actions">
  <?php echo $this->Html->link('Add Contact', array('action' => 'add_sub', $supplier['Supplier']['id'], 'controller' => 'supplier_contacts'), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Add Contact'))); ?>
</div>
<fieldset id="sub-content-contact-form" class='sub-content-detail'>
  <?php if ($supplier['SupplierContact']) { ?>
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
        foreach ($supplier_contacts as $supplier_contact):
          $firstname = h($supplier_contact['first_name']) . ' ' . h($supplier_contact['last_name'])
          ?>
          <tr>
            <td>
              <?php echo $firstname; ?>
            </td>
            <td>
              <?php echo h($supplier_contact['title']); ?>
              &nbsp;
            </td>
            <td>
              <?php echo h($supplier_contact['email']); ?>
              &nbsp;
            </td>
            <td>
              <?php echo $this->InventoryLookup->address_format($supplier_contact['address'], $supplier_contact['city'], $supplier_contact['province'], $supplier_contact['country'], $supplier_contact['postal_code']); ?>
              &nbsp;
            </td>
            <td>
              <?php echo $this->InventoryLookup->phone_format($supplier_contact['phone'], $supplier_contact['phone_ext'], $supplier_contact['cell'], $supplier_contact['fax_number']); ?>
              &nbsp;
            </td>
            <td class="actions">
              <?php //echo $this->Html->link(__(''), array('action' => DETAIL, $supplier_contact['id'], 'controller' => 'supplier_contacts'), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content icon-file', 'title' => __('View Detail Contact'))); ?>
              <?php echo $this->Html->link(__(''), array('action' => 'edit_sub', $supplier_contact['id'], $supplier_id, 'controller' => 'supplier_contacts'), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content icon-edit', 'title' => __('Edit Contact'))); ?>
              <?php echo $this->Form->postLink(__(''), array('controller' => 'supplier_contacts', 'action' => DELETE, $supplier_contact['id'], $supplier_id), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete Contact')), __('Are you sure you want to delete # %s?', $firstname)); ?>
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
            <label>No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</fieldset>