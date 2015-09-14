<fieldset id="sub-project-list" class='sub-content-detail'>
  <?php 
		if($builderproject)
		{
			echo $this->element('PartialData/project_list', array('project_list' => $builderproject));
		}
		else { 
		?>
		<span style="float: right;"><a href="#add-project-modal" role="button" class="btn btn-inverse" data-toggle="modal">Add Project</a></span>
		<div style="clear: both;"></div>
		<table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
      <thead>
        <tr class="grid-header">
          <th>Project Name</th>
					<th>Project Location</th>
					<th>Contact Person</th>
					<th>Contact Person's Phone</th>
					<th>Created Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
	
<!--	<style type="text/css">
	.modal-body{
		max-height: 550px!important
	}
	.modal{
		height: 550px!important;
	}
</style>-->

<div id="add-project-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5>Add Project</h5>
    </div>
    <div class="modal-body">
			<?php
				echo $this->Form->create('BuilderProject', array('inputDefaults' => array()));
			?>
      <table class="customer_quote_form">
				<tr>
					<th>Project: </th>
					<td>
						<?php
							echo $this->Form->input('BuilderProject.project_name', array(
								'class' => 'input-medium',
								'placeholder' => "Project Name",
								'label' => false,
						));
						?>
						<?php echo $this->Form->hidden('selected_customer_id', array()); ?>
						<div style="color: red; display: none;" class="error-message-customer">Project Name Required.</div>
					</td>
				</tr>
				<tr>
					<th>Site Address: </th>
					<td>
						<?php
							echo $this->Form->input('BuilderProject.site_address', array(
								'class' => 'input-xlarge',
								'placeholder' => "Site Address",
								'label' => false,
						));
						?>
						<div style="color: red; display: none;" class="error-message-customer">Site Address Required.</div>
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
										'label' => false
								));
								?>
							</td>
							<td>
								<?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;', 'label' => false)); ?>
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
											'label' => false,
									));
									?>
								</td>
								<td>
									<?php
										echo $this->Form->input('BuilderProject.country', array(
											'class' => 'input-medium',
											'placeholder' => "Country",
											'label' => false,
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
								'label' => false,
						));
						?>
						<div style="color: red; display: none;" class="error-message-customer">Contact Person Required.</div>
					</td>
				</tr>
				<tr>
					<th>Phone: </th>
					<td>
						<?php
							echo $this->Form->input('BuilderProject.contact_person_phone', array(
								'class' => 'input-medium phone-mask',
								'placeholder' => '(000) 000-0000',
								'label' => false,
						));
						?>
						<div style="color: red; display: none;" class="error-message-customer">Contact Person Phone Required.</div>
					</td>
				</tr>
				<tr>
					<th>Cell: </th>
					<td>
						<?php
							echo $this->Form->input('BuilderProject.contact_person_cell', array(
								'class' => 'input-medium phone-mask',
								'placeholder' => '(000) 000-0000',
								'label' => false,
						));
						?>
					</td>
				</tr>
				<tr>
					<th style="width: 150px!important;">Multi Family Pricing:</th>
					<td>
							<?php echo $this->Form->input('BuilderProject.multi_family_pricing', array('type'=>'checkbox','label' => '', 'div' => true)); ?>
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
								'value' => $customer['Customer']['id']
						));
						?>
					</td>
				</tr>
				<tr>
					<th>Comments: </th>
					<td><?php echo $this->Form->input('BuilderProject.comment', array('placeholder' => 'Comments', 'type' => 'text', 'rows' => 1, 'cols' => '88', 'label' => false,)); ?></td>
				</tr>
				<tr>
					<td>
						<input type="button" id="add-project-sction" class="btn btn-info add-more" value="Save" />
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end(); ?>
    </div>
</div>

<script type="text/javascript">
$(function(){
		$("#add-project-sction").click(function() {
			if(BuilderProjectOnBuilderSction(true)) {
				$('#add-project-modal').modal('hide');
      }
    });		
	});	
</script>
	
	
	<?php
		}
  ?>
</fieldset>