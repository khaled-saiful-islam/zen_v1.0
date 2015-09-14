<legend><?php echo $legend; ?></legend>
<div class="item form">
  <?php
  echo $this->Form->create('Material', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'item-core-form ajax-form-submit', 'type' => 'post'));
  echo $this->element('Forms/Material/main-form');
  ?>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <?php if (!$edit) { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } else { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'detail', $id), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } ?>

  <?php
  echo $this->Form->end();
  ?>
</div>
<script>
  $(".item-core-form").validate({ignore: null});
</script>