<div class="suppliers form">
  <?php //echo $this->element('Actions/item', array('edit' => $edit)); ?>
  <?php echo $this->Form->create('Supplier', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit supplier-form')); ?>
  <fieldset>
    <legend <?php if ($edit) { ?>class="edit-legend"<?php } ?> ><?php echo __($legend); ?></legend>
    <table class='table-form-big'>
      <tr>
        <th><label for="SupplierName">Name: </label></th>
        <td colspan="2">
          <?php echo $this->Form->input('name', array('placeholder' => 'Name', 'class' => 'wide-input required')); ?>
        </td>
        <th><label for="EmployeeRep">Employee Representative: </label></th>
        <td colspan="2">
          <?php echo $this->Form->input('employee_rep', array('placeholder' => 'Sales Representatives', 'class' => 'form-select required wide-input', "multiple" => true, "options" => $this->CustomerLookup->getSalesRepresentatives(), "value" => isset($this->request->data['Supplier']['employee_rep']) ? unserialize($this->request->data['Supplier']['employee_rep']) : "")); ?>
        </td>
      </tr>
      <tr>
        <th><label for="SupplierEmail">E-mail: </label></th>
        <td colspan="2"><?php echo $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'required email')); ?></td>
        <th><label for="SupplierWebSite">Website: </label></th>
        <td colspan="2">
          <?php echo $this->Form->input('website', array('placeholder' => 'URL', 'class' => 'small-wide-input', 'type' => 'text')); ?>
        </td>
      </tr>
      <tr>
        <th rowspan="3"><label for="SupplierPhone">Phone: </label></th>
        <td>
          <label class="wide-width">Phone: </label>
          <?php echo $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'small-wide-input phone-mask')); ?>
        </td>
        <td class="width-min">
          <label class="wide-width">Extension: </label>
          <?php echo $this->Form->input('phone_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>

        </td>
        <th rowspan="3"><label for="SupplierAddress">Address: </label></th>
        <td colspan="2">
          <label class="wide-width">Address: </label>
          <?php echo $this->Form->input('address', array('placeholder' => 'Address', 'class' => 'wide-input')); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label class="wide-width">Cell: </label>
          <?php echo $this->Form->input('cell', array('placeholder' => 'Cell', 'class' => 'small-wide-input')); ?>
        </td>
        <td>
          <label class="wide-width">City: </label>
          <?php echo $this->Form->input('city', array('placeholder' => 'City', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Province: </label>
          <?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label class="wide-width">Fax: </label>
          <?php echo $this->Form->input('fax_number', array('placeholder' => 'Fax Number', 'class' => 'small-wide-input')); ?>
        </td>
        <td>
          <label class="wide-width">Country: </label>
          <?php echo $this->Form->input('country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Postal Code: </label>
          <?php echo $this->Form->input('postal_code', array('placeholder' => 'Postal Code', 'style' => 'width:75px;', 'class' => '')); ?>
        </td>
      </tr>
      <tr>
        <th><label>Vendor Type: </label></th>
        <td colspan="2">
          <?php
//          echo $this->Form->input('door_supplier', array('type' => 'checkbox', 'label' => 'Door Supplier', 'div' => true));
//          echo $this->Form->input('cabinet_supplier', array('type' => 'checkbox', 'label' => 'Cabinet Supplier', 'div' => true));
//          echo $this->Form->input('laminate_supplier', array('type' => 'checkbox', 'label' => 'Laminate Supplier', 'div' => true));
//          echo $this->Form->input('hardware_supplier', array('type' => 'checkbox', 'label' => 'Hardware Supplier', 'div' => true));
          ?>
          <?php echo $this->Form->input('supplier_type', array('placeholder' => 'Vendor Type', 'class' => 'form-select required', "multiple" => true, "options" => $this->InventoryLookup->InventoryLookup('supplier_type'), "value" => isset($this->request->data['Supplier']['supplier_type']) ? unserialize($this->request->data['Supplier']['supplier_type']) : "")); ?>
        </td>
        <th><label for="SupplierTerms">Terms: </label></th>
        <td colspan="3"><?php echo $this->Form->input('terms', array('placeholder' => 'Terms')); ?></td>
      </tr>
      <tr>
        <th class="width-medium"><label for="SupplierQbSupplierName">QB Vendor Name: </label></th>
        <td colspan="2"><?php echo $this->Form->input('qb_suplier_name', array('placeholder' => 'QB Vendor Name')); ?></td>
        <th><label for="SupplierDefaultPoType"><!--Default PO Type:--> </label></th>
<!--        <td colspan="3"><?php echo $this->Form->input('default_po_type', array('placeholder' => 'Default PO Type')); ?></td>-->
      </tr>
      <tr>
        <th><label for="SupplierGstRate">GST Rate(%): </label></th>
        <td colspan="2"><?php echo $this->Form->input('gst_rate', array('placeholder' => 'GST Rate')); ?></td>
        <th><label for="SupplierPstRate">PST Rate(%): </label></th>
        <td colspan="3"><?php echo $this->Form->input('pst_rate', array('placeholder' => 'PST Rate')); ?></td>
      </tr>
      <tr>
        <th><label for="SupplierNotes">Notes: </label></th>
        <td colspan="2"><?php echo $this->Form->input('notes', array('rows' => 3, 'cols' => 40, 'placeholder' => 'Notes')); ?></td>
        <th><label for="SupplierNotesOnPo">Notes (on PO): </label></th>
        <td colspan="3"><?php echo $this->Form->input('notes_on_po', array('rows' => 3, 'cols' => 40, 'placeholder' => 'Notes (on PO)')); ?></td>
      </tr>
    </table>
  </fieldset>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <?php if (!isset($this->request->data['Supplier']['id'])) { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
    </div>
  <?php } else { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => DETAIL, $this->request->data['Supplier']['id']), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
    </div>
  <?php } ?>
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".supplier-form").validate({ignore:null});
  $(".supplier-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});

</script>
