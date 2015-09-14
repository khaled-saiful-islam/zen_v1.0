<?php
$report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_cab_parts');
$report_items = array( );
$report_resource_cabinets = array( );
$report_resource_items = array( );
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

                if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                    foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                        if( isset($all_items[$cabinet_item['item_id']]) ) {
                            $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                        }
                        else {
                            $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                            $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                        }
                        if( isset($report_resource_cabinets["{$cabinet_order['resource_type']}|{$cabinet_order['id']}"]['Item'][$cabinet_item['item_id']]) ) {
                            $report_resource_cabinets["{$cabinet_order['resource_type']}|{$cabinet_order['id']}"]['Item'][$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                        }
                        else {
                            $report_resource_cabinets["{$cabinet_order['resource_type']}|{$cabinet_order['id']}"]['Item'][$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                            $report_resource_cabinets["{$cabinet_order['resource_type']}|{$cabinet_order['id']}"]['Item'][$cabinet_item['item_id']]['id'] = $cabinet_item['item_id'];
                            $report_resource_cabinets["{$cabinet_order['resource_type']}|{$cabinet_order['id']}"]['detail'] = $cabinet_order;
                            $report_resource_cabinets["{$cabinet_order['resource_type']}|{$cabinet_order['id']}"]['Cabinet-Detail'] = $resource_detail['Cabinet'];
                        }
                    }
                }
                break;
            case 'item':
                $resource_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
                if( isset($report_resource_items["{$cabinet_order['resource_type']}|{$cabinet_order['resource_id']}"]['Item'][$cabinet_order['resource_id']]) ) {
                    $report_resource_items["{$cabinet_order['resource_type']}|{$cabinet_order['resource_id']}"]['Item'][$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                }
                else {
                    $report_resource_items["{$cabinet_order['resource_type']}|{$cabinet_order['resource_id']}"]['Item'][$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                    $report_resource_items["{$cabinet_order['resource_type']}|{$cabinet_order['resource_id']}"]['Item'][$cabinet_order['resource_id']]['id'] = $cabinet_item['item_id'];
                    $report_resource_items["{$cabinet_order['resource_type']}|{$cabinet_order['resource_id']}"]['detail'] = $cabinet_order;
                    $report_resource_items["{$cabinet_order['resource_type']}|{$cabinet_order['resource_id']}"]['Item-Detail'] = $resource_detail['Item'];
                }
                break;

            default:
                break;
        }
    }

    $resources = $item->find('all', array( 'conditions' => array( 'Item.id' => $all_items_list, 'Item.item_department_id' => $report_department_list ), 'order' => array( 'Item.item_title' ) ));
    foreach( $resources as $item_detail ) {
        $report_items[$item_detail['Item']['id']] = array(
            'id' => $item_detail['Item']['id'],
            'department_id' => $item_detail['Item']['item_department_id'],
            'number' => $item_detail['Item']['number'],
            'description' => $item_detail['Item']['description'],
            'code' => $item_detail['Item']['item_title'],
            'item_material' => $item_detail['Item']['item_material'],
            'width' => $item_detail['Item']['width'],
            'length' => $item_detail['Item']['length'],
            'quantity' => $all_items[$item_detail['Item']['id']]['item_quantity'],
        );
    }
}

