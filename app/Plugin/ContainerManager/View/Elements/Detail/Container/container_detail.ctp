<div style="text-align: right;">
    <?php
    echo $this->Html->link(
            '<i class="icon-print icon-black"></i> Container Preview', array( 'controller' => 'containers', 'action' => 'print_detail', $container['Container']['id'] ), array( 'class' => 'open-link', 'title' => 'Print Detail Information', "escape" => false )
    );
    ?>
</div>
<fieldset>	
    <legend><?php echo $legend; ?></legend>
    <div class="detail actions">
        <?php echo $this->Html->link('Edit', array( 'controller' => 'containers', 'action' => 'edit', $container['Container']['id'] ), array( 'class' => 'btn btn-success btn-padding', 'title' => __('Edit') )); ?>
    </div>
    <div class="detail actions" style="padding-right: 20px;">
        <?php echo $this->Html->link('Back', array( 'controller' => 'containers', 'action' => 'container_index' ), array( 'class' => 'btn btn-success btn-padding', 'title' => __('Back') )); ?>
    </div>
    <div class="work-order form">		
        <div style="width: 50%; height: 30px; background-color: #dedede;"><span style="padding: 5px; font-weight: bold;">Booking Container Information</span></div>
        <table class="table-form-big" width="50%">
            <tr>
                <th>
                    <label>Shipping Date:</label>
                </th>
                <td>
                    <?php echo $this->Util->formatDate($container['Container']['ship_date']); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Shipping Company:</label>
                </th>
                <td>
                    <?php echo $container['Container']['ship_company']; ?>
                </td>
            </tr>
            <tr>
                <th>
                    <label>ETA:</label>
                </th>
                <td>
                    <?php echo $this->Util->formatDate($container['Container']['ead']); ?>
                </td>
            </tr>
        </table>

        <div style="width: 50%; height: 30px; background-color: #dedede; margin-top: 20px;"><span style="padding: 5px; font-weight: bold;">Load Container Information</span></div>
        <table class="table-form-big" width="50%">
            <tr>
                <th>
                    <label>Container ID:</label>
                </th>
                <td>
                    <?php echo $container['Container']['container_no']; ?>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Received Date:</label>
                </th>
                <td>
                    <?php echo $this->Util->formatDate($container['Container']['received_date']); ?>
                </td>
            </tr>
        </table>
    </div>
</fieldset>

<table style="width: 50%; margin-top: 20px;" cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
        <tr class="grid-header">			
            <th><?php echo 'Skid Number'; ?></th>
            <th><?php echo 'Weight'; ?></th>
            <th style="width: 180px;"><?php echo 'Work Order Number'; ?></th>
            <th class="actions"><?php echo 'Label'; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_weight = 0;
        foreach( $container['ContainerSkid'] as $con ):
            ?>
            <tr>
                <td><?php echo $con['skid_no']; ?>&nbsp;</td>
                <td style="text-align: right;"> <?php echo $con['weight']; ?>&nbsp;</td>
                <td style="width: 180px;"> <?php echo $con['work_order_number']; ?>&nbsp;</td>
                <?php
                $total_weight += $con['weight'];
                ?>

                <td class="actions">
                    <?php echo $this->Html->link('', array( 'action' => "print_skid_label", $con['skid_no'] ), array( 'class' => 'open-link icon-file', 'title' => __('Skid Label') )); ?>
                </td>
            </tr>
<?php endforeach; ?>
        <tr>
            <td>&nbsp;</td>
            <td style="text-align: right;"><b>Total:</b> <?php echo $total_weight; ?></td>
            <td style="width: 180px;">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>

<style type="text/css">
    .table-form-big th{
        width: 120px;
    }
</style>