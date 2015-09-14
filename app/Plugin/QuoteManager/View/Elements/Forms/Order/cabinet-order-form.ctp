<div class="cabinetOrders form">
    <?php
    $all_items = $this->InventoryLookup->ListAllTypesOfItems();
    $main_item_list = $all_items['main_list'];
    $price_list = $all_items['price_list'];
    $title_list = $all_items['title_list'];

    $total_cost = 0;

    echo $this->Form->input('current_quote_id', array( 'type' => 'hidden', 'class' => 'hide', 'value' => $quote['Quote']['id'] ));
    ?>

    <?php
    $quote_status = $this->InventoryLookup->QuoteStatus($quote['Quote']['id']);
    echo $this->Form->create('CabinetOrderBasic', array( 'inputDefaults' => array( 'label' => false ) ));
    ?>
    <?php if( $quote_status != 'Review' && $quote['Quote']['delete'] != 1 ) { ?>
        <table class="main-table">
            <tr>
                <td valign="top">
                    <fieldset style="width: 1028px;">
                        <div class="input text resource"><?php echo "<div class='bold font-small'>Item</div>" . $this->Form->input('resource_id', array( 'placeholder' => 'Item', 'type' => 'hidden', 'class' => 'required form-select-ajax-all-type-item select-quote-price', 'empty' => true )); ?></div>
                        <div class="input text door-style"><?php echo "<div class='bold font-small'>Door Style</div>" . $this->Form->input('door_style', array( 'placeholder' => 'No Door', 'class' => 'form-select semi-input-select', 'options' => $this->InventoryLookup->DoorDataList('door_style', true), 'empty' => true )); ?></div>
                        <div class="input text door-color"><?php echo "<div class='bold font-small'>Door Color</div>" . $this->Form->input('door_color', array( 'placeholder' => 'Door Color', 'class' => 'form-select', 'options' => $this->InventoryLookup->Color(), 'empty' => true )); ?></div>
                        <div class="input text material"><?php echo "<div class='bold font-small'>Material</div>" . $this->Form->input('material_id', array( 'placeholder' => 'Material', 'class' => 'form-select', 'options' => $this->InventoryLookup->getMaterial(), 'empty' => true )); ?></div>
                        <div class="input text cabinet-color"><?php echo "<div class='bold font-small'>Cabinet Color</div>" . $this->Form->input('cabinet_color', array( 'placeholder' => 'Cabinet Color', 'class' => 'form-select', 'options' => $this->InventoryLookup->Color(), 'empty' => true )); ?></div>
                        <div style="margin-left: 0px;" class="input text door-side"><?php echo "<div class='bold font-small'>Door Option</div>" . $this->Form->input('door_side', array( 'placeholder' => 'Door Option', 'class' => 'form-select', 'options' => $this->InventoryLookup->getDoorSide(), 'empty' => true )); ?></div>
                        <div style="margin-left: 0px;" class="input text"><?php echo "<div class='bold font-small'>Door Drill</div>" . $this->Form->input('door_drilling', array( 'placeholder' => 'Door Drill', 'class' => 'form-select', 'options' => $this->InventoryLookup->getDoorDrillingForQuote(), 'empty' => true )); ?></div>
                        <div class="input text text-right"><?php echo "<div class='bold font-small'>Quantity</div>" . $this->Form->input('resource_quantity', array( 'placeholder' => 'Quantity', 'class' => 'number super-small-input', 'value' => '1' )); ?></div>
                        <?php echo $this->Form->hidden('customer_id', array( 'value' => $quote['Quote']['customer_id'] )); ?>
                        <span class="hide" id="quote_color_required">0</span>
                        <span class="hide" id="quote_material_required">0</span>
                    </fieldset>
                </td>
                <td valign="top">
                    <div id="debug-data"></div>
                </td>
            </tr>
        </table>
        <input type="button" id="add-cabinet" class="btn btn-info add-more" value="Add Item" />
        <a href="#add-custom-panel-modal" role="button" class="add-custom-panel-modal-opener btn btn-inverse" data-toggle="modal">Add Custom Panel</a>
        <a href="#add-custom-door-modal" role="button" class="add-custom-door-modal-opener btn btn-inverse" data-toggle="modal">Add Custom Door</a>
    <?php } ?>
    <?php echo $this->Form->end(); ?>

    <?php echo $this->Form->create('CabinetOrder', array( 'inputDefaults' => array( ), 'class' => 'cabinet-order-form ajax-form-submit', 'url' => '/quote_manager/cabinet_orders/save_quote_cabinets/' . $quote['Quote']['id'] )); ?>
    <div class="align-left align-top-margin">
        <?php if( $quote_status != 'Review' && $quote['Quote']['delete'] != 1 ) { ?>
            <div>
                <div style="float:left; width:70px;"><?php echo $this->Form->input('Save', array( 'type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save', 'name' => 'save' )); ?></div>
                <div style="float:left;"><?php echo $this->Form->input('Reset', array( 'type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Reset', 'name' => 'reset' )); ?></div>
                <?php echo $this->Html->link('Submit for Review', array( 'action' => 'quote_review', $quote['Quote']['id'] ), array( 'class' => 'btn btn-success right review_quote_ajax' )); ?>
            </div>
        <?php } ?>
        <?php
        if( $quote_status == 'Review' || $quote['Quote']['delete'] == 1 ) {
            if( $quote['Quote']['delete'] != 1 ) {
                echo $this->Html->link('Approved', array( 'action' => 'quote_approved', $quote['Quote']['id'] ), array( 'class' => 'btn btn-success right' ));
                echo $this->Html->link('Unlock', array( 'action' => 'quote_unlock', $quote['Quote']['id'] ), array( 'style' => 'margin-right: 10px;', 'class' => 'btn btn-success right' ));
            }
            ?>
            <table class="cabinet-list global-options main-table">
                <tr class="text-left"><th style="width: 110px;">Drawer: </th><td><?php echo $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer']); ?></td></tr>
                <tr class="text-left"><th style="width: 110px;">Drawer Slider: </th><td><?php echo $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer_slide']); ?></td></tr>
                <tr class="text-left"><th style="width: 110px;">Delivery: </th><td style="width: 160px;"><?php echo $quote['Quote']['delivery']; ?></td><td><?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?></td></tr>
                <tr class="text-left"><th style="width: 110px;">Installation: </th><td><?php echo $quote['Quote']['installation']; ?></td></tr>
            </table>
            <?php
        }
        ?>
        <?php
        $edit_class = '';
        if( $quote_status == 'Review' || $quote['Quote']['delete'] == 1 ) {
            $edit_class = 'cabinet-list-after-review';
        }
        ?>
        <div class="cabinet-list" id="<?php echo $edit_class; ?>">
            <?php if( $quote_status != 'Review' && $quote['Quote']['delete'] != 1 ) { ?>
                <table class="cabinet-list global-options main-table">
                    <tr valign="top">
                        <td class="text-left"><?php echo $this->Form->input('Global.drawer', array( 'label' => 'Drawer', 'placeholder' => 'Drawer', 'class' => 'form-select medium-input-select required', 'options' => $this->InventoryLookup->InventoryLookup('drawer'), 'empty' => true, 'value' => $quote['Quote']['drawer'] )); ?></td>
                        <td class="text-left"><?php echo $this->Form->input('Global.drawer_slide', array( 'label' => 'Drawer Slide', 'placeholder' => 'Drawer Slide', 'class' => 'form-select medium-input-select required', 'options' => $this->InventoryLookup->InventoryLookup('drawer_slide'), 'empty' => true, 'value' => $quote['Quote']['drawer_slide'] )); ?></td>
                        <td class="text-left"><?php echo $this->Form->input('Global.delivery', array( 'label' => 'Production Time', 'placeholder' => 'Production Time', 'class' => 'form-select medium-input-select required', 'options' => $this->InventoryLookup->ProductionTime(), 'empty' => true, 'value' => $quote['Quote']['delivery'] )); ?></td>
                        <td class="text-left"><?php echo $this->Form->input('Global.installation', array( 'label' => 'Installation', 'placeholder' => 'Installation', 'class' => 'form-select medium-input-select required', 'options' => array( 'Not Installed' => 'Not Installed', 'We Installed' => 'We Installed' ), 'empty' => true, 'value' => $quote['Quote']['installation'] )); ?></td>
                        <td style="display: block; position: relative; top: 20px; left: 10px;" class="text-left"><?php echo $this->Form->input('Global.is_interior_melamine', array( 'type' => 'checkbox', 'label' => 'White Melamine', 'div' => true, 'checked' => isset($quote['Quote']['is_interior_melamine']) ? "checked" : '' )); ?></td>
                    </tr>
                </table>
            <?php } ?>
            <table id="cabinet-list" class="cabinet-list main-table" border="1">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Door</th>
                        <th>Door Color</th>
                        <th>Material</th>
                        <th>Cabinet Color</th>
                        <th>Door Option</th>
                        <th>Door Drill</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th style="width:50px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
                        foreach( $quote['CabinetOrder'] as $cabinet_order ) {
                            $temporary_class = $cabinet_order['temporary'] ? ' temporary ' : ($cabinet_order['temporary_delete'] ? ' temporary-delete ' : '');
                            ?>
                            <?php $modal_id = $cabinet_order['id']; ?>
                            <tr valign="top" class="<?php echo $temporary_class; ?>">
                                <td class="text-left">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['id'], 'class' => 'cabinet_order_id' ));
                                    echo $this->Form->input($modal_id . '.temporary_delete', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['temporary_delete'] ));
                                    echo $this->Form->input($modal_id . '.temporary', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['temporary'] ));
                                    echo $this->Form->input($modal_id . '.resource_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['resource_id'] ));
                                    echo $this->Form->input($modal_id . '.resource_type', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['resource_type'] ));
                                    switch( $cabinet_order['resource_type'] ) {
                                        case 'cabinet':
                                            echo $this->InventoryLookup->CabinetName2ID($cabinet_order['resource_id'], true);
                                            break;
                                        case 'item':
                                            echo $this->InventoryLookup->ItemTitle2ID($cabinet_order['resource_id'], true);
                                            break;
                                        case 'custom_door':
                                            echo 'CD';
                                            break;
                                        case 'custom_panel':
                                            echo 'CP';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="text-left description">
                                    &nbsp;
                                    <?php
                                    if( isset($cabinet_order['description']) && !empty($cabinet_order['description']) ) {
                                        echo $this->Form->input($modal_id . '.description', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['description'] ));
                                        echo h($cabinet_order['description']);
                                    }
                                    if( isset($cabinet_order['edgetape']) && !empty($cabinet_order['edgetape']) ) {
                                        echo $this->Form->input($modal_id . '.edgetape', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['edgetape'] ));
                                    }
