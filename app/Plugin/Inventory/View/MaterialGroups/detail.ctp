<div class="inventoryLookups view">
  <fieldset class="content-detail">
    <div id="inventory-lookup-information">
			<legend><?php echo "Material Group Data Settings"; ?></legend>
      <div class="detail actions">
        <?php echo $this->Html->link('Edit Setting', array('action' => EDIT, $material_group['MaterialGroup']['id']), array('data-target' => '#inventory-lookup-information','class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit Setting'))); ?>
      </div>
      <table class="table table-striped table-data-compact">
        <tr>
          <th><?php echo __('Name'); ?>:</th>
          <td>
            <?php echo h($material_group['MaterialGroup']['name']); ?>
            &nbsp;
          </td>
        </tr>
				<tr>
          <th><?php echo __('Code'); ?>:</th>
          <td>
            <?php echo h($material_group['MaterialGroup']['code']); ?>
            &nbsp;
          </td>
        </tr>
				<tr>
          <th><?php echo __('Default'); ?>:</th>
          <td>
            <?php 
							if($material_group['MaterialGroup']['default'] == 1) echo "Yes";
							if($material_group['MaterialGroup']['default'] == 0) echo "No";
						?>
            &nbsp;
          </td>
        </tr>
      </table>
    </div>
  </fieldset>
</div>