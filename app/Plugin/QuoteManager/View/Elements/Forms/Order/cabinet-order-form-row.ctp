<?php
if( isset($cabinet_order_id) && !is_null($cabinet_order_id) ) {
    $modal_id = $calculatePrice['conditions']['resource_id'] . '-' . $calculatePrice['conditions']['resource_type'] . '-' . time();
    ?>
    <tr valign="top" class="temporary">
        <td class="text-left">
            &nbsp;
            <?php
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $cabinet_order_id, 'class' => 'cabinet_order_id' ));
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.temporary_delete', array( 'type' => 'hidden', 'readonly' => true, 'value' => '0' ));
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.temporary', array( 'type' => 'hidden', 'readonly' => true, 'value' => '1' ));
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.resource_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['resource_id'] ));
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.resource_type', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['resource_type'] ));

            switch( $calculatePrice['conditions']['resource_type'] ) {
                case 'cabinet':
                    echo $this->InventoryLookup->CabinetName2ID($calculatePrice['conditions']['resource_id'], true);
                    break;
                case 'item':
                    echo $this->InventoryLookup->ItemTitle2ID($calculatePrice['conditions']['resource_id'], true);
                    break;
            }
            ?>
        </td>
        <td class="text-left description">
            &nbsp;
            <?php
//    echo $this->Form->input('CabinetOrder.' . $modal_id . '.cabinet_id', array('type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['cabinet_id']));
//    echo $this->InventoryLookup->CabinetName2ID($calculatePrice['conditions']['cabinet_id'], true);
            ?>
        </td>
        <td class="text-left">
            &nbsp;
            <?php
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.door_side', array( 'type' => 'hidden', 'readonly' => true, 'value' => $door_side ));
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.door_drilling', array( 'type' => 'hidden', 'readonly' => true, 'value' => $door_drilling ));
            if( isset($calculatePrice['conditions']['door_id']) && !empty($calculatePrice['conditions']['door_id']) ) {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.door_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['door_id'] ));
                echo $this->InventoryLookup->DoorStyle2ID($calculatePrice['conditions']['door_id'], true);
            }
            else {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.door_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => '' ));
            }
            ?>
        </td>
        <td class="text-left">
            &nbsp;
            <?php
            if( isset($calculatePrice['conditions']['door_color']) && !empty($calculatePrice['conditions']['door_color']) ) {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.door_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['door_color'] ));
                echo $this->InventoryLookup->ColorCode2ID($calculatePrice['conditions']['door_color'], true);
            }
            else {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.door_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => '' ));
            }
            ?>
        </td>
        <td class="text-left">
            &nbsp;
            <?php
            if( isset($calculatePrice['conditions']['material_id']) && !empty($calculatePrice['conditions']['material_id']) ) {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.material_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['material_id'] ));
                echo $this->InventoryLookup->MaterialCode2ID($calculatePrice['conditions']['material_id'], true);
            }
            else {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.material_id', array( 'type' => 'hidden', 'readonly' => true, 'value' => '' ));
            }
            ?>
        </td>
        <td class="text-left">
            &nbsp;
            <?php
            if( isset($calculatePrice['conditions']['cabinet_color']) && !empty($calculatePrice['conditions']['cabinet_color']) ) {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.cabinet_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['cabinet_color'] ));
                echo $this->InventoryLookup->ColorCode2ID($calculatePrice['conditions']['cabinet_color'], true);
            }
            else {
                echo $this->Form->input('CabinetOrder.' . $modal_id . '.cabinet_color', array( 'type' => 'hidden', 'readonly' => true, 'value' => '' ));
            }
            ?>
        </td>
        <td>
            <?php echo $door_side; ?>
        </td>
        <td>
            <?php echo $door_drilling; ?>
        </td>
        <td class="text-right quantity">
            &nbsp;
            <?php
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.quantity', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['conditions']['quantity'] ));
            echo $calculatePrice['conditions']['quantity'];
            ?>
        </td>
        <td class="text-right price">
            <?php
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.total_cost', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['total_price'] ));
            echo $this->Util->formatCurrency($calculatePrice['total_price']);
            ?>
        </td>
        <td class="text-left">
            &nbsp;
            <?php
            echo $this->Form->input('CabinetOrder.' . $modal_id . '.cost_calculation', array( 'type' => 'hidden', 'readonly' => true, 'value' => $calculatePrice['debug_calculation'] ));
            ?>
            <a href="#" class="icon-remove icon-remove-margin remove-cabinet-order-item show-tooltip" title="Remove">&nbsp;</a>
            <a href="#<?php echo $modal_id; ?>" class="icon-info-sign show-tooltip" title="Calculation Detail" data-toggle="modal">&nbsp;</a>
            <div id="<?php echo $modal_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>Price Calculation Detail</h3>
                </div>
                <div class="modal-body">
                    <p><?php echo $calculatePrice['debug_calculation']; ?></p>
                    <p>&nbsp;</p>
                </div>
            </div>
        </td>
    </tr>
    <?php
}
?>