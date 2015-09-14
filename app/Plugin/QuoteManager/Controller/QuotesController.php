<?php

App::uses('QuoteManagerAppController', 'QuoteManager.Controller');

/**
 * Quotes Controller
 *
 * @property Quote $Quote
 */
class QuotesController extends QuoteManagerAppController {

    public $presetVars = array(
        'job_name' => array( 'type' => 'like' ),
        'customer_id' => array( 'type' => 'lookup', 'modelField' => 'name', 'model' => 'Customer' )
    );

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "quote-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_quote";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "quote";
        $this->set("side_bar", $this->side_bar);

//    debug($this->request->params['named']);
//    if(isset($this->request->params['named']['start_date'])){
//      $this->request->params['named']['start_date'] = $this->Calendar->formatDate($this->request->params['named']['start_date']);
//    }
//    if(isset($this->request->params['named']['end_date'])){
//      $this->request->params['named']['end_date'] = $this->Calendar->formatDate($this->request->params['named']['end_date']);
//    }
//    debug($this->request->params['named']);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Quote->recursive = 0;

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
        $this->paginate['conditions'] = $this->Quote->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Quote.vid' => null ); // skip version histories
        $this->paginate['conditions'] += array( 'Quote.status !=' => 'Approve' );
        $this->paginate['conditions'] += array( 'Quote.delete !=' => 1 );
        $quotes = $this->paginate();
        $paginate = true;
        $legend = "Quotes";

