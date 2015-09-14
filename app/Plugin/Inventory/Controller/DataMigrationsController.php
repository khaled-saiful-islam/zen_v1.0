<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Cabinets Controller
 *
 * @property Cabinet $Cabinet
 */
class DataMigrationsController extends InventoryAppController {

    public $uses = array( "Cabinet", "Supplier" );
    var $components = array( 'Auth' );

    /**
     * tasks before render the output
     */
    private $cabinet_data_settings = array( );

    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
    }

    /*
     * get Edgetape
     */

    function getEdgeTape() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, number, item_title, Department FROM `items` where Department = 'Edgetape'";
        $datas = $this->Cabinet->query($sql);
//        pr($datas);
        App::uses("ItemsOption", "Inventory.Model");
        foreach( $datas as $data ) {
            $item_option['ItemsOption']['inventory_lookup_id'] = 117;
            $item_option['ItemsOption']['item_id'] = $data['items']['id'];

            $ItemOption_model = new ItemsOption();
            if( !$ItemOption_model->save($item_option) ) {
                pr($ItemOption_model->validationErrors);
            }
        }
    }

    /*
     * Get Product Type for Cabinet
     */

    function getProductType() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, name, product_type FROM `cabinets`";
        $datas = $this->Cabinet->query($sql);
        //pr($datas);
        App::uses("Cabinet", "Inventory.Model");

        foreach( $datas as $data ) {
            $name = $data['cabinets']['name'];

            $sql2 = "SELECT Cabinet,UnitType FROM `cabinetlist` where Cabinet = '$name'";
            $d = $this->Cabinet->query($sql2);

            $type = $d[0]['cabinetlist']['UnitType'];

            $sql3 = "SELECT id, name, lookup_type FROM `inventory_lookups` where name = '$type' AND lookup_type = 'cabinet_type'";
            $type_data = $this->Cabinet->query($sql3);
//            pr($type_data[0]['inventory_lookups']['id']);
            if( !empty($type_data) ) {
                $cabinet['Cabinet']['id'] = $data['cabinets']['id'];
                $cabinet['Cabinet']['product_type'] = $type_data[0]['inventory_lookups']['id'];

                $Cabinet_model = new Cabinet();
                if( !$Cabinet_model->save($cabinet) ) {
                    pr($Cabinet_model->validationErrors);
                }
            }
            else {
                $cabinet['Cabinet']['id'] = $data['cabinets']['id'];
                $cabinet['Cabinet']['product_type'] = 137;

                $Cabinet_model = new Cabinet();
                if( !$Cabinet_model->save($cabinet) ) {
                    pr($Cabinet_model->validationErrors);
                }
            }
        }
    }

    /*
     * Put Standard to all Door Drilling
     */

    function doorDrilling() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, top_door_drilling, bottom_door_drilling FROM `cabinets`";
        $datas = $this->Cabinet->query($sql);

        App::uses("Cabinet", "Inventory.Model");
        foreach( $datas as $data ) {
            $cabinet['Cabinet']['id'] = $data['cabinets']['id'];
            $cabinet['Cabinet']['top_door_drilling'] = 1;
            $cabinet['Cabinet']['bottom_door_drilling'] = 1;

            $Cabinet_model = new Cabinet();
            if( !$Cabinet_model->save($cabinet) ) {
                pr($Cabinet_model->validationErrors);
            }
        }
    }

    /*
     * Put Standard to all Door Drilling
     */

    function getDowel() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, item_id, cabinet_id FROM `cabinets_items` where item_id = 15097";
        $datas = $this->Cabinet->query($sql);
//        pr($datas);exit;
        App::uses("CabinetsItem", "Inventory.Model");
        foreach( $datas as $data ) {
            $cabinet_item['CabinetsItem']['id'] = $data['cabinets_items']['id'];
            $cabinet_item['CabinetsItem']['accessories'] = 0;

            $CabinetsItem_model = new CabinetsItem();
            if( !$CabinetsItem_model->save($cabinet_item) ) {
                pr($CabinetsItem_model->validationErrors);
            }
        }
    }

    /*
     * To get New Accessories according to Anne
     */

    function getNewAccessroies() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, item_id FROM `cabinets_items`";
        $datas = $this->Cabinet->query($sql);

        App::uses("CabinetsItem", "Inventory.Model");

        foreach( $datas as $data ) {
            $id = $data['cabinets_items']['item_id'];
            $sql2 = "SELECT id, item_title, item_department_id, Department FROM `items` WHERE id = $id AND item_title LIKE '%Dowel%'";
            $d = $this->Cabinet->query($sql2);
//            pr($d);
            if( !empty($d) ) {
                $acc['CabinetsItem']['id'] = $data['cabinets_items']['id'];
                $acc['CabinetsItem']['accessories'] = 1;

                $CabinetsItem_model = new CabinetsItem();
                if( !$CabinetsItem_model->save($acc) ) {
                    pr($CabinetsItem_model->validationErrors);
                }
            }
        }
    }

    /*
     * Put Metabox Accessories
     */

    function putMetaboxAccessories() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT * FROM `items` where Department = 'Metabox'";
        $datas = $this->Cabinet->query($sql);
