<?php echo $this->Html->script('common.js'); ?>
<fieldset>
  <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>><?php echo $legend; ?></legend>
  <div class="work-order form">
		
		<div style="width: 50%; height: 30px; background-color: #dedede;"><span style="padding: 5px; font-weight: bold;">Booking Container Information</span></div>
		<table class="table-form-big" width="50%">
			<tr>
				<th>
					<label>Shipping Date:</label>
				</th>
				<td>
					<?php echo $this->Form->input('ship_date', array('type'=>'text','placeholder'=>'Shipping Date','class' => 'required date_class', 'value' => isset($container['Container']['ship_date']) ? $this->Util->formatDate($container['Container']['ship_date']) : '')); ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>Shipping Company:</label>
				</th>
				<td>
					<?php echo $this->Form->input('ship_company', array('placeholder'=>'Shipping Company', 'class' => 'required', 'value' => isset($container['Container']['ship_company']) ? $container['Container']['ship_company'] : '')); ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>ETA:</label>
				</th>
				<td>
					<?php echo $this->Form->input('ead', array('placeholder'=>'ETA','class' => 'date_class', 'type' => "text", 'value' => isset($container['Container']['ead']) ? $this->Util->formatDate($container['Container']['ead']) : '')); ?>
				</td>
			</tr>
		</table>
		
		<div style="width: 50%; height: 30px; background-color: #dedede; margin-top: 20px;"><span style="padding: 5px; font-weight: bold;">Load Container Information</span></div>
		<table class="table-form-big" width="50%">
			<tr>
				<th>
					<label>Container ID:</label>
				</th>
				<td>
					<?php echo $this->Form->input('container_no', array('placeholder'=>'Container ID', 'value' => isset($container['Container']['container_no']) ? $container['Container']['container_no'] : '')); ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>Received Date:</label>
				</th>
				<td>
					<?php echo $this->Form->input('received_date', array('placeholder'=>'Received Date','class' => 'date_class', 'type' => "text", 'value' => isset($container['Container']['received_date']) ? $this->Util->formatDate($container['Container']['received_date']) : '')); ?>
				</td>
			</tr>
		</table>
    
<!-----------------------------------------------------------Dynamic Skid Operation---------------------------------------------->
	<table style="margin-top: 15px;" id="invoiceTblId" cellpadding="0" cellspacing="0" border="0" class="table-form-big" style="width: 70%;" class="form_tb">
    <tr>
        <th>Skid No</th>
        <th>WO</th>
        <th>Weight</th>
		</tr>
		<?php echo $this->element('Forms/Container/edit/new_skid_row_dynamic', array('data' => $container)); ?>
		<div id='boxLoading'></div>
	</table>
	
	<div style="width: 39%; text-align: right;">
		<div><b>Total Weight: <span id="total_weight"><?php echo $total; ?></span></b>
		</div>
	</div>								
									
	<div align="left" style="padding-bottom:15px">
		<?php echo $this->Html->link("Add Skid", "javascript:void(0)", array(
																																"class" => 'btn btn-info',
																																"escape" => false,
																																"onClick" => $this->Commonjs->ajax_append(array("controller" => "containers", "action" => "dynamic_skid"), "invoiceTblId", "boxLoading")
																																		));?>	
	</div>								
	
<!-----------------------------------------------------------Dynamic Skid Operation---------------------------------------------->
		
    <div class="align-left align-top-margin">
      <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
    </div>
		<div class="align-left align-top-margin">
			<?php echo $this->Html->link('Cancel', array('action' => 'detail',$container['Container']['id']), array('class' => 'btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
		</div>
  </div>

</fieldset>

<script type="text/javascript" >
	$(".container-form").validate({ignore: null});
  $(".date_class").datepicker({
    dateFormat:"dd/mm/yy"
  });
</script>
<style type="text/css">
	.table-form-big th{
		width: 120px;
	}
</style>