        $this->set(compact('quotes', 'paginate', 'legend'));
    }

    public function deleted_quote() {
        $this->layoutOpt['left_nav_selected'] = "view_delete_quote";
        $this->Quote->recursive = 0;

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
        $this->paginate['conditions'] = $this->Quote->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Quote.vid' => null ); // skip version histories
        $this->paginate['conditions'] += array( 'Quote.status !=' => 'Approve' );
        $this->paginate['conditions'] += array( 'Quote.delete !=' => 0 );
        $quotes = $this->paginate();
        $paginate = true;
        $legend = "Quotes";

        $this->set(compact('quotes', 'paginate', 'legend'));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null, $modal = null) {
        $this->layoutOpt['left_nav_selected'] = "view_quote";
        $this->Quote->recursive = 3;

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);

        if( !is_null($quote['Quote']['vid']) ) { // redirect to parent quote
            $this->redirect(array( $quote['Quote']['vid'], $modal ));
        }

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        //debug($quote_status);
        App::import("Model", "Upload");
        $upload_model = new Upload();
        $uploads = $upload_model->find('all', array( 'conditions' => array( 'Upload.ref_id' => $id, 'Upload.ref_model' => 'quotes' ), 'order' => array( 'Upload.title' => 'ASC' ) ));

        App::import("Model", "UploadPayment");
        $upload_payment_model = new UploadPayment();
        $upload_payment = $upload_payment_model->find('all', array( 'conditions' => array( 'UploadPayment.ref_id' => $id, 'UploadPayment.ref_model' => 'quotes' ), 'order' => array( 'UploadPayment.payment_date' => 'ASC' ) ));

        App::import("Model", "PurchaseOrderManager.GeneralSetting");
        $generalsetting_model = new GeneralSetting();
        $deposit_amount = $generalsetting_model->find("first", array( "conditions" => array( "GeneralSetting.type" => 'deposit_payment' ) ));

        App::import("Model", "ContainerManager.ContainerSkid");
        $containerskid_model = new ContainerSkid();
        $container = $containerskid_model->find("first", array( "conditions" => array( "ContainerSkid.skid_no" => $quote['Quote']['skid_number'] ) ));

        $user_id = $this->loginUser['id'];
        $this->set(compact('quote', 'user_id', 'modal', 'quote_status', 'uploads', 'upload_payment', 'deposit_amount', 'container'));
    }

    public function edit_payment($id = null) {
        App::import("Model", "UploadPayment");
        $upload_payment_model = new UploadPayment();
        $upload_payment = $upload_payment_model->find('first', array( 'conditions' => array( 'UploadPayment.id' => $id ) ));

        $this->set(compact('upload_payment', 'id'));
    }

    /**
     * print/pdf view method
     *
     * @param string $id
     * @return void
     */
    public function print_detail($id = null) {
        $this->layoutOpt['layout'] = 'quote_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        if( empty($quote['CabinetOrder']) ) {
            $this->layoutOpt['layout'] = 'report_message';
            $this->render("../Elements/Detail/Quote/print_detail_message");
        }
        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();

        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Detail Report";
        $reportDate = time();
        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate'));
    }

    /*
     * PDF for Quote Detail section
     */

    public function view_pdf($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();

        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Detail Report";
        $reportDate = time();
        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate'));

        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/view_pdf");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "Quote_detail" . ".pdf";
//        $html2pdf->Output("uploads/QuotePDF/pdf/" . $pdfFileName, "F");    
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_quote";
        $this->Quote->Customer->recursive = 0;

        if( $this->request->is('post') ) {
            App::import('Model', 'CustomerManager.Customer');
            $c = new Customer();

            App::import('Model', 'CustomerManager.BuilderAccount');
            $bc = new BuilderAccount();

            $customer['Customer']['id'] = $this->request->data['Quote']['customer_id'];
            $customer['Customer']['address'] = $this->request->data['Quote']['address'];
            $customer['Customer']['city'] = $this->request->data['Quote']['city'];
            $customer['Customer']['province'] = $this->request->data['Quote']['province'];
            $customer['Customer']['country'] = $this->request->data['Quote']['country'];
            $customer['Customer']['postal_code'] = $this->request->data['Quote']['postal_code'];

            $cus_info = $c->find("first", array( "conditions" => array( "Customer.id" => $this->request->data['Quote']['customer_id'] ) ));
            $customer['Customer']['customer_type_id'] = $cus_info['Customer']['customer_type_id'];

            $build_info = $c->find("first", array( "conditions" => array( "BuilderAccount.customer_id" => $this->request->data['Quote']['customer_id'] ) ));
            $customer['BuilderAccount']['customer_id'] = $build_info['BuilderAccount']['customer_id'];
            $customer['BuilderAccount']['builder_legal_name'] = $build_info['BuilderAccount']['builder_legal_name'];
            $customer['BuilderAccount']['builder_type'] = $build_info['BuilderAccount']['builder_type'];
            $customer['BuilderAccount']['discount_rate'] = $build_info['BuilderAccount']['discount_rate'];
            $customer['BuilderAccount']['multi_unit'] = $build_info['BuilderAccount']['multi_unit'];
            $customer['BuilderAccount']['quotes_validity'] = $build_info['BuilderAccount']['quotes_validity'];
            $customer['BuilderAccount']['ar_account'] = $build_info['BuilderAccount']['ar_account'];
            $customer['BuilderAccount']['ap_account'] = $build_info['BuilderAccount']['ap_account'];
            $customer['BuilderAccount']['retail_client'] = $build_info['BuilderAccount']['retail_client'];
            $customer['BuilderAccount']['effective_date'] = $build_info['BuilderAccount']['effective_date'];
            $customer['BuilderAccount']['invoice_on_day'] = $build_info['BuilderAccount']['invoice_on_day'];
            $customer['BuilderAccount']['due_on_day'] = $build_info['BuilderAccount']['due_on_day'];
            $customer['BuilderAccount']['credit_limit'] = $build_info['BuilderAccount']['credit_limit'];
            $customer['BuilderAccount']['credit_terms'] = $build_info['BuilderAccount']['credit_terms'];
            $customer['BuilderAccount']['no_of_houses'] = $build_info['BuilderAccount']['no_of_houses'];
            $customer['BuilderAccount']['no_of_units'] = $build_info['BuilderAccount']['no_of_units'];

            $this->Quote->create();
            $this->request->data['Quote']['sales_person'] = $cus_info['Customer']['sales_representatives'];
            $this->request->data['Quote']['quote_created_date'] = date('Y-m-d');

            if( $this->Quote->save($this->request->data) ) {

                $c->save($customer);

                $this->Session->setFlash(__('The quote has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'action' => DETAIL, $this->Quote->id ));
            }
            else {
                $this->Session->setFlash(__('The quote could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        $customers = $this->Quote->Customer->find('all', array( 'fields' => array( 'address', 'city', 'province', 'postal_code', 'country' ) ));

        $this->set(compact('customers'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null, $section = null) {
        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        else {
            App::import('Model', 'Quote');
            $quote = new Quote();
            $quote_data = $quote->find('first', array( 'conditions' => array( 'Quote.id' => $id ) ));
            if( !is_null($quote_data['Quote']['vid']) ) { // redirect to parent quote
                $this->redirect(array( $quote_data['Quote']['vid'] ));
            }
        }

        if( $this->request->is('post') || $this->request->is('put') ) {
            if( isset($this->request->data['QuoteStatus']['status']) && trim($this->request->data['QuoteStatus']['status']) == "Approve" ) {
                $this->request->data['Quote']['status'] = "Approve";
            }

//      if (isset($this->request->data['QuoteStatus']['status'])) {
//        $this->create_history($id);
//      }
            $this->create_history($id); // allways do a versioning
            if( isset($this->request->data['Quote']['sales_person']) ) {
                $this->request->data['Quote']['sales_person'] = serialize($this->request->data['Quote']['sales_person']);
            }
            App::import('Model', 'CustomerManager.Customer');
            $c = new Customer();

            App::import('Model', 'CustomerManager.BuilderAccount');
            $bc = new BuilderAccount();

            $customer['Customer']['id'] = $this->request->data['Quote']['customer_id'];
            $customer['Customer']['address'] = $this->request->data['Quote']['address'];
            $customer['Customer']['city'] = $this->request->data['Quote']['city'];
            $customer['Customer']['province'] = $this->request->data['Quote']['province'];
            $customer['Customer']['country'] = $this->request->data['Quote']['country'];
            $customer['Customer']['postal_code'] = $this->request->data['Quote']['postal_code'];

            $cus_info = $c->find("first", array( "conditions" => array( "Customer.id" => $this->request->data['Quote']['customer_id'] ) ));
            $customer['Customer']['customer_type_id'] = $cus_info['Customer']['customer_type_id'];

            $build_info = $c->find("first", array( "conditions" => array( "BuilderAccount.customer_id" => $this->request->data['Quote']['customer_id'] ) ));
            $customer['BuilderAccount']['customer_id'] = $build_info['BuilderAccount']['customer_id'];
            $customer['BuilderAccount']['builder_legal_name'] = $build_info['BuilderAccount']['builder_legal_name'];
            $customer['BuilderAccount']['builder_type'] = $build_info['BuilderAccount']['builder_type'];
            $customer['BuilderAccount']['discount_rate'] = $build_info['BuilderAccount']['discount_rate'];
            $customer['BuilderAccount']['multi_unit'] = $build_info['BuilderAccount']['multi_unit'];
            $customer['BuilderAccount']['quotes_validity'] = $build_info['BuilderAccount']['quotes_validity'];
            $customer['BuilderAccount']['ar_account'] = $build_info['BuilderAccount']['ar_account'];
            $customer['BuilderAccount']['ap_account'] = $build_info['BuilderAccount']['ap_account'];
            $customer['BuilderAccount']['retail_client'] = $build_info['BuilderAccount']['retail_client'];
            $customer['BuilderAccount']['effective_date'] = $build_info['BuilderAccount']['effective_date'];
            $customer['BuilderAccount']['invoice_on_day'] = $build_info['BuilderAccount']['invoice_on_day'];
            $customer['BuilderAccount']['due_on_day'] = $build_info['BuilderAccount']['due_on_day'];
            $customer['BuilderAccount']['credit_limit'] = $build_info['BuilderAccount']['credit_limit'];
            $customer['BuilderAccount']['credit_terms'] = $build_info['BuilderAccount']['credit_terms'];
            $customer['BuilderAccount']['no_of_houses'] = $build_info['BuilderAccount']['no_of_houses'];
            $customer['BuilderAccount']['no_of_units'] = $build_info['BuilderAccount']['no_of_units'];
            if( $this->Quote->save($this->request->data) ) {

                $c->save($customer);

                $this->Session->setFlash(__('The quote has been saved'), 'default', array( 'class' => 'text-success' ));
//        $this->redirect(array('action' => 'detail_section', $this->Quote->id, $section));
                $this->redirect(array( 'action' => 'detail', $this->Quote->id ));
            }
            else {
                $this->Session->setFlash(__('The quote could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        else {
            $this->Quote->recursive = 3;
            $this->request->data = $this->Quote->read(null, $id);
        }
        $this->Quote->Customer->recursive = 0;

        $customers = $this->Quote->Customer->find('all', array( 'fields' => array( 'address', 'city', 'province', 'postal_code', 'country' ) ));

        $customers = $this->Quote->Customer->find('all', array( 'fields' => array( 'address', 'city', 'province', 'postal_code', 'country' ) ));

        $user_id = $this->loginUser['id'];
        $this->set(compact('customers', 'section', 'user_id', 'id', 'quote_data'));
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
        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }

        $quote['Quote']['id'] = $id;
        $quote['Quote']['delete'] = 1;
        $quote['Quote']['deleted_by'] = $this->loginUser['id'];
        ;

        $return = $this->Quote->save($quote);

        if( $return ) {
            $this->Session->setFlash(__('Quote deleted'), 'default', array( 'class' => 'text-success' ));
            $this->redirect(array( 'action' => 'index', 'sort' => 'quote_number', 'direction' => 'desc' ));
        }
        $this->Session->setFlash(__('Quote was not deleted'), 'default', array( 'class' => 'text-error' ));
        $this->redirect(array( 'action' => 'index', 'sort' => 'quote_number', 'direction' => 'desc' ));
    }

    public function quote_review($id = null) {
        $this->autoRender = FALSE;

        App::import('Model', 'QuoteManager.Quote');
        $Quote = new Quote();

        App::import("Model", "UploadPayment");
        $upload = new UploadPayment();
        $upload_data = $upload->find("first", array( "conditions" => array( "UploadPayment.ref_id" => $id ) ));

        if( !empty($upload_data) ) {
            $quote_data = $Quote->find("first", array( "conditions" => array( "Quote.id" => $id ) ));

            if( empty($quote_data['Quote']['est_shipping']) ) {
                if( $quote_data['Quote']['delivery'] == '4 - 8 Weeks Delivery' ) {
                    $add_days = 56;
                    $today = $quote_data['Quote']['quote_created_date'];
                    $esd_date = date('d/m/Y', strtotime($today) + (24 * 3600 * $add_days));
                }
                if( $quote_data['Quote']['delivery'] == '5 - 10 Weeks Delivery' ) {
                    $add_days = 70;
                    $today = $quote_data['Quote']['quote_created_date'];
                    $esd_date = date('d/m/Y', strtotime($today) + (24 * 3600 * $add_days));
                }
                $quote['Quote']['est_shipping'] = $esd_date;
            }
        }
        else {
            $msg['error'] = 1;
            echo json_encode($msg);
            die();
        }

        App::import('Model', 'QuoteManager.QuoteStatus');
        $QuoteStatus = new QuoteStatus();

        $quote['Quote']['id'] = $id;
        $quote['Quote']['status'] = 'Review';
        $Quote->save($quote);

        $quote_status['QuoteStatus']['status'] = 'Review';
        $quote_status['QuoteStatus']['quote_id'] = $id;

        if( $QuoteStatus->save($quote_status) ) {
            $msg['error'] = 0;
            echo json_encode($msg);
            die();
            //$this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$id}#quote-detail");
        }
    }

    public function quote_approved($id = null) {
        $this->autoRender = FALSE;

        App::import('Model', 'QuoteManager.QuoteStatus');
        $QuoteStatus = new QuoteStatus();

        App::import('Model', 'QuoteManager.Quote');
        $Quote = new Quote();
        $Q_model = new Quote();
        $quote['Quote']['id'] = $id;
        $quote['Quote']['status'] = 'Approve';

        $Q_data = $Q_model->find("first", array( "conditions" => array( "Quote.id" => $id ) ));

        if( empty($Q_data['Quote']['est_shipping']) ) {
            if( $Q_data['Quote']['delivery'] == '4 - 8 Weeks Delivery' ) {
                $add_days = 56;
                $today = $Q_data['Quote']['quote_created_date'];
                $esd_date = date('d/m/Y', strtotime($today) + (24 * 3600 * $add_days));
            }
            if( $Q_data['Quote']['delivery'] == '5 - 10 Weeks Delivery' ) {
                $add_days = 70;
                $today = $Q_data['Quote']['quote_created_date'];
                $esd_date = date('d/m/Y', strtotime($today) + (24 * 3600 * $add_days));
            }
            $quote['Quote']['est_shipping'] = $esd_date;
        }
        $Quote->save($quote);

        $quote_status['QuoteStatus']['status'] = 'Approve';
        $quote_status['QuoteStatus']['quote_id'] = $id;

        $quote_info = $Quote->find("first", array( "conditions" => array( "Quote.id" => $id ) ));

        $workorder['WorkOrder']['quote_id'] = $quote_info['Quote']['id'];
        $workorder['WorkOrder']['project_id'] = $quote_info['Quote']['project_id'];
        $workorder['WorkOrder']['customer_id'] = $quote_info['Quote']['customer_id'];
        $workorder['WorkOrder']['status'] = 'New';
        $quote_number_explode = explode("-", $quote_info['Quote']['quote_number']);
        $workorder['WorkOrder']['work_order_number'] = $quote_number_explode[0];
        $workorder['WorkOrder']['skid_number'] = $quote_info['Quote']['skid_number'];
        $workorder['WorkOrder']['skid_weight'] = $quote_info['Quote']['skid_weight'];

        App::import("Model", "WorkOrderManager.WorkOrder");
        $wo = new WorkOrder();
        $wo->save($workorder);

        App::import("Model", "PurchaseOrderManager.PurchaseOrder");
        App::import("Model", "PurchaseOrderManager.PurchaseOrderItem");
        App::import("Model", "Inventory.Supplier");
        App::import('Model', 'PurchaseOrderManager.GeneralSetting');

        $supplier = array( );
        foreach( $quote_info['CabinetOrderItem'] as $quote_item ) {
            $item_info = $this->findQuoteItem($quote_item['item_id']);
            $supplier_required = $this->findQuoteItemDept($item_info['Item']['item_department_id']);
            if( $supplier_required['ItemDepartment']['supplier_required'] == 1 ) {
                $supplier[$item_info['Item']['supplier_id']][] = $item_info;
            }
        }
        $total_amount = 0;
        foreach( $supplier as $key => $value ) {
            if( empty($Q_data['Quote']['est_shipping']) )
                $est_date_quote = $quote['Quote']['est_shipping'];
            else {
                $est_date_quote = $quote_info['Quote']['est_shipping'];
            }
            $purchaseorder = new PurchaseOrder();

            $sp_model = new Supplier();
            $sp_data = $sp_model->find("first", array( "conditions" => array( "Supplier.id" => $id ) ));

            $general_model = new GeneralSetting();
            $location_data = $general_model->find("first", array( "conditions" => array( "GeneralSetting.name" => 'Default' ) ));

            $po['supplier_id'] = $key;
            $po['work_order_id'] = $wo->id;
            $po_number = explode("-", $quote_info['Quote']['quote_number']);
            $po['purchase_order_num'] = $po_number[0];
            $po['quote_id'] = $quote_info['Quote']['id'];
            $po['shipment_date'] = $est_date_quote;
            $po['payment_type'] = 'On Account';
            $po['issued_on'] = date('d/m/Y');
            $po['issued_by'] = $this->loginUser['id'];
            $po['term'] = $sp_data['Supplier']['terms'];
            $po['location_name'] = $location_data['GeneralSetting']['name'];
            $po['name_ship_to'] = $location_data['GeneralSetting']['name_address'];
            $po['address'] = $location_data['GeneralSetting']['address'];
            $po['city'] = $location_data['GeneralSetting']['city'];
            $po['province'] = $location_data['GeneralSetting']['province'];
            $po['postal_code'] = $location_data['GeneralSetting']['postal_code'];
            $po['country'] = $location_data['GeneralSetting']['country'];

            foreach( $value as $v ) {
                foreach( $quote_info['CabinetOrderItem'] as $req_info ) {
                    if( $req_info['item_id'] == $v['Item']['id'] ) {
                        $quantity = $req_info['quantity'];
                        $total_amount = $total_amount + ($quantity * $v['Item']['price']);
                    }
                }
            }
            App::import("Model", "PurchaseOrderManager.GeneralSetting");
            $g_setting = new GeneralSetting();
            $gst_rate = $g_setting->find("first", array( "conditions" => array( "GeneralSetting.type" => 'gst' ) ));
            $pst_rate = $g_setting->find("first", array( "conditions" => array( "GeneralSetting.type" => 'pst' ) ));
            $gst_amount = ($gst_rate['GeneralSetting']['value'] / 100) * $total_amount;
            $pst_amount = ($pst_rate['GeneralSetting']['value'] / 100) * $total_amount;
            $total_amount = $total_amount + $gst_amount + $pst_amount;

            $po['total_amount'] = $total_amount;
            $purchaseorder->save($po);

            $index = 0;
            $purchaseorderitem = new PurchaseOrderItem();
            foreach( $value as $v ) {
                foreach( $quote_info['CabinetOrderItem'] as $req_info ) {
                    if( $req_info['item_id'] == $v['Item']['id'] ) {
                        $po_item[$index]['quantity'] = $req_info['quantity'];
                        $po_item[$index]['code'] = $req_info['code'];
                        $po_item[$index]['cabinet_id'] = $req_info['cabinet_id'];
                        $po_item[$index]['door_id'] = $req_info['door_id'];
                    }
                }
                $po_item[$index]['item_id'] = $v['Item']['id'];
                $po_item[$index]['purchase_order_id'] = $purchaseorder->id;
                $index++;
            }
            $purchaseorderitem->saveAll($po_item);
        }
//		foreach($quote_info['CabinetOrderItem'] as $quote_item){
//			$purchaseorder = new PurchaseOrder();
//			$item_info = $this->findQuoteItem($quote_item['item_id']);
//			$supplier_required = $this->findQuoteItemDept($item_info['Item']['item_department_id']);			
//			if(!empty($supplier_required['ItemDepartment']['supplier_required'])){
//				$supplier[$item_info['Item']['supplier_id']][] = $item_info;
//				$po['supplier_id'] = $item_info['Item']['supplier_id'];
//				$po['work_order_id'] = $wo->id;
//				$po['purchase_order_num'] = $quote_info['Quote']['quote_number'];
//				$po['quote_id'] = $quote_info['Quote']['id'];
//				$po['shipment_date'] = date("Y-m-d");
//				$po['expiry_date'] = date("Y-m-d");
//				$po['cc_num'] = 'Test CC Number';
//				$po['name_cc'] = 'Test CC Name';
//				$po['payment_type'] = 'On Account';
//				//$purchaseorder->save($po);
//
//				$index = 0;
//				foreach($quote_info['CabinetOrderItem'] as $qitem){
//					$purchaseorderitem = new PurchaseOrderItem();
//					$item_info = $this->findQuoteItem($qitem['item_id']);
//					$supplier_required = $this->findQuoteItemDept($item_info['Item']['item_department_id']);
//					if(!empty($supplier_required['ItemDepartment']['supplier_required'])){
//						$po_item[$index]['item_id'] = $item_info['Item']['id'];
//						$po_item[$index]['code'] = $item_info['Item']['id']."|item";
//						$po_item[$index]['purchase_order_id'] = $purchaseorder->id;
//						$index++;
//					}
//				}
//				//$purchaseorderitem->saveAll($po_item);
//			}
//		}exit;
        //exit;
        if( $QuoteStatus->save($quote_status) ) {
            $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/detail/{$wo->id}");
        }
    }

    public function quote_payment_view($id = null) {
        App::import("Model", "UploadPayment");
        $UploadPayment_model = new UploadPayment();
        $data = $UploadPayment_model->find("all", array( "conditions" => array( "UploadPayment.ref_id" => $id ) ));

        App::import("Model", "QuoteManager.Quote");
        $Quote_model = new Quote();
        $Quote_data = $Quote_model->find("first", array( "conditions" => array( "Quote.id" => $id ) ));

        $this->set(compact('data', 'Quote_data'));
    }

    public function findQuoteItem($id = null) {
        App::import("Model", "Inventory.Item");
        $item = new Item();
        $item_info = $item->find("first", array( "conditions" => array( "Item.id" => $id ), 'recursive' => -1 ));
        return $item_info;
    }

    public function findQuoteItemDept($id = null) {
        App::import("Model", "Inventory.ItemDepartment");
        $ItemDepartment = new ItemDepartment();
        $itemdepartment_info = $ItemDepartment->find("first", array( "conditions" => array( "ItemDepartment.id" => $id ), 'recursive' => -1 ));
        //if(!empty($itemdepartment_info['ItemDepartment']['supplier_required']))
        return $itemdepartment_info;
    }

    public function quote_unlock($id = null) {
        $this->autoRender = FALSE;

        App::import('Model', 'QuoteManager.QuoteStatus');
        $QuoteStatus = new QuoteStatus();

        App::import('Model', 'QuoteManager.Quote');
        $Quote = new Quote();
        $quote['Quote']['id'] = $id;
        $quote['Quote']['status'] = 'Change';

        $test = $Quote->save($quote);

        $quote_status['QuoteStatus']['status'] = 'Change';
        $quote_status['QuoteStatus']['quote_id'] = $id;

        if( $QuoteStatus->save($quote_status) ) {
            $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$id}#quote-detail");
        }
    }

    public function delete_temporary($id = null) {
        $this->autoRender = FALSE;
        App::import('Model', 'QuoteManager.CabinetOrder');
        $CabinetOrder = new CabinetOrder();
        $CabinetOrder->recursive = false;
        $CabinetOrder->id = (int) $id;
        if( !$CabinetOrder->exists() ) {
            return json_encode(array( 'invalid_id' => 1, 'success' => 0, 'deleted' => 0 ));
        }
        $data = $CabinetOrder->read(null, $id);

        if( $data['CabinetOrder']['temporary'] ) {
            if( $CabinetOrder->delete($id) ) {
                return json_encode(array( 'id' => $id, 'invalid_id' => 0, 'success' => 1, 'deleted' => 1 ));
            }
            else {
                return json_encode(array( 'id' => $id, 'invalid_id' => 0, 'success' => 0, 'deleted' => 0 ));
            }
        }

        $CabinetOrder = new CabinetOrder();
        $data = array( 'id' => $id, 'temporary_delete' => 1 );
        if( $CabinetOrder->save($data) ) {
            return json_encode(array( 'id' => $id, 'invalid_id' => 0, 'success' => 1, 'deleted' => 0 ));
        }
        else {
            return json_encode(array( 'id' => $id, 'invalid_id' => 0, 'success' => 0, 'deleted' => 0 ));
        }
    }

    public function detail_section($id = null, $section = null) {
        $this->layoutOpt['left_nav_selected'] = "view_quote";
//    $this->Quote->recursive = 2;

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));

        $this->set(compact('quote', 'section', 'user_id', 'quote_status'));
    }

    public function auto_generate_num() {
        $this->autoRender = false;
        $value = "";
        App::uses('Quote', 'QuoteManager.Model');
        $quoteModel = new Quote();
        $quotes = $quoteModel->find('all', array( 'fields' => array( 'Quote.id,Quote.quote_number' ) ));
        if( $quotes ) {
            $quote_number = (int) $quotes[count($quotes) - 1]['Quote']['quote_number'];
            $cnt = count($quotes);
            $max = 0;
            for( $i = 1; $i <= $cnt; $i++ ) {
                $num = (int) $quotes[$i - 1]['Quote']['quote_number'];
                if( $max < $num )
                    $max = $num;
            }
            $quote_number = explode("-", $quote_number);
            $length = (strlen($quote_number[0] + 1) == strlen($quote_number[0])) ? strlen($quote_number[0]) : strlen($quote_number[0] + 1);
            for( $i = $length; $i < 6; $i++ ) {
                $value .='0';
            }
            //$value.=$quote_number[0] + 1;
            $value.=$max + 1;
        }
        else {
            $value = "000001";
        }
        return $value;
    }

    public function create_new_quote_from_existing_quote($id) {
        $this->autoRender = false;
        // backup old version
        $quote_id = (int) $id;
        App::import('Model', 'QuoteManager.Quote');
        $quote = new Quote();
        $quote_model = new Quote();
        $quote_model->recursive = -1;

        $backup_data = $quote->find('first', array( 'conditions' => array( 'Quote.id' => $quote_id ) ));
        $update_version = $quote->find('first', array( 'conditions' => array( 'Quote.id' => $quote_id ) ));

        $new_quote_number = $this->auto_generate_num();

        $current_user = $this->loginUser;
        $backup_data['Quote']['id'] = null;
        $backup_data['Quote']['created'] = date('Y-m-d H:i:s');
        $backup_data['Quote']['created_by'] = isset($current_user['id']) ? $current_user['id'] : '0';
        $backup_data['Quote']['quote_number'] = $new_quote_number;
        $backup_data['Quote']['current_version'] = null;
        unset($backup_data['WorkOrder']);
        unset($backup_data['PurchaseOrder']);
        $backup_data_all = $backup_data;
        unset($backup_data['QuoteStatus']);
        unset($backup_data['CabinetOrder']);
        unset($backup_data['QuoteInstallerPaysheet']);
        unset($backup_data['CabinetOrderItem']);
        unset($backup_data['Customer']);
        unset($backup_data['User']);
        unset($backup_data['UserCreated']);
        unset($backup_data['Invoice']);
        unset($backup_data['GraniteOrder']);
        unset($backup_data['GraniteOrderItem']);

        $flag = $quote->save($backup_data['Quote'], false);
        $quote_id = (int) $quote->id; // new quote id

        $backup_data['Quote']['id'] = $quote_id;

        // Quote Installer Paysheet
        foreach( $backup_data_all['QuoteInstallerPaysheet'] as $index => $value ) {
            $backup_data_all['QuoteInstallerPaysheet'][$index]['id'] = null;
            $backup_data_all['QuoteInstallerPaysheet'][$index]['quote_id'] = $quote_id;
        }
        App::import('Model', 'QuoteManager.QuoteInstallerPaysheet');
        $QuoteInstallerPaysheet = new QuoteInstallerPaysheet();
        $QuoteInstallerPaysheet->saveAll($backup_data_all['QuoteInstallerPaysheet']);

        if( !empty($backup_data_all['GraniteOrder']) ) {
            // Granite Order
            foreach( $backup_data_all['GraniteOrder'] as $index => $value ) {
                $backup_data_all['GraniteOrder'][$index]['id'] = null;
                $backup_data_all['GraniteOrder'][$index]['quote_id'] = $quote_id;
            }
            App::import('Model', 'QuoteManager.GraniteOrder');
            $graniteOrder = new GraniteOrder();
            $graniteOrder->saveAll($backup_data_all['GraniteOrder']);

            // Granite Order Item
            foreach( $backup_data_all['GraniteOrderItem'] as $index => $value ) {
                $backup_data_all['GraniteOrderItem'][$index]['id'] = null;
                $backup_data_all['GraniteOrderItem'][$index]['quote_id'] = $quote_id;
                $backup_data_all['GraniteOrderItem'][$index]['granite_order_id'] = $graniteOrder->id;
            }
            App::import('Model', 'QuoteManager.GraniteOrderItem');
            $graniteOrderItem = new GraniteOrderItem();
            $graniteOrderItem->saveAll($backup_data_all['GraniteOrderItem']);
        }
        if( !empty($backup_data_all['CabinetOrder']) ) {
            // Cabinet Order
            foreach( $backup_data_all['CabinetOrder'] as $index => $value ) {
                $backup_data_all['CabinetOrder'][$index]['id'] = null;
                $backup_data_all['CabinetOrder'][$index]['quote_id'] = $quote_id;
            }
            App::import('Model', 'QuoteManager.CabinetOrder');
            $CabinetOrder = new CabinetOrder();
            $CabinetOrder->saveAll($backup_data_all['CabinetOrder'], false);
        }
        // Cabinet Order Item
//    foreach ($backup_data_all['CabinetOrderItem'] as $index => $value) {
//      $backup_data_all['CabinetOrderItem'][$index]['id'] = null;
//      $backup_data_all['CabinetOrderItem'][$index]['quote_id'] = $quote_id;
//      $backup_data_all['CabinetOrderItem'][$index]['cabinet_order_id'] = $CabinetOrder->id;
//    }
//    App::import('Model', 'QuoteManager.CabinetOrderItem');
//    $CabinetOrderItem = new CabinetOrderItem();
//    $CabinetOrderItem->saveAll($backup_data_all['CabinetOrderItem']);
        $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$quote_id}#quote-basic-info-detail");
    }

    public function create_history($id) {
        $this->autoRender = false;
        // backup old version
        $quote_id = (int) $id;
        App::import('Model', 'QuoteManager.Quote');
        $quote = new Quote();
        $quote_model = new Quote();
        $quote_model->recursive = -1;

//    cake_debug($quote_id); exit;
        $backup_data = $quote->find('first', array( 'conditions' => array( 'Quote.id' => $quote_id ) ));
        $update_version = $quote->find('first', array( 'conditions' => array( 'Quote.id' => $quote_id ) ));

        $versions = $quote_model->find('all', array( 'conditions' => array( 'Quote.vid' => $quote_id ) ));
        $current_version = count($versions) + 1;
        $quote_number_split = explode('-', $update_version['Quote']['quote_number']);
        $update_version['Quote']['quote_number'] = "{$quote_number_split[0]}-{$current_version}";
        $this->request->data['Quote']['quote_number'] = "{$quote_number_split[0]}-{$current_version}";
        $update_version['Quote']['current_version'] = $current_version;
        $update_version['Quote']['status'] = "Revision";
//    pr($update_version['Quote']); exit;
        $quote_model->save($update_version['Quote']);

        $current_user = $this->loginUser;
        $backup_data['Quote']['vid'] = $quote_id;
        $backup_data['Quote']['id'] = null;
        $backup_data['Quote']['created'] = date('Y-m-d H:i:s');
        $backup_data['Quote']['created_by'] = isset($current_user['id']) ? $current_user['id'] : '0';

        unset($backup_data['WorkOrder']);
        unset($backup_data['PurchaseOrder']);
        $backup_data_all = $backup_data;
        unset($backup_data['QuoteStatus']);
        unset($backup_data['CabinetOrder']);
        unset($backup_data['QuoteInstallerPaysheet']);
        unset($backup_data['CabinetOrderItem']);
        unset($backup_data['Customer']);
        unset($backup_data['User']);
        unset($backup_data['UserCreated']);
        unset($backup_data['Invoice']);
        unset($backup_data['GraniteOrder']);
        unset($backup_data['GraniteOrderItem']);

//    pr($backup_data);exit;
        $flag = $quote->save($backup_data['Quote'], false);
        $backup_data['Quote']['vid'] = $quote_id; // old quote id
        $quote_id = (int) $quote->id; // new quote id
        if( isset($this->request->data['QuoteStatus']) && !empty($this->request->data['QuoteStatus']) ) {
            $this->request->data['QuoteStatus']['quote_vid'] = $quote_id;
        }

        $backup_data['Quote']['id'] = $quote_id;

        // Quote Installer Paysheet
        foreach( $backup_data_all['QuoteInstallerPaysheet'] as $index => $value ) {
            $backup_data_all['QuoteInstallerPaysheet'][$index]['id'] = null;
            $backup_data_all['QuoteInstallerPaysheet'][$index]['quote_id'] = $quote_id;
        }
        App::import('Model', 'QuoteManager.QuoteInstallerPaysheet');
        $QuoteInstallerPaysheet = new QuoteInstallerPaysheet();
        $QuoteInstallerPaysheet->saveAll($backup_data_all['QuoteInstallerPaysheet']);

        // Quote Status
        foreach( $backup_data_all['QuoteStatus'] as $index => $value ) {
            $backup_data_all['QuoteStatus'][$index]['id'] = null;
            $backup_data_all['QuoteStatus'][$index]['quote_id'] = $quote_id;
            $backup_data_all['QuoteStatus'][$index]['quote_vid'] = $backup_data['Quote']['vid'];
        }
        App::import('Model', 'QuoteManager.QuoteStatus');
        $QuoteStatus = new QuoteStatus();
        $QuoteStatus->saveAll($backup_data_all['QuoteStatus']);


        if( !empty($backup_data_all['GraniteOrder']) ) {
            // Granite Order
            foreach( $backup_data_all['GraniteOrder'] as $index => $value ) {
                $backup_data_all['GraniteOrder'][$index]['id'] = null;
                $backup_data_all['GraniteOrder'][$index]['quote_id'] = $quote_id;
            }
            App::import('Model', 'QuoteManager.GraniteOrder');
            $graniteOrder = new GraniteOrder();
            $graniteOrder->saveAll($backup_data_all['GraniteOrder']);

            // Granite Order Item
            foreach( $backup_data_all['GraniteOrderItem'] as $index => $value ) {
                $backup_data_all['GraniteOrderItem'][$index]['id'] = null;
                $backup_data_all['GraniteOrderItem'][$index]['quote_id'] = $quote_id;
                $backup_data_all['GraniteOrderItem'][$index]['granite_order_id'] = $graniteOrder->id;
            }
            App::import('Model', 'QuoteManager.GraniteOrderItem');
            $graniteOrderItem = new GraniteOrderItem();
            $graniteOrderItem->saveAll($backup_data_all['GraniteOrderItem']);
        }
        if( !empty($backup_data_all['CabinetOrder']) ) {
            // Cabinet Order
            foreach( $backup_data_all['CabinetOrder'] as $index => $value ) {
                $backup_data_all['CabinetOrder'][$index]['id'] = null;
                $backup_data_all['CabinetOrder'][$index]['quote_id'] = $quote_id;
            }
            App::import('Model', 'QuoteManager.CabinetOrder');
            $CabinetOrder = new CabinetOrder();
            $CabinetOrder->saveAll($backup_data_all['CabinetOrder'], false);
        }
        // Cabinet Order Item
//    foreach ($backup_data_all['CabinetOrderItem'] as $index => $value) {
//      $backup_data_all['CabinetOrderItem'][$index]['id'] = null;
//      $backup_data_all['CabinetOrderItem'][$index]['quote_id'] = $quote_id;
////      $backup_data_all['CabinetOrderItem'][$index]['cabinet_order_id'] = $CabinetOrder->id;
//    }
//    App::import('Model', 'QuoteManager.CabinetOrderItem');
//    $CabinetOrderItem = new CabinetOrderItem();
//    $CabinetOrderItem->saveAll($backup_data_all['CabinetOrderItem']);
//    }
    }

    public function reports($limit = REPORT_LIMIT) {
        $this->layoutOpt['left_nav'] = "quote-left-nav";
        $this->layoutOpt['left_nav_selected'] = "report_quote";

        $this->Quote->recursive = 1;

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
        $this->paginate['conditions'] = $this->Quote->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Quote.vid' => null ); // skip version histories

        if( !empty($this->passedArgs['start_date']) ) {
            $date = empty($this->passedArgs['start_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['start_date']));
            $this->paginate['conditions'] += array( 'Quote.created >=' => $date );
        }
        if( !empty($this->passedArgs['end_date']) ) {
            $date = empty($this->passedArgs['end_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['end_date']));
            $this->paginate['conditions'] += array( 'Quote.created <=' => $date );
        }

        if( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 1 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'On Progress' );
            $report_type = $this->passedArgs['report_type'];
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 2 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'New' );
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 3 ) {
            $this->paginate['conditions'] += array( 'UserCreated.role !=' => 96 );
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 4 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'Approve' );
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 6 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'Review' );
        }
        $quotes = $this->paginate();
        $paginate = true;
        $legend = "Reports";

//    debug($quotes);

        $this->set(compact('quotes', 'paginate', 'legend', 'report_type'));
    }

    public function reports_print($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->recursive = 1;

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
        $this->paginate['conditions'] = $this->Quote->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Quote.vid' => null ); // skip version histories

        if( !empty($this->passedArgs['start_date']) ) {
            $date = empty($this->passedArgs['start_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['start_date']));
            $this->paginate['conditions'] += array( 'Quote.created >=' => $date );
            $reportStartDate = date('l, F d, Y', strtotime($this->passedArgs['start_date']));
        }
        if( !empty($this->passedArgs['end_date']) ) {
            $date = empty($this->passedArgs['end_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['end_date']));
            $this->paginate['conditions'] += array( 'Quote.created <=' => $date );
            $reportEndDate = date('l, F d, Y', strtotime($this->passedArgs['end_date']));
        }

        if( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 1 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'On Progress' );
            $reportTitle = "Jobs Costing Work in progress";
            $report_type = $this->passedArgs['report_type'];
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 2 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'New' );
            $reportTitle = "Jobs Entered in a system";
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 3 ) {
            $this->paginate['conditions'] += array( 'UserCreated.role !=' => 96 );
            $reportTitle = "Jobs not submitted by sales person";
        }
        elseif( isset($this->passedArgs['report_type']) && $this->passedArgs['report_type'] == 4 ) {
            $this->paginate['conditions'] += array( 'Quote.status' => 'Approve' );
            $reportTitle = "Jobs Submitted report";
        }

        $quotes = $this->paginate();
        $paginate = true;
        $legend = "Quotes";
        $reportDate = date('l, F d, Y');

        $this->set(compact('quotes', 'paginate', 'reportTitle', 'legend', 'reportDate', 'reportEndDate', 'reportStartDate', 'report_type'));
    }

    public function listing_report_print($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->recursive = 0;

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
        $this->paginate['conditions'] = $this->Quote->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Quote.vid' => null ); // skip version histories

        $reportDate = date('l, F d, Y');
        $quotes = $this->paginate();
        $paginate = false;
        $legend = "Quotes";
        $reportTitle = "General Listing Report";

        $this->set(compact('quotes', 'paginate', 'reportTitle', 'legend', 'reportDate', 'reportEndDate', 'reportStartDate'));
    }

    public function quote_price() {
        
    }

    public function order_form($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->recursive = 3;

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);

        if( !is_null($quote['Quote']['vid']) ) { // redirect to parent quote
            $this->redirect(array( $quote['Quote']['vid'] ));
        }
//    debug($quote);
        $reportDate = date('l, F d, Y');
        $reportTitle = "Order";
        $reportNumber = $quote['Quote']['quote_number'];

        $user_id = $this->loginUser['id'];
        $this->set(compact('quote', 'reportDate', 'reportTitle', 'reportNumber'));
    }

    public function counter_top_form($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->recursive = 3;

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);

        if( !is_null($quote['Quote']['vid']) ) { // redirect to parent quote
            $this->redirect(array( $quote['Quote']['vid'] ));
        }
//    debug($quote);
        $reportDate = date('l, F d, Y');
        $reportTitle = "Counter Top";
        $reportNumber = $quote['Quote']['quote_number'];

        $user_id = $this->loginUser['id'];
        $this->set(compact('quote', 'reportDate', 'reportTitle', 'reportNumber'));
    }

    public function pricing_form($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->recursive = 3;

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);

        if( !is_null($quote['Quote']['vid']) ) { // redirect to parent quote
            $this->redirect(array( $quote['Quote']['vid'] ));
        }

//    debug($quote);
        $price = $this->QuoteItem->quotePrice($quote);
//    debug($price);

        $reportDate = date('l, F d, Y');
        $reportTitle = "Order Pricing";
        $reportNumber = $quote['Quote']['quote_number'];

        $user_id = $this->loginUser['id'];
        $this->set(compact('quote', 'reportDate', 'reportTitle', 'reportNumber', 'price'));
    }

    public function install_completion($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->recursive = 3;

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);

        if( !is_null($quote['Quote']['vid']) ) { // redirect to parent quote
            $this->redirect(array( $quote['Quote']['vid'] ));
        }

        $reportDate = date('l, F d, Y');
        $reportTitle = "Install Completion";
        $reportNumber = $quote['Quote']['quote_number'];

        $user_id = $this->loginUser['id'];
        $this->set(compact('quote', 'reportDate', 'reportTitle', 'reportNumber', 'price'));
    }

    private function saveTempCalculationResultToPrint($quote_id, $resource_id, $total_cost, $cost_calculation, $resource_type, $cabinet_color, $material_id, $door_id, $door_color, $quantity, $door_side = null, $door_drilling = null, $description = null, $edgetape = null) { //, $drawer_id, $drawer_slide_id) {
        $data = array(
            'quote_id' => $quote_id,
            'resource_id' => $resource_id,
            'total_cost' => $total_cost,
            'cost_calculation' => $cost_calculation,
            'resource_type' => $resource_type,
            'cabinet_color' => $cabinet_color,
            'material_id' => $material_id,
            'door_id' => $door_id,
            'door_color' => $door_color,
            'quantity' => $quantity,
            'description' => $description,
            'edgetape' => $edgetape,
//        'drawer_id' => $drawer_id,
//        'drawer_slide_id' => $drawer_slide_id,
            'temporary' => '1',
            'door_side' => $door_side,
            'door_drilling' => $door_drilling,
        );
        App::import('Model', 'QuoteManager.CabinetOrder');
        $CabinetOrder = new CabinetOrder();
        if( $CabinetOrder->save($data) ) {
            return $CabinetOrder->id;
        }
        else {
            return null;
        }
    }

    public function calculate_cabinet_price() {
        $this->autoRender = FALSE;
        $calculatePrice['new_row'] = '';

        $resource = explode('|', trim($this->request->data['resource']));
        if( isset($resource[1]) && !empty($resource[1]) ) {
//            pr($this->request->data);exit;
            $resource_id = $resource[0];
            $resource_type = $resource[1];
            $quote_id = (int) $this->request->data['quote_id'];
            $cabinet_color = $this->request->data['cabinet_color'];
            $material_id = $this->request->data['material_id'];
            $door_id = $this->request->data['door_id'];
            $door_color = $this->request->data['door_color'];
            $drawer_id = $this->request->data['drawer_id'];
            $drawer_slide_id = $this->request->data['drawer_slide'];
            $quantity = $this->request->data['resource_quantity'];
            $delivery_option = $this->request->data['delivery_option'];
            $cabinet_order_id = null;
            $door_side = $this->request->data['door_side'];
            $door_drilling = $this->request->data['door_drilling'];
            $customer_id = $this->request->data['customer_id'];

            App::import("Model", "CustomerManager.Customer");
            $customer_model = new Customer();
            $customer = $customer_model->find('first', array( 'conditions' => array( 'Customer.id' => $customer_id ) ));

            App::import("Model", "QuoteManager.Quote");
            $quote_model = new Quote();
            $quote_data = $quote_model->find('first', array( 'conditions' => array( 'Quote.id' => $quote_id ), 'recursive' => -1 ));

            $multi_family_pricing = 0;
            foreach( $customer['BuilderProject'] as $project ) {
                if( $project['id'] == $quote_data['Quote']['project_id'] ) {
                    $multi_family_pricing = $project['multi_family_pricing'];
                }
            }

            if( $customer['Customer']['customer_type_id'] == 2 && $multi_family_pricing == 1 ) {
                switch( $resource_type ) {
                    case 'cabinet':
                        $calculatePrice = $this->PriceCalculation->calculateCabinetPriceForBuilder($resource_id, $cabinet_color, $material_id, $door_id, $door_color, $drawer_id, $drawer_slide_id, $quantity, $delivery_option);
                        if( !empty($quote_id) ) {
                            $cabinet_order_id = $this->saveTempCalculationResultToPrint($quote_id, $resource_id, $calculatePrice['total_price'], $calculatePrice['debug_calculation'], $resource_type, $cabinet_color, $material_id, $door_id, $door_color, $quantity, $door_side, $door_drilling); //, $drawer_id, $drawer_slide_id);
                        }
                        break;
                    case 'item':
                        $calculatePrice = $this->PriceCalculation->calculateItemPriceForBuilder($resource_id, $quantity, $material_id, $cabinet_color);
                        if( !empty($quote_id) ) {
                            $cabinet_order_id = $this->saveTempCalculationResultToPrint($quote_id, $resource_id, $calculatePrice['total_price'], $calculatePrice['debug_calculation'], $resource_type, null, $material_id, null, null, $quantity); //, $drawer_id, $drawer_slide_id);
                        }
                        break;
                }
            }
            else {
                switch( $resource_type ) {
                    case 'cabinet':
                        $calculatePrice = $this->PriceCalculation->calculateCabinetPrice($resource_id, $cabinet_color, $material_id, $door_id, $door_color, $drawer_id, $drawer_slide_id, $quantity, $delivery_option);
                        if( !empty($quote_id) ) {
                            $cabinet_order_id = $this->saveTempCalculationResultToPrint($quote_id, $resource_id, $calculatePrice['total_price'], $calculatePrice['debug_calculation'], $resource_type, $cabinet_color, $material_id, $door_id, $door_color, $quantity, $door_side, $door_drilling); //, $drawer_id, $drawer_slide_id);
                        }
                        break;
                    case 'item':
                        $calculatePrice = $this->PriceCalculation->calculateItemPrice($resource_id, $quantity, $material_id, $cabinet_color);
                        if( !empty($quote_id) ) {
                            $cabinet_order_id = $this->saveTempCalculationResultToPrint($quote_id, $resource_id, $calculatePrice['total_price'], $calculatePrice['debug_calculation'], $resource_type, null, $material_id, null, null, $quantity); //, $drawer_id, $drawer_slide_id);
                        }
                        break;
                }
            }

            if( $resource_id ) {
                /* Set up new view that won't enter the ClassRegistry */
                $view = new View($this, false);
                $view->set('calculatePrice', $calculatePrice);
                $view->set('cabinet_order_id', $cabinet_order_id);
                $view->set('door_side', $door_side);
                $view->set('door_drilling', $door_drilling);
                /* Grab output into variable without the view actually outputting! */
                $view_output = $view->render('../Elements/Forms/Order/cabinet-order-form-row');
                $calculatePrice['new_row'] = $view_output;
            }
        }

        echo json_encode($calculatePrice);
        exit;
    }

    public function calculate_custom_panel() {
        $this->autoRender = FALSE;

        $quote_id = (int) $this->request->data['quote_id'];
        $height = (int) $this->request->data['height'];
        $width = (int) $this->request->data['width'];
        $color_id = (int) $this->request->data['color_id'];
        $material_id = (int) $this->request->data['material_id'];
        $edgetape = $this->request->data['edgetape'];
        $cabinet_order_id = null;

        if( empty($height) || empty($width) || empty($color_id) || empty($material_id) ) {
            $calculateCustomPanel['new_row'] = '';
        }
        else {
            $calculateCustomPanel = $this->PriceCalculation->calculateCustomPanel($height, $width, $color_id, $material_id, $edgetape);
            if( !empty($quote_id) ) {
                $cabinet_order_id = $this->saveTempCalculationResultToPrint($quote_id, 0, $calculateCustomPanel['total_price'], $calculateCustomPanel['debug_calculation'], $calculateCustomPanel['conditions']['resource_type'], $color_id, $material_id, null, null, '1', $calculateCustomPanel['description'], $calculateCustomPanel['conditions']['edgetape']);
            }

            $calculateCustomPanel['new_row'] = '';

            /* Set up new view that won't enter the ClassRegistry */
            $view = new View($this, false);
            $view->set('calculatePrice', $calculateCustomPanel);
            $view->set('cabinet_order_id', $cabinet_order_id);
            /* Grab output into variable without the view actually outputting! */
            $view_output = $view->render('../Elements/Forms/Order/cabinet-order-form-row-custom');
            $calculateCustomPanel['new_row'] = $view_output;
        }

        echo json_encode($calculateCustomPanel);
        exit;
    }

    public function calculate_custom_door() {
        $this->autoRender = FALSE;

        $quote_id = (int) $this->request->data['quote_id'];
        $height = (int) $this->request->data['height'];
        $width = (int) $this->request->data['width'];
        $color = (int) $this->request->data['color'];
        $door_id = (int) $this->request->data['door_id'];
        $cabinet_order_id = null;

        if( empty($height) || empty($width) || empty($color) || empty($door_id) ) {
            $calculateCustomDoor['new_row'] = '';
        }
        else {
            $calculateCustomDoor = $this->PriceCalculation->calculateCustomDoor($height, $width, $color, $door_id);
            if( !empty($quote_id) ) {
                $cabinet_order_id = $this->saveTempCalculationResultToPrint($quote_id, 0, $calculateCustomDoor['total_price'], $calculateCustomDoor['debug_calculation'], $calculateCustomDoor['conditions']['resource_type'], null, null, $door_id, $color, '1', $calculateCustomDoor['description']);
            }

            $calculateCustomDoor['new_row'] = '';

            /* Set up new view that won't enter the ClassRegistry */
            $view = new View($this, false);
            $view->set('calculatePrice', $calculateCustomDoor);
            $view->set('cabinet_order_id', $cabinet_order_id);
            /* Grab output into variable without the view actually outputting! */
            $view_output = $view->render('../Elements/Forms/Order/cabinet-order-form-row-custom');
            $calculateCustomDoor['new_row'] = $view_output;
        }

        echo json_encode($calculateCustomDoor);
        exit;
    }

    public function saveCustomerForm() {
        $this->autoRender = FALSE;

        $this->request->data['Customer']['first_name'] = $this->request->data['first_name'];
        $this->request->data['Customer']['last_name'] = $this->request->data['last_name'];
        $this->request->data['Customer']['phone'] = $this->request->data['phone'];
        $this->request->data['Customer']['sales_representatives'] = $this->request->data['sales_person'];
        $this->request->data['Customer']['status'] = 1;

        App::import("Model", "CustomerManager.Customer");
        $customer = new Customer();

        App::import("Model", "CustomerManager.BuilderAccount");
        $builderaccount = new BuilderAccount();

        if( $this->request->data['type'] == 'Retail Customer' ) {
            $this->request->data['Customer']['customer_type_id'] = 1;
            $info = $customer->save($this->request->data);

            $data1['value'] = $info['Customer']['id'];
            $data1['name'] = $info['Customer']['first_name'] . " " . $info['Customer']['last_name'];
            echo json_encode($data1);
        }
        if( $this->request->data['type'] == 'Builder' ) {
            $this->request->data['Customer']['customer_type_id'] = 2;
            $info = $customer->save($this->request->data);

            $builder['BuilderAccount']['customer_id'] = $info['Customer']['id'];
            $builder['BuilderAccount']['builder_legal_name'] = $info['Customer']['first_name'] . " " . $info['Customer']['last_name'];
            $builder['BuilderAccount']['builder_type'] = 108;
            $builderaccount->save($builder);

            $data2['value'] = $info['Customer']['id'];
            $data2['name'] = $info['Customer']['first_name'] . " " . $info['Customer']['last_name'];
            echo json_encode($data2);
        }
        exit;
    }

    function get_all_type_item_list() {
        App::uses('Sanitize', 'Utility');
        $name = Sanitize::escape($this->request->query['term']);

        App::import("Model", "Inventory.Cabinet");
        App::import("Model", "Inventory.Item");
        $item = new Item();

        $query = "SELECT cabinets.id AS id, cabinets.name AS code, 'cabinet' AS item_type, cabinets.manual_unit_price AS price, cabinets.name AS title, 'cabinet' AS item_type
                FROM cabinets
                WHERE cabinets.name LIKE '%{$name}%' LIMIT 5
               UNION
              SELECT items.id AS id, items.item_title AS code, 'item' AS item_type, items.price AS price, items.item_title AS title, 'item' AS item_type
                FROM items
                LEFT JOIN item_departments ON item_departments.id = items.item_department_id
                WHERE item_departments.direct_sale = 1 AND items.base_item = 0 AND items.item_title LIKE '%{$name}%' LIMIT 5";
        $result = $item->query($query);

        $return_data = array( );
        $index = 0;
        foreach( $result as $row ) {
            $return_data[$index]['id'] = "{$row[0]['id']}|{$row[0]['item_type']}";
            $return_data[$index]['text'] = $row[0]['code'];
            $return_data[$index]['item_type'] = $row[0]['item_type'];
            if( $row[0]['item_type'] == 'item' ) {
                $return_data[$index]['door_count'] = 0;
                $return_data[$index]['quote_color_required'] = 0;
                $return_data[$index]['quote_material_required'] = 0;
            }
            elseif( $row[0]['item_type'] == 'cabinet' ) {
                $cabinet = new Cabinet();
                $cabinet->recursive = 0;
                $cabinet_detail = $cabinet->find('first', array( 'conditions' => array( 'Cabinet.id' => $row[0]['id'] ) ));
                $return_data[$index]['door_count'] = (int) $cabinet_detail['Cabinet']['top_door_count'] + (int) $cabinet_detail['Cabinet']['bottom_door_count']
                        + (int) $cabinet_detail['Cabinet']['top_drawer_front_count'] + (int) $cabinet_detail['Cabinet']['middle_drawer_front_count']
                        + (int) $cabinet_detail['Cabinet']['bottom_drawer_front_count'] + (int) $cabinet_detail['Cabinet']['dummy_drawer_front_count'];
                $return_data[$index]['quote_color_required'] = (int) $cabinet_detail['Cabinet']['quote_color_required'];
                $return_data[$index]['quote_material_required'] = (int) $cabinet_detail['Cabinet']['quote_material_required'];
            }
            $index++;
        }
        print json_encode($return_data);
        exit;
    }

    function delete_single_file_payment($quote_id, $id) {
        App::import("Model", "UploadPayment");
        @$upload_model = new UploadPayment();

        if( !$id ) {
            $this->Session->setFlash(__('Invalid id for delete', true));
            $this->redirect(array( 'action' => 'index' ));
        }
        @$upload_model->delete($id);

        $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$quote_id}#payment-info");
    }

    function delete_single_file($quote_id, $id) {
        App::import("Model", "Upload");
        @$upload_model = new Upload();

        if( !$id ) {
            $this->Session->setFlash(__('Invalid id for delete', true));
            $this->redirect(array( 'action' => 'index' ));
        }
        @$upload_model->delete($id);

        $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$quote_id}#quote-documents");
    }

    function upload_single_file($id) {
        if( $this->uploadFile() ) {
            App::import("Model", "Upload");
            $upload = new Upload();
            if( !$upload->save($this->data) ) {
                $this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        else {
            $this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
        }
        $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$id}#quote-documents");
    }

    function findTotalAmountQuote($id = null) {
        $quote = $this->Quote->read(null, $id);

        $total_quote_price = 0;
        $total_quote_price_cabinet = 0;
        $total_quote_price_installation = 0;
        $total_quote_price_discount = 0;
        $cabinets = array( );

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
                        break;

                    default:
                        break;
                };
                $sub_total = $cabinet_order['total_cost'];
                $total_quote_price_cabinet += $sub_total;
            }
        }
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
                    $sub_total = $installation['price'] * $installation['quantity'];
                    $total_quote_price_installation += $sub_total;
                }
            }
        }

        $total_quote_price = $total_quote_price_cabinet + $total_quote_price_installation;

        if( $quote['Quote']['delivery'] == '5 – 10 Weeks Delivery' ) {
            $total_quote_price_discount = $total_quote_price * 0.25; // 25% discount for late delivery
        }

        $total_quote_price -= $total_quote_price_discount;

        return $total_quote_price;
    }

    function upload_single_file_payment($id) {
        $this->autoRender = false;
        if( $this->data['UploadPayment']['deposit'] == 'Yes' ) {
            App::import("Model", "UploadPayment");
            $upload = new UploadPayment();
            $upload_data = $upload->find('first', array( 'conditions' => array( 'UploadPayment.ref_id' => $id ) ));

            if( empty($upload_data) ) {
                App::import("Model", "PurchaseOrderManager.GeneralSetting");
                $generalsetting_model = new GeneralSetting();
                $deposit = $generalsetting_model->find('first', array( 'conditions' => array( 'GeneralSetting.type' => 'deposit_payment' ) ));

                $total_for_quote = $this->findTotalAmountQuote($id);
                $minimum_payment = number_format(($deposit['GeneralSetting']['value'] / 100) * $total_for_quote, 2);
                $total_amount_from_form = number_format($this->data['UploadPayment']['amount'], 2);
                if( $total_amount_from_form < $minimum_payment ) {
                    $m = "Please put minimum amount for payment";
                    die(json_encode($m));
                }
            }
        }
        if( !empty($this->request->data['UploadPayment']['file']) ) {
            $this->uploadFilePayment();
        }

        App::import("Model", "UploadPayment");
        $upload = new UploadPayment();
        $upload->save($this->data);

        $m = "Saved";
        die(json_encode($m));
    }

    function upload_single_file_payment_edit($id = null) {
        $this->autoRender = false;
        if( !empty($this->request->data['UploadPayment']['file']) ) {
            $this->uploadFilePaymentEdit($this->request->data['UploadPayment']['id']);
        }
        App::import("Model", "UploadPayment");
        $upload = new UploadPayment();

        $this->data['UploadPayment']['id'] = $id;
        if( !$upload->save($this->data) ) {
//			$this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
        }
        $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}quote_manager/quotes/detail/{$id}#payment-info");
    }

    function download_single_file($id) {
        App::import("Model", "Upload");
        $upload_model = new Upload();

        if( !$id ) {
            $this->Session->setFlash(__('Invalid id for upload', true));
            $this->redirect(array( 'action' => 'index' ));
        }
        $upload = $upload_model->find('first', array(
            'conditions' => array(
                'Upload.id' => $id,
            )
                ));
        if( !$upload ) {
            $this->Session->setFlash(__('Invalid id for upload', true));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->viewClass = 'Media';
        $filename = $upload['Upload']['filename'];
        $this->set(array(
            'id' => $upload['Upload']['id'],
            'name' => substr($filename, 0, strrpos($filename, '.')),
            'extension' => substr(strrchr($filename, '.'), 1),
            'path' => APP . 'uploads' . DS . $upload['Upload']['ref_model'] . DS . $upload['Upload']['ref_id'] . DS,
            'download' => true,
        ));
    }

    function download_single_file_payment($id) {
        App::import("Model", "UploadPayment");
        $upload_model = new UploadPayment();

        if( !$id ) {
            $this->Session->setFlash(__('Invalid id for upload', true));
            $this->redirect(array( 'action' => 'index' ));
        }
        $upload = $upload_model->find('first', array(
            'conditions' => array(
                'UploadPayment.id' => $id,
            )
                ));
        if( !$upload ) {
            $this->Session->setFlash(__('Invalid id for upload', true));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->viewClass = 'Media';
        $filename = $upload['UploadPayment']['filename'];
        $this->set(array(
            'id' => $upload['UploadPayment']['id'],
            'name' => substr($filename, 0, strrpos($filename, '.')),
            'extension' => substr(strrchr($filename, '.'), 1),
            'path' => APP . 'uploads' . DS . $upload['UploadPayment']['ref_model'] . DS . $upload['UploadPayment']['ref_id'] . DS,
            'download' => true,
        ));
    }

    function uploadFile() {
        $file = $this->request->data['Upload']['file'];
        if( $file['error'] === UPLOAD_ERR_OK ) {
            $id = String::uuid();
            mkdir(APP . 'uploads' . DS . $this->data['Upload']['ref_model'] . DS . $this->data['Upload']['ref_id'], 0777, TRUE);
            $dest_file = APP . 'uploads' . DS . $this->data['Upload']['ref_model'] . DS . $this->data['Upload']['ref_id'] . DS . $id;
            if( move_uploaded_file($file['tmp_name'], $dest_file) ) {
                $this->request->data['Upload']['id'] = $id;
                $this->request->data['Upload']['filename'] = $file['name'];
                $this->request->data['Upload']['filesize'] = $file['size'];
                $this->request->data['Upload']['filemime'] = $file['type'];
                return true;
            }
        }
        return false;
    }

    function uploadFilePayment() {
        $file = $this->request->data['UploadPayment']['file'];

        if( $file['error'] === UPLOAD_ERR_OK ) {
            $id = String::uuid();
            mkdir(APP . 'uploads' . DS . $this->data['UploadPayment']['ref_model'] . DS . $this->data['UploadPayment']['ref_id'], 0777, TRUE);
            $dest_file = APP . 'uploads' . DS . $this->data['UploadPayment']['ref_model'] . DS . $this->data['UploadPayment']['ref_id'] . DS . $id;
            if( move_uploaded_file($file['tmp_name'], $dest_file) ) {
                $this->request->data['UploadPayment']['id'] = $id;
                $this->request->data['UploadPayment']['filename'] = $file['name'];
                $this->request->data['UploadPayment']['filesize'] = $file['size'];
                $this->request->data['UploadPayment']['filemime'] = $file['type'];
                return true;
            }
        }
        return false;
    }

    function uploadFilePaymentEdit($id = null) {
        $file = $this->request->data['UploadPayment']['file'];

        if( $file['error'] === UPLOAD_ERR_OK ) {
            //$id = String::uuid();
            mkdir(APP . 'uploads' . DS . $this->data['UploadPayment']['ref_model'] . DS . $this->data['UploadPayment']['ref_id'], 0777, TRUE);
            $dest_file = APP . 'uploads' . DS . $this->data['UploadPayment']['ref_model'] . DS . $this->data['UploadPayment']['ref_id'] . DS . $id;
            if( move_uploaded_file($file['tmp_name'], $dest_file) ) {
                $this->request->data['UploadPayment']['filename'] = $file['name'];
                $this->request->data['UploadPayment']['filesize'] = $file['size'];
                $this->request->data['UploadPayment']['filemime'] = $file['type'];
                return true;
            }
        }
        return false;
    }

    /**
     * cab parts report
     *
     * @param string $id
     * @return void
     */
    public function report_cab_parts($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "002";
        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "CabPack";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    /*
     * Cab Parts PDF function
     */

    public function pdf_cab_parts($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "002";
        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "CabPack";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
//$content = $this->render("/Elements/Detail/Quote/pdf_cab_parts");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_cab_parts");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "cab_parts" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    public function corn_job() {
        $this->layoutOpt['layout'] = 'report';

        App::import('Model', 'WorkOrderManager.WorkOrder');
        $WorkOrder_Model = new WorkOrder();
        $work_order = $WorkOrder_Model->find("all", array( "conditions" => array( "WorkOrder.is_print" => 0 ), "recursive" => -1 ));

        $user_id = $this->loginUser['id'];

        $this->set(compact('work_order', 'user_id'));
    }

    public function pdf_report_cab_parts($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

//		$this->Quote->id = $id;
//    if (!$this->Quote->exists()) {
//      throw new NotFoundException(__('Invalid quote'));
//    }
//    $quote = $this->Quote->read(null, $id);
//    $user_id = $this->loginUser['id'];
//		
//		$bar_code_number = $quote['WorkOrder']['work_order_number']."002";
//    App::import('Model', 'QuoteManager.QuoteStatus');
//    $quoteStatusModel = new QuoteStatus();
//    $quote_status = $quoteStatusModel->find('all', array('conditions' => array('QuoteStatus.quote_id' => $id)));
//    $reportTitle = "CabPack";
//    $reportDate = time();
//
//    $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        $content = $this->render("../Elements/Detail/Quote/pdf_report_cab_parts");

        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $html2pdf->WriteHTML($content);
        $html2pdf->Output('exemple.pdf');
        exit;
//
    }

    public function barCodeImage($code = null) {
        $this->autoRender = false;

        $randomnr = $code;

        $im = imagecreatetruecolor(150, 70);
        $white = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 70, $white);

        $font = WWW_ROOT . "font/UPC-A.ttf";

        imagealphablending($im, true); // set alpha blending on
        imagesavealpha($im, true); // save alphablending setting (important)
        imagettftext($im, 60, 0, 0, 70, $black, $font, $randomnr);

        //prevent caching on client side:
        header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", FALSE);
        header("Pragma: no-cache");

        header("Content-type: image/png");
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * panel parts report
     *
     * @param string $id
     * @return void
     */
    public function report_panel_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00400";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Panel List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_panel_list($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00400";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Panel List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        //$content = $this->render("/Elements/Detail/Quote/pdf_panel_list");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_panel_list");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "pdf_panel_list" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * hardware report
     *
     * @param string $id
     * @return void
     */
    public function report_hardware($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00199";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Hardware";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_hardware($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00199";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Hardware";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        //$content = $this->render("/Elements/Detail/Quote/pdf_hardware");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_hardware");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "hardware" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * cabinet backs report
     *
     * @param string $id
     * @return void
     */
    public function report_cabinet_backs_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00600";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Cabinet Backs";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_cabinet_backs_list($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00600";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Cabinet Backs";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_cabinet_backs_list");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "cabinet_backs" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * cabinet shelf report
     *
     * @param string $id
     * @return void
     */
    public function report_cabinet_shelf_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00800";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Shelf List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_cabinet_shelf_list($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00800";
        //$bar_code_number = substr($bar_code_number, 1, 10);

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Shelf List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

//        $content = $this->render("/Elements/Detail/Quote/pdf_cabinet_shelf_list");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_cabinet_shelf_list");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "cabinet_shelf" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * drawer box report
     *
     * @param string $id
     * @return void
     */
    public function report_drawer_box_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00500";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Drawer List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_drawer_box_list($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00500";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Drawer List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        //$content = $this->render("/Elements/Detail/Quote/pdf_drawer_box_list");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_drawer_box_list");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "drawer_box" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * wood drawer box report
     *
     * @param string $id
     * @return void
     */
    public function report_wood_drawer_box_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00700";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Wood Drawer Box";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_wood_drawer_box($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00700";
        //$bar_code_number = substr($bar_code_number, 1, 10);

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Wood Drawer List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
//$content = $this->render("/Elements/Detail/Quote/pdf_wood_drawer_box");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_wood_drawer_box");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "wood_drawer_box" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    public function report_order_notes($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Order Notes";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate'));
    }

    public function pdf_order_notes($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Order Notes";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate'));

        //$content = $this->render("/Elements/Detail/Quote/pdf_order_notes");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_order_notes");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "order_notes" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * master cabinet parts report
     *
     * @param string $id
     * @return void
     */
    public function report_master_cabinet_parts_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00200";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Master Cabinet Parts List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_master_cabinet_parts($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00200";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Master Cabinet Parts";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        //$content = $this->render("/Elements/Detail/Quote/pdf_master_cabinet_parts");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_master_cabinet_parts");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "pdf_master_cabinet_parts" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * door drawers report
     *
     * @param string $id
     * @return void
     */
    public function report_door_drawer_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00300";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Door/Drawer List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_door_drawer_list($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00300";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Door/Drawer List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

        //$content = $this->render("/Elements/Detail/Quote/pdf_door_drawer_list");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_door_drawer_list");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "door_drawer" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    /**
     * door drawers report
     *
     * @param string $id
     * @return void
     */
    public function report_door_manufacturing_list($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00777";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Door Manufacturing List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));
    }

    public function pdf_door_manufacturing_list($id = null) {
        $this->layoutOpt['layout'] = 'pdf_report';

        $this->Quote->id = $id;
        if( !$this->Quote->exists() ) {
            throw new NotFoundException(__('Invalid quote'));
        }
        $quote = $this->Quote->read(null, $id);
        $user_id = $this->loginUser['id'];

        $bar_code_number = $quote['WorkOrder']['work_order_number'] . "00777";

        App::import('Model', 'QuoteManager.QuoteStatus');
        $quoteStatusModel = new QuoteStatus();
        $quote_status = $quoteStatusModel->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        $reportTitle = "Door Manufacturing List";
        $reportDate = time();

        $this->set(compact('quote', 'section', 'user_id', 'quote_status', 'reportTitle', 'reportDate', 'bar_code_number'));

//$content = $this->render("/Elements/Detail/Quote/pdf_door_manufacturing_list");
        require_once APP . 'Vendor' . DS . 'html2pdf' . DS . 'html2pdf.class.php';
        header('Content-type: application/pdf');
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $content = $this->render("/Elements/Detail/Quote/pdf_door_manufacturing_list");
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $pdfFileName = "door_manufacturing" . ".pdf";
        $html2pdf->Output($pdfFileName, "D");
        exit;
    }

    public function production_index() {
        $this->layoutOpt['left_nav_selected'] = "view_quote";
    }

}
