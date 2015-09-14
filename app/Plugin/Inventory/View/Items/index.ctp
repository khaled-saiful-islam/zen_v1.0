<?php
if ($paginate) {
  ?>
  <div class="items index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __($legend); ?>
        <div class="report-buttons">
          <?php
          $url = $this->params['plugin'] . '/' . $this->params['controller'] . '/listing_report_print/';
          foreach ($this->params['named'] as $key => $value) {
            $url .= $key . ':' . $value . '/';
          }
          ?>
          <a href="<?php echo $this->webroot . $url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
        </div>
      </legend>
<!--      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">-->
      <div id="search_div-open">
        <?php echo $this->Form->create('Item', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Item Number</div>" . $this->Form->input('number', array('placeholder' => 'Item Number')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Item Code</div>" . $this->Form->input('item_title', array('placeholder' => 'Item Code', 'empty' => true, 'class' => 'form-select select-item-group')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Supplier Name</div>" . $this->Form->input('supplier_id', array('placeholder' => 'Supplier Name', 'options' => $this->InventoryLookup->Supplier(), 'empty' => true, 'class' => 'form-select select-item-group')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Item Department</div>" . $this->Form->input('item_department_id', array('placeholder' => 'Item Department', 'options' => $this->InventoryLookup->ItemDepartment(1), 'empty' => true, 'class' => 'form-select select-item-group')); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo "<div class=''>Width</div>" . $this->Form->input('width', array('placeholder' => 'Width')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Length</div>" . $this->Form->input('length', array('placeholder' => 'Length')); ?>
            </td>
						<td>
							<?php echo "<div class=''>Item Material Group</div>" .$this->Form->input('item_material_group', array('placeholder' => 'Item Material Group', 'options' => $this->InventoryLookup->getMaterialGroup(), 'empty' => true, 'class' => 'form-select')); ?>
						</td>

            <td>
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success item_submit')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th class="min-width"><?php echo $this->Paginator->sort('number'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('item_title', 'Item Code'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('item_cost'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('price'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('supplier_id'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('current_stock'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('width'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('length'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('item_department_id'); ?></th>
						<th class="min-width"><?php echo $this->Paginator->sort('item_material_group'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 0;
          foreach ($items as $item):
            $count++;
            ?>
            <tr class="<?php //echo $odd_even;   ?>">
              <td><?php echo $this->Html->link(h($item['Item']['number']), array('action' => DETAIL, $item['Item']['id']), array('title' => __('View'), 'class' => 'table-first-column-color show-tooltip show-tooltip')); ?>&nbsp;</td>
              <td><?php echo h($item['Item']['item_title']); ?>&nbsp;</td>
              <td><?php echo h($item['Item']['item_cost']); ?>&nbsp;</td>
              <td><?php echo h($item['Item']['price']); ?>&nbsp;</td>
              <td>
                <?php //echo $this->Html->link($item['Supplier']['name'], array('controller' => 'suppliers', 'action' => DETAIL, $item['Supplier']['id']), array('class' => 'show-detail-ajax')); ?>
                <?php echo $this->Html->link(h($item['Supplier']['name']), array('plugin' => 'inventory', 'controller' => 'suppliers', 'action' => DETAIL, $item['Supplier']['id'], 'modal'), array('title' => __($item['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
                &nbsp;
              </td>
              <td><?php echo h($item['Item']['current_stock']); ?>&nbsp;</td>
              <td><?php echo h($item['Item']['width']); ?>&nbsp;</td>
              <td><?php echo h($item['Item']['length']); ?>&nbsp;</td>
              <td>
                <?php echo $this->Html->link(h($item['ItemDepartment']['name']), array('controller' => 'item_departments', 'action' => DETAIL, $item['ItemDepartment']['id'], 'modal'), array('title' => h($item['ItemDepartment']['name']),'class' => 'table-first-column-color show-detail-ajax-modal show-tooltip')); ?>
              </td>
							<td><?php echo $this->InventoryLookup->findMaterialGroup($item['Item']['item_material_group']); ?></td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $item['Item']['id']), array('class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
                <?php echo $this->Form->postLink('', array('action' => DELETE, $item['Item']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $item['Item']['id'])); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
  </div>
<?php }else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing items-report-table">
    <thead>
      <tr class="grid-header">
        <th><?php echo h('Number'); ?></th>
        <th><?php echo h('Item Code'); ?></th>
        <th><?php echo h('Item Cost'); ?></th>
        <th><?php echo h('Price'); ?></th>
        <th><?php echo h('Supplier'); ?></th>
        <th><?php echo h('Current Stock'); ?></th>
        <th><?php echo h('Width'); ?></th>
        <th><?php echo h('Length'); ?></th>
        <th class="item-dep"><?php echo h('Item Department'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 0;
      foreach ($items as $item):
        $count++;
        ?>
        <tr class="<?php //echo $odd_even;   ?>">
          <td><?php echo h($item['Item']['number']); //echo $this->Html->link(h($item['Item']['number']), array('action' => DETAIL, $item['Item']['id']), array('title' => __('View'), 'class' => 'show-detail-ajax table-first-column-color'));   ?>&nbsp;</td>
          <td><?php echo h($item['Item']['item_title']); ?>&nbsp;</td>
          <td><?php echo h($item['Item']['item_cost']); ?>&nbsp;</td>
          <td><?php echo $this->Util->formatCurrency($item['Item']['price']); ?>&nbsp;</td>
          <td>
            <?php //echo $this->Html->link($item['Supplier']['name'], array('controller' => 'suppliers', 'action' => DETAIL, $item['Supplier']['id']), array('class' => 'show-detail-ajax')); ?>
            <?php echo h($item['Supplier']['name']); //echo $this->Html->link(h($item['Supplier']['name']), array('plugin'=>'inventory','controller'=>'suppliers','action' => DETAIL, $item['Supplier']['id'],'modal'), array('title' => __($item['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
            &nbsp;
          </td>
          <td><?php echo h($item['Item']['current_stock']); ?>&nbsp;</td>
          <td><?php echo h($item['Item']['width']); ?>&nbsp;</td>
          <td><?php echo h($item['Item']['length']); ?>&nbsp;</td>
          <td class="item-dep">
            <?php echo h($item['ItemDepartment']['name']); //echo $this->Html->link(h($item['ItemDepartment']['name']), array('controller' => 'item_departments', 'action' => DETAIL, $item['ItemDepartment']['id']), array('class' => 'show-detail-ajax')); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>