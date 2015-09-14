<?php //debug($customer); ?>
<div class="detail actions">
    <?php echo $this->Html->link('Edit', array('action' => EDIT, $customer['Customer']['id'],'account-credit'), array('data-target' => '#customer-account-credit-info', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<table class="table table-striped table-data-compact">
    <tr>
        <th><?php echo __('Discount Rate'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['discount_rate']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Retail Client'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['retail_client']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Multi Unit'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['multi_unit']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Quotes Validity'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['quotes_validity']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('AR Account'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['ar_account']); ?>
            &nbsp;
        </td>
        <th><?php echo __('Ap Account'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['ap_account']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Effective Date'); ?>:</th>
        <td>
            <?php echo h($this->Util->dateTimeFormat($customer['BuilderAccount']['effective_date'])); ?>
            &nbsp;
        </td>
        <th><?php echo __('Invoice On Day'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['invoice_on_day']); ?>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th><?php echo __('Due On Day'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['due_on_day']); ?>
        </td>
        <th><?php echo __('Credit Limit'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['credit_limit']); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo __('Credit Terms'); ?>:</th>
        <td colspan="3">
            <?php echo h($customer['BuilderAccount']['credit_terms']); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo __('Created'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['created']); ?>
        </td>
        <th><?php echo __('Modified'); ?>:</th>
        <td>
            <?php echo h($customer['BuilderAccount']['modified']); ?>
        </td>
    </tr>
</table>