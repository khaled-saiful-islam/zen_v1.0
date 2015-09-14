<div class="doors view">
  <?php //echo $this->element('Actions/door', array('detail' => true)); ?>
  <fieldset class="content-detail">
    <legend><?php echo __('Installer'); ?>:&nbsp;<?php //echo h($door['Installer']['door_style']); ?>&nbsp;</legend>
    <ul class="nav nav-tabs form-tab-nav" id="door-detail-tab-nav">
      <li class="active"><a href="#installer-basic-detail" data-toggle="tab"><?php echo __('Basic Information'); ?></a></li>
      <li><a href="#installer-holidays-detail" data-toggle="tab"><?php echo __('Holidays'); ?></a></li>
    </ul>

    <div class="tab-content">
      <fieldset id="installer-basic-detail" class="sub-content-detail tab-pane active">
        <?php echo $this->element('Detail/Installer/installer-basic-detail', array('edit' => true)); ?>
      </fieldset>
      <fieldset id="installer-holidays-detail" class="sub-content-detail tab-pane">
        <?php echo $this->element('Detail/Installer/installer-holidays-detail', array('edit' => true)); ?>
      </fieldset>
    </div>
  </fieldset>
</div>