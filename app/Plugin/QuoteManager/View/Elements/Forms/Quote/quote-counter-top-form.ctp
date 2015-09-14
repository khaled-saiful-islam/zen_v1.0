<fieldset>
  <?php if ($edit) { ?>
    <legend class='inner-legend'>Edit Counter Top</legend>
  <?php } ?> 

  <div id="counter_top_items" >
    <?php echo $this->Form->input("type", array("type" => "hidden",'value' => 'Counter Top')); ?>
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>
          <th>To be used in</th>
          <th>Item</th>
          <th>Description</th>
          <th>Quantity</th>
          <th>Each Cost</th>
          <th>Total Cost</th>
          <th>Order Number</th>          
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
          <td>
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.quote_id", array("type" => "hidden", "class" => "quote_id user-input", 'value' => $this->data['Quote']['id']));
            echo $this->Form->input("CabinetOrderItem.-1.item_id", array("type" => "hidden", "class" => "item_id user-input"));
            echo $this->Form->input("CabinetOrderItem.-1.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
            echo $this->Form->input("CabinetOrderItem.-1.door_id", array("type" => "hidden", "class" => "door_id user-input"));

            echo $this->Form->input("CabinetOrderItem.-1.used_in", array(
                "class" => "used_in user-input form-select required",
                "placeholder" => "To be used in",
                "label" => false,
                "value" => "To be used in"
            ));
            ?>
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
          <td>            
            <span class='data-title'>&nbsp;</span>
          </td>
          <td>
            <?php
            echo $this->Form->input("CabinetOrderItem.-1.quantity", array(
                "class" => "quantity user-input small-input required set-item-cost",
                "placeholder" => "Quantity",
                "label" => false,
                "value" => 0
            ));
            ?>
          </td>
          <td>
            <span class='data-each-cost'>0.00</span>
          </td>
          <td> 
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
            <a href="#" class="icon-remove icon-remove-margin remove"></a>
          </td>
        </tr>
        <?php
        $total_cost = 0.00;
        if (!empty($this->data['CabinetOrderItem'])) {
          foreach ($this->data['CabinetOrderItem'] as $index => $value) {
            if ($value['type'] == 'Counter Top') {
              ?>
              <tr class="clone-row">
                <td>
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.quote_id", array("type" => "hidden", "class" => "quote_id user-input"));
                  echo $this->Form->input("CabinetOrderItem.{$index}.item_id", array("type" => "hidden", "class" => "item_id user-input"));
                  echo $this->Form->input("CabinetOrderItem.{$index}.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
                  echo $this->Form->input("CabinetOrderItem.{$index}.door_id", array("type" => "hidden", "class" => "door_id user-input"));

                  echo $this->Form->input("CabinetOrderItem.{$index}.used_in", array(
                      "class" => "used_in user-input form-select required",
                      "placeholder" => "To be used in",
                      "label" => false
                  ));
                  ?>
                </td>
                <td>
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.code", array(
                      "class" => "code user-input form-select required set-item-cost",
                      "placeholder" => "Code",
                      "label" => false,
                      "options" => $main_item_list
                  ));
                  ?>
                </td>
                <td>
                  <?php
                  $title = '';
                  if (!empty($this->data['CabinetOrderItem'][$index]['code']))
                    $title = $title_list[$this->data['CabinetOrderItem'][$index]['code']];
                  ?>
                  <span class='data-title'><?php echo $title; ?></span>
                </td>
                <td>
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.quantity", array(
                      "class" => "quantity user-input small-input required set-item-cost",
                      "placeholder" => "Quantity",
                      "label" => false
                  ));
                  ?>
                </td>
                <td>          
                  <?php
                  $each_cost = '';
                  if (!empty($this->data['CabinetOrderItem'][$index]['code']))
                    $each_cost = $price_list[$this->data['CabinetOrderItem'][$index]['code']];;
                  ?>
                  <span class='data-each-cost'><?php echo $each_cost; ?></span>
                </td>
                <td>
                  <?php
                  $item_total_cost = number_format($each_cost * $this->data['CabinetOrderItem'][$index]['quantity'], 2, '.', '');
                  $total_cost+=$item_total_cost;
                  echo "<span class='data-item-total-cost'>" . $item_total_cost . "</span>";
                  ?>
                </td>
                <td>          
                  <?php
                  echo $this->Form->input("CabinetOrderItem.{$index}.order_number", array(
                      "class" => "order_number user-input required",
                      "placeholder" => "Order Number",
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
          <td colspan="5" class="text-right" style="font-weight: bold;">
            Total:	
          </td>
          <td>
            <span class='data-total-cost'><?php echo number_format($total_cost, 2, '.', ''); ?></span>
          </td>
          <td colspan="2">
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
