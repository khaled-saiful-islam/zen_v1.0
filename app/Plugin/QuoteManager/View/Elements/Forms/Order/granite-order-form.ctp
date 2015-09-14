<div class="granite-orders form">
  <?php
  $all_items = $this->InventoryLookup->ListAllTypesOfItems();
  $main_item_list = $all_items['main_list'];
  $price_list = $all_items['price_list'];
  $title_list = $all_items['title_list'];
  $total_cost = $this->InventoryLookup->GraniteOrderCost($this->data['GraniteOrder']['id']);
//  debug($customerTypes);
//  debug($quotes);
  ?>
  <?php echo $this->Form->create('GraniteOrder', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'granite-order-form ajax-form-submit')); ?>
  <?php echo $this->Form->input('id'); ?>
  <?php echo $this->Form->input('quote_id', array('type' => 'hidden')); ?>
  <?php echo $this->Form->input('gst_value', array('type' => 'hidden', 'value' => GST, 'class' => 'gst_value')); ?>

  <fieldset>
    <table class='table-form-big'>
      <tr>
        <th><label for="">Granite:</label></th>
        <td><?php echo $this->Form->input('granite', array('placeholder' => 'Granite', 'class' => '')); ?></td>
        <th><label for="">Edge Profile: </label></th>
        <td><?php echo $this->Form->input('edge_profile', array('placeholder' => 'Door Style', 'class' => '')); ?></td>
      </tr>
      <tr>
        <th><label for="">Sqft Labour:</label></th>
        <td><?php echo $this->Form->input('sqft_labour', array('placeholder' => '0', 'class' => '')); ?></td>
        <th><label for="">Slab:</label></th>
        <td><?php echo $this->Form->input('slab', array('placeholder' => '0', 'class' => '')); ?></td>
      </tr>
      <tr>
        <th><label for="">Cost:</label></th>
        <td><?php echo $this->Form->input('cost', array('placeholder' => '0.00', 'type' => 'text', 'class' => 'extra-cost')); ?></td>
        <th><label for="">Radius:</label></th>
        <td><?php echo $this->Form->input('radius', array('placeholder' => 'Radius', 'type' => 'text', 'class' => '')); ?></td>
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin">
      <tr>
        <th class="wide-width"><label>Blacksplash (up to 6&quot;):</label></th>
        <td>
          <?php echo $this->Form->input('backsplash_up_to_six', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>Kitchen Under Mount:</label></th>
        <td>
          <?php echo $this->Form->input('kitchen_under_mount', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>Cook Top Cutout:</label></th>
        <td>
          <?php echo $this->Form->input('cook_top_cutout', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <th class="wide-width"><label>Blacksplash (over 6&quot;):</label></th>
        <td>
          <?php echo $this->Form->input('backsplash_over_six', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>Kitchen Top Mount:</label></th>
        <td>
          <?php echo $this->Form->input('kitchen_top_mount', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>Electrical Cutout:</label></th>
        <td>
          <?php echo $this->Form->input('electrical_cutout', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <th class="wide-width"><label>Island with Raised bar:</label></th>
        <td>
          <?php echo $this->Form->input('island_with_raised_bar', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>Vanity Under Mount Snik:</label></th>
        <td>
          <?php echo $this->Form->input('vanity_under_mount_sink', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>T/M to U/M Conversion:</label></th>
        <td>
          <?php echo $this->Form->input('tm_to_um_conversion', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <th class="wide-width"><label>Island no Raised bar:</label></th>
        <td>
          <?php echo $this->Form->input('island_no_raised_bar', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th class="wide-width"><label>Vanity Top Mount Snik:</label></th>
        <td>
          <?php echo $this->Form->input('vanity_top_mount_sink', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
        <th><label>&nbsp;</label></th>
        <td>
          &nbsp;
        </td>
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin">
      <tr>
        <th class="wide-width"><label>Travel Charge:</label></th>
        <td>
          <?php echo $this->Form->input('travel_charge', array('placeholder' => 'Travel Charge', 'class' => '')); ?>
        </td>
        <th class="wide-width"><label>Return Trips:</label></th>
        <td>
          <?php echo $this->Form->input('return_trip', array('placeholder' => '0', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <th><label for="">GST(%):</label></th>
        <td>
          <?php
            echo $this->Form->input('gst', array('readonly' => 'readonly', 'value' => GST,'class' => 'gst_value'));
          ?>
        </td>
        <th><label for="">Total Cost:</label></th>
        <td>
          <?php
          //$extra_cost = $this->data['GraniteOrder']['delivery_cost']+$this->data['GraniteOrder']['extras_glass']+$this->data['GraniteOrder']['counter_top']+$this->data['GraniteOrder']['installation']+$this->data['GraniteOrder']['discount'];
//          $value = isset($this->data['GraniteOrder']['total_cost']) ? $this->data['GraniteOrder']['total_cost'] : 0.00;
          echo $this->Form->input('total_cost', array('readonly' => 'readonly', 'value' => $total_cost['total_cost'], 'class' => 'total-cost'));
          ?>
        </td>
      </tr>
      <tr>
        <th><label>Discount</label></th>
        <td colspan="3">
          <?php
            echo $this->Form->input('discount_name', array('readonly' => 'readonly', 'value' => $quotes['Customer']['CustomerType']['name']));

          ?>
          <?php
          if($quotes['Customer']['customer_type_id']==2 || $quotes['Customer']['customer_type_id']==3)
            echo $this->Form->input('discount', array('type'=>'hidden','placeholder' => 'Discount','value'=>$quotes['Customer']['BuilderAccount']['discount_rate']));
          else
            echo $this->Form->input('discount', array('type'=>'hidden','placeholder' => 'Discount','value'=>0));
          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <div class="item-notes">
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>
          <th class="text-center">Code</th>
          <th class="text-center">Description</th>
          <th class="text-center">Quantity</th>
          <th class="text-center">Each Cost</th>
          <th class="text-center">Total Cost</th>
          <th class="text-center">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
          <td>
            <?php
            echo $this->Form->input("GraniteOrderItem.-1.granite_order_id", array("type" => "hidden", "class" => "granite_order_id user-input"));
            echo $this->Form->input("GraniteOrderItem.-1.item_id", array("type" => "hidden", "class" => "item_id user-input"));
            echo $this->Form->input("GraniteOrderItem.-1.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
            echo $this->Form->input("GraniteOrderItem.-1.door_id", array("type" => "hidden", "class" => "door_id user-input"));

            echo $this->Form->input("GraniteOrderItem.-1.code", array(
                "class" => "code user-input",
                "placeholder" => "Code",
                "label" => false,
                "type" => "hidden"
            ));

            $code = '';
            if (isset($this->data['GraniteOrderItem'][0]['code'])) {
              $code = $main_item_list[$this->data['GraniteOrderItem'][0]['code']];
            }
            echo "<span class='data-code'>{$code}</span>";
            ?>
          </td>
          <td>
            <span class='data-title'></span>
          </td>
          <td class="text-center">
            <?php
            echo $this->Form->input("GraniteOrderItem.-1.quantity", array(
                "class" => "quantity user-input",
                "placeholder" => "Quantity",
                "label" => false,
                "type" => "hidden"
            ));

            $quantity = '';
            if (isset($this->data['GraniteOrderItem'][0]['quantity'])) {
              $quantity = $this->data['GraniteOrderItem'][0]['quantity'];
            }
            echo "<span class='cab-order-data-quantity'>{$quantity}</span>";
            ?>
          </td>
          <td class="text-right">
            <?php
            echo "<span class='cab-order-data-each-cost'></span>";
            ?>
          </td>
          <td class="text-right">
            <?php
            echo "<span class='cab-order-data-per-item-total-cost'></span>";
            ?>
          </td>
          <td>
            <a href="#" class="icon-remove hide remove"></a>
          </td>
        </tr>
        <?php
        //debug($this->data['GraniteOrderItem']);
        $item_total_cost = 0.00;
        if (!empty($this->data['GraniteOrderItem'])) {

          foreach ($this->data['GraniteOrderItem'] as $index => $value) {
            if ($index == -1)
              continue; // skip the first 1 as it is already in place
            ?>
            <tr class="clone-row">
              <td>
                <?php
                echo $this->Form->input("GraniteOrderItem.{$index}.granite_order_id", array("type" => "hidden", "class" => "granite_order_id user-input"));
                echo $this->Form->input("GraniteOrderItem.{$index}.item_id", array("type" => "hidden", "class" => "item_id user-input"));
                echo $this->Form->input("GraniteOrderItem.{$index}.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
                echo $this->Form->input("GraniteOrderItem.{$index}.door_id", array("type" => "hidden", "class" => "door_id user-input"));

                echo $this->Form->input("GraniteOrderItem.{$index}.code", array(
                    "class" => "code user-input",
                    "placeholder" => "Code",
                    "label" => false,
                    "type" => "hidden"
                ));

                echo "<span class='data-code'>{$main_item_list[$this->data['GraniteOrderItem'][$index]['code']]}</span>";
                ?>
              </td>
              <td>
                <?php
                //echo $index;
                echo "<span class='data-title'>{$title_list[$this->data['GraniteOrderItem'][$index]['code']]}</span>";
                ?>
              </td>
              <td class="text-center">
                <?php
                echo $this->Form->input("GraniteOrderItem.{$index}.quantity", array(
                    "class" => "quantity user-input",
                    "placeholder" => "Quantity",
                    "label" => false,
                    "type" => "hidden"
                ));
                //pr($this->data['GraniteOrderItem'][$index]['quantity']);
                $quantity = $this->data['GraniteOrderItem'][$index]['quantity'];
                echo "<span class='cab-order-data-quantity'>{$this->data['GraniteOrderItem'][$index]['quantity']}</span>";
                ?>
              </td>
              <td class="text-right">
                <?php
                $each_cost = $price_list[$this->data['GraniteOrderItem'][$index]['code']];
                echo "<span class='cab-order-data-each-cost'>{$each_cost}</span>";
                ?>
              </td>
              <td class="text-right">
                <?php
                $per_item_total_cost = number_format($each_cost * $quantity, 2, '.', '');
//                $item_total_cost += $per_item_total_cost;
                echo "<span class='cab-order-data-per-item-total-cost'>{$per_item_total_cost}</span>";
                ?>
              </td>
              <td>
                <a href="#" class="icon-remove remove"></a>
              </td>
            </tr>
            <?php
          }
          ?>
  <!--          <tr>
          <td colspan="4" class="text-right" style="font-weight: bold;">Total:</td>
          <td class="text-right">
            <span class='co-data-item-total-cost'><?php echo $item_total_cost; ?></span>
          </td>
          <td>&nbsp;</td>
        </tr>-->
          <?php
        }
//        else {
        ?>
        <tr>
          <td colspan="4" class="text-right" style="font-weight: bold;">Total:</td>
          <td class="text-right">
            <span class='co-data-item-total-cost' ><?php echo number_format($total_cost['item_cost'], '2', '.', ''); ?></span>
          </td>
          <td>&nbsp;</td>
        </tr>
        <?php // } ?>
        <tr>
          <td colspan="6">
            <input type="button" class="btn btn-info add-more" value="Add Item" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
  </div>
  <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', array('controller' => 'quotes', 'action' => DETAIL, $quote_id), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel')); ?>
  </div>
  <?php echo $this->Form->end(); ?>

  <!-- Modal -->
  <div id="add_granite_order_item" class="modal hide fade modal-width" data-keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="add_item_label">Add Item</h3>
    </div>
    <div class="modal-body">
      <form class="add-granite-order-item-form">
        <table class="table-form-big">
          <tr>
            <th>
              <label class="">Item Number:</label> &nbsp;
            </th>
            <td>
              <!--<div class="ui-widget combobox">            -->
              <?php echo $this->Form->input("code", array("type" => "select", 'placeholder' => 'Item Number', 'empty' => true, 'options' => $main_item_list, "class" => "required code user-input form-select")); ?>
              <!--</div>-->
            </td>
            <th>
              <label class="">Quantity:</label> &nbsp;
            </th>
            <td>
              <input placeholder="Quantity" class="required quantity number" type='text' />
            </td>
          </tr>
          <tr>
            <th>
              <label class="">Item Description:</label> &nbsp;
            </th>
            <td>
              <input id="item_description" name="item_description" placeholder="Item Description" readonly="readonly" class="item-description" type='text' />
              <?php echo $this->Form->input("description", array("type" => "select", 'options' => $title_list, "class" => "description user-input", 'style' => 'display:none')); ?>
            </td>
            <th>
              <label class="">Price:</label> &nbsp;
            </th>
            <td>
              <input id="item_price" name="item_price" placeholder="Item Price" readonly="readonly" class="item-price" type='text' />
              <?php echo $this->Form->input("price", array("type" => "select", 'options' => $price_list, "class" => "price user-input", 'style' => 'display:none')); ?>
            </td>
          </tr>
        </table>
      </form>
    </div>
    <div class="modal-footer">
      <button class="save btn btn-primary">Add</button>
    </div>
  </div>
</div>
<script>
  $(".granite-order-form").validate({ignore: null});

  $(".granite-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
  //$("#add_granite_order_item .code").combobox();
</script>