//									if( isset($cabinet_order['door_side']) && !empty($cabinet_order['door_side']) ) {
//										echo $this->Form->input($modal_id . '.door_side', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_side'] ));
//									}
                                    ?>
                                </td>
                                <td class="text-left">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.door_side', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_side'] ));
                                    echo $this->Form->input($modal_id . '.door_drilling', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_drilling'] ));
                                    echo $this->Form->input($modal_id . '.door_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_id'] ));
                                    echo $this->InventoryLookup->DoorStyle2ID($cabinet_order['door_id'], true);
                                    ?>
                                </td>
                                <td class="text-left">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.door_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['door_color'] ));
                                    echo $this->InventoryLookup->ColorCode2ID($cabinet_order['door_color'], true);
                                    ?>
                                </td>
                                <td class="text-left">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.material_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['material_id'] ));
                                    echo $this->InventoryLookup->MaterialCode2ID($cabinet_order['material_id'], true);
                                    ?>
                                </td>
                                <td class="text-left">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.cabinet_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['cabinet_color'] ));
                                    echo $this->InventoryLookup->ColorCode2ID($cabinet_order['cabinet_color'], true);
                                    ?>
                                </td>
                                <td class="text-right quantity"><?php echo $cabinet_order['door_side']; ?></td>
                                <td class="text-right quantity"><?php echo $cabinet_order['door_drilling']; ?></td>
                                <td class="text-right quantity">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.quantity', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['quantity'] ));
                                    echo $cabinet_order['quantity'];
                                    ?>
                                </td>
                                <td class="text-right price">
                                    &nbsp;
                                    <?php
                                    echo $this->Form->input($modal_id . '.total_cost', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['total_cost'] ));
                                    echo $this->Util->formatCurrency($cabinet_order['total_cost']);
                                    ?>
                                </td>
                                <td class="text-left" style="width:50px;">
                                    &nbsp;
                                    <?php
                                    if( $edit ) {
                                        ?>
                                        <?php if( $quote_status != 'Review' ) { ?>
                                            <a href="#" class="icon-remove icon-remove-margin remove-cabinet-order-item show-tooltip" title="Remove">&nbsp;</a>
                                            <?php
                                        }
                                        if( $cabinet_order['cost_calculation'] ) {
                                            echo $this->Form->input($modal_id . '.cost_calculation', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order['cost_calculation'] ));
                                            ?>
                                            <a href="#<?php echo $modal_id; ?>" class="icon-info-sign show-tooltip" title="Calculation Detail" data-toggle="modal">&nbsp;</a>
                                            <div id="<?php echo $modal_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h3>Price Calculation Detail</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo $cabinet_order['cost_calculation']; ?></p>
                                                    <p>&nbsp;</p>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <?php
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="align-left align-top-margin">
        <?php // echo $this->Html->link('Cancel', array('controller' => 'quotes', 'action' => DETAIL, $quote['Quote']['id']), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel'));      ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->Form->end(); ?>

    <div id="add-custom-panel-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Add Custom Panel</h3>
        </div>
        <div class="modal-body">
            <p>
                <?php echo $this->element('Forms/Order/cabinet-order-custom-panel-form'); ?>
            </p>
            <p>&nbsp;</p>
        </div>
    </div>

    <div id="add-custom-door-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Add Custom Door</h3>
        </div>
        <div class="modal-body">
            <p>
                <?php echo $this->element('Forms/Order/cabinet-order-custom-door-form'); ?>
            </p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<script>
    $(".cabinet-order-form").validate({ignore: null});
    //  $(".cabinet-order-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
    //$("#add_order_item .code").combobox();
    $(document).ready(function() {
        $(".add-custom-door-modal-opener").click(function() {
            $('#CabinetOrderCustomDoorDoor').val($('#CabinetOrderBasicDoorStyle').val());
            $('#CabinetOrderCustomDoorDoor').select2().select2('val',$('#CabinetOrderBasicDoorStyle').val());
            $('#CabinetOrderCustomDoorColor').val($('#CabinetOrderBasicDoorColor').val());
            $('#CabinetOrderCustomDoorColor').select2().select2('val',$('#CabinetOrderBasicDoorColor').val());

        });
        $(".add-custom-panel-modal-opener").click(function() {
            $('#CabinetOrderCustomPanelColorId').val($('#CabinetOrderBasicCabinetColor').val());
            $('#CabinetOrderCustomPanelColorId').select2().select2('val',$('#CabinetOrderBasicCabinetColor').val());
            $('#CabinetOrderCustomPanelMaterialId').val($('#CabinetOrderBasicMaterialId').val());
            $('#CabinetOrderCustomPanelMaterialId').select2().select2('val',$('#CabinetOrderBasicMaterialId').val());
        });

        $("#CabinetOrderDetailForm").submit(function() {
            if($("#CabinetOrderDetailForm .error").length == 0) {
                //        ajaxStart();
                ajaxStartOrder();
            }
        });

        $("#add-cabinet").click(function() {
            calculateQuotePrice(true);
        });

        $("#add-custom-panel").click(function() {
            if(calculateCustomPanel(true)) {
                $('#add-custom-panel-modal').modal('hide');
                clearCustomPanelInputs();
            }
        });

        $("#add-custom-door").click(function() {
            if(calculateCustomDoor(true)) {
                $('#add-custom-door-modal').modal('hide');
                clearCustomDoorInputs();
            }
        });

        $(".remove-cabinet-order-item").live('click', function(e) {
            e.preventDefault();
            ajaxStart();

            var parent = $(this).parents('#cabinet-list tbody tr');
            $.ajax({
                url: BASEURL + "quote_manager/quotes/delete_temporary/" + parent.find('td .cabinet_order_id').val(),
                dataType: 'json',
                type: 'get',
                async: false,
                data: null,
                success: function(data) {
                    if(data.success) {
                        parent.addClass('temporary-delete');
                        $('#CabinetOrder' + data.id + 'TemporaryDelete').val(1);
                        if(data.deleted) {
                            parent.remove();
                        }
                    }
                    ajaxStop();
                },
                error: function(data) {
                    showAjaxError(contentDivId, data);
                    ajaxStop();
                }
            });
        });
		
        $('#CabinetOrderBasicResourceId').change(function(){
            var id = $(this).val();
            if (id !== "") {
                var resource_parts = id.split('|');
                var resource_url = 'inventory/cabinets/cabinet_json';
                if(resource_parts[1] == 'item') {
                    resource_url = 'inventory/items/item_json';
                }
                $.ajax(BASEURL + resource_url, {
                    data: {
                        term: resource_parts[0]
                    },
                    dataType: "json"
                }).done(function(data) {
                    intelligentSelectionQuoteOptions(data);
                });
            }
        });
		
        $(".review_quote_ajax").live('click', function(e) {
            e.preventDefault();
            ajaxStartSubmit();

            var id = '<?php echo $quote['Quote']['id']; ?>';
            $.ajax({
                url: BASEURL + "quote_manager/quotes/quote_review/" + id,
                dataType: 'json',
                type: 'POST',
                data: null,
                success: function(success) {
                    if(success.error == 1){
                        alert("Pleaes pay atlest one payment.");
                    }
                    else{
                        location.reload(true);
                    }
                    ajaxStopSubmit();
                }
            });
        });

    });
</script>