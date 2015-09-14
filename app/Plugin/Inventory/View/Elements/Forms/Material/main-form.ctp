<table class='table-form-big'>
  <tr>
    <th><label for="MaterialName">Name: </label></th>
    <td><?php echo $this->Form->input('name', array('class' => 'input-medium required', 'placeholder' => 'Name')); ?></td>
    <th><label for="MaterialCode">Code: </label></th>
    <td><?php echo $this->Form->input('code', array('class' => 'input-medium required', 'placeholder' => 'Code')); ?></td>
  </tr>
  <tr>
    <th><label for="MaterialWidth">Width: </label></th>
    <td><?php echo $this->Form->input('width', array('class' => 'input-medium required number', 'placeholder' => 'Width')); ?></td>
    <th><label for="MaterialLength">Length: </label></th>
    <td><?php echo $this->Form->input('length', array('class' => 'input-medium required number', 'placeholder' => 'Length')); ?></td>
  </tr>
  <tr>
    <th><label for="MaterialCost">Cost: </label></th>
    <td><?php echo $this->Form->input('cost', array('class' => 'input-medium material_cost required number', 'placeholder' => 'Cost')); ?></td>
    <th><label for="MaterialMarkup">Markup: </label></th>
    <td><?php echo $this->Form->input('markup', array('class' => 'input-medium material_markup required number', 'placeholder' => 'Markup')); ?></td>
  </tr>
  <tr>
    <th><label for="MaterialPrice">Price: </label></th>
    <td><?php echo $this->Form->input('price', array('class' => 'input-medium material_price number', 'placeholder' => 'Price', 'readonly' => true)); ?></td>
    <th><label for="MaterialMaterialGroupId">Material Group: </label></th>
    <td><?php echo $this->Form->input('material_group_id', array('options' => $this->InventoryLookup->getMaterialGroup(), 'default' => isset($data['MaterialGroup']['id']) ? $data['MaterialGroup']['id'] : '', 'class' => 'input-medium required form-select', 'empty' => true)); ?></td>
  </tr>
  <tr>
    <th><label for="MaterialPrice">Custom Markup: </label></th>
    <td colspan="3"><?php echo $this->Form->input('custom_markup', array('class' => 'input-medium number', 'placeholder' => 'Price')); ?></td>
  </tr>
</table>

<script type="text/javascript">
  $(function(){
    $('.material_cost, .material_markup').live('change',function(){
      cost = $('.material_cost').val();
      markup = $('.material_markup').val();
      price = parseFloat(cost * markup).toFixed(2);
      $('.material_price').val(price);
    })
  })
</script>