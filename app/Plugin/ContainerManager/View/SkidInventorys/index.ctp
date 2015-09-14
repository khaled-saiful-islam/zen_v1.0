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
        <?php echo $this->Form->create('SkidInventory', array('url' => array_merge(array('controller' => 'skid_inventorys', 'action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <div>Skid No</div>
              <?php echo $this->Form->input('skid_no', array('placeholder' => 'Skid No', 'class' => 'input-medium')); ?>
            </td>
						<td>
              <div>Weight</div>
              <?php echo $this->Form->input('weight', array('placeholder' => 'Weight', 'class' => 'input-medium')); ?>
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
            <th><?php echo $this->Paginator->sort('skid_no'); ?></th>
						<th><?php echo $this->Paginator->sort('weight'); ?></th>
						<th><?php echo $this->Paginator->sort('description'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($skidinventorys as $skidinventory): ?>
            <tr>
							<td><?php echo $this->Html->link(h($skidinventory['SkidInventory']['skid_no']), array('action' => DETAIL, $skidinventory['SkidInventory']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>&nbsp;</td>
							<td> <?php echo $skidinventory['SkidInventory']['weight']; ?>&nbsp;</td>
							<td> <?php echo $skidinventory['SkidInventory']['description']; ?>&nbsp;</td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $skidinventory['SkidInventory']['id']), array('class' => 'icon-file', 'title' => __('View'))); ?>
								<?php echo $this->Form->postLink('', array('action' => DELETE, $skidinventory['SkidInventory']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete')); ?>
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
        <th><?php echo h('Skid No'); ?></th>
        <th><?php echo h('Weight'); ?></th>
        <th><?php echo h('Description'); ?></th>
      </tr>
    </thead>
		<tbody>
		<?php
		foreach ($skidinventorys as $skidinventory): ?>
			<tr>
				<td><?php echo $this->Html->link(h($skidinventory['SkidInventory']['skid_no']), array('action' => DETAIL, $skidinventory['SkidInventory']['id']), array('class' => 'table-first-column-color', 'title' => __('View'))); ?>&nbsp;</td>
				<td> <?php echo $skidinventory['SkidInventory']['weight']; ?>&nbsp;</td>
				<td> <?php echo $skidinventory['SkidInventory']['description']; ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link('', array('action' => DETAIL, $skidinventory['SkidInventory']['id']), array('class' => 'icon-file', 'title' => __('View'))); ?>
					<?php echo $this->Form->postLink('', array('action' => DELETE, $skidinventory['SkidInventory']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
  </table>
<?php } ?>