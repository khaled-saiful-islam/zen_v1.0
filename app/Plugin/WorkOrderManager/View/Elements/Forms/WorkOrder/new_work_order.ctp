<div>     
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
</div>

<table class="table-form-big" style="margin-top: 2px;">
	<tr>
		</td>
		<th style="width: 125px;"><label for="QuoteCustomerId">Skid Number: </label></th>
		<td colspan="3">
			<?php echo $this->Form->input('skid_number', array('type' => 'text','class' => 'input-small','label' => false, 'value' => isset($work_order['WorkOrder']['skid_number']) ? $work_order['WorkOrder']['skid_number'] : "")); ?>
		</td>
		<th style="width: 78px;"><?php echo __('Skid Weight'); ?>:</th>
		<td colspan="2">
			<?php 
				echo $this->Form->input('skid_weight', array('type' => 'text','class' => 'input-small','label' => false, 'value' => isset($work_order['WorkOrder']['skid_weight']) ? $work_order['WorkOrder']['skid_weight'] : ""));
				echo $this->Form->hidden('id', array('value' => isset($work_order['WorkOrder']['id']) ? $work_order['WorkOrder']['id'] : ""));
			?>
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

<div class="align-left">
<?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
</div>
<div class="align-left">
	<?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $work_order['WorkOrder']['id']), array('data-target' => '#work-basic-info-detail-main', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
</div>
