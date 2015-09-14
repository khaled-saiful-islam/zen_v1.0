<div id="cabinet_door_drawer" class="tab-pane">
    <fieldset>
        <legend <?php if( $edit ) { ?> class="inner-legend" <?php } ?>>Edit Door/Drawer Information</legend>
        <table class='table-form-big'>
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
                <td class="big-table-td-width"><?php echo $this->Form->input('top_door_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('top_door_height', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('top_door_count', array( 'class' => 'input-width', 'placeholder' => 'Count' )); ?></td>
            </tr>
            <tr>
                <th><label class="table-data-title">Door Drilling</label></th>
                <td class="big-table-td-width" colspan="3"><?php echo $this->Form->input('top_door_drilling', array( 'class' => 'form-select', 'placeholder' => 'Drilling', "options" => $this->InventoryLookup->getDoorDrilling() )); ?></td>
            </tr>
            <tr>
                <th><label class="table-data-title">Bottom Door</label></th>
                <td class="big-table-td-width"><?php echo $this->Form->input('bottom_door_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('bottom_door_height', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('bottom_door_count', array( 'class' => 'input-width', 'placeholder' => 'Count' )); ?></td>
            </tr>
<!--            <tr>
                <th><label class="table-data-title">Bottom Door Drilling</label></th>
                <td class="big-table-td-width" colspan="3"><?php echo $this->Form->input('bottom_door_drilling', array( 'class' => 'form-select', 'placeholder' => 'Drilling', "options" => $this->InventoryLookup->getDoorDrilling() )); ?></td>
            </tr>-->
            <tr>
                <th class="table-data-title"><label>Number of Hinges:</label></th>
                <td><?php echo $this->Form->input('number_hinges', array( 'class' => 'input-width', 'placeholder' => 'Hinges' )); ?></td>
                <th class="table-data-title"><label>Number of Shelfs:</label></th>
                <td><?php echo $this->Form->input('number_shelfs', array( 'class' => 'input-width', 'placeholder' => 'Shelfs' )); ?></td>
            </tr>
            <tr>
                <th class="table-data-title"><label for="CabinetTopaDoorHandling">Top Door Handling:</label></th>
                <td colspan="4" class="radio-lable">
                    <?php echo $this->Form->radio('top_door_handling', array( 'Normally' => 'Normally', 'Like Bottom Doors' => 'Like Bottom Doors' ), array( 'legend' => false, 'style' => 'clear: both;' )); ?></td>
            </tr>
            <tr>
                <th class="table-data-title"><label for="CabinetBottomaDoorHandling">Bottom Door Handling:</label></th>
                <td colspan="4" class="radio-lable">
                    <?php echo $this->Form->radio('bottom_door_handling', array( 'Normally' => 'Normally', 'Frame Only' => 'Frame Only' ), array( 'legend' => false, 'style' => 'clear: both;' )); ?></td>
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
                <td class="big-table-td-width"><?php echo $this->Form->input('top_drawer_front_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('top_drawer_front_height', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('top_drawer_front_count', array( 'class' => 'input-width', 'placeholder' => 'Count' )); ?></td>
            </tr>
            <tr>
                <th class="table-separator-right">
                    <label class="table-data-title">Middle Drawer Front</label>
                </th>
                <td class="big-table-td-width"><?php echo $this->Form->input('middle_drawer_front_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('middle_drawer_front_height', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('middle_drawer_front_count', array( 'class' => 'input-width', 'placeholder' => 'Count' )); ?></td>
            </tr>
            <tr>
                <th class="table-separator-right">
                    <label class="table-data-title">Bottom Drawer Front</label>
                </th>
                <td class="big-table-td-width"><?php echo $this->Form->input('bottom_drawer_front_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('bottom_drawer_front_height', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('bottom_drawer_front_count', array( 'class' => 'input-width', 'placeholder' => 'Count' )); ?></td>
            </tr>
            <tr>
                <th class="table-separator-right">
                    <label class="table-data-title">Dummy Drawer Front</label>
                </th>
                <td class="big-table-td-width"><?php echo $this->Form->input('dummy_drawer_front_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('dummy_drawer_front_height', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
                <td class="big-table-td-width"><?php echo $this->Form->input('dummy_drawer_front_count', array( 'class' => 'input-width', 'placeholder' => 'Count' )); ?></td>
            </tr>
            <tr>
                <th class="table-separator-right">
                    <label class="table-data-title">Drawer Bottom</label>
                </th>
                <td class="big-table-td-width"><?php echo $this->Form->input('drawer_bottom_width', array( 'class' => 'input-width', 'placeholder' => 'Width' )); ?></td>
                <th class="big-table-td-width">
                    <label>Depth:</label>
                </th>
                <td class="big-table-td-width"><?php echo $this->Form->input('drawer_bottom_depth', array( 'class' => 'input-width', 'placeholder' => 'Height' )); ?></td>
            </tr>
        </table>
    </fieldset>
</div>