//        pr($datas);
        App::uses("Item", "Inventory.Model");
        foreach( $datas as $data ) {
            $item['Item']['id'] = $data['items']['id'];
            $item['Item']['item_department_id'] = 65;

            $Item_model = new Item();
            if( !$Item_model->save($item) ) {
                pr($Item_model->validationErrors);
            }
        }
    }

    /*
     * To get accessories to set 1
     */

    function getAccessories() {
        set_time_limit(0);
        $this->autoRender = false;
        $sql = "SELECT id,cabinet_id,item_id,accessories FROM cabinets_items
		WHERE accessories = 0";
        $datas = $this->Cabinet->query($sql);

        App::uses("CabinetsItem", "Inventory.Model");
        foreach( $datas as $data ) {
            $accessories['CabinetsItem']['id'] = $data['cabinets_items']['id'];
            $accessories['CabinetsItem']['accessories'] = 1;

            $CabinetsItem_model = new CabinetsItem();
            if( !$CabinetsItem_model->save($accessories) ) {
                pr($CabinetsItem_model->validationErrors);
            }
        }
    }

    /*
     * To get Installation lookup data
     */

    function getCabinetInstallation() {
        set_time_limit(0);
        $this->autoRender = false;
        $sql = "SELECT * FROM  install_tasks";
        $datas = $this->Cabinet->query($sql);

        App::uses("InventoryLookup", "Inventory.Model");
        foreach( $datas as $data ) {
            $installation['InventoryLookup']['name'] = $data['install_tasks']['description'];
            $installation['InventoryLookup']['lookup_type'] = "installation_type";
            $installation['InventoryLookup']['price'] = $data['install_tasks']['amount'];
            $installation['InventoryLookup']['price_unit'] = $data['install_tasks']['unit'];
            $installation['InventoryLookup']['value'] = $data['install_tasks']['description'];

            $InventoryLookup_model = new InventoryLookup();
            if( !$InventoryLookup_model->save($installation) ) {
                pr($InventoryLookup_model->validationErrors);
            }
        }
    }

    /*
     * to put same factor to builder factor
     */

    function getBuilderFactor() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, number, factor, price, builder_factor, builder_price FROM items ";
        $datas = $this->Cabinet->query($sql);

        App::uses("Item", "Inventory.Model");
        foreach( $datas as $data ) {
            $factor['Item']['id'] = $data['items']['id'];
            $factor['Item']['builder_factor'] = $data['items']['factor'];
            $factor['Item']['builder_price'] = $data['items']['price'];

            $Item_model = new Item();
            if( !$Item_model->save($factor) ) {
                pr($Item_model->validationErrors);
            }
        }
    }

    /*
     * Installation Data -> cabinets_installations table
     */

    function getcabinetInstallData() {
        set_time_limit(0);
        $this->autoRender = false;
        $sql = "SELECT id, cabinet_id, item_id FROM cabinets_items WHERE item_id = 15097
        ";
        $datas = $this->Cabinet->query($sql);
//        pr($datas);exit;
        App::uses("CabinetsInstallation", "Inventory.Model");

        foreach( $datas as $data ) {
            if( $data['cabinets_items']['cabinet_id'] != 0 ) {
                $cabinet_installation['CabinetsInstallation']['inventory_lookup_id'] = 216;
                $cabinet_installation['CabinetsInstallation']['cabinet_id'] = $data['cabinets_items']['cabinet_id'];

                $CabinetsInstallation_model = new CabinetsInstallation();
                if( !$CabinetsInstallation_model->save($cabinet_installation) ) {
                    pr($CabinetsInstallation_model->validationErrors);
                }
            }
        }
    }

    /*
     * update script
     */

    function getUpdateItem() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT * FROM `items`
		WHERE
			`item_title` LIKE '%-V Standard%'
			OR `item_title` LIKE '%-M Standard'
			OR `item_title` LIKE '%-P Standard';";
        $datas = $this->Cabinet->query($sql);

        foreach( $datas as $data ) {
//			$id = $data['items']['id'];
//			$sql = "DELETE FROM items WHERE id = ($id)";
//			$d = $this->Cabinet->query($sql);
//			foreach($d as $final){
//				$item_id = $final['items']['id'];
//				$sql_delete = "DELETE from items WHERE id = $item_id";
//				$this->Cabinet->query($sql_delete);
//			}			
        }
