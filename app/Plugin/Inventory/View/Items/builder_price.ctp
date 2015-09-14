<?php
if( $paginate ) {
    ?>
    <div class="items index">
        <fieldset class="content-detail">
            <legend><?php echo __($legend); ?></legend>
            <div id="search_div-open">
                <?php echo $this->Form->create('Item', array( 'url' => array_merge(array( 'action' => 'builder_price' ), $this->params['pass']), 'inputDefaults' => array( 'label' => false, 'div' => false ) )); ?>
                <table class="table-form-big search_div">
                    <tr>
                        <td>
                            <?php echo "<div class=''>Item Number</div>" . $this->Form->input('number', array( 'placeholder' => 'Item Number' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Item Code</div>" . $this->Form->input('item_title', array( 'placeholder' => 'Item Code', 'empty' => true, 'class' => 'form-select select-item-group' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Supplier Name</div>" . $this->Form->input('supplier_id', array( 'placeholder' => 'Supplier Name', 'options' => $this->InventoryLookup->Supplier(), 'empty' => true, 'class' => 'form-select select-item-group' )); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->submit(__('Search'), array( 'class' => 'btn btn-success item_submit', 'style' => 'position: relative; bottom: 5px;' )); ?>
                        </td>
                    </tr>
                </table>
                <?php echo $this->Form->end(); ?>
            </div>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
                <thead>
                    <tr class="grid-header">
                        <th class="min-width"><?php echo $this->Paginator->sort('number'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('item_title', 'Item Code'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('item_cost'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('price'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('builder_price'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('supplier_id'); ?></th>
                        <th class="actions"><?php echo __(''); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach( $items as $item ):
                        $count++;
                        ?>
                        <tr>
                            <td><?php echo h($item['Item']['number']); ?>&nbsp;</td>
                            <td><?php echo h($item['Item']['item_title']); ?>&nbsp;</td>
                            <td><?php echo h($item['Item']['item_cost']); ?>&nbsp;</td>
                            <td><?php echo h($item['Item']['price']); ?>&nbsp;</td>
                            <td><?php echo h($item['Item']['builder_price']); ?>&nbsp;</td>
                            <td>
                                <?php echo $this->Html->link(h($item['Supplier']['name']), array( 'plugin' => 'inventory', 'controller' => 'suppliers', 'action' => DETAIL, $item['Supplier']['id'], 'modal' ), array( 'title' => __($item['Supplier']['name']), 'class' => 'table-first-column-color show-tooltip show-detail-ajax-modal' )); ?>
                                &nbsp;
                            </td>                            
                            <td class="actions">
                                <?php echo $this->Html->link('', array( 'action' => 'edit_builder_price', $item['Item']['id'] ), array( 'class' => 'icon-edit show-tooltip', 'title' => __('Edit Builder Price') )); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </fieldset>
        <?php echo $this->element('Common/paginator'); ?>
    </div>
<?php } ?>