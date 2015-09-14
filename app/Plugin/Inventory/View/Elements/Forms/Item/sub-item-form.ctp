<div class="item form">
    <?php 
    echo $this->Form->create('Item', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', 'class' => 'item-core-form ajax-form-submit'));
    $sub_form = $this->InventoryLookup->item_form_elements($section);
    echo $this->element('Forms/Item/' . $sub_form['form'], array('edit' => $edit));
    ?>
    <div class="align-left align-top-margin">
        <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
    </div>
		<div class="align-left align-top-margin">
				<?php echo $this->Html->link('Cancel', array('action' => 'index'), array('id' => 'test','class' => 'sub_item_cancel btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
		</div>

    <?php
    echo $this->Form->end();
    ?>
</div>
<script>
    $(".item-core-form").validate({ignore: null});
<?php if ($edit && ($section !== 'images')) { // do ajax if edit and not uploading files     ?>
//        $(".item-core-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
<?php } ?>
	
	$(function(){
		$('a.sub_item_cancel').click(function(event){
			event.preventDefault();
			ajaxStart();
			var item_id = '<?php echo $sp_id; ?>';
			$.ajax({
        url: '<?php
						echo $this->Util->getURL(array(
								'controller' => "items",
								'action' => 'list_sub_item',
								'plugin' => 'inventory',
						))
						?>/'+item_id,
					data: '',
					success: function( response ) {
            $('#item-sub #sub-content-item-notes').html(response);
						ajaxStop();
					}
				});
		});
	});
</script>