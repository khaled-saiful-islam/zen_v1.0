<div class="cabinetOrdersCustomDoor cabinetOrdersCustom form">
  <?php
  echo $this->Form->create('CabinetOrderCustomDoor', array('inputDefaults' => array()));
  ?>
  <table>
    <tr>
      <td valign="top">
        <fieldset>
          <?php echo $this->Form->input('height', array('placeholder' => 'Height')); ?>
          <?php echo $this->Form->input('width', array('placeholder' => 'Width')); ?>
          <?php echo $this->Form->input('door', array('placeholder' => 'Door Style', 'label' => 'Door Style', 'class' => 'form-select', 'options' => $this->InventoryLookup->DoorDataList('door_style', true), 'empty' => true)); ?>
          <?php echo $this->Form->input('color', array('placeholder' => 'Door Color', 'label' => 'Door Color', 'class' => 'form-select', 'options' => $this->InventoryLookup->Color(), 'empty' => true)); ?>
        </fieldset>
      </td>
      <td valign="top">
        <div id="debug-data"></div>
      </td>
    </tr>
  </table>
  <input type="button" id="add-custom-door" class="btn btn-info add-more" value="Add Door" />
  <?php echo $this->Form->end(); ?>
</div>