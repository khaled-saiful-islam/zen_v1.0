<?php
  $time = time("now"); 
  $i = Uniqid($time);  
?>
<?php foreach( $container['ContainerSkid'] as $d ) { 
	$i++; ?>
<tr id='tridn_<?=$i?>'>
	<td align="left" width="100px">
		<?php
				echo $this->Form->input("ContainerSkid.$i.skid_no", array(
																								"label" => false,
																								"style" => "width: 100px;",
																								"onkeyup" => "getWO(this.value, '$i')",
																								'validate' => $this->Commonjs->validate("Required"),
																								"div" => false,
																								'value' => isset($d['skid_no']) ? $d['skid_no'] : ""
																								));
		?>
	</td>
	<td align="left" width="100px">
				<?php
						echo $this->Form->hidden("ContainerSkid.$i.work_order_number", array(
																										"label" => false,
																										"style" => "width: 150px;",
																										"id" => "work_order_id$i",
																										'type' => "text",
																										'value' => isset($d['work_order_number']) ? $d['work_order_number'] : ""
																										));
				?>
			<?php
							echo $this->Form->hidden("ContainerSkid.$i.work_order_id", array(
																											"label" => false,
																											"style" => "width: 150px;",
																											"id" => "wo_id$i",
																											'type' => "text",
																											'value' => isset($d['work_order_id']) ? $d['work_order_id'] : ""
																											));
					?>
		<div id="work_order_id_html<?php echo $i; ?>"><?php echo isset($d['work_order_id']) ? $d['work_order_id'] : ""; ?></div>
	</td>
	<td align="left" width="100px">
				<?php
						echo $this->Form->hidden("ContainerSkid.$i.weight", array(
																										"label" => false,
																										"style" => "width: 150px;",
																										"id" => "weight$i",
																										"class" => "TotalWeightForSkid",
																										'value' => isset($d['weight']) ? $d['weight'] : ""
																										));
				?>
				<?php
						echo $this->Form->hidden("ContainerSkid.$i.id", array(
																										"label" => false,
																										'value' => isset($d['id']) ? $d['id'] : ""
																										));
				?>
		<div id="weight_html<?php echo $i; ?>"><?php echo isset($d['weight']) ? $d['weight'] : ""; ?></div>
	</td>

	<td>
			<a href="javascript:void(0)" onClick="deleteRow('#tridn_<?php echo $i; ?>')" class="icon-remove icon-remove-margin remove">&nbsp;</a>
	</td>		
</tr>
<?php } ?>

<script type="text/javascript">
function deleteRow(id){
	$(id).empty().remove();
	getTotalWeight();
}
function getWO(skid_no, dynamic_id){	
	$.ajax({
		url: '<?php
					echo $this->Util->getURL(array(
							'controller' => "containers",
							'action' => 'getWOSkid',
							'plugin' => 'container_manager',
					))
					?>/'+skid_no,
		type: 'POST',
		data: '',
		dataType: "json",
		success: function( response ) {
			var work_order_id = '<?php echo "work_order_id"; ?>';
			$("#" + work_order_id + dynamic_id).val(response.wo_number);
			
			var wo_id = '<?php echo "wo_id"; ?>';
			$("#" + wo_id + dynamic_id).val(response.wo_id);
			
			var weight_id = '<?php echo "weight"; ?>';
			$("#" + weight_id + dynamic_id).val(response.skid_weight);
			
			var work_order_id_html = '<?php echo "work_order_id_html"; ?>';
			$("#" + work_order_id_html + dynamic_id).html(response.wo_number);
			
			var weight_id_html = '<?php echo "weight_html"; ?>';
			$("#" + weight_id_html + dynamic_id).html(response.skid_weight);
			
			var total_weight = 0;
			$( '#invoiceTblId .TotalWeightForSkid' ).each( function() {
					total_weight += parseFloat( $( this ).val() );
			} );
			$('#total_weight').html(total_weight.toFixed(2));
			$('.TotalWeightForContainerTable').val(total_weight.toFixed(2));
		}
	});
}
function getTotalWeight(){
	var total_weight = 0;
	$( '#invoiceTblId .TotalWeightForSkid' ).each( function() {
			total_weight += parseFloat( $( this ).val() );
	} );
	$('#total_weight').html(total_weight.toFixed(2));
	$('.TotalWeightForContainerTable').val(total_weight.toFixed(2));
}
</script>