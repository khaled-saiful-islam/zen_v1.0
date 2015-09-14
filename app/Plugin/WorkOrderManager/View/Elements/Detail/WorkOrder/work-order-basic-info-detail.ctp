<?php
if (isset($modal) && $modal == "modal") {
  ?>  
  <table class="table-form-big margin-bottom">
    <tr>
      <th style="width: 125px;"><?php echo __('Work Order Number'); ?>:</th>
      <td colspan="6">
        <?php echo h($work_order['WorkOrder']['work_order_number']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Job Name'); ?>:</th>
      <td colspan="3">
        <?php echo h($work_order['Quote']['job_name']); ?>
        &nbsp;
      </td>
      <th><label for="QuoteCustomerId">Customer: </label></th>
      <td>
        <?php echo h($work_order['Quote']['Customer']['first_name']); ?>&nbsp;<?php echo h($work_order['Quote']['Customer']['last_name']); ?>
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
<!--    <tr>        
      <th><?php echo __('Reference'); ?>:</th>
      <td colspan="2">
        <?php echo h($work_order['Quote']['reference']); ?>
        &nbsp;
      </td>
    </tr>-->
    <tr>
      <th><?php echo __('Builder Job'); ?>:</th>
      <td colspan="3">
        <?php echo h($work_order['Quote']['builder_job']); ?>
        &nbsp;
      </td>
      <th><?php echo __('Builder Po'); ?>:</th>
      <td colspan="2">
        <?php echo h($work_order['Quote']['builder_po']); ?>
        &nbsp;
      </td>
    </tr>
  </table>
<?php } else { ?>
<div class="">     
  <?php 
  echo $this->Html->link('Edit Work Order', array('action' => "edit_workorder", $work_order['WorkOrder']['id']), array('data-target' => '#work-basic-info-detail-main', 'class' => 'ajax-sub-content btn btn-success right')); 
	//echo $this->Html->link('Edit Quote', array('action' => EDIT, $quote['Quote']['id'], 'basic'), array('data-target' => '#quote-basic-info-detail-main', 'class' => 'ajax-sub-content btn btn-success right'));
	?>

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
        <?php echo h($work_order['Quote']['Customer']['first_name']); ?>&nbsp;<?php echo h($work_order['Quote']['Customer']['last_name']); ?>
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
<!--    <tr>        
      <th><?php echo __('Reference'); ?>:</th>
      <td colspan="2">
        <?php echo h($work_order['Quote']['reference']); ?>
        &nbsp;
      </td>
    </tr>-->
<!--    <tr>
      <th><?php echo __('Builder Job'); ?>:</th>
      <td colspan="3">
        <?php echo h($work_order['Quote']['builder_job']); ?>
        &nbsp;
      </td>
      <th><?php echo __('Builder Po'); ?>:</th>
      <td colspan="2">
        <?php echo h($work_order['Quote']['builder_po']); ?>
        &nbsp;
      </td>
    </tr>-->
  </table>
</div>
<!--<table class="table-form-big table-form-big-margin quote-table-mid-width">
  <tr>
    <th colspan="4">
      <label class="table-data-title">Job Details</label>
    </th>
  </tr>
  <tr>
    <th><?php echo __('Cabinet Cost'); ?>:</th>
    <td>
      <?php echo h($work_order['Quote']['cabinet_cost']); ?>
      &nbsp;
    </td>
    <th><?php echo __('Door Cost'); ?>:</th>
    <td>
      <?php echo h($work_order['Quote']['door_cost']); ?>
      &nbsp;
    </td>
  </tr>
  <tr>
    <th><?php echo __('Drawer Cost'); ?>:</th>
    <td>
      <?php echo h($work_order['Quote']['drawer_cost']); ?>
      &nbsp;
    </td>
    <th><?php echo __('Extra Doors'); ?>:</th>
    <td>
      <?php echo h($work_order['Quote']['extra_doors']); ?>
      &nbsp;
    </td>
  </tr>
  <tr>
    <th><?php echo __('Style'); ?>:</th>
    <td>
      <?php echo h($work_order['Quote']['style']); ?>
      &nbsp;
    </td>
    <th><?php echo __('Color'); ?>:</th>
    <td>
      <?php echo h($work_order['Quote']['color']); ?>
      &nbsp;
    </td>
  </tr>
  <tr>
    <th><label>Sub Total</label></th>
    <td colspan="3">
      <?php
      $job_sub_total = 0.00;
      $job_sub_total = $work_order['Quote']['cabinet_cost'] + $work_order['Quote']['door_cost'] + $work_order['Quote']['drawer_cost'] + $work_order['Quote']['extra_doors'];
      if ($job_sub_total)
        echo number_format($job_sub_total, 2, '.', '');
      else
        echo '0.00';
      ?>
    </td>
  </tr>
</table>-->
<table class="table-form-big" style="margin-top: 2px;">
	<tr>
		</td>
		<th style="width: 125px;"><label for="QuoteCustomerId">Skid Number: </label></th>
		<td colspan="3">
			<?php echo $work_order['WorkOrder']['skid_number']; ?>&nbsp;
		</td>
		<th style="width: 78px;"><?php echo __('Skid Weight'); ?>:</th>
		<td colspan="2">
			<?php 
				echo $work_order['WorkOrder']['skid_weight']; ?>
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
<?php } ?>