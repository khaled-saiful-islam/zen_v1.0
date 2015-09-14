<fieldset>
    <?php if( $edit ) { ?>
        <div class="detail actions">
            <?php echo $this->Html->link('Edit', array( 'action' => EDIT, $cabinet['Cabinet']['id'], 'door-drawer' ), array( 'data-target' => '#cabinet_door_drawer', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit') )); ?>
        </div>
    <?php } ?>
    <table class='table-form-big table-form-big-margin'>
        <tr>
            <th colspan="4">
                <label class="table-data-big-title">Door Information</label>
            </th>
        </tr>
        <tr>
            <th class="table-separator-right">&nbsp;</th>
            <th class="table-separator-right"><label>Width</label></th>
            <th class="table-separator-right"><label>Height</label></th>
            <th class="table-separator-right"><label>Count</label></th>
        </tr>
        <tr>
            <th><label class="table-data-title">Top Door</label></th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['top_door_width']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['top_door_height']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['top_door_count']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><label class="table-data-title">Door Drilling</label></th>
            <td colspan="3" class="big-table-td-width">
                <?php echo h($this->InventoryLookup->getDoorDrilling($cabinet['Cabinet']['top_door_drilling'])); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><label class="table-data-title">Bottom Door</label></th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['bottom_door_width']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['bottom_door_height']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['bottom_door_count']); ?>
                &nbsp;
            </td>
        </tr>
<!--        <tr>
            <th><label class="table-data-title">Bottom Door Drilling</label></th>
            <td colspan="3" class="big-table-td-width">
                <?php echo h($this->InventoryLookup->getDoorDrilling($cabinet['Cabinet']['bottom_door_drilling'])); ?>
                &nbsp;
            </td>
        </tr>-->
        <tr>
            <th class="table-data-title"><label>Number of Hinges:</label></th>
            <td>
                <?php echo h($cabinet['Cabinet']['number_hinges']); ?>
                &nbsp;
            </td>
            <th class="table-data-title"><label>Number of Shelfs:</label></th>
            <td>
                <?php echo h($cabinet['Cabinet']['number_shelfs']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th class="table-data-title"><label for="CabinetTopaDoorHandling">Top Door Handling:</label></th>
            <td colspan="3" class="radio-lable">
                <?php echo $this->Form->radio('top_door_handling', array( 'Normally' => 'Normally', 'Like Bottom Doors' => 'Like Bottom Doors' ), array( 'legend' => false, 'value' => $cabinet['Cabinet']['top_door_handling'], 'disabled' => 'disabled', 'style' => 'clear: both;' )); ?>
            </td>
        </tr>
        <tr>
            <th class="table-data-title"><label for="CabinetTopaDoorHandling">Bottom Door Handling:</label></th>
            <td colspan="3" class="radio-lable">
                <?php echo $this->Form->radio('bottom_door_handling', array( 'Normally' => 'Normally', 'Frame only' => 'Frame Only' ), array( 'legend' => false, 'value' => $cabinet['Cabinet']['bottom_door_handling'], 'disabled' => 'disabled', 'style' => 'clear: both;' )); ?>
            </td>
        </tr>
    </table>
    <table class="table-form-big table-form-big-margin">
        <tr>
            <th colspan="4">
                <label class="table-data-big-title">Drawer Information</label>
            </th>
        </tr>
        <tr>
            <th class="table-separator-right">
                &nbsp;
            </th>
            <th class="table-separator-right">
                <label class="">Width</label>
            </th>
            <th class="table-separator-right">
                <label class="">Height</label>
            </th>
            <th class="table-separator-right">
                <label class="">Count</label>
            </th>
        </tr>
        <tr>
            <th class="table-separator-right">
                <label class="table-data-title">Top Drawer Front</label>
            </th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['top_drawer_front_width']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['top_drawer_front_height']); ?>&nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['top_drawer_front_count']); ?>&nbsp;
            </td>
        </tr>
        <tr>
            <th class="table-separator-right">
                <label class="table-data-title">Middle Drawer Front</label>
            </th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['middle_drawer_front_width']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['middle_drawer_front_height']); ?>&nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['middle_drawer_front_count']); ?>&nbsp;
            </td>
        </tr>
        <tr>
            <th class="table-separator-right">
                <label class="table-data-title">Bottom Drawer Front</label>
            </th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['bottom_drawer_front_width']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['bottom_drawer_front_height']); ?>&nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['bottom_drawer_front_count']); ?>&nbsp;
            </td>
        </tr>
        <tr>
            <th class="table-separator-right">
                <label class="table-data-title">Dummy Drawer Front</label>
            </th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['dummy_drawer_front_width']); ?>
                &nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['dummy_drawer_front_height']); ?>&nbsp;
            </td>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['dummy_drawer_front_count']); ?>&nbsp;
            </td>
        </tr>
        <tr>
            <th class="table-separator-right">
                <label class="table-data-title">Drawer Bottom</label>
            </th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['drawer_bottom_width']); ?>
                &nbsp;
            </td>
            <th class="big-table-td-width">
                <label>Depth:</label>
            </th>
            <td class="big-table-td-width">
                <?php echo h($cabinet['Cabinet']['drawer_bottom_depth']); ?>&nbsp;
            </td>
        </tr>
    </table>
</fieldset>