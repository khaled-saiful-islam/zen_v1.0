<?php

App::uses('ScheduleManagerAppController', 'ScheduleManager.Controller');

/**
 * Schedule Controller
 *
 * @property ServiceEntries Controller $Schedule
 */
class ServiceEntriesController extends ScheduleManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "schedule-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_service_entry";
		
		if($this->isAjax){
			$this->layoutOpt['layout'] = 'ajax';
		}else{
			$this->layoutOpt['layout'] = 'left_bar_template';
		}
		
		$this->side_bar = "schedule";
		$this->set("side_bar",$this->side_bar);
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->ServiceEntry->recursive = 0;
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->ServiceEntry->parseCriteria($this->passedArgs);    
    $serviceEntries = $this->paginate();
    App::uses('WorkOrder','WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list',array('fields'=>array('id','work_order_number'),'conditions'=>array('status'=>'Approve')));

    $this->set(compact('serviceEntries','workOrders'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_service_entry";
    $this->ServiceEntry->id = $id;
    if (!$this->ServiceEntry->exists()) {
      throw new NotFoundException(__('Invalid ServiceEntry'));
    }
    
    $user_id = $this->loginUser['id'];
    $this->ServiceEntry->recursive = 3;
    $service = $this->ServiceEntry->read(null, $id);
    
    App::import('Model', 'ScheduleManager.ScheduleStatus');
    $scheduleStatusModel = new ScheduleStatus();
    $schedule_status = $scheduleStatusModel->find('all', array('conditions' => array('ScheduleStatus.schedule_id' => $id,'ScheduleStatus.type'=>'Service')));
        
    $this->set(compact('user_id', 'service','schedule_status'));
  }

  /**
   * view section method
   *
   * @param string $id
   * @return void
   */
  public function detail_section($id = null, $section = null) {
    $this->layoutOpt['left_nav_selected'] = "view_service_entry";
    $this->ServiceEntry->id = $id;
    if (!$this->ServiceEntry->exists()) {
      throw new NotFoundException(__('Invalid ServiceEntry'));
    }
    $this->ServiceEntry->recursive = 3;
    $user_id = $this->loginUser['id'];
    $service = $this->ServiceEntry->read(null, $id);
    
    App::import('Model', 'ScheduleManager.ScheduleStatus');
    $scheduleStatusModel = new ScheduleStatus();
    $schedule_status = $scheduleStatusModel->find('all', array('conditions' => array('ScheduleStatus.schedule_id' => $id,'ScheduleStatus.type'=>'Service')));
    
    $this->set(compact('user_id','section', 'service','schedule_status'));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_service";

    if ($this->request->is('post')) {
      $this->ServiceEntry->create();			
      if ($this->ServiceEntry->save($this->request->data)) {
        $this->Session->setFlash(__('The Service Entry has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->ServiceEntry->id));
      } else {
        $this->Session->setFlash(__('The Service Entry could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }
    App::uses('WorkOrder','WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list',array('fields'=>array('id','work_order_number'),'conditions'=>array('status'=>'Approve')));
    $user_id = $this->loginUser['id'];    
    $this->set(compact('workOrders','purchaseOrders','user_id'));    
  }
	function formatDate($date) {
		$this->autoRender = false;
    $exp = explode("/", $date);

    $year = $month = $day = 0;

    if (isset($exp[2]))
      $year = $exp[2];
    if (isset($exp[1]))
      $month = $exp[1];
    if (isset($exp[0]))
      $day = $exp[0];

    $date = strtotime($year . "-" . $month . "-" . $day);

    return date("Y-m-d", $date);
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $section = null) {
    $this->ServiceEntry->id = $id;
    if (!$this->ServiceEntry->exists()) {
      throw new NotFoundException(__('Invalid ServiceEntry'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
//			$s_date = date("Y-m-d H:i:s", strtotime($this->formatDate($this->request->data['ServiceEntry']['created'])));
//			$add_e_date = strtotime($this->formatDate($this->request->data['ServiceEntry']['booked_for'])) + ( 60 * 60 );
//			$e_date = date("Y-m-d H:i:s", $add_e_date);
			
//			$schedule['Appointment']['work_order_id'] = $this->request->data['ServiceEntry']['work_order_id'];			
//			$schedule['Appointment']['created_by'] = $this->request->data['ServiceEntry']['created_by'];
//			$schedule['Appointment']['type'] = $this->request->data['ServiceEntry']['type'];
//			$schedule['Appointment']['start_date'] = $s_date;
//			$schedule['Appointment']['end_date'] = $e_date;
			
//			App::import('Model', 'ScheduleManager.Appointment');
//			$Appointment_Model = new Appointment();
//			$app_data = $Appointment_Model->find("first", array("conditions" => array("Appointment.service_entry_id" => $id)));
//			$schedule['Appointment']['id'] = $app_data['Appointment']['id'];
			
      if ($this->ServiceEntry->save($this->request->data)) {
//				$Appointment_Model->save($schedule);
				
        $this->Session->setFlash(__('The Service Entry has been saved'));
        if ($section != 'basic') {
          $this->redirect(array('action' => 'detail_section', $this->ServiceEntry->id, $section));
        }
        else
          $this->redirect(array('action' => 'detail_section', $this->ServiceEntry->id,$section));
      } else {
        $this->Session->setFlash(__('The Service Entry could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->ServiceEntry->read(null, $id);
    }
    App::uses('WorkOrder','WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list',array('fields'=>array('id','work_order_number'),'conditions'=>array('status'=>'Approve')));
    $user_id = $this->loginUser['id'];
    
    $this->set(compact('workOrders','purchaseOrders','user_id','id', 'section'));
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->ServiceEntry->id = $id;
    if (!$this->ServiceEntry->exists()) {
      throw new NotFoundException(__('Invalid Service Entry'), 'default', array('class' => 'text-error'));
    }
    if ($this->ServiceEntry->delete()) {
      $this->Session->setFlash(__('Service Entry deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Service Entry was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }
  public function getPoItem($wo_id=null){
    $this->autoRender = false;
    App::uses('PurchaseOrderItem','PurchaseOrderManager.Model');
    $purchaseOrderModel = new PurchaseOrderItem();
    $purchaseOrders = $purchaseOrderModel->find('all',array('fields'=>array('PurchaseOrder.id,PurchaseOrder.purchase_order_num,PurchaseOrderItem.id','PurchaseOrderItem.code'),'conditions'=>array('PurchaseOrder.work_order_id'=>$wo_id)));
    //debug($purchaseOrders);
    
    $allItems = $this->QuoteItem->ListAllTypesOfItems();
    $list = array();
    $title_list = array();
    $price_list = array();
    $po_list = array();
    $po_id_list = array();
    foreach ($purchaseOrders as $value){
      if(array_key_exists($value['PurchaseOrderItem']['code'], $allItems['main_list'])){
        $list[$value['PurchaseOrderItem']['code']] = $allItems['main_list'][$value['PurchaseOrderItem']['code']];
        $title_list[$value['PurchaseOrderItem']['code']] = $allItems['title_list'][$value['PurchaseOrderItem']['code']];
        $price_list[$value['PurchaseOrderItem']['code']] = $allItems['price_list'][$value['PurchaseOrderItem']['code']];
        $po_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrder']['purchase_order_num'];
        $po_id_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrder']['id'];
      }
    }
    echo json_encode(array('main_list'=>$list,'title_list'=>$title_list,'price_list'=>$price_list,'po_list'=>$po_list,'po_id_list'=>$po_id_list));
    //echo json_encode($purchaseOrders);
  }
  /**
   * print/pdf view method
   *
   * @param string $id
   * @return void
   */
  public function print_detail($id = null) {
    $this->layoutOpt['layout'] = 'report';

    $this->ServiceEntry->id = $id;
    if (!$this->ServiceEntry->exists()) {
      throw new NotFoundException(__('Invalid ServiceEntry'));
    }
    
    $user_id = $this->loginUser['id'];
    $this->ServiceEntry->recursive = 3;
    $service = $this->ServiceEntry->read(null, $id);
    
    App::import('Model', 'ScheduleManager.ScheduleStatus');
    $scheduleStatusModel = new ScheduleStatus();
    $schedule_status = $scheduleStatusModel->find('all', array('conditions' => array('ScheduleStatus.schedule_id' => $id,'ScheduleStatus.type'=>'Service')));
    
    App::import('Model', 'QuoteManager.Quote');
    $quoteModel = new Quote();
    $quotes = $quoteModel->find('first',array('conditions' => array('Quote.id' => $service['WorkOrder']['quote_id'])));
        
    $reportTitle = "Service";
    $reportNumber = $service['WorkOrder']['work_order_number'];
    $reportDate = date('l, F d, Y');
    
    $this->set(compact('user_id', 'service','quotes','schedule_status','reportTitle','reportNumber','reportDate'));
  }
}
