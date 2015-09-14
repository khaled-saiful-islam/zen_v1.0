<?php

App::uses('WorkOrderManagerAppController', 'WorkOrderManager.Controller');

/**
 * Work Order Controller
 *
 * @property WorkOrder $WorkOrder
 */
class WorkOrdersController extends WorkOrderManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "work-order-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_work_order";
		$this->paginate['conditions'] = array();
		
		if($this->isAjax){
			$this->layoutOpt['layout'] = 'ajax';
		}else{
			$this->layoutOpt['layout'] = 'left_bar_template';
		}
		
		$this->side_bar = "workorder";
		$this->set("side_bar",$this->side_bar);
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->WorkOrder->recursive = 2;

    if (!isset($this->params['named']['limit'])) {
      $this->paginate['limit'] = REPORT_LIMIT;
      $this->paginate['maxLimit'] = REPORT_LIMIT;
    } elseif (isset($this->params['named']['limit']) && $this->params['named']['limit'] != 'All') {
      $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
      $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
    } else {
      $this->paginate['limit'] = 0;
      $this->paginate['maxLimit'] = 0;
    }
		if (!empty($this->passedArgs['est_shipping'])) {
      $date = empty($this->passedArgs['est_shipping']) ? "" : date("Y-m-d", strtotime($this->passedArgs['est_shipping']));
      $this->paginate['conditions'] += array('Quote.est_shipping' => $date);
    }
		
    $this->Prg->commonProcess();
    $this->paginate['conditions'] += $this->WorkOrder->parseCriteria($this->passedArgs);
    $workorders = $this->paginate();
    $paginate = true;
    $legend = "Work Orders";

    $this->set(compact('workorders', 'paginate', 'legend'));
  }

  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_work_order";

    if ($this->request->is('post')) {
      $this->WorkOrder->create();
      if ($this->request->data['WorkOrder']['quote_id'])
        $work_order['WorkOrder']['quote_id'] = $this->request->data['WorkOrder']['quote_id'];
      $flag = false;
//      cake_debug($this->request->data);exit;
//      foreach ($work_order as $value) {
//      $this->request->data['WorkOrder']['quote_id'] = $value;
      $value = $this->QuoteItem->get_quote_number($this->request->data['WorkOrder']['quote_id']);
      $this->request->data['WorkOrder']['work_order_number'] = $value;
//      cake_debug($this->request->data);exit;

      $flag = $this->WorkOrder->save($this->request->data);
      if ($flag) {
        $this->create_po($this->request->data, $flag['WorkOrder']['id']);
        $this->request->data['WorkOrder']['id'] = $flag['WorkOrder']['id'] + 1;
      }
//      }
      if ($flag) {
        $this->Session->setFlash(__('The work order has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The work order could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }

    App::import('Model', 'QuoteManager.Quote');
    $quote = new Quote();
    $quote_info = $quote->find("list", array('fields' => array('id', 'job_name'), "conditions" => array("Quote.status" => 'Approve')));

    $work_order_info = $this->WorkOrder->find("list", array('fields' => array('id', 'quote_id')));
    foreach ($work_order_info as $value)
      unset($quote_info[$value]);

    $this->set(compact('quote_info'));
  }

  public function detail($id = null, $modal = null) {
    $this->layoutOpt['left_nav_selected'] = "view_work_order";
    $this->WorkOrder->recursive = 3;

    $this->WorkOrder->id = $id;
    if (!$this->WorkOrder->exists()) {
      throw new NotFoundException(__('Invalid work order'));
    }
    $work_order = $this->WorkOrder->read(null, $id);

		App::import('Model', 'QuoteManager.Quote');
    $q = new Quote();
		$quote = $q->find('first', array('conditions' => array('Quote.id' => $work_order['Quote']['id'])));
		
    App::import('Model', 'WorkOrderManager.WorkOrderStatus');
    $workOrderStatusModel = new WorkOrderStatus();
    $workOrder_status = $workOrderStatusModel->find('all', array('conditions' => array('WorkOrderStatus.work_order_id' => $id)));

    $user_id = $this->loginUser['id'];
				
		App::import("Model", "Upload");
    $upload_model = new Upload();
    $uploads = $upload_model->find('all', array('conditions' => array('Upload.ref_id' => $work_order['Quote']['id'], 'Upload.ref_model' => 'quotes'), 'order' => array('Upload.title' => 'ASC')));

		App::import("Model", "UploadPayment");
    $upload_payment_model = new UploadPayment();
    $upload_payment = $upload_payment_model->find('all', array('conditions' => array('UploadPayment.ref_id' => $work_order['WorkOrder']['quote_id'], 'UploadPayment.ref_model' => 'quotes'), 'order' => array('UploadPayment.payment_date' => 'ASC')));
    $this->set(compact('work_order', 'user_id', 'modal', 'workOrder_status', 'quote', 'uploads', 'upload_payment'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $section = null) {
    $this->WorkOrder->id = $id;
    if (!$this->WorkOrder->exists()) {
      throw new NotFoundException(__('Invalid quote'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['WorkOrder']['id'] = $id; 
			
      if (trim($this->request->data['WorkOrderStatus']['status']) == "Approve") {
        $this->request->data['WorkOrder']['status'] = "Approve";
								
				$wo_data = $this->WorkOrder->find('first', array('conditions' => array('WorkOrder.id' => $id)));
				$s_date = date("Y-m-d H:i:s", strtotime($wo_data['Quote']['est_shipping']));
				$add_e_date = strtotime($wo_data['Quote']['est_shipping']);
//				$add_e_date = strtotime($wo_data['Quote']['est_shipping']) + ( 60 * 60 );
				$e_date = date("Y-m-d H:i:s", $add_e_date);
				
				$schedule['Appointment']['work_order_id'] = $wo_data['WorkOrder']['id'];
				$schedule['Appointment']['address'] = $wo_data['Quote']['address'];
				$schedule['Appointment']['city'] = $wo_data['Quote']['city'];
				$schedule['Appointment']['province'] = $wo_data['Quote']['province'];
				$schedule['Appointment']['postal_code'] = $wo_data['Quote']['postal_code'];
				$schedule['Appointment']['country'] = $wo_data['Quote']['country'];
				$schedule['Appointment']['type'] = "Appointment";
				$schedule['Appointment']['created_by'] = $this->loginUser['id'];
				$schedule['Appointment']['start_date'] = $s_date;
				$schedule['Appointment']['end_date'] = $e_date;
      }
			if (trim($this->request->data['WorkOrderStatus']['status']) == "Review") {
        $this->request->data['WorkOrder']['status'] = "Review";
      }
			if (trim($this->request->data['WorkOrderStatus']['status']) == "New") {
        $this->request->data['WorkOrder']['status'] = "New";
      }
			if (trim($this->request->data['WorkOrderStatus']['status']) == "Cancel") {
        $this->request->data['WorkOrder']['status'] = "Cancel";
      }
			if (trim($this->request->data['WorkOrderStatus']['status']) == "Change") {
        $this->request->data['WorkOrder']['status'] = "Change";
      }
			
//			pr($this->request->data);exit;
      if ($this->WorkOrder->save($this->request->data)) {
				App::import('Model', 'ScheduleManager.Appointment');
				$Appointment_Model = new Appointment();
				$Appointment_Model->save($schedule);
				
        $this->Session->setFlash(__('The Work Order status has been saved'), 'default', array('class' => 'text-success'));

        $this->redirect(array('action' => 'detail_section', $this->WorkOrder->id, $section));
      } else {
        $this->Session->setFlash(__('The Work Order status could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
        $this->redirect(array('action' => 'detail_section', $this->WorkOrder->id, $section));
      }
    }
  }
	
	function edit_workorder($id = null){
		$this->WorkOrder->id = $id;
    if (!$this->WorkOrder->exists()) {
      throw new NotFoundException(__('Invalid quote'));
    }
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->WorkOrder->save($this->request->data['WorkOrder']);
			$this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/detail/{$id}");
		}
		$wo_data = $this->WorkOrder->find('first', array('conditions' => array('WorkOrder.id' => $id)));
		$this->set(compact('wo_data'));
	}

  public function detail_section($id = null, $section = null) {
    $this->layoutOpt['left_nav_selected'] = "view_work_order";
    $this->WorkOrder->recursive = 3;

    $this->WorkOrder->id = $id;
    if (!$this->WorkOrder->exists()) {
      throw new NotFoundException(__('Invalid work order'));
    }
    $work_order = $this->WorkOrder->read(null, $id);

    App::import('Model', 'WorkOrderManager.WorkOrderStatus');
    $workOrderStatusModel = new WorkOrderStatus();
    $workOrder_status = $workOrderStatusModel->find('all', array('conditions' => array('WorkOrderStatus.work_order_id' => $id)));

    $user_id = $this->loginUser['id'];
    $this->set(compact('work_order', 'section', 'user_id', 'modal', 'workOrder_status'));
  }

  private function create_po($data, $work_id) {
    $quote_id = $data['WorkOrder']['quote_id'];
    App::uses('Quote', 'QuoteManager.Model');
    App::uses('PurchaseOrder', 'PurchaseOrderManager.Model');
    $quote = new Quote();
    $purchaseOrder = new PurchaseOrder();
    $quote->recursive = 0;
    $quoteInfo = $quote->find('all', array('conditions' => array('Quote.id' => $quote_id)));

    //set po id
    $po_id = $purchaseOrder->find('list', array('fields' => array('id')));
    $tmp_po_id = 0;
    if (count($po_id) > 0)
      $tmp_po_id = array_pop($po_id) + 1;
    else
      $tmp_po_id = 1;

    $all_items = $this->QuoteItem->ListQuoteItems($quote_id);
//    debug($all_items);
//    exit;
    $all_items = $this->QuoteItem->AdjustPOItem($all_items);
    $quantity_list = $all_items['quantity_list'];
    $price_list = $all_items['price_list'];
    $title_list = $all_items['title_list'];
    $name_list = $all_items['name_list'];
    $supplier_list = $this->QuoteItem->SupplierAndItemInfo();

    $total_cost = 0.00;
    $index1 = 0;
    $item_have = false;
    foreach ($supplier_list as $key => $supplier) {
      $po_data['PurchaseOrder'] = array();
      $po_data['PurchaseOrderItem'] = array();
      //debug($supplier);
      $index2 = 0;
      $item_total_cost = 0.00;
      foreach ($supplier['item'] as $item_key => $item) {
        if ($quantity_list && is_array($quantity_list)) {
          if (array_key_exists($item, $quantity_list)) {
            //debug($quantity_list[$item]);
            $po_data['PurchaseOrderItem'][$index2]['quantity'] = $quantity_list[$item];
            $po_data['PurchaseOrderItem'][$index2]['code'] = $item;
            $item_total_cost += $price_list[$item] * $quantity_list[$item];
            //debug($item);
            //debug($quantity_list[$item]);
            //debug($price_list[$item]);
            //debug($item_total_cost);
            $item_arr = explode('|', $item);
            $item_id = ($item_arr[1] == 'item') ? $item_arr[0] : 0;
            $cabite_id = ($item_arr[1] == 'cabinet') ? $item_arr[0] : 0;
            $door_id = ($item_arr[1] == 'door' || $item_arr[1] == 'drawer' || $item_arr[1] == 'wall_door') ? $item_arr[0] : 0;
            $po_data['PurchaseOrderItem'][$index2]['item_id'] = $item_id;
            $po_data['PurchaseOrderItem'][$index2]['cabinet_id'] = $cabite_id;
            $po_data['PurchaseOrderItem'][$index2]['door_id'] = $door_id;

            $index2++;
            //set item in supplier
            $item_have = true;
          }
        }
      }
      if ($item_have) {
        $value = $this->QuoteItem->auto_generate_number('Purchase Order');

        $po_data['PurchaseOrder']['id'] = $tmp_po_id;
        $po_data['PurchaseOrder']['supplier_id'] = $key;
        $po_data['PurchaseOrder']['purchase_order_num'] = $value;
        $po_data['PurchaseOrder']['quote_id'] = $quote_id;
        $po_data['PurchaseOrder']['work_order_id'] = $work_id;
        $po_data['PurchaseOrder']['tax_gst'] = $supplier['gst'];
        $po_data['PurchaseOrder']['order_subtotal'] = $item_total_cost;
        $gst_val = $item_total_cost * $supplier['gst'] / 100;
        $pst_val = $item_total_cost * $supplier['pst'] / 100;
        $po_data['PurchaseOrder']['total_amount'] = $item_total_cost + $pst_val + $gst_val;
        $po_data['PurchaseOrder']['tax_pst'] = $supplier['pst'];
        $item_have = false;
        //debug($po_data);
        $purchaseOrder->save($po_data);
//        $email = new CakeEmail();
//        $email->config('gmail');
//        $email->from(array('sanaul.ilbd@gmail.com' => 'Zenliving'));
//        $email->to('rokon01bd@gmail.com');
//        $email->subject('Zenliving');
//        $email->send('My message');
        $to = $supplier['email'];
        $subject = "Test mail";
        $message = "Hello! This is a test message.";
        $from = "development@instaonline.com";
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
        //echo "Mail Sent.";
        $tmp_po_id++;
      }
    }
  }

  public function wo_genarate_auto() {
    App::uses('Quote', 'QuoteManager.Model');
    $quote = new Quote();
    $quote_info = $quote->find("all", array("conditions" => array("Quote.status" => 'Approve')));
    $today_date = date('Y-m-d');

    foreach ($quote_info as $quote) {
      if (empty($quote['WorkOrder']) || !isset($quote['WorkOrder']['id'])) {
        $status_date = $quote['QuoteStatus'][count($quote['QuoteStatus']) - 1]['status_date'];
        if ($status_date < 1)
          $status_date = $quote['QuoteStatus'][count($quote['QuoteStatus']) - 1]['created'];

        $after_five_days = date('Y-m-d', strtotime("+5 days", strtotime($status_date)));
        $wo_arr = array();
        $flag = false;
        if ($after_five_days < $today_date) {
//          debug($today_date);
//          debug($after_five_days);
//          debug($status_date);
//          debug($quote);
          $this->WorkOrder->create();
          $wo_arr['WorkOrder']['quote_id'] = $quote['Quote']['id'];
          $wo_arr['WorkOrder']['work_order_number'] = '';
          $flag = $this->WorkOrder->save($wo_arr);
          if ($flag) {
            $this->create_po($wo_arr, $flag['WorkOrder']['id']);
            $wo_arr['WorkOrder']['id'] = $flag['WorkOrder']['id'] + 1;
          }
        }
      }
    }
  }

  public function report($limit = REPORT_LIMIT) {
    $this->layoutOpt['left_nav'] = "";
    $this->layoutOpt['left_nav_selected'] = "";

    $this->WorkOrder->recursive = 2;
    if ($limit != 'All') {
      $this->paginate['limit'] = $limit;
      $this->Prg->commonProcess();
      $this->paginate['conditions'] = $this->WorkOrder->parseCriteria($this->passedArgs);
      $workorders = $this->paginate();
    } else {
      $workorders = $this->WorkOrder->find('all');
    }

    $paginate = false;
    $legend = "Work Orders Report";

    $this->set(compact('workorders', 'limit', 'paginate', 'legend'));
  }

  function listing_report_print($limit = REPORT_LIMIT) {
    $this->layoutOpt['layout'] = 'report';

    $this->WorkOrder->recursive = 2;

    if (!isset($this->params['named']['limit'])) {
      $this->paginate['limit'] = REPORT_LIMIT;
      $this->paginate['maxLimit'] = REPORT_LIMIT;
    } elseif (isset($this->params['named']['limit']) && $this->params['named']['limit'] != 'All') {
      $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
      $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
    } else {
      $this->paginate['limit'] = 0;
      $this->paginate['maxLimit'] = 0;
    }

    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->WorkOrder->parseCriteria($this->passedArgs);
    $workorders = $this->paginate();
    $paginate = false;
    $legend = "Work Orders";

    $this->set(compact('workorders', 'paginate', 'legend'));
  }
	
	//Payment Info Upload Section
	function upload_single_file_payment($id) {
		if(!empty($this->request->data['UploadPayment']['file'])){
			$this->uploadFilePayment();
		}
		App::import("Model", "UploadPayment");
		$upload = new UploadPayment();
		if (!$upload->save($this->data)) {
			$this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
		}
//		else {
//      $this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
//    }
    $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/detail/{$id}#payment-info");
  }
	function uploadFilePayment() {
    $file = $this->request->data['UploadPayment']['file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
      $id = String::uuid();
      mkdir(APP . 'uploads' . DS . $this->data['UploadPayment']['ref_model'] . DS . $this->data['UploadPayment']['ref_id'], 0777, TRUE);
      $dest_file = APP . 'uploads' . DS . $this->data['UploadPayment']['ref_model'] . DS . $this->data['UploadPayment']['ref_id'] . DS . $id;
      if (move_uploaded_file($file['tmp_name'], $dest_file)) {
        $this->request->data['UploadPayment']['id'] = $id;
        $this->request->data['UploadPayment']['filename'] = $file['name'];
        $this->request->data['UploadPayment']['filesize'] = $file['size'];
        $this->request->data['UploadPayment']['filemime'] = $file['type'];
        return true;
      }
    }
    return false;
  }
	function uploadFile() {
    $file = $this->request->data['Upload']['file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
      $id = String::uuid();
      mkdir(APP . 'uploads' . DS . $this->data['Upload']['ref_model'] . DS . $this->data['Upload']['ref_id'], 0777, TRUE);
      $dest_file = APP . 'uploads' . DS . $this->data['Upload']['ref_model'] . DS . $this->data['Upload']['ref_id'] . DS . $id;
      if (move_uploaded_file($file['tmp_name'], $dest_file)) {
        $this->request->data['Upload']['id'] = $id;
        $this->request->data['Upload']['filename'] = $file['name'];
        $this->request->data['Upload']['filesize'] = $file['size'];
        $this->request->data['Upload']['filemime'] = $file['type'];
        return true;
      }
    }
    return false;
  }
	function download_single_file_payment($id) {
    App::import("Model", "UploadPayment");
    $upload_model = new UploadPayment();
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for upload', true));
      $this->redirect(array('action' => 'index'));
    }
    $upload = $upload_model->find('first', array(
        'conditions' => array(
            'UploadPayment.id' => $id,
        )
            ));
    if (!$upload) {
      $this->Session->setFlash(__('Invalid id for upload', true));
      $this->redirect(array('action' => 'index'));
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
	function delete_single_file_payment($work_order_id, $id) {
    App::import("Model", "UploadPayment");
    @$upload_model = new UploadPayment();

    if (!$id) {
      $this->Session->setFlash(__('Invalid id for delete', true));
      $this->redirect(array('action' => 'index'));
    }
    @$upload_model->delete($id);

    $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/detail/{$work_order_id}#payment-info");
  }
	function upload_single_file($id) {
    if ($this->uploadFile()) {
      App::import("Model", "Upload");
      $upload = new Upload();
      if (!$upload->save($this->data)) {
        $this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    } else {
      $this->Session->setFlash(__('The file could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
    }
    $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/detail/{$id}#quote-documents");
  }
	function download_single_file($id) {
    App::import("Model", "Upload");
    $upload_model = new Upload();

    if (!$id) {
      $this->Session->setFlash(__('Invalid id for upload', true));
      $this->redirect(array('action' => 'index'));
    }
    $upload = $upload_model->find('first', array(
        'conditions' => array(
            'Upload.id' => $id,
        )
            ));
    if (!$upload) {
      $this->Session->setFlash(__('Invalid id for upload', true));
      $this->redirect(array('action' => 'index'));
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
	function delete_single_file($quote_id, $id) {
    App::import("Model", "Upload");
    @$upload_model = new Upload();

    if (!$id) {
      $this->Session->setFlash(__('Invalid id for delete', true));
      $this->redirect(array('action' => 'index'));
    }
    @$upload_model->delete($id);

    $this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}work_order_manager/work_orders/detail/{$quote_id}#quote-documents");
  }
}
