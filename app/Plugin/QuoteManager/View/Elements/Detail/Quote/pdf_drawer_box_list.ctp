<?php ob_start(); ?>

<?php
echo $this->Html->css('style', true);
echo $this->Html->css('report', true);
?>

<page>

    <?php
    $check_num = $this->InventoryLookup->barCodeCheckNum($bar_code_number);
    $final_bar_code = $bar_code_number . $check_num;

    $report_department_list = $this->InventoryLookup->ReportsDepartmentsList('report_drawer_box_list');
    ?>    
    <!----------------------------Header Section--------------------------->
    <div style="margin-bottom: 20px; border: none;" class="header">
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
                            <?php 
                                $drawer_list = $this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer']);
                                if(!empty($drawer_list)){
                                    echo $drawer_list." ".h($quote['WorkOrder']['work_order_number']);
                                }
                                else {
                                    echo "Drawer List";
                                }
                            ?>
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

    <div class="tab-content">
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
                                        N/A
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:20%; padding-left: 20px;">Door Style:</th>
                                    <td style="width:80%">
                                        N/A
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:20%; padding-left: 20px;">Door Color:</th>
                                    <td style="width:80%">
                                        N/A
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

        <div style="font-size: 18px; margin-top: 20px; margin-bottom: 20px; text-decoration: underline; font-weight: bold;" class="sub-section">
            Wood Drawer Box - <?php echo h($this->InventoryLookup->InventoryLookupReverse($quote['Quote']['drawer'])); ?>
        </div>

        <div>
            <table style="width: 100%;">
                <tr class="dashed-underline">
                    <th class="text-left" style="width: 100px;">Qty</th>
                    <th class="text-left" style="width: 120px;">Code</th>
                    <th class="text-left" style="width: 250px;">Description</th>
                    <th class="text-left" style="width: 150px;">Width X Length</th>
                </tr>
                <tr><td colspan="4" style="border-top: 1px solid black;">&nbsp;</td></tr>
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
                            <td class="text-left"><?php echo $report_item['quantity']; ?></td>
                            <td class="text-left"><?php echo $report_item['code']; ?></td>
                            <td class="text-left"><?php echo $report_item['description']; ?></td>
                            <td class="text-center"><?php echo "{$report_item['width']} X {$report_item['length']}"; ?></td>
                        </tr>
                        <?php
                    }
                }
                else {
                    ?>
                    <tr><td class="text-center" colspan="4">There is no wood drawer box</td></tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</page>
<?php echo $content = ob_get_clean(); ?>