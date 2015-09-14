<?php ob_start(); ?>

<?php
echo $this->Html->css('style', true);
echo $this->Html->css('report', true);
?>

<page>
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

                        $this->InventoryLookup->report_door_manufacturing_list($report_items, $cabinet_order, $cabinet_detail['top_door_count'], $cabinet_order['door_id'], $cabinet_detail['top_door_width'], $cabinet_detail['top_door_height'], $cabinet_order['quantity'], false);
                        $this->InventoryLookup->report_door_manufacturing_list($report_items, $cabinet_order, $cabinet_detail['bottom_door_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_door_width'], $cabinet_detail['bottom_door_width'], $cabinet_order['quantity'], false);
                        $this->InventoryLookup->report_door_manufacturing_list($report_items, $cabinet_order, $cabinet_detail['top_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['top_drawer_front_width'], $cabinet_detail['top_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->report_door_manufacturing_list($report_items, $cabinet_order, $cabinet_detail['middle_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['middle_drawer_front_width'], $cabinet_detail['middle_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->report_door_manufacturing_list($report_items, $cabinet_order, $cabinet_detail['bottom_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['bottom_drawer_front_width'], $cabinet_detail['bottom_drawer_front_height'], $cabinet_order['quantity'], true);
                        $this->InventoryLookup->report_door_manufacturing_list($report_items, $cabinet_order, $cabinet_detail['dummy_drawer_front_count'], $cabinet_order['door_id'], $cabinet_detail['dummy_drawer_front_width'], $cabinet_detail['dummy_drawer_front_height'], $cabinet_order['quantity'], true);
                    }
                    $report_items2 = array( );
                    $report_items_wood = array( );
                    $report_items_outside = array( );
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
    $wood_count = 1;
    foreach( $report_items_wood as $key => $v ) {
        $dynamic_wood[$wood_count] = $key;
        $wood_count++;
    }
    $outside_count = 1;
    foreach( $report_items_outside as $key => $v ) {
        $dynamic_outside[$outside_count] = $key;
        $outside_count++;
    }

    $z = 1;
    if( !empty($report_items2) ) {
        foreach( $report_items2 as $ri ) {
            ?>
            <div class="tab-content">
                <!--------------------------Header Section------------------------->
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
                                <div style="text-align: right; width: 100%;">
                                    <?php $bar_code = $this->InventoryLookup->barCodeImageGenerator($final_bar_code); ?>
                                    <img src="<?php echo $this->Html->url('/', true); ?>img/<?php echo $bar_code; ?>">
                                    <br/>
                                    <span style="font-size: 14px; width: 100%; display: block; margin-top: 10px;" class="report-title">
                                        <?php echo $reportTitle . "&nbsp;&nbsp;" . $quote['WorkOrder']['work_order_number']; ?>
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
                <!--------------------------Header Section------------------------->

                <!------------------------Customer Information-------------------------------->
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
                                    <table width="100%">                
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
                                                <?php echo $dynamic_wood[$z]; ?>
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Outside Profile:</th>
                                            <td>
                                                <?php
                                                if( isset($dynamic_outside[$z]) )
                                                    echo $dynamic_outside[$z];
                                                ?>
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
                <!------------------------Customer Information-------------------------------->
                <div style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 25%;">
                                <div style="text-decoration: underline; font-size: 14px; font-weight: bold;">Door &amp; Drawer List</div>
                            </td>
                            <td style="width: 40%;">
                                <?php
                                $img = $this->InventoryLookup->ReportsDepartmentsList($dynamic_door_style_id[$z]);
                                ?>
                                <?php
                                if( !empty($img['Door']['door_image']) ) {
                                    ?>
                                    <img style="width: 80px; height: 80px;" src="<?php echo $this->Html->url('/', true); ?>files/door/door_image/<?php echo $door['Door']['door_image_dir']; ?>/<?php echo 'thumb_' . $door['Door']['door_image']; ?>">
                                    <?php
                                }
                                else {
                                    echo "Image N/A";
                                }
                                ?>
                            </td>
                            <td style="width: 30%;">
                                <?php
                                $img = $this->InventoryLookup->ReportsDepartmentsList($dynamic_door_style_id[$z]);
                                ?>
                                <?php
                                if( !empty($img['Door']['inside_profile_image']) ) {
                                    ?>
                                    <img style="width: 80px; height: 80px;" src="<?php echo $this->Html->url('/', true); ?>files/door/inside_profile_image/<?php echo $door['Door']['inside_profile_image_dir']; ?>/<?php echo 'thumb_' . $door['Door']['inside_profile_image']; ?>">
                                    <?php
                                }
                                else {
                                    echo "Inside Profile: N/A";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <div>
                    <table style="width: 100%;">
                        <tr class="dashed-underline">
                            <th class="text-left" style="width: 30px;">Qty</th>
                            <th class="text-center" style="width: 80px;">W X H</th>
                            <th class="text-left" style="width: 170px;">Code</th>
                            <th class="text-left" style="width: 50px;">Stile</th>
                            <th class="text-center" style="width: 80px;">W X H</th>
                            <th class="text-left" style="width: 50px;">Rail</th>
                            <th class="text-center" style="width: 80px;">W X H</th>
                            <th class="text-left" style="width: 50px;">Panel</th>
                            <th class="text-center" style="width: 80px;">W X H</th>
                        </tr>
                        <tr><td colspan="9" style="border-top: 1px solid black;">&nbsp;</td></tr>
                        <?php
                        if( !empty($ri) ) {
                            foreach( $ri as $report_item ) {
                                ?>
                                <tr>
                                    <td style="width: 30px;" class="text-left"><?php echo $report_item['quantity']; ?></td>
                                    <td style="width: 80px;" class="text-center"><?php echo "{$report_item['width']} X {$report_item['height']}"; ?></td>
                                    <td style="width: 170px;" class="text-left"><?php echo $report_item['code']; ?></td>
                                    <td style="width: 50px;" class="text-left"><?php echo $report_item['stile_quantity']; ?></td>
                                    <td style="width: 80px;" class="text-center">
                                        <?php
                                        if( (int) $report_item['stile_width'] > 0 ) {
                                            echo "{$report_item['stile_width']} X {$report_item['stile_height']}";
                                        }
                                        else {
                                            echo '&nbsp;';
                                        }
                                        ?>
                                    </td>
                                    <td style="width: 50px;" class="text-left"><?php echo $report_item['rail_quantity']; ?></td>
                                    <td style="width: 80px;" class="text-center">
                                        <?php
                                        if( (int) $report_item['rail_width'] > 0 ) {
                                            echo "{$report_item['rail_width']} X {$report_item['rail_height']}";
                                        }
                                        else {
                                            echo '&nbsp;';
                                        }
                                        ?>
                                    </td>
                                    <td style="width: 50px;" class="text-left"><?php echo $report_item['panel_quantity']; ?></td>
                                    <td style="width: 80px;" class="text-center"><?php echo "{$report_item['panel_width']} X {$report_item['panel_height']}"; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        else {
                            ?>
                            <tr>
                                <td class="text-center" colspan="9">There is no door/drawer</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div style="page-break-after:always; clear:both"></div>
            <?php
            $z++;
        }
    }
    else {
        ?>
        <!--------------------------Header Section------------------------->
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
                            <span style="width: 100%; display: block;"><barcode type="UPCA" value="<?php echo $final_bar_code; ?>" label="none" style="width:50mm; height:15mm; color: #000000; font-size: 4mm"></barcode></span>
                            <br/>
                            <span style="font-size: 14px; width: 100%; display: block; margin-top: 10px;" class="report-title">
                                <?php echo $reportTitle . "&nbsp;&nbsp;" . $quote['WorkOrder']['work_order_number']; ?>
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
        <!--------------------------Header Section------------------------->

        <!------------------------Customer Information-------------------------------->
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
                            <table width="100%">                
                                <tr>
                                    <th>Door Style:</th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Wood Species:</th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Outside Profile:</th>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            <div style="clear: both;"></div>
        </div>
        <!------------------------Customer Information-------------------------------->
        <div style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%;">
                        <div style="text-decoration: underline; font-size: 14px; font-weight: bold;">Door &amp; Drawer List</div>
                    </td>
                    <td style="width: 40%;"> <?php echo "Image N/A"; ?></td>
                    <td style="width: 30%;"><?php echo "Inside Profile: N/A"; ?></td>
                </tr>
            </table>
        </div>

        <div>
            <table style="width: 100%;">
                <tr class="dashed-underline">
                    <th class="text-left" style="width: 30px;">Qty</th>
                    <th class="text-center" style="width: 80px;">W X H</th>
                    <th class="text-left" style="width: 170px;">Code</th>
                    <th class="text-left" style="width: 50px;">Stile</th>
                    <th class="text-center" style="width: 80px;">W X H</th>
                    <th class="text-left" style="width: 50px;">Rail</th>
                    <th class="text-center" style="width: 80px;">W X H</th>
                    <th class="text-left" style="width: 50px;">Panel</th>
                    <th class="text-center" style="width: 80px;">W X H</th>
                </tr>
                <tr><td colspan="9" style="border-top: 1px solid black;">&nbsp;</td></tr>
                <tr><td class="text-center" colspan="9">There is no door/drawer</td></tr>

            </table>
        </div>
        <?php
    }
    ?>    
</page>
<?php echo $content = ob_get_clean(); ?>