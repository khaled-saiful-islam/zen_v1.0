<div class="supplierContacts index">
    <h2><?php echo __('Supplier Contacts'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('supplier_id'); ?></th>
            <th><?php echo $this->Paginator->sort('first_name'); ?></th>
            <th><?php echo $this->Paginator->sort('last_name'); ?></th>
            <th><?php echo $this->Paginator->sort('address_line_1'); ?></th>
            <th><?php echo $this->Paginator->sort('address_line_2'); ?></th>
            <th><?php echo $this->Paginator->sort('city'); ?></th>
            <th><?php echo $this->Paginator->sort('state'); ?></th>
            <th><?php echo $this->Paginator->sort('phone_other'); ?></th>
            <th><?php echo $this->Paginator->sort('zip'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($supplierContacts as $supplierContact): ?>
            <tr>
                <td><?php echo h($supplierContact['SupplierContact']['id']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($supplierContact['Supplier']['name'], array('controller' => 'suppliers', 'action' => 'view', $supplierContact['Supplier']['id'])); ?>
                </td>
                <td><?php echo h($supplierContact['SupplierContact']['first_name']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['last_name']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['address_line_1']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['address_line_2']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['city']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['state']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['phone_other']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['zip']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['created']); ?>&nbsp;</td>
                <td><?php echo h($supplierContact['SupplierContact']['modified']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $supplierContact['SupplierContact']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $supplierContact['SupplierContact']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $supplierContact['SupplierContact']['id']), null, __('Are you sure you want to delete # %s?', $supplierContact['SupplierContact']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Supplier Contact'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Suppliers'), array('controller' => 'suppliers', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Address Types'), array('controller' => 'address_types', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Address Type'), array('controller' => 'address_types', 'action' => 'add')); ?> </li>
    </ul>
</div>
