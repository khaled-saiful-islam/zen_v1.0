<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * InventoryLookups Controller
 *
 * @property InventoryLookup $InventoryLookup
 */
class InventoryLookupsController extends InventoryAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "inventory_lookup-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_inventory_lookup";
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->InventoryLookup->recursive = 0;
    $this->Prg->commonProcess();
    $this->paginate['conditions'] =$this->InventoryLookup->parseCriteria($this->passedArgs);
    $this->set('inventoryLookups', $this->paginate());
  }

  /**
   * detail method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->InventoryLookup->id = $id;
    if (!$this->InventoryLookup->exists()) {
      throw new NotFoundException(__('Invalid inventory lookup'));
    }
    $this->set('inventoryLookup', $this->InventoryLookup->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if ($this->request->is('post')) {
      $this->InventoryLookup->create();
      if ($this->InventoryLookup->save($this->request->data)) {
        $this->Session->setFlash(__('The inventory lookup has been saved'));
        $this->redirect(array('action' => DETAIL, $this->InventoryLookup->id));
      } else {
        $this->Session->setFlash(__('The inventory lookup could not be saved. Please, try again.'));
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
    $this->InventoryLookup->id = $id;
    if (!$this->InventoryLookup->exists()) {
      throw new NotFoundException(__('Invalid inventory lookup'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->InventoryLookup->save($this->request->data)) {
        $this->Session->setFlash(__('The inventory lookup has been saved'));
        $this->redirect(array('action' => DETAIL, $this->InventoryLookup->id));
      } else {
        $this->Session->setFlash(__('The inventory lookup could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->InventoryLookup->read(null, $id);
    }
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null) {
    return 0; // disable delete
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->InventoryLookup->id = $id;
    if (!$this->InventoryLookup->exists()) {
      throw new NotFoundException(__('Invalid inventory lookup'));
    }
    if ($this->InventoryLookup->delete()) {
      $this->Session->setFlash(__('Inventory lookup deleted'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Inventory lookup was not deleted'));
    $this->redirect(array('action' => 'index'));
  }

}
