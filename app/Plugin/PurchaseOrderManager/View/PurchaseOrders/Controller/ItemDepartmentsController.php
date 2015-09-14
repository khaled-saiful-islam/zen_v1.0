<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * ItemDepartments Controller
 *
 * @property ItemDepartment $ItemDepartment
 */
class ItemDepartmentsController extends InventoryAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "item_department-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_item_department";
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->layoutOpt['left_nav_selected'] = "view_item_department";

    $this->ItemDepartment->recursive = 0;
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->ItemDepartment->parseCriteria($this->passedArgs);
    $this->set('itemDepartments', $this->paginate());
  }

  /**
   * detail method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_item_department";

    $this->ItemDepartment->id = $id;
    if (!$this->ItemDepartment->exists()) {
      throw new NotFoundException(__('Invalid item department'));
    }
    $this->set('itemDepartment', $this->ItemDepartment->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_item_department";

    if ($this->request->is('post')) {
      $this->ItemDepartment->create();
      if ($this->ItemDepartment->save($this->request->data)) {
        $this->Session->setFlash(__('The item department has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->ItemDepartment->id));
      } else {
        $this->Session->setFlash(__('The item department could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->ItemDepartment->id = $id;
    if (!$this->ItemDepartment->exists()) {
      throw new NotFoundException(__('Invalid item department'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->ItemDepartment->save($this->request->data)) {
        $this->Session->setFlash(__('The item department has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->ItemDepartment->id));
      } else {
        $this->Session->setFlash(__('The item department could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    } else {
      $this->request->data = $this->ItemDepartment->read(null, $id);
    }
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
    $this->ItemDepartment->id = $id;
    if (!$this->ItemDepartment->exists()) {
      throw new NotFoundException(__('Invalid item department'));
    }
    if ($this->ItemDepartment->delete()) {
      $this->Session->setFlash(__('Item department has been deleted.'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Item department has not been deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

}
