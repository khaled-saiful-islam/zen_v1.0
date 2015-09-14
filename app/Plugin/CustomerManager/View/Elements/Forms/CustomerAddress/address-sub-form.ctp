<div class="addresses form">
  <?php echo $this->Form->create('CustomerAddress', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit address-form')); ?>
  <fieldset>
    <legend class="inner-legend"><?php echo __($legend); ?></legend>
    <?php echo $this->Form->input('customer_id', array('type' => 'hidden', 'value' => $customer_id)); ?>
    <table class='table-form-big'>
      <tr>
        <th><label for="CustomerAddressFirstName">Name: </label></th>
        <td>
          <?php echo $this->Form->input('first_name', array('placeholder' => 'First Name', 'class' => 'required')); ?>
        </td>
        <td>
          <?php echo $this->Form->input('last_name', array('placeholder' => 'Last Name', 'class' => '')); ?>
        </td>
      </tr>
      <tr>
        <th><label for="CustomerAddressTitle">Title: </label></th>
        <td colspan="2"><?php echo $this->Form->input('title', array('class' => '')); ?></td>
      </tr>
      <tr>
        <th><label for="CustomerAddressEmail">Email: </label></th>
        <td colspan="3" >
          <?php echo $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'email')); ?>
        </td>
      </tr>
      <tr>
        <th rowspan="3"><label for="CustomerAddressPhone">Phone: </label></th>
        <td>
          <label class="wide-width">Phone: </label>
          <?php echo $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'phone-mask')); ?>
        </td>
        <td>
          <label class="wide-width">Extension: </label>
          <?php echo $this->Form->input('phone_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>
        </td>
      <tr>
        <td colspan="2">
          <label class="wide-width">Cell: </label>
          <?php echo $this->Form->input('cell', array('placeholder' => '(000) 000-0000', 'class' => 'phone-mask')); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label class="wide-width">Fax: </label>
          <?php echo $this->Form->input('fax_number', array('placeholder' => '(000) 000-0000', 'class' => 'phone-mask')); ?>
        </td>
      </tr>
      <tr>
        <th rowspan="3"><label for="CustomerAddressAddress">Address: </label></th>
        <td colspan="2">
          <label class="wide-width">Address: </label>
          <?php echo $this->Form->input('address', array('placeholder' => 'Address', 'class' => 'wide-input')); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label class="wide-width">City: </label>
          <?php echo $this->Form->input('city', array('placeholder' => 'City', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Province: </label>
          <?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => '', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label class="wide-width">Country: </label>
          <?php echo $this->Form->input('country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Postal Code: </label>
          <?php echo $this->Form->input('postal_code', array('placeholder' => 'Postal Code', 'class' => '')); ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <div class="clear"></div><!-- 'class' => 'ajax-form-submit address-form' -->
  <div class="align-left align-top-margin"><?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?></div>
  <div class="align-left align-top-margin"><?php echo $this->Html->link('Cancel', array('controller' => 'customer_addresses', 'action' => 'show_list', $customer_id), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?></div>
  <div class="clear"></div>
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".address-form").validate({ignore: null});
  //  $("input[type=text]").ezpz_hint();
  $(".address-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#sub-content-address-form'});
</script>