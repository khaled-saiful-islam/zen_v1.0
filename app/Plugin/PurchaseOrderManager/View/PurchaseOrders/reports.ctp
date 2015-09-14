<div class="customers index">
  <fieldset class="content-detail">
    <legend>
      <?php echo __($legend); ?>
      <div class="report-buttons">    
        <?php
        $url = $this->params['plugin'] . '/' . $this->params['controller'] . '/reports_print/';
        foreach ($this->params['named'] as $key => $value) {
          $url .= $key . ':' . $value . '/';
        }
        ?>
        <a href="<?php echo $this->webroot.$url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
      </div>
    </legend> 
    <div >
      <?php echo $this->Form->create('Quote', array('url' => array_merge(array('action' => 'reports')), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big" style="min-width: 200px;">
        <tr>
          <td> 
            <?php
            $report_type_options = array(
                "1" => "Purchase Orders Created",
                "2" => "Purchase Orders Received"
            );
            $options = array();
            for ($i = 1; $i <= 10; $i++) {
              $options[REPORT_LIMIT * $i] = REPORT_LIMIT * $i;
            }
            $options['All'] = "All";
            ?>
            <?php echo $this->Form->input('limit', array('empty' => true, 'options' => $options, 'placeholder' => 'Limit', 'class' => 'form-select limit')); ?>
            <label class="wide-width">Default Limit: <?php echo REPORT_LIMIT; ?></label>
          </td>
          <td>
            <?php echo $this->Form->input('report_type', array('empty' => true, 'options' => $report_type_options, 'placeholder' => 'Report Type', 'class' => 'form-select', 'style' => 'width:250px;')); ?>            
          </td> 
          <td>
            <?php echo $this->Form->input('start_date', array('type' => 'text', 'placeholder' => 'Start Date', 'class' => 'start-date')); ?>            
          </td>
          <td>
            <?php echo $this->Form->input('end_date', array('type' => 'text', 'placeholder' => 'End Date', 'class' => 'end-date')); ?>            
          </td>
          <td style="width: 78px;">
            <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
          </td>
        </tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
          <th><?php echo $this->Paginator->sort('purchase_order_num','Number'); ?></th>
          <th><?php echo $this->Paginator->sort('Quote.job_detail','Description'); ?></th>
          <th><?php //echo $this->Paginator->sort('customer_id');    ?>&nbsp;</th>

        </tr>
      </thead>
      <tbody>
        <?php
                    debug($purchaseorders);
        foreach ($purchaseorders as $purchaseorder):
          ?>
          <tr>           

            <td><?php echo h($this->Util->formatDate($purchaseorder['PurchaseOrder']['created'])); ?>&nbsp;</td>            
            <td><?php echo h($purchaseorder['PurchaseOrder']['purchase_order_num']); ?>&nbsp;</td>
            <td><?php echo h($purchaseorder['Quote']['job_detail']); ?>&nbsp;</td>
            <td><?php //echo h($quote['UserCreated']['first_name']); ?>&nbsp;<?php //echo h($quote['UserCreated']['last_name']); ?></td>       

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
</div>

<script type="text/javascript" >
  $(".start-date").datepicker({
    dateFormat:"dd-mm-yy"
  });
  $(".end-date").datepicker({
    dateFormat:"dd-mm-yy"
  });
</script>