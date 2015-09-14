<fieldset>
    <?php if( $edit ) { ?>
        <div class="detail actions">
            <?php echo $this->Html->link('Add/Edit', array( 'action' => EDIT, $cabinet['Cabinet']['id'], 'accessories' ), array( 'data-target' => '#cabinet_accessories', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit') )); ?>
        </div>
    <?php } ?>
    <?php if( $cabinets_accessories ) { ?>
        <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing" style="width: 60%;">
            <thead>
                <tr class="grid-header">
                    <th class="min-witdh"><?php echo h('Item Code'); ?></th>
                    <th class="min-witdh"><?php echo h('Description'); ?></th>
                    <th class="min-witdh"><?php echo h('Department'); ?></th>
                    <th class="min-witdh"><?php echo h('Item Cost'); ?></th>
                    <th class="min-witdh"><?php echo h('Quantity'); ?></th>
                    <th class="min-witdh"><?php echo h('Price'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $item_departments = $this->InventoryLookup->ItemDepartment();
                $count = 0;
                $total_price = 0;
                foreach( $cabinets_accessories as $cabinet_accessories ):
                    $count++;
                    $total_price+=($cabinet_accessories['CabinetsItem']['item_quantity'] * $cabinet_accessories['Item']['price']);
                    $odd_even = 'odd';
                    if( ($count % 2) == 0 ) {
                        $odd_even = 'even';
                    }
                    ?>
                    <tr class="<?php //echo $odd_even;    ?>">
                        <td><?php echo h($cabinet_accessories['Item']['item_title']); ?>&nbsp;</td>
                        <td><?php echo h($cabinet_accessories['Item']['description']); ?>&nbsp;</td>
                        <td><?php echo h($item_departments[$cabinet_accessories['Item']['item_department_id']]); ?>&nbsp;</td>
                        <td class="text-right"><?php echo h($this->Util->formatCurrency($cabinet_accessories['Item']['price'])); ?>&nbsp;</td>
                        <td class="text-center"><?php echo h($cabinet_accessories['CabinetsItem']['item_quantity']); ?>&nbsp;</td>
                        <td class="text-right"><?php echo h($this->Util->formatCurrency($cabinet_accessories['CabinetsItem']['item_quantity'] * $cabinet_accessories['Item']['price'])); ?>&nbsp;</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;"> Total Cost: </td>
                    <td><?php echo number_format($total_price, 2, '.', ''); ?></td>
                </tr>
            </tbody>
        </table>
    <?php }
    else { ?>
        <table cellpadding="0" cellspacing="0" class="table table-bordered listing" style="width: 85%;">
            <thead>
                <tr class="grid-header">
                    <th class="min-witdh"><?php echo h('Item Code'); ?></th>
                    <th class="min-witdh"><?php echo h('Description'); ?></th>
                    <th class="min-witdh"><?php echo h('Department'); ?></th>
                    <th class="min-witdh"><?php echo h('Item Cost'); ?></th>
                    <th class="min-witdh"><?php echo h('Quantity'); ?></th>
                    <th class="min-witdh"><?php echo h('Price'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <label class="text-cursor-normal">No data here</label>
                    </td>
                </tr>
            </tbody>
        </table>
<?php } ?>
</fieldset>