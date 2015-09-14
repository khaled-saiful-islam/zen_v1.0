<?php
$all_items = $this->InventoryLookup->ListAllTypesOfItems();
$main_item_list = $all_items['main_list'];
$price_list = $all_items['price_list'];
$title_list = $all_items['title_list'];
//debug($main_item_list);
?>
<div id="service-entry-basic-information" class="sub-content-detail">
  <fieldset>
    <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>><?php echo $legend; ?></legend>
    <table class="table-form-big">  
      <tr>
        <th>
          <label>Job Number:</label>
        </th>
        <td colspan="3">
          <?php echo $this->Form->input('work_order_id', array('placeholder' => 'Job Number', 'options' => $workOrders, 'empty' => true, 'class' => 'required form-select work-order-id')); ?>
          <?php echo $this->Form->input('created_by', array('type' => 'hidden', 'value' => $user_id)); ?>
          <?php echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'Service')); ?>
        </td>
      </tr>
<!--      <tr>
        <th>
          <label>Created Date:</label>
          <label class="wide-width-date">(dd/mm/yyyy)</label>
        </th>
        <td>
          <?php echo $this->Form->input('created', array('type' => 'text', 'placeholder' => 'Created Date', 'readonly' => 'readonly', 'value' => date('d/m/Y'))); ?>
        </td>
      </tr>-->
			<tr>
          <th>
          <label>Booked for:</label>
          <label class="wide-width-date">(dd/mm/yyyy)</label>
            
        </th>
        <td>
          <?php
          if (!empty($this->data['ServiceEntry']['booked_for']))
            echo $this->Form->input('booked_for', array('type' => 'text', 'placeholder' => 'DD/MM/YYYY', 'class' => 'not_previous', 'value' => $this->Util->formatDate($this->data['ServiceEntry']['booked_for'])));
          else
            echo $this->Form->input('booked_for', array('type' => 'text', 'placeholder' => 'DD/MM/YYYY', 'class' => 'not_previous'));
          ?>
        </td>
          <td style="width: 8px;">
            at
          </td>
          <td>
            <?php echo $this->Form->input('booking_on_time', array('label' => false, 'div' => false, 'type' => 'text', 'placeholder' => 'Start Time', 'class' => 'booking-on-time')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label>How Long:(00:00)</label>
          </th>
          <td>
            <?php echo $this->Form->input('hours', array('label' => false, 'div' => false, 'placeholder' => 'Hours', 'class' => 'hours')); ?>
          </td>
          <td colspan="2">
            hrs
          </td>
       </tr>
      <tr>
        <th>
          <label>Description:</label>
        </th>
        <td colspan="3">
          <?php echo $this->Form->input('description', array('placeholder' => 'Type Description', 'cols' => 60, 'rows' => 4, 'class' => '')); ?>
        </td>
      </tr>
    </table>
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>          
          <th>Number</th>
          <th>Description</th>
          <th>Quantity</th>
          <th>Each Cost</th>
          <th>Total Cost</th>
          <th>Reason</th>
          <th>Purchase Order</th>          
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
          <td>
            <?php
            echo $this->Form->input("ScheduleItem.-1.schedule_id", array("type" => "hidden", "class" => "schedule_id user-input"));
            echo $this->Form->input("ScheduleItem.-1.item_id", array("type" => "hidden", "class" => "item_id user-input"));
            echo $this->Form->input("ScheduleItem.-1.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
            echo $this->Form->input("ScheduleItem.-1.door_id", array("type" => "hidden", "class" => "door_id user-input"));
            //echo $this->Form->input("ScheduleItem.-1.type", array('type' => 'hidden', "class" => "type", 'value' => 'Service'));

            echo $this->Form->input("ScheduleItem.-1.code", array(
                "class" => "code user-input form-select",
                "label" => false,
                "type" => "hidden"
            ));
            $code = '';
            if (isset($this->data['ScheduleItem'][0]['code'])) {
              $code = $main_item_list[$this->data['ScheduleItem'][0]['code']];
            }
            echo "<span class='data-code'>{$code}</span>";
            ?>
          </td>
          <td>            
            <span class='data-title'>&nbsp;</span>
          </td>
          <td>
            <?php
            echo $this->Form->input("ScheduleItem.-1.quantity", array(
                "class" => "quantity user-input small-input set-item-cost",
                "label" => false,
                "type" => "hidden",
                'value' => 0
            ));

            $quantity = '';
            if (isset($this->data['ScheduleItem'][0]['quantity'])) {
              $quantity = $this->data['ScheduleItem'][0]['quantity'];
            }
            echo "<span class='data-quantity'>{$quantity}</span>";
            ?>
          </td>          
          <td>
            <span class='data-each-cost'>0.00</span>
          </td>
          <td> 
            <span class='data-per-item-total-cost'>0.00</span>
          </td>
          <td>          
            <?php
            echo $this->Form->input("ScheduleItem.-1.reason", array(
                "class" => "reason user-input",
                "label" => false,
                "type" => "hidden"
            ));

            $reason = '';
            if (isset($this->data['ScheduleItem'][0]['reason'])) {
              $reason = $this->data['ScheduleItem'][0]['reason'];
            }
            echo "<span class='data-reason'>{$reason}</span>";
            ?>   

          </td>
          <td> 
            <?php
            echo $this->Form->input("ScheduleItem.-1.purchase_order_id", array(
                "class" => "purchase_order_id user-input",
                "label" => false,
                "type" => "hidden"
            ));
            $purchase_order_id = '';
            if (isset($this->data['ScheduleItem'][0]['purchase_order_id'])) {
              $purchase_order_id = $this->data['ScheduleItem'][0]['purchase_order_id'];
            }
            echo "<span class='data-purchase-order-number'>{$purchase_order_id}</span>";
            ?>
          </td>
          <td>
            <a href="#" class="icon-remove icon-remove-margin remove"></a>
          </td>
        </tr>
        <?php
        //debug($this->data);
        $total_cost = 0.00;
        if (!empty($this->data['ScheduleItem'])) {
          foreach ($this->data['ScheduleItem'] as $index => $value) {
            if ($value['type'] == 'Service') {
              if ($index == -1)
                continue;
              ?>
              <tr class="clone-row">
                <td>
                  <?php
                  echo $this->Form->input("ScheduleItem.{$index}.schedule_id", array("type" => "hidden", "class" => "schedule_id user-input"));
                  echo $this->Form->input("ScheduleItem.{$index}.item_id", array("type" => "hidden", "class" => "item_id user-input"));
                  echo $this->Form->input("ScheduleItem.{$index}.cabinet_id", array("type" => "hidden", "class" => "cabinet_id user-input"));
                  echo $this->Form->input("ScheduleItem.{$index}.door_id", array("type" => "hidden", "class" => "door_id user-input"));
                  //echo $this->Form->input("ScheduleItem.{$index}.type", array('type' => 'hidden', 'value' => 'Service'));

                  echo $this->Form->input("ScheduleItem.{$index}.code", array(
                      "class" => "code user-input form-select",
                      "label" => false,
                      "type" => "hidden"
                  ));
                  $code = '';
                  if (isset($this->data['ScheduleItem'][$index]['code'])) {
                    $code = $main_item_list[$this->data['ScheduleItem'][$index]['code']];
                  }
                  echo "<span class='data-code'>{$code}</span>";
                  ?>
                </td>
                <td>            
                  <span class='data-title'>
                    <?php
                    $title = '';
                    if (isset($this->data['ScheduleItem'][$index]['code'])) {
                      $title = $title_list[$this->data['ScheduleItem'][$index]['code']];
                    }
                    echo $title;
                    ?>
                  </span>
                </td>
                <td>
                  <?php
                  echo $this->Form->input("ScheduleItem.{$index}.quantity", array(
                      "class" => "quantity user-input small-input set-item-cost",
                      "label" => false,
                      "type" => "hidden"
                  ));

                  $quantity = '';
                  if (isset($this->data['ScheduleItem'][$index]['quantity'])) {
                    $quantity = $this->data['ScheduleItem'][$index]['quantity'];
                  }
                  echo "<span class='data-quantity'>{$quantity}</span>";
                  ?>
                </td>          
                <td>
                  <span class='data-each-cost'>
                    <?php
                    $cost = 0.00;
                    if (isset($this->data['ScheduleItem'][$index]['code'])) {
                      $cost = $price_list[$this->data['ScheduleItem'][$index]['code']];
                    }
                    echo number_format($cost, 2, '.', '');
                    $total_cost+= $cost * $quantity;
                    ?>
                  </span>
                </td>
                <td> 
                  <span class='data-per-item-total-cost'>
                    <?php echo number_format($cost * $quantity, 2, '.', ''); ?>
                  </span>
                </td>
                <td>          
                  <?php
                  echo $this->Form->input("ScheduleItem.{$index}.reason", array(
                      "class" => "reason user-input",
                      "label" => false,
                      "type" => "hidden"
                  ));

                  $reason = '';
                  if (isset($this->data['ScheduleItem'][$index]['reason']) && !empty($this->data['ScheduleItem'][$index]['reason'])) {
                    $reason = $this->data['ScheduleItem'][0]['reason'];
                    $di = $this->InventoryLookup->InventorySpecificLookup('service_techs', $this->data['ScheduleItem'][$index]['reason']);
                    $reason = $di[$this->data['ScheduleItem'][$index]['reason']];
                  }
                  echo "<span class='data-reason'>{$reason}</span>";
                  ?>          
                </td>
                <td> 
                  <?php
                  echo $this->Form->input("ScheduleItem.{$index}.purchase_order_id", array(
                      "class" => "purchase_order_id user-input",
                      "label" => false,
                      "type" => "hidden"
                  ));
                  $purchase_order_id = '';
                  if (isset($this->data['ScheduleItem'][$index]['purchase_order_id'])) {
                    $purchase_order_id = $this->data['PurchaseOrder'][$index]['purchase_order_num'];
                  }
                  echo "<span class='data-purchase-order-number'>{$purchase_order_id}</span>";
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
          <td>
            <span class='data-item-total-cost'><?php echo number_format($total_cost, 2, '.', ''); ?></span>
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
  </fieldset>  
</div>
<script type="text/javascript" >
	$(".booking-on").datepicker({
    dateFormat:"DD, MM d,yy"
  });
  $(".booking-on-time").timepicker({
    timeFormat: "hh:mm tt"
  });
	$(".hours").timepicker({
  });
	$(".not_previous").datepicker({ minDate: 0, dateFormat:"dd/mm/yy" });
//	$('.not_previous').datetimepicker({
//		timeFormat: "hh:mm tt"
//	});
  
  $('.work-order-id').live('change',function() {
    var wo_id = $(this).val();
	
    $.ajax({
      url: '<?php
        echo $this->Util->getURL(array(
            'controller' => "service_entries",
            'action' => 'getPoItem',
            'plugin' => 'schedule_manager',
        ))
        ?>/'+wo_id,
              type: 'POST',
              data: '',
              dataType: "json",
              success: function( response ) {
                //console.log(response);
                $('#add_item_service select.description').find('option').remove();
                $('#add_item_service select.service-code').find('option').remove();
                $('#add_item_service select.price').find('option').remove();
                $('#add_item_service select.po_number').find('option').remove();
                $('#add_item_service select.po_id').find('option').remove();

                $.each(response,function(key,value){
                  //$('#add_item_service form select.description')
                  //console.log(value);
                  //console.log(key);
                  var index=key;
                  var title_option="";
                  var price_option="";
                  var po_option="";
                  var code_option="";
                  var po_id_option="";
                  $.each(value,function(next_key,next_value){
                    //console.log(index);
                    if(index=="title_list")
                      title_option +="<option value="+next_key+">"+next_value+"</option>";
                    else if(index=="price_list")
                      price_option +="<option value="+next_key+">"+next_value+"</option>";
                    else if(index=="po_list")
                      po_option +="<option value="+next_key+">"+next_value+"</option>";
                    else if(index=="main_list")
                      code_option +="<option value="+next_key+">"+next_value+"</option>";
                    else if(index=="po_id_list")
                      po_id_option +="<option value="+next_key+">"+next_value+"</option>";
                  });
                  //console.log(option);
                  $('#add_item_service select.description').append(title_option);
                  $('#add_item_service select.service-code').append(code_option);
                  $('#add_item_service select.price').append(price_option);
                  $('#add_item_service select.po_number').append(po_option);
                  $('#add_item_service select.po_id').append(po_id_option);
                });
                  
              }
            });	
          });
              
</script>
