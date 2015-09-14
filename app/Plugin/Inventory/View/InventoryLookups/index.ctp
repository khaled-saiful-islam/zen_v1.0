<div class="inventoryLookups index">
  <legend><?php echo __(h($this->InventoryLookup->to_camel_case($friendly_type)) . ' Data Settings'); ?></legend>
  <div align="right">
    <a class="search_link" href="#">
      <span class="search-img">Search</span>
    </a>
  </div>
  <div id="search_div">
    <?php echo $this->Form->create('InventoryLookup', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
    <table class="table-form-big search_div" style="min-width: 100px;">
      <tr>
        <?php if (!$type_config['name']['hidden']) { ?>
          <td><?php echo (isset($type_config['name']['label']) ? h($type_config['name']['label']) : 'Name' . ": ") . $this->Form->input('name', array('placeholder' => isset($type_config['name']['label']) ? h($type_config['name']['label']) : 'Name')); ?></td>
        <?php } ?>
        <?php if (!$type_config['value']['hidden']) { ?>
          <td><?php echo (isset($type_config['value']['label']) ? h($type_config['value']['label']) : 'Value' . ": ") . $this->Form->input('value', array('placeholder' => isset($type_config['value']['label']) ? h($type_config['value']['label']) : 'Value')); ?></td>
        <?php } ?>
        <?php if (!$type_config['lookup_type']['hidden']) { ?>
          <!--<td><?php echo (isset($type_config['lookup_type']['label']) ? h($type_config['lookup_type']['label']) : 'Settings Type' . ": ") . $this->Form->input('lookup_type', array('placeholder' => isset($type_config['lookup_type']['label']) ? h($type_config['lookup_type']['label']) : 'Settings Type')); ?></td>-->
          <!--<td><?php echo $this->Paginator->sort('lookup_type', 'Settings Type'); ?></td>-->
        <?php } ?>
        <td class="width-min">
          <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success item_data_submit', 'div' => false)); ?>
        </td>
      </tr>
    </table>
    <?php echo $this->Form->end(); ?>
  </div>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">

        <?php if (!$type_config['name']['hidden']) { ?>
          <th><?php echo $this->Paginator->sort('name', isset($type_config['name']['label']) ? h($type_config['name']['label']) : 'Name'); ?></th>
        <?php } ?>

        <?php if (!$type_config['value']['hidden']) { ?>
          <th><?php echo $this->Paginator->sort('value', isset($type_config['value']['label']) ? h($type_config['value']['label']) : 'Value'); ?></th>
        <?php } ?>

        <?php if (!$type_config['price']['hidden']) { ?>
          <th><?php echo $this->Paginator->sort('price', isset($type_config['price']['label']) ? h($type_config['price']['label']) : 'Price'); ?></th>
        <?php } ?>

        <?php if (!$type_config['price_unit']['hidden']) { ?>
          <th><?php echo $this->Paginator->sort('price_unit', isset($type_config['price_unit']['label']) ? h($type_config['price_unit']['label']) : 'Price Unit'); ?></th>
        <?php } ?>

        <?php if (!$type_config['parent_lookup']['hidden']) { ?>
          <th><?php echo $this->Paginator->sort('parent_lookup', isset($type_config['parent_lookup']['label']) ? h($type_config['parent_lookup']['label']) : 'Parent Setting'); ?></th>
        <?php } ?>

        <?php if (!$type_config['department_id']['hidden']) { ?>
          <th><?php echo isset($type_config['department_id']['label']) ? h($type_config['department_id']['label']) : 'Department'; ?></th>
        <?php } ?>

        <?php if (!$type_config['lookup_type']['hidden']) { ?>
          <th><?php echo $this->Paginator->sort('lookup_type', 'Settings Type'); ?></th>
        <?php } ?>

        <th class="actions"><?php echo __(''); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($inventoryLookups as $inventoryLookup):
        $system_data = '';
        if ($inventoryLookup['InventoryLookup']['system']) {
          $system_data = 'system-data';
        }
        ?>
        <tr class="<?php echo $system_data; ?>">
          <td><?php echo h($inventoryLookup['InventoryLookup']['name']); ?>&nbsp;</td>

          <?php if (!$type_config['value']['hidden']) { ?>
            <td><?php echo h($this->InventoryLookup->text_setting_type($inventoryLookup['InventoryLookup']['value'])); ?>&nbsp;</td>
          <?php } ?>

          <?php if (!$type_config['price']['hidden']) { ?>
            <td class="text-right"><?php echo h($this->Util->formatCurrency($inventoryLookup['InventoryLookup']['price'])); ?>&nbsp;</td>
          <?php } ?>

          <?php if (!$type_config['price_unit']['hidden']) { ?>
            <td><?php echo h($this->InventoryLookup->text_setting_type($inventoryLookup['InventoryLookup']['price_unit'])); ?>&nbsp;</td>
          <?php } ?>

          <?php if (!$type_config['parent_lookup']['hidden']) { ?>
            <td>
              <?php
              if ($inventoryLookup['InventoryLookup']['parent_lookup']) {
                $parent_lookup = $this->InventoryLookup->InventoryLookupReverse($inventoryLookup['InventoryLookup']['parent_lookup']);
                echo h($parent_lookup);
              }
              ?>
            </td>
          <?php } ?>

          <?php if (!$type_config['department_id']['hidden']) { ?>
            <td>
              <ul>
                <?php
                if (isset($inventoryLookup['InventoryLookup']['department_id']) && !empty($inventoryLookup['InventoryLookup']['department_id']) && is_array($inventoryLookup['InventoryLookup']['department_id'])) {
                  foreach ($inventoryLookup['InventoryLookup']['department_id'] as $department_id) {
                    $department = $this->InventoryLookup->getItemDepartmentName($department_id);
                    echo '<li>' . h($department) . '</li>';
                  }
                }
                ?>
              </ul>
            </td>
          <?php } ?>

          <?php if (!$type_config['lookup_type']['hidden']) { ?>
            <td><?php echo h($this->InventoryLookup->text_setting_type($inventoryLookup['InventoryLookup']['lookup_type'])); ?>&nbsp;</td>
          <?php } ?>

          <td class="actions">
            <?php echo $this->Html->link('', array('action' => DETAIL, $inventoryLookup['InventoryLookup']['id'], $type), array('class' => 'icon-folder-open show-tooltip', 'title' => __('View'))); ?>
            <?php // echo $this->Html->link('', array('action' => EDIT, $inventoryLookup['InventoryLookup']['id']), array('class' => 'icon-edit show-edit-ajax', 'title' => __('Edit'))); ?>
            <?php
            if (!$inventoryLookup['InventoryLookup']['system']) {
              echo $this->Form->postLink('', array('action' => DELETE, $inventoryLookup['InventoryLookup']['id'], $type), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $inventoryLookup['InventoryLookup']['name']));
            }
            ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php echo $this->element('Common/paginator'); ?>
</div>