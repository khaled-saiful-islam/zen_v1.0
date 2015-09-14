<?php
if( $modal != "modal" ) {
    ?>  
    <div class="detail actions">
        <?php echo $this->Html->link('Edit', array( 'action' => EDIT, $user['User']['id'], 'basic' ), array( 'data-target' => '#user-basic-info', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit') )); ?>
    </div>
<?php } ?>
<table class="table-form-big <?php if( $modal == "modal" ) { ?> margin-bottom <?php } ?>">
    <tr>
        <th>
            <label>Name:</label>
        </th>
        <td>          
            <?php echo h($user['User']['first_name']); ?> 
            &nbsp;
            <?php echo h($user['User']['last_name']); ?>
        </td> 
        <th>
            <label>Employee Number:</label>
        </th>
        <td>
            <?php echo h($user['User']['empid']); ?>&nbsp;
        </td>
    </tr>
    <tr>    
        <th>
            <label>Title:</label>
        </th>
        <td>
            <?php echo h($user['User']['title']); ?>&nbsp;
        </td>
        <th>
            <label>Username:</label>
        </th>
        <td>
            <?php echo h($user['User']['username']); ?>&nbsp;
        </td>
    </tr>
    <tr>    
        <th>
            <label>Role:</label>
        </th>
        <td>
            <?php
            if( !empty($user['User']['role']) ) {
                $role = $this->InventoryLookup->InventorySpecificLookup('user_role', $user['User']['role']);
                echo h($role[$user['User']['role']]);
            }
            ?>
            &nbsp;
        </td>
        <th>
            <label>Status:</label>
        </th>
        <td>
            <?php echo $user['User']['status'] == 0 ? 'Inactive' : 'Active'; ?>&nbsp;
        </td>
    </tr>  
    <tr>
        <th>
            <label>E-mail 1:</label>
        </th>
        <td>
            <?php echo h($user['User']['email1']); ?>&nbsp;
        </td>
        <th>
            <label>E-mail 2:</label>
        </th>
        <td>
            <?php echo h($user['User']['email2']); ?>&nbsp;
        </td>
    </tr>
    <tr>    
        <th><label>Cell Phone: </label></th>
        <td>
            <?php echo h($user['User']['cell_phone']); ?>&nbsp;
        </td>
        <th><label>Home Phone: </label></th>
        <td>
            <?php echo $this->InventoryLookup->phone_format(h($user['User']['home_phone']), $user['User']['hp_ext'], null, null); ?>
        </td>
    </tr>
    <tr>
        <th><label>Work Phone: </label></th>
        <td colspan="3">
            <?php //echo h($user['User']['work_phone']); ?>
            <?php //echo h($user['User']['ext']); ?>
            <?php echo $this->InventoryLookup->phone_format(h($user['User']['work_phone']), $user['User']['wp_ext'], null, null); ?>

        </td>
    </tr>
    <tr>
        <th>
            <label>Address:</label>
        </th>
        <td>
            <?php echo $this->InventoryLookup->address_format($user['User']['address'], $user['User']['city'], $user['User']['province'], $user['User']['country'], $user['User']['postal_code']); ?>&nbsp;
        </td>
        <th>
            <label>	Description/Remark:</label>
        </th>
        <td>
            <?php echo h($user['User']['remark']); ?>&nbsp;
        </td>
    </tr>
    <tr>

    </tr>
</table>
<?php if( $loginUser['role'] == 94 ) { ?>
    <div style="width: 100%;height: 30px; background: #EDEBE8; margin-top: 10px; margin-bottom: 5px; font-size: 14px; font-weight: bold;">User Permission</div>
    <table class="table-form-big">
        <tr>
            <th style="width: 150px;"><label>Dashboard Section: </label></th>
            <td><?php echo $user['User']['permission_dashboard'] == 1 ? "Yes" : "No"; ?></td>
            <th style="width: 150px;"><label>Customer Section: </label></th>
            <td><?php echo $user['User']['permission_customer'] == 1 ? "Yes" : "No"; ?></td>
        </tr>
        <tr>
            <th style="width: 150px;"><label>Quote Section: </label></th>
            <td><?php echo $user['User']['permission_quote'] == 1 ? "Yes" : "No"; ?></td>
            <th style="width: 150px;"><label>Work Order Section: </label></th>
            <td><?php echo $user['User']['permission_work_order'] == 1 ? "Yes" : "No"; ?></td>
        </tr>
        <tr>
            <th style="width: 150px;"><label>Purchase Order Section: </label></th>
            <td><?php echo $user['User']['permission_purchase_order'] == 1 ? "Yes" : "No"; ?></td>
            <th style="width: 150px;"><label>Schedule Section: </label></th>
            <td><?php echo $user['User']['permission_schedule'] == 1 ? "Yes" : "No"; ?></td>
        </tr>
        <tr>
            <th style="width: 150px;"><label>Admin Section: </label></th>
            <td><?php echo $user['User']['permission_admin'] == 1 ? "Yes" : "No"; ?></td>
        </tr>
    </table>
<?php } ?>
