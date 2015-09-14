<?php
//debug($customer);exit;
?>
<div class="customers view">
  <fieldset>
    <legend>
      <?php echo __('Service'); ?>
      <div class="report-buttons">    
        <?php
        echo $this->Html->link(
                '', array('controller' => 'service_entries', 'action' => 'print_detail', $service['ServiceEntry']['id']), array('class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information')
        );
        ?>
      </div>
    </legend>   
    <ul class="nav nav-tabs form-tab-nav" id="item-form-tab-nav">
      <li class="active"><a href="#service-entry-basic-info-detail" data-toggle="tab"><?php echo __('Service Information'); ?></a></li>            
      <li><a href="#service-status-info" data-toggle="tab"><?php echo __('Service Status'); ?></a></li>            
    </ul>

    <div class="tab-content">
      <fieldset id="service-entry-basic-info-detail" class="tab-pane active">
        <?php echo $this->element('Detail/Service/service-entry-basic-info-detail', array('edit' => true)); ?>
      </fieldset>  
      <fieldset id="service-status-info" class="tab-pane">
        <?php echo $this->element('Detail/Service/service-status-info', array('edit' => true)); ?>
      </fieldset>  
    </div>
  </fieldset>
</div>