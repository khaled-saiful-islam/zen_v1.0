<div class="doors view"> 
  <fieldset class="content-detail">
    <legend><?php echo __('Door',array('edit'=>false)); ?>:&nbsp;<?php echo h($door['Door']['door_style']); ?>&nbsp;</legend>    

    <div class="tab-content">
      <fieldset id="door-basic-info-detail" class="sub-content-detail">        
        <?php echo $this->element('Detail/Door/door-basic-info-detail', array('edit' => false)); ?>
      </fieldset>      
      <fieldset id="door-factory-info-detail" class="sub-content-detail">
        <h2 style="font-size: 14px;"><?php echo __('Door Factory Information'); ?></h2>
        <?php echo $this->element('Detail/Door/door-factory-info-detail', array('edit' => false)); ?>
      </fieldset>
    </div>
  </fieldset>
</div>