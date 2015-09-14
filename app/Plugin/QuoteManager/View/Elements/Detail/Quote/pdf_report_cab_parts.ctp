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
foreach( $report_resource_cabinets as $cabinet ) {
    //pr($cabinet);
    $report_cab_count++;
    $cab_pack = str_pad($report_cab_count, 2, "0", STR_PAD_LEFT);
    $upc_code_num = $bar_code_number . $cab_pack;
    $check_num = $this->InventoryLookup->barCodeCheckNum($upc_code_num);
    $final_bar_code = $upc_code_num . $check_num;
    ?>
    <div class="quotes report-print">
        <div style="float: right; position: relative; top: -70px;">
    <!--			<img src="<?php echo "http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/barCodeImage/{$final_bar_code}" ?>">-->
        </div>
        <div style="clear: both;"></div>
        <div style="font-size: 13px; float: right; position: relative; top: -70px;">
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
        <fieldset style="position: relative; top: -70px;">
            <legend class="text-right sub-title"><?php echo $reportTitle . ':' . $report_cab_count; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
            <div class="tab-content">
                <fieldset id="quote-basic-info-detail" class="sub-content-detail">
                    <table>
                        <tr>
                            <th style="font-size: 18px;" class="text-left">Customer</th>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-report-compact">
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
                            <td>
                                <table class="table-report-compact" style="float: right;">
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
                <div style="font-size: 15px; margin-top: 20px; margin-bottom: 20px; font-weight: bold;">
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
                <div style="font-size: 14px; margin-top: 10px;margin-bottom: 10px;">
                    <p><b>Cabinet Door/Drawer Info:</b></p>
                    <p>-------------------------------------</p>
                    <?php echo $cabinet['Cabinet-Detail']['top_door_count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;Door&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cabinet['Cabinet-Detail']['top_door_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['top_door_height']; ?></br>
                    <?php echo $cabinet['Cabinet-Detail']['top_drawer_front_count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;Drawer&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cabinet['Cabinet-Detail']['top_drawer_front_width']; ?> X <?php echo $cabinet['Cabinet-Detail']['top_drawer_front_height']; ?>
                </div>
            </div>

        </fieldset>
    </div>
    <div class="page-break"></div>
    <!--  <div class="header hide-in-screen">
        <div class="header-left">

          <div class="logo">
    <?php
    echo $this->Html->image('header_logo.jpg');
    ?>
            <div class="clear"></div>
          </div>
          <div class="address">
            <span>2790 32nd Avenue N.E. T1Y 5S5</span><br/>
            <span>Calgary, Alberta Phone: 403-7201928</span><br/>
          </div>
        </div>
        <div class="header-right">
              <span class="report-title">
    <?php if( isset($reportTitle) ) echo h($reportTitle); ?>
          </span>
          <br/>
          <span class="report-date">
    <?php if( isset($reportDate) ) echo h(date('l, F d, Y - h:i a', $reportDate)); ?>
          </span>
          <span class="report-date">
    <?php if( isset($reportStartDate) ) echo '<br/><br/>Date Range: ' . h($reportStartDate); ?> <br/>
    <?php if( isset($reportEndDate) ) echo h($reportEndDate); ?>
          </span>
          <span class="report-number">
    <?php if( isset($reportNumber) ) echo h($reportNumber); ?>
          </span>
          <br/>
        </div>
      </div>-->
    <?php
}
?>