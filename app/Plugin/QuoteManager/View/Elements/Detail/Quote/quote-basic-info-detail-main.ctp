<?php
if( isset($modal) && $modal == "modal" ) {
    ?>
    <table class="table-form-big margin-bottom">
        <tr>
            <th><?php echo __('Quote Number'); ?>:</th>
            <td colspan="3">
                <?php echo h($quote['Quote']['quote_number']); ?>
                &nbsp;
            </td>
            <th><?php echo __('Project Name'); ?>:</th>
            <td colspan="3">
                <?php echo $this->InventoryLookup->getProjectName($quote['Quote']['project_id']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><label for="QuoteCustomerId">Customer: </label></th>
            <td colspan="2">
                <?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
            </td>
        </tr>
        <tr>
            <th rowspan="3"><?php echo __('Address'); ?>:</th>
            <td rowspan="3" colspan="3">
                <?php echo $this->InventoryLookup->address_format(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
                &nbsp;
            </td>
            <th><?php echo __('Est Shipping'); ?>:<label class="wide-width-date">(dd/mm/yyyy)</label></th>
            <td colspan="2">
                <?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><?php echo __('Sales Person'); ?>:</th>
            <td>
                <?php
                $sales = unserialize($quote['Quote']['sales_person']);
                $cnt = count($sales);
                $j = 1;
                for( $i = 0; $i < $cnt; $i++ ) {
                    $sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
                    echo $j . ". " . $sales_person['User']['first_name'] . " " . $sales_person['User']['last_name'] . "</br>";
                    $j++;
                }
                ?>
            </td>
        </tr>
    </table>
<?php }
else {
    ?>

    <div class="">
        <?php
        $quote_status = $this->InventoryLookup->QuoteStatus($quote['Quote']['id']);

        if( $edit && $quote_status != 'Review' && $quote_status != 'Approve' && $quote['Quote']['delete'] != 1 ) {
            echo $this->Html->link('Edit Quote', array( 'action' => EDIT, $quote['Quote']['id'], 'basic' ), array( 'data-target' => '#quote-basic-info-detail-main', 'class' => 'ajax-sub-content btn btn-success right' ));
            //echo $this->Html->link('Submit for Review', array('action' => 'quote_review', $quote['Quote']['id']), array('style' => 'margin-right: 20px;', 'class' => 'btn btn-success right'));
        }
//		if($quote_status == 'Review'){
//			echo $this->Html->link('Approved', array('action' => 'quote_approved', $quote['Quote']['id']), array('class' => 'btn btn-success right'));
//			echo $this->Html->link('Unlock', array('action' => 'quote_unlock', $quote['Quote']['id']), array('style' => 'margin-right: 20px;', 'class' => 'btn btn-success right'));
//		}
        ?>

        <table class="table-form-big">
            <tr>
                <th><?php echo __('Quote Number'); ?>:</th>
                <td colspan="3">
    <?php echo h($quote['Quote']['quote_number']); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Project Name'); ?>:</th>
                <td colspan="3">
    <?php echo $this->InventoryLookup->getProjectName($quote['Quote']['project_id']); ?>
                    &nbsp;
                </td>
            </tr>
            <tr>
                </td>
                <th><label for="QuoteCustomerId">Customer: </label></th>
                <td colspan="3">
    <?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
                </td>
                <th><?php echo __('Sales Person'); ?>:</th>
                <td colspan="2">
                    <?php
                    $sales = unserialize($quote['Quote']['sales_person']);
                    $cnt = count($sales);
                    $j = 1;
                    for( $i = 0; $i < $cnt; $i++ ) {
                        $sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
                        echo $j . ". " . $sales_person['User']['first_name'] . " " . $sales_person['User']['last_name'] . "</br>";
                        $j++;
                    }
                    ?>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th rowspan="3"><?php echo __('Address'); ?>:</th>
                <td rowspan="3" colspan="3">
    <?php echo $this->InventoryLookup->address_format(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
                    &nbsp;
                </td>
                <th><?php echo __('Job Detail'); ?>:</th>
                <td>
    <?php echo h($quote['Quote']['job_detail']); ?>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th><?php echo __('Est Shipping'); ?>:<label class="wide-width-date">(dd/mm/yyyy)</label></th>
                <td rowspan="3" colspan="3">
    <?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table class="table-form-big" style="margin-top: 5px;">
            <tr>
                <th style="width: 85px;"><label for="QuoteCustomerId">Skid Number: </label></th>
                <td colspan="3">
    <?php echo $quote['Quote']['skid_number']; ?>&nbsp;
                    <script>skid_no = '<?php echo $quote['Quote']['skid_number']; ?>'</script>
                    <a data-toggle="modal" style="margin-left: 5px; position: relative; top: -8px; " href='#add-project-modal'><i class='icon-exclamation-sign icon-black'></i></a>
                </td>
                <th style="width: 78px;"><?php echo __('Skid Weight'); ?>:</th>
                <td colspan="2">
    <?php echo $quote['Quote']['skid_weight']; ?>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table class="table-form-big" style="margin-top: 5px;">
            <tr>
                <th style="width: 85px;"><label>First Measure: </label></th>
                <td colspan="3">
    <?php echo $this->Util->formatDate($quote['Quote']['first_date_measure']); ?>&nbsp;
                </td>
                <th style="width: 78px;"><label>Second Measure: </label></th>
                <td colspan="2">
    <?php echo $this->Util->formatDate($quote['Quote']['second_date_measure']); ?>&nbsp;
                </td>
            </tr>
        </table>
    <!--		<table class="table-form-big" style="margin-top: 5px;">
                <tr>
    <th style="width: 85px;"><label for="QuoteCustomerId">Interior: </label></th>
    <td colspan="3">
        <?php
        if( $quote['Quote']['is_interior_melamine'] == 1 )
            echo "White Interior Melamine";
        if( $quote['Quote']['is_interior_melamine'] == 0 )
            echo "";
        ?>&nbsp;
    </td>
    </tr>
        </table>-->
    </div>

    <?php
    $total_cost = 0.00;
    if( !empty($quote['CabinetOrder']) || !empty($quote['GraniteOrder']) ) {

//    $total_cost = $this->InventoryLookup->CabinetOrderCost($quote['CabinetOrder'][0]['id']);
        ?>
        <?php
//    $total_cost = $this->InventoryLookup->GraniteOrderCost($quote['GraniteOrder'][0]['id']);
        ?>
        <?php // echo $this->element('Detail/Order/granite-order-detail', array('edit' => $edit, 'total_cost' => $total_cost)); ?>
        <?php
    }
    ?>
<?php } ?>

<div id="add-project-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>View Container</h3>
    </div>
    <div class="modal-body">
        <div class="work-order form">		
            <div style="width: 50%; height: 30px; background-color: #dedede;"><span style="padding: 5px; font-weight: bold;">Booking Container Information</span></div>
            <table class="table-form-big" width="50%">
                <tr>
                    <th style="width: 60px;">
                        <label>Shipping Date:</label>
                    </th>
                    <td>
<?php echo $this->Util->formatDate($container['Container']['ship_date']); ?>
                    </td>
                </tr>
                <tr>
                    <th style="width: 60px;">
                        <label>Shipping Company:</label>
                    </th>
                    <td>
<?php echo $container['Container']['ship_company']; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width: 60px;">
                        <label>EAD:</label>
                    </th>
                    <td>
<?php echo $this->Util->formatDate($container['Container']['ead']); ?>
                    </td>
                </tr>
            </table>

            <div style="width: 50%; height: 30px; background-color: #dedede; margin-top: 20px;"><span style="padding: 5px; font-weight: bold;">Load Container Information</span></div>
            <table class="table-form-big" width="50%">
                <tr>
                    <th style="width: 60px;">
                        <label>Container ID:</label>
                    </th>
                    <td>
<?php echo $container['Container']['container_no']; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width: 60px;">
                        <label>Received Date:</label>
                    </th>
                    <td>
<?php echo $this->Util->formatDate($container['Container']['received_date']); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>