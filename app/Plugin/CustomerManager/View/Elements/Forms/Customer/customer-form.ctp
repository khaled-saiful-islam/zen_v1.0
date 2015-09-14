<?php
if (isset($section) && $section == 'account-credit')
  echo $this->Form->create('BuilderAccount', array('url' => array('controller' => 'builder_accounts', 'action' => 'edit', $id, $section), 'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'customer-form'));
else
  echo $this->Form->create('Customer', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'customer-form'));
?>
<?php
if (!isset($section))
  $section = null;

$sub_form = $this->InventoryLookup->customer_form_elements($section);

if ($section == 'account-credit')
  $legend = "Edit Account&Credit Information";

echo $this->element('Forms/Customer/' . $sub_form['form'], array('edit' => $edit, 'legend' => $legend));
?>

<div class="align-left align-top-margin">
  <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success customer_name_valid', 'label' => false, 'value' => 'Save')); ?>
</div>
<div class="align-left align-top-margin">
  <?php if (!$edit) { ?>
    <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
  <?php } else { ?>
    <?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $id, $section), array('data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
  <?php } ?>
</div>
<div class="clear"></div>

<?php echo $this->Form->end(); ?>
<script>
//  $.validator.addMethod("require_from_group", function(value, element, options) {
//    }, $.format("Please fill out at least {0} of these fields."));
//
//  // "filone" is the class we will use for the input elements at this example
//  $.validator.addClassRules("fillone", {
//    require_from_group: [1,".fillone"]
//  });
  $(".customer-form").validate({ignore: null});
<?php if ($edit && ($section != 'basic' && $section != 'builder-basic')) { ?>
    $(".customer-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
<?php } else { ?>
//    $(".customer-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
<?php } ?>
</script>
