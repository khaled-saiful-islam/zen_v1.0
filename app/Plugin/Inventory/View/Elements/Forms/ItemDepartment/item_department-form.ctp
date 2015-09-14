<div class="itemDepartments form">
  <?php //echo $this->element('Actions/item_department', array('edit' => $edit)); ?>
  <?php echo $this->Form->create('ItemDepartment', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'item-department-form ajax-form-submit')); ?>
  <fieldset>
    <?php
    //if (!$edit) {
      ?>
      <legend><?php echo __($legend); ?></legend>
      <?php
    //}
    echo $this->Form->input('id');
    ?>
    <table class='table-form-big'>
      <tr>
        <th><label for="ItemDepartmentName">Name</label></th>
        <td><?php echo $this->Form->input('name', array('class' => 'required')); ?></td>
        <th><label for="ItemDepartmentQbItemRef">ACC Item Ref:</label></th>
        <td>
          <?php
          echo $this->Form->input('qb_item_ref');
          ?>
        </td>
      </tr>
      <tr>
        <th><label for="ItemDepartmentName">Instruction</label></th>
        <td>
          <?php
          echo $this->Form->input('instruction', array('rows' => 3));
          ?>
        </td>
        <th>&nbsp;</th>
        <td class="radio-lable">
          <?php
          echo $this->Form->input('active', array('label' => 'Active', 'div' => true));
          echo $this->Form->input('supplier_required', array('label' => 'Create PO', 'div' => true));
          echo $this->Form->input('stock_number_required', array('label' => 'Stock Number Required', 'div' => true));
          echo $this->Form->input('direct_sale', array('label' => 'Direct Sale', 'div' => true));
          echo $this->Form->input('avaiable_in_website', array('label' => 'Available in Website', 'div' => true));
          ?>
        </td>
      </tr>
    </table>

  </fieldset>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <?php if ($edit) { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => DETAIL, $this->request->data['ItemDepartment']['id']), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } else { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } ?>
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".item-department-form").validate({ignore: null});
<?php
if ($edit) {
  ?>
        $(".item-department-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
  <?php
}
?>
</script>