<div class="see-all-contact">
    <?php echo $this->Html->link('Edit Contact', array('controller' => 'supplier_contacts', 'action' => 'edit_sub', $supplierContact['SupplierContact']['id'], $supplierContact['Supplier']['id']), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit Contact'))); ?> |
    <?php echo $this->Html->link('See All Contact', array('controller' => 'supplier_contacts', 'action' => 'show_list', $supplierContact['Supplier']['id']), array('data-target' => '#sub-content-contact-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('See All Contact'))); ?> | 
</div>
<div class="supplierContacts view">
    <fieldset>
        <legend><?php echo __('Supplier Contact'); ?></legend>
        <table class="table table-striped table-data-compact">
            <tr>
                <th><?php echo __('Supplier Name'); ?>:</th>
                <td>
                    <?php echo $this->Html->link("{$supplierContact['Supplier']['name']}", array('controller' => 'suppliers', 'action' => 'view', $supplierContact['Supplier']['id'])); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Contact Name'); ?>:</th>
                <td>
                    <?php echo h($supplierContact['SupplierContact']['first_name']); ?>
                    &nbsp;
                    <?php echo h($supplierContact['SupplierContact']['last_name']); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo __('Address'); ?>:</th>
                <td>
                    <?php echo h($supplierContact['SupplierContact']['address_line_1']); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Address Type'); ?>:</th>
                <td>
                    <?php echo $supplierContact['AddressType']['name']; ?>
                    &nbsp;
                </td>
            </tr>      
            <tr>                
                <?php if ($supplierContact['SupplierContact']['address_line_2'] == "") { ?>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                <?php } else { ?>
                    <th>&nbsp;</th>
                    <td>
                        <?php echo h($supplierContact['SupplierContact']['address_line_2']); ?>
                        &nbsp;
                    </td>
                <?php } ?>
                <th><?php echo __('City'); ?>:</th>
                <td>
                    <?php echo h($supplierContact['SupplierContact']['city']); ?>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th><?php echo __('State'); ?>:</th>
                <td>
                    <?php echo h($supplierContact['SupplierContact']['state']); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Phone Other'); ?>:</th>
                <td>
                    <?php echo h($supplierContact['SupplierContact']['phone_other']); ?>
                    &nbsp;
                </td>
            </tr>
        </table>
    </fieldset>
</div>