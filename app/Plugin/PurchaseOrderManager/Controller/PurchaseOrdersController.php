<?php

App::uses('PurchaseOrderManagerAppController', 'PurchaseOrderManager.Controller');

/**
 * Purchase Order Controller
 *
 * @property PurchaseOrder $PurchaseOrder
 */
class PurchaseOrdersController extends PurchaseOrderManagerAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "purchase-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_purchase_order";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "purchase";
        $this->set("side_bar", $this->side_bar);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->PurchaseOrder->recursive = 0;

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
        $this->paginate['conditions'] = $this->PurchaseOrder->parseCriteria($this->passedArgs);
        $name = $this->PurchaseOrder->find('all');
        $purchaseorders = $this->paginate();
        $paginate = true;
        $legend = "Purchase Orders";

        $this->set(compact('purchaseorders', 'name', 'paginate', 'legend'));
    }

    public function add($quote_id = null, $section = null) {
        $this->layoutOpt['left_nav_selected'] = "add_purchase_order";

        if( $this->request->is('post') ) {

            $rand_num = $this->request->data['PurchaseOrder']['purchase_order_num'];
            $all_pos = $this->PurchaseOrder->find('all');
            foreach( $all_pos as $all_po ) {
                if( $all_po['PurchaseOrder']['purchase_order_num'] == $rand_num ) {
                    $this->Session->setFlash(__('The Purchase Order could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
                }
            }
            $this->PurchaseOrder->create();
            if( $this->PurchaseOrder->save($this->request->data) ) {
                $this->Session->setFlash(__('The Purchase Order has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'action' => DETAIL, $this->PurchaseOrder->id ));
            }
            else {
                $this->Session->setFlash(__('The Purchase Order could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $location_data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.name" => 'Default' ) ));

        $this->set(compact('quote_id', 'section', 'location_data'));
    }

    public function edit($id = null) {
        $this->PurchaseOrder->id = $id;
        if( !$this->PurchaseOrder->exists() ) {
            throw new NotFoundException(__('Invalid Purchase Order'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->PurchaseOrder->save($this->request->data) ) {
                $this->Session->setFlash(__('The Purchase Order has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'action' => DETAIL, $this->PurchaseOrder->id ));
            }
            else {
                $this->Session->setFlash(__('The Purchase Order could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        else {
            $this->request->data = $this->PurchaseOrder->read(null, $id);
            $shipping_date = $this->request->data['PurchaseOrder']['shipment_date'];
            $PO = $this->PurchaseOrder->read(null, $id);
            $this->set(compact('PO', 'shipping_date'));
        }
    }

    public function detail($id = null, $modal = null) {
        $this->layoutOpt['left_nav_selected'] = "view_purchase_order";
        $this->PurchaseOrder->id = $id;
        if( !$this->PurchaseOrder->exists() ) {
            throw new NotFoundException(__('Invalid Purchase Order'));
        }

        $purchaseorder = $this->PurchaseOrder->read(null, $id);
        $this->set(compact('purchaseorder', 'modal'));
    }

    public function print_detail($id = null) {
        $this->layoutOpt['layout'] = 'po_report';
        $this->PurchaseOrder->id = $id;
        $purchaseorder = $this->PurchaseOrder->read(null, $id);
        $reportDate = time();

        $this->set(compact('purchaseorder', 'reportDate'));
    }

    public function detail_section($purchase_order_id = null, $section = null) {
        $this->layoutOpt['left_nav_selected'] = "view_purchase_order";
        $this->PurchaseOrder->id = $purchase_order_id;
        if( !$this->PurchaseOrder->exists() ) {
            throw new NotFoundException(__('Invalid Purchase Order'));
        }
        $purchase_order = $this->PurchaseOrder->read(null, $purchase_order_id);
        $this->set(compact('purchase_order', 'section'));
    }

    public function delete($id = null, $section = null, $work_order_id) {
        if( !$this->request->is('post') ) {
            throw new MethodNotAllowedException();
        }
        $this->PurchaseOrder->id = $id;
        if( !$this->PurchaseOrder->exists() ) {
            throw new NotFoundException(__('Invalid Purchase Order'));
        }
        if( $this->PurchaseOrder->delete() ) {
            $this->Session->setFlash(__('Purchase Order has been deleted successfully'), 'default', array( 'class' => 'text-success' ));
            if( $section == "work-order-po" ) {
                $this->redirect(array( 'plugin' => 'work_order_manager', 'controller' => 'work_orders', 'action' => 'detail', $work_order_id, $section ));
            }
            else {
                $this->redirect(array( 'action' => 'index' ));
            }
        }
        $this->Session->setFlash(__('Purchase Order has not been deleted successfully. Please try again'), 'default', array( 'class' => 'text-error' ));
        $this->redirect(array( 'action' => 'index' ));
    }

    public function getSupplier($id = null) {
        $this->autoRender = false;
        App::import('Model', 'Inventory.Supplier');
        $supplier = new Supplier();
        $purchaseorder = $supplier->find("first", array( "conditions" => array( "Supplier.id" => $id ) ));
        $add_formate = $this->QuoteItem->address_format($purchaseorder['Supplier']['address'], $purchaseorder['Supplier']['city'], $purchaseorder['Supplier']['province'], $purchaseorder['Supplier']['country'], $purchaseorder['Supplier']['postal_code']);
        $phone_formate = $this->QuoteItem->phone_format($purchaseorder['Supplier']['phone'], $purchaseorder['Supplier']['phone_ext'], $purchaseorder['Supplier']['cell'], $purchaseorder['Supplier']['fax_number']);
        $purchaseorder['Supplier']['address_formate'] = $add_formate;
        $purchaseorder['Supplier']['phone_formate'] = $phone_formate;
        echo json_encode($purchaseorder);
    }

    public function getQuote($id = null) {
        $this->autoRender = false;
        App::import('Model', 'WorkOrderManager.WorkOrder');
        $workOrderModel = new WorkOrder();
        $workOrder = $workOrderModel->find("first", array( "conditions" => array( "WorkOrder.id" => $id ) ));

        $all_items = $this->QuoteItem->ListQuoteItems($workOrder['Quote']['id']);
        $all_items = $this->QuoteItem->AdjustPOItem($all_items);
        //pr($all_items);exit;
//    debug($all_items);
//    $main_item_list = $all_items['quantity_list'];
//    $price_list = $all_items['price_list'];
//    $title_list = $all_items['title_list'];
//    $name_list = $all_items['name_list'];
//    $restrictedSupplier = $this->QuoteItemComponent->RestrictedSupplierOfPO($work_id);
//    $supplier_list = $this->QuoteItem->SupplierAndItemInfo();

        App::import('Model', 'QuoteManager.Quote');
        $quote = new Quote();
        //$quote->recursive = 3;
        $quote_info = $quote->find("first", array( "conditions" => array( "Quote.id" => $workOrder['Quote']['id'] ) ));
        $add_formate = $this->QuoteItem->address_format($quote_info['Quote']['address'], $quote_info['Quote']['city'], $quote_info['Quote']['province'], $quote_info['Quote']['country'], $quote_info['Quote']['postal_code']);

        if( !empty($quote_info['Quote']['est_shipping']) ) {
            $quote_info['Quote']['est_shipping'] = $this->dateFormatPo($quote_info['Quote']['est_shipping']);
        }
        else {
            if( $quote_info['Quote']['delivery'] == '4 - 8 Weeks Delivery' ) {
                $add_days = 56;
                $today = $quote_info['Quote']['quote_created_date'];
                $esd_date = date('d/m/Y', strtotime($today) + (24 * 3600 * $add_days));
            }
            if( $quote_info['Quote']['delivery'] == '5 - 10 Weeks Delivery' ) {
                $add_days = 70;
                $today = $quote_info['Quote']['quote_created_date'];
                $esd_date = date('d/m/Y', strtotime($today) + (24 * 3600 * $add_days));
            }
            $quote_info['Quote']['est_shipping'] = $esd_date;
        }
        $quote_info['Quote']['sales_person'] = unserialize($quote_info['Quote']['sales_person']);
        $quote_info['Quote']['address_formate'] = $add_formate;
        $quote_info['all_item'] = $all_items;
        echo json_encode($quote_info);
    }

    function dateFormatPO($date_time) {
        $this->autoRender = false;
        if( $date_time == null )
            return "N/A";
        if( strcmp($date_time, "0000-00-00") == 0 || strcmp($date_time, "0000-00-00 00:00:00") == 0 )
            return "N/A";
        $str = strtotime($date_time);

        $result_date_time = date("d/m/Y", $str);

        return $result_date_time;
    }

    public function received() {
        $this->layoutOpt['left_nav_selected'] = "view_purchase_receive";
    }

    public function getPO($id = null) {
        $this->autoRender = false;
        $quote_info = $this->PurchaseOrder->find("first", array( "conditions" => array( "PurchaseOrder.id" => $id ) ));
        echo json_encode($quote_info);
    }

    public function getWorkOrderOfPO($id = null) {
//        $this->autoRender = false;
//        $quote_info = $this->PurchaseOrder->find("first", array("conditions" => array("PurchaseOrder.id" => $id)));
//        echo json_encode($quote_info);
    }

    function received_save($id = null) {
        $this->autoRender = false;
        $data = $this->PurchaseOrder->read(null, $id);

        $receive_array['PurchaseOrder']['id'] = $data['PurchaseOrder']['id'];
        $receive_array['PurchaseOrder']['received'] = 1;

        $this->PurchaseOrder->save($receive_array);

        return true;
    }

    function received_save_list($id = null) {
        $this->layoutOpt['left_nav_selected'] = "view_purchase_receive_all";
        $data = $this->PurchaseOrder->read(null, $id);

        $receive_array['PurchaseOrder']['id'] = $data['PurchaseOrder']['id'];
        $receive_array['PurchaseOrder']['received'] = 1;
        $receive_array['PurchaseOrder']['is_paid'] = 2;
        $receive_array['PurchaseOrder']['received_by'] = $this->loginUser['id'];

        $this->PurchaseOrder->save($receive_array, false);

        $this->PurchaseOrder->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->PurchaseOrder->parseCriteria($this->passedArgs);
        $name = $this->PurchaseOrder->find('all');
        $purchaseorders = $this->paginate();
        $this->set(compact('purchaseorders', 'name'));
    }

    function received_view() {
        $this->layoutOpt['left_nav_selected'] = "view_purchase_receive_all";
        $this->PurchaseOrder->recursive = 0;

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
        $this->paginate['conditions'] = $this->PurchaseOrder->parseCriteria($this->passedArgs);
        if( isset($this->params['named']['received']) ) {
            if( $this->params['named']['received'] == 0 ) {
                $zero = 0;
                $this->paginate['conditions']['PurchaseOrder.received LIKE'] = "%" . $zero . "%";
            }
        }
        $name = $this->PurchaseOrder->find('all');
        $purchaseorders = $this->paginate();
        $paginate = true;
        $legend = "Purchase Receive";

        $this->set(compact('purchaseorders', 'name', 'paginate', 'legend'));
    }

    function listing_report_print_por($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';
        $this->PurchaseOrder->recursive = 0;

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
        $this->paginate['conditions'] = $this->PurchaseOrder->parseCriteria($this->passedArgs);
        $name = $this->PurchaseOrder->find('all');
        $purchaseorders = $this->paginate();
        $paginate = false;
        $legend = "Purchase Receive";
        $reportDate = date('l, F d, Y - h:i a');

        $this->set(compact('purchaseorders', 'name', 'paginate', 'legend', 'reportDate'));
    }

    public function po_of_work_order($quote_id = null, $section = null, $work_id = null, $edit = null) {
        $this->layoutOpt['left_nav_selected'] = "add_purchase_order";

        if( $this->request->is('post') || $this->request->is('put') ) {

            $this->PurchaseOrder->create();
            if( $this->PurchaseOrder->save($this->request->data) ) {
                $this->Session->setFlash(__('The Purchase Order has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'plugin' => 'work_order_manager', 'controller' => 'work_orders', 'action' => 'detail_section', $work_id, $section ));
            }
            else {
                $this->Session->setFlash(__('The Purchase Order could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        App::uses('Quote', 'QuoteManager.Model');
        $quote = new Quote();
        $quote->recursive = 0;
        $quoteInfo = $quote->find('all', array( 'conditions' => array( 'Quote.id' => $quote_id ) ));

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $location_data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.name" => 'Default' ) ));

        $this->set(compact('quote_id', 'section', 'quoteInfo', 'work_id', 'edit', 'location_data'));
    }

    public function edit_order($id = null, $section = null, $work_id = null) {
        $this->PurchaseOrder->id = $id;
        if( !$this->PurchaseOrder->exists() ) {
            throw new NotFoundException(__('Invalid Purchase Order'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            $this->PurchaseOrder->create();
            //debug($this->request->data);exit;
            if( $this->PurchaseOrder->save($this->request->data) ) {
                $this->Session->setFlash(__('The Purchase Order has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'plugin' => 'work_order_manager', 'controller' => 'work_orders', 'action' => 'detail_section', $work_id, $section ));
            }
            else {
                $this->Session->setFlash(__('The Purchase Order could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        $this->request->data = $this->PurchaseOrder->read(null, $id);
        $purchaseOrder = $this->PurchaseOrder->read(null, $id);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $location_data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.name" => 'Default' ) ));

        $edit = true;
        $this->set(compact('purchaseOrder', 'section', 'work_id', 'edit', 'location_data'));
    }

    public function reports($limit = REPORT_LIMIT) {
        $this->layoutOpt['left_nav_selected'] = "view_reports";

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
        $this->paginate['conditions'] = $this->PurchaseOrder->parseCriteria($this->passedArgs);
        $name = $this->PurchaseOrder->find('all');
        $purchaseorders = $this->paginate();
        $paginate = true;
        $legend = "Purchase Orders";

        $this->set(compact('purchaseorders', 'name', 'paginate', 'legend'));
    }

    function listing_report_print($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';

        $this->PurchaseOrder->recursive = 0;

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
        $this->paginate['conditions'] = $this->PurchaseOrder->parseCriteria($this->passedArgs);
        $name = $this->PurchaseOrder->find('all');
        $purchaseorders = $this->paginate();
        $paginate = false;
        $legend = "Purchase Orders";
        $reportDate = date('l, F d, Y - h:i a');

        $this->set(compact('purchaseorders', 'name', 'paginate', 'legend', 'reportDate'));
    }

    public function general_setting_list() {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $general_info = $general_model->find('all', array( 'conditions' => array( 'GeneralSetting.type <>' => 'location' ), 'group' => 'GeneralSetting.type desc' ));

        $this->set(compact('general_info'));
    }

    public function location_list($id = null, $type = '') {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "add_location";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $locations = $general_model->find('all', array( 'conditions' => array( 'GeneralSetting.type' => 'location' ) ));
        $this->set(compact('locations'));
    }
    
    public function production_time_list($id = null, $type = '') {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "production_time";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $productions = $general_model->find('all', array( 'conditions' => array( 'GeneralSetting.type' => 'production_time' ) ));
        $this->set(compact('productions'));
    }
    public function production_add($id = null) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "production_time";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        if( $this->request->is('post') ) {
            App::import('Model', 'PurchaseOrderManager.GeneralSetting');
            $general_model = new GeneralSetting();

            $this->request->data['GeneralSetting']['type'] = 'production_time';

            if( $general_model->save($this->request->data) ) {
                $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'production_time_list', $general_model->id, 'production_time' ));
            }
        }
    }
    public function production_edit($id = null) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "production_time";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $data = $general_model->find('first', array( 'conditions' => array( 'GeneralSetting.id' => $id ) ));

        if( $this->request->is('post') ) {
            App::import('Model', 'PurchaseOrderManager.GeneralSetting');
            $general_model = new GeneralSetting();

            $this->request->data['GeneralSetting']['type'] = 'production_time';

            if( $general_model->save($this->request->data) ) {
                $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'production_time_list', $general_model->id, 'production_time' ));
            }
        }
        $this->set(compact('data'));
    }

    public function location_add($id = null) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "add_location";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        if( $this->request->is('post') ) {
            App::import('Model', 'PurchaseOrderManager.GeneralSetting');
            $general_model = new GeneralSetting();

            $this->request->data['GeneralSetting']['type'] = 'location';

            if( $general_model->save($this->request->data) ) {
                $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'location_list', $general_model->id, 'location' ));
            }
        }
    }

    public function location_edit($id = null) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "add_location";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $data = $general_model->find('first', array( 'conditions' => array( 'GeneralSetting.id' => $id ) ));

        if( $this->request->is('post') ) {
            App::import('Model', 'PurchaseOrderManager.GeneralSetting');
            $general_model = new GeneralSetting();

            $this->request->data['GeneralSetting']['type'] = 'location';

            if( $general_model->save($this->request->data) ) {
                $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'location_list', $general_model->id, 'location' ));
            }
        }
        $this->set(compact('data'));
    }

    public function getLocationData($id = null) {
        $this->autoRender = false;
        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $location_data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.id" => $id ) ));

        echo json_encode($location_data);
    }

    public function getSupplierData($id = null) {
        $this->autoRender = false;
        App::import('Model', 'Inventory.Supplier');
        $supplier_model = new Supplier();
        $supplier_data = $supplier_model->find("first", array( "conditions" => array( "Supplier.id" => $id ) ));

        echo json_encode($supplier_data);
    }

    public function gst($id = null) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.id" => $id ) ));

        $this->set(compact('data'));
    }

    public function gst_add() {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $general_model->save($this->request->data);
        $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'general_setting_list' ));
    }

    public function pst($id = null) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.id" => $id ) ));

        $this->set(compact('data'));
    }

    public function pst_add() {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $general_model->save($this->request->data);
        $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'general_setting_list' ));
    }

    public function deposit_payment($id) {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.id" => $id ) ));

        $this->set(compact('data'));
    }

    public function deposit_payment_add() {
        $this->layoutOpt['left_nav'] = "general-left-nav";
        $this->layoutOpt['left_nav_selected'] = "list_general";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);

        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $general_model = new GeneralSetting();
        $general_model->save($this->request->data);
        $this->redirect(array( 'controller' => 'purchase_orders', 'action' => 'general_setting_list' ));
    }

}
