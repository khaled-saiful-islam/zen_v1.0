
<div class="item form">
  <?php
  echo $this->Form->create('Item', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', 'class' => 'item-core-form ajax-form-submit'));
  $sub_form = $this->InventoryLookup->item_form_elements($section);
  echo $this->element('Forms/Item/' . $sub_form['form'], array('edit' => $edit));
  ?>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <?php if (!$edit && !(isset($id) && $id)) { ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } else { ?>
    <?php
    if (!$edit && (isset($id) && $id)) {
      $item_id = $id; // for this page only to return to base item
      $section = 'item-sub';
      $sub_form['detail'] = 'item-sub';
    }
    ?>
    <div class="align-left align-top-margin">
      <?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $item_id, $section), array('data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } ?>

  <?php
  echo $this->Form->end();
  ?>
</div>
<script>
  $(".item-core-form").validate({ignore: null});
<?php if ($edit && ($section !== 'images')) { // do ajax if edit and not uploading files      ?>
    //        $(".item-core-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
<?php } ?>
</script>