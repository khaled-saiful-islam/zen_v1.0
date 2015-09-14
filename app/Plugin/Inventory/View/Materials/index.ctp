<?php
if( $paginate ) {
    ?>
    <div class="items index">
        <fieldset class="content-detail">
            <legend>
                <?php echo __($legend); ?>
            </legend>
            <div align="right">
                <a class="search_link" href="#">
                    <span class="search-img">Search</span>
                </a>
            </div>
            <div id="search_div">
                <?php echo $this->Form->create('Material', array( 'url' => array_merge(array( 'action' => 'index' ), $this->params['pass']), 'inputDefaults' => array( 'label' => false, 'div' => false ) )); ?>
                <table class="table-form-big search_div">
                    <tr>
                        <td>
                            <?php echo "<div class=''>Name</div>" . $this->Form->input('name', array( 'class' => 'input-medium', 'placeholder' => 'Name' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Code</div>" . $this->Form->input('code', array( 'class' => 'input-small', 'placeholder' => 'Code' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Width</div>" . $this->Form->input('width', array( 'class' => 'input-small', 'placeholder' => 'Width' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Length</div>" . $this->Form->input('length', array( 'class' => 'input-small', 'placeholder' => 'Length' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Cost</div>" . $this->Form->input('cost', array( 'class' => 'input-small', 'placeholder' => 'Cost' )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "<div class=''>Material group</div>" . $this->Form->input('material_group_id', array( 'options' => $this->InventoryLookup->getMaterialGroup(), 'class' => 'input-medium form-select', 'empty' => true )); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->submit(__('Search'), array( 'class' => 'btn btn-success item_submit' )); ?>
                        </td>
                    </tr>
                </table>
                <?php echo $this->Form->end(); ?>
            </div>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
                <thead>
                    <tr class="grid-header">
                        <th class="min-width"><?php echo $this->Paginator->sort('name'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('code'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('width'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('length'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('cost'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('markup'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('price'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('material_group_id'); ?></th>
                        <th class="actions"><?php echo __(''); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach( $materials as $material ):
                        $count++;
                        ?>
                        <tr class="<?php //echo $odd_even;     ?>">
                            <td><?php echo h($material['Material']['name']); ?>&nbsp;</td>
                            <td><?php echo h($material['Material']['code']); ?>&nbsp;</td>
                            <td><?php echo h($material['Material']['width']); ?>&nbsp;</td>
                            <td><?php echo h($material['Material']['length']); ?>&nbsp;</td>
                            <td><?php echo h($material['Material']['cost']); ?>&nbsp;</td>
                            <td><?php echo h($material['Material']['markup']); ?>&nbsp;</td>
                            <td><?php echo h($material['Material']['price']); ?>&nbsp;</td>
                            <td><?php echo h($this->InventoryLookup->findMaterialGroup($material['Material']['material_group_id']));
                ;
                        ?>&nbsp;</td>

                            <td class="actions">
                                <?php echo $this->Html->link('', array( 'action' => DETAIL, $material['Material']['id'] ), array( 'class' => 'icon-folder-open show-tooltip', 'title' => __('View') )); ?>
                                <?php echo $this->Form->postLink('', array('action' => DELETE, $material['Material']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $material['Material']['id']));   ?>
                            </td>
                        </tr>
    <?php endforeach; ?>
                </tbody>
            </table>

        </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
    </div>
<?php }else { ?>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing items-report-table">
        <thead>
            <tr class="grid-header">
                <th><?php echo h('Name'); ?></th>
                <th><?php echo h('Code'); ?></th>
                <th><?php echo h('Width'); ?></th>
                <th><?php echo h('Length'); ?></th>
                <th><?php echo h('Cost'); ?></th>
                <th><?php echo h('Markup'); ?></th>
                <th><?php echo h('Price'); ?></th>
                <th><?php echo h('Material Group'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach( $materialgroups as $materialgroup ):
                $count++;
                ?>
                <tr class="<?php //echo $odd_even;     ?>">
                    <td><?php echo h($material['Material']['name']); ?>&nbsp;</td>
                    <td><?php echo h($material['Material']['code']); ?>&nbsp;</td>
                    <td><?php echo h($material['Material']['width']); ?>&nbsp;</td>
                    <td><?php echo h($material['Material']['length']); ?>&nbsp;</td>
                    <td class="text-right"><?php echo $this->Util->formatCurrency($material['Material']['cost']); ?>&nbsp;</td>
                    <td><?php echo h($material['Material']['markup']); ?>&nbsp;</td>
                    <td class="text-right"><?php echo $this->Util->formatCurrency($material['Material']['price']); ?>&nbsp;</td>
                    <td><?php echo h($material['Material']['material_group_id']); ?>&nbsp;</td>
                </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
<style type="text/css">
    table.table-form-big tr td{
        width: 100px!important
    }
</style>