<?php
$report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_panel_list');

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
            <?php $bar_code = $this->InventoryLookup->barCodeImageGenerator($final_bar_code); ?>
            <img src="<?php echo $this->Html->url('/', true); ?>img/<?php echo $bar_code; ?>">
        </div>
        <div style="clear: both;"></div>

        <fieldset style="position: relative; top: -65px;">
            <legend style="width: 1000px; border-bottom-color: #fff; color: #403c3d; font-size: 21px;" class="text-right sub-title" style="width: 1000px; border-bottom-color: #fff;" class="text-right sub-title"><?php echo $reportTitle; ?> For <?php echo h($quote['WorkOrder']['work_order_number']); ?></legend>
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
?>
