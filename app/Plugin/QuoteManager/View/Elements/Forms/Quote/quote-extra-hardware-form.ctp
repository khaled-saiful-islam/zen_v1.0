<fieldset>
  <?php if ($edit) { ?>
    <legend class='inner-legend'>
      <?php if ($section == 'extra-hardware') { ?>
        Edit Job Extras/Hardware
      <?php } elseif ($section == 'door-shelf') { ?>
        Edit Glass Doors & Shelfs
      <?php } ?>
    </legend>
  <?php } ?> 

  <div id="extra_hardware_items" >
    <?php
    $type = "";
    if ($section == 'extra-hardware') {
      echo $this->Form->input("type", array("type" => "hidden",'value' => 'Extra Hardware'));
      $type = "Extra Hardware";
    } elseif ($section == 'door-shelf') {
      echo $this->Form->input("type", array("type" => "hidden",'value' => 'Glass Door Shelf'));
      $type = "Glass Door Shelf";
    }
//    echo $this->Form->input("$model_name.form_type", array(
//        "class" => "form_type",
//        "label" => false,
//        "type" => 'hidden',
//        'value' => $model_name
//    ));
    ?>
    <input type="hidden" value="CabinetOrderItem" class="form_type" />    
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>
          <th>Description</th>
          <th>Item</th>          
          <th>Quantity</th>
          <th>Each Cost</th>
          <th>Total Cost</th>
          <th>Order Number</th> 
          <th>Optional Color</th> 
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
          <td>
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.quote_id", array("type" => "hidden", "class" => "quote_id user-input",'value' => $this->data['Quote']['id']));
            echo $this->Form->input("CabinetOrderItem.-1.item_id", array("type" => "hidden", "class" => "item_id user-input"));
            echo $this->Form->input("CabinetOrderItem.-1.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
            echo $this->Form->input("CabinetOrderItem.-1.door_id", array("type" => "hidden", "class" => "door_id user-input"));
            ?>
            <span class='data-title'>&nbsp;</span>
          </td>
          <td>
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.code", array(
                "class" => "code user-input required form-select set-item-cost",
                "placeholder" => "",
                "label" => false,
                "options" => $main_item_list
            ));
            ?>
          </td>
          <td class="">
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.quantity", array(
                "class" => "quantity user-input small-input required set-item-cost",
                "placeholder" => "Quantity",
                "label" => false,
                "value" => 0
            ));
            ?>
          </td>
          <td class="">
            <span class='data-each-cost'>0.00</span>
          </td>
          <td class=""> 
            <span class='data-item-total-cost'>0.00</span>
          </td>
          <td>          
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.order_number", array(
                "class" => "order_number user-input required small-wide-input",
                "placeholder" => "Order Number",
                "label" => false,
                "value" => "142563"
            ));
            ?>          
          </td>
          <td>          
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.optional_color", array(
                "class" => "optional_color user-input",
                "placeholder" => "Optional Color",
                "label" => false,
                "value" => "Optional Color"
            ));
            ?>          
          </td>
          <td>
            <a href="#" class="icon-remove icon-remove-margin remove"></a>
          </td>
        </tr>
        <?php
        $total_cost = 0.00;
        if (!empty($this->data['CabinetOrderItem'])) {
          foreach ($this->data['CabinetOrderItem'] as $index => $value) {
            if ($value['type'] == $type) {
              ?>
              <tr class="clone-row">
                <td>
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.quote_id", array("type" => "hidden", "class" => "quote_id user-input", 'value' => $this->data['Quote']['id']));
                  echo $this->Form->input("CabinetOrderItem.{$index}.item_id", array("type" => "hidden", "class" => "item_id user-input"));
                  echo $this->Form->input("CabinetOrderItem.{$index}.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
                  echo $this->Form->input("CabinetOrderItem.{$index}.door_id", array("type" => "hidden", "class" => "door_id user-input"));
                  ?>
                  <?php
                  $title = '';
                  if (!empty($this->data['CabinetOrderItem'][$index]['code']))
                    $title = $title_list[$this->data['CabinetOrderItem'][$index]['code']];
                  ?>
                  <span class='data-title'><?php echo $title; ?></span>
                </td>
                <td>
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.code", array(
                      "class" => "code user-input required form-select set-item-cost",
                      "placeholder" => "",
                      "label" => false,
                      "options" => $main_item_list
                  ));
                  ?>
                </td>
                <td class="">
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.quantity", array(
                      "class" => "quantity user-input small-input required set-item-cost",
                      "placeholder" => "Quantity",
                      "label" => false
                  ));
                  ?>
                </td>
                <td class="">
                  <?php
                  $each_cost = '';
                  if (!empty($this->data['CabinetOrderItem'][$index]['code']))
                    $each_cost = $price_list[$this->data['CabinetOrderItem'][$index]['code']];;
                  ?>
                  <span class='data-each-cost'><?php echo $each_cost; ?></span>
                </td>
                <td class=""> 
                  <?php
                  $item_total_cost = number_format($each_cost * $this->data['CabinetOrderItem'][$index]['quantity'], 2, '.', '');
                  $total_cost+=$item_total_cost;
                  echo "<span class='data-item-total-cost'>" . $item_total_cost . "</span>";
                  ?>
                </td>
                <td>          
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.order_number", array(
                      "class" => "order_number user-input required small-wide-input",
                      "placeholder" => "Order Number",
                      "label" => false,
                  ));
                  ?>          
                </td>
                <td>          
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.optional_color", array(
                      "class" => "optional_color user-input",
                      "placeholder" => "Optional Color",
                      "label" => false,
                  ));
                  ?>          
                </td>
                <td>
                  <a href="#" class="icon-remove icon-remove-margin remove"></a>
                </td>
              </tr>
              <?php
            }
          }
        }
        ?>
        <tr>
          <td colspan="4" class="text-right" style="font-weight: bold;">
            Total:	
          </td>
          <td class="">
            <span class='data-total-cost'><?php echo number_format($total_cost, 2, '.', ''); ?></span>
          </td>
          <td colspan="3">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <input type="button" class="btn btn-info add-more" value="Add More" />	
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</fieldset>
