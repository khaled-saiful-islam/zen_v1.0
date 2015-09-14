<?php
if ($paginate) {
  ?>
  <div class="customers index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __($legend); ?>
      </legend>
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('Container', array('url' => array_merge(array('action' => 'container_index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <div>Ship Date</div>
              <?php echo $this->Form->input('ship_date', array('placeholder' => 'Ship Date', 'class' => 'date_class input-small', 'type' => 'text')); ?>
            </td>
						<td>
              <div>Ship Company</div>
              <?php echo $this->Form->input('ship_company', array('placeholder' => 'Ship Company')); ?>
            </td>
						<td>
              <div>Container No</div>
              <?php echo $this->Form->input('container_no', array('placeholder' => 'Container No','class' => 'input-small')); ?>
            </td>
						<td>
              <div>ETA</div>
              <?php echo $this->Form->input('ead', array('placeholder' => 'ETA', 'class' => 'date_class input-small', 'type' => 'text')); ?>
            </td>
						<td>
              <div>Skid Count</div>
              <?php echo $this->Form->input('skid_count', array('placeholder' => 'Skid Count','class' => 'input-small')); ?>
            </td>
						<td>
              <div>Total Weight</div>
              <?php echo $this->Form->input('total_weight', array('placeholder' => 'Total Weight','class' => 'input-small')); ?>
            </td>
						<td>
              <div>Received Date</div>
              <?php echo $this->Form->input('received_date', array('placeholder' => 'Received Date', 'class' => 'date_class input-small', 'type' => 'text')); ?>
            </td>
            <td>
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('ship_date'); ?></th>
						<th><?php echo $this->Paginator->sort('ship_company'); ?></th>
						<th><?php echo $this->Paginator->sort('container_no'); ?></th>
            <th><?php echo 'ETA'; ?></th>
						<th><?php echo $this->Paginator->sort('skid_count'); ?></th>
						<th><?php echo $this->Paginator->sort('total_weight'); ?></th>
						<th><?php echo $this->Paginator->sort('received_date'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($containers as $container): ?>
            <tr>
              <td><?php echo h($this->Util->formatDate($container['Container']['ship_date'])); ?>&nbsp;</td>
							<td> <?php echo $container['Container']['ship_company']; ?>&nbsp;</td>
							<td><?php echo $this->Html->link(h($container['Container']['container_no']), array('action' => DETAIL, $container['Container']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>&nbsp;</td>
              <td><?php echo h($this->Util->formatDate($container['Container']['ead'])); ?>&nbsp;</td>
							<td> 
								<?php 
									$cnt = count($container['ContainerSkid']);
									echo $cnt; 
								?>&nbsp;
							</td>
							<td> 
								<?php 
									$total = 0;
									foreach($container['ContainerSkid'] as $c){
										$total += $c['weight'];
									}
									echo $total; 
								?>&nbsp;
							</td>
							<td><?php echo h($this->Util->formatDate($container['Container']['received_date'])); ?>&nbsp;</td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $container['Container']['id']), array('class' => 'icon-file', 'title' => __('View'))); ?>
								<?php echo $this->Form->postLink('', array('action' => DELETE, $container['Container']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete')); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php echo $this->element('Common/paginator'); ?>
    </fieldset>
  </div>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th><?php echo h('Ship Date'); ?></th>
        <th><?php echo h('Ship Company'); ?></th>
        <th><?php echo h('Container NO'); ?></th>
        <th><?php echo h('ETA'); ?></th>
        <th><?php echo h('Skid Count'); ?></th>
        <th><?php echo h('Total Weight'); ?></th>
        <th><?php echo h('Received Date'); ?></th>
      </tr>
    </thead>
		<tbody>
		<?php
		foreach ($containers as $container): ?>
			<tr>
				<td><?php echo h($this->Util->formatDate($container['Container']['ship_date'])); ?>&nbsp;</td>
				<td> <?php echo $container['Container']['ship_company']; ?>&nbsp;</td>
				<td><?php echo $this->Html->link(h($container['Container']['container_no']), array('action' => DETAIL, $container['Container']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>&nbsp;</td>
				<td><?php echo h($this->Util->formatDate($container['Container']['ead'])); ?>&nbsp;</td>
				<td> 
						<?php 
							$cnt = count($container['ContainerSkid']);
							echo $cnt; 
						?>&nbsp;
				</td>
				<td> 
					<?php 
						$total = 0;
						foreach($container['ContainerSkid'] as $c){
							$total += $c['weight'];
						}
						echo $total; 
					?>&nbsp;
				</td>
				<td><?php echo h($this->Util->formatDate($container['Container']['received_date'])); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link('', array('action' => DETAIL, $container['Container']['id']), array('class' => 'icon-file', 'title' => __('View'))); ?>
					<?php echo $this->Form->postLink('', array('action' => 'container_delete', $container['Container']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
  </table>
<?php } ?>
<script type="text/javascript" >
  $(".date_class").datepicker({
    dateFormat:"dd-mm-yy"
  });
</script>