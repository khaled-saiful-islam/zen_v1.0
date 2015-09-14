<?php
echo $this->Form->create("ItemInventoryTransaction", array(
    "url" => array("controller" => "items", "action" => "add_to_inventory", isset($id) ? $id : ""),
    "inputDefaults" => array(
        "label" => false,
        "div" => false,
    ),
    'class' => 'add_to'
));
?>
<table class="table-form-big">
  <tr>
    <th>Quantity: </th>
    <td>
      <?php
      echo $this->Form->input('ItemInventoryTransaction.count', array(
          'class' => 'input-medium required number',
      ));
      ?>
    </td>
  </tr>
  <tr>
    <th>Item Code: </th>
    <td>
      <?php
      echo $this->Form->input('ItemInventoryTransaction.item_id', array(
          'class' => 'input-medium required form-select test',
          "options" => $this->InventoryLookup->getItemTitle($id),
          'empty' => false,
      ));
      ?>
    </td>
  </tr>
  <tr>
    <th>Supplier's name: </th>
    <td>
      <?php
      echo $this->Form->input('ItemInventoryTransaction.supplier_id', array(
          'class' => 'input-medium required form-select',
          "options" => $this->InventoryLookup->Supplier(),
          'empty' => false,
          "value" => isset($item['Item']['supplier_id']) ? $this->InventoryLookup->SupplierForView($item['Item']['supplier_id']) : ""
      ));
      ?>
    </td>
  </tr>
  <tr>
    <th>Comments: </th>
    <td style="padding-top: 15px;">
      <?php
      echo $this->Form->input('ItemInventoryTransaction.comment', array(
          'class' => 'textarea required',
          'type' => 'textarea',
          'rows' => 3
      ));
      ?>
    </td>
  </tr>
</table>
<div class="align-left align-top-margin">
  <input type="submit" class="btn btn-success" value="Save">
</div>

<?php echo $this->Form->end(); ?>

<script type="text/javascript">
  $(function(){
    $("form.add_to").validate({ignore: null});
    $("#ItemInventoryTransactionAddToInventoryForm").ajaxForm({url: $(this).attr('action'), type: 'post',  success: function(){$('select.item_sub_history').trigger('change', $('#ItemInventoryTransactionItemId').val()); $("#detailDialog").dialog('close');}});

    initialization();
  })

</script>