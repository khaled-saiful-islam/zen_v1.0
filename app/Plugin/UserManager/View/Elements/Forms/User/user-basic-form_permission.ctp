<div id="user-basic-information" class="sub-content-detail">
    <fieldset>    
        <legend <?php if( $edit ) { ?> class="inner-legend" <?php } ?>>
            <?php echo $legend; ?>
        </legend>
        <?php if( $loginUser['role'] == 94 ) { ?>
            <div style="width: 100%; background: #EDEBE8; margin-top: 10px; margin-bottom: 5px; font-size: 14px; font-weight: bold;">User Permission</div>
            <table class="table-form-big">
                <tr>
                    <th style="width: 150px;"><label>Dashboard Section: </label></th>
                    <td><?php echo $this->Form->input('permission_dashboard', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                    <th style="width: 150px;"><label>Customer Section: </label></th>
                    <td><?php echo $this->Form->input('permission_customer', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                </tr>
                <tr>
                    <th style="width: 150px;"><label>Quote Section: </label></th>
                    <td><?php echo $this->Form->input('permission_quote', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                    <th style="width: 150px;"><label>Work Order Section: </label></th>
                    <td><?php echo $this->Form->input('permission_work_order', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                </tr>
                <tr>
                    <th style="width: 150px;"><label>Purchase Order Section: </label></th>
                    <td><?php echo $this->Form->input('permission_purchase_order', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                    <th style="width: 150px;"><label>Schedule Section: </label></th>
                    <td><?php echo $this->Form->input('permission_schedule', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                </tr>
                <tr>
                    <th style="width: 150px;"><label>Admin Section: </label></th>
                    <td><?php echo $this->Form->input('permission_admin', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                </tr>
            </table>
        <?php } ?>
    </fieldset>
</div>
