<h4>Edit Project</h4>
<?php
		echo $this->Form->create('BuilderProject', array('url' => array('action' => 'edit', $data['BuilderProject']['id']), 'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit project_form'));
?>
	<table class="customer_quote_form">
		<tr>
			<th>Project: </th>
			<td>
				<?php
					echo $this->Form->input('BuilderProject.project_name', array(
						'class' => 'input-medium',
						'placeholder' => "Project Name",
						'value' => isset($data['BuilderProject']['project_name']) ? $data['BuilderProject']['project_name'] : "",
						'label' => false
				));
				?>
				<?php echo $this->Form->hidden('selected_customer_id', array()); ?>
			</td>
		</tr>
		<tr>
			<th>Site Address: </th>
			<td>
				<?php
					echo $this->Form->input('BuilderProject.site_address', array(
						'class' => 'input-xlarge',
						'placeholder' => "Site Address",
						'value' => isset($data['BuilderProject']['site_address']) ? $data['BuilderProject']['site_address'] : "",
						'label' => false,
				));
				?>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<table>
					<tr>
						<td>
						<?php
							echo $this->Form->input('BuilderProject.city', array(
								'class' => 'input-medium',
								'placeholder' => "City",
								'value' => isset($data['BuilderProject']['city']) ? $data['BuilderProject']['city'] : "",
								'label' => false
						));
						?>
					</td>
					<td>
						<?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;', 'label' => false, 'value' => isset($data['BuilderProject']['province']) ? $data['BuilderProject']['province'] : "")); ?>
					</td>
					</tr>
				</table>
			</td>

		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<table>
					<tr>
						<td>
							<?php
								echo $this->Form->input('BuilderProject.postal_code', array(
									'class' => 'input-medium',
									'placeholder' => "Postal Code",
									'value' => isset($data['BuilderProject']['postal_code']) ? $data['BuilderProject']['postal_code'] : "",
									'label' => false
							));
							?>
						</td>
						<td>
							<?php
								echo $this->Form->input('BuilderProject.country', array(
									'class' => 'input-medium',
									'placeholder' => "Country",
									'value' => isset($data['BuilderProject']['country']) ? $data['BuilderProject']['country'] : "",
									'label' => false
							));
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>Contact Person: </th>
			<td>
				<?php
					echo $this->Form->input('BuilderProject.contact_person', array(
						'class' => 'input-medium',
						'placeholder' => 'Contact Person',
						'value' => isset($data['BuilderProject']['contact_person']) ? $data['BuilderProject']['contact_person'] : "",
						'label' => false
				));
				?>
			</td>
		</tr>
		<tr>
			<th>Phone: </th>
			<td>
				<?php
					echo $this->Form->input('BuilderProject.contact_person_phone', array(
						'class' => 'input-medium phone-mask',
						'placeholder' => '(000) 000-0000',
						'value' => isset($data['BuilderProject']['contact_person_phone']) ? $data['BuilderProject']['contact_person_phone'] : "",
						'label' => false,
				));
				?>
			</td>
		</tr>
		<tr>
			<th>Cell: </th>
			<td>
				<?php
					echo $this->Form->input('BuilderProject.contact_person_cell', array(
						'class' => 'input-medium phone-mask',
						'placeholder' => '(000) 000-0000',
						'value' => isset($data['BuilderProject']['contact_person_cell']) ? $data['BuilderProject']['contact_person_cell'] : "",
						'label' => false,
				));
				?>
			</td>
		</tr>
		<tr>
			<th style="width: 150px!important;">Multi Family Pricing:</th>
			<td>
					<?php echo $this->Form->input('BuilderProject.multi_family_pricing', array('type'=>'checkbox','label' => '', 'div' => true, 'value' => isset($data['BuilderProject']['multi_family_pricing']) ? $data['BuilderProject']['multi_family_pricing'] : "")); ?>
			</td>
		</tr>
		<tr>
<!--					<th>Builder Name: </th>-->
			<td>
				<?php
					echo $this->Form->hidden('BuilderProject.customer_id', array(
						'class' => 'input-medium',
						'label' => false,
						'empty' => true,
						'value' => isset($data['BuilderProject']['customer_id']) ? $data['BuilderProject']['customer_id'] : ""
				));
				?>
			</td>
		</tr>
		<tr>
			<th>Comments: </th>
			<td><?php echo $this->Form->input('BuilderProject.comment', array('placeholder' => 'Comments', 'type' => 'text', 'rows' => 3, 'cols' => '88', 'label' => false, 'value' => isset($data['BuilderProject']['comment']) ? $data['BuilderProject']['comment'] : "")); ?></td>
		</tr>
	</table>
	<div class="align-left align-top-margin"><?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?></div>
  <div class="align-left align-top-margin"><?php echo $this->Html->link('Cancel', array('controller' => 'builder_projects', 'action' => 'detail', $data['BuilderProject']['id']), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?></div>
  <div class="clear"></div>
	<?php echo $this->Form->end(); ?>

<script>
  $(".project_form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#sub-project-list'});
</script>