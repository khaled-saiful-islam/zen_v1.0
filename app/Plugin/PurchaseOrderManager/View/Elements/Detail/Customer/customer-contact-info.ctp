
<fieldset id="sub-content-address-form" class='sub-content-detail'>
  <div class="detail actions">
    <?php echo $this->Html->link('Add Contact', array('controller' => 'customer_addresses', 'action' => 'add_sub', $customer['Customer']['id']), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Add Contact'))); ?>
  </div>
  <?php
  
  if($customer['CustomerAddress'])
  echo $this->element('PartialData/customer_addresses', array('customer_addresses' => $customer['CustomerAddress'], 'customer_id' => $customer['Customer']['id']));
  ?>
</fieldset>