<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Items Controller
 *
 * @property Item $Item
 */
class ItemsController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "item-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_item";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'item_template';
        }

        $this->side_bar = "item";
        $this->set("side_bar", $this->side_bar);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->layoutOpt['left_nav_selected'] = "view_item";

        $this->Item->recursive = 0;

        if( !isset($this->params['named']['limit']) ) {
            $this->paginate['limit'] = REPORT_LIMIT;
            $this->paginate['maxLimit'] = REPORT_LIMIT;
        }
        elseif( isset($this->params['named']['limit']) && $this->params['named']['limit'] != 'All' ) {
            $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
            $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
        }
        else {
            $this->paginate['limit'] = 0;
            $this->paginate['maxLimit'] = 0;
        }
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Item->parseCriteria($this->passedArgs);
        $this->paginate['conditions']['Item.base_item']['base_item'] = 0;

        $items = $this->paginate();
        $paginate = true;
        $legend = "Items";

        $this->set(compact('items', 'paginate', 'legend'));
    }

    /*
     * Builder Price Setting
     */

    function builder_price() {

        $this->Item->recursive = 0;

        if( !isset($this->params['named']['limit']) ) {
            $this->paginate['limit'] = REPORT_LIMIT;
            $this->paginate['maxLimit'] = REPORT_LIMIT;
        }
        elseif( isset($this->params['named']['limit']) && $this->params['named']['limit'] != 'All' ) {
            $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
            $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
        }
        else {
            $this->paginate['limit'] = 0;
            $this->paginate['maxLimit'] = 0;
        }
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Item->parseCriteria($this->passedArgs);
        $this->paginate['conditions']['Item.base_item']['base_item'] = 0;

        $items = $this->paginate();
        $paginate = true;
        $legend = "Items";

        $this->set(compact('items', 'paginate', 'legend'));
    }

    /*
     * Builder Price Edit
     */

    function edit_builder_price($id = null) {

        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->Item->save($this->request->data) ) {
                $this->redirect(array( 'action' => 'builder_price', $this->request->data['Item']['id'] ));
            }
            else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        $item = $this->Item->find('first', array( 'conditions' => array( 'Item.id' => $id ) ));

        $this->set(compact('item'));
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->layoutOpt['left_nav_selected'] = "view_item";

        $this->Item->id = $id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }

        $item = $this->Item->read(null, $id);

        App::import('Model', 'Inventory.ItemInventoryTransaction');
        $itemInventoryTransactionModel = new ItemInventoryTransaction();
        $itemInventoryTransaction = $itemInventoryTransactionModel->find('all', array( 'conditions' => array( 'ItemInventoryTransaction.item_id' => $id ) ));

        $this->set(compact('item', 'itemInventoryTransaction', 'id'));
    }

    /**
     * print/pdf view method
     *
     * @param string $id
     * @return void
     */
    public function print_detail($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Item->id = $id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        $item = $this->Item->read(null, $id);

        App::import('Model', 'Inventory.ItemInventoryTransaction');
        $itemInventoryTransactionModel = new ItemInventoryTransaction();
        $itemInventoryTransaction = $itemInventoryTransactionModel->find('all', array( 'conditions' => array( 'ItemInventoryTransaction.item_id' => $id ) ));
        $reportTitle = "Detail Report";
        $reportDate = date('l, F d, Y');

        $this->set(compact('item', 'itemInventoryTransaction', 'reportTitle', 'reportDate'));
    }

    /**
     * generate barcode method
     *
     * @param string $id
     * @return void
     */
    public function barcode($id = null) {
        $this->layoutOpt['layout'] = 'ajax';

        $this->Item->id = $id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        $this->set('item', $this->Item->read(null, $id));
    }

    /**
     * print barcode and labels view method
     *
     * @param string $id
     * @return void
     */
    public function print_label($id = null) {
        $this->layoutOpt['layout'] = 'ajax';

        $this->Item->id = $id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        $this->set('item', $this->Item->read(null, $id));
    }

    public function add_to_inventory($id = null) {
        $item = $this->Item->find("first", array( "conditions" => array( "Item.id" => $id ) ));

        $this->layoutOpt['left_nav_selected'] = false;
        if( !empty($this->request->data) ) {
            $this->request->data['ItemInventoryTransaction']['direction'] = 'in';
            //$this->request->data['ItemInventoryTransaction']['item_id'] = $id;
            $this->request->data['ItemInventoryTransaction']['type'] = "add";

            $item = $this->Item->find("first", array( "conditions" => array( "Item.id" => $id ) ));

            $item['Item']['current_stock'] = $item['Item']['current_stock'] + $this->request->data['ItemInventoryTransaction']['count'];
            $item['Item']['id'] = $id;
            $this->Item->save($item);

            App::import('Model', 'Inventory.ItemInventoryTransaction');
            $iteminventorytransaction = new ItemInventoryTransaction();
            $inventory = $iteminventorytransaction->save($this->request->data);

            if( $inventory['ItemInventoryTransaction']['id'] ) {
                $this->Session->setFlash(SAVE_SUCCESS_MSG, "Messages/success");
                $this->redirect(array( "controller" => "items", "action" => "detail", $id ));
            }
            else {
                $this->Session->setFlash(SAVE_FAILED_MODAL_MSG, "Messages/failed");
                $this->redirect(array( "controller" => "items", "action" => "detail", $id ));
            }
        }
        $this->set(compact('id', 'item'));
    }

    function get_history($id = null) {
        $this->set('item', $this->Item->read(null, $id));

        App::import('Model', 'Inventory.ItemInventoryTransaction');
        $iteminventorytransactionModel = new ItemInventoryTransaction();
        $itemInventoryTransaction = $iteminventorytransactionModel->find('all', array( 'conditions' => array( 'ItemInventoryTransaction.item_id' => $id ) ));
        $this->set(compact('itemInventoryTransaction'));
    }

    function get_base_item_list() {
        $item_title = $this->request->query['term'];
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $item_list = array( );
        $item_list = $item->find("all", array( 'conditions' => array( 'base_item' => '0', 'item_title like' => "%{$item_title}%" ), 'order' => array( 'item_title' => 'asc' ), 'limit' => 10 ));

        $return_data = array( );
        $index = 0;
        foreach( $item_list as $id => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val['Item']['id'];
                $return_data[$index]['text'] = $val['Item']['item_title'];
                $return_data[$index]['detail'] = $val['Item'];
                $index++;
            }
        }
        print json_encode($return_data);
        exit;
    }

    function get_item_list() {
        $item_title = $this->request->query['term'];
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $item_list = array( );
        $item_list = $item->find("all", array( 'conditions' => array( 'item_title like' => "%{$item_title}%" ), 'order' => array( 'item_title' => 'asc' ), 'limit' => 10 ));

        $return_data = array( );
        $index = 0;
        foreach( $item_list as $id => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val['Item']['id'];
                $return_data[$index]['text'] = $val['Item']['item_title'];
                $return_data[$index]['detail'] = $val['Item'];
                $index++;
            }
        }
        print json_encode($return_data);
        exit;
    }

    function get_item_edgetape() {
        App::uses('Sanitize', 'Utility');
        $item_title = Sanitize::escape($this->request->query['term']);

        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $query = "SELECT items.id AS id, items.item_title AS code, 'item' AS item_type, items.price AS price, items.item_title AS title
                FROM items
                LEFT JOIN `items_options` `items_options` ON `items_options`.item_id = items.id
                WHERE `items_options`.inventory_lookup_id = 117 AND items.item_title LIKE '%{$item_title}%'";
        $item_list = $item->query($query);

        $return_data = array( );
        $index = 0;
        foreach( $item_list as $id => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val['items']['id'];
                $return_data[$index]['text'] = $val['items']['code'];
                $index++;
            }
        }
        print json_encode($return_data);
        exit;
    }

    function get_item_accessories() {
        App::uses('Sanitize', 'Utility');
        $item_title = Sanitize::escape($this->request->query['term']);

        App::import("Model", "Inventory.Item");
        $item = new Item();
        $query = "SELECT items.id AS id, items.item_title AS code, 'item' AS item_type, items.price AS price, items.item_title AS title
                FROM items
                LEFT JOIN `item_departments` `item_departments` ON `item_departments`.id = items.item_department_id
                WHERE `item_departments`.id = 3 AND items.item_title LIKE '%{$item_title}%' ORDER BY items.item_title ASC";
        $item_list = $item->query($query);

        $return_data = array( );
        $index = 0;
        foreach( $item_list as $id => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val['items']['id'];
                $return_data[$index]['text'] = $val['items']['code'];
                $item_detail = $item->find("first", array( 'conditions' => array( 'Item.id' => $val['items']['id'] ), 'limit' => 1 ));
                $return_data[$index]['detail'] = $item_detail['Item'];
                $index++;
            }
        }
        print json_encode($return_data);
        exit;
    }

    function item_json() {
        $id = $this->request->query['term'];
        App::import("Model", "Inventory.Item");
        $item = new Item();
//    $item->recursive = 2;
        $item_list = array( );
        $item_list = $item->find("all", array( 'conditions' => array( 'Item.id' => $id ), 'order' => array( 'item_title' => 'asc' ), 'limit' => 1 ));

        $return_data = array( );
        foreach( $item_list as $id => $val ) {
            if( $val ) {
                $return_data['id'] = $val['Item']['id'];
                $return_data['text'] = $val['Item']['item_title'];
                $return_data['detail'] = $val['Item'];
                $return_data['complete_detail'] = $val;
                $return_data['item_type'] = 'item';
                $return_data['door_count'] = 0;
                $return_data['quote_color_required'] = 0;
                $return_data['quote_material_required'] = 0;
                break;
            }
        }
        print json_encode($return_data);
        exit;
    }

    public function damaged($id = null) {
        $this->layoutOpt['left_nav_selected'] = false;
        if( !empty($this->request->data) ) {
            $this->request->data['ItemInventoryTransaction']['direction'] = 'out';
            $this->request->data['ItemInventoryTransaction']['item_id'] = $id;
            $this->request->data['ItemInventoryTransaction']['type'] = "damaged";

            $item = $this->Item->find("first", array( "conditions" => array( "Item.id" => $id ) ));
            $item['Item']['current_stock'] = $item['Item']['current_stock'] - $this->request->data['ItemInventoryTransaction']['count'];
            $item['Item']['id'] = $id;
            $this->Item->save($item);

            App::import('Model', 'Inventory.ItemInventoryTransaction');
            $iteminventorytransaction = new ItemInventoryTransaction();
            $inventory = $iteminventorytransaction->save($this->request->data);

            if( $inventory['ItemInventoryTransaction']['id'] ) {
                $this->Session->setFlash(SAVE_SUCCESS_MSG, "Messages/success");
                $this->redirect(array( "controller" => "items", "action" => "detail", $id ));
            }
            else {
                $this->Session->setFlash(SAVE_FAILED_MODAL_MSG, "Messages/failed");
                $this->redirect(array( "controller" => "items", "action" => "detail", $id ));
            }
        }
        $this->set(compact('id'));
    }

    /**
     * check item department required field
     *
     * return boolean
     */
    private function check_item_department_required($field, $value) {
        if( $field ) {
            if( $value == "" || empty($value) ) {
                return false;
            }
        }
        return true;
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($id = null) {
        $id = (int) $id;
        if( $id == 0 )
            $id = null;

        //pr($this->request->data);exit;
        $this->layoutOpt['left_nav_selected'] = "add_item";
        if( $this->request->is('post') || $this->request->is('put') ) {

            $etape_Std = 0;
            $etape_Cust = 0;
            if( substr($this->request->data['Item']['item_title'], 0, 2) == 'wg' ) {
                $etape_Std = ($this->request->data['Item']['width'] * 2) + 60;
                $etape_Cust = $this->request->data['Item']['length'] + 30;
            }
            if( substr($this->request->data['Item']['item_title'], 0, 2) == 'wb' || substr($this->request->data['Item']['item_title'], 0, 2) == 'ad' ) {
                $etape_Std = $this->request->data['Item']['length'] + 30;
            }
            if( substr($this->request->data['Item']['item_title'], 0, 2) == 'vk' ) {
                $etape_Std = ($this->request->data['Item']['length'] * 2) + ($this->request->data['Item']['width'] * 2) + 120;
            }
            if( substr($this->request->data['Item']['item_title'], 0, 2) == 'bg' || substr($this->request->data['Item']['item_title'], 0, 2) == 'vg' || substr($this->request->data['Item']['item_title'], 0, 2) == 'pg' || substr($this->request->data['Item']['item_title'], 0, 2) == 'sp' || substr($this->request->data['Item']['item_title'], 0, 2) == 'bc' || substr($this->request->data['Item']['item_title'], 0, 2) == 'tb' || substr($this->request->data['Item']['item_title'], 0, 2) == 'fs' || substr($this->request->data['Item']['item_title'], 0, 2) == 'bh' || substr($this->request->data['Item']['item_title'], 0, 2) == 'bb' ) {
                $etape_Cust = $this->request->data['Item']['length'] + 30;
            }
            $this->request->data['Item']['etape_std'] = $etape_Std;
            $this->request->data['Item']['etape_cust'] = $etape_Cust;

            $item_cost = trim($this->request->data['Item']['item_cost']);
            $factor = trim($this->request->data['Item']['factor']);
            $supplier_id = $this->request->data['Item']['supplier_id'];
            $stock = $this->request->data['Item']['current_stock'];
            $department_id = trim($this->request->data['Item']['item_department_id']);
            if( is_null($id) ) {
                $this->request->data['Item']['base_item'] = 0;
            }
            else {
                $this->request->data['Item']['base_item'] = (int) $id;
                $this->request->params['pass'] = array( );
            }

            $price = round($item_cost * $factor, 2);
            $this->request->data['Item']['price'] = $price;
            $item_department = $this->Item->ItemDepartment->find('all', array( 'conditions' => array( 'id' => $department_id ) ));

            if( !$this->check_item_department_required($item_department[0]['ItemDepartment']['supplier_required'], $supplier_id) ) {
                $this->Session->setFlash(__('Your selected item department required supplier. Please, select supplier.'), 'default', array( 'class' => 'text-error' ));
            }
            elseif( !$this->check_item_department_required($item_department[0]['ItemDepartment']['stock_number_required'], $stock) ) {
                $this->Session->setFlash(__('Your selected item department required stock. Please, insert current stock.'), 'default', array( 'class' => 'text-error' ));
            }
            else {
                $this->Item->id = null;
                $this->Item->create();
                if( $this->Item->save($this->request->data) ) {
                    $this->Session->setFlash(__('The item has been saved'), 'default', array( 'class' => 'text-success' ));
                    if( is_null($id) ) {
                        $this->redirect(array( 'action' => DETAIL, $this->Item->id ));
                    }
                    else {
                        $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}inventory/items/detail/{$id}#item-sub");
//            $this->redirect(array('action' => 'detail_section', $id, 'item-sub'));
                    }
                }
                else {
                    $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
                }
            }
        }
        $this->Item->id = $id;
        if( $this->Item->exists() ) {
            $this->request->data = $this->Item->read(null, $id);
            $this->Item->id = null;
        }
        else {
            $this->Item->id = null;
        }
        $suppliers = $this->Item->Supplier->find('list');
        $itemDepartments = $this->Item->ItemDepartment->find('list');
        $cabinets = $this->Item->Cabinet->find('list');
        $this->set(compact('suppliers', 'itemDepartments', 'cabinets', 'id'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($item_id = null, $section = null) {
        //pr($this->request->data);exit;
        $item_id = (int) $item_id;
        $this->Item->id = $item_id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( !$section ) {
                $item_cost = trim($this->request->data['Item']['item_cost']);
                $factor = trim($this->request->data['Item']['factor']);
                $supplier_id = $this->request->data['Item']['supplier_id'];
                $stock = $this->request->data['Item']['current_stock'];
                $department_id = trim($this->request->data['Item']['item_department_id']);

                $price = round($item_cost * $factor, 2);
                $this->request->data['Item']['price'] = $price;
                $item_department = $this->Item->ItemDepartment->find('all', array( 'conditions' => array( 'id' => $department_id ) ));


                if( !$this->check_item_department_required($item_department[0]['ItemDepartment']['supplier_required'], $supplier_id) ) {
                    $this->Session->setFlash(__('Your selected item department required supplier. Please, select supplier.'), 'default', array( 'class' => 'text-error' ));
                }
                elseif( !$this->check_item_department_required($item_department[0]['ItemDepartment']['stock_number_required'], $stock) ) {
                    $this->Session->setFlash(__('Your selected item department required stock. Please, insert current stock.'), 'default', array( 'class' => 'text-error' ));
                }
                else {
//          if (isset($this->request->data['ItemOption'])) {
//            $item_value = explode(',', $this->request->data['ItemOption']['ItemOption']);
//            $this->request->data['ItemOption']['ItemOption'] = $item_value;
//          }
                    if( $this->Item->save($this->request->data) ) {
                        $this->Session->setFlash(__('The item has been saved'), 'default', array( 'class' => 'text-success' ));
//            $this->redirect(array('action' => 'detail_section', $item_id, $section));
                        $this->redirect(array( 'action' => 'detail', $item_id, $section ));
                    }
                    else {
                        $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
                    }
                }
            }
            else {
                if( isset($this->request->data['ItemOption']) ) {
                    $item_value = explode(',', $this->request->data['ItemOption']['ItemOption']);
                    $this->request->data['ItemOption']['ItemOption'] = $item_value;
                }
                if( $this->Item->save($this->request->data) ) {
                    $this->Session->setFlash(__('The item has been saved'), 'default', array( 'class' => 'text-success' ));
                    $this->redirect(array( 'action' => 'detail_section', $item_id, $section ));
                }
                else {
                    $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
                }
            }
        }
        else {
            $this->request->data = $this->Item->read(null, $item_id);
            $item_image = $this->request->data;
        }
        $suppliers = $this->Item->Supplier->find('list');
        $itemDepartments = $this->Item->ItemDepartment->find('list');
        $cabinets = $this->Item->Cabinet->find('list');
        $this->set(compact('suppliers', 'itemDepartments', 'cabinets', 'section', 'item_id', 'item_image'));
    }

    public function edit_sub_item($item_id = null, $section = null, $sp_id = null) {
        //pr($this->request->data);exit;
        $this->Item->id = $item_id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            //if (!$section) {
            $item_cost = trim($this->request->data['Item']['item_cost']);
            $factor = trim($this->request->data['Item']['factor']);
            $supplier_id = $this->request->data['Item']['supplier_id'];
            $stock = $this->request->data['Item']['current_stock'];
            $department_id = trim($this->request->data['Item']['item_department_id']);

            $price = round($item_cost * $factor, 2);
            $this->request->data['Item']['price'] = $price;
            $item_department = $this->Item->ItemDepartment->find('all', array( 'conditions' => array( 'id' => $department_id ) ));


            if( !$this->check_item_department_required($item_department[0]['ItemDepartment']['supplier_required'], $supplier_id) ) {
                $this->Session->setFlash(__('Your selected item department required supplier. Please, select supplier.'), 'default', array( 'class' => 'text-error' ));
            }
            elseif( !$this->check_item_department_required($item_department[0]['ItemDepartment']['stock_number_required'], $stock) ) {
                $this->Session->setFlash(__('Your selected item department required stock. Please, insert current stock.'), 'default', array( 'class' => 'text-error' ));
            }
            else {
//          if (isset($this->request->data['ItemOption'])) {
//            $item_value = explode(',', $this->request->data['ItemOption']['ItemOption']);
//            $this->request->data['ItemOption']['ItemOption'] = $item_value;
//          }
                if( $this->Item->save($this->request->data) ) {
                    $this->Session->setFlash(__('The item has been saved'), 'default', array( 'class' => 'text-success' ));
//            $this->redirect(array('action' => 'detail_section', $item_id, $section));
                    $this->redirect(array( 'action' => 'detail', $sp_id, $section ));
                }
                else {
                    $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
                }
            }
            //} else {
//        if (isset($this->request->data['ItemOption'])) {
//          $item_value = explode(',', $this->request->data['ItemOption']['ItemOption']);
//          $this->request->data['ItemOption']['ItemOption'] = $item_value;
//        }
//        if ($this->Item->save($this->request->data)) {
//          $this->Session->setFlash(__('The item has been saved'), 'default', array('class' => 'text-success'));
//          $this->redirect(array('action' => 'detail', $sp_id, $section));
//        } else {
//          $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
//        }
            //}
        }
        else {
            $this->request->data = $this->Item->read(null, $item_id);
            $item_image = $this->request->data;
        }
        $suppliers = $this->Item->Supplier->find('list');
        $itemDepartments = $this->Item->ItemDepartment->find('list');
        $cabinets = $this->Item->Cabinet->find('list');
        $this->set(compact('suppliers', 'itemDepartments', 'cabinets', 'section', 'item_id', 'item_image', 'sp_id'));
    }

    function list_sub_item($id = null) {
        $this->set(compact('id'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if( !$this->request->is('post') ) {
            throw new MethodNotAllowedException();
        }
        $this->Item->id = $id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        $item['id'] = $id;
        $item['delete'] = 1;
        $data = $this->Item->save($item);
        if( $data ) {
            $this->Session->setFlash(__('Item deleted'), 'default', array( 'class' => 'text-success' ));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->Session->setFlash(__('Item was not deleted'), 'default', array( 'class' => 'text-error' ));
        $this->redirect(array( 'action' => 'index' ));
    }

    /**
     * damaged_item method
     *
     * @param string $id
     * @return void
     */
    public function damaged_item($id = null) {
//    if ($this->request->is('post')) {
//      $this->Item->create();
//      if ($this->Item->save($this->request->data)) {
//        $this->Session->setFlash(__('The item has been saved'), 'default', array('class' => 'text-success'));
//        $this->redirect(array('action' => 'index'));
//      } else {
//        $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
//      }
//    }
//    $suppliers = $this->Item->Supplier->find('list');
//    $itemDepartments = $this->Item->ItemDepartment->find('list');
//    $cabinets = $this->Item->Cabinet->find('list');
//    $this->set(compact('suppliers', 'itemDepartments', 'cabinets'));
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail_section($item_id = null, $section = null, $edit = true) {
        $this->layoutOpt['left_nav_selected'] = "view_item";

        $this->Item->id = $item_id;
        if( !$this->Item->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }
        $item = $this->Item->read(null, $item_id);

        App::import('Model', 'Inventory.ItemInventoryTransaction');
        $itemInventoryTransactionModel = new ItemInventoryTransaction();
        $itemInventoryTransaction = $itemInventoryTransactionModel->find('all', array( 'conditions' => array( 'ItemInventoryTransaction.item_id' => $item_id ) ));

        $this->set(compact('item', 'itemInventoryTransaction', 'section', 'item_id', 'edit'));
    }

    public function report($limit = REPORT_LIMIT) {
        $this->layoutOpt['left_nav'] = "";
        $this->layoutOpt['left_nav_selected'] = "";

        $this->Item->recursive = 0;
        if( $limit != 'All' ) {
            $this->paginate['limit'] = $limit;
            $this->Prg->commonProcess();
            $this->paginate['conditions'] = $this->Item->parseCriteria($this->passedArgs);
            $items = $this->paginate();
        }
        else {
            $items = $this->Item->find('all');
        }

        $paginate = false;
        $legend = "Items Report";

        $this->set(compact('items', 'limit', 'paginate', 'legend'));
    }

    function listing_report_print($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';
        $this->Item->recursive = 0;

        if( !isset($this->params['named']['limit']) ) {
            $this->paginate['limit'] = REPORT_LIMIT;
            $this->paginate['maxLimit'] = REPORT_LIMIT;
        }
        elseif( $this->params['named']['limit'] != 'All' ) {
            $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
            $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
        }
        else {
            $this->paginate['limit'] = 0;
            $this->paginate['maxLimit'] = 0;
        }
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Item->parseCriteria($this->passedArgs);
        $items = $this->paginate();
        $paginate = false;
        $legend = "Items";
        $reportTitle = "General Listing Report";
        $reportDate = date('l, F d, Y');

        $this->set(compact('items', 'paginate', 'legend', 'reportTitle', 'reportDate'));
    }

    function getgruopItemNumber($id) {
        $this->autoRender = false;
        App::import('Model', 'Inventory.InventoryLookup');
        $inventorylookup = new InventoryLookup();
        $number = $inventorylookup->find("first", array( "conditions" => array( "InventoryLookup.id" => $id ) ));

        $items = $this->Item->find('first', array( 'limit' => 1, 'order' => array( 'Item.id DESC' ) ));
        $item_id = $items['Item']['id'] + 1;
        $number['InventoryLookup']['num'] = str_pad($item_id, 4, '0', STR_PAD_LEFT);
        echo json_encode($number);
    }

    function item_additional_detail($id = null) {
        $this->autoRender = false;
        $this->request->data['ItemAdditionalDetail']['item_id'] = $id;
        App::import('Model', 'Inventory.ItemAdditionalDetail');
        $itemadditionaldetail = new ItemAdditionalDetail();
        $data = $itemadditionaldetail->save($this->request->data);
        $this->redirect(array( 'action' => DETAIL, $id ));
    }

}
