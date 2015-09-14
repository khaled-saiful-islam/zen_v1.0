<div class="invoices form">
  <?php
  echo $this->Form->create('Invoice', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', 'class' => 'invoice-form ajax-form-submit'));

  $sub_form = $this->InventoryLookup->invoice_form_elements($section);
  echo $this->element('Forms/Invoice/' . $sub_form['from'], array('legend'=>$legend,'edit' => $edit));
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
      <?php //echo $this->Html->link('Cancel', array('action' => 'detail_section', $door_id, $section), array('data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
    </div>
  <?php } ?>
  <?php
  echo $this->Form->end();
  ?>
</div>
<script>
  $(".invoice-form").validate({ignore: null});
<?php //if ($edit && ($section)) { // do ajax if edit and not uploading files     ?>
  $(".invoice-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
        
        
<?php // }  ?>
</script>