//		foreach($datas as $data){
//			$id = $data['items']['number'];
//			$sql = "SELECT * FROM  cabinets_items WHERE number IN ($id)";
//			$d = $this->Cabinet->query($sql);
//			pr($d);
//		}
    }

    /*
     * Update Item data based on import rules
     */

    function getNewItemData() {
        set_time_limit(0);
        $this->autoRender = false;

        $sql = "SELECT * FROM `items`
		WHERE
                `base_item` = 0;";
        $datas = $this->Cabinet->query($sql);

        App::uses("Item", "Inventory.Model");
        foreach( $datas as $data ) {
            $id = $data['items']['id'];
            $sql2 = "SELECT id, number, width, length, item_title, item_material_group FROM items WHERE base_item = $id AND item_material_group = 1 AND item_title LIKE 'BK%'";
            $d1 = $this->Cabinet->query($sql2);

            if( !empty($d1) ) {
                foreach( $d1 as $item_data ) {
                    $item['Item']['id'] = $item_data['items']['id'];
                    $item['Item']['width'] = $item_data['items']['width'] - 10;
                    $item['Item']['length'] = $item_data['items']['length'] - 10;
                    $item['Item']['description'] = $item_data['items']['item_title'];

                    $item_model = new Item();
                    if( !$item_model->save($item) ) {
                        pr($item_model->validationErrors);
                    }
                }
            }
        }
    }

    /*
     * updated script for item (title, item cost, factor, price)
     */

    function getUpdate() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT * FROM `items`
		WHERE
			`base_item` = 0;";
        $datas = $this->Cabinet->query($sql);

        App::uses("Item", "Inventory.Model");

        foreach( $datas as $data ) {
//			pr($data);
            $id = $data['items']['id'];
            $sql2 = "SELECT id, number, item_title FROM items WHERE base_item = $id";

            $d1 = $this->Cabinet->query($sql2);
//			pr($d1);

            foreach( $d1 as $item_data ) {
                $w_h['Item']['id'] = $item_data['items']['id'];
                $w_h['Item']['item_cost'] = $data['items']['item_cost'];
                $w_h['Item']['factor'] = $data['items']['factor'];
                $w_h['Item']['price'] = $data['items']['price'];

                $item_model = new Item();
                $item_model->save($w_h);
            }
//			foreach($d1 as $HPL){
//				$update1 = explode('HPL-19mm', $HPL['items']['item_title']);
//				$v_array['Item']['id'] = $HPL['items']['id'];
//				$v_array['Item']['item_title'] = $update1[0];
//				
//				$item_model = new Item();
//				$item_model->save($v_array);
            //}
        }
    }

    /*
     * To get updated Door
     */

    function geDoor() {
        set_time_limit(0);

        $this->autoRender = false;

        $sql = "SELECT DoorStyle, DoorImage FROM doorstyles";
        $datas = $this->Cabinet->query($sql);

        App::uses("Door", "Inventory.Model");
        $Door_model = new Door();

        $i = 1;
        foreach( $datas as $data ) {
            $door_data = $Door_model->find('first', array( 'fields' => array( 'id', 'door_style', 'door_image', 'door_image_dir' ), 'conditions' => array( 'Door.door_style' => $data['doorstyles']['DoorStyle'] ), 'recursive' => -1 ));

            $id = $door_data['Door']['id'];
            if( !empty($data['doorstyles']['DoorImage']) ) {
                mkdir(WWW_ROOT . 'files' . DS . 'door' . DS . 'door_image' . DS . $door_data['Door']['id'], 0777, TRUE);
                file_put_contents(WWW_ROOT . "files/door/door_image/$id/thumb_door_image.jpg", $data['doorstyles']['DoorImage']);
                file_put_contents(WWW_ROOT . "files/door/door_image/$id/xvga_door_image.jpg", $data['doorstyles']['DoorImage']);
                file_put_contents(WWW_ROOT . "files/door/door_image/$id/vga_door_image.jpg", $data['doorstyles']['DoorImage']);

                $door_image_data['Door']['id'] = $door_data['Door']['id'];
                $door_image_data['Door']['door_image'] = "door_image.jpg";
                $door_image_data['Door']['door_image_dir'] = $id;

                $Door_image_model = new Door();
                $Door_image_model->save($door_image_data);
            }
        }
    }

    /*
     * To get Image data
     */

    function getOtherImage() {
        set_time_limit(0);

        $this->autoRender = false;

        $sql = "SELECT DoorStyle, ProfileOutsideImage, ProfileInsideImage FROM doorstyles";
        $datas = $this->Cabinet->query($sql);

        App::uses("Door", "Inventory.Model");
        $Door_model = new Door();

        $i = 1;
        foreach( $datas as $data ) {
            $door_data = $Door_model->find('first', array( 'fields' => array( 'id', 'door_style', 'door_image', 'door_image_dir' ), 'conditions' => array( 'Door.door_style' => $data['doorstyles']['DoorStyle'] ), 'recursive' => -1 ));

            $id = $door_data['Door']['id'];
            if( !empty($data['doorstyles']['ProfileOutsideImage']) ) {

                mkdir(WWW_ROOT . 'files' . DS . 'door' . DS . 'outside_profile_image' . DS . $door_data['Door']['id'], 0777, TRUE);
                file_put_contents(WWW_ROOT . "files/door/outside_profile_image/$id/thumb_outside_profile_image.jpg", $data['doorstyles']['ProfileOutsideImage']);
                file_put_contents(WWW_ROOT . "files/door/outside_profile_image/$id/xvga_outside_profile_image.jpg", $data['doorstyles']['ProfileOutsideImage']);
                file_put_contents(WWW_ROOT . "files/door/outside_profile_image/$id/vga_outside_profile_image.jpg", $data['doorstyles']['ProfileOutsideImage']);

                $out_door_image_data['Door']['id'] = $door_data['Door']['id'];
                $out_door_image_data['Door']['outside_profile_image'] = "outside_profile_image.jpg";
                $out_door_image_data['Door']['outside_profile_image_dir'] = $id;

                $Door_image_model = new Door();
                $Door_image_model->save($out_door_image_data);
            }
            if( !empty($data['doorstyles']['ProfileInsideImage']) ) {

                mkdir(WWW_ROOT . 'files' . DS . 'door' . DS . 'inside_profile_image' . DS . $door_data['Door']['id'], 0777, TRUE);
                file_put_contents(WWW_ROOT . "files/door/inside_profile_image/$id/thumb_inside_profile_image.jpg", $data['doorstyles']['ProfileInsideImage']);
                file_put_contents(WWW_ROOT . "files/door/inside_profile_image/$id/xvga_inside_profile_image.jpg", $data['doorstyles']['ProfileInsideImage']);
                file_put_contents(WWW_ROOT . "files/door/inside_profile_image/$id/vga_inside_profile_image.jpg", $data['doorstyles']['ProfileInsideImage']);

                $in_door_image_data['Door']['id'] = $door_data['Door']['id'];
                $in_door_image_data['Door']['inside_profile_image'] = "inside_profile_image.jpg";
                $in_door_image_data['Door']['inside_profile_image_dir'] = $id;

                $Door_image_model = new Door();
                $Door_image_model->save($in_door_image_data);
            }
        }
    }

    /*
     * Emergency Item Update
     */

    function emergencyItemChange() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT * FROM `items` WHERE Department = 'Accessorie'";
        $datas = $this->Cabinet->query($sql);

        App::uses("Item", "Inventory.Model");
        foreach( $datas as $data ) {
            $item['Item']['id'] = $data['items']['id'];
            $item['Item']['item_department_id'] = 3;
            $item['Item']['Department'] = 'Accessories';

            $Item_model = new Item();
            if( !$Item_model->save($item) ) {
                pr($Item_model->validationErrors);
            }
        }
    }

    function changeAccessories() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT * FROM `cabinets_items`";
        $datas = $this->Cabinet->query($sql);

        App::uses("CabinetsItem", "Inventory.Model");
        foreach( $datas as $data ) {
            if( $data['cabinets_items']['accessories'] == 1 ) {
                $cabinet_item['CabinetsItem']['id'] = $data['cabinets_items']['id'];
                $cabinet_item['CabinetsItem']['accessories'] = 0;

                $CabinetsItem_model = new CabinetsItem();
                if( !$CabinetsItem_model->save($cabinet_item) ) {
                    pr($CabinetsItem_model->validationErrors);
                }
            }
        }
    }

    function getTESTCabinetItem() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT id, item_id FROM `cabinets_items`";
        $datas = $this->Cabinet->query($sql);

        App::uses("CabinetsItem", "Inventory.Model");

        foreach( $datas as $data ) {
            $id = $data['cabinets_items']['item_id'];
            $sql2 = "SELECT id, item_department_id, Department FROM `items` WHERE id = $id";
            $d = $this->Cabinet->query($sql2);

            if( !empty($d) ) {
                if( $d[0]['items']['item_department_id'] == 3 ) {

                    $c_a['CabinetsItem']['id'] = $data['cabinets_items']['id'];
                    $c_a['CabinetsItem']['accessories'] = 1;

                    $CabinetsItem_model = new CabinetsItem();
                    if( !$CabinetsItem_model->save($c_a) ) {
                        pr($CabinetsItem_model->validationErrors);
                    }
                }
            }

//            if(!empty($d)){
//                $base_id = $d[0]['items']['id'];
//                $sql3 = "SELECT id, item_department_id, Department FROM `items` WHERE base_item = $base_id";
//                $item_data = $this->Cabinet->query($sql3);
//                
//                $save_data['Item']['id'] = $base_id;
//                $save_data['Item']['item_department_id'] = $item_data[0]['items']['item_department_id'];
//                $save_data['Item']['Department'] = $item_data[0]['items']['Department'];
//                
//                $Item_model = new Item();
//                if( !$Item_model->save($save_data) ) {
//                    pr($Item_model->validationErrors);
//                }
//            }
        }
    }

    /*
     * Item old script. But we need it.
     */

    function getItem() {
        set_time_limit(0);

        $this->autoRender = false;
        $sql = "SELECT * FROM `inventory`
		WHERE
			`Description` NOT LIKE '%:V'
			AND `Description` NOT LIKE '%:M'
			AND `Description` NOT LIKE '%:P'
			AND `Description` NOT LIKE '%-V'
			AND `Description` NOT LIKE '%-M'
			AND `Description` NOT LIKE '%-P'
			AND `Department` NOT IN ( 'Stain', 'Sheet Stk', 'Sheet Goods' );";
        $datas = $this->Cabinet->query($sql);

        App::uses("Item", "Inventory.Model");

        App::uses("Supplier", "Inventory.Model");
        $supplier_model = new Supplier();

        App::uses("Material", "Inventory.Model");
        $Material_model = new Material();

        App::uses("ItemDepartment", "Inventory.Model");
        $ItemDepartment_model = new ItemDepartment();

        foreach( $datas as $data ) {
            $Item = new Item();
            $item_data = array( );
            $item_data['Item']['item_title'] = $data['inventory']['Description'];
            $item_data['Item']['number'] = $data['inventory']['Number'];
            $item_data['Item']['old_number'] = $data['inventory']['Number'];
            $item_data['Item']['description'] = $data['inventory']['Reference'];
            $item_data['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $item_data['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $item_data['Item']['minimum'] = $data['inventory']['Minimum'];
            $item_data['Item']['maximum'] = $data['inventory']['Maximum'];
            $item_data['Item']['location'] = $data['inventory']['Location'];

            $supplier_id = $supplier_model->find('first', array( 'fields' => array( 'id' ), 'conditions' => array( 'Supplier.name' => $data['inventory']['Supplier'] ), 'recursive' => -1 ));
            $item_data['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            $item_data['Item']['created'] = $data['inventory']['Created'];
            $item_data['Item']['modified'] = $data['inventory']['Modified'];
            $item_data['Item']['item_cost'] = $data['inventory']['Cost'];

            $item_data['Item']['PGM_Biesse'] = $data['inventory']['PGM_Biesse'];
            $item_data['Item']['PGM_Morbi'] = $data['inventory']['PGM_Morbi'];
            $item_data['Item']['PGM_Edgeband'] = $data['inventory']['PGM_Edgeband'];

            $item_data['Item']['material'] = "Standard";
            $item_data['Item']['item_material'] = 2;
            $item_data['Item']['item_material_group'] = 3;

            $item_data['Item']['variable_cost'] = $data['inventory']['Variablecost'];
            $item_data['Item']['main_item'] = $data['inventory']['Mainitem'];
            $item_data['Item']['base_item'] = 0;
            $item_data['Item']['Department'] = $data['inventory']['Department'];

            $department_id = $ItemDepartment_model->find('first', array( 'fields' => array( 'id', "name" ), 'conditions' => array( 'ItemDepartment.name' => $data['inventory']['Department'] ), 'recursive' => -1 ));
            $item_data['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];

            $item_data['Item']['price'] = $data['inventory']['Price'];
            $item_data['Item']['factor'] = $data['inventory']['Factor'];
            $item_data['Item']['image'] = $data['inventory']['Image'];
            $item_data['Item']['current_stock'] = !empty($data['inventory']['Onhand']) ? $data['inventory']['Onhand'] : 0;
            $item_data['Item']['item_group'] = 1;

            if( !$Item->save($item_data) ) {
                pr($Item->validationErrors);
            }

            //------------VENEER------------------------
            $Item_Veneer = new Item();
            $veneer = array( );
            $veneer['Item']['base_item'] = $Item->id;

            $veneer['Item']['material'] = "Maple";
            $veneer['Item']['item_material'] = 1;
            $veneer['Item']['item_material_group'] = 1;

            $veneer['Item']['description'] = $data['inventory']['Reference'];
            $veneer['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $veneer['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $veneer['Item']['Department'] = $data['inventory']['Department'];
            $veneer['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $veneer['Item']['item_group'] = 1;
            $veneer['Item']['item_title'] = $data['inventory']['Description'];

            $veneer['Item']['item_cost'] = $data['inventory']['Cost'];
            $veneer['Item']['price'] = $data['inventory']['Price'];
            $veneer['Item']['factor'] = $data['inventory']['Factor'];

            $veneer['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_Veneer->save($veneer) ) {
                pr($Item_Veneer->validationErrors);
            }

            //------------MDF------------------------
            $Item_MDF = new Item();
            $mdf = array( );
            $mdf['Item']['base_item'] = $Item->id;

            $mdf['Item']['material'] = $data['inventory']['Reference'];
            $mdf['Item']['item_material'] = 145;
            $mdf['Item']['item_material_group'] = 2;

            $mdf['Item']['description'] = 'ADJS';
            $mdf['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $mdf['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $mdf['Item']['Department'] = $data['inventory']['Department'];
            $mdf['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $mdf['Item']['item_group'] = 1;
            $mdf['Item']['item_title'] = $data['inventory']['Description'];

            $mdf['Item']['item_cost'] = $data['inventory']['Cost'];
            $mdf['Item']['price'] = $data['inventory']['Price'];
            $mdf['Item']['factor'] = $data['inventory']['Factor'];

            $mdf['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_MDF->save($mdf) ) {
                pr($Item_MDF->validationErrors);
            }

            //------------Plywood------------------------
            $Item_plywood = new Item();
            $plywood = array( );
            $plywood['Item']['base_item'] = $Item->id;

            $plywood['Item']['material'] = $data['inventory']['Reference'];
            $plywood['Item']['item_material'] = 3;
            $plywood['Item']['item_material_group'] = 4;

            $plywood['Item']['description'] = 'ADJS';
            $plywood['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $plywood['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $plywood['Item']['Department'] = $data['inventory']['Department'];
            $plywood['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $plywood['Item']['item_group'] = 1;
            $plywood['Item']['item_title'] = $data['inventory']['Description'];

            $plywood['Item']['item_cost'] = $data['inventory']['Cost'];
            $plywood['Item']['price'] = $data['inventory']['Price'];
            $plywood['Item']['factor'] = $data['inventory']['Factor'];

            $plywood['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_plywood->save($plywood) ) {
                pr($Item_plywood->validationErrors);
            }

            //------------Acrylic-19mm------------------------
            $Item_Acr19 = new Item();
            $Acr19 = array( );
            $Acr19['Item']['base_item'] = $Item->id;

            $Acr19['Item']['material'] = $data['inventory']['Reference'];
            $Acr19['Item']['item_material'] = 4;
            $Acr19['Item']['item_material_group'] = 5;

            $Acr19['Item']['description'] = 'ADJS';
            $Acr19['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $Acr19['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $Acr19['Item']['Department'] = $data['inventory']['Department'];
            $Acr19['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $Acr19['Item']['item_group'] = 1;
            $Acr19['Item']['item_title'] = $data['inventory']['Description'];

            $Acr19['Item']['item_cost'] = $data['inventory']['Cost'];
            $Acr19['Item']['price'] = $data['inventory']['Price'];
            $Acr19['Item']['factor'] = $data['inventory']['Factor'];

            $Acr19['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_Acr19->save($Acr19) ) {
                pr($Item_Acr19->validationErrors);
            }

            //------------Acrylic-38mm------------------------
            $Item_Acr38 = new Item();
            $Acr38 = array( );
            $Acr38['Item']['base_item'] = $Item->id;

            $Acr38['Item']['material'] = $data['inventory']['Reference'];
            $Acr38['Item']['item_material'] = 148;
            $Acr38['Item']['item_material_group'] = 6;

            $Acr38['Item']['description'] = 'ADJS';
            $Acr38['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $Acr38['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $Acr38['Item']['Department'] = $data['inventory']['Department'];
            $Acr38['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $Acr38['Item']['item_group'] = 1;
            $Acr38['Item']['item_title'] = $data['inventory']['Description'];

            $Acr38['Item']['item_cost'] = $data['inventory']['Cost'];
            $Acr38['Item']['price'] = $data['inventory']['Price'];
            $Acr38['Item']['factor'] = $data['inventory']['Factor'];

            $Acr38['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_Acr38->save($Acr38) ) {
                pr($Item_Acr38->validationErrors);
            }

            //------------HPL-19mm------------------------
            $Item_HPL19 = new Item();
            $HPL19 = array( );
            $HPL19['Item']['base_item'] = $Item->id;

            $HPL19['Item']['material'] = $data['inventory']['Reference'];
            $HPL19['Item']['item_material'] = 146;
            $HPL19['Item']['item_material_group'] = 7;

            $HPL19['Item']['description'] = 'ADJS';
            $HPL19['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $HPL19['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $HPL19['Item']['Department'] = $data['inventory']['Department'];
            $HPL19['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $HPL19['Item']['item_group'] = 1;
            $HPL19['Item']['item_title'] = $data['inventory']['Description'];

            $HPL19['Item']['item_cost'] = $data['inventory']['Cost'];
            $HPL19['Item']['price'] = $data['inventory']['Price'];
            $HPL19['Item']['factor'] = $data['inventory']['Factor'];

            $HPL19['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_HPL19->save($HPL19) ) {
                pr($Item_HPL19->validationErrors);
            }

            //------------HPL-38mm------------------------
            $Item_HPL38 = new Item();
            $HPL38 = array( );
            $HPL38['Item']['base_item'] = $Item->id;

            $HPL38['Item']['material'] = $data['inventory']['Reference'];
            $HPL38['Item']['item_material'] = 147;
            $HPL38['Item']['item_material_group'] = 8;

            $HPL38['Item']['description'] = 'ADJS';
            $HPL38['Item']['width'] = !empty($data['inventory']['Width']) ? $data['inventory']['Width'] : 0;
            $HPL38['Item']['length'] = !empty($data['inventory']['Length']) ? $data['inventory']['Length'] : 0;
            $HPL38['Item']['Department'] = $data['inventory']['Department'];
            $HPL38['Item']['item_department_id'] = $department_id['ItemDepartment']['id'];
            $HPL38['Item']['item_group'] = 1;
            $HPL38['Item']['item_title'] = $data['inventory']['Description'];

            $HPL38['Item']['item_cost'] = $data['inventory']['Cost'];
            $HPL38['Item']['price'] = $data['inventory']['Price'];
            $HPL38['Item']['factor'] = $data['inventory']['Factor'];

            $HPL38['Item']['supplier_id'] = $supplier_id['Supplier']['id'];

            if( !$Item_HPL38->save($HPL38) ) {
                pr($Item_HPL38->validationErrors);
            }
        }
    }

    /*
     * To get Material Data
     */

    function geMaterial() {
        $this->autoRender = false;
        $sql = "SELECT DISTINCT material FROM inventory;";
        $datas = $this->Cabinet->query($sql);

        App::uses("Material", "Inventory.Model");
        foreach( $datas as $data ) {
            $material = new Material();
            if( !empty($data['inventory']['material']) ) {
                $m['Material']['name'] = $data['inventory']['material'];
                $m['Material']['code'] = $data['inventory']['material'];
                $m['Material']['material_group_id'] = 9;
                $material->save($m);
            }
        }
    }

    /*
     * To get Department Data
     */

    function getDepartment() {
        $this->autoRender = false;
        $sql = "SELECT * FROM departments;";
        $datas = $this->Cabinet->query($sql);

        App::uses("ItemDepartment", "Inventory.Model");
        foreach( $datas as $data ) {
            $ItemDepartment = new ItemDepartment();

            $item_department['ItemDepartment']['name'] = $data['departments']['Department'];

            if( $data['departments']['Inactive'] == 0 )
                $item_department['ItemDepartment']['active'] = 1;
            else {
                $item_department['ItemDepartment']['active'] = 0;
            }
            $item_department['ItemDepartment']['supplier_required'] = $data['departments']['SupplierReqd'];
            $item_department['ItemDepartment']['stock_number_required'] = $data['departments']['StockNoReqd'];
            $item_department['ItemDepartment']['direct_sale'] = $data['departments']['NFR'];
            $item_department['ItemDepartment']['instruction'] = $data['departments']['Instructions'];
            $item_department['ItemDepartment']['qb_item_ref'] = $data['departments']['QBAccount'];

            if( !$ItemDepartment->save($item_department) ) {
                pr($ItemDepartment->validationErrors);
            }
        }
    }

    /*
     * To get Cabinet Data
     */

    function getCabinet() {
        $this->autoRender = false;

        $sql = "SELECT * FROM cabinetlist;";
        $datas = $this->Cabinet->query($sql);

        App::uses("Cabinet", "Inventory.Model");
        foreach( $datas as $data ) {
            $cabinet_model = new Cabinet();

            $cabinet_data['Cabinet']['name'] = $data['cabinetlist']['Cabinet'];
            $cabinet_data['Cabinet']['description'] = $data['cabinetlist']['Description'];

            $cabinet_data['Cabinet']['actual_dimensions_width'] = $data['cabinetlist']['Width'];
            $cabinet_data['Cabinet']['actual_dimensions_height'] = $data['cabinetlist']['Height'];
            $cabinet_data['Cabinet']['actual_dimensions_depth'] = $data['cabinetlist']['Depth'];

            $cabinet_data['Cabinet']['left_gable_price'] = $data['cabinetlist']['LeftGablePrice'];
            $cabinet_data['Cabinet']['right_gable_price'] = $data['cabinetlist']['RightGablePrice'];

            $cabinet_data['Cabinet']['top_bottom_width'] = $data['cabinetlist']['TBWidth'];
            $cabinet_data['Cabinet']['top_bottom_depth'] = $data['cabinetlist']['TBDepth'];
            $cabinet_data['Cabinet']['top_bottom_sqr'] = $data['cabinetlist']['TBSquareFeet'];

            $cabinet_data['Cabinet']['cabinet_back_width'] = $data['cabinetlist']['BackWidth'];
            $cabinet_data['Cabinet']['cabinet_back_height'] = $data['cabinetlist']['BackHeight'];
            $cabinet_data['Cabinet']['cabinet_back_sqr'] = $data['cabinetlist']['BackSquareFeet'];

            $cabinet_data['Cabinet']['MelCost'] = $data['cabinetlist']['MelCost'];
            $cabinet_data['Cabinet']['taping'] = $data['cabinetlist']['Taping'];
            $cabinet_data['Cabinet']['drilling'] = $data['cabinetlist']['Drilling'];
            $cabinet_data['Cabinet']['back_cutting'] = $data['cabinetlist']['BackCutting'];
            $cabinet_data['Cabinet']['BoxPrice'] = $data['cabinetlist']['BoxPrice'];

            $cabinet_data['Cabinet']['top_door_width'] = $data['cabinetlist']['TopDoorWidth'];
            $cabinet_data['Cabinet']['top_door_height'] = $data['cabinetlist']['TopDoorHeight'];
            $cabinet_data['Cabinet']['top_door_count'] = $data['cabinetlist']['TopDoorCount'];

            $cabinet_data['Cabinet']['bottom_door_width'] = $data['cabinetlist']['BottomDoorWidth'];
            $cabinet_data['Cabinet']['bottom_door_height'] = $data['cabinetlist']['BottomDoorHeight'];
            $cabinet_data['Cabinet']['bottom_door_count'] = $data['cabinetlist']['BottomDoorCount'];

            $cabinet_data['Cabinet']['top_drawer_front_width'] = $data['cabinetlist']['TopDrawerWidth'];
            $cabinet_data['Cabinet']['top_drawer_front_height'] = $data['cabinetlist']['TopDrawerHeight'];
            $cabinet_data['Cabinet']['top_drawer_front_count'] = $data['cabinetlist']['TopDrawerCount'];

            $cabinet_data['Cabinet']['middle_drawer_front_width'] = $data['cabinetlist']['MidDrawerWidth'];
            $cabinet_data['Cabinet']['middle_drawer_front_height'] = $data['cabinetlist']['MidDrawerHeight'];
            $cabinet_data['Cabinet']['middle_drawer_front_count'] = $data['cabinetlist']['MidDrawerCount'];

            $cabinet_data['Cabinet']['bottom_drawer_front_width'] = $data['cabinetlist']['BottomDrawerWidth'];
            $cabinet_data['Cabinet']['bottom_drawer_front_height'] = $data['cabinetlist']['BottomDrawerHeight'];
            $cabinet_data['Cabinet']['bottom_drawer_front_count'] = $data['cabinetlist']['BottomDrawerCount'];

            $cabinet_data['Cabinet']['dummy_drawer_front_width'] = $data['cabinetlist']['DummyHeight'];
            $cabinet_data['Cabinet']['dummy_drawer_front_height'] = $data['cabinetlist']['DummyWidth'];
            $cabinet_data['Cabinet']['dummy_drawer_front_count'] = $data['cabinetlist']['DummyCount'];

            $cabinet_data['Cabinet']['drawer_bottom_width'] = $data['cabinetlist']['DrawerBottomWidth'];
            $cabinet_data['Cabinet']['drawer_bottom_depth'] = $data['cabinetlist']['DrawerBottomDepth'];

            $cabinet_data['Cabinet']['number_hinges'] = $data['cabinetlist']['NumberofHinges'];
            $cabinet_data['Cabinet']['AssemblyCost'] = $data['cabinetlist']['AssemblyCost'];
            $cabinet_data['Cabinet']['UnitType'] = $data['cabinetlist']['UnitType'];

            $cabinet_data['Cabinet']['number_shelfs'] = $data['cabinetlist']['ShelfCount'];
            $cabinet_data['Cabinet']['Line'] = $data['cabinetlist']['Line'];
            $cabinet_data['Cabinet']['BothBotDoors'] = $data['cabinetlist']['BothBotDoors'];

            $cabinet_data['Cabinet']['include_on_door_list'] = $data['cabinetlist']['IncOnDoorList'];
            $cabinet_data['Cabinet']['include_on_finishing_list'] = $data['cabinetlist']['IncOnFinList'];

            $cabinet_data['Cabinet']['FinishedEndSquareFeet'] = $data['cabinetlist']['FinishedEndSquareFeet'];
            $cabinet_data['Cabinet']['FinishedEndPanelPrice'] = $data['cabinetlist']['FinishedEndPanelPrice'];
            $cabinet_data['Cabinet']['VeneerPanelSquareFeet'] = $data['cabinetlist']['VeneerPanelSquareFeet'];
            $cabinet_data['Cabinet']['VeneerPriceNotIncluded'] = $data['cabinetlist']['VeneerPriceNotIncluded'];
            $cabinet_data['Cabinet']['OutsideProfiling'] = $data['cabinetlist']['OutsideProfiling'];
            $cabinet_data['Cabinet']['DrawerCount'] = $data['cabinetlist']['DrawerCount'];
            $cabinet_data['Cabinet']['DrawerHardwareCost'] = $data['cabinetlist']['DrawerHardwareCost'];
            $cabinet_data['Cabinet']['ImageID'] = $data['cabinetlist']['ImageID'];


            if( !$cabinet_model->save($cabinet_data) ) {
                pr($cabinet_model->validationErrors);
            }
        }
    }

    /*
     * To get Cabinet Items Data
     */

    function getCabinetItems() {
        set_time_limit(0);
        $this->autoRender = false;

        $sql = "SELECT * FROM cabinetparts;";
        $datas = $this->Cabinet->query($sql);

        App::uses("CabinetsItem", "Inventory.Model");

        App::uses("Cabinet", "Inventory.Model");
        $Cabinet_model = new Cabinet();

        App::uses("Item", "Inventory.Model");
        $Item_model = new Item();

        foreach( $datas as $data ) {
            $CabinetsItem_model = new CabinetsItem();

            $cabinet_data['CabinetsItem']['lineid'] = $data['cabinetparts']['lineid'];

            $cabinet_data = $Cabinet_model->find('first', array( 'fields' => array( 'id', 'name' ), 'conditions' => array( 'Cabinet.name' => $data['cabinetparts']['cabinet'] ), 'recursive' => -1 ));
            $cabinet_data['CabinetsItem']['cabinet_id'] = !empty($cabinet_data['Cabinet']['id']) ? $cabinet_data['Cabinet']['id'] : "0";

            $Item_data = $Item_model->find('first', array( 'fields' => array( 'id', 'number' ), 'conditions' => array( 'Item.number' => $data['cabinetparts']['number'] ), 'recursive' => -1 ));
            $cabinet_data['CabinetsItem']['item_id'] = !empty($Item_data['Item']['id']) ? $Item_data['Item']['id'] : "0";

            if( !empty($Item_data) ) {
                $item['Item']['id'] = $Item_data['Item']['id'];
                $item['Item']['item_department_id'] = 3;
                $item['Item']['Department'] = 'Accessories';

                if( !$Item_model->save($item) ) {
                    pr($Item_model->validationErrors);
                }
            }

            $cabinet_data['CabinetsItem']['item_quantity'] = !empty($data['cabinetparts']['quantity']) ? $data['cabinetparts']['quantity'] : "1";
            $cabinet_data['CabinetsItem']['component'] = $data['cabinetparts']['component'];
            $cabinet_data['CabinetsItem']['category'] = $data['cabinetparts']['category'];
            $cabinet_data['CabinetsItem']['number'] = $data['cabinetparts']['number'];
            $cabinet_data['CabinetsItem']['accessories'] = 1;

            if( !$CabinetsItem_model->save($cabinet_data) ) {
                pr($CabinetsItem_model->validationErrors);
            }
        }
    }

    /*
     * To get Customer Data
     */

    function getCustomer() {
        $this->autoRender = false;

        $sql = "SELECT * FROM customer_old;";
        $datas = $this->Cabinet->query($sql);

        App::import("Model", "CustomerManager.Customer");
        App::import("Model", "CustomerManager.BuilderAccount");
        App::import("Model", "CustomerManager.CustomerAddress");

        foreach( $datas as $data ) {
            $Customer_model = new Customer();
            $BuilderAccount_model = new BuilderAccount();
            $CustomerAddress_model = new CustomerAddress();

            $cus_data['Customer']['last_name'] = $data['customer_old']['CustomerName'];
            $cus_data['Customer']['website'] = $data['customer_old']['WebSite'];
            if( $data['customer_old']['Inactive'] == 0 ) {
                $cus_data['Customer']['status'] = 1;
            }
            else {
                $cus_data['Customer']['status'] = 0;
            }
            $cus_data['Customer']['address'] = $data['customer_old']['loc_Address1'];
            $cus_data['Customer']['city'] = $data['customer_old']['loc_City'];
            $cus_data['Customer']['province'] = $data['customer_old']['loc_Province'];
            $cus_data['Customer']['postal_code'] = $data['customer_old']['loc_PostalCode'];
            $cus_data['Customer']['country'] = $data['customer_old']['loc_Country'];
            $cus_data['Customer']['phone'] = $data['customer_old']['loc_Phone'];
            $cus_data['Customer']['fax_number'] = $data['customer_old']['loc_FaxNumber'];
            $cus_data['Customer']['customer_type_id'] = 2;
            $cus_data['Customer']['site_address_exists'] = 1;
            $sales_person = array( $this->loginUser['id'] );
            $cus_data['Customer']['sales_representatives'] = serialize($sales_person);

            $Customer_model->save($cus_data['Customer']);

            App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
            $s = new CustomerSalesRepresentetives();
            $sales_data['customer_id'] = $Customer_model->id;
            $sales_data['user_id'] = $this->loginUser['id'];
            $s->save($sales_data);

            $cus_data['BuilderAccount']['customer_id'] = $Customer_model->id;
            $cus_data['BuilderAccount']['builder_legal_name'] = $data['customer_old']['CustomerName'];
            $cus_data['BuilderAccount']['credit_terms'] = $data['customer_old']['CreditTerms'];
            $cus_data['BuilderAccount']['credit_limit'] = $data['customer_old']['CreditLimit'];
            $cus_data['BuilderAccount']['invoice_on_day'] = $data['customer_old']['StartDate'];
            $cus_data['BuilderAccount']['quotes_validity'] = 30;

            $BuilderAccount_model->save($cus_data['BuilderAccount']);

            $cus_data['CustomerAddress']['customer_id'] = $Customer_model->id;
            $cus_data['CustomerAddress']['first_name'] = $data['customer_old']['con_ContactName'];
            $cus_data['CustomerAddress']['title'] = $data['customer_old']['con_Title'];
            $cus_data['CustomerAddress']['phone'] = $data['customer_old']['con_WorkPhone'];
            $cus_data['CustomerAddress']['fax_number'] = $data['customer_old']['con_FAX'];
            $cus_data['CustomerAddress']['cell'] = $data['customer_old']['con_MobilePhone'];
            $cus_data['CustomerAddress']['address'] = $data['customer_old']['con_Address1'];
            $cus_data['CustomerAddress']['city'] = $data['customer_old']['con_City'];
            $cus_data['CustomerAddress']['province'] = $data['customer_old']['con_Province'];
            $cus_data['CustomerAddress']['postal_code'] = $data['customer_old']['con_PostalCode'];
            $cus_data['CustomerAddress']['country'] = $data['customer_old']['con_Country'];
            $cus_data['CustomerAddress']['email'] = $data['customer_old']['con_eMail_Address'];

            $CustomerAddress_model->save($cus_data['CustomerAddress']);
        }
    }

    /*
     * To get User data
     */

    function getUser() {
        $this->autoRender = false;

        $sql = "SELECT * FROM users_old;";
        $datas = $this->Cabinet->query($sql);

        App::import("Model", "UserManager.User");

        $cnt = 10;
        foreach( $datas as $data ) {
            $User_model = new User();

            $user_data = array( );
            $user_data['User']['first_name'] = $data['users_old']['Lastname'];
            $user_data['User']['city'] = $data['users_old']['City'];
            $user_data['User']['province'] = $data['users_old']['Province'];
            $user_data['User']['postal_code'] = $data['users_old']['Postal'];
            $user_data['User']['country'] = $data['users_old']['Country'];
            $user_data['User']['work_phone'] = $data['users_old']['PhoneNumber'];
            $user_data['User']['email1'] = $data['users_old']['EMail'];

            if( $data['users_old']['Role'] == 2 )
                $user_data['User']['role'] = 94;
            else if( $data['users_old']['Role'] == 0 )
                $user_data['User']['role'] = 98;
            else if( $data['users_old']['Role'] == 5 )
                $user_data['User']['role'] = 95;

            $user_data['User']['username'] = $data['users_old']['Username'];
            $user_data['User']['screetp'] = $this->Auth->password($data['users_old']['Password']);

            $user_data['User']['last_logindate'] = $data['users_old']['LastLogon'];
            $user_data['User']['remark'] = $data['users_old']['Comments'];
            $user_data['User']['status'] = 1;

            $user_data['User']['empid'] = "EM" . $cnt;

            $User_model->save($user_data['User'], false);

            $cnt++;
        }
    }

    /*
     * To get Color Data
     */

    function getColor() {
        $this->autoRender = false;

        $sql = "select * from inventory where Department = 'Stain';";
        $datas = $this->Cabinet->query($sql);

        App::import("Model", "Inventory.Color");
        App::import("Model", "Inventory.ColorSection");

        $i = 1;
        foreach( $datas as $data ) {
            $color_model = new Color();

            $color_data = array( );
            $color_data['Color']['name'] = $data['inventory']['Description'];
            $color_data['Color']['code'] = $data['inventory']['Material'] . "C" . $i;

            if( !$color_model->save($color_data) ) {
                pr($color_model->validationErrors);
            }

            //Cabinet Material
            $cabinet_material_data = array( );
            $cabinet_material_data['ColorSection']['color_id'] = $color_model->id;
            $cabinet_material_data['ColorSection']['edgetape_id'] = 0;
            $cabinet_material_data['ColorSection']['cost'] = $data['inventory']['Cost'];
            $cabinet_material_data['ColorSection']['markup'] = 1;
            $cabinet_material_data['ColorSection']['price'] = $data['inventory']['Price'];
            $cabinet_material_data['ColorSection']['type'] = "cabinate_material";

            $color_section_model1 = new ColorSection();

            if( !$color_section_model1->save($cabinet_material_data) ) {
                pr($color_section_model1->validationErrors);
            }

            //Door Material
            $door_material_data = array( );
            $door_material_data['ColorSection']['color_id'] = $color_model->id;
            $door_material_data['ColorSection']['edgetape_id'] = 0;
            $door_material_data['ColorSection']['cost'] = $data['inventory']['Cost'];
            $door_material_data['ColorSection']['markup'] = 1;
            $door_material_data['ColorSection']['price'] = $data['inventory']['Price'];
            $door_material_data['ColorSection']['type'] = "door_material";

            $color_section_model2 = new ColorSection();

            if( !$color_section_model2->save($door_material_data) ) {
                pr($color_section_model2->validationErrors);
            }
            $i++;
        }
    }

    /**
     * To get Vendor from client's Data
     */
    function getVendor() {
        $this->autoRender = false;
        $sql = "SELECT * FROM vendors;";
        $datas = $this->Cabinet->query($sql);

        App::uses("Supplier", "Inventory.Model");
        foreach( $datas as $data ) {
            $supplier = new Supplier();

            $vendor['Supplier']['name'] = $data['vendors']['Name'];
            $vendor['Supplier']['address'] = $data['vendors']['AddressLine1'];
            $vendor['Supplier']['city'] = $data['vendors']['City'];
            $vendor['Supplier']['postal_code'] = $data['vendors']['Postal'];
            $vendor['Supplier']['province'] = $data['vendors']['Province'];
            $vendor['Supplier']['country'] = "Canada";
            $vendor['Supplier']['phone'] = $data['vendors']['PhoneNumber'];
            $vendor['Supplier']['fax_number'] = $data['vendors']['FaxNumber'];
            $vendor['Supplier']['terms'] = $data['vendors']['Terms'];
            $vendor['Supplier']['notes'] = $data['vendors']['Notes'];
            $vendor['Supplier']['email'] = $data['vendors']['EmailAddress'];
            $vendor['Supplier']['qb_suplier_name'] = $data['vendors']['QBAccountName'];

            $vendor['Supplier']['door_supplier'] = $data['vendors']['DoorVendor'];
            $vendor['Supplier']['cabinet_supplier'] = $data['vendors']['BoxVendor'];
            $vendor['Supplier']['laminate_supplier'] = $data['vendors']['LaminateVendor'];
            $vendor['Supplier']['hardware_supplier'] = $data['vendors']['HardwareVendor'];

            $vendor['Supplier']['gst_rate'] = $data['vendors']['GST'];
            $vendor['Supplier']['pst_rate'] = $data['vendors']['PST'];

            $vendor['Supplier']['notes_on_po'] = $data['vendors']['POMemo'];

            if( !$supplier->save($vendor) ) {
                pr($supplier->validationErrors);
            }
        }
    }

}
