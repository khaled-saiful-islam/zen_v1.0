<h2>Edit Color Setup</h2>
<?php
  echo $this->Form->create('ScheduleColor', array("url" => array("controller" => "appointments", "action" => "edit_color", isset($id) ? $id : '', isset($type) ? $type : ''),'inputDefaults' => array('label' => false, 'div' => false)));
?>
<table class='table-form-big table-form-big-margin'>
	<tbody>
		<tr>
			<td>
				<?php echo $this->Form->input('id', array( 'type' => 'hidden','class' => 'input-medium', 'value' => isset($data['ScheduleColor']['id']) ? $data['ScheduleColor']['id'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 45px;"><label for="address">Type: </label></th>
			<td>
				<?php echo $this->Form->input('type', array( 'readonly' => 'readonly','class' => 'input-medium', 'label' => false, 'value' => isset($data['ScheduleColor']['type']) ? $data['ScheduleColor']['type'] : '')); ?>
			</td>
		</tr>
		<tr>
			<th style="width: 45px;"><label for="address">Background Color: </label></th>
			<td>
				<?php echo $this->Form->input('bgcolor', array( 'class' => 'input-medium Binded', 'label' => false, 'value' => isset($data['ScheduleColor']['bgcolor']) ? $data['ScheduleColor']['bgcolor'] : '000000')); ?>
			</td>
		</tr>		
	</tbody>	
</table>
<input type="submit" class="btn btn-info" value="Save" />	
<?php echo $this->Form->end(); ?>

<script type="text/javascript">        
	$(document).ready(function() {
			$('.Binded').jPicker();
	});
</script>