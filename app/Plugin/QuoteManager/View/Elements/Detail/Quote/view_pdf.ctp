<?php ob_start(); ?>

<?php 
echo $this->Html->css('style' ,true); 
echo $this->Html->css('report', true);
?>

<page>
    
<!----------------------------Header Section--------------------------->
<div style="margin-bottom: 20px;" class="header">
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
                    <span style="font-size: 23px;" class="report-title">
                        Quotation
                    </span>
                    <br/>
                    <span class="report-date" style="font-size: 14px;">
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
                    <br/>
                    <span class="report-date">
                        <?php
                        echo "<span style='font-size: 18px; font-weight: bold;'>Quote No: " . $quote['Quote']['quote_number'] . "</span>";
                        ?>
                    </span>
                    <br/>
                </div>
            </td>
        </tr>
    </table>        
</div>
<!----------------------------Header Section--------------------------->
    
<div style="border-bottom-color: #fff; position: relative; width: 100%;">
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div style="display: block;font-weight: normal; text-align: left; width: 100%;"><?php echo __('Estimated Delivery Date'); ?><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $this->Util->formatDate($quote['Quote']['est_shipping']); ?></div>
            </td>
            <td style="width: 48%;">
                <div style="color: red; font-size: 22px; font-weight: bold; width: 100%; text-align: right;">
                    <?php echo h($this->InventoryLookup->findProductionTime($quote['Quote']['delivery'])); ?>
                </div>
            </td>
        </tr>
    </table>
