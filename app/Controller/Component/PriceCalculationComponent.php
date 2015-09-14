<?php

/**
 * @author Sadi Abdullah
 * @desc the component for calculate the price. it do not call any external function to maintain the stability and independence
 */
App::uses('Component', 'Controller');
App::uses('Sanitize', 'Utility');

class PriceCalculationComponent extends Component {

    private $default_markup;
    private $bulm_up_charge;
    private $bulm_up_charge_total;
    private $default_discount;

    function __construct() {
//    $this->default_markup = 1;
        $this->default_markup = 1.25;
        $this->bulm_up_charge = 20;
        $this->bulm_up_charge_total = 0;
        $this->default_discount = .05;
    }

    /**
     * @desc Main function to calculate the custom panel price
     * @param int $height
     * @param int $door_id
     * @param int $width
     * @return array the result of the calculation along with debug data and subparts
     */
    public function calculateItemPrice($item_id, $quantity = 1, $material_id = 0, $color_id = 0, $delivery_charge = 0) {
        App::import("Model", "Inventory.Color");
        App::import("Model", "Inventory.Item");
        $item = new Item();

        $item_id = (int) Sanitize::escape($item_id);
        $material_id = (int) Sanitize::escape($material_id);
        $color_id = (int) Sanitize::escape($color_id);

        $debug_calculation = '';
        $item_price = 0;

        $item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $item_id ) ));
        $item_sqft = $this->calculateSQFT($item_detail['Item']['length'], $item_detail['Item']['width']);
        if( $item_detail ) {
            $item_price = $item_detail['Item']['price'];
            $ItemMaterialPrice = null;
            if( isset($material_id) && !empty($material_id) ) {
                $ItemMaterialPrice = $this->getItemMaterialPrice($item, $item_id, $material_id, $debug_calculation);
                $item_price = $ItemMaterialPrice['item_price'];
                $item_sqft = $ItemMaterialPrice['item_sqft'];
            }
        }

        $debug_calculation .= "Item Sqft = {$item_sqft} <br />";
        $debug_calculation .= "<br />";

        // get cabinet color price
        $cabinet_color_price = 0;
        $item_price_color = 0;
        $color_detail = array( );
        if( !empty($color_id) ) {
            $color = new Color();
            $color_detail = $color->find('first', array( 'conditions' => array( 'id' => $color_id ) ));
            if( isset($color_detail['ColorSection']) && !empty($color_detail['ColorSection']) && is_array($color_detail['ColorSection']) ) {
                foreach( $color_detail['ColorSection'] as $color_section ) {
//          if ($color_section['type'] == 'cabinet_material') {
                    if( $color_section['type'] == 'cabinate_material' ) {
                        $cabinet_color_price = $color_section['price'];
                        $debug_calculation .= "Cabinet Color Price = {$cabinet_color_price} <br />";
                        $debug_calculation .= "<br />";

                        $item_price_color = $cabinet_color_price * $item_sqft * $color_section['markup'];
                        $debug_calculation .= "<b>Item Price (Color) = {$item_price_color} </b><br />";
                        $debug_calculation .= "<br />";
                        break;
                    }
                }
            }
//      unset($color_detail); // clean up
            unset($color); // clean up
        }

        $total_price = (($item_price_color + $item_price) * $quantity);

        if( $ItemMaterialPrice['sub_item'] ) {
            $debug_calculation .= "Item ({$ItemMaterialPrice['sub_item']['Item']['item_title']}) Price = {$total_price} <br />";
        }
        else {
            $debug_calculation .= "Item ({$item_detail['Item']['item_title']}) Price = {$total_price} <br />";
        }

        $result = array(
            'name' => $item_detail['Item']['item_title'],
            'description' => $item_detail['Item']['description'],
            'total_price' => $total_price,
            'debug_calculation' => $debug_calculation,
            'conditions' => array(
                'resource_id' => $item_id,
                'resource_type' => 'item',
                'material_id' => $material_id,
                'cabinet_color' => $color_id,
                'quantity' => $quantity,
            ),
        );
        return $result;
    }

    public function calculateItemPriceForBuilder($item_id, $quantity = 1, $material_id = 0, $color_id = 0, $delivery_charge = 0) {
        App::import("Model", "Inventory.Color");
        App::import("Model", "Inventory.Item");
        $item = new Item();

        $item_id = (int) Sanitize::escape($item_id);
        $material_id = (int) Sanitize::escape($material_id);
        $color_id = (int) Sanitize::escape($color_id);

        $debug_calculation = '';
        $item_price = 0;

        $item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $item_id ) ));
        $item_sqft = $this->calculateSQFT($item_detail['Item']['length'], $item_detail['Item']['width']);
        if( $item_detail ) {
            $item_price = $item_detail['Item']['builder_price'];
//			$item_price = $item_detail['Item']['price'];
            $ItemMaterialPrice = null;
            if( isset($material_id) && !empty($material_id) ) {
                $ItemMaterialPrice = $this->getItemMaterialPriceForBuilder($item, $item_id, $material_id, $debug_calculation);
                $item_price = $ItemMaterialPrice['item_price'];
                $item_sqft = $ItemMaterialPrice['item_sqft'];
            }
        }

        $debug_calculation .= "Item Sqft = {$item_sqft} <br />";
        $debug_calculation .= "<br />";

        // get cabinet color price
        $cabinet_color_price = 0;
        $item_price_color = 0;
        $color_detail = array( );
        if( !empty($color_id) ) {
            $color = new Color();
            $color_detail = $color->find('first', array( 'conditions' => array( 'id' => $color_id ) ));
            if( isset($color_detail['ColorSection']) && !empty($color_detail['ColorSection']) && is_array($color_detail['ColorSection']) ) {
                foreach( $color_detail['ColorSection'] as $color_section ) {
//          if ($color_section['type'] == 'cabinet_material') {
                    if( $color_section['type'] == 'cabinate_material' ) {
                        $cabinet_color_price = $color_section['price'];
                        $debug_calculation .= "Cabinet Color Price = {$cabinet_color_price} <br />";
                        $debug_calculation .= "<br />";

                        $item_price_color = $cabinet_color_price * $item_sqft * $color_section['markup'];
                        $debug_calculation .= "<b>Item Price (Color) = {$item_price_color} </b><br />";
                        $debug_calculation .= "<br />";
                        break;
                    }
                }
            }
//      unset($color_detail); // clean up
            unset($color); // clean up
        }

        $total_price = (($item_price_color + $item_price) * $quantity);

        if( $ItemMaterialPrice['sub_item'] ) {
            $debug_calculation .= "Item ({$ItemMaterialPrice['sub_item']['Item']['item_title']}) Price = {$total_price} <br />";
        }
        else {
            $debug_calculation .= "Item ({$item_detail['Item']['item_title']}) Price = {$total_price} <br />";
        }

        $result = array(
            'name' => $item_detail['Item']['item_title'],
            'description' => $item_detail['Item']['description'],
            'total_price' => $total_price,
            'debug_calculation' => $debug_calculation,
            'conditions' => array(
                'resource_id' => $item_id,
                'resource_type' => 'item',
                'material_id' => $material_id,
                'cabinet_color' => $color_id,
                'quantity' => $quantity,
            ),
        );
        return $result;
    }

    /**
     * @desc Main function to calculate the custom panel price
     * @param int $height
     * @param int $door_id
     * @param int $width
     * @return array the result of the calculation along with debug data and subparts
     */
    public function calculateCustomPanel($height, $width, $color_id, $material_id, $edgetape) {
        App::uses("Color", "Inventory.Model");

        $height = (int) Sanitize::escape($height);
        $width = (int) Sanitize::escape($width);
        $color_id = (int) Sanitize::escape($color_id);
        $material_id = (int) Sanitize::escape($material_id);
        $edgetape = Sanitize::escape($edgetape);

        $debug_calculation = '';

        $panel_sqft = $this->calculateSQFT($height, $width);
        $debug_calculation .= "Panel SQFT = {$panel_sqft} <br />";
        $debug_calculation .= "<br />";

        $panel_price_material = 0;
        $material_price = 0;
        $material_data = array( );
        if( !empty($material_id) ) {
            $material_data = $this->getMaterialDetail($material_id);
            // calculate the material price aka cost for custom panel
            $material_sqft = $this->calculateSQFT($material_data['Material']['length'], $material_data['Material']['width'], TRUE);
            $debug_calculation .= "Material Sqft = {$material_sqft} <br />";
            if( $material_sqft > 0 ) {
                $material_price = ($material_data['Material']['price'] / $material_sqft);
                $debug_calculation .= "Material Cost = {$material_price} <br />";
                $debug_calculation .= "<br />";

                $panel_price_material = $material_price * $panel_sqft * (float) $material_data['Material']['markup'] * (float) $material_data['Material']['custom_markup'];
                $debug_calculation .= "<b>Panel Price (Material) = {$panel_price_material} </b><br />";
                $debug_calculation .= "<br />";
            }
        }

        // get cabinet color price
        $cabinet_color_price = 0;
        $panel_price_color = 0;
        $color_detail = array( );
        if( !empty($color_id) ) {
            $color = new Color();
            $color_detail = $color->find('first', array( 'conditions' => array( 'id' => $color_id ) ));
            if( isset($color_detail['ColorSection']) && !empty($color_detail['ColorSection']) && is_array($color_detail['ColorSection']) ) {
                foreach( $color_detail['ColorSection'] as $color_section ) {
//          if ($color_section['type'] == 'cabinet_material') {
                    if( $color_section['type'] == 'cabinate_material' ) {
                        $cabinet_color_price = $color_section['price'];
                        $debug_calculation .= "Cabinet Color Price = {$cabinet_color_price} <br />";
                        $debug_calculation .= "<br />";

                        $panel_price_color = $cabinet_color_price * $panel_sqft * $color_section['markup'];
                        $debug_calculation .= "<b>Panel Price (Color) = {$panel_price_color} </b><br />";
                        $debug_calculation .= "<br />";
                        break;
                    }
                }
            }
//      unset($color_detail); // clean up
            unset($color); // clean up
        }

        $total_price = $panel_price_color + $panel_price_material;

        $result = array(
            'name' => 'CP',
            'description' => "Custom Panel ({$height}X{$width}) [Edgetape: {$edgetape}] [Color: {$color_detail['Color']['code']}] [Material: {$material_data['Material']['code']}]",
            'total_price' => $total_price,
            'debug_calculation' => $debug_calculation,
            'conditions' => array(
                'height' => $height,
                'width' => $width,
                'color_id' => $color_id,
                'material_id' => $material_id,
                'edgetape' => $edgetape,
                'quantity' => 1,
                'resource_type' => 'custom_panel',
                'resource_id' => '0',
            ),
        );
        return $result;
    }

    /**
     * @desc Main function to calculate the custom panel price
     * @param int $height
     * @param int $door_id
     * @param int $width
     * @return array the result of the calculation along with debug data and subparts
     */
    public function calculateCustomDoor($height, $width, $color_id, $door_id) {
        App::uses("Door", "Inventory.Model");
        App::uses("Color", "Inventory.Model");

        $height = (int) Sanitize::escape($height);
        $width = (int) Sanitize::escape($width);
        $color_id = (int) Sanitize::escape($color_id);
        $door_id = (int) Sanitize::escape($door_id);

        $debug_calculation = '';
        $custom_door_price = 0;
        $count = 1;

        // get door color price
        $door_color_price = 0;
        $door_color_detail = array( );
        if( !empty($color_id) ) {
            $color = new Color();
            $door_color_detail = $color->find('first', array( 'conditions' => array( 'id' => $color_id ) ));
            if( isset($door_color_detail['ColorSection']) && !empty($door_color_detail['ColorSection']) && is_array($door_color_detail['ColorSection']) ) {
                foreach( $door_color_detail['ColorSection'] as $color_section ) {
                    if( $color_section['type'] == 'door_material' ) {
                        $door_color_price = $color_section['price'];
                        break;
                    }
                }
            }
//      unset($door_color_detail); // clean up
            unset($color); // clean up
        }

        if( !empty($door_id) ) {
            $door = new Door();
            $door_detail = $door->find('first', array( 'conditions' => array( 'Door.id' => $door_id ) ));

            $door_cost_markup = (float) $door_detail['Door']['cost_markup_factor'];
            $door_custom_markup = (float) $door_detail['Door']['custom_size_markup'];
            $debug_calculation .= "Door/Drawer Cost Markup = {$door_cost_markup} <br />";
            $debug_calculation .= "<br />";

            $price_sqft = (float) $door_detail['Door']['wall_door_price'];
            $price_each = (float) $door_detail['Door']['wall_door_price_each'];
            $label = 'Custom Door';

            $custom_door_price_detail = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each);
            $debug_calculation .= "<br />";
            $custom_door_price = $custom_door_price_detail['price'];

            if( $door_color_price ) {
                $debug_calculation .= "Door Color Price = {$door_color_price} <br />";
                $debug_calculation .= "<br />";
                $doors_drawers_price_color = ($door_color_price * $door_custom_markup * $custom_door_price_detail['sqft']);
                $custom_door_price += $doors_drawers_price_color;
                $debug_calculation .= "<br />";
                $debug_calculation .= "<b>Door/Drawer Price (Color) = {$doors_drawers_price_color} </b><br />";
                $debug_calculation .= "<br />";
            }

            unset($door); // clean up
        }

        $total_price = $custom_door_price;

        $result = array(
            'name' => 'CD',
            'description' => "Custom Door ({$height}X{$width}) [Door: {$door_detail['Door']['door_style']}] [Color: {$door_color_detail['Color']['code']}]",
            'total_price' => $total_price,
            'debug_calculation' => $debug_calculation,
            'conditions' => array(
                'height' => $height,
                'width' => $width,
                'color_id' => $color_id,
                'door_id' => $door_id,
                'quantity' => 1,
                'resource_type' => 'custom_door',
                'resource_id' => '0',
            ),
        );
        return $result;
    }

    /**
     * @desc Main function to calculate the cabinet price
     * @param int $cabinet_id
     * @param int $material_id
     * @param int $door_id
     * @param int $door_color
     * @return array the result of the calculation along with debug data and subparts
     */
    public function calculateCabinetPrice($cabinet_id, $cabinet_color, $material_id, $door_id, $door_color, $drawer_id, $drawer_slide_id, $quantity = 1, $delivery_option = '', $delivery_charge = 0) {
        App::import("Model", "Inventory.Cabinet");
        App::uses("Material", "Inventory.Model");
        App::uses("Door", "Inventory.Model");
        App::uses("Color", "Inventory.Model");
        App::import("Model", "Inventory.Item");
        App::import("Model", "Inventory.CabinetsItem");
        App::import("Model", "Inventory.InventoryLookup");

        $cabinet_id = Sanitize::escape($cabinet_id);
        $material_id = Sanitize::escape($material_id);
        $door_id = Sanitize::escape($door_id);
        $door_color = Sanitize::escape($door_color);
        $cabinet_color = Sanitize::escape($cabinet_color);
        $drawer_id = Sanitize::escape($drawer_id);
        $drawer_slide_id = Sanitize::escape($drawer_slide_id);

        $debug_calculation = '';

        $cabinets_items_model = new CabinetsItem();
        $cabinets_items_model->recursive = 1;
        $cabinets_items = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $cabinet_id, 'accessories' => '0' ) ));
        $cabinets_accessories = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $cabinet_id, 'accessories' => '1' ) ));

        if( !empty($cabinet_id) ) {
            $cabinet = new Cabinet();
            $cabinet_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_id ) ));
        }

        // predefined values
        $debug_calculation .= "Blum Up Charge = {$this->bulm_up_charge} <br />";
        $debug_calculation .= "Default Markup Factor = {$this->default_markup} <br />";
        $debug_calculation .= "<br />";

        // calculate cabinet sqft
        $item_model = new Item();
        $cabinet_sqft = $this->calculateCabinetSQFT($cabinets_items, $item_model, $material_id);
        $debug_calculation .= "Cabinet SQFT = {$cabinet_sqft} <br />";
        $debug_calculation .= "<br />";

        // calculate cabinet sqft
        $panel_sqft = $this->calculatePanelSQFT($cabinets_items);
        $debug_calculation .= "Panel SQFT = {$panel_sqft} <br />";
        $debug_calculation .= "<br />";

        // calculate cabinet sqft
        $box_total = $this->calculateBoxTotal($cabinets_items, $door_id, $drawer_id, $drawer_slide_id);
        $debug_calculation .= "<b>Box Total Price = {$box_total} </b><br />";
        $debug_calculation .= "<br />";

        // get door color price
        $door_color_price = 0;
        $door_color_detail = array( );
        if( !empty($door_color) ) {
            $color = new Color();
            $door_color_detail = $color->find('first', array( 'conditions' => array( 'id' => $door_color ) ));
            if( isset($door_color_detail['ColorSection']) && !empty($door_color_detail['ColorSection']) && is_array($door_color_detail['ColorSection']) ) {
                foreach( $door_color_detail['ColorSection'] as $color_section ) {
                    if( $color_section['type'] == 'door_material' ) {
                        $door_color_price = $color_section['price'];
                        break;
                    }
                }
            }
            unset($door_color_detail); // clean up
            unset($color); // clean up
        }

        // get cabinet color price
        $cabinet_color_price = 0;
        $cabinet_price_color = 0;
        $panel_price_color = 0;
        $cabinet_color_detail = array( );
        if( !empty($cabinet_color) ) {
            $color = new Color();
            $cabinet_color_detail = $color->find('first', array( 'conditions' => array( 'id' => $cabinet_color ) ));
            if( isset($cabinet_color_detail['ColorSection']) && !empty($cabinet_color_detail['ColorSection']) && is_array($cabinet_color_detail['ColorSection']) ) {
                foreach( $cabinet_color_detail['ColorSection'] as $color_section ) {
//          if ($color_section['type'] == 'cabinet_material') {
                    if( $color_section['type'] == 'cabinate_material' ) {
                        $cabinet_color_price = $color_section['price'];
                        $cabinet_price_color = $cabinet_color_price * $cabinet_sqft;
                        $debug_calculation .= "Cabinet Color Price = {$cabinet_color_price} <br />";
                        $debug_calculation .= "<b>Cabinet Price (Color) = {$cabinet_price_color} </b><br />";

                        $panel_price_color = $cabinet_color_price * $panel_sqft;
                        $debug_calculation .= "<b>Panel Price (Color) = {$panel_price_color} </b><br />";
                        $debug_calculation .= "<br />";
                        break;
                    }
                }
            }
            unset($cabinet_color_detail); // clean up
            unset($color); // clean up
        }

        $doors_drawers_price = 0;
        if( !empty($door_id) ) {
            $door = new Door();
            $door_detail = $door->find('first', array( 'conditions' => array( 'Door.id' => $door_id ) ));

            $door_cost_markup = $door_detail['Door']['cost_markup_factor'];
            $door_drawers = array( );
            $debug_calculation .= "Door/Drawer Cost Markup = {$door_cost_markup} <br />";
            $debug_calculation .= "<br />";

            $door_drawers['top_door'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['top_door_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['top_door_height'];
                $width = (float) $cabinet_detail['Cabinet']['top_door_width'];
                $count = (float) $cabinet_detail['Cabinet']['top_door_count'];
                $price_sqft = (float) $door_detail['Door']['wall_door_price'];
                $price_each = (float) $door_detail['Door']['wall_door_price_each'];
                $label = 'Top Door';

                $door_drawers['top_door'] = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each);
                $debug_calculation .= "<br />";
            }

            $door_drawers['bottom_door'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['bottom_door_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['bottom_door_height'];
                $width = (float) $cabinet_detail['Cabinet']['bottom_door_width'];
                $count = (float) $cabinet_detail['Cabinet']['bottom_door_count'];
                $price_sqft = (float) $door_detail['Door']['door_price'];
                $price_each = (float) $door_detail['Door']['door_price_each'];
                $label = 'Bottom Door';

                $door_drawers['bottom_door'] = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each);
                $debug_calculation .= "<br />";
            }

            $door_drawers['top_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['top_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['top_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['top_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['top_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['drawer_price'];
                $price_each = (float) $door_detail['Door']['drawer_price_each'];
                $label = 'Top Drawer Front';

                $door_drawers['top_drawer_front'] = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

            $door_drawers['middle_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['middle_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['middle_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['middle_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['middle_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['lower_drawer_price'];
                $price_each = (float) $door_detail['Door']['lower_drawer_price_each'];
                $label = 'Middle Drawer Front';

                $door_drawers['middle_drawer_front'] = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

            $door_drawers['bottom_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['bottom_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['bottom_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['bottom_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['bottom_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['lower_drawer_price'];
                $price_each = (float) $door_detail['Door']['lower_drawer_price_each'];
                $label = 'Bottom Drawer Front';

                $door_drawers['bottom_drawer_front'] = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

            $door_drawers['dummy_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['dummy_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['dummy_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['dummy_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['dummy_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['drawer_price'];
                $price_each = (float) $door_detail['Door']['drawer_price_each'];
                $label = 'Dummy Drawer Front';

                $door_drawers['dummy_drawer_front'] = $this->calculateDoorDrawer($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

//      $debug = var_export($door_drawers, true);
//      $debug_calculation .= "Door/Drawer Price = {$debug} <br />";

            $doors_drawers_price = $this->sumDoorDrawer($door_drawers);
            $debug_calculation .= "<b>Door/Drawer Price = {$doors_drawers_price} </b><br />";
            $debug_calculation .= "<b>Bulm up Charge Total Price = {$this->bulm_up_charge_total} </b><br />";
            $debug_calculation .= "<br />";

            if( $door_color_price ) {
                $debug_calculation .= "Door Color Price = {$door_color_price} <br />";
                $debug_calculation .= "<br />";
                $doors_drawers_price_color = $this->sumDoorDrawerColor($debug_calculation, $door_drawers, $door_color_price);
                $doors_drawers_price += $doors_drawers_price_color;
                $debug_calculation .= "<br />";
                $debug_calculation .= "<b>Door/Drawer Price (Color) = {$doors_drawers_price_color} </b><br />";
                $debug_calculation .= "<br />";
            }

            unset($door); // clean up
        }

        $inventory_lookup = new InventoryLookup();
        $inventory_lookup->recursive = -1;
        $drawer_departments = array( );
        $inventory_lookup_detail = $inventory_lookup->find('all', array( 'conditions' => array( 'InventoryLookup.lookup_type' => 'drawer' ) ));
        foreach( $inventory_lookup_detail as $inventory_lookup_row ) {
            $departments = $inventory_lookup->SearchCache2Array($inventory_lookup_row['InventoryLookup']['department_id']);
            foreach( $departments as $department ) {
                if( isset($drawer_departments[$department]) ) {
                    $drawer_departments[$department][] = $inventory_lookup_row['InventoryLookup']['id'];
                }
                else {
                    $drawer_departments[$department] = array( $inventory_lookup_row['InventoryLookup']['id'] );
                }
            }
        }

        $item = new Item();
        $items_price = 0;
        $discount = 0;
        $items = array( );
        if( !empty($cabinet_detail['CabinetsItem']) ) {
            foreach( $cabinet_detail['CabinetsItem'] as $cabinet_item ) {
                if( $cabinet_item['accessories'] )
                    continue; // skip the accessories

                $item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_item['item_id'] ) ));
                if( array_key_exists($item_detail['Item']['item_department_id'], $drawer_departments) ) {
                    if( !in_array($drawer_id, $drawer_departments[$item_detail['Item']['item_department_id']]) ) {
                        continue; // skip the un-selected drawer
                    }
                }
                $item_price = $item_detail['Item']['price'];
                $ItemMaterialPrice = null;
                if( isset($material_id) && !empty($material_id) ) {
                    $ItemMaterialPrice = $this->getItemMaterialPrice($item, $cabinet_item['item_id'], $material_id, $debug_calculation);
                    $item_price = $ItemMaterialPrice['item_price'];
                }

                //Discount                
//                if( $delivery_option == '5 – 10 Weeks Delivery' ) {
//                    $discount = $item_price * $this->default_discount;
//                    $item_price = $item_price - $discount;
//                }

                $item_calculated_price = ($cabinet_item['item_quantity'] * $item_price);
                $items_price += $item_calculated_price;

                if( $ItemMaterialPrice['sub_item'] ) {
                    $debug_calculation .= "Cabinet Item ({$ItemMaterialPrice['sub_item']['Item']['item_title']}) Price = {$ItemMaterialPrice['material_data']['Material']['price']} => Quantity = {$cabinet_item['item_quantity']} => Total = {$item_calculated_price} <br />";
                }
                else {
                    $debug_calculation .= "Cabinet Item ({$item_detail['Item']['item_title']}) Price = {$item_price} => Quantity = {$cabinet_item['item_quantity']} => Total = {$item_calculated_price} <br />";
                }

//        $items[] = array(
//            'id' => $item_detail['Item']['id'],
//            'item_title' => $item_detail['Item']['item_title'],
//            'price' => $item_price,
//            'base_price' => $item_detail['Item']['price'],
//            'quantity' => $cabinet_item['item_quantity'],
//        );
            }

            $debug_calculation .= "<b>Cabinet Item Price = {$items_price} </b><br />";
            $debug_calculation .= "<br />";

            unset($cabinet_detail); // clean up
        }

        $total_price = (($items_price + $cabinet_price_color + $panel_price_color + $doors_drawers_price + $this->bulm_up_charge_total) * $this->default_markup) * $quantity;
        
        $discount_rate = $this->getProductionTime($delivery_option);
        $discount = $total_price * $discount_rate;
        $total_price = $total_price - $discount;
        
        $debug_calculation .= "<b>Discount = {$discount} </b><br />";
        $debug_calculation .= "<b>Total Price = {$total_price} </b><br />";

        $result = array(
//        'items' => $items,
            'items_price' => $items_price,
            'doors_price' => $doors_drawers_price,
            'cabinet_color_price_color' => $cabinet_price_color,
            'total_price' => $total_price,
            'debug_calculation' => $debug_calculation,
            'conditions' => array(
                'resource_id' => $cabinet_id,
                'resource_type' => 'cabinet',
                'material_id' => $material_id,
                'door_id' => $door_id,
                'door_color' => $door_color,
                'cabinet_color' => $cabinet_color,
                'drawer_slide_id' => $drawer_slide_id,
                'drawer_id' => $drawer_id,
                'quantity' => $quantity,
            ),
        );
        return $result;
    }

    /* Calculation for Builder who have multiple pricing */

    public function calculateCabinetPriceForBuilder($cabinet_id, $cabinet_color, $material_id, $door_id, $door_color, $drawer_id, $drawer_slide_id, $quantity = 1, $delivery_option = '', $delivery_charge = 0) {
        App::import("Model", "Inventory.Cabinet");
        App::uses("Material", "Inventory.Model");
        App::uses("Door", "Inventory.Model");
        App::uses("Color", "Inventory.Model");
        App::import("Model", "Inventory.Item");
        App::import("Model", "Inventory.CabinetsItem");
        App::import("Model", "Inventory.InventoryLookup");

        $cabinet_id = Sanitize::escape($cabinet_id);
        $material_id = Sanitize::escape($material_id);
        $door_id = Sanitize::escape($door_id);
        $door_color = Sanitize::escape($door_color);
        $cabinet_color = Sanitize::escape($cabinet_color);
        $drawer_id = Sanitize::escape($drawer_id);
        $drawer_slide_id = Sanitize::escape($drawer_slide_id);

        $debug_calculation = '';

        $cabinets_items_model = new CabinetsItem();
        $cabinets_items_model->recursive = 1;
        $cabinets_items = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $cabinet_id, 'accessories' => '0' ) ));
        $cabinets_accessories = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $cabinet_id, 'accessories' => '1' ) ));

        if( !empty($cabinet_id) ) {
            $cabinet = new Cabinet();
            $cabinet_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_id ) ));
        }

        // predefined values
        $debug_calculation .= "Blum Up Charge = {$this->bulm_up_charge} <br />";
        $debug_calculation .= "Default Markup Factor = {$this->default_markup} <br />";
        $debug_calculation .= "<br />";

        // calculate cabinet sqft
        $item_model = new Item();
        $cabinet_sqft = $this->calculateCabinetSQFTForBuilder($cabinets_items, $item_model, $material_id);
        $debug_calculation .= "Cabinet SQFT = {$cabinet_sqft} <br />";
        $debug_calculation .= "<br />";

        // calculate cabinet sqft
        $panel_sqft = $this->calculatePanelSQFTForBuilder($cabinets_items);
        $debug_calculation .= "Panel SQFT = {$panel_sqft} <br />";
        $debug_calculation .= "<br />";

        // calculate cabinet sqft
        $box_total = $this->calculateBoxTotalForBuilder($cabinets_items, $door_id, $drawer_id, $drawer_slide_id);
        $debug_calculation .= "<b>Box Total Price = {$box_total} </b><br />";
        $debug_calculation .= "<br />";

        // get door color price
        $door_color_price = 0;
        $door_color_detail = array( );
        if( !empty($door_color) ) {
            $color = new Color();
            $door_color_detail = $color->find('first', array( 'conditions' => array( 'id' => $door_color ) ));
            if( isset($door_color_detail['ColorSection']) && !empty($door_color_detail['ColorSection']) && is_array($door_color_detail['ColorSection']) ) {
                foreach( $door_color_detail['ColorSection'] as $color_section ) {
                    if( $color_section['type'] == 'door_material' ) {
                        $door_color_price = $color_section['price'];
                        break;
                    }
                }
            }
            unset($door_color_detail); // clean up
            unset($color); // clean up
        }

        // get cabinet color price
        $cabinet_color_price = 0;
        $cabinet_price_color = 0;
        $panel_price_color = 0;
        $cabinet_color_detail = array( );
        if( !empty($cabinet_color) ) {
            $color = new Color();
            $cabinet_color_detail = $color->find('first', array( 'conditions' => array( 'id' => $cabinet_color ) ));
            if( isset($cabinet_color_detail['ColorSection']) && !empty($cabinet_color_detail['ColorSection']) && is_array($cabinet_color_detail['ColorSection']) ) {
                foreach( $cabinet_color_detail['ColorSection'] as $color_section ) {
//          if ($color_section['type'] == 'cabinet_material') {
                    if( $color_section['type'] == 'cabinate_material' ) {
                        $cabinet_color_price = $color_section['price'];
                        $cabinet_price_color = $cabinet_color_price * $cabinet_sqft;
                        $debug_calculation .= "Cabinet Color Price = {$cabinet_color_price} <br />";
                        $debug_calculation .= "<b>Cabinet Price (Color) = {$cabinet_price_color} </b><br />";

                        $panel_price_color = $cabinet_color_price * $panel_sqft;
                        $debug_calculation .= "<b>Panel Price (Color) = {$panel_price_color} </b><br />";
                        $debug_calculation .= "<br />";
                        break;
                    }
                }
            }
            unset($cabinet_color_detail); // clean up
            unset($color); // clean up
        }

        $doors_drawers_price = 0;
        if( !empty($door_id) ) {
            $door = new Door();
            $door_detail = $door->find('first', array( 'conditions' => array( 'Door.id' => $door_id ) ));

            $door_cost_markup = $door_detail['Door']['cost_markup_factor'];
            $door_drawers = array( );
            $debug_calculation .= "Door/Drawer Cost Markup = {$door_cost_markup} <br />";
            $debug_calculation .= "<br />";

            $door_drawers['top_door'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['top_door_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['top_door_height'];
                $width = (float) $cabinet_detail['Cabinet']['top_door_width'];
                $count = (float) $cabinet_detail['Cabinet']['top_door_count'];
                $price_sqft = (float) $door_detail['Door']['wall_door_price'];
                $price_each = (float) $door_detail['Door']['wall_door_price_each'];
                $label = 'Top Door';

                $door_drawers['top_door'] = $this->calculateDoorDrawerForBuilder($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each);
                $debug_calculation .= "<br />";
            }

            $door_drawers['bottom_door'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['bottom_door_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['bottom_door_height'];
                $width = (float) $cabinet_detail['Cabinet']['bottom_door_width'];
                $count = (float) $cabinet_detail['Cabinet']['bottom_door_count'];
                $price_sqft = (float) $door_detail['Door']['door_price'];
                $price_each = (float) $door_detail['Door']['door_price_each'];
                $label = 'Bottom Door';

                $door_drawers['bottom_door'] = $this->calculateDoorDrawerForBuilder($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each);
                $debug_calculation .= "<br />";
            }

            $door_drawers['top_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['top_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['top_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['top_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['top_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['drawer_price'];
                $price_each = (float) $door_detail['Door']['drawer_price_each'];
                $label = 'Top Drawer Front';

                $door_drawers['top_drawer_front'] = $this->calculateDoorDrawerForBuilder($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

            $door_drawers['middle_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['middle_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['middle_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['middle_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['middle_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['lower_drawer_price'];
                $price_each = (float) $door_detail['Door']['lower_drawer_price_each'];
                $label = 'Middle Drawer Front';

                $door_drawers['middle_drawer_front'] = $this->calculateDoorDrawerForBuilder($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

            $door_drawers['bottom_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['bottom_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['bottom_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['bottom_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['bottom_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['lower_drawer_price'];
                $price_each = (float) $door_detail['Door']['lower_drawer_price_each'];
                $label = 'Bottom Drawer Front';

                $door_drawers['bottom_drawer_front'] = $this->calculateDoorDrawerForBuilder($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

            $door_drawers['dummy_drawer_front'] = array( 'sqft' => 0, 'price' => 0 );
            if( !empty($cabinet_detail['Cabinet']['dummy_drawer_front_count']) ) {
                $height = (float) $cabinet_detail['Cabinet']['dummy_drawer_front_height'];
                $width = (float) $cabinet_detail['Cabinet']['dummy_drawer_front_width'];
                $count = (float) $cabinet_detail['Cabinet']['dummy_drawer_front_count'];
                $price_sqft = (float) $door_detail['Door']['drawer_price'];
                $price_each = (float) $door_detail['Door']['drawer_price_each'];
                $label = 'Dummy Drawer Front';

                $door_drawers['dummy_drawer_front'] = $this->calculateDoorDrawerForBuilder($debug_calculation, $label, $height, $width, $count, $door_cost_markup, $price_sqft, $price_each, true);
                $debug_calculation .= "<br />";
            }

//      $debug = var_export($door_drawers, true);
//      $debug_calculation .= "Door/Drawer Price = {$debug} <br />";

            $doors_drawers_price = $this->sumDoorDrawer($door_drawers);
            $debug_calculation .= "<b>Door/Drawer Price = {$doors_drawers_price} </b><br />";
            $debug_calculation .= "<b>Bulm up Charge Total Price = {$this->bulm_up_charge_total} </b><br />";
            $debug_calculation .= "<br />";

            if( $door_color_price ) {
                $debug_calculation .= "Door Color Price = {$door_color_price} <br />";
                $debug_calculation .= "<br />";
                $doors_drawers_price_color = $this->sumDoorDrawerColorForBuilder($debug_calculation, $door_drawers, $door_color_price);
                $doors_drawers_price += $doors_drawers_price_color;
                $debug_calculation .= "<br />";
                $debug_calculation .= "<b>Door/Drawer Price (Color) = {$doors_drawers_price_color} </b><br />";
                $debug_calculation .= "<br />";
            }

            unset($door); // clean up
        }

        $inventory_lookup = new InventoryLookup();
        $inventory_lookup->recursive = -1;
        $drawer_departments = array( );
        $inventory_lookup_detail = $inventory_lookup->find('all', array( 'conditions' => array( 'InventoryLookup.lookup_type' => 'drawer' ) ));
        foreach( $inventory_lookup_detail as $inventory_lookup_row ) {
            $departments = $inventory_lookup->SearchCache2Array($inventory_lookup_row['InventoryLookup']['department_id']);
            foreach( $departments as $department ) {
                if( isset($drawer_departments[$department]) ) {
                    $drawer_departments[$department][] = $inventory_lookup_row['InventoryLookup']['id'];
                }
                else {
                    $drawer_departments[$department] = array( $inventory_lookup_row['InventoryLookup']['id'] );
                }
            }
        }

        $item = new Item();
        $items_price = 0;
        $discount = 0;
        $items = array( );
        if( !empty($cabinet_detail['CabinetsItem']) ) {
            foreach( $cabinet_detail['CabinetsItem'] as $cabinet_item ) {
                if( $cabinet_item['accessories'] )
                    continue; // skip the accessories

                $item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_item['item_id'] ) ));
                if( array_key_exists($item_detail['Item']['item_department_id'], $drawer_departments) ) {
                    if( !in_array($drawer_id, $drawer_departments[$item_detail['Item']['item_department_id']]) ) {
                        continue; // skip the un-selected drawer
                    }
                }
                $item_price = $item_detail['Item']['builder_price'];
//				$item_price = $item_detail['Item']['price'];
                $ItemMaterialPrice = null;
                if( isset($material_id) && !empty($material_id) ) {
                    $ItemMaterialPrice = $this->getItemMaterialPriceForBuilder($item, $cabinet_item['item_id'], $material_id, $debug_calculation);
                    $item_price = $ItemMaterialPrice['item_price'];
                }
                
                //Discount
//                if( $delivery_option == '5 – 10 Weeks Delivery' ) {
//                    $discount = $item_price * $this->default_discount;
//                    $item_price = $item_price - $discount;
//                }

                $item_calculated_price = ($cabinet_item['item_quantity'] * $item_price);
                $items_price += $item_calculated_price;

                if( $ItemMaterialPrice['sub_item'] ) {
                    $debug_calculation .= "Cabinet Item ({$ItemMaterialPrice['sub_item']['Item']['item_title']}) Price = {$ItemMaterialPrice['material_data']['Material']['price']} => Quantity = {$cabinet_item['item_quantity']} => Total = {$item_calculated_price} <br />";
                }
                else {
                    $debug_calculation .= "Cabinet Item ({$item_detail['Item']['item_title']}) Price = {$item_price} => Quantity = {$cabinet_item['item_quantity']} => Total = {$item_calculated_price} <br />";
                }

//        $items[] = array(
//            'id' => $item_detail['Item']['id'],
//            'item_title' => $item_detail['Item']['item_title'],
//            'price' => $item_price,
//            'base_price' => $item_detail['Item']['price'],
//            'quantity' => $cabinet_item['item_quantity'],
//        );
            }

            $debug_calculation .= "<b>Cabinet Item Price = {$items_price} </b><br />";
            $debug_calculation .= "<br />";

            unset($cabinet_detail); // clean up
        }

        $total_price = (($items_price + $cabinet_price_color + $panel_price_color + $doors_drawers_price + $this->bulm_up_charge_total) * $this->default_markup) * $quantity;
        
        $discount_rate = $this->getProductionTime($delivery_option);
        $discount = $total_price * $discount_rate;
        $total_price = $total_price - $discount;
        
        $debug_calculation .= "<b>Discount = {$discount} </b><br />";
        $debug_calculation .= "<b>Total Price = {$total_price} </b><br />";

        $result = array(
//        'items' => $items,
            'items_price' => $items_price,
            'doors_price' => $doors_drawers_price,
            'cabinet_color_price_color' => $cabinet_price_color,
            'total_price' => $total_price,
            'debug_calculation' => $debug_calculation,
            'conditions' => array(
                'resource_id' => $cabinet_id,
                'resource_type' => 'cabinet',
                'material_id' => $material_id,
                'door_id' => $door_id,
                'door_color' => $door_color,
                'cabinet_color' => $cabinet_color,
                'drawer_slide_id' => $drawer_slide_id,
                'drawer_id' => $drawer_id,
                'quantity' => $quantity,
            ),
        );
        return $result;
    }
    
    public function getProductionTime($id = null){
        App::uses("GeneralSetting", "PurchaseOrderManager.Model");
        $general_setting = new GeneralSetting();
        $data = $general_setting->find("first", array('conditions' => array('GeneralSetting.id' => $id)));
        
        $value = ($data['GeneralSetting']['value'] / 100);
        return $value;
    }

    public function calculateSQFT($height, $width, $no_minimum = FALSE) {
        $sqft = ($height * $width) / 92903.04; // milimeter to square foot
        if( ($sqft < 1) && (!$no_minimum) ) {
            $sqft = 1;  // minimum sqft will be one
        }

        return $sqft;
    }

    public function calculateDoorDrawer(&$debug_calculation, $label, $height, $width, $count = 1, $cost_markup = 1, $price_sqft = 0, $price_each = 0, $is_drawer = 0) {
        if( $count > 0 ) {
            if( $is_drawer ) {
                $this->bulm_up_charge_total += $count * $this->bulm_up_charge;
            }
            $sqft = $this->calculateSQFT($height, $width);
            $debug_calculation .= "{$label} (Count) = {$count} <br />";
            $debug_calculation .= "{$label} (SQFT) = {$sqft} <br />";
            $sqft = $sqft * $count;
            $debug_calculation .= "{$label} (SQFT) [With Count] = {$sqft} <br />";

            $debug_calculation .= "{$label} Price (SQFT) = {$price_sqft} <br />";
            $price_sqft = ($sqft * $price_sqft * $cost_markup);
            $debug_calculation .= "{$label} Price (SQFT) [Sub Total] = {$price_sqft} <br />";

            $debug_calculation .= "{$label} Price (EACH) = {$price_each} <br />";
            $price_each = ($price_each * $cost_markup * $count);
            $debug_calculation .= "{$label} Price (EACH) [Sub Total] = {$price_each} <br />";

            $price = ($price_sqft + $price_each);
            $debug_calculation .= "<b>{$label} Price (Total) = {$price} </b><br />";

            return array( 'sqft' => $sqft, 'price' => $price );
        }
        else {
            return array( 'sqft' => 0, 'price' => 0 );
        }
    }

    public function calculateDoorDrawerForBuilder(&$debug_calculation, $label, $height, $width, $count = 1, $cost_markup = 1, $price_sqft = 0, $price_each = 0, $is_drawer = 0) {
        if( $count > 0 ) {
            if( $is_drawer ) {
                $this->bulm_up_charge_total += $count * $this->bulm_up_charge;
            }
            $sqft = $this->calculateSQFT($height, $width);
            $debug_calculation .= "{$label} (Count) = {$count} <br />";
            $debug_calculation .= "{$label} (SQFT) = {$sqft} <br />";
            $sqft = $sqft * $count;
            $debug_calculation .= "{$label} (SQFT) [With Count] = {$sqft} <br />";

            $debug_calculation .= "{$label} Price (SQFT) = {$price_sqft} <br />";
            $price_sqft = ($sqft * $price_sqft * $cost_markup);
            $debug_calculation .= "{$label} Price (SQFT) [Sub Total] = {$price_sqft} <br />";

            $debug_calculation .= "{$label} Price (EACH) = {$price_each} <br />";
            $price_each = ($price_each * $cost_markup * $count);
            $debug_calculation .= "{$label} Price (EACH) [Sub Total] = {$price_each} <br />";

            $price = ($price_sqft + $price_each);
            $debug_calculation .= "<b>{$label} Price (Total) = {$price} </b><br />";

            return array( 'sqft' => $sqft, 'price' => $price );
        }
        else {
            return array( 'sqft' => 0, 'price' => 0 );
        }
    }

    public function sumDoorDrawer($door_drawers = array( )) {
        $total_price = 0;
        foreach( $door_drawers as $key => $value ) {
            $total_price += $value['price'];
        }

        return $total_price;
    }

    public function sumDoorDrawerColor(&$debug_calculation, $door_drawers = array( ), $door_color_price = 0) {
        $total_price = 0;
        foreach( $door_drawers as $key => $value ) {
            if( $value['sqft'] == 0 ) {
                continue; // skip the one with no info
            }
            $label = str_replace('_', ' ', $key);
            $label = ucwords($label);

            $door_drawer_color_price = $this->DoorDrawerColor($value['sqft'], $door_color_price);
            $debug_calculation .= "{$label} Color Price (Total) = {$door_drawer_color_price} <br />";
            $total_price += $door_drawer_color_price;
        }

        return $total_price;
    }

    public function sumDoorDrawerColorForBuilder(&$debug_calculation, $door_drawers = array( ), $door_color_price = 0) {
        $total_price = 0;
        foreach( $door_drawers as $key => $value ) {
            if( $value['sqft'] == 0 ) {
                continue; // skip the one with no info
            }
            $label = str_replace('_', ' ', $key);
            $label = ucwords($label);

            $door_drawer_color_price = $this->DoorDrawerColor($value['sqft'], $door_color_price);
            $debug_calculation .= "{$label} Color Price (Total) = {$door_drawer_color_price} <br />";
            $total_price += $door_drawer_color_price;
        }

        return $total_price;
    }

    public function calculateCabinetSQFT($cabinets_items, &$item = null, $material_id = null) {
        $cabinet_sqft = 0;
        if( $material_id && !is_null($item) ) {
            $material_data = $this->getMaterialDetail($material_id);
            $material_group_id = $material_data['MaterialGroup']['id'];
        }
        if( !is_null($item) ) {
            foreach( $cabinets_items as $cabinet_item ) {
                switch( $cabinet_item['Item']['item_department_id'] ) {
                    case 4: // #1
                    case 27: // #2
                    case 10: // #3
                    case 12: // #4
                    case 13: // #5
                    case 14: // #6
                    case 17: // #7
                        $selected_item = $cabinet_item;
                        $item_id = $cabinet_item['Item']['id'];
                        $base_item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $item_id ) ));
                        $selected_item = $base_item_detail;
                        $items_price = $selected_item['Item']['price'];

                        if( $material_id ) {
                            $item_detail = $item->find('first', array( 'conditions' => array( 'Item.base_item' => $item_id, 'Item.item_material_group' => $material_group_id ) ));
                            if( $item_detail ) {
                                // if found and proper item with material (group)
                                $selected_item = $item_detail;
                                $items_price = $selected_item['Item']['price'];
                            }
                        }

                        if( ($selected_item['Item']['width'] > 0) && ($selected_item['Item']['length'] > 0) ) {
                            $cabinet_sqft += ($cabinet_item['CabinetsItem']['item_quantity'] * $this->calculateSQFT($selected_item['Item']['length'], $selected_item['Item']['width']));
                        }
                        break;
                }
            }
        }

        return $cabinet_sqft;
    }

    public function calculateCabinetSQFTForBuilder($cabinets_items, &$item = null, $material_id = null) {
        $cabinet_sqft = 0;
        if( $material_id && !is_null($item) ) {
            $material_data = $this->getMaterialDetail($material_id);
            $material_group_id = $material_data['MaterialGroup']['id'];
        }
        if( !is_null($item) ) {
            foreach( $cabinets_items as $cabinet_item ) {
                switch( $cabinet_item['Item']['item_department_id'] ) {
                    case 4: // #1
                    case 27: // #2
                    case 10: // #3
                    case 12: // #4
                    case 13: // #5
                    case 14: // #6
                    case 17: // #7
                        $selected_item = $cabinet_item;
                        $item_id = $cabinet_item['Item']['id'];
                        $base_item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $item_id ) ));
                        $selected_item = $base_item_detail;
                        $items_price = $selected_item['Item']['builder_price'];
//						$items_price = $selected_item['Item']['price'];

                        if( $material_id ) {
                            $item_detail = $item->find('first', array( 'conditions' => array( 'Item.base_item' => $item_id, 'Item.item_material_group' => $material_group_id ) ));
                            if( $item_detail ) {
                                // if found and proper item with material (group)
                                $selected_item = $item_detail;
                                $items_price = $selected_item['Item']['builder_price'];
//								$items_price = $selected_item['Item']['price'];
                            }
                        }

                        if( ($selected_item['Item']['width'] > 0) && ($selected_item['Item']['length'] > 0) ) {
                            $cabinet_sqft += ($cabinet_item['CabinetsItem']['item_quantity'] * $this->calculateSQFT($selected_item['Item']['length'], $selected_item['Item']['width']));
                        }
                        break;
                }
            }
        }

        return $cabinet_sqft;
    }

    public function calculatePanelSQFT($cabinets_items) {
        $panel_sqft = 0;
        foreach( $cabinets_items as $cabinet_item ) {
            switch( $cabinet_item['Item']['item_department_id'] ) {
                case 18: // #10
                case 19: // #11
                case 22: // #14
                case 23: // #15
                    if( ($cabinet_item['Item']['width'] > 0) && ($cabinet_item['Item']['length'] > 0) ) {
                        $panel_sqft += ($cabinet_item['CabinetsItem']['item_quantity'] * $this->calculateSQFT($cabinet_item['Item']['length'], $cabinet_item['Item']['width']));
                    }
                    break;
            }
        }

        return $panel_sqft;
    }

    public function calculatePanelSQFTForBuilder($cabinets_items) {
        $panel_sqft = 0;
        foreach( $cabinets_items as $cabinet_item ) {
            switch( $cabinet_item['Item']['item_department_id'] ) {
                case 18: // #10
                case 19: // #11
                case 22: // #14
                case 23: // #15
                    if( ($cabinet_item['Item']['width'] > 0) && ($cabinet_item['Item']['length'] > 0) ) {
                        $panel_sqft += ($cabinet_item['CabinetsItem']['item_quantity'] * $this->calculateSQFT($cabinet_item['Item']['length'], $cabinet_item['Item']['width']));
                    }
                    break;
            }
        }

        return $panel_sqft;
    }

    public function calculateBoxTotal($cabinets_items, $door_id = 0, $drawer_id = 0, $drawer_slide = 0) {
        $door_id = (int) $door_id;
        $drawer_id = (int) $drawer_id;
        $drawer_slide = (int) $drawer_slide;
        $box_total = 0;
        foreach( $cabinets_items as $cabinet_item ) {
            switch( $cabinet_item['Item']['item_department_id'] ) {
                case 26: // #0
                case 4: // #1
                case 27: // #2
                case 10: // #3
                case 12: // #4
                case 13: // #5
                case 14: // #6
                case 15: // #7
                case 17: // #9
                case 18: // #10
                case 19: // #11
                case 20: // #12
                case 23: // #15
                    $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    break;
                case 5: // #13
                    if( $door_id > 0 ) {
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    }
                case 8: // #16
                    if( $drawer_slide == 129 ) { // Blum Undermount Slides
//            $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $this->bulm_up_charge);
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity']);
                    }
                    if( ($drawer_id == 120) || $drawer_id == 121 ) { // Dovetail Drawers || Metabox Drawers
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    }
                    break;
                case 9: // #17
                    if( $drawer_id == 122 ) { // Melamine Drawer Box
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    }
            }
        }

        return $box_total;
    }

    public function calculateBoxTotalForBuilder($cabinets_items, $door_id = 0, $drawer_id = 0, $drawer_slide = 0) {
        $door_id = (int) $door_id;
        $drawer_id = (int) $drawer_id;
        $drawer_slide = (int) $drawer_slide;
        $box_total = 0;
        foreach( $cabinets_items as $cabinet_item ) {
            switch( $cabinet_item['Item']['item_department_id'] ) {
                case 26: // #0
                case 4: // #1
                case 27: // #2
                case 10: // #3
                case 12: // #4
                case 13: // #5
                case 14: // #6
                case 15: // #7
                case 17: // #9
                case 18: // #10
                case 19: // #11
                case 20: // #12
                case 23: // #15
                    $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['builder_price']);
//					$box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    break;
                case 5: // #13
                    if( $door_id > 0 ) {
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['builder_price']);
//						$box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    }
                case 8: // #16
                    if( $drawer_slide == 129 ) { // Blum Undermount Slides
//            $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $this->bulm_up_charge);
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity']);
                    }
                    if( ($drawer_id == 120) || $drawer_id == 121 ) { // Dovetail Drawers || Metabox Drawers
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['builder_price']);
//						$box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    }
                    break;
                case 9: // #17
                    if( $drawer_id == 122 ) { // Melamine Drawer Box
                        $box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['builder_price']);
//						$box_total += ($cabinet_item['CabinetsItem']['item_quantity'] * $cabinet_item['Item']['price']);
                    }
            }
        }

        return $box_total;
    }

    private function getItemMaterialPrice(&$item, $item_id, $material_id, &$debug_calculation) {
        $base_item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $item_id ) ));
        $selected_item = $base_item_detail;
        $items_price = $selected_item['Item']['price'];
        $material_data = $this->getMaterialDetail($material_id);
        $material_group_id = $material_data['MaterialGroup']['id'];
        $item_sqft = 0;

        $item_detail = $item->find('first', array( 'conditions' => array( 'Item.base_item' => $item_id, 'Item.item_material_group' => $material_group_id ) ));
        if( $item_detail ) {
            // if found and proper item with material (group)
            $selected_item = $item_detail;
            $items_price = $selected_item['Item']['price'];
        }
        if( ($items_price <= 0) && ($material_data['MaterialGroup']['id']) ) {
            $item_sqft = $this->calculateSQFT($selected_item['Item']['length'], $selected_item['Item']['width']);
            if( $item_sqft < 1 ) {
                $item_sqft = 1;
            }
            $debug_calculation .= "Item SQFT = {$item_sqft} <br />";
            $items_price = $item_sqft * ($material_data['Material']['price'] / $this->calculateSQFT($material_data['Material']['length'], $material_data['Material']['width']));
        }
        return array( 'item_price' => $items_price, 'material_data' => $material_data, 'base_item' => $base_item_detail, 'sub_item' => $item_detail, 'item_sqft' => $item_sqft );
    }

    private function getItemMaterialPriceForBuilder(&$item, $item_id, $material_id, &$debug_calculation) {
        $base_item_detail = $item->find('first', array( 'conditions' => array( 'Item.id' => $item_id ) ));
        $selected_item = $base_item_detail;
        $items_price = $selected_item['Item']['builder_price'];
//		$items_price = $selected_item['Item']['price'];
        $material_data = $this->getMaterialDetail($material_id);
        $material_group_id = $material_data['MaterialGroup']['id'];
        $item_sqft = 0;

        $item_detail = $item->find('first', array( 'conditions' => array( 'Item.base_item' => $item_id, 'Item.item_material_group' => $material_group_id ) ));
        if( $item_detail ) {
            // if found and proper item with material (group)
            $selected_item = $item_detail;
            $items_price = $selected_item['Item']['builder_price'];
//			$items_price = $selected_item['Item']['price'];
        }
        if( ($items_price <= 0) && ($material_data['MaterialGroup']['id']) ) {
            $item_sqft = $this->calculateSQFT($selected_item['Item']['length'], $selected_item['Item']['width']);
            if( $item_sqft < 1 ) {
                $item_sqft = 1;
            }
            $debug_calculation .= "Item SQFT = {$item_sqft} <br />";
            $items_price = $item_sqft * ($material_data['Material']['price'] / $this->calculateSQFT($material_data['Material']['length'], $material_data['Material']['width']));
        }
        return array( 'item_price' => $items_price, 'material_data' => $material_data, 'base_item' => $base_item_detail, 'sub_item' => $item_detail, 'item_sqft' => $item_sqft );
    }

    private function DoorDrawerColor($door_drawer_sqft, $door_color_price) {
        return $door_drawer_sqft * $door_color_price;
    }

    private function getMaterialDetail($material_id) {
        App::import('Model', 'Inventory.Material');

        $material = new Material();
        $material_data = $material->find("first", array( "conditions" => array( 'Material.id' => $material_id ) ));
        return $material_data;
    }

}