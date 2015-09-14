<?php
if ($paginate) {
//  debug($_SERVER['REQUEST_URI']);
  ?>
  <div class="doors index">
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
        <?php echo $this->Form->create('Door', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Door Style</div>" . $this->Form->input('door_style', array('placeholder' => 'Door Style')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Supplier Name</div>" . $this->Form->input('supplier_id', array('placeholder' => 'Supplier Name', 'options' => $this->InventoryLookup->Supplier(), 'empty' => true, 'class' => 'form-select')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Wood Species</div>" . $this->Form->input('wood_species', array('placeholder' => 'Wood Species', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->InventoryLookup('wood_species'))); ?>
            </td>
            <td>
              <?php echo "<div class=''>Product Line</div>" . $this->Form->input('product_line', array('placeholder' => 'Doors Product Line', 'empty' => true, 'class' => 'form-select', 'options' => $this->InventoryLookup->InventoryLookup('doors_product_line'))); ?>
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
            <th><?php echo $this->Paginator->sort('door_style'); ?></th>
            <th><?php echo $this->Paginator->sort('cab_outside_profile'); ?></th>
            <th><?php echo $this->Paginator->sort('wood_species'); ?></th>
            <th><?php echo $this->Paginator->sort('supplier_id'); ?></th>
            <th><?php echo $this->Paginator->sort('rounding_method'); ?></th>
            <th><?php echo $this->Paginator->sort('product_line'); ?></th>
            <th><?php echo $this->Paginator->sort('access'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($doors as $door):
            ?>
            <tr>
              <td><?php echo $this->Html->link(h($door['Door']['door_style']), array('action' => DETAIL, $door['Door']['id']), array('class' => 'table-first-column-color show-tooltip show-tooltip', 'title' => 'view')); ?>&nbsp;</td>
              <td><?php echo h($door['Door']['cab_outside_profile']); ?>&nbsp;</td>
              <td>
                <?php
//                echo h($door['Door']['wood_species']);
                $wood_species = $this->InventoryLookup->InventorySpecificLookup('wood_species', $door['Door']['wood_species']);
                if (isset($wood_species[$door['Door']['wood_species']])) {
                  echo h($wood_species[$door['Door']['wood_species']]);
                }
                ?>
                &nbsp;
              </td>
              <td>
                <?php echo $this->Html->link(h($door['Supplier']['name']), array('controller' => 'suppliers', 'action' => DETAIL, $door['Supplier']['id']), array('class' => 'show-detail-ajax')); ?>
              </td>
              <td>
                <?php
                if ($door['Door']['rounding_method']) {
                  $rm = $this->InventoryLookup->InventoryLookup('doors_rounding_method', $door['Door']['rounding_method']);
                  echo h($rm[$door['Door']['rounding_method']]);
                }
                ?>
                &nbsp;
              </td>
              <td>
                <?php
                if ($door['Door']['product_line']) {
                  $rm = $this->InventoryLookup->InventoryLookup('doors_product_line', $door['Door']['product_line']);
                  echo h($rm[$door['Door']['product_line']]);
                }
                ?>
                &nbsp;
              </td>
              <td>
                <?php echo h($this->InventoryLookup->text_public_access($door['Door']['access'])); ?>
                &nbsp;
              </td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $door['Door']['id']), array('class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
                <?php echo $this->Form->postLink('', array('action' => DELETE, $door['Door']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $door['Door']['id'])); ?>
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
        <th><?php echo h('Door Style'); ?></th>
        <th><?php echo h('Outside Profile'); ?></th>
        <th><?php echo h('Wood Species'); ?></th>
        <th><?php echo h('Supplier'); ?></th>
        <th><?php echo h('Rounding Method'); ?></th>
        <th><?php echo h('Product Line'); ?></th>
        <th><?php echo h('Access'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($doors as $door):
        ?>
        <tr>
          <td><?php echo h($door['Door']['door_style']); //echo $this->Html->link(h($door['Door']['door_style']), array('action' => DETAIL, $door['Door']['id']), array('class' => 'show-detail-ajax table-first-column-color'));     ?>&nbsp;</td>
          <td><?php echo h($door['Door']['cab_outside_profile']); ?>&nbsp;</td>
          <td><?php echo h($door['Door']['wood_species']); ?>&nbsp;</td>
          <td>
            <?php echo h($door['Supplier']['name']); //echo $this->Html->link(h($door['Supplier']['name']), array('controller' => 'suppliers', 'action' => DETAIL, $door['Supplier']['id']), array('class' => 'show-detail-ajax')); ?>
          </td>
          <td>
            <?php
            if ($door['Door']['rounding_method']) {
              $rm = $this->InventoryLookup->InventoryLookup('doors_rounding_method', $door['Door']['rounding_method']);
              echo h($rm[$door['Door']['rounding_method']]);
            }
            ?>
            &nbsp;
          </td>
          <td>
            <?php
            if ($door['Door']['product_line']) {
              $rm = $this->InventoryLookup->InventoryLookup('doors_product_line', $door['Door']['product_line']);
              echo h($rm[$door['Door']['product_line']]);
            }
            ?>
            &nbsp;
          </td>
          <td>
            <?php echo h($this->InventoryLookup->text_public_access($door['Door']['access'])); ?>
            &nbsp;
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>