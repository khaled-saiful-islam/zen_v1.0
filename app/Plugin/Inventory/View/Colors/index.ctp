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
          <a href="<?php echo $this->webroot . $url; ?>" class="icon-print open-link show-tooltip" data_target="color_report" title="Print Listing"></a>
        </div>
      </legend>
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('Color', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo "<div class=''>Color Name</div>" . $this->Form->input('name', array('placeholder' => 'Color Name')); ?>
            </td>
            <td>
              <?php echo "<div class=''>Color Code</div>" . $this->Form->input('code', array('placeholder' => 'Color Code')); ?>
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
            <th class="min-width"><?php echo $this->Paginator->sort('name'); ?></th>
            <th class="min-width"><?php echo $this->Paginator->sort('code'); ?></th>
            <th class="min-width">Cabinet Color Price</th>
            <th class="min-width">Door Color Price</th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 0;
          foreach ($colors as $color):
            $count++;
            $door_section_price = '';
            $cabinet_section_price = '';
            if (isset($color['ColorSection'][0]['type'])) {
              if ($color['ColorSection'][0]['type'] == 'cabinate_material') {
                $cabinet_section_price = $color['ColorSection'][0]['price'];
              } else {
                $door_section_price = $color['ColorSection'][0]['price'];
              }
            }
            if (isset($color['ColorSection'][1]['type'])) {
              if ($color['ColorSection'][1]['type'] == 'cabinate_material') {
                $cabinet_section_price = $color['ColorSection'][1]['price'];
              } else {
                $door_section_price = $color['ColorSection'][1]['price'];
              }
            }
            ?>
            <tr class="<?php //echo $odd_even;      ?>">
              <td><?php echo $this->Html->link(h($color['Color']['name']), array('action' => DETAIL, $color['Color']['id']), array('title' => __('View'), 'class' => 'table-first-column-color show-tooltip')); ?>&nbsp;</td>
              <td><?php echo h($color['Color']['code']); ?>&nbsp;</td>
              <td class="text-right"><?php echo $this->Util->formatCurrency($cabinet_section_price); ?>&nbsp;</td>
              <td class="text-right"><?php echo $this->Util->formatCurrency($door_section_price); ?>&nbsp;</td>
              <td class="actions">
                <?php echo $this->Html->link('', array('action' => DETAIL, $color['Color']['id']), array('class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
                <?php //echo $this->Form->postLink('', array('action' => DELETE, $color['Color']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $color['Color']['id'])); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
  </div>
<?php } else { ?>
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
      foreach ($colors as $color):
        $count++;
        ?>
        <tr class="<?php //echo $odd_even;      ?>">
          <td><?php echo h($color['Color']['number']); //echo $this->Html->link(h($color['Color']['number']), array('action' => DETAIL, $color['Color']['id']), array('title' => __('View'), 'class' => 'show-detail-ajax table-first-column-color'));      ?>&nbsp;</td>
          <td><?php echo h($color['Color']['item_title']); ?>&nbsp;</td>
          <td><?php echo h($color['Color']['item_cost']); ?>&nbsp;</td>
          <td><?php echo h($color['Color']['price']); ?>&nbsp;</td>
          <td>
            <?php //echo $this->Html->link($color['Supplier']['name'], array('controller' => 'suppliers', 'action' => DETAIL, $color['Supplier']['id']), array('class' => 'show-detail-ajax')); ?>
            <?php echo h($color['Supplier']['name']); //echo $this->Html->link(h($color['Supplier']['name']), array('plugin'=>'inventory','controller'=>'suppliers','action' => DETAIL, $color['Supplier']['id'],'modal'), array('title' => __($color['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal')); ?>
            &nbsp;
          </td>
          <td><?php echo h($color['Color']['current_stock']); ?>&nbsp;</td>
          <td><?php echo h($color['Color']['width']); ?>&nbsp;</td>
          <td><?php echo h($color['Color']['length']); ?>&nbsp;</td>
          <td class="item-dep">
            <?php echo h($color['ItemDepartment']['name']); //echo $this->Html->link(h($color['ItemDepartment']['name']), array('controller' => 'item_departments', 'action' => DETAIL, $color['ItemDepartment']['id']), array('class' => 'show-detail-ajax')); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php } ?>