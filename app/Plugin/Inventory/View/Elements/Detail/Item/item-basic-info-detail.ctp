<div class="detail actions">
    <?php
    if( $edit ) {
        echo $this->Html->link('Edit Item', array( 'action' => EDIT, $item['Item']['id'] ), array( 'data-target' => '#item-basic-info-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit Item') ));
    }
    ?>
</div>
<table style="margin-bottom: 10px;">
    <tr>
        <th><?php echo __('Item Group'); ?>:</th>
        <td>
            <?php
            if( $item['Item']['item_group'] ) {
                $item_group = $this->InventoryLookup->InventorySpecificLookup('item_group', $item['Item']['item_group']);
                echo h($item_group[$item['Item']['item_group']]);
            }
            ?>
            &nbsp;
        </td>
    </tr>
</table>
<table class="table-form-big">
    <tr>
        <th><?php echo __('Number'); ?>:</th>
        <td>
            <?php echo h($item['Item']['number']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Item Code'); ?>:</th>
        <td colspan="3">
            <?php echo h($item['Item']['item_title']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Width'); ?>:</th>
        <td>
            <?php echo h($item['Item']['width']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Length'); ?>:</th>
        <td>
            <?php echo h($item['Item']['length']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Item Cost'); ?>:</th>
        <td>
            <?php echo $this->Util->formatCurrency($item['Item']['item_cost']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Item Material Group'); ?>:</th>
        <td>
            <?php
            if( $item['Item']['item_material'] ) {
                $item_material_group = $this->InventoryLookup->findMaterialGroup($item['Item']['item_material_group']);
                echo h($item_material_group);
            }
            ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Factor'); ?>:</th>
        <td>
            <?php echo h($item['Item']['factor']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Builder Factor'); ?>:</th>
        <td>
            <?php echo $item['Item']['builder_factor']; ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Price'); ?>:</th>
        <td>
            <?php echo $this->Util->formatCurrency($item['Item']['price']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Builder Price'); ?>:</th>
        <td>
            <?php echo $this->Util->formatCurrency($item['Item']['builder_price']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Description'); ?>:</th>
        <td colspan="3">
            <?php echo h($item['Item']['description']); ?>
            &nbsp;
        </td>
    </tr>
    <table class='table-form-big table-form-big-margin'>
        <tr>
            <th colspan="4">
                <label style="text-decoration: none;" class="table-data-title">Ordering / Storage</label>
            </th>
        </tr>
        <tr>
            <th><?php echo __('Supplier'); ?>:</th>
            <td>
                <?php echo $this->Html->link(h($item['Supplier']['name']), array( 'controller' => 'suppliers', 'action' => DETAIL, $item['Supplier']['id'] )); ?>
                &nbsp;
            </td>
            <th><?php echo __('Item Department'); ?>:</th>
            <td>
                <?php echo $this->Html->link(h($item['ItemDepartment']['name']), array( 'controller' => 'item_departments', 'action' => DETAIL, $item['ItemDepartment']['id'] )); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><?php echo __('Current Stock'); ?>:</th>
            <td>
                <?php echo h($item['Item']['current_stock']); ?>
                &nbsp;
            </td>
            <th><?php echo __('Location'); ?>:</th>
            <td>
                <?php echo h($item['Item']['location']); ?>
                &nbsp;
            </td>
        </tr>
    </table>

    <table cellpatding="0" cellspacing="0" class="table-form-big table-form-big-margin">
        <tr>
            <th colspan="4">
                <label style="text-decoration: none;" class="table-data-title">Item Detail</label>
            </th>
        </tr>
        <tr>
            <th><?php echo __('Minimum'); ?>:</th>
            <td>
                <?php echo h($item['Item']['minimum']); ?>
                &nbsp;
            </td>
            <th><?php echo __('Maximum'); ?>:</th>
            <td>
                <?php echo h($item['Item']['maximum']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><?php echo __('Item Options'); ?>:</th>
            <td>
                <?php
                foreach( $item['ItemOption'] as $item_option ) {
                    echo h($item_option['name']);
                    echo '<br />'; // line break for each item options
                }
                ?>
                &nbsp;
            </td>
            <th><label for="ItemImage">Available in Website:</label></th>
            <td>
                <?php
                if( $item['Item']['avaiable_in_website'] == 1 ) {
                    echo 'Yes';
                }
                else {
                    echo 'No';
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="ItemImage">Item Image:</label></th>
            <td colspan="3">
                <?php
                if( !empty($item['Item']['image']) ) {
                    echo $this->Html->image("../files/item/image/{$item['Item']['image_dir']}/thumb_{$item['Item']['image']}");
                }
                ?>
            </td>
        </tr>        
        <tr>
            <th colspan="4"><label>Edge Tape in mm:</label></th>
        </tr>
        <tr>
            <th><?php echo __('Matching Color'); ?>:</th>
            <td>
                <?php
                echo $item['Item']['matching_color'];
                ?>
                &nbsp;
            </td>
            <th><?php echo __('Customer Color'); ?>:</th>
            <td>
                <?php
                echo $item['Item']['customer_color'];
                ?>
            </td>
        </tr>
        <tr>
            <th><?php echo __('Edge Tape Std'); ?>:</th>
            <td>
                <?php
                echo $item['Item']['etape_std'];
                ?>
                &nbsp;
            </td>
            <th><?php echo __('Edge Tape Cust'); ?>:</th>
            <td>
                <?php
                echo $item['Item']['etape_cust'];
                ?>
            </td>
        </tr>
    </table>