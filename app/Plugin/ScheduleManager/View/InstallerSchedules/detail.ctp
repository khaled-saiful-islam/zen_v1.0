<div class="doors view">
  <?php //echo $this->element('Actions/door', array('detail' => true)); ?>
  <fieldset class="content-detail">
    <legend><?php echo __('Installer Schedule'); ?>:&nbsp;<?php //echo h($door['Installer']['door_style']); ?>&nbsp;</legend>
    
    <ul class="nav nav-tabs form-tab-nav" id="door-detail-tab-nav">
      <li class="active"><a href="#installer-schedule-basic-detail" data-toggle="tab"><?php echo __('Basic Information'); ?></a></li>
      <li><a href="#installer-schedule-status-detail" data-toggle="tab"><?php echo __('Status'); ?></a></li>
    </ul>

    <div class="tab-content">
      <fieldset id="installer-schedule-basic-detail" class="sub-content-detail tab-pane active">
        <?php echo $this->element('Detail/InstallerSchedule/installer-schedule-basic-detail', array('edit' => true)); ?>
      </fieldset> 
      <fieldset id="installer-schedule-status-detail" class="sub-content-detail tab-pane">
        <?php echo $this->element('Detail/InstallerSchedule/installer-schedule-status-detail', array('edit' => true)); ?>
      </fieldset> 
    </div>
  </fieldset>
</div>