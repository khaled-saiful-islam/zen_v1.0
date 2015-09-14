<?php //pr($this->request);    ?>
<div class="see-all-contact">
    <?php echo $this->Html->link('Edit Contact', array('controller' => 'customer_addresses', 'action' => 'edit_sub', $address['CustomerAddress']['id'], $address['Customer']['id']), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit Contact'))); ?> |
    <?php echo $this->Html->link('See All Contact', array('controller' => 'customer_addresses', 'action' => 'show_list', $address['Customer']['id']), array('data-target' => '#sub-content-address-form', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('See All Contact'))); ?> | 
</div>
<div class="addresses view">
    <fieldset>
        <!--<legend><?php echo __('CustomerAddress'); ?></legend>-->
        <table class="table table-striped table-data-compact">
          <!--<tr>
            <th><?php echo __('Customer'); ?>:</th>
            <td>
            <?php echo $this->Html->link($address['Customer']['id'], array('controller' => 'customers', 'action' => DETAIL)); ?>
              &nbsp;
            </td>
          </tr>-->
            <tr>
                <th><?php echo __('Name'); ?>:</th>
                <td>
                    <?php echo h($address['CustomerAddress']['first_name']); ?>&nbsp;<?php echo h($address['CustomerAddress']['last_name']); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Address Type'); ?>:</th>
                <td>
                    <?php echo $address['AddressType']['name']; ?>
                    &nbsp;
                </td>
            </tr>
            <!--<tr>
                <th><?php echo __('Last Name'); ?>:</th>
                <td>
            <?php echo h($address['CustomerAddress']['last_name']); ?>
                    &nbsp;
                </td>
            </tr>-->
            <tr>
                <th><?php echo __('Address'); ?>:</th>
                <td>
                    <?php echo h($address['CustomerAddress']['address_line_1']); ?>
                    &nbsp;
                </td>
                <th><?php echo __('City'); ?>:</th>
                <td>
                    <?php echo h($address['CustomerAddress']['city']); ?>
                    &nbsp;
                </td>                
            </tr>            
            <tr>
                <?php if ($address['CustomerAddress']['address_line_2'] != "") { ?>
                    <th>&nbsp;</th>
                    <td>
                        <?php echo h($address['CustomerAddress']['address_line_2']); ?>
                        &nbsp;
                    </td>
                <?php } else { ?>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                <?php } ?>
                <th><?php echo __('State'); ?>:</th>
                <td>
                    <?php echo h($address['CustomerAddress']['state']); ?>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th><?php echo __('Zip'); ?>:</th>
                <td>
                    <?php echo h($address['CustomerAddress']['zip']); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Phone Other'); ?>:</th>
                <td colspan="3">
                    <?php echo h($address['CustomerAddress']['phone_other']); ?>
                    &nbsp;
                </td>
            </tr>
            <tr>

            </tr>
        </table>
    </fieldset>
</div>
