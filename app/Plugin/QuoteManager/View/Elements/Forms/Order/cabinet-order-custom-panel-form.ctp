<div class="cabinetOrdersCustomPanel cabinetOrdersCustom form">
  <?php
  echo $this->Form->create('CabinetOrderCustomPanel', array('inputDefaults' => array()));
  ?>
  <table>
    <tr>
      <td valign="top">
        <fieldset>
          <?php echo $this->Form->input('height', array('placeholder' => 'Height')); ?>
          <?php echo $this->Form->input('width', array('placeholder' => 'Width')); ?>
          <?php echo $this->Form->input('color_id', array('placeholder' => 'Color', 'class' => 'form-select', 'options' => $this->InventoryLookup->Color(), 'empty' => true)); ?>
          <?php echo $this->Form->input('material_id', array('placeholder' => 'Material', 'class' => 'form-select', 'options' => $this->InventoryLookup->getMaterial(), 'empty' => true)); ?>
          <?php echo $this->Form->input('edgetape', array('value' => '', 'readonly' => true)); ?>
        </fieldset>
      </td>
      <td valign="top">
        <div id="panel-edgatape-selection">
          <table border="0">
            <tbody>
              <tr>
                <td width="30">&nbsp;</td>
                <td width="152" align="center"><input type="checkbox" id="panel-edgatape-selection-l1" name="l1"></td>
                <td width="30">&nbsp;</td>
              </tr>
              <tr>
                <td width="30" valign="center"><input type="checkbox" id="panel-edgatape-selection-s1" name="s1"></td>
                <td width="152"><img src="<?php echo $this->webroot; ?>img/panel.jpg" width="150px" /></td>
                <td width="30"><input type="checkbox" id="panel-edgatape-selection-s2" name="s2"></td>
              </tr>
              <tr>
                <td width="30">&nbsp;</td>
                <td width="152" align="center"><input type="checkbox" id="panel-edgatape-selection-l2" name="l2"></td>
                <td width="30">&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <input type="button" id="add-custom-panel" class="btn btn-info add-more" value="Add Panel" />
  <?php echo $this->Form->end(); ?>
</div>
<script>
  $(document).ready(function() {
    $( "#panel-edgatape-selection input" ).click(function() {
      setCustomPanelEdgetape();
    });
  });
</script>