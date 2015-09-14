<div id="cabinet_items" class="tab-pane">
  <fieldset>
<!--          <table class='table-form-compact'>
      <tr>
        <td><?php echo $this->Form->input('Item', array('options' => $this->InventoryLookup->item(), 'class' => 'multiselect')); ?></td>
      </tr>
    </table>-->
    <legend <?php if ($edit) { ?>class='inner-legend'<?php } ?>>Edit Cabinet Parts</legend>
    <div class="cabinets-items">
      <table class="table-form-big" style="width: 70%;">
        <thead>
          <tr>
            <th>Item Code</th>
            <th>Description</th>
            <th>Department</th>
            <th>Cost</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>&nbsp;</th>
            <!--<th>Category</th>-->
          </tr>
        </thead>
        <tbody>
          <tr class="clone-row hide">
            <td>
              <?php
              $item_departments = $this->InventoryLookup->ItemDepartment();
              $description = '';
              $department = '';
              $cost = '';
              $quantity = 0;
//              if (!empty($this->data['CabinetsItem'])) {
//                $item = $this->InventoryLookup->ItemDetail($this->data['CabinetsItem'][0]['item_id']);
//                $description = $item['Item']['description'];
//                $cost = $item['Item']['price'];
//                $quantity = $this->data['CabinetsItem'][0]['item_quantity'];
//              }
              echo $this->Form->input("CabinetsItem.-1.accessories", array(
                  "class" => "accessories hide",
                  "value" => "0",
                  "label" => false,
                  'type' => 'hidden',
              ));
              echo $this->Form->input("CabinetsItem.-1.item_id", array(
                  "class" => "item_id user-input form-select-ajax-base-item form-select-ajax-item-cabinet-item wide-input",
                  "label" => false,
                  "type" => 'hidden',
                  'data-placeholder' => 'Item Code'
              ));
              ?>
            </td>
            <td class="description">
              <?php echo $description; ?>&nbsp;
            </td>
            <td class="department">
              <?php echo $department; ?>&nbsp;
            </td>
            <td class="cost">
              <?php echo $cost; ?>&nbsp;
            </td>
            <td>
              <?php
              echo $this->Form->input("CabinetsItem.-1.item_quantity", array(
                  "class" => "item_quantity user-input",
                  "placeholder" => "Quantity",
                  "label" => false,
              ));
              ?>
            </td>
            <td class="price">
              <?php echo $cost * $quantity; ?>
            </td>
            <td class="remove">
              &nbsp
              <a href="#" class="icon-remove icon-remove-margin remove">&nbsp;</a>
            </td>
          </tr>
          <?php
          if (!empty($this->data['CabinetsItem'])) {
            foreach ($this->data['CabinetsItem'] as $index => $value) {
              if ($value['accessories'])
                continue; // skip the accessories

              $item = $this->InventoryLookup->ItemDetail($value['item_id']);
              $description = $item['Item']['description'];
              $department = $item_departments[$item['Item']['item_department_id']];
              $cost = $item['Item']['price'];
              $quantity = $value['item_quantity'];
              ?>
              <tr class="clone-row">
                <td>
                  <?php
                  echo $this->Form->input("CabinetsItem.{$index}.accessories", array(
                      "class" => "accessories hide",
                      "value" => "0",
                      "label" => false,
                      'type' => 'hidden',
                  ));
                  echo $this->Form->input("CabinetsItem.{$index}.item_id", array(
                      "class" => "item_id user-input form-select-ajax-base-item form-select-ajax-item-cabinet-item wide-input required",
                      "label" => false,
                      "type" => 'hidden',
                  ));
                  ?>
                </td>
                <td class="description">
                  <?php echo $description; ?>&nbsp;
                </td>
                <td class="department">
                  <?php echo $department; ?>&nbsp;
                </td>
                <td class="cost">
                  <?php echo $cost; ?>&nbsp;
                </td>
                <td>
                  <?php
                  echo $this->Form->input("CabinetsItem.{$index}.item_quantity", array(
                      "class" => "item_quantity user-input required",
                      "placeholder" => "Quantity",
                      "label" => false,
                  ));
                  ?>
                </td>
                <td class="price">
                  <?php echo $cost * $quantity; ?>
                </td>
                <td class="remove">
                  &nbsp
                  <a href="#" class="icon-remove icon-remove-margin remove">&nbsp;</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
          <tr>
            <td colspan="6">
              <input type="button" class="btn btn-info add-more" value="Add An Item" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </fieldset>
</div>
<script>
  $(function(){
    $('.item_quantity').live('change',function(){
      parent = $(this).parents('table tr');
      cost = parseFloat(parent.find('td.cost').html()).toFixed(2);
      quantity = parseFloat($(this).val()).toFixed(2);
      price = parseFloat(cost * quantity).toFixed(2);
      parent.find('td.price').html(price);
    });
  });
</script>
