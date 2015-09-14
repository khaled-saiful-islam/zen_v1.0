<?php
if ($paginate) {
  ?>
  <div class="suppliers index">
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
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('Supplier', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Name</div>" . $this->Form->input('name', array('placeholder' => 'Vendor Name', 'class' => 'input-medium')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Email</div>" . $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'wide-small-input')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Phone</div>" . $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'wide-small-input phone-mask')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Cell Phone</div>" . $this->Form->input('cell', array('placeholder' => '(000) 000-0000', 'class' => 'wide-small-input phone-mask')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Vendor Type</div>" . $this->Form->input('supplier_type', array('placeholder' => 'Employee Rep', 'class' => ' form-select wide-small-input', 'type' => 'select', 'options' => $this->InventoryLookup->InventoryLookup('supplier_type'), 'empty' => '')); ?>
            </td>
            <td>
              <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success customer_submit')); ?>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('name', 'Name'); ?></th>
            <th><?php echo $this->Paginator->sort('email'); ?></th>
            <th><?php echo $this->Paginator->sort('phone'); ?></th>
            <th><?php echo $this->Paginator->sort('cell'); ?></th>
            <th>Vendor Type</th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($suppliers as $supplier): ?>
            <tr>
              <td><?php echo $this->Html->link(h($supplier['Supplier']['name']), array('action' => DETAIL, $supplier['Supplier']['id']), array('class' => 'table-first-column-color show-tooltip', 'title' => __('View'))); ?>&nbsp;</td>
              <td><?php echo h($supplier['Supplier']['email']); ?>&nbsp;</td>
              <td><?php echo h($supplier['Supplier']['phone']); ?>&nbsp;<?php if ($supplier['Supplier']['phone_ext']) echo 'Ext: ' . h($supplier['Supplier']['phone_ext']); ?></td>
              <td><?php echo h($supplier['Supplier']['cell']); ?>&nbsp;</td>
              <td>
                <?php
                if (isset($supplier['Supplier']['supplier_type'])) {
                  $cnt = 1;
                  $supplier_types = unserialize($supplier['Supplier']['supplier_type']);
                  if (is_array($supplier_types)) {
                    foreach ($supplier_types as $supplier_type) {
                      echo $cnt . ". " . h($this->InventoryLookup->InventoryLookupReverse($supplier_type)) . "</br>";
                      $cnt++;
                    }
                  }
                }
                ?>
                &nbsp;
              </td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $supplier['Supplier']['id']), array('data-target' => '#MainContent', 'class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
                <?php //echo $this->Html->link('', array('action' => EDIT, $supplier['Supplier']['id']), array('class' => 'icon-edit', 'title' => __('Edit'))); ?>
                <?php echo $this->Form->postLink('', array('action' => DELETE, $supplier['Supplier']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $supplier['Supplier']['name'])); ?>
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
        <th><?php echo h('Name'); ?></th>
        <th><?php echo h('E-mail'); ?></th>
        <th><?php echo h('Phone'); ?></th>
        <th><?php echo h('Cell'); ?></th>
        <th><?php echo h('Supplier Type'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($suppliers as $supplier): ?>
        <tr>
          <td><?php echo h($supplier['Supplier']['name']); //echo $this->Html->link(h($supplier['Supplier']['name']), array('action' => DETAIL, $supplier['Supplier']['id']), array('class' => 'show-detail-ajax table-first-column-color', 'title' => __('View')));  ?>&nbsp;</td>
          <td><?php echo h($supplier['Supplier']['email']); ?>&nbsp;</td>
          <td><?php echo h($supplier['Supplier']['phone']); ?>&nbsp;<?php if ($supplier['Supplier']['phone_ext']) echo 'Ext: ' . h($supplier['Supplier']['phone_ext']); ?></td>
          <td><?php echo h($supplier['Supplier']['cell']); ?>&nbsp;</td>
          <td>
            <?php
            if (isset($supplier['Supplier']['supplier_type'])) {
              $cnt = 1;
              $supplier_types = unserialize($supplier['Supplier']['supplier_type']);
              if (is_array($supplier_types)) {
                foreach ($supplier_types as $supplier_type) {
                  echo $cnt . ". " . h($this->InventoryLookup->InventoryLookupReverse($supplier_type)) . "</br>";
                  $cnt++;
                }
              }
            }
            ?>
            &nbsp;
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>
