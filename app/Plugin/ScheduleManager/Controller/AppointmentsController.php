<?php

App::uses('ScheduleManagerAppController', 'ScheduleManager.Controller');

/**
 * Appointments Controller
 *
 * @property Appointments $Appointments
 */
class AppointmentsController extends ScheduleManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "schedule-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_appointment";
		
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
    $this->Appointment->recursive = 0;
    $appointment = $this->Appointment->find('all');

    $user_id = $this->loginUser['id'];
    App::uses('WorkOrder', 'WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list', array('fields' => array('id', 'work_order_number'), 'conditions' => array('status' => 'Approve')));   
        
    $this->set(compact('workOrders', 'user_id', 'appointment'));
  }
  public function appointment_data(){
    $this->autoRender = false;
    
    $start_date = date('Y-m-d H:i:s', $this->request->query['start']);
    $end_date = date('Y-m-d H:i:s', $this->request->query['end']);
//    debug($start_date);
//    debug($end_date);
    
    $appointmentData = $this->Appointment->find('all',array('conditions' => array('Appointment.start_date >' =>$start_date,'Appointment.end_date <='=>$end_date)));
    $calendarData = array();
//    debug($appointmentData);
    $calendarData = $this->Calendar->dataFormat('Appointment',$appointmentData,$calendarData);
    
    echo json_encode($calendarData);
  }
  public function add() {
    $this->autoRender = false;
    if ($this->request->data) {
      $this->Appointment->create();
      $data = $this->Appointment->save($this->request->data);
      if ($data) {
        App::uses('WorkOrder', 'WorkOrderManager.Model');
        $workOrderModel = new WorkOrder();
        $workOrders = $workOrderModel->find('list', array('fields' => array('id', 'work_order_number'), 'conditions' => array('id' => $data['Appointment']['work_order_id'])));
        $tmp_data['id'] = $data['Appointment']['id'];
        $tmp_data['work_order_number'] = 'Work order: '.$workOrders[$data['Appointment']['work_order_id']];
        $tmp_data['start_date'] = $data['Appointment']['start_date'];
        $tmp_data['end_date'] = $data['Appointment']['end_date'];
				
				App::import('Model','ScheduleManager.ScheduleColor');
				$ScheduleColorModel = new ScheduleColor();
				$color_data = $ScheduleColorModel->find('first',array('conditions' => array('ScheduleColor.type' =>"Appointment")));
				
				$tmp_data['color'] = "#".$color_data['ScheduleColor']['bgcolor'];
        $description = "<table class='tooltip-table'>";
        $description .= "<tr><th><lable>Work order: </label></th><td>" . $workOrders[$data['Appointment']['work_order_id']] . "</td></tr>";
        $description .= "<tr><th><lable>Address: </label></th><td>" . $this->Calendar->address_format($data['Appointment']['address'],$data['Appointment']['city'],$data['Appointment']['province'],$data['Appointment']['country'],$data['Appointment']['postal_code']) . "</td></tr>";
        $description .= "</table>";

        $tmp_data['description'] = $description;
        
        echo json_encode(array("Error" => "", $tmp_data));
      } else {
        echo json_encode(array("Error" => 'Error'));
      }
    }
  }

  public function detail($id = null) {
    
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->autoRender = false;
    $this->Appointment->id = $id;
    if (!$this->Appointment->exists()) {
      throw new NotFoundException(__('Invalid ServiceEntry'));
    }
    
    if ($this->request->is('post') || $this->request->is('put')) {      
      $data = $this->Appointment->save($this->request->data);
//      debug($data);
      if ($data) {
        $appointments = $this->Appointment->find('first',array('conditions' => array('Appointment.id' =>$id)));
        App::uses('WorkOrder', 'WorkOrderManager.Model');
        $workOrderModel = new WorkOrder();
        $workOrders = $workOrderModel->find('list', array('fields' => array('id', 'work_order_number'), 'conditions' => array('id' => $appointments['Appointment']['work_order_id'])));
        $tmp_data['id'] = $appointments['Appointment']['id'];
        $tmp_data['work_order_number'] = 'Work order: '.$workOrders[$appointments['Appointment']['work_order_id']];
        $tmp_data['start_date'] = $appointments['Appointment']['start_date'];
        $tmp_data['end_date'] = $appointments['Appointment']['end_date'];
        $description = "<table class='tooltip-table'>";
        $description .= "<tr><th><lable>Work order: </label></th><td>" . $workOrders[$appointments['Appointment']['work_order_id']] . "</td></tr>";
//        $description .= "<tr><th><lable>Name: </label></th><td>" . $appointments['Appointment']['job_name'] . "</td></tr>";
        $description .= "<tr><th><lable>Address: </label></th><td>" . $this->Calendar->address_format($appointments['Appointment']['address'],$appointments['Appointment']['city'],$appointments['Appointment']['province'],$appointments['Appointment']['country'],$appointments['Appointment']['postal_code']) . "</td></tr>";
        $description .= "</table>";

        $tmp_data['description'] = $description;
        
        echo json_encode(array("Error" => "", $tmp_data));
      } else {
        echo json_encode(array("Error" => 'Error'));
      }
    }else{ 
      $data = $this->Appointment->read(null, $id); 
      $data['Appointment']['start_date'] = date('c', strtotime($data['Appointment']['start_date']));  
      $data['Appointment']['end_date'] = date('c', strtotime($data['Appointment']['end_date']));  
      //$data = $this->Appointment->read(null, $id); 
      echo json_encode($data);
    }
  }
  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null) {
    $this->autoRender = false;
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->Appointment->id = $id;
    if (!$this->Appointment->exists()) {
      throw new NotFoundException(__('Invalid Appointment'), 'default', array('class' => 'text-error'));
    }
    if ($this->Appointment->delete())  {
        echo json_encode(array("Error" => ""));
      } else {
        echo json_encode(array("Error" => 'Error'));
      }
  }
  
  public function calendar(){
    $this->layoutOpt['left_nav'] = "";
    $this->layoutOpt['left_nav_selected'] = "";
  }
  public function calendar_data(){
    $this->autoRender = false;
    
    $start_date = date('Y-m-d', $this->request->query['start']);
    $end_date = date('Y-m-d', $this->request->query['end']);
//    debug($start_date);
//    debug($end_date);

    App::import('Model','ScheduleManager.ServiceEntry');
    $serviceEntryModel = new ServiceEntry();
    $serviceEntryData = $serviceEntryModel->find('all',array('conditions' => array('ServiceEntry.booked_for >' => $start_date, 'ServiceEntry.booked_for <=' => $end_date)));
//    debug($serviceEntryData);
    
    App::import('Model','ScheduleManager.InstallerSchedule');
    $installerScheduleModel = new InstallerSchedule();
    $installerScheduleData = $installerScheduleModel->find('all',array('conditions' => array('InstallerSchedule.start_install >' => $start_date, 'InstallerSchedule.start_install <=' =>$end_date)));
//    debug($installerScheduleData);
    
    App::import('Model','ScheduleManager.Appointment');
    $appointmentModel = new Appointment();
    $start_date = date('Y-m-d H:i:s', $this->request->query['start']);
    $end_date = date('Y-m-d H:i:s', $this->request->query['end']);
    $appointmentData = $appointmentModel->find('all',array('conditions' => array('Appointment.start_date >' =>$start_date,'Appointment.end_date <='=>$end_date)));
//    debug($appointmentData);
    
    $calendarData = array();
    $calendarData = $this->Calendar->dataFormat('Service',$serviceEntryData,$calendarData);
    $calendarData = $this->Calendar->dataFormat('Installation',$installerScheduleData,$calendarData);
    $calendarData = $this->Calendar->dataFormat('Appointment',$appointmentData,$calendarData);
    
    echo json_encode($calendarData);
  }
  
  public function appointment_event_data(){
    $this->autoRender = false;
    $event_id = $this->request->data['event_id']; 
    
    $appointments = $this->Appointment->find('first',array('conditions' => array('Appointment.id' =>$event_id)));
    
    $tmp_appointments['id'] = $appointments['Appointment']['id'];
    $tmp_appointments['work_order_id'] = $appointments['Appointment']['work_order_id'];
    $tmp_appointments['job_name'] = $appointments['Appointment']['job_name'];
    $tmp_appointments['address'] = $appointments['Appointment']['address'];
    $tmp_appointments['city'] = $appointments['Appointment']['city'];
    $tmp_appointments['province'] = $appointments['Appointment']['province'];
    $tmp_appointments['postal_code'] = $appointments['Appointment']['postal_code'];
    $tmp_appointments['country'] = $appointments['Appointment']['country'];
    $tmp_appointments['service_tech_id'] = $appointments['Appointment']['service_tech_id'];
    $tmp_appointments['start_date'] = date('c', strtotime($appointments['Appointment']['start_date']));  
    $tmp_appointments['end_date'] = date('c', strtotime($appointments['Appointment']['end_date'])); 
    
    echo json_encode($tmp_appointments);
  }
	public function view_color(){
		$this->layoutOpt['left_nav_selected'] = "view_color_change";
		
		App::import('Model','ScheduleManager.ScheduleColor');
    $ScheduleColorModel = new ScheduleColor();
    $ScheduleColorData = $ScheduleColorModel->find('all');

		$this->set(compact('ScheduleColorData'));
	}
	public function edit_color($id = null, $type = null){
		$this->layoutOpt['left_nav_selected'] = "view_color_change";		
		
		if ($this->request->is('post') || $this->request->is('put')) {
			App::import('Model','ScheduleManager.ScheduleColor');
			$S_Model = new ScheduleColor();

			if ($S_Model->save($this->request->data)) {				
        $this->Session->setFlash(__('The Color has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => 'view_color'));
      } else {
        $this->Session->setFlash(__('The Color could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
		}
		App::import('Model','ScheduleManager.ScheduleColor');
    $ScheduleColorModel = new ScheduleColor();
    $data = $ScheduleColorModel->find('first',array('conditions' => array('ScheduleColor.type' =>$type)));
		$this->set(compact('data', 'id', 'type'));
	}
	function getWOAddress($id = null){
		$this->autoRender = false;
    App::import('Model', 'WorkOrderManager.WorkOrder');
    $workOrderModel = new WorkOrder();
    $workOrder = $workOrderModel->find("first", array("conditions" => array("WorkOrder.id" => $id)));
		echo json_encode($workOrder);
	}
}
