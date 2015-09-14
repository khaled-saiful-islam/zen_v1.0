<div class="suppliers index">
  <fieldset class="content-detail">
    <legend><?php echo __($legend); ?>: [Limit <?php echo $limit; ?>]</legend>
    <div class="report-buttons">    
      <?php
      echo $this->Html->link(
              '', array('controller' => 'cabinets', 'action' => 'listing_report_print', $limit), array('class' => 'icon-print open-link', 'data_target' => 'cabinets_report_print', 'title' => 'Print Listing Information')
      );
      ?>
    </div>
    <form>
      <table class="table-form-big">
        <tr>
          <th>
            <label>Limit</label>
          </th>
          <td>            
            <select class="form-select limit" placeholder="Limit">
              <option value=""></option>
              <?php for($i=1;$i<=10;$i++){ ?>
              <option value="<?php echo REPORT_LIMIT*$i; ?>"><?php echo REPORT_LIMIT*$i; ?></option>
              <?php } ?>
              <option value="All">All</option>
            </select> 
          </td>
          <td>
            Default Limit: <?php echo REPORT_LIMIT; ?>
          </td>
          <td>
            <input type="hidden" class="href-hidden" value="<?php echo $this->webroot; ?>inventory/cabinets/report" />
            <?php echo $this->Html->link('Show', array('controller' => 'cabinets', 'action' => 'report'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding show-link', 'title' => __('Show'))); ?>
          </td>
        </tr>        
      </table>
    </form>
  </fieldset>
</div>

<?php
echo $this->element('../Cabinets/index');
?>
</div>
<script type="text/javascript">
  
  $("select.limit").live('change',function(event){
    value = $(this).val();
    value_href = $('.href-hidden').val();
    value_href = value_href+'/'+value;
    $('.show-link').attr('href',value_href);
  });
  
</script>