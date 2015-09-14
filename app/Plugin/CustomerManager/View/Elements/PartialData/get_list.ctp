<div class="detail actions">
	<?php //echo $this->Html->link('Add Project', array('controller' => 'builder_projects', 'action' => 'addProject',$id ), array('data-target' => '#sub-project-list', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
	<span><a href="#add-project-modal" role="button" class="btn btn-inverse" data-toggle="modal">Add Project</a></span>
</div>
<h4>List Project</h4>
<table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
  <thead>
    <tr class="grid-header">
			<th>Project Name</th>
			<th>Project Location</th>
			<th>Contact Person</th>
			<th>Contact Person's Phone</th>
			<th>Created Date</th>
			<th class="actions"><?php echo __(''); ?></th>
		</tr>
  </thead>
  <tbody>
    <?php 
    foreach ($project_list as $project): 
      ?>
      <tr>
				<td>
					<?php echo $this->Html->link(h($project['BuilderProject']['project_name']), array('controller' => 'builder_projects','action' => "getQuoteAndWO", $project['BuilderProject']['id'], $project['BuilderProject']['customer_id']), array('data-target' => '#sub-project-list', 'style' => 'text-decoration: underline;','class' => 'ajax-sub-content table-first-column-color', 'title' => __('View'))); ?>
        </td>
        <td>
          <?php echo $project['BuilderProject']['site_address']; ?>
        </td>        
        <td>
          <?php echo $project['BuilderProject']['contact_person']; ?>
        </td>
				<td>
          <?php echo $project['BuilderProject']['contact_person_phone']; ?>
        </td>
        <td>
          <?php echo h($this->Util->formatDate($project['BuilderProject']['created'])); ?>
        </td>
				<td class="actions">
					<?php echo $this->Html->link('', array('controller' => 'builder_projects','action' => DETAIL, $project['BuilderProject']['id']), array('data-target' => '#sub-project-list', 'title' => __('View'), 'class' => 'ajax-sub-content icon-folder-open show-tooltip')); ?>
					<?php echo $this->Form->postLink('', array('controller' => 'builder_projects', 'action' => DELETE, $project['BuilderProject']['id'], $project['BuilderProject']['customer_id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete')); ?>
				</td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!--<style type="text/css">
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
								'value' => $id
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