<div style="width: 400px;">
    <h2 style="float: left; margin-right: 15px;">Production Time Setup</h2>
    <div style="float: left; width: 150px; position: relative; top: 22px;">
        <?php
        echo $this->Html->link('<i class="icon-plus icon-blue"></i> Add Production Time', array( 'controller' => 'purchase_orders', 'action' => 'production_add' ), array( 'escape' => false ));
        ?>
    </div>
</div>
<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
        <tr class="grid-header">
            <th><?php echo h('Title'); ?></th>
            <th><?php echo h('Percentage'); ?></th>
            <th class="actions"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $productions as $production ): ?>
            <tr>
                <td>
                    <?php echo h($production['GeneralSetting']['name']); ?>
                    &nbsp;
                </td>
                <td>
                    <?php echo h($production['GeneralSetting']['value'])."%"; ?>
                    &nbsp;
                </td>
                <td>
                    <?php
                    echo $this->Html->link('', array( 'controller' => 'purchase_orders', 'action' => 'production_edit', $production['GeneralSetting']['id'] ), array( 'class' => 'icon-edit' ));
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>