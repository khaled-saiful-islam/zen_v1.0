<div class="cabinets form form-margin-bottom">
  <?php
  //echo $this->element('Actions/cabinet', array('edit' => $edit));
  echo $this->Form->create('Cabinet', array('type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'cabinet-form ajax-form-submit'));

  $sub_form = $this->InventoryLookup->cabinet_form_elements($section);
  $sub_detail = $this->InventoryLookup->cabinet_detail_elements($section);
  $sub_content = $this->InventoryLookup->cabinet_ajax_sub_content($section);
//    var_dump($sub_form);
  //var_dump($edit);
  echo $this->element('Forms/Cabinet/' . $sub_form, array('edit' => $edit, 'legend' => $legend));
  ?>
  <div class="align-left align-top-margin">
    <?php
    echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save'));
    ?>
  </div>
  <?php if (!$edit) { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } else { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $cabinet_id, $section), array('data-target' => '#' . $sub_content, 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } ?>
  <?php
  echo $this->Form->end();
  ?>
</div>
<script>
  $(".cabinet-form").validate({ignore: null});
<?php if ($edit && (($section !== 'basic') || (empty($section)))) { ?>
    $(".cabinet-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_content; ?>'});
<?php } ?>
</script>