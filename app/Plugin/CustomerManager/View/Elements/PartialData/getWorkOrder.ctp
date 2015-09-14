<div class="report-buttons">
	<?php 
		$report_list = $this->InventoryLookup->ReportsList();
		$report_function_list = $this->InventoryLookup->ReportsFunctionList();
		echo $this->Form->input('report_name', array('type' => 'select', 'label' => false, 'class' => 'form-select', 'options' => $report_list));
		echo $this->Html->link(
						'', array('controller' => 'quotes', 'action' => 'print_detail', $work_order['Quote']['id']), array('class' => 'icon-print open-quote-report-link', 'data_target' => 'quote_report', 'data_uuid' => $work_order['Quote']['id'], 'title' => 'Print Detail Information','style' => 'margin-left: 15px;')
		);
	?>
</div>
<div class="detail actions" style="margin-right: 20px;">
	<?php echo $this->Html->link('Back', array('controller' => 'builder_projects', 'action' => 'getQuoteAndWO', $work_order['WorkOrder']['project_id'], $customer_id), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<h4>Work Order Detail</h4>

<table class="table-form-big">
    <tr>
      <th style="width: 125px;"><?php echo __('Work Order Number'); ?>:</th>
      <td colspan="6">
        <?php echo h($work_order['WorkOrder']['work_order_number']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php //echo __('Job Name'); ?></th>
      <td colspan="3">
        <?php //echo h($work_order['Quote']['job_name']); ?>
        &nbsp;
      </td>
      <th><label for="QuoteCustomerId">Customer: </label></th>
      <td>
        <?php echo h($work_order['Customer']['first_name']); ?>&nbsp;<?php echo h($work_order['Customer']['last_name']); ?>
      </td>
      <td style="text-align: right;">        
        <?php //echo $this->Html->link('Edit Quote', array('action' => EDIT, $work_order['Quote']['id'],'basic'), array('data-target' => '#quote-basic-info-detail', 'class' => 'ajax-sub-content btn btn-success')); ?>
      </td>
    </tr>
    <tr>
      <th rowspan="3"><?php echo __('Address'); ?>:</th>
      <td rowspan="3" colspan="3">          
        <?php echo $this->InventoryLookup->address_format(h($work_order['Quote']['address']),h($work_order['Quote']['city']), h($work_order['Quote']['province']), h($work_order['Quote']['country']), h($work_order['Quote']['postal_code'])); ?>
        &nbsp;
      </td>
      <th><?php echo __('Est Shipping'); ?>:</th>
      <td colspan="2">
        <?php echo h($this->Util->formatDate($work_order['Quote']['est_shipping'])); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Sales Person'); ?>:</th>
      <td colspan="2">
        <?php 
					$sales = unserialize($work_order['Quote']['sales_person']); 
					$cnt = count($sales);
					$j = 1;
					for($i = 0; $i<$cnt; $i++){
						$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
						echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
						$j++;
					}						
				?>
      </td>        
    </tr>
  </table>

<table class="table-form-big" style="margin-top: 2px;">
	<tr>
		</td>
		<th style="width: 125px;"><label for="QuoteCustomerId">Skid Number: </label></th>
		<td colspan="3">
			<?php echo $work_order['Quote']['skid_number']; ?>&nbsp;
		</td>
		<th style="width: 78px;"><?php echo __('Skid Weight'); ?>:</th>
		<td colspan="2">
			<?php 
				echo $work_order['Quote']['skid_weight']; ?>
			&nbsp;
		</td>
	</tr>
</table>
<table class="table-form-big table-form-big-margin quote-table-mid-width">
  <tr>
    <th><?php echo __('Job Detail'); ?>:</th>
    <td colspan="3">
      <?php echo h($work_order['Quote']['job_detail']); ?>
      &nbsp;
    </td>
  </tr>
</table>

<script>
  var report_list = new Array();
<?php
if (!empty($report_function_list) and is_array($report_function_list)) {
  foreach ($report_function_list as $function_id => $report_function) {
    ?>
          report_list[<?php echo $function_id; ?>] = '<?php echo $report_function; ?>';
    <?php
  }
}
?>
	$('a.open-quote-report-link').live('click', function(event) {
    event.preventDefault();
    var url = BASEURL + 'quote_manager/quotes/' + report_list[$('#report_name').val()] + '/' + $(this).attr("data_uuid");
    window.open(url, $(this).attr("data_target"), "status=0,toolbar=0,resizable=0,height=600,width=1030,location=0,scrollbars=1");
  });
	
</script>