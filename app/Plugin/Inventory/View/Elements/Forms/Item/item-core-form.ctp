<fieldset>
    <legend class="inner-legend">
        <?php if( $edit ) { ?>
            <?php echo __('Edit Item Information'); ?>
            <?php
        }
        else {
            ?>
            <?php
            echo __('Add Item Information');
            ?>
            <?php
        }
        $material_required_class = '';
        if( isset($id) && $id ) {
            echo "<span style='float: left margin-left: 50px; font-size: 12px;'>&nbsp;&nbsp;(" . $this->InventoryLookup->Item_name_for_sub_base($id) . ")</span>";
            $material_required_class = ' required ';
        }

        $item_departments = $this->InventoryLookup->ItemDepartmentDetails(1);
        $item_departments_detail = array( );
        foreach( $item_departments as $item_department ) {
            $item_departments_detail[$item_department['ItemDepartment']['id']] = $item_department['ItemDepartment'];
        }
        ?>
    </legend>
    <script>
        var item_department_detail = <?php echo json_encode($item_departments_detail) ?>;
    </script>
    <table style="margin-bottom: 10px;">
        <tr>
            <th style="width: 106px; text-align: left;padding-left: 10px;" for="ItemItemGroup">Item Group:</th>
            <?php if( $edit || $id ) { ?>
                <td>
                    <?php
//        echo $this->Form->input('item_group', array('placeholder' => 'Item Group', 'options' => $this->InventoryLookup->InventoryLookup('item_group', true), 'empty' => true,'readonly'=> true, 'class' => 'form-select select-item-group item_number'));
//        echo $this->Form->input('item_group', array('readonly'=> true, 'class' => 'hide', 'type' => 'hidden'));
//        echo $this->Form->input('base_item', array('readonly'=> true, 'class' => 'hide', 'type' => 'hidden', 'value' => $id));
                    echo $this->InventoryLookup->InventoryLookupReverse($this->request->data['Item']['item_group']);
                    ?>
                </td>
                <?php
            }
            else {
                ?>
                <td><?php echo $this->Form->input('item_group', array( 'placeholder' => 'Item Group', 'options' => $this->InventoryLookup->InventoryLookup('item_group', true), 'empty' => true, 'class' => 'form-select select-item-group item_number' )); ?></td>
                <?php
            }
            ?>
