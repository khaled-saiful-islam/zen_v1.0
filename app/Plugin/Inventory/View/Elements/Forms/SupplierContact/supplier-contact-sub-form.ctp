<div class="supplierContacts form">
  <?php echo $this->Form->create('SupplierContact', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit supplier-contacts-form')); ?>
  <fieldset>
    <legend class="inner-legend"><?php echo __($legend); ?></legend>
    <?php echo $this->Form->input('supplier_id', array('type' => 'hidden', 'value' => $supplier_id)); ?>
    <table class='table-form-big'>
      <tr>
        <th><label for="SupplierContactFirstName">Name: </label></th>
        <td>
          <?php echo $this->Form->input('first_name', array('placeholder' => 'First Name', 'class' => 'required')); ?>
        </td>
        <td>
          <?php echo $this->Form->input('last_name', array('placeholder' => 'Last Name', 'class' => '')); ?>
        </td>
      </tr>
      <tr>
        <th><label for="SupplierContactAddressTypeId">Title: </label></th>
        <td colspan="2"><?php echo $this->Form->input('title', array('placeholder' => 'Title', 'class' => 'form-select')); ?></td>
      </tr>
      <tr>
        <th><label for="SupplierContactEmail">Email: </label></th>
        <td colspan="3" >
          <?php echo $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'email')); ?>
        </td>
      </tr>
      <tr>
        <th rowspan="3">
          <label for="SupplierContactPhone">Phone: </label>
        </th>
        <td>
          <label class="wide-width">Phone: </label>
          <?php echo $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'phone-mask')); ?>
        </td>
        <td>
          <label class="wide-width">Extension: </label>
          <?php echo $this->Form->input('phone_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label class="wide-width">Cell: </label>
          <?php echo $this->Form->input('cell', array('placeholder' => 'Cell')); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label class="wide-width">Fax: </label>
          <?php echo $this->Form->input('fax_number', array('placeholder' => 'Fax Number')); ?>
        </td>
      </tr>
      <tr>
        <th rowspan="3"><label for="SupplierContactAddress">Address: </label></th>
        <td colspan="2">
          <label class="wide-width">Address: </label>
          <?php echo $this->Form->input('address', array('placeholder' => 'Address', 'class' => 'required wide-input')); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label class="wide-width">City: </label>
          <?php echo $this->Form->input('city', array('placeholder' => 'City', 'class' => 'required')); ?>
        </td>
        <td>
          <label class="wide-width">Province: </label>
          <?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'required', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label class="wide-width">Country: </label>
          <?php echo $this->Form->input('country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => 'required')); ?>
        </td>
        <td class="width-min">
          <label class="wide-width">Postal Code: </label>
          <?php echo $this->Form->input('postal_code', array('placeholder' => 'Postal Code', 'class' => 'required', 'style' => 'width:75px;')); ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', array('controller' => 'supplier_contacts', 'action' => 'show_list', $supplier_id), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".supplier-contacts-form").validate({ignore: null});
  $(".supplier-contacts-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#sub-content-contact-form'});
</script>