</div>

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
                                <th>&nbsp;</th>
                                <td>
                                    <?php echo $this->InventoryLookup->address_format_quote_report(h($quote['Quote']['address']), h($quote['Quote']['city']), h($quote['Quote']['province']), h($quote['Quote']['country']), h($quote['Quote']['postal_code'])); ?>
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
                                <th style="width:30%; padding-left: 20px;">Sales Person: </th>
                                <td style="width:70%;">
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
                                <th style="width:20%; padding-left: 20px;">Job Detail: </th>
                                <td style="width:80%">
                                    <?php echo h($quote['Quote']['job_detail']); ?>
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
    <div style="color: red; width: 100%; margin-bottom: 20px; font-size: 20px; text-align: right;"><?php echo $quote['Quote']['installation']; ?> Production Time</div>
    
        <div>
            <table style="width: 100%;">
                <tr class="dashed-underline">
                    <th class="text-left" style="width: 30px;">Qty</th>
                    <th class="text-left" style="width: 70px;">Code</th>
                    <th class="text-left" style="width: 100px;">Description</th>
                    <th class="text-left" style="width: 80px;">Cabinet Color</th>
                    <th class="text-left" style="width: 100px;">Door Style</th>
                    <th class="text-left" style="width: 100px;">Door Color</th>
                    <th class="text-right">Each</th>
                    <th class="text-right">Total</th>
                </tr>
                <tr><td colspan="8" style="border-top: 1px solid black;">&nbsp;</td></tr>
                <?php
                $total_quote_price = 0;
                $total_quote_price_cabinet = 0;
                $total_quote_price_installation = 0;
                $total_quote_price_discount = 0;
                $extra_total = 0;
                $cabinets = array( );

                if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
                    App::import("Model", "Inventory.Cabinet");
                    App::import("Model", "Inventory.Item");
                    foreach( $quote['CabinetOrder'] as $cabinet_order ) {
                        $item_model_ass_chk = new Item();
                        $item_detail_info = $item_model_ass_chk->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
                        if( $item_detail_info['Item']['Department'] == 'Accessories' ) {
                            continue;
                        }

                        $cabinet = new Cabinet();
                        $item_model = new Item();
                        $resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
                        switch( $cabinet_order['resource_type'] ) {
                            case 'cabinet':
                                $resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));
                                $resource_detail['Resource']['name'] = $resource_detail['Cabinet']['name'];
                                $resource_detail['Resource']['description'] = $resource_detail['Cabinet']['description'];
                                $cabinets[] = $resource_detail;
                                break;

                            case 'item':
                                $resource_detail = $item_model->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
                                if( $resource_detail['Item']['Department'] == 'Accessories' ) {
                                    break;
                                }
                                $resource_detail['Resource']['name'] = $resource_detail['Cabinet'][0]['name'];
                                $resource_detail['Resource']['description'] = $resource_detail['Cabinet'][0]['description'];
                                $cabinets[] = $resource_detail;
                                //pr($cabinets);
                                break;

                            default:
                                break;
                        }; 
                        ?>
                        <tr valign="top">
                            <td class="text-left" style="width: 30px;"><?php echo $cabinet_order['quantity']; ?></td>
                            <td class="text-left" style="width: 70px;">
                                <?php
                                echo $resource_detail['Resource']['name'];
                                ?>
                            </td>
                            <td class="text-left" style="width: 100px;"><?php echo $resource_detail['Resource']['description']; ?></td>
                            <td class="text-left" style="width: 80px;">
                                <?php
                                if( $cabinet_order['cabinet_color'] ) {
                                    $color = $this->InventoryLookup->ColorDetail($cabinet_order['cabinet_color']);
                                    if( $color ) {
                                        echo $color['Color']['code'];
                                    }
                                }
                                ?>
                                &nbsp;
                            </td>
                            <td class="text-left" style="width: 100px;">
                                <?php
                                if( $cabinet_order['door_id'] ) {
                                    $style = $this->InventoryLookup->DoorStyle2ID($cabinet_order['door_id'], TRUE);
                                    if( $style ) {
                                        echo $style;
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-left" style="width: 100px;">
                                <?php
                                if( $cabinet_order['door_color'] ) {
                                    $color = $this->InventoryLookup->ColorDetail($cabinet_order['door_color']);
                                    if( $color ) {
                                        echo $color['Color']['code'];
                                    }
                                }
                                ?>
                                &nbsp;
                            </td>
                            <td class="text-right"><?php echo $this->Util->formatCurrency($cabinet_order['total_cost']); ?></td>
                            <td class="text-right">
                                <?php
                                $sub_total = $cabinet_order['total_cost'];
                                $total_quote_price_cabinet += $sub_total;
                                echo $this->Util->formatCurrency($sub_total);
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr><td colspan="8" style="border-bottom: 1px solid #acacac;" >&nbsp;</td></tr>        
                <tr valign="top">
                    <td class="text-left quantity" >&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td style="width: 120px!important;" class="text-right price"><b>Cabinet Total:</b> </td>
                    <td class="text-right price bold"><?php echo "$" . $this->Util->formatCurrency($total_quote_price_cabinet); ?></td>
                </tr>
                
                <tr valign="top"><td colspan="8" style="width: 80px;" style="border-bottom: 1px solid #acacac;" class="text-left quantity">Extra / Accessories</td></tr>                
                
                <?php
                if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
                    App::import("Model", "Inventory.Cabinet");
                    App::import("Model", "Inventory.Item");
                    foreach( $quote['CabinetOrder'] as $cabinet_order ) {
                        $cabinet = new Cabinet();
                        $item_model = new Item();
                        $resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
                        switch( $cabinet_order['resource_type'] ) {
                            case 'cabinet':
                                $resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));
                                $resource_detail['Resource']['name'] = $resource_detail['Cabinet']['name'];
                                $resource_detail['Resource']['description'] = $resource_detail['Cabinet']['description'];
                                $cabinets[] = $resource_detail;
                                break;

                            case 'item':
                                $resource_detail = $item_model->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
                                $resource_detail['Resource']['name'] = $resource_detail['Cabinet'][0]['name'];
                                $resource_detail['Resource']['description'] = $resource_detail['Cabinet'][0]['description'];
                                $cabinets[] = $resource_detail;
                                //pr($cabinets);
                                break;

                            default:
                                break;
                        }; //pr($resource_detail);
                        if( (isset($resource_detail['CabinetsItem']) && !empty($resource_detail['CabinetsItem']) && ($cabinet_order['resource_type'] == 'cabinet') ) ) {
                            foreach( $resource_detail['CabinetsItem'] as $cabinet_item ) {
                                if( $cabinet_item['accessories'] ) { // show accessories only
                                    ?>
                                    <tr valign="top">
                                        <td class="text-left" ><?php echo $cabinet_item['item_quantity']; ?></td>
                                        <td class="text-left" style="width: 80px;">
                                            <?php
                                            $item = $this->InventoryLookup->ItemDetail($cabinet_item['item_id']);
                                            echo $item['Item']['item_title'];
                                            ?>
                                        </td>
                                        <td class="text-left" style=" width: 80px;"><?php echo $item['Item']['description']; ?></td>
                                        <td class="text-left">&nbsp;</td>
                                        <td class="text-left">&nbsp;</td>
                                        <td class="text-left">&nbsp;</td>
                                        <td class="text-right">&nbsp;<?php //echo $this->Util->formatCurrency($item['Item']['price']);   ?></td>
                                        <td class="text-right">
                                            <?php
                                            $sub_total_accessories = $item['Item']['price'] * $cabinet_item['item_quantity'];
                                            $extra_total += $sub_total_accessories;
                                            //echo $this->Util->formatCurrency($sub_total_accessories);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        if( isset($resource_detail['Item']['Department']) && $cabinet_order['resource_type'] == 'item' ) {
                            ?>
                            <tr valign="top">
                                <td class="text-left quantity" ><?php echo $cabinet_order['quantity']; ?></td>
                                <td class="text-left small">
                                    <?php
                                    $item = $this->InventoryLookup->ItemDetail($resource_detail['Item']['id']);
                                    echo $item['Item']['item_title'];
                                    ?>
                                </td>
                                <td class="text-left"><?php echo $item['Item']['description']; ?></td>
                                <td class="text-left small">&nbsp;</td>
                                <td class="text-left small">&nbsp;</td>
                                <td class="text-left small">&nbsp;</td>
                                <td class="text-right price">&nbsp;<?php //echo $this->Util->formatCurrency($item['Item']['price']);   ?></td>
                                <td class="text-right price">
                                    <?php
                                    $sub_total_accessories = $resource_detail['Item']['price'] * $cabinet_order['quantity'];
                                    $extra_total += $sub_total_accessories;
                                    //echo $this->Util->formatCurrency($sub_total_accessories);
                                    ?>
                                </td>
                            </tr>	
                            <?php
                        }
                    }
                }
                ?>
                <tr><td colspan="8" style="border-bottom: 1px solid #acacac;" >&nbsp;</td></tr>
                
                <tr valign="top">
                    <td class="text-left quantity" >&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-right price"><b>Extra Total:</b> </td>
                    <td class="text-right price bold"><?php echo "$" . $this->Util->formatCurrency($extra_total); ?></td>
                </tr>
                
                <tr valign="top"><td style="border-bottom: 1px solid #acacac;" colspan="8">&nbsp;</td></tr>
                <!---------------------------------------------------------------------------------------------------------------------------------------->
                <?php
                if( ($quote['Quote']['installation'] == 'We Installed') && !empty($cabinets) && is_array($cabinets) ) {
                    $installation_summery_list = array( );

                    foreach( $cabinets as $cabinet ) {
                        if( !empty($cabinet['CabinetInstallation']) && is_array($cabinet['CabinetInstallation']) ) {
                            foreach( $cabinet['CabinetInstallation'] as $installation ) {
                                if( isset($installation_summery_list[$installation['name']]['quantity']) ) {
                                    $installation_summery_list[$installation['name']]['quantity']++;
                                }
                                else {
                                    $installation_summery_list[$installation['name']]['name'] = $installation['name'];
                                    $installation_summery_list[$installation['name']]['price_unit'] = $installation['price_unit'];
                                    $installation_summery_list[$installation['name']]['price'] = $installation['price'];
                                    $installation_summery_list[$installation['name']]['quantity'] = 1;
                                }
                            }
                        }
                    }

                    if( !empty($installation_summery_list) ) {
                        foreach( $installation_summery_list as $installation ) {
                            ?>

                            <?php
                            $sub_total = $installation['price'] * $installation['quantity'];
                            $total_quote_price_installation += $sub_total;
                            //echo $this->Util->formatCurrency($sub_total);
                            ?>
                            <?php
                        }
                    }
                }
                ?>
                <tr valign="top">
                    <td class="text-left quantity" >&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td style="width: 165px;" class="text-right price"><b>Installation Total:</b></td>
                    <td class="text-right price bold"><?php echo $this->Util->formatCurrency($total_quote_price_installation); ?></td>
                </tr>
                <tr valign="top">
                    <td class="text-left quantity" >&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-right price"><b>Sub Total:</b> </td>
                    <td class="text-right price bold">
                        <?php
                        $total_quote_price = $total_quote_price_cabinet + $total_quote_price_installation;
                        echo $this->Util->formatCurrency($total_quote_price);
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <td class="text-left quantity" >&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-right price"><b>Discount:</b></td>
                    <td class="text-right price bold">
                        <?php
                        if( $quote['Quote']['delivery'] == '5 – 10 Weeks Delivery' ) {
                            $total_quote_price_discount = $total_quote_price * 0.25; // 25% discount for late delivery
                        }
                        echo $this->Util->formatCurrency($total_quote_price_discount);
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <td class="text-left quantity" >&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-left small">&nbsp;</td>
                    <td class="text-right price"><b>Total: </b></td>
                    <td class="text-right price bold">
                        <?php
                        $total_quote_price -= $total_quote_price_discount;
                        $total_quote_price += $extra_total;
                        echo $this->Util->formatCurrency($total_quote_price);
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
 </page>
<?php echo $content = ob_get_clean();?>