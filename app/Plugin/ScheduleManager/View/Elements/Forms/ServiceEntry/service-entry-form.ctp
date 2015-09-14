<?php
//debug($this->data);
$number_list = array();
$title_list = array();
$price_list = array();
$po_list = array();
$po_id_list = array();

if($this->data){
$all_list = $this->InventoryLookup->listOfPoItem($this->data['ServiceEntry']['work_order_id']);
$number_list = $all_list['main_list'];
$title_list = $all_list['title_list'];
$price_list = $all_list['price_list'];
$po_list = $all_list['po_list'];
$po_id_list = $all_list['po_id_list'];
}
//debug($number_list);

echo $this->Form->create('ServiceEntry', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'ajax-form-submit service-entry-form'));
$sub_form = $this->InventoryLookup->service_entry_form_elements($section);
echo $this->element('Forms/ServiceEntry/' . $sub_form['from'], array('edit' => $edit, 'legend' => $legend));
?>

<div class="align-left align-top-margin">
  <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
</div>
<div class="align-left align-top-margin">
  <?php if (!$edit) { ?>
    <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
  <?php } else { ?>
    <?php echo $this->Html->link('Cancel', array('action' => 'detail_section', $id, $section), array('data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Cancel'))); ?>
  <?php } ?>
</div>
<div class="clear"></div>

<?php echo $this->Form->end(); ?>
</div>

<div id="add_item_service" class="modal hide fade modal-width" data-keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="add_item_label">Add Item</h3>
  </div>
  <div class="modal-body">
    <form>
      <table class="table-form-big">
        <tr>
          <th>
            <label class="label-text">Item Number:</label> &nbsp;
          </th>
          <td>          
            <?php echo $this->Form->input("code", array("type" => "select",'options'=>$number_list ,'placeholder' => 'Item Number', 'empty' => true, "class" => "form-select required service-code user-input")); ?>
          </td>
          <th>
            <label class="label-text">Quantity:</label> &nbsp;
          </th>
          <td>
            <input placeholder="Quantity" class="item-quantity required number" type='text' />
          </td>            
        </tr>
        <tr>
          <th>
            <label class="label-text">Item Description:</label> &nbsp;
          </th>
          <td>  
            <input id="item_description" name="item_description" placeholder="Item Description" readonly="readonly" class="item-description" type='text' />
            <?php echo $this->Form->input("description", array("type" => "select", 'options'=>$title_list ,"class" => "description user-input", 'style' => 'display:none')); ?>
          </td>
          <th>
            <label class="label-text">Price:</label> &nbsp;
          </th>
          <td>   
            <input id="item_price" name="item_price" placeholder="Item Price" readonly="readonly" class="item-price" type='text' />
            <?php echo $this->Form->input("price", array("type" => "select",'options'=>$price_list ,"class" => "price user-input", 'style' => 'display:none')); ?>
          </td>            
        </tr>
        <tr>
          <th>
            <label class="label-text">Purchase Order:</label>&nbsp;
          </th>
          <td>   
            <input id="item_po_number" name="item_po_number" placeholder="Purchase Order" readonly="readonly" class="item-po-number" type='text' />
            <input id="item_po_id" name="item_po_id" class="item-po-id" type='hidden' />
            <?php echo $this->Form->input("po_number", array("type" => "select",'options'=>$po_list,"class" => "po_number user-input", 'style' => 'display:none')); ?>
            <?php echo $this->Form->input("po_id", array("type" => "select",'options'=>$po_id_list,"class" => "po_id user-input", 'style' => 'display:none')); ?>
          </td>
          <th>
            <label class="label-text">Reason:</label>&nbsp;
          </th>
          <td>
            <?php echo $this->Form->input("reason", array('placeholder' => 'Reason', 'options' => $this->InventoryLookup->InventoryLookup('service_techs'), "empty" => true, "class" => "reason user-input required form-select")); ?>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <div class="modal-footer">
    <button class="save btn btn-primary">Add</button>
  </div>
</div>


<script>
  $(".service-entry-form").validate({ignore: null});
<?php if ($edit && !empty($section)) { ?>
    $(".service-entry-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#<?php echo $sub_form['detail']; ?>'});
<?php } else { ?>
    $(".service-entry-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
  <?php
}
?>
</script>
