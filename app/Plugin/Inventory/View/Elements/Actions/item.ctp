<?php $damage_modal = false; ?>
<div class="actions">
  <ul class="unstyled">
    <li><?php echo $this->Html->link('', array('action' => ADD), array('class' => 'icon-plus show-add-ajax', 'title' => __('New Item'))); ?> </li>
    <li><?php echo $this->Html->link('', array('action' => 'index'), array('class' => 'icon-list-alt show-list-ajax', 'title' => __('List Item'))); ?></li>

    <?php if (isset($detail) && ($detail == true)) { ?>
      <?php $damage_modal = true; ?>
      <li><?php echo $this->Html->link('', array('action' => EDIT, $item['Item']['id']), array('class' => 'icon-edit show-edit-ajax', 'title' => __('Edit'))); ?></li>
      <li><?php echo $this->Html->link('', '', array('class' => 'icon-ban-circle show-damaged-modal', 'title' => __('Damaged'))); ?></li>
      <li><?php echo $this->Form->postLink('', array('action' => DELETE, $item['Item']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $item['Item']['id'])); ?></li>
    <?php } ?>

    <?php if (isset($edit) && ($edit == true)) { ?>
      <li><?php echo $this->Form->postLink('', array('action' => DELETE, $this->Form->value('Item.id')), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $this->Form->value('Item.id'))); ?></li>
    <?php } ?>

  </ul>
</div>

<?php if ($damage_modal == true) { ?>
  <!-- Item Damaged Modal -->
  <div id="ItemDamagedModal" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Damaged Item Entry</h3>
    </div>
    <div class="modal-body">
      <p align="center">
        <?php echo $this->Form->create('ItemInventoryTransaction', array('url' => array('controller' => 'items','action' => 'damaged_item', $item['Item']['id']), 'class' => 'item-damaged-entry-form')); ?>
        <?php echo $this->Form->input('item_id', array('type' => 'hidden', 'value' => $item['Item']['id'])); ?>
        <?php echo $this->Form->input('count', array('class' => 'small-input', 'label' => 'Item Quantity')); ?>
        <?php echo $this->Form->input('comment', array('class' => 'wide-input', 'label' => 'Item Damaged Reason')); ?>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Save</button>
        <?php // echo $this->Html->link('Cancel', '#', array('class' => 'select-button btn')); ?>
        <?php echo $this->Form->end(); ?>
      </p>
    </div>
  </div>
  <script>
    $('.show-damaged-modal').click(function(event){
      event.preventDefault();
      $('#ItemDamagedModal').modal('show');
    });
  </script>
<?php } ?>
