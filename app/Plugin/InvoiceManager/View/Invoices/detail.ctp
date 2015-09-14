<div class="invoices view">
  <fieldset>
    <legend>
      <?php echo __('Invoice'); ?>
      <div class="report-buttons">    
        <?php
        $url = $this->params['plugin'] . '/' . $this->params['controller'] . '/listing_report_print/'.$id;
        foreach ($this->params['named'] as $key => $value) {
          $url .= $key . ':' . $value . '/';
        }
        ?>
        <a href="http://<?php echo $_SERVER['SERVER_NAME'] . '/' . $url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
      </div>
    </legend>
    <ul class="nav nav-tabs form-tab-nav" id="cabinet-tab-nav">
      <li class="active"><a href="#invoice_information" data-toggle="tab"><?php echo __('Invoice Information'); ?></a></li>
      <li><a href="#invoice_status" data-toggle="tab"><?php echo __('Status'); ?></a></li>      
    </ul>
    <div class="tab-content">
      <div id="invoice_information" class="sub-content-detail tab-pane active">
        <?php echo $this->element('Detail/Invoice/invoice-basic-info-detail', array('edit' => true)); ?>
      </div>
      <div id="invoice_status" class="sub-content-detail tab-pane">
        <?php echo $this->element('Detail/Invoice/invoice-status-info', array('edit' => true)); ?>
      </div>      
    </div>

  </fieldset>

</div>
