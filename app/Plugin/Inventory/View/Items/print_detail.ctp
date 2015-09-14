<div class="quotes report-print">
  <fieldset>
    <legend><?php echo __('Item', array('edit' => false)); ?></legend>

    <div class="tab-content">
      <fieldset id="item-basic-info-detail" class="sub-content-detail">
        <?php echo $this->element('Detail/Item/item-basic-info-detail', array('edit' => false)); ?>
      </fieldset>
      <fieldset id="item-detail" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Item Detail'); ?></h2>
        <?php echo $this->element('Detail/Item/item-detail', array('edit' => false)); ?>
      </fieldset>
      <fieldset id="item-notes-detail" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Item Notes'); ?></h2>
        <?php echo $this->element('Detail/Item/item-notes-detail', array('edit' => false)); ?>
      </fieldset>
      <fieldset id="item-history-detail" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Inventory History'); ?></h2>
        <?php echo $this->element('Detail/Item/item-history-detail', array('edit' => false)); ?>
      </fieldset>
    </div>

  </fieldset>
</div>