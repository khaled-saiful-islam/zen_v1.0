<div class="customers index">
  <fieldset class="content-detail">
    <legend><?php echo __($legend); ?>: [Limit <?php echo $limit; ?>]</legend>
    <div class="report-buttons">    
      <?php
      echo $this->Html->link(
              '', array('controller' => 'customers', 'action' => 'listing_report_print', $limit), array('class' => 'icon-print open-link', 'data_target' => 'customer_report_print', 'title' => 'Print Listing Information')
      );
      ?>
    </div>
    <!--<?php //echo $this->Form->create('Customer', array('url' => array_merge(array('action' => 'report'), $this->params['pass']), 'class'=>'customer-report-form','inputDefaults' => array('label' => false, 'div' => false))); ?>
    <table class="table-form-big search_div">
      <tr>
        <th>
          <label>Limit</label>
        </th>
        <td>            
          <select class="form-select limit" placeholder="Limit">
            <option value=""></option>
            <?php for ($i = 1; $i <= 10; $i++) { ?>
              <option value="<?php echo REPORT_LIMIT * $i; ?>"><?php echo REPORT_LIMIT * $i; ?></option>
            <?php } ?>
            <option value="All">All</option>
          </select> 
          <label class="wide-width">Default Limit: <?php echo REPORT_LIMIT; ?></label>
        </td>
        <td>
          <?php //echo $this->Form->input('enhanced_search', array('placeholder' => 'Customer Name')); ?>
        </td>
        <td>
          <?php //echo $this->Form->input('email', array('placeholder' => 'Email')); ?>
        </td>
        <td>
          <?php //echo $this->Form->input('customer_type_id', array('placeholder' => 'Customer Type', 'empty' => true, 'class' => 'form-select', 'options' => $customerTypes)); ?>
        </td>
        <td class="width-min">
          <?php //echo $this->Form->input('status', array('placeholder' => 'Status', 'empty' => true, 'class' => 'form-select', 'options' => array(0 => 'Inactive', 1 => 'Active'))); ?>
        </td>
        <td class="width-min">
          <input type="hidden" class="href-hidden" value="<?php echo $this->webroot; ?>customer_manager/customers/report" />
          <?php //echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
        </td>
      </tr>
    </table>
    <?php //echo $this->Form->end(); ?>-->
    <form>
      <table class="table-form-big">
        <tr>
          <th>
            <label>Limit</label>
          </th>
          <td>            
            <select class="form-select limit" placeholder="Limit">
              <option value=""></option>
    <?php for ($i = 1; $i <= 10; $i++) { ?>
                <option value="<?php echo REPORT_LIMIT * $i; ?>"><?php echo REPORT_LIMIT * $i; ?></option>
    <?php } ?>
              <option value="All">All</option>
            </select> 
            <label class="wide-width">Default Limit: <?php echo REPORT_LIMIT; ?></label>
          </td>
          <td>
            
          </td>
          <td>
            <input type="hidden" class="href-hidden" value="<?php echo $this->webroot; ?>customer_manager/customers/report" />
    <?php echo $this->Html->link('Show', array('controller' => 'customers', 'action' => 'report'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding show-link', 'title' => __('Show'))); ?>
          </td>
        </tr>        
      </table>
    </form>
  </fieldset>
</div>

<?php
echo $this->element('../Customers/index');
?>
<script type="text/javascript">
  
  $("select.limit").live('change',function(event){
    value = $(this).val();
    value_href = $('.href-hidden').val();
    value_href = value_href+'/'+value;
    $('form.customer-report-form').attr('action',value_href);
    $('.show-link').attr('href',value_href);    
  });
  
</script>