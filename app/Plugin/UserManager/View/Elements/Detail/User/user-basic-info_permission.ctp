
<div class="detail actions">
    <?php echo $this->Html->link('Edit', array( 'action' => 'user_permission_edit', $user['User']['id'], 'basic' ), array( 'data-target' => '#user-basic-info', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit') )); ?>
</div>
<?php if( $loginUser['role'] == 94 ) { ?>
    <div style="width: 100%;height: 30px; background: #EDEBE8; margin-top: 30px; margin-bottom: 5px; font-size: 14px; font-weight: bold;">User Permission</div>
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
