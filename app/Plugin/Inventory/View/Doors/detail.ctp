<div class="doors view">
  <?php //echo $this->element('Actions/door', array('detail' => true)); ?>
  <div class="report-buttons">    
    <?php
    echo $this->Html->link(
            '', array('controller' => 'doors', 'action' => 'print_detail', $door['Door']['id']), array('class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information')
    );
    ?>
  </div>
  <fieldset class="content-detail">
    <legend><?php echo __('Door'); ?>:&nbsp;<?php echo h($door['Door']['door_style']); ?>&nbsp;</legend>
    <ul class="nav nav-tabs form-tab-nav" id="door-detail-tab-nav">
      <li class="active"><a href="#door-basic-info-detail" data-toggle="tab"><?php echo __('Basic Information'); ?></a></li>
      <li><a href="#door-images-detail" data-toggle="tab"><?php echo __('Door Images'); ?></a></li>
      <li><a href="#door-factory-info-detail" data-toggle="tab"><?php echo __('Factory/Door/Drawer Information'); ?></a></li>
    </ul>

    <div class="tab-content">
      <fieldset id="door-basic-info-detail" class="sub-content-detail tab-pane active">
        <?php echo $this->element('Detail/Door/door-basic-info-detail', array('edit' => true)); ?>
      </fieldset>
      <fieldset id="door-images-detail" class="sub-content-detail tab-pane">
        <?php echo $this->element('Detail/Door/door-images-detail', array('edit' => true)); ?>
      </fieldset>
      <fieldset id="door-factory-info-detail" class="sub-content-detail tab-pane">
        <?php echo $this->element('Detail/Door/door-factory-info-detail', array('edit' => true)); ?>
      </fieldset>
    </div>
  </fieldset>
</div>