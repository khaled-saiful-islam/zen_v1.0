<div class="inventoryLookups view">
  <fieldset class="content-detail">
    <div id="inventory-lookup-information">
      <legend><?php echo "Material Data Settings"; ?></legend>
      <div class="detail actions">
        <?php echo $this->Html->link('Edit Setting', array('action' => EDIT, $material['Material']['id']), array('data-target' => '#inventory-lookup-information', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit Setting'))); ?>
      </div>
      <table class="table table-striped table-data-compact">
        <tr>
          <th><?php echo __('Name'); ?>:</th>
          <td>
            <?php echo h($material['Material']['name']); ?>
            &nbsp;
          </td>
          <th><?php echo __('Code'); ?>:</th>
          <td>
            <?php echo h($material['Material']['code']); ?>
            &nbsp;
          </td>
        </tr>
        <tr>
          <th><?php echo __('Width'); ?>:</th>
          <td>
            <?php echo h($material['Material']['width']); ?>
            &nbsp;
          </td>
          <th><?php echo __('Length'); ?>:</th>
          <td>
            <?php echo h($material['Material']['length']); ?>
            &nbsp;
          </td>
        </tr>
        <tr>
          <th><?php echo __('Cost'); ?>:</th>
          <td>
            <?php echo h($material['Material']['cost']); ?>
            &nbsp;
          </td>
          <th><?php echo __('Markup'); ?>:</th>
          <td>
            <?php echo h($material['Material']['markup']); ?>
            &nbsp;
          </td>
        </tr>
        <tr>
          <th><?php echo __('Price'); ?>:</th>
          <td>
            <?php echo $this->Util->formatCurrency($material['Material']['price']); ?>
            &nbsp;
          </td>
          <th><?php echo __('Material Group'); ?>:</th>
          <td>
            <?php echo h($this->InventoryLookup->findMaterialGroup($material['Material']['material_group_id'])); ?>
            &nbsp;
          </td>
        </tr>
        <tr>
          <th><?php echo __('Custom Markup'); ?>:</th>
          <td>
            <?php echo $material['Material']['custom_markup']; ?>
            &nbsp;
          </td>
          <td colspan="2">
            &nbsp;
          </td>
        </tr>
      </table>
    </div>
  </fieldset>
</div>
<style type="text/css">
  .table-data-compact tr td{
    width: 150px;
  }
</style>