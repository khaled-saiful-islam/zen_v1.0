<?php
$cabinet = null;
if (isset($this->request->data['Cabinet'])) {
  $cabinet = $this->request->data['Cabinet'];
}
echo $this->Form->create('Cabinet', array('type' => 'file', 'action' => "edit/{$cabinet_id}#cabinet_general", 'inputDefaults' => array('label' => false, 'div' => false), 'class' => 'cabinet-form ajax-form-submit'));
echo $this->Form->input('id', array('class' => 'hide', 'type' => 'hidden', 'value' => $cabinet_id));
?>
<div id="cabinet_information" class="sub-content-detail">
  <fieldset>
    <table class='table-form-big'>
      <tr>
        <th><label for="CabinetAssemblyInstruction">Assembly Instruction:</label></th>
        <td class="big-table-td-width"><?php echo $this->Form->input('assembly_instruction', array('class' => 'wide-input', 'placeholder' => 'Assembly Instruction')); ?></td>
      </tr>
      <tr>
        <th><label for="CabinetQuoteColorRequired">Quote Color Required:</label></th>
        <td class="big-table-td-width"><?php echo $this->Form->input('quote_color_required'); ?></td>
      </tr>
      <tr>
        <th><label for="CabinetQuoteMaterialRequired">Quote Material Required:</label></th>
        <td class="big-table-td-width"><?php echo $this->Form->input('quote_material_required'); ?></td>
      </tr>
    </table>
  </fieldset>
</div>
<div class="">
  <?php
  echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save'));
  ?>
</div>
<?php
echo $this->Form->end();
?>