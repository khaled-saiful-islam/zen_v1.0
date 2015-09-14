<div class="users form form-margin-bottom">
  <?php
  
  echo $this->Form->create('User', array('type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'user-form ajax-form-submit'));

  $sub_form = $this->InventoryLookup->user_form_elements($section);
  echo $this->element('Forms/User/' . $sub_form['form'], array('edit' => $edit, 'legend' => $legend));
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
      <?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $id, $section), array('data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } ?>
  <?php
  echo $this->Form->end();
  ?>
</div>
<script>
  $(".user-form").validate({ignore: null});
<?php if ($edit && !empty($section)) { ?>
    $(".user-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
<?php } ?>
</script>