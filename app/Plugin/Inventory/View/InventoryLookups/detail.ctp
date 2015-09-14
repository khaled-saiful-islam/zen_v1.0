<div class="inventoryLookups view">
  <fieldset class="content-detail">
    <legend><?php echo __(h($this->InventoryLookup->to_camel_case($type)) . ' Data Settings'); ?></legend>
    <div id="inventory-lookup-information">
      <div class="detail actions">
        <?php
        if (!$inventoryLookup['InventoryLookup']['system'] || in_array($inventoryLookup['InventoryLookup']['lookup_type'], $editable_system_data)) {
          echo $this->Html->link('Edit Setting', array('action' => EDIT, $inventoryLookup['InventoryLookup']['id'], $type), array('data-target' => '#inventory-lookup-information', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit Setting')));
        }
        ?>
      </div>
      <table class="table table-striped table-data-compact">

        <?php if (!$type_config['name']['hidden']) { ?>
          <tr>
            <th><?php echo __(isset($type_config['name']['label']) ? h($type_config['name']['label']) : 'Name'); ?>:</th>
            <td>
              <?php echo h($inventoryLookup['InventoryLookup']['name']); ?>
              &nbsp;
            </td>
          </tr>
        <?php } ?>

        <?php if (!$type_config['value']['hidden']) { ?>
          <tr>
            <th><?php echo __(isset($type_config['value']['label']) ? h($type_config['value']['label']) : 'Value'); ?>:</th>
            <td>
              <?php echo h($inventoryLookup['InventoryLookup']['value']); ?>
              &nbsp;
            </td>
          </tr>
        <?php } ?>

        <?php if (!$type_config['price']['hidden']) { ?>
          <tr>
            <th><?php echo __(isset($type_config['price']['label']) ? h($type_config['price']['label']) : 'Price'); ?>:</th>
            <td>
              <?php echo $this->Util->formatCurrency($inventoryLookup['InventoryLookup']['price']); ?>
              &nbsp;
            </td>
          </tr>
        <?php } ?>

        <?php if (!$type_config['price_unit']['hidden']) { ?>
          <tr>
            <th><?php echo __(isset($type_config['price_unit']['label']) ? h($type_config['price_unit']['label']) : 'Price Unit'); ?>:</th>
            <td>
              <?php echo h($inventoryLookup['InventoryLookup']['price_unit']); ?>
              &nbsp;
            </td>
          </tr>
        <?php } ?>

        <?php if (!$type_config['parent_lookup']['hidden']) { ?>
          <tr>
            <th><?php echo __(isset($type_config['parent_lookup']['label']) ? h($type_config['parent_lookup']['label']) : 'Parent Setting'); ?>:</th>
            <td>
              <?php
              if ($inventoryLookup['InventoryLookup']['parent_lookup']) {
                $parent_lookup = $this->InventoryLookup->InventoryLookupReverse($inventoryLookup['InventoryLookup']['parent_lookup']);
                echo h($parent_lookup);
              }
              ?>
              &nbsp;
            </td>
          </tr>
        <?php } ?>

        <?php if (!$type_config['department_id']['hidden']) { ?>
          <tr>
            <th><?php echo __(isset($type_config['department_id']['label']) ? h($type_config['department_id']['label']) : 'Department'); ?>:</th>
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
              &nbsp;
            </td>
          </tr>
        <?php } ?>

        <?php if (!$type_config['lookup_type']['hidden']) { ?>
          <tr>
            <th><?php echo __('Lookup Type'); ?>:</th>
            <td>
              <?php echo h($this->InventoryLookup->to_camel_case($inventoryLookup['InventoryLookup']['lookup_type'])); ?>
              &nbsp;
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </fieldset>
</div>