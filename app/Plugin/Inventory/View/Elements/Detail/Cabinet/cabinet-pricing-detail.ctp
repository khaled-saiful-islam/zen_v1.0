<fieldset>
  <?php if ($edit) { ?>
    <div class="detail actions">
      <?php echo $this->Html->link('Edit', array('action' => EDIT, $cabinet['Cabinet']['id'], 'pricing'), array('data-target' => '#cabinet_pricing', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
    </div>
  <?php } ?>
  <table class='table-form-big'>
    <tr>
      <th colspan="4">
        <label class="table-data-title text-left">Pricing Information</label>
      </th>
    </tr>
    <tr>
      <th><?php echo h('Taping'); ?>(feet):</th>
      <td>
        <?php echo h($cabinet['Cabinet']['taping']); ?>
        &nbsp;($0.20 per foot)
      </td>
      <th><?php echo h('Drilling'); ?>:</th>
      <td>
        <?php echo h($cabinet['Cabinet']['drilling']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo h('Back Cutting'); ?>:</th>
      <td>
        <?php echo h($cabinet['Cabinet']['back_cutting']); ?>
        &nbsp;
      </td>
      <th class="width-medium"><?php echo h('Assembly Box Count'); ?>:</th>
      <td>
        <?php echo h($cabinet['Cabinet']['assembly_box_count']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo h('Left Gable Price'); ?>:</th>
      <td>
        <?php echo h($this->Util->formatCurrency($cabinet['Cabinet']['left_gable_price'])); ?>
        &nbsp;
      </td>
      <th><?php echo h('Right Gable Price'); ?>:</th>
      <td>
        <?php echo h($this->Util->formatCurrency($cabinet['Cabinet']['right_gable_price'])); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th class="width-medium"><?php echo h('Manual Unit Price'); ?>:</th>
      <td colspan="3">
        <?php echo h($this->Util->formatCurrency($cabinet['Cabinet']['manual_unit_price'])); ?>
        &nbsp;
      </td>
    </tr>
  </table>
<!--  <table class="table-form-big table-form-big-margin">
    <tr>
      <th colspan="4">
        <label class="table-data-title">Accessibility Information</label>
      </th>
    </tr>
    <tr>
      <th><?php echo h('Item Access'); ?>:</th>
      <td>
        <?php echo h($this->InventoryLookup->text_public_access($cabinet['Cabinet']['item_access'])); ?>
        &nbsp;
      </td>
      <th><?php echo h('Product Line'); ?>:</th>
      <td >
        <?php
        if($cabinet['Cabinet']['product_line']){
          $pl = $this->InventoryLookup->InventoryLookup('product_line', $cabinet['Cabinet']['product_line']);
          echo h($pl[$cabinet['Cabinet']['product_line']]);
        }
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td colspan="3" class="radio-lable">
        <?php
        echo $this->Form->input('include_on_door_list', array('label' => 'Include On Door List', 'disabled' => 'disabled', 'div' => true, 'checked' => $cabinet['Cabinet']['include_on_door_list'])); ?>
        <?php
        echo $this->Form->input('include_on_finishing_list', array('label' => 'Include On Finishing List','disabled' => 'disabled', 'div' => true, 'checked' => $cabinet['Cabinet']['include_on_finishing_list'])); ?>

        &nbsp;
      </td>
    </tr>
  </table>-->
</fieldset>