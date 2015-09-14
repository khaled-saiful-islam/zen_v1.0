<?php
if ($paginate) {
  ?>
  <div class="customers index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __($legend); ?>
      </legend>            
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo "Project Name"; ?></th>
            <th><?php echo "Project Location"; ?></th>
						<th><?php echo "Contact Person"; ?></th>
						<th><?php echo "Contact Person's Phone"; ?></th>
						<th><?php echo "Created Date"; ?></th>
						
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($builderproject_data as $project): ?>
            <tr>
							<td>
								<?php echo $project['BuilderProject']['project_name']; ?>
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
								<a class="icon-folder-open show-tooltip" href="<?php echo urldecode( $this->Html->url( array('controller' => 'builders', 'action' => 'detail', $project['BuilderProject']['customer_id'].'#project') ) ); ?>">&nbsp;</a>
									<?php //echo $this->Html->link('', array('controller' => 'builder_projects', 'action' => 'delete', $project['BuilderProject']['id'], $project['BuilderProject']['customer_id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete')); ?>
							</td>
						</tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </fieldset>
  </div>
<?php }?>
  