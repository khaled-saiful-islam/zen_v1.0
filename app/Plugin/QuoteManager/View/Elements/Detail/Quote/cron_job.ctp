<?php
ob_start();

echo $this->Html->css('style' ,true); 
echo $this->Html->css('report', true);
?>
<page>
<?php
foreach( $work_order as $wo ) {

    $quote = $this->InventoryLookup->getQuoteForCornJob($wo['WorkOrder']['quote_id']);
    $quote_status = $this->InventoryLookup->getQuoteStatusForCornJob($wo['WorkOrder']['quote_id']);

    $reportTitle1 = "CabPack";
    $reportTitle2 = "Panel List";
    $reportTitle3 = "Hardware";
    $reportTitle4 = "Cabinet Backs";
    $reportTitle5 = "Shelf List";
    $reportTitle6 = "Drawer List";
    $reportTitle7 = "Wood Drawer Box";
    $reportTitle8 = "Order Notes";
    $reportTitle9 = "Master Cabinet Parts List";
    $reportTitle10 = "Door/Drawer List";
    $reportTitle11 = "Door Manufacturing List";

    $bar_code_number1 = $wo['WorkOrder']['work_order_number'] . "002";
    $bar_code_number2 = $wo['WorkOrder']['work_order_number'] . "00400";
    $bar_code_number3 = $wo['WorkOrder']['work_order_number'] . "00199";
    $bar_code_number4 = $wo['WorkOrder']['work_order_number'] . "00600";
    $bar_code_number5 = $wo['WorkOrder']['work_order_number'] . "00800";
    $bar_code_number6 = $wo['WorkOrder']['work_order_number'] . "00500";
    $bar_code_number7 = $wo['WorkOrder']['work_order_number'] . "00700";
    $bar_code_number9 = $wo['WorkOrder']['work_order_number'] . "00200";
    $bar_code_number10 = $wo['WorkOrder']['work_order_number'] . "00300";
    $bar_code_number11 = $wo['WorkOrder']['work_order_number'] . "00777";

    $reportDate = time();
    ?>

    <!--------------------------------------------------------------Quote Detail Report Start------------------------------------------------------------------------>

    <?php echo $this->element('Detail/Quote/print_detail_corn_job', array( 'quote' => $quote, 'quote_status' => $quote_status, 'user_id' => $user_id )); ?>

    <!---------------------------------------------------------Quote Detail Report End----------------------------------------------------------------------------->

    <?php
//--------------------------------------------------CABPACK REPORT START--------------------------------------------------------//


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
        $upc_code_num = $bar_code_number1 . $cab_pack;
        $check_num = $this->InventoryLookup->barCodeCheckNum($upc_code_num);
        $final_bar_code = $upc_code_num . $check_num;
        ?>
        <div class="quotes report-print" style="top: -55px;">
            <div style="float: right; position: relative; top: -70px; left: 20px;">
                <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
            </div>
            <div style="clear: both;"></div>

            <fieldset style="position: relative; top: -65px;">
                <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle1 . ':' . $report_cab_count; ?> &nbsp;&nbsp;<?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>

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
//--------------------------------------------------CABPACK REPORT END--------------------------------------------------------//
//--------------------------------------------------PANEL LIST START--------------------------------------------------------//


    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_panel_list');

    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number2);
    $final_bar_code = $bar_code_number2 . $check_num;

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

                    if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                        foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                            if( isset($all_items[$cabinet_item['item_id']]) ) {
                                $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                            }
                            else {
                                $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                            }
                        }
                    }
                    break;
                case 'item':
                    if( isset($all_items[$cabinet_order['resource_id']]) ) {
                        $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                    }
                    else {
                        $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                        $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
                    }
                    break;

                default:
                    break;
            }
        }

