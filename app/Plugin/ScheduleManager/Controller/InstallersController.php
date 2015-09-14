<?php

App::uses('ScheduleManagerAppController', 'ScheduleManager.Controller');

/**
 * Installers Controller
 *
 * @property Installers $Installers
 */
class InstallersController extends ScheduleManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "schedule-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_installers";
		
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
    $this->Installer->recursive = 0;
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->Installer->parseCriteria($this->passedArgs);
    $installers = $this->paginate();

    $this->set(compact('installers'));
  }

  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_installers";

    if ($this->request->is('post')) {
      $this->Installer->create();
      //debug($this->request->data);exit;
      if ($this->Installer->save($this->request->data)) {
        $this->Session->setFlash(__('Installer has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->Installer->id));
      } else {
        $this->Session->setFlash(__('Installer could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }

    $user_id = $this->loginUser['id'];
    $this->set(compact('user_id'));
  }

  public function detail($id = null) {
    $this->Installer->id = $id;
    if (!$this->Installer->exists()) {
      throw new NotFoundException(__('Invalid Installer'));
    }

    $user_id = $this->loginUser['id'];
    $this->Installer->recursive = 1;
    $installer = $this->Installer->read(null, $id);
    $this->set(compact('user_id', 'installer'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $section = null) {
    $this->Installer->id = $id;
    if (!$this->Installer->exists()) {
      throw new NotFoundException(__('Invalid Installer'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Installer->save($this->request->data)) {
        $this->Session->setFlash(__('The Installer has been saved'));
        $this->redirect(array('action' => 'detail_section', $this->Installer->id, $section));
      } else {
        $this->Session->setFlash(__('The Installer could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->Installer->read(null, $id);
    }
    $user_id = $this->loginUser['id'];

    $this->set(compact('user_id', 'id', 'section'));
  }

  /**
   * detail_section method
   *
   * @param string $id
   * @return void
   */
  public function detail_section($id = null, $section = null) {
    $this->Installer->id = $id;
    if (!$this->Installer->exists()) {
      throw new NotFoundException(__('Invalid Installer'));
    }

    $user_id = $this->loginUser['id'];
    $this->Installer->recursive = 1;
    $installer = $this->Installer->read(null, $id);
    $this->set(compact('user_id', 'installer', 'section'));
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
    $this->Installer->id = $id;
    if (!$this->Installer->exists()) {
      throw new NotFoundException(__('Invalid Installer'), 'default', array('class' => 'text-error'));
    }
    if ($this->Installer->delete()) {
      $this->Session->setFlash(__('Installer deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Installer was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

  public function add_holidays() {
    $this->autoRender = false;
    //debug($this->request->data);
    App::uses('Holiday', 'ScheduleManager.Model');
    $holidayModel = new Holiday();
    if ($this->request->is('post') || $this->request->is('put')) {
      $holidayModel->create();
      $data = $holidayModel->save($this->request->data);
      if ($data) {
        echo json_encode(array("Error" => "", $data));
      } else {
        echo json_encode(array("Error" => 'Error'));
      }
    }
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete_holidays($id = null) {
    $this->autoRender = false;
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    App::uses('Holiday', 'ScheduleManager.Model');
    $holidayModel = new Holiday();

    $holidayModel->id = $id;
    if (!$holidayModel->exists()) {
      throw new NotFoundException(__('Invalid Installer Holiday'), 'default', array('class' => 'text-error'));
    }
    if ($holidayModel->delete()) {
      echo json_encode(array("Error" => ""));
    } else {
      echo json_encode(array("Error" => 'Error'));
    }
  }

}
