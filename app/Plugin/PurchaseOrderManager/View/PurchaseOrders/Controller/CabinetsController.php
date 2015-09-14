<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Cabinets Controller
 *
 * @property Cabinet $Cabinet
 */
class CabinetsController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "cabinet-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_cabinet";
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Cabinet->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Cabinet->parseCriteria($this->passedArgs);
        $this->set('cabinets', $this->paginate());
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {        
        $this->Cabinet->id = $id;
        if (!$this->Cabinet->exists()) {
            throw new NotFoundException(__('Invalid cabinet'));
        }
        $this->set('cabinet', $this->Cabinet->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_cabinet";
        $section = 'basic';

        if ($this->request->is('post')) {
            $this->Cabinet->create();
            if ($this->Cabinet->save($this->request->data)) {
                $this->Session->setFlash(__('The cabinet has been saved'), 'default', array('class' => 'text-success'));
                $this->redirect(array('action' => DETAIL, $this->Cabinet->id));
            } else {
                $this->Session->setFlash(__('The cabinet could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
            }
        }
        $items = $this->Cabinet->Item->find('list');
        $this->set(compact('items', 'section'));
    }

    /**
     * edit method
     *
     * @param string $cabinet_id
     * @return void
     */
    public function edit($cabinet_id = null, $section = null) {
        $this->Cabinet->id = $cabinet_id;
        if (!$this->Cabinet->exists()) {
            throw new NotFoundException(__('Invalid cabinet'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            //echo "test";
            //print_r($this->request->data);
            if ($this->Cabinet->save($this->request->data)) {
                //$this->Session->setFlash(__('The cabinet has been updated'), 'default', array('class' => 'text-success'));
                $this->redirect(array('action' => 'detail_section', $cabinet_id,$section));
            } else {
                //$this->Session->setFlash(__('The cabinet could not be updated. Please, try again.'), 'default', array('class' => 'text-error'));
            }
        } else {
            $this->request->data = $this->Cabinet->read(null, $cabinet_id);
        }
        $items = $this->Cabinet->Item->find('list');
        $this->set(compact('items', 'section', 'cabinet_id'));
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
        $this->Cabinet->id = $id;
        if (!$this->Cabinet->exists()) {
            throw new NotFoundException(__('Invalid cabinet'));
        }
        if ($this->Cabinet->delete()) {
            $this->Session->setFlash(__('Cabinet deleted'), 'default', array('class' => 'text-success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Cabinet was not deleted'), 'default', array('class' => 'text-error'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * detail door drawer method
     *
     * @param string $id
     * @return void
     */
    public function detail_section($cabinet_id = null,$section= null) {
        $this->Cabinet->id = $cabinet_id;
        if (!$this->Cabinet->exists()) {
            throw new NotFoundException(__('Invalid cabinet'));
        }        
        $cabinet = $this->Cabinet->read(null, $cabinet_id);
        $edit = true;
        $this->set(compact('cabinet','edit','section'));
    }
}
