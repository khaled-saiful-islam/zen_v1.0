<?PHP
/**
 * @property Inventory/InventoryLookup $InventoryLookup
 */
?>
<?php echo $this->Html->css('Inventory.style-inventory.css'); ?>
<?php
if ($paginate) {
//  debug($_SERVER['REQUEST_URI']);
  ?>
  <div class="itemDepartments index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __('Item Departments'); ?>
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
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('ItemDepartment', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Name</div>" . $this->Form->input('name', array('placeholder' => 'Name')); ?>
            </td>
            <td colspan="2">
              <?php echo "<div class=''>Instruction</div>" . $this->Form->input('instruction', array('placeholder' => 'Instruction', 'class' => 'wide-input')); ?>
            </td>
            <td>
              <?php echo "<div class=''>ACC Item Ref</div>" . $this->Form->input('qb_item_ref', array('placeholder' => 'ACC Item Ref')); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo "<div class=''>Active</div>" . $this->Form->input('active', array('placeholder' => 'Status', 'empty' => true, 'class' => 'form-select', 'options' => array(0 => 'Inactive', 1 => 'Active'))); ?>
            </td>
            <td>
              <?php echo "<div class=''>Create PO</div>" . $this->Form->input('supplier_required', array('placeholder' => 'Status', 'empty' => true, 'class' => 'form-select', 'options' => array(0 => 'No', 1 => 'Yes'))); ?>
            </td>
            <td>
              <?php echo "<div class=''>Stock Number Required</div>" . $this->Form->input('stock_number_required', array('placeholder' => 'Status', 'empty' => true, 'class' => 'form-select', 'options' => array(0 => 'No', 1 => 'Yes'))); ?>
            </td>
            <td class="width-min">
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('instruction'); ?></th>
            <th><?php echo $this->Paginator->sort('qb_item_ref', 'ACC Item Ref'); ?></th>
            <th><?php echo $this->Paginator->sort('supplier_required', 'Create PO'); ?></th>
            <th><?php echo $this->Paginator->sort('stock_number_required'); ?></th>
            <th><?php echo $this->Paginator->sort('active'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 0;
          foreach ($itemDepartments as $itemDepartment):

            $count++;
            $odd_even = 'odd';
            if (($count % 2) == 0) {
              $odd_even = 'even';
            }

            $system_data = '';
            if ($itemDepartment['ItemDepartment']['system']) {
              $system_data = 'system-data';
            }
            ?>
            <tr class="<?php echo $system_data; ?>">
              <td class="min-width"><?php echo $this->Html->link(h($itemDepartment['ItemDepartment']['name']), array('action' => DETAIL, $itemDepartment['ItemDepartment']['id']), array('title' => __('View'), 'class' => 'table-first-column-color show-tooltip')); ?>&nbsp;</td>
              <td class="min-width"><?php echo h($itemDepartment['ItemDepartment']['instruction']); ?>&nbsp;</td>
              <td class="min-width"><?php echo h($itemDepartment['ItemDepartment']['qb_item_ref']); ?>&nbsp;</td>
              <td class="min-width"><?php echo $this->InventoryLookup->text_yes_no(h($itemDepartment['ItemDepartment']['supplier_required'])); ?>&nbsp;</td>
              <td class="min-width"><?php echo $this->InventoryLookup->text_yes_no(h($itemDepartment['ItemDepartment']['stock_number_required'])); ?>&nbsp;</td>
              <td class="min-width"><?php echo $this->InventoryLookup->text_yes_no(h($itemDepartment['ItemDepartment']['active'])); ?>&nbsp;</td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $itemDepartment['ItemDepartment']['id']), array('class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
                <?php
                if (!$itemDepartment['ItemDepartment']['system']) {
                  echo $this->Form->postLink('', array('action' => DELETE, $itemDepartment['ItemDepartment']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $itemDepartment['ItemDepartment']['name']));
                }
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </fieldset>

    <?php echo $this->element('Common/paginator'); ?>
  </div>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th>Name</th>
        <th>instruction</th>
        <th>ACC Item Ref</th>
        <th>Supplier Required</th>
        <th>Stock Number Required</th>
        <th>Active</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 0;
      foreach ($itemDepartments as $itemDepartment):
        $count++;
        ?>
        <tr>
          <td class="min-width"><?php echo h($itemDepartment['ItemDepartment']['name']); ?>&nbsp;</td>
          <td class="min-width"><?php echo h($itemDepartment['ItemDepartment']['instruction']); ?>&nbsp;</td>
          <td class="min-width"><?php echo h($itemDepartment['ItemDepartment']['qb_item_ref']); ?>&nbsp;</td>
          <td class="min-width"><?php echo $this->InventoryLookup->text_yes_no(h($itemDepartment['ItemDepartment']['supplier_required'])); ?>&nbsp;</td>
          <td class="min-width"><?php echo $this->InventoryLookup->text_yes_no(h($itemDepartment['ItemDepartment']['stock_number_required'])); ?>&nbsp;</td>
          <td class="min-width"><?php echo $this->InventoryLookup->text_yes_no(h($itemDepartment['ItemDepartment']['active'])); ?>&nbsp;</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>