//                $resources = $item->find('all', array('conditions' => array('Item.id' => $all_items_list, 'Item.item_department_id' => $report_department_list), 'order' => array('Item.item_title')));
        $resources = $item->find('all', array( 'conditions' => array( 'Item.id' => $all_items_list ), 'order' => array( 'Item.item_title' ) ));
        foreach( $resources as $item_detail ) {
            if( in_array($item_detail['Item']['item_department_id'], $report_department_list) || (!is_null($item_detail['Item']['item_material']) || !empty($item_detail['Item']['item_material'])) ) {  // check if it is in valid department or no-standared material
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
    }
    $report_items2 = array( );
    if( !empty($report_items) ) {
        foreach( $report_items as $index => $value ) {
            $report_items2[$value['item_material']][$index] = $value;
        }
    }
//			pr($report_items2);
    $index_count = 1;
    foreach( $report_items2 as $key => $v ) {
        $dynamic_item_material_id[$index_count] = $key;
        $index_count++;
    }

    $z = 1;
    foreach( $report_items2 as $ri ) {
        ?>
        <div class="quotes report-print" style="top: -55px;">
            <div style="float: right; position: relative; top: -70px; left: 20px;">
                <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
            </div>
            <div style="clear: both;"></div>

            <fieldset style="position: relative; top: -65px;">
                <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title" style="width: 1000px; border-bottom-color: #fff;" class="text-right sub-title"><?php echo $reportTitle2; ?> For <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
                                            <th>Item Material:</th>
                                            <td>
                                                <?php
                                                $material_data = $this->InventoryLookup->getItemMaterialForReport($dynamic_item_material_id[$z]);
                                                if( !empty($material_data['MaterialGroup']) )
                                                    echo "<span style='font-size: 16px; font-weight: bold;'>" . $material_data['MaterialGroup']['name'] . "</span>";
                                                else {
                                                    echo "<span style='font-size: 16px; font-weight: bold;'>" . "None" . "</span>";
                                                }
                                                ?>
                                                &nbsp;
                                            </td>
                                        </tr>								
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                        <div style="margin-top: 20px;" class="cabinet-list">
                            <div style="font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 10px;">Panel List</div>
                            <table id="cabinet-list" class="cabinet-list" style="min-width: 600px;">
                                <thead>
                                    <tr class="dashed-underline">
                                        <th class="text-left quantity">Qty</th>
                                        <th class="text-left small">Code</th>
                                        <th class="text-left">Description</th>
                                        <th class="text-center semi">Width X Length</th>
                                    </tr>
                                </thead>
                                <tbody>
        <?php
        if( !empty($ri) ) {
            foreach( $ri as $report_item ) {
                ?>
                                            <tr>
                                                <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                                <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                                <td class="text-left"><?php echo $report_item['description']; ?></td>
                                                <td class="text-center semi"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        ?>
                                        <tr>
                                            <td class="text-center" colspan="5">There is no panel</td>
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
        <?php if( isset($dynamic_item_material_id[$z + 1]) ) { ?>
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
            } $z++;
        }
//--------------------------------------------------PANEL LIST END--------------------------------------------------------//
//--------------------------------------------------HARDWARE START--------------------------------------------------------//

        $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number3);
        $final_bar_code = $bar_code_number3 . $check_num;
        ?>
    <div class="quotes report-print" style="top: -55px;">
                <?php
                $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_hardware');
                ?>
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
        </div>
        <div style="clear: both;"></div>
        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle3; ?> For <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="margin-top: 20px;" class="cabinet-list">
                        <table id="cabinet-list" class="cabinet-list" style="min-width: 600px;">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-left small">UPC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

                                                if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                                                    foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                                                        if( isset($all_items[$cabinet_item['item_id']]) ) {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                                                        }
                                                        else {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                                            $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'item':
                                                if( isset($all_items[$cabinet_order['resource_id']]) ) {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                                                }
                                                else {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                                                    $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
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

                                if( !empty($report_items) ) {
                                    foreach( $report_items as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td class="text-left small">N/A</td>
                                        </tr>
            <?php
        }
    }
    else {
        ?>
                                    <tr>
                                        <td class="text-center" colspan="5">There is no hardware</td>
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
//--------------------------------------------------HARDWARE END--------------------------------------------------------//
//--------------------------------------------------CABINET BACKS START--------------------------------------------------------//

    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number4);
    $final_bar_code = $bar_code_number4 . $check_num;
    ?>
    <div class="quotes report-print" style="top: -55px;">
                <?php
                $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_cabinet_backs_list');
                ?>
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
        </div>
        <div style="clear: both;"></div>
        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle4; ?> <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
                                            <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="margin-top: 15px;" class="cabinet-list">
                        <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px; text-decoration: underline;">Cabinet Backs</div>
                        <table id="cabinet-list" class="cabinet-list table-report-listing">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center small">Width X Length</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

                                                if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                                                    foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                                                        if( isset($all_items[$cabinet_item['item_id']]) ) {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                                                        }
                                                        else {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                                            $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'item':
                                                if( isset($all_items[$cabinet_order['resource_id']]) ) {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                                                }
                                                else {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                                                    $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
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

                                if( !empty($report_items) ) {
                                    foreach( $report_items as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td class="text-center small"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                        </tr>
            <?php
        }
    }
    else {
        ?>
                                    <tr>
                                        <td class="text-center" colspan="6">There is no cabinet backs</td>
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
//--------------------------------------------------CABINET BACKS END--------------------------------------------------------//
//--------------------------------------------------CABINET SHELFS START--------------------------------------------------------//

    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number5);
    $final_bar_code = $bar_code_number5 . $check_num;
    ?>
    <div class="quotes report-print" style="top: -55px;">
                <?php
                $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_cabinet_shelf_list');
                ?>
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
        </div>
        <div style="clear: both;"></div>

        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle5; ?> For <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="margin-top: 15px;" class="cabinet-list">
                        <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px; text-decoration: underline;">Cabinet Shelfs</div>
                        <table id="cabinet-list" class="cabinet-list table-report-listing">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center small">Width X Length</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

                                                if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                                                    foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                                                        if( isset($all_items[$cabinet_item['item_id']]) ) {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                                                        }
                                                        else {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                                            $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'item':
                                                if( isset($all_items[$cabinet_order['resource_id']]) ) {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                                                }
                                                else {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                                                    $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
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

                                if( !empty($report_items) ) {
                                    foreach( $report_items as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td class="text-center small"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                        </tr>
            <?php
        }
    }
    else {
        ?>
                                    <tr>
                                        <td class="text-center" colspan="6">There is no shelf</td>
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
//--------------------------------------------------CABINET SHELFS END--------------------------------------------------------//
//--------------------------------------------------DRAWER BOX START--------------------------------------------------------//

    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number6);
    $final_bar_code = $bar_code_number6 . $check_num;

    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_drawer_box_list');
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

                    if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                        foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                            if( isset($all_items[$cabinet_item['item_id']]) ) {
                                $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                            }
                            else {
                                $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                            }
                        }
                    }
                    break;
                case 'item':
                    if( isset($all_items[$cabinet_order['resource_id']]) ) {
                        $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                    }
                    else {
                        $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                        $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
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
    ?>

    <div class="quotes report-print" style="top: -55px;">

        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
        </div>
        <div style="clear: both;"></div>
        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo!empty($report_items) ? $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer']) : "Drawer List" ?> For <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="font-size: 18px; margin-bottom: 20px; margin-top: 10px; font-weight: bold; text-decoration: underline;" class="sub-section">
                        Wood Drawer Box - <?php echo h($this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer'])); ?>
                    </div>
                    <div class="cabinet-list">
                        <table id="cabinet-list" class="cabinet-list table-report-listing" style="min-width: 600px;">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center small">Width X Length</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    if( !empty($report_items) ) {
        foreach( $report_items as $report_item ) {
            ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td class="text-center small"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                        </tr>
            <?php
        }
    }
    else {
        ?>
                                    <tr>
                                        <td class="text-center" colspan="5">There is no drawer box</td>
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
                //--------------------------------------------------DRAWER BOX END--------------------------------------------------------//
                //--------------------------------------------------WOOD DRAWER BOX START--------------------------------------------------------//

                $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number7);
                $final_bar_code = $bar_code_number7 . $check_num;
                ?>
    <div class="quotes report-print" style="top: -55px;">
    <?php
    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_wood_drawer_box_list');
    ?>
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
        </div>
        <div style="clear: both;"></div>

        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle7; ?> <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="font-size: 18px; margin-top: 10px; margin-bottom: 10px; text-decoration: underline; font-weight: bold;" class="sub-section">
                        Wood Drawer Box - <?php echo h($this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer'])); ?>
                    </div>
                    <div style="margin-top: 20px;" class="cabinet-list">
                        <table id="cabinet-list" class="cabinet-list table-report-listing" style="min-width: 600px;">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center small">Width X Length</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

                                                if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                                                    foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                                                        if( isset($all_items[$cabinet_item['item_id']]) ) {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                                                        }
                                                        else {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                                            $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'item':
                                                if( isset($all_items[$cabinet_order['resource_id']]) ) {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                                                }
                                                else {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                                                    $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
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

                                if( !empty($report_items) ) {
                                    foreach( $report_items as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td class="text-center semi"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                        </tr>
            <?php
        }
    }
    else {
        ?>
                                    <tr>
                                        <td class="text-center" colspan="6">There is no wood drawer box</td>
                                    </tr>
            <?php
        }
        ?>
                            </tbody>
                        </table>
                <?php
                if( !empty($report_items) ) {
                    ?>
                            <h2 class="text-center red">*** <?php echo $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer']); ?> *** </h2>
                    <?php
                }
                ?>
                    </div>
                </fieldset>
            </div>

        </fieldset>
    </div>
    <?php
//--------------------------------------------------WOOD DRAWER BOX END--------------------------------------------------------//
//--------------------------------------------------ORDER NOTES START--------------------------------------------------------//
    ?>

    <div class="quotes report-print" style="top: -55px;">
    <?php
    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_order_notes');
    ?>
        <fieldset style="position: relative; ">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle8; ?> <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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

            <div class="tab-content" style="margin-bottom: 70px;">
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
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
    <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
                                <?php echo "N/A"; ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="margin-top: 10px;" class="cabinet-list">
                        <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px; text-decoration: underline;">Order Notes</div>
                        <table id="cabinet-list" class="cabinet-list table-report-listing">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

                                                if( isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) ) {
                                                    foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                                                        if( isset($all_items[$cabinet_item['item_id']]) ) {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] += $cabinet_item['item_quantity'];
                                                        }
                                                        else {
                                                            $all_items[$cabinet_item['item_id']]['item_quantity'] = $cabinet_item['item_quantity'];
                                                            $all_items_list[$cabinet_item['item_id']] = $cabinet_item['item_id'];
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'item':
                                                if( isset($all_items[$cabinet_order['resource_id']]) ) {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                                                }
                                                else {
                                                    $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                                                    $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
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

                                if( !empty($report_items) ) {
                                    foreach( $report_items as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                        </tr>
                <?php
            }
        }
        else {
            ?>
                                    <tr>
                                        <td class="text-center" colspan="6">There is no cabinet backs</td>
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
//--------------------------------------------------ORDER NOTES END--------------------------------------------------------//
//--------------------------------------------------MASTER CABINET PARTS START--------------------------------------------------------//

    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number9);
    $final_bar_code = $bar_code_number9 . $check_num;
    ?>
    <div class="quotes report-print" style="top: -55px;">
    <?php
    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_master_cabinet_parts_list');
    ?>
        <div style="float: right; position: relative; top: -70px; left: 20px;">
            <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
        </div>
        <div style="clear: both;"></div>
        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle9; ?> For <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Style:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Door Color:</th>
                                        <td>
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                    <div style="margin-top: 20px;" class="cabinet-list">
                        <table id="cabinet-list" class="cabinet-list table-report-listing">
                            <thead>
                                <tr class="dashed-underline">
                                    <th class="text-left quantity">Qty</th>
                                    <th class="text-left small">Code</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-left small">UPC</th>
                                    <th class="text-center small">Width X Length</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                        if( is_null($cabinet_order['material_id']) || empty($cabinet_order['material_id']) ) { // only with standard material
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
                                                        }
                                                    }
                                                    break;
                                                case 'item':
                                                    if( isset($all_items[$cabinet_order['resource_id']]) ) {
                                                        $all_items[$cabinet_order['resource_id']]['item_quantity'] += $cabinet_order['quantity'];
                                                    }
                                                    else {
                                                        $all_items[$cabinet_order['resource_id']]['item_quantity'] = $cabinet_order['quantity'];
                                                        $all_items_list[$cabinet_order['resource_id']] = $cabinet_item['item_id'];
                                                    }
                                                    break;

                                                default:
                                                    break;
                                            }
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

                                if( !empty($report_items) ) {
                                    foreach( $report_items as $report_item ) {
                                        ?>
                                        <tr>
                                            <td class="text-left quantity"><?php echo $report_item['quantity']; ?></td>
                                            <td class="text-left normal"><?php echo $report_item['code']; ?></td>
                                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                                            <td class="text-left small">N/A</td>
                                            <td class="text-center small"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                        </tr>
            <?php
        }
    }
    else {
        ?>
                                    <tr>
                                        <td class="text-center" colspan="6">There is no master cabinet parts</td>
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
    //--------------------------------------------------MASTER CABINET PARTS END--------------------------------------------------------//
//--------------------------------------------------DOOR DRAWER LIST START--------------------------------------------------------//
    ?>

    <?php
    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number10);
    $final_bar_code = $bar_code_number10 . $check_num;

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

                        $this->InventoryLookup->door_drawer_report(&$report_items, $cabinet_order, $cabinet_detail['top_door_count'], $cabinet_order['door_id'], $cabinet_detail['top_door_width'], $cabinet_detail['top_door_height'], $cabinet_order['quantity'], false);
                        $this->InventoryLookup->door_drawer_report(&$report_items, $cabinet_order, $cabinet_detail['bottom_door_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_door_width'], $cabinet_detail['bottom_door_width'], $cabinet_order['quantity'], false);
                        $this->InventoryLookup->door_drawer_report(&$report_items, $cabinet_order, $cabinet_detail['top_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['top_drawer_front_width'], $cabinet_detail['top_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->door_drawer_report(&$report_items, $cabinet_order, $cabinet_detail['middle_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['middle_drawer_front_width'], $cabinet_detail['middle_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->door_drawer_report(&$report_items, $cabinet_order, $cabinet_detail['bottom_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_drawer_front_width'], $cabinet_detail['bottom_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->door_drawer_report(&$report_items, $cabinet_order, $cabinet_detail['dummy_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['dummy_drawer_front_width'], $cabinet_detail['dummy_drawer_front_height'], $cabinet_order['quantity'], true);
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
    foreach( $report_items2 as $ri ) {
        ?>

        <div class="quotes report-print" style="top: -55px;">
        <?php
        $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_door_drawer_list');
        ?>
            <div style="float: right; position: relative; top: -70px; left: 20px;">
                <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
            </div>
            <div style="clear: both;"></div>

            <fieldset style="position: relative; top: -65px;">
                <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle10; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>		

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
//--------------------------------------------------DOOR DRAWER LIST END--------------------------------------------------------//
//--------------------------------------------------DOOR MANUFACTURING START--------------------------------------------------------//

    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_door_manufacturing_list');

    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number11);
    $final_bar_code = $bar_code_number11 . $check_num;

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

                        $this->InventoryLookup->report_door_manufacturing_list(&$report_items, $cabinet_order, $cabinet_detail['top_door_count'], $cabinet_order['door_id'], $cabinet_detail['top_door_width'], $cabinet_detail['top_door_height'], $cabinet_order['quantity'], false);
                        $this->InventoryLookup->report_door_manufacturing_list(&$report_items, $cabinet_order, $cabinet_detail['bottom_door_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_door_width'], $cabinet_detail['bottom_door_width'], $cabinet_order['quantity'], false);
                        $this->InventoryLookup->report_door_manufacturing_list(&$report_items, $cabinet_order, $cabinet_detail['top_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['top_drawer_front_width'], $cabinet_detail['top_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->report_door_manufacturing_list(&$report_items, $cabinet_order, $cabinet_detail['middle_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['middle_drawer_front_width'], $cabinet_detail['middle_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->report_door_manufacturing_list(&$report_items, $cabinet_order, $cabinet_detail['bottom_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_drawer_front_width'], $cabinet_detail['bottom_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->report_door_manufacturing_list(&$report_items, $cabinet_order, $cabinet_detail['dummy_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['dummy_drawer_front_width'], $cabinet_detail['dummy_drawer_front_height'], $cabinet_order['quantity'], true);
                    }
                    $report_items2 = array( );
                    if( !empty($report_items) ) {
                        foreach( $report_items as $index => $value ) {
                            $report_items2[$value['door_style']][$index] = $value;
                            $report_items_wood[$value['wood_species']][$index] = $value;
                            $report_items_outside[$value['outside_profile']][$index] = $value;
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
//	$wood_count = 1;
//	foreach($report_items_wood as $key => $v){
//	 $dynamic_wood[$wood_count] = $key;
//	 $wood_count++;
//	}
//	$outside_count = 1;
//	foreach($report_items_outside as $key => $v){
//	 $dynamic_outside[$outside_count] = $key;
//	 $outside_count++;
//	}

    $z = 1;
    foreach( $report_items2 as $ri ) {
        ?>
        <div class="quotes report-print" style="top: -55px;">
            <div style="float: right; position: relative; top: -70px; left: 20px;">
                <img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">
            </div>
            <div style="clear: both;"></div>

            <fieldset style="position: relative; top: -65px;">

                <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title"><?php echo $reportTitle11; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>		

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
                                            <th>Door Style:</th>
                                            <td>
        <?php echo "<span style='font-size: 16px; font-weight: bold;'>" . $dynamic_door_style_id[$z] . "</span>"; ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Wood Species:</th>
                                            <td>
        <?php //echo $dynamic_wood[$z]; ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Outside Profile:</th>
                                            <td>
        <?php
        if( isset($dynamic_outside[$z]) )
        //echo $dynamic_outside[$z];
            
            ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset id="quote-basic-info-detail-cabinets" class="sub-content-detail">
                        <div class="sub-section" style="margin-top: 20px; margin-bottom: 20px;">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <table class="table-report-compact no-border">
                                            <tr>
                                                <td colspan="2" style="font-size: 18px; font-weight: bold; text-decoration: underline;">Door &amp; Drawer List</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" rowspan="2">
                                        <table class="table-report-compact_image no-border" style="float: right; height: 50px;">
                                            <tr>
                                                <td style="border: #000 groove medium">Image N/A</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 45px;">Inside Profile:</th>
                                    <td class="text-left" style="width: 150px;">N/A</td>
                                </tr>
                            </table>
                        </div>

                        <div class="cabinet-list">
                            <table id="cabinet-list" class="cabinet-list table-report-listing">
                                <thead>
                                    <tr class="dashed-underline">
                                        <th class="text-left qty_mng">Qty</th>
                                        <th >W X H</th>
                                        <th class="text-left">Code</th>
                                        <th class="text-left quantity">Stile</th>
                                        <th >W X L</th>
                                        <th class="text-left quantity">Rail</th>
                                        <th >W X L</th>
                                        <th class="text-left quantity">Panel</th>
                                        <th >W X L</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if( !empty($ri) ) {
                                    foreach( $ri as $report_item ) {
                                        ?>
                                        <td class="text-left qty_mng"><?php echo $report_item['quantity']; ?></td>
                                        <td class="text-center" style="width: 160px; display: block;"><?php echo "{$report_item['width']} X {$report_item['height']}"; ?></td>
                                        <td class="text-left"><?php echo $report_item['code']; ?></td>
                                        <td class="text-left quantity"><?php echo $report_item['stile_quantity']; ?></td>
                                        <td class="text-center" style="width: 160px; display: block;"><?php
                                        if( (int) $report_item['stile_width'] > 0 ) {
                                            echo "{$report_item['stile_width']} X {$report_item['stile_height']}";
                                        }
                                        else {
                                            echo '&nbsp;';
                                        }
                                        ?></td>
                                        <td class="text-left quantity"><?php echo $report_item['rail_quantity']; ?></td>
                                        <td class="text-center" style="width: 160px; display: block;"><?php
                if( (int) $report_item['rail_width'] > 0 ) {
                    echo "{$report_item['rail_width']} X {$report_item['rail_height']}";
                }
                else {
                    echo '&nbsp;';
                }
                ?></td>
                                        <td class="text-left quantity"><?php echo $report_item['panel_quantity']; ?></td>
                                        <td class="text-center" style="width: 160px; display: block;"><?php echo "{$report_item['panel_width']} X {$report_item['panel_height']}"; ?></td>
                                        </tr>
                            <?php
                        }
                    }
                    else {
                        ?>
                                    <tr>
                                        <td class="text-center" colspan="5">There is no door/drawer</td>
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
        } $z++;
    }
//--------------------------------------------------DOOR MANUFACTURING END--------------------------------------------------------//
    ?>


    <?php
}
?>
</page>
<?php echo $content = ob_get_clean();?>