$report_cab_count = 0;
$next_page = count($report_resource_cabinets);
foreach( $report_resource_cabinets as $cabinet ) {
    $report_cab_count++;
    $cab_pack = str_pad($report_cab_count, 2, "0", STR_PAD_LEFT);
    $upc_code_num = $bar_code_number . $cab_pack;
    $check_num = $this->InventoryLookup->barCodeCheckNum($upc_code_num);
    $final_bar_code = $upc_code_num . $check_num;
    ?>
    <div class="quotes report-print" style="top: -55px;">
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <?php $bar_code = $this->InventoryLookup->barCodeImageGenerator($final_bar_code); ?>
            <img src="<?php echo $this->Html->url('/', true); ?>img/<?php echo $bar_code; ?>">
        </div>
        <div style="clear: both;"></div>

        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle . ':' . $report_cab_count; ?> &nbsp;&nbsp;<?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>

            <!--			<div style="width: 100%; border-bottom: 1px dashed #acacac;"></div>-->
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

            <div class="tab-content">
                <fieldset id="quote-basic-info-detail" class="sub-content-detail">
                    <table style="border-bottom: 1px dashed #acacac; border-top: 1px dashed #acacac;">
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
                                        <th>Started Date:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Cabinet Color:</th>
                                        <td>
                                            <?php echo h($this->InventoryLookup->ColorCode2ID($cabinet['detail']['cabinet_color'], TRUE)); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
                                            <?php echo h($this->InventoryLookup->DoorStyle2ID($cabinet['detail']['door_id'], TRUE)); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
                                            <?php echo h($this->InventoryLookup->ColorCode2ID($cabinet['detail']['cabinet_color'], TRUE)); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <div style="font-size: 18px; margin-top: 20px; margin-bottom: 20px; font-weight: bold; text-decoration: underline;">
                    Parts Listing For: <?php echo $cabinet['Cabinet-Detail']['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cabinet['Cabinet-Detail']['description']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cabinet['detail']['door_side']; ?>
                </div>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div class="cabinet-list">
                        <table id="cabinet-list" class="cabinet-list table-report-listing">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center small">Width X Length</th>
                                    <th class="text-center small">Edge Tape</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cabinet_items = array_intersect_key($report_items, $cabinet['Item']);
                                if( !empty($cabinet_items) ) {
                                    foreach( $cabinet_items as $cabinet_item ) {
                                        if( isset($report_items[$cabinet_item['id']]) ) {
                                            $report_item = $report_items[$cabinet_item['id']];
                                            ?>
                                            <tr>
                                                <td class="text-left quantity"><?php echo $cabinet['Item'][$cabinet_item['id']]['item_quantity']; ?></td>
                                                <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                                <td class="text-left"><?php echo $report_item['description']; ?></td>
                                                <td class="text-center small"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                                <td class="text-center small">
                                                    <?php
                                                    $edge =  $this->InventoryLookup->getEdgeTapeForCabParts($report_item['id'], $report_item['code']);
                                                    if(!empty($edge)){
                                                        echo $edge;
                                                    }
                                                    else {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                else {
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="5">There is no cabinet parts</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                <div style="font-size: 14px; margin-top: 20px; margin-bottom: 10px;">
                    <p style="margin-bottom: 0px; text-decoration: underline;"><b>Cabinet Door/Drawer Info:</b></p>
                    <?php if( $cabinet['Cabinet-Detail']['top_door_count'] > 0 ) { ?>
                        <?php echo $cabinet['Cabinet-Detail']['top_door_count']; ?>&nbsp;Top Door&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['top_door_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['top_door_height'] . ")"; ?></br>
                    <?php } ?>

                    <?php if( $cabinet['Cabinet-Detail']['bottom_door_count'] > 0 ) { ?>
                        <?php echo $cabinet['Cabinet-Detail']['bottom_door_count']; ?>&nbsp;Bottom Door&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['bottom_door_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['bottom_door_height'] . ")"; ?></br>
                    <?php } ?>

                    <?php if( $cabinet['Cabinet-Detail']['top_drawer_front_count'] > 0 ) { ?>
                        <?php echo $cabinet['Cabinet-Detail']['top_drawer_front_count']; ?>&nbsp;Top Drawer Front&nbsp;&<?php echo "(" . $cabinet['Cabinet-Detail']['top_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['top_drawer_front_height'] . ")"; ?></br>
                    <?php } ?>

                    <?php if( $cabinet['Cabinet-Detail']['middle_drawer_front_count'] > 0 ) { ?>
                        <?php echo $cabinet['Cabinet-Detail']['middle_drawer_front_count']; ?>&nbsp;Middle Drawer Front&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['middle_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['middle_drawer_front_height'] . ")"; ?></br>
                    <?php } ?>

                    <?php if( $cabinet['Cabinet-Detail']['bottom_drawer_front_count'] > 0 ) { ?>
                        <?php echo $cabinet['Cabinet-Detail']['bottom_drawer_front_count']; ?>&nbsp;Bottom Drawer Front&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['bottom_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['bottom_drawer_front_height'] . ")"; ?></br>
                    <?php } ?>

                    <?php if( $cabinet['Cabinet-Detail']['dummy_drawer_front_count'] > 0 ) { ?>
                        <?php echo $cabinet['Cabinet-Detail']['dummy_drawer_front_count']; ?>&nbsp;Dummy Drawer Front&nbsp;&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['dummy_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['dummy_drawer_front_height'] . ")"; ?></br>
                    <?php } ?>
                </div>

                <div style="font-size: 14px; margin-top: 15px;margin-bottom: 10px;">
                    <p style="margin-bottom: 0px; text-decoration: underline;"><b>Drawer Boxes:</b></p>
                    <?php
                    foreach( $cabinet['Item'] as $key => $value ) {
                        $drawer_box_detail = $this->InventoryLookup->ItemDetailForDrawerBox($key);
                        if( $drawer_box_detail['Item']['Department'] == 'Drawer Box' ) {
                            echo $value['item_quantity'] . "&nbsp;" . $drawer_box_detail['Item']['item_title'] . "&nbsp;" . "(" . $drawer_box_detail['Item']['width'] . " X " . $drawer_box_detail['Item']['length'] . ")" . "<br/>";
                        }
                    }
                    ?>
                </div>
            </div>

        </fieldset>
    </div>
    <div class="page-break"></div>
    <?php if( $report_cab_count < $next_page ) { ?>
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
}
?>