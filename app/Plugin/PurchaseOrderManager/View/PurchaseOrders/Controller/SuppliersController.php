<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Suppliers Controller
 *
 * @property Supplier $Supplier
 */
class SuppliersController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "supplier-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_supplier";
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Supplier->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Supplier->parseCriteria($this->passedArgs);
        $this->set('suppliers', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->Supplier->id = $id;
        if (!$this->Supplier->exists()) {
            throw new NotFoundException(__('Invalid supplier'));
        }
        $this->set('supplier', $this->Supplier->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_supplier";

        if ($this->request->is('post')) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $this->Session->setFlash(__('The supplier has been saved'), 'default', array('class' => 'text-success'));
                $this->redirect(array('action' => DETAIL, $this->Supplier->id));
            } else {
                $this->Session->setFlash(__('The supplier could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
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
        $this->Supplier->id = $id;
        if (!$this->Supplier->exists()) {
            throw new NotFoundException(__('Invalid supplier'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);exit;
            if ($this->Supplier->save($this->request->data)) {
                $this->Session->setFlash(__("The supplier's data has been updated"), 'default', array('class' => 'text-success'));
                $this->redirect(array('action' => DETAIL, $this->Supplier->id));
            } else {
                $this->Session->setFlash(__("The supplier's data could not be updated. Please, try again."), 'default', array('class' => 'text-error'));
            }
        } else {
            $this->request->data = $this->Supplier->read(null, $id);
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
        $this->Supplier->id = $id;
        if (!$this->Supplier->exists()) {
            throw new NotFoundException(__('Invalid supplier'));
        }
        if ($this->Supplier->delete()) {
            $this->Session->setFlash(__('Supplier has been deleted successfully'), 'default', array('class' => 'text-success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Supplier has not been deleted successfully. Please try again'), 'default', array('class' => 'text-error'));
        $this->redirect(array('action' => 'index'));
    }

}
