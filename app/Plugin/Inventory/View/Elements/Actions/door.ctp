<div class="actions">
  <ul class="unstyled">
    <li><?php echo $this->Html->link('', array('action' => ADD), array('class' => 'icon-plus show-add-ajax', 'title' => __('New Item Depertment'))); ?> </li>
    <li><?php echo $this->Html->link('', array('action' => 'index'), array('class' => 'icon-list-alt show-list-ajax', 'title' => __('List Item Departments'))); ?></li>

    <?php if (isset($detail) && ($detail == true)) { ?>
      <li><?php echo $this->Html->link('', array('action' => EDIT, $door['Door']['id']), array('class' => 'icon-edit show-edit-ajax', 'title' => __('Edit'))); ?></li>
      <li><?php echo $this->Form->postLink('', array('action' => DELETE, $door['Door']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $door['Door']['id'])); ?></li>
    <?php } ?>

    <?php if (isset($edit) && ($edit == true)) { ?>
      <li><?php echo $this->Form->postLink('', array('action' => DELETE, $this->Form->value('Door.id')), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $this->Form->value('Door.id'))); ?></li>
    <?php } ?>
  </ul>
</div>