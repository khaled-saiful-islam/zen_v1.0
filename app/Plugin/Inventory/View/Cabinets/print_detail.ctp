<div class="cabinets view">  
  <fieldset class="content-detail">
    <legend>
      <?php echo __('Cabinet'); ?>:&nbsp;<?php echo h($cabinet['Cabinet']['name']); ?>
        &nbsp;
    </legend>
    
    <div class="tab-content">
      <div id="cabinet_information" class="sub-content-detail">
        <?php echo $this->element('Detail/Cabinet/cabinet-basic-info-detail', array('edit' => false)); ?>
      </div>
      <div id="cabinet_door_drawer" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Cabinet Door Drawer Information'); ?></h2>
        <?php echo $this->element('Detail/Cabinet/cabinet-door-drawer-detail', array('edit' => false)); ?>
      </div>
      <div id="cabinet_items" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Cabinet Items Information'); ?></h2>
        <?php echo $this->element('Detail/Cabinet/cabinet-items-detail', array('edit' => false)); ?>
      </div>
      <div id="cabinet_pricing" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Cabinet Pricing Information'); ?></h2>
        <?php echo $this->element('Detail/Cabinet/cabinet-pricing-detail', array('edit' => false)); ?>
      </div>
    </div>

  </fieldset>
</div>
