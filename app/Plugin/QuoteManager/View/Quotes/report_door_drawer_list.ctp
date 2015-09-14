<?php
$check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number);
$final_bar_code = $bar_code_number . $check_num;

$report_items = array( );
$all_items = array( );
$all_items_list = array( );
if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
    App::import("Model", "Inventory.Cabinet");
    App::import("Model", "Inventory.Item");

    $cabinet = new Cabinet();
    $item = new Item();
    $item->recursive = -1;

    foreach( $quote['CabinetOrder'] as $cabinet_order ) {
        if( $cabinet_order['temporary_delete'] ) {
            continue; // skip the (temporarily) deleted one
        }
        $resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
        switch( $cabinet_order['resource_type'] ) {
            case 'cabinet':
                $resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));

                // if and only if it has door style selected (without no-door)
                if( !is_null($cabinet_order['door_id']) && !empty($cabinet_order['door_id']) && ($cabinet_order['door_id'] != 13) ) {
                    $cabinet_detail = $resource_detail['Cabinet'];

                    $this->InventoryLookup->door_drawer_report($report_items, $cabinet_order, $cabinet_detail['top_door_count'], $cabinet_order['door_id'], $cabinet_detail['top_door_width'], $cabinet_detail['top_door_height'], $cabinet_order['quantity'], false);
                    $this->InventoryLookup->door_drawer_report($report_items, $cabinet_order, $cabinet_detail['bottom_door_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_door_width'], $cabinet_detail['bottom_door_width'], $cabinet_order['quantity'], false);
                    $this->InventoryLookup->door_drawer_report($report_items, $cabinet_order, $cabinet_detail['top_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['top_drawer_front_width'], $cabinet_detail['top_drawer_front_height'], $cabinet_order['quantity'], true);
                    $this->InventoryLookup->door_drawer_report($report_items, $cabinet_order, $cabinet_detail['middle_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['middle_drawer_front_width'], $cabinet_detail['middle_drawer_front_height'], $cabinet_order['quantity'], true);
                    $this->InventoryLookup->door_drawer_report($report_items, $cabinet_order, $cabinet_detail['bottom_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_drawer_front_width'], $cabinet_detail['bottom_drawer_front_height'], $cabinet_order['quantity'], true);
                    $this->InventoryLookup->door_drawer_report($report_items, $cabinet_order, $cabinet_detail['dummy_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['dummy_drawer_front_width'], $cabinet_detail['dummy_drawer_front_height'], $cabinet_order['quantity'], true);
                }
                $report_items2 = array( );
                if( !empty($report_items) ) {
                    foreach( $report_items as $index => $value ) {
                        $report_items2[$value['door_style']][$index] = $value;
                    }
                }
                break;

            default:
                break;
        }
    }
}
$index_count = 1;
foreach( $report_items2 as $key => $v ) {
    $dynamic_door_style_id[$index_count] = $key;
    $index_count++;
}
$z = 1;
if( !empty($report_items2) ) {
    foreach( $report_items2 as $ri ) {
        ?>

        <div class="quotes report-print" style="top: -55px;">
            <?php
            $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_door_drawer_list');
            ?>
            <div style="float: right; position: relative; top: -70px; left: 20px;">
                <?php $bar_code = $this->InventoryLookup->barCodeImageGenerator($final_bar_code); ?>
                <img src="<?php echo $this->Html->url('/', true); ?>img/<?php echo $bar_code; ?>">
            </div>
            <div style="clear: both;"></div>

            <fieldset style="position: relative; top: -65px;">
                <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>		

                <div style="font-size: 15px; float: right; position: relative; top: -20px; color: #7f7c7c; font-weight: bold; word-spacing: 4px;">
                    <?php
                    if( isset($reportDate) ) {
                        if( is_int($reportDate) ) {
                            echo h(date('D, M jS, Y - h:i a', $reportDate));
                        }
                        else {
                            echo h($reportDate);
                        }
                    }
                    ?>
                </div>
                <div style="clear: both;"></div>
                <div class="tab-content" style="margin-bottom: 25px;">
                    <fieldset id="quote-basic-info-detail" class="sub-content-detail">
                        <table style="border-bottom: 1px dashed #acacac; border-top: 1px dashed #acacac!important;">
                            <tr>
                                <td>
                                    <table class="table-report-compact" style="width: 98%!important;">
                                        <tr>
                                            <th style="font-size: 18px!important; font-weight: bold!important;" class="text-left">Customer</th>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table class="table-report-compact table_new_design" style="position: relative; left: 20px; width: 95%!important;">
                                        <tr>
                                            <th>Name: </th>
                                            <td>
                                                <?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo __('Address'); ?>:</th>
                                            <td>
                                                <?php echo $this->InventoryLookup->address_format(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
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
                                                    echo $j . ". " . $sales_person['User']['first_name'] . " " . $sales_person['User']['last_name'] . "</br></br>";
                                                    $j++;
                                                }
                                                ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo __('Ship Date'); ?>:</th>
                                            <td>
                                                <?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="border-left: 1px dashed #acacac;">
                                    <table class="table-report-compact table_new_design" style="float: right; min-height: 168px;">
                                        <tr>
                                            <th>Door Style:</th>
                                            <td>
                                                <?php echo "<span style='font-size: 16px; font-weight: bold;'>" . $dynamic_door_style_id[$z] . "</span>"; ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>				
                    </fieldset>
                    <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                        <div class="sub-section">
                            <table>
                                <tr>
                                    <td>
                                        <table class="table-report-compact no-border" style="margin-top: 10px;">
                                            <tr>
                                                <td style="font-size: 18px; font-weight: bold; text-decoration: underline;" colspan="2">Door &amp; Drawer List</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table-report-compact_image no-border" style="float: right; height: 50px; margin-top: 10px;">
                                            <tr>
                                                <td style="border: #000 groove medium;">Image N/A</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="cabinet-list">
                            <table id="cabinet-list" class="cabinet-list table-report-listing">
                                <thead>
                                    <tr class="dashed-underline">
                                        <th class="text-left quantity">Qty</th>
                                        <th class="small text-center">W X H</th>
                        <!--                <th style="display: block; width: 110px;" class="text-left">Door Style</th>-->
                                        <th style="width: 100px;" class="text-left">Description</th>
                                        <th class="text-left">Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if( !empty($ri) ) {
                                        foreach( $ri as $report_item ) {
                                            ?>
                                            <tr>
                                                <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                                <td class="small text-center"><?php echo "{$report_item['width']} X {$report_item['height']}"; ?></td>
                            <!--                    <td style="min-width: 215px; width: 77px; display: block;" class="text-left"><?php echo $report_item['door_style']; ?></td>-->
                                                <td style="min-width: 119px;" class="text-left"><?php echo $report_item['description']; ?></td>
                                                <td style="min-width: 60px;" class="text-left"><?php echo $report_item['code']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        ?>
                                        <tr>
                                            <td class="text-center" colspan="6">There is no door/drawer</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </fieldset>
        </div>		

        <!--		                 /*Page Break*/                             -->

        <div class="page-break"></div>
        <?php if( isset($dynamic_door_style_id[$z + 1]) ) { ?>
            <div class="header hide-in-screen">
                <div class="header-left">
                    <div class="logo logo_report" style="position: relative; z-index: 999;">
                        <?php
                        echo $this->Html->image('header_logo.png');
                        ?>
                    </div>
                    <div class="address">
                        <span style="display: block;">2790 32nd Avenue N.E.</span><br/>
                        <span style="display: block; margin-top: -8px;">Calgary, AB T1Y 5S5</span><br/>
                        <span style="display: block; margin-top: -8px;">Phone: 403-7201928</span><br/>
                    </div>
                </div>
                <div class="header-right">
                    <span class="report-number">
                        <?php if( isset($reportNumber) ) echo h($reportNumber); ?>
                    </span>
                    <br/>
                </div>
            </div>
            <?php
        }
        $z++;
    }
}
else {
    ?>
    <div class="quotes report-print" style="top: -55px;">
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <?php $bar_code = $this->InventoryLookup->barCodeImageGenerator($final_bar_code); ?>
            <img src="<?php echo $this->Html->url('/', true); ?>img/<?php echo $bar_code; ?>">
        </div>
        <div style="clear: both;"></div>
        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>		

            <div style="font-size: 15px; float: right; position: relative; top: -20px; color: #7f7c7c; font-weight: bold; word-spacing: 4px;">
                <?php
                if( isset($reportDate) ) {
                    if( is_int($reportDate) ) {
                        echo h(date('D, M jS, Y - h:i a', $reportDate));
                    }
                    else {
                        echo h($reportDate);
                    }
                }
                ?>
            </div>
            <div style="clear: both;"></div>
            <div class="tab-content" style="margin-bottom: 25px;">
                <fieldset id="quote-basic-info-detail" class="sub-content-detail">
                    <table style="border-bottom: 1px dashed #acacac; border-top: 1px dashed #acacac!important;">
                        <tr>
                            <td>
                                <table class="table-report-compact" style="width: 98%!important;">
                                    <tr>
                                        <th style="font-size: 18px!important; font-weight: bold!important;" class="text-left">Customer</th>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                <table class="table-report-compact table_new_design" style="position: relative; left: 20px; width: 95%!important;">
                                    <tr>
                                        <th>Name: </th>
                                        <td>
                                            <?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Address'); ?>:</th>
                                        <td>
                                            <?php echo $this->InventoryLookup->address_format(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
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
                                                echo $j . ". " . $sales_person['User']['first_name'] . " " . $sales_person['User']['last_name'] . "</br></br>";
                                                $j++;
                                            }
                                            ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Ship Date'); ?>:</th>
                                        <td>
                                            <?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: 1px dashed #acacac;">
                                <table class="table-report-compact table_new_design" style="float: right; min-height: 168px;">
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>				
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div class="sub-section">
                        <table>
                            <tr>
                                <td>
                                    <table class="table-report-compact no-border" style="margin-top: 10px;">
                                        <tr>
                                            <td style="font-size: 18px; font-weight: bold; text-decoration: underline;" colspan="2">Door &amp; Drawer List</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table class="table-report-compact_image no-border" style="float: right; height: 50px; margin-top: 10px;">
                                        <tr>
                                            <td style="border: #000 groove medium;">Image N/A</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="cabinet-list">
                        <table id="cabinet-list" class="cabinet-list table-report-listing">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="small text-center">W X H</th>
                                    <th style="width: 100px;" class="text-left">Description</th>
                                    <th class="text-left">Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if( !empty($ri) ) {
                                    foreach( $ri as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="small text-center"><?php echo "{$report_item['width']} X {$report_item['height']}"; ?></td>
                                            <td style="min-width: 119px;" class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td style="min-width: 60px;" class="text-left"><?php echo $report_item['code']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else {
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="6">There is no door/drawer</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </fieldset>
    </div>
    <?php
}
?>