<!--<td><?php echo $this->Form->input('base_item', array( 'type' => 'hidden', 'value' => isset($id) ? $id : '' )); ?></td>-->
        </tr>
    </table>
    <table class='item-cost-calculation table-form-big'>
        <tr>
            <th for="ItemItemTitle">Item Code:</th>
            <td colspan="3"><?php echo $this->Form->input('item_title', array( 'class' => 'required wide-input', 'placeholder' => 'Item Code' )); ?></td>
        </tr>
        <tr>
            <th for="ItemWidth">Width:</th>
            <td><?php echo $this->Form->input('width', array( 'placeholder' => 'Width', 'class' => 'required small-input' )); ?></td>
            <th for="ItemLength">Length:</th>
            <td><?php echo $this->Form->input('length', array( 'placeholder' => 'Length', 'class' => 'required small-input' )); ?></td>
        </tr>
        <tr>
            <th for="ItemItemCost">Item Cost:</th>
            <td><?php echo $this->Form->input('item_cost', array( 'placeholder' => 'Item Cost', 'class' => 'required item-cost money-input' )); ?></td>
            <th for="ItemItemMaterial">Item Material Group:</th>
            <td>
                <?php
                echo $this->Form->input('item_material_group', array( 'placeholder' => 'Item Material Group', 'options' => $this->InventoryLookup->getMaterialGroup(), 'empty' => true, 'class' => 'select-item-material-group ' . $material_required_class, 'default' => isset($this->request->data['Item']['item_material_group']) ? $this->request->data['Item']['item_material_group'] : '' ));
                ?>
            </td>
        </tr>
        <tr>
            <th for="ItemFactor">Factor:</th>
            <td><?php echo $this->Form->input('factor', array( 'placeholder' => 'Factor', 'class' => 'required item-factor small-input' )); ?></td>
            <th for="ItemFactor">Builder Factor:</th>
            <td><?php echo $this->Form->input('builder_factor', array( 'class' => 'small-input' )); ?></td>
        </tr>
        <tr>
            <th for="ItemPrice">Price:</th>
            <td><?php echo $this->Form->input('price', array( 'placeholder' => 'Price', 'class' => 'required item-price money-input', 'readonly' => 'readonly' )); ?></td>
            <th for="ItemItemCost">Builder Price:</th>
            <td><?php echo $this->Form->input('builder_price', array( 'placeholder' => 'Builder Price', 'class' => 'money-input' )); ?></td>
        </tr>
        <tr>
            <th for="ItemDescription">Description:</th>
            <td colspan="3"><?php echo $this->Form->input('description', array( 'placeholder' => 'Description', 'class' => 'wide-input', 'rows' => 3, 'cols' => 50 )); ?></td>
        </tr>
    </table>
    <table class='table-form-big table-form-big-margin'>
        <tr>
            <th colspan="4">
                <label style="text-decoration: none;" class="table-data-title">Ordering / Storage</label>
            </th>
        </tr>
        <tr>
            <th><label for="ItemSupplierId">Supplier:</label></th>
            <td><?php echo $this->Form->input('supplier_id', array( 'placeholder' => 'Supplier', 'empty' => true, 'class' => 'form-select required' )); ?></td>
            <th><label for="ItemItemDepartmentId">Item Department:</label></th>
            <td><?php echo $this->Form->input('item_department_id', array( 'placeholder' => 'Item Department', 'options' => $this->InventoryLookup->ItemDepartment(1), 'empty' => true, 'class' => 'form-select required' )); ?></td>
        </tr>
        <tr>
            <th><label for="ItemCurrentStock">Current Stock:</label></th>
            <td><?php echo $this->Form->input('current_stock', array( 'placeholder' => 'Current Stock', 'class' => 'required small-input' )); ?></td>
            <th><label for="ItemLocation">Location:</label></th>
            <td><?php echo $this->Form->input('location', array( 'placeholder' => 'Location' )); ?></td>
        </tr>
    </table>

    <fieldset>
        <?php //echo __('Item Detail'); ?>
        <?php
        $select_data = array( );
        if( isset($this->data['ItemOption']) && is_array($this->data['ItemOption']) ) {
            foreach( $this->data['ItemOption'] as $item ) {
                @$select_data[$item['id']] = $item['name'];
            }
        }
        ?>
        <script type="text/javascript">

            work_order_job_title('form.item-core-form .item-option',<?php echo $this->InventoryLookup->select2_multi_json_format($this->InventoryLookup->InventoryLookup('item_option')); ?>,<?php echo $this->InventoryLookup->select2_multi_json_format($select_data); ?>);

        </script>
        <table class='table-form-big table-form-big-margin'>
            <tr>
                <th colspan="4">
                    <label style="text-decoration: none;" class="table-data-title">Item Detail</label>
                </th>
            </tr>
            <tr>
                <th><label for="ItemMinimum">Minimum:</label></th>
                <td><?php echo $this->Form->input('minimum', array( 'class' => 'small-input' )); ?></td>
                <th><label for="ItemMaximum">Maximum:</label></th>
                <td><?php echo $this->Form->input('maximum', array( 'class' => 'small-input' )); ?></td>
            </tr>
            <tr>
                <th><label for="ItemItemOption">Item Option:</label></th>
                <td>
                    <?php echo $this->Form->input('ItemOption', array( 'options' => $this->InventoryLookup->InventoryLookup('item_option'), 'class' => 'form-select input-medium' )); ?>
                </td>
                <th><label for="ItemItemOption">Available in Website:</label></th>
                <td>
                    <?php echo $this->Form->input('avaiable_in_website'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="ItemImage">Item Image:</label></th>
                <td colspan="3">
                    <?php echo $this->Form->input('image', array( 'type' => 'file' )); ?>
                    <?php echo $this->Form->input('image_dir', array( 'type' => 'hidden' )); ?>
                    <?php
                    if( !empty($item_image['Item']['image']) ) {
                        echo $this->Html->image("../files/item/image/{$item_image['Item']['image_dir']}/thumb_{$item_image['Item']['image']}");
                    }
                    else {
                        echo $this->Html->image("../img/no-image.jpg");
                    }
                    ?>
                </td>
            </tr>
        </table>

        <table class='table-form-big' style="margin-top: 10px;">
            <tr>
                <th colspan="4"><label>Edge Tape (in mm)</label></th>
            </tr>
            <tr>
                <th><label for="ItemMatchingColor">Matching Color:</label></th>
                <td><?php echo $this->Form->input('matching_color', array( 'class' => 'small-input required' )); ?></td>
                <th><label for="ItemCustomerColor">Customer Color:</label></th>
                <td><?php echo $this->Form->input('customer_color', array( 'class' => 'small-input required' )); ?></td>
            </tr>
        </table>
    </fieldset>
</fieldset>


<script>
    $(".item-core-form").validate({ignore: null});
<?php if( $edit ) { ?>
        //    $(".item-core-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
<?php } ?>
    $('#ItemItemDepartmentId').change(function(){
        $('#ItemAvaiableInWebsite').attr('checked', false);
        if(item_department_detail[$(this).val()] != undefined) {
            if(item_department_detail[$(this).val()].avaiable_in_website) {
                $('#ItemAvaiableInWebsite').attr('checked', 'checked');
            }
        }
    });
</script>