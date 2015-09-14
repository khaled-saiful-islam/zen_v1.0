<?php ob_start(); ?>

<?php
echo $this->Html->css('style', true);
echo $this->Html->css('report', true);
?>

<page>
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
        <!----------------------------Header Section--------------------------->
        <div class="tab-content">
            <div style="margin-bottom: 20px; border: none;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 58%;">
                            <div>
                                <table style="100%;">
                                    <tr>
                                        <td style="width: 40%;">
                                            <div>
                                                <img src="<?php echo $this->Html->url('/', true); ?>img/logo.png">
                                            </div>
                                        </td>
                                        <td style="width: 58%;">
                                            <div style="width: 100%;">
                                                2790 32nd Avenue N.E.<br/>
                                                Calgary, AB T1Y 5S5<br/>
                                                Phone: 403-7201928<br/>
                                            </div>    
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td style="width: 40%;">
                            <div style="text-align: right;">
                                <?php $bar_code = $this->InventoryLookup->barCodeImageGenerator($final_bar_code); ?>
                                <img src="<?php echo $this->Html->url('/', true); ?>img/<?php echo $bar_code; ?>">
                                <br/>
                                <span style="font-size: 23px; width: 100%; display: block; margin-top: 10px;" class="report-title">
                                    <?php echo $reportTitle . ": " . $report_cab_count . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $quote['WorkOrder']['work_order_number']; ?>
                                </span>
                                <br/>
                                <span class="report-date" style="font-size: 14px; margin-top: 20px;">
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
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>        
            </div>
            <!----------------------------Header Section---------------------------> 
            <!--                    <div class="tab-content">-->
            <!--------------------------Customer Information---------------------------------->
            <div style="position: relative; border-top: 1px dashed #acacac; border-bottom: 1px dashed #acacac;" class="quote_detail_report">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <div class="first_div">
                                <table class="quote_detail_report_table" width="100%">
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Customer: </th>
                                        <td style="width:80%">
                                            <?php echo h($quote['Customer']['first_name']); ?>&nbsp;<?php echo h($quote['Customer']['last_name']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Address: </th>
                                        <td style="width:80%">
                                            <?php echo $this->InventoryLookup->address_format_quote_report(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Sales Person: </th>
                                        <td style="width:80%">
                                            <?php
                                            $sales = unserialize($quote['Quote']['sales_person']);
                                            $cnt = count($sales);
                                            $j = 1;
                                            for( $i = 0; $i < $cnt; $i++ ) {
                                                $sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
                                                echo $sales_person['User']['first_name'] . " " . $sales_person['User']['last_name'];
                                                if( $j < $cnt )
                                                    echo " / ";
                                                $j++;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Ship Date: </th>
                                        <td style="width:80%">
                                            <?php echo $this->Util->formatDate($quote['Quote']['est_shipping']); ?>&nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td style="border-right: 1px dashed #acacac;">&nbsp;</td>
                        <td style="width: 45%;">
                            <div class="second_div">
                                <table class="quote_detail_report_table" width="100%">
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Started Date:</th>
                                        <td style="width:80%">
                                            N/A
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Cabinet Color:</th>
                                        <td style="width:80%">
                                            <?php echo h($this->InventoryLookup->ColorCode2ID($cabinet['detail']['cabinet_color'], TRUE)); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Door Style:</th>
                                        <td style="width:80%">
                                            <?php echo h($this->InventoryLookup->DoorStyle2ID($cabinet['detail']['door_id'], TRUE)); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%; padding-left: 20px;">Door Color:</th>
                                        <td style="width:80%">
                                            <?php echo h($this->InventoryLookup->ColorCode2ID($cabinet['detail']['cabinet_color'], TRUE)); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="clear: both;"></div>
            </div>
            <!--------------------------Customer Information---------------------------------->

            <div style="font-size: 18px; margin-top: 20px; margin-bottom: 20px; font-weight: bold; text-decoration: underline;">
                Parts Listing For: <?php echo $cabinet['Cabinet-Detail']['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cabinet['Cabinet-Detail']['description']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cabinet['detail']['door_side']; ?>
            </div> 

            <div>
                <table style="width: 100%;">
                    <tr>
                        <th class="text-left" style="width: 50px;">Qty</th>
                        <th class="text-left" style="width: 80px;">Code</th>
                        <th class="text-left" style="width: 300px;">Description</th>
                        <th class="text-center" style="width: 100px;">Width X Length</th>
                        <th class="text-center" style="width: 100px;">EdgeTape</th>
                    </tr>
                    <tr><td colspan="5" style="border-top: 1px solid black;">&nbsp;</td></tr>
                    <?php
                    $cabinet_items = array_intersect_key($report_items, $cabinet['Item']);
                    if( !empty($cabinet_items) ) {
                        foreach( $cabinet_items as $cabinet_item ) {
                            if( isset($report_items[$cabinet_item['id']]) ) {
                                $report_item = $report_items[$cabinet_item['id']];
                                ?>
                                <tr>
                                    <td class="text-left" style="width: 50px;"><?php echo $cabinet['Item'][$cabinet_item['id']]['item_quantity']; ?></td>
                                    <td class="text-left" style="width: 80px;"><?php echo $report_item['code']; ?></td>
                                    <td class="text-left" style="width: 300px;"><?php echo $report_item['description']; ?></td>
                                    <td class="text-center" style="width: 100px;"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                                    <td class="text-center small">
                                        <?php
                                        $edge = $this->InventoryLookup->getEdgeTapeForCabParts($report_item['id'], $report_item['code']);
                                        if( !empty($edge) ) {
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
                </table>
            </div>

            <div style="font-size: 14px; margin-top: 20px; margin-bottom: 20px;">
                <p style="margin-bottom: 0px; text-decoration: underline;"><b>Cabinet Door/Drawer Info:</b></p>
                <?php if( $cabinet['Cabinet-Detail']['top_door_count'] > 0 ) { ?>
                    <?php echo $cabinet['Cabinet-Detail']['top_door_count']; ?>&nbsp;Top Door&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['top_door_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['top_door_height'] . ")" . "<br/>"; ?>
                <?php } ?>

                <?php if( $cabinet['Cabinet-Detail']['bottom_door_count'] > 0 ) { ?>
                    <?php echo $cabinet['Cabinet-Detail']['bottom_door_count']; ?>&nbsp;Bottom Door&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['bottom_door_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['bottom_door_height'] . ")" . "<br/>"; ?>
                <?php } ?>

                <?php if( $cabinet['Cabinet-Detail']['top_drawer_front_count'] > 0 ) { ?>
                    <?php echo $cabinet['Cabinet-Detail']['top_drawer_front_count']; ?>&nbsp;Top Drawer Front&nbsp;&<?php echo "(" . $cabinet['Cabinet-Detail']['top_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['top_drawer_front_height'] . ")" . "<br/>"; ?>
                <?php } ?>

                <?php if( $cabinet['Cabinet-Detail']['middle_drawer_front_count'] > 0 ) { ?>
                    <?php echo $cabinet['Cabinet-Detail']['middle_drawer_front_count']; ?>&nbsp;Middle Drawer Front&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['middle_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['middle_drawer_front_height'] . ")" . "<br/>"; ?>
                <?php } ?>

                <?php if( $cabinet['Cabinet-Detail']['bottom_drawer_front_count'] > 0 ) { ?>
                    <?php echo $cabinet['Cabinet-Detail']['bottom_drawer_front_count']; ?>&nbsp;Bottom Drawer Front&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['bottom_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['bottom_drawer_front_height'] . ")" . "<br/>"; ?>
                <?php } ?>

                <?php if( $cabinet['Cabinet-Detail']['dummy_drawer_front_count'] > 0 ) { ?>
                    <?php echo $cabinet['Cabinet-Detail']['dummy_drawer_front_count']; ?>&nbsp;Dummy Drawer Front&nbsp;&nbsp;<?php echo "(" . $cabinet['Cabinet-Detail']['dummy_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['dummy_drawer_front_height'] . ")" . "<br/>"; ?>
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
        <div style="page-break-after:always; clear:both"></div>
        <?php
    }
    ?>
</page>
<?php echo $content = ob_get_clean(); ?>