<fieldset>
    <?php if( $edit ) { ?>
        <div class="detail actions">
            <?php echo $this->Html->link('Edit', array( 'action' => EDIT, $cabinet['Cabinet']['id'], 'basic' ), array( 'data-target' => '#cabinet_information', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit') )); ?>
        </div>
    <?php } ?>
    <table class="table-form-big">
        <tr>
            <th><?php echo h('Name'); ?>:</th>
            <td>
                <?php echo h($cabinet['Cabinet']['name']); ?>
                &nbsp;
            </td>
            <th><?php echo h('Cabinet Category'); ?>:</th>
            <td colspan="3">
                <?php
                if( $cabinet['Cabinet']['product_type'] && is_array($cabinet['Cabinet']['product_type']) ) {
                    $product_type = $this->InventoryLookup->InventorySpecificLookup('cabinet_type', $cabinet['Cabinet']['product_type']);
                    if( $product_type ) {
                        foreach( $cabinet['Cabinet']['product_type'] as $lookup_id ) {
                            echo '<li>' . h($product_type[$lookup_id]) . '</li>';
                        }
                    }
                }
                ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><label for="CabinetLabourHours">Labour Hours:</label></th>
            <td colspan="2"><?php echo $cabinet['Cabinet']['labour_hours']; ?></td>
        </tr>
        <tr>
            <th><?php echo h('Image'); ?>:</th>
            <td>
                <?php //echo h($cabinet['Cabinet']['image']); ?>
                <?php
                if( !empty($cabinet['Cabinet']['image']) ) {
                    echo $this->Html->image("../files/cabinet/image/{$cabinet['Cabinet']['image_dir']}/{$cabinet['Cabinet']['image']}");
                }
                ?>
                &nbsp;
            <th ><?php echo h('Description'); ?>:</th>
            <td colspan="3">
                <?php echo h($cabinet['Cabinet']['description']); ?>
                &nbsp;
            </td>

            </td>
        </tr>
        <tr>
            <th colspan="6" class="table-separator-right">
                <label class="table-data-title">Actual Dimensions</label>
            </th>
        </tr>
        <tr>
            <th><?php echo h('Width'); ?>:</th>
            <td>
                <?php echo h($cabinet['Cabinet']['actual_dimensions_width']); ?>
                &nbsp;
            </td>
            <th><?php echo h('Height'); ?>:</th>
            <td>
                <?php echo h($cabinet['Cabinet']['actual_dimensions_height']); ?>
                &nbsp;
            </td>
            <th><?php echo h('Depth'); ?>:</th>
            <td>
                <?php echo h($cabinet['Cabinet']['actual_dimensions_depth']); ?>
                &nbsp;
            </td>
        </tr>
    </table>
</fieldset>