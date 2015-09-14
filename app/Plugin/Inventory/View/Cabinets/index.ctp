<?php
if ($paginate) {
  ?>
  <div class="cabinets index">
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
        <?php echo $this->Form->create('Cabinet', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Name</div>" . $this->Form->input('name', array('placeholder' => 'Cabinet Name')); ?>
            </td>
<!--            <td>
              <?php echo "<div class=''>Cabinet Category</div>" . $this->Form->input('product_type', array('placeholder' => 'Product Type', 'options' => $this->InventoryLookup->InventoryLookup('cabinet_type'), 'empty' => true, 'class' => 'form-select')); ?>
            </td>-->
            <td>
              <?php echo "<div class=''>Actual Dimensions Width</div>" . $this->Form->input('actual_dimensions_width', array('placeholder' => 'Actual Dimensions Width')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Actual Dimensions Height</div>" . $this->Form->input('actual_dimensions_height', array('placeholder' => 'Actual Dimensions Height')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Actual Dimensions Depth</div>" . $this->Form->input('actual_dimensions_depth', array('placeholder' => 'Actual Dimensions Depth')); ?>
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
            <th class="min-width"><?php echo $this->Paginator->sort('name'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('product_type', 'Cabinet Category'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('actual_dimensions_width', 'Actual Dimensions Width'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('actual_dimensions_height', 'Actual Dimensions Height'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('actual_dimensions_depth', 'Actual Dimensions Depth'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 0;
          foreach ($cabinets as $cabinet):
            $count++;
            ?>
            <tr class="<?php //echo $odd_even;        ?>">
              <!--<td><?php echo $this->Html->link(h($cabinet['Cabinet']['name']), array('action' => 'detail_section', $cabinet['Cabinet']['id'], 'detail', 0), array('title' => __('View'), 'class' => 'table-first-column-color show-tooltip modal_ajax_jq_ui_detail')); ?>&nbsp;</td>-->
              <td><?php echo $this->Html->link(h($cabinet['Cabinet']['name']), array('action' => DETAIL, $cabinet['Cabinet']['id']), array('title' => __('View'), 'class' => 'table-first-column-color show-tooltip')); ?>&nbsp;</td>
              <td>
                <?php
                if ($cabinet['Cabinet']['product_type'] && is_array($cabinet['Cabinet']['product_type'])) {
                  $product_type = $this->InventoryLookup->InventorySpecificLookup('cabinet_type', $cabinet['Cabinet']['product_type']);
                  if ($product_type) {
                    foreach ($cabinet['Cabinet']['product_type'] as $lookup_id) {
                      echo '<li style="margin-left: 10px;">' . h($product_type[$lookup_id]) . '</li>';
                    }
                  }
                }
                ?>&nbsp;</td>
              <td><?php echo h($cabinet['Cabinet']['actual_dimensions_width']); ?>&nbsp;</td>
              <td><?php echo h($cabinet['Cabinet']['actual_dimensions_height']); ?>&nbsp;</td>
              <td><?php echo h($cabinet['Cabinet']['actual_dimensions_depth']); ?>&nbsp;</td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $cabinet['Cabinet']['id']), array('class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
                <?php echo $this->Form->postLink('', array('action' => DELETE, $cabinet['Cabinet']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $cabinet['Cabinet']['name'])); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
  </div>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing cabinets-report-table">
    <thead>
      <tr class="grid-header">
        <th><?php echo h('Name'); ?></th>
        <th><?php echo h('Product Type'); ?></th>
        <th><?php echo h('Actual Dimensions Width'); ?></th>
        <th><?php echo h('Actual Dimensions Height'); ?></th>
        <th class="cabinets-dept"><?php echo h('Actual Dimensions Depth'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 0;
      foreach ($cabinets as $cabinet):
        $count++;
        ?>
        <tr class="<?php //echo $odd_even;        ?>">
          <td><?php echo h($cabinet['Cabinet']['name']); //echo $this->Html->link(h($cabinet['Cabinet']['name']), array('action' => DETAIL, $cabinet['Cabinet']['id']), array('title' => __('View'), 'class' => 'show-detail-ajax table-first-column-color'));      ?>&nbsp;</td>
          <td>
            <?php
            if ($cabinet['Cabinet']['product_type']) {
              $pt = $this->InventoryLookup->InventorySpecificLookup('cabinet_type', $cabinet['Cabinet']['product_type']);
              echo h($pt[$cabinet['Cabinet']['product_type']]);
            }
            ?>&nbsp;</td>
          <td><?php echo h($cabinet['Cabinet']['actual_dimensions_width']); ?>&nbsp;</td>
          <td><?php echo h($cabinet['Cabinet']['actual_dimensions_height']); ?>&nbsp;</td>
          <td class="cabinets-dept"><?php echo h($cabinet['Cabinet']['actual_dimensions_depth']); ?>&nbsp;</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>
