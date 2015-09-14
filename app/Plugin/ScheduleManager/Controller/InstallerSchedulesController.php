<?php

App::uses('ScheduleManagerAppController', 'ScheduleManager.Controller');

/**
 * InstallerSchedules Controller
 *
 * @property InstallerSchedules $Installers
 */
class InstallerSchedulesController extends ScheduleManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "schedule-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_installer_schedule";
		
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
    $this->InstallerSchedule->recursive = 0;
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->InstallerSchedule->parseCriteria($this->passedArgs);
    $installerSchedules = $this->paginate();

    App::uses('Installer', 'ScheduleManager.Model');
    $installerModel = new Installer();
    $installers = $installerModel->find('list', array('fields' => array('id', 'name_lookup_id')));   
    
    App::uses('WorkOrder', 'WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list', array('fields' => array('id', 'work_order_number'), 'conditions' => array('status' => 'Approve')));   
    
    $this->set(compact('installerSchedules','workOrders','installers'));
  }

  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_installer_schedule";

    if ($this->request->is('post')) {
      $this->InstallerSchedule->create();
      //debug($this->request->data);exit;
      if ($this->InstallerSchedule->save($this->request->data)) {
        $this->Session->setFlash(__('Installer Schedule has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->InstallerSchedule->id));
      } else {
        $this->Session->setFlash(__('Installer Schedule could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }

    $user_id = $this->loginUser['id'];
    App::uses('Installer', 'ScheduleManager.Model');
    $installerModel = new Installer();
    $installers = $installerModel->find('list', array('fields' => array('id', 'name_lookup_id')));   
    
    App::uses('WorkOrder', 'WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list', array('fields' => array('id', 'work_order_number'), 'conditions' => array('status' => 'Approve')));   
    
    $this->set(compact('user_id','workOrders','installers'));
  }

  public function detail($id = null) {
    $this->InstallerSchedule->id = $id;
    if (!$this->InstallerSchedule->exists()) {
      throw new NotFoundException(__('Invalid Installer'));
    }

    $user_id = $this->loginUser['id'];
    $this->InstallerSchedule->recursive = 1;
    $installerSchedule = $this->InstallerSchedule->read(null, $id);
    
    App::import('Model', 'ScheduleManager.ScheduleStatus');
    $scheduleStatusModel = new ScheduleStatus();
    $schedule_status = $scheduleStatusModel->find('all', array('conditions' => array('ScheduleStatus.schedule_id' => $id,'ScheduleStatus.type'=>'Installer Schedule')));
    
    
    $this->set(compact('user_id', 'installerSchedule','schedule_status'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $section = null) {
    $this->InstallerSchedule->id = $id;
    if (!$this->InstallerSchedule->exists()) {
      throw new NotFoundException(__('Invalid Installer'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->InstallerSchedule->save($this->request->data)) {
        $this->Session->setFlash(__('The Installer has been saved'));
        $this->redirect(array('action' => 'detail_section', $this->InstallerSchedule->id, $section));
      } else {
        $this->Session->setFlash(__('The Installer could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->InstallerSchedule->read(null, $id);
    }
    $user_id = $this->loginUser['id'];
    App::uses('Installer', 'ScheduleManager.Model');
    $installerModel = new Installer();
    $installers = $installerModel->find('list', array('fields' => array('id', 'name_lookup_id')));   
    
    App::uses('WorkOrder', 'WorkOrderManager.Model');
    $workOrderModel = new WorkOrder();
    $workOrders = $workOrderModel->find('list', array('fields' => array('id', 'work_order_number'), 'conditions' => array('status' => 'Approve')));   
    
    $this->set(compact('user_id','workOrders','installers','id', 'section'));
  }

  /**
   * detail_section method
   *
   * @param string $id
   * @return void
   */
  public function detail_section($id = null, $section = null) {    
    $this->InstallerSchedule->id = $id;
    if (!$this->InstallerSchedule->exists()) {
      throw new NotFoundException(__('Invalid Installer'));
    }

    $user_id = $this->loginUser['id'];
    $this->InstallerSchedule->recursive = 1;
    $installerSchedule = $this->InstallerSchedule->read(null, $id);
    
    App::import('Model', 'ScheduleManager.ScheduleStatus');
    $scheduleStatusModel = new ScheduleStatus();
    $schedule_status = $scheduleStatusModel->find('all', array('conditions' => array('ScheduleStatus.schedule_id' => $id,'ScheduleStatus.type'=>'Installer Schedule')));
        
    $this->set(compact('user_id', 'installerSchedule', 'section','schedule_status'));
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
    $this->InstallerSchedule->id = $id;
    if (!$this->InstallerSchedule->exists()) {
      throw new NotFoundException(__('Invalid Installer Schedule'), 'default', array('class' => 'text-error'));
    }
    if ($this->InstallerSchedule->delete()) {
      $this->Session->setFlash(__('Installer Schedule deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Installer Schedule was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }
  public function calendar_view($prev = null, $next=null) {
    
    App::uses('Installer', 'ScheduleManager.Model');
    $installerModel = new Installer();
    $installers = $installerModel->find('all'); 
    
    $this->set(compact('installers','prev','next'));
    //debug($installers);
  }
  
  function set_week_calendar_view($set_date=null,$prev=null,$next=null){
    App::uses('Installer', 'ScheduleManager.Model');
    $installerModel = new Installer();
    $installers = $installerModel->find('all'); 
    
    if(!empty($set_date))
      $set_date = $this->formatDate(str_replace('-', '/', $set_date));
    
    $this->set(compact('installers','set_date','prev','next'));
  }
}
