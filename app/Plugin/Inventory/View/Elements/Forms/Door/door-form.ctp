<div class="doors form">
    <?php
//  echo $this->element('Actions/door', array('edit' => $edit));
    echo $this->Form->create('Door', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', 'class' => 'door-form ajax-form-submit'));

    $sub_form = $this->InventoryLookup->door_form_elements($section);
    echo $this->element('Forms/Door/' . $sub_form['from'], array('edit' => $edit));
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
            <?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $door_id, $section), array('data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
        </div>
    <?php } ?>
    <?php
    echo $this->Form->end();
    ?>
</div>
<script>
    $(".door-form").validate({ignore: null});
<?php if ($edit && ($section !== 'images')) { // do ajax if edit and not uploading files    ?>
        $(".door-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
        $(".door-form .door-combobox").combobox();

<?php } ?>
</script>