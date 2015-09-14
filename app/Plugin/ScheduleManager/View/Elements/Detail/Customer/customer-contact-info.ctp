
<fieldset id="sub-content-address-form" class='sub-content-detail'>
  <div class="detail actions">
    <?php echo $this->Html->link('Add Contact', array('controller' => 'customer_addresses', 'action' => 'add_sub', $customer['Customer']['id']), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Add Contact'))); ?>
  </div>
  <?php
  if ($customer['CustomerAddress']) {
    echo $this->element('PartialData/customer_addresses', array('customer_addresses' => $customer['CustomerAddress'], 'customer_id' => $customer['Customer']['id']));
    ?>
  <?php } else { ?>
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
</fieldset>