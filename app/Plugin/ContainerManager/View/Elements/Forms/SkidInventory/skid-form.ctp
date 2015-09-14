<fieldset>
  <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>><?php echo $legend; ?></legend>
  <div class="work-order form">
		
		<table class="table-form-big" width="50%">
			<tr>
				<th>
					<label>Skid No:</label>
				</th>
				<td>
					<?php echo $this->Form->input('skid_no', array('type'=>'text','placeholder'=>'Skid No','class' => 'required', 'value' => isset($skidinventory['SkidInventory']['skid_no']) ? $skidinventory['SkidInventory']['skid_no'] : '')); ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>Weight:</label>
				</th>
				<td>
					<?php echo $this->Form->input('weight', array('placeholder'=>'Weight', 'class' => 'required', 'value' => isset($skidinventory['SkidInventory']['weight']) ? $skidinventory['SkidInventory']['weight'] : '')); ?>
				</td>
			</tr>
			<tr>
				<th>
					<label>Description:</label>
				</th>
				<td>
					<?php echo $this->Form->input('description', array('style' => 'width: 250px; height: 100px;','placeholder'=>'Description','type' => "textarea", 'value' => isset($skidinventory['SkidInventory']['description']) ? $skidinventory['SkidInventory']['description'] : '')); ?>
				</td>
			</tr>
		</table>
		
    <div class="align-left align-top-margin">
      <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
    </div>
		<?php
			if(!isset($skidinventory['SkidInventory']['id'])){
		?>
		<div class="align-left align-top-margin">
			<?php echo $this->Html->link('Cancel', array('action' => 'index'), array('class' => 'btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
		</div>
		<?php
			}
			else {
		?>
			<div class="align-left align-top-margin">
				<?php echo $this->Html->link('Cancel', array('action' => 'detail', $skidinventory['SkidInventory']['id']), array('class' => 'btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
			</div>
		<?php
				
			}
		?>
  </div>

</fieldset>

<script type="text/javascript" >
	$(".skid-form").validate({ignore: null});
</script>
<style type="text/css">
	.table-form-big th{
		width: 120px;
	}
</style>