<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Suppliers Controller
 *
 * @property Supplier $Supplier
 */
class SuppliersController extends InventoryAppController {

  public $helpers = array('CustomerManager.CustomerLookup');

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "supplier-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_supplier";
		
		if($this->isAjax){
			$this->layoutOpt['layout'] = 'ajax';
		}else{
			$this->layoutOpt['layout'] = 'left_bar_template';
		}
		
		$this->side_bar = "admin";
		$this->set("side_bar",$this->side_bar);
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->Supplier->recursive = 0;

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
    $this->paginate['conditions'] = $this->Supplier->parseCriteria($this->passedArgs);
    $suppliers = $this->paginate();
    $paginate = true;
    $legend = "Vendors";

    $this->set(compact('suppliers', 'paginate', 'legend'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null, $modal = null) {
    $this->Supplier->id = $id;
    if (!$this->Supplier->exists()) {
      throw new NotFoundException(__('Invalid vendor'));
    }
    $supplier = $this->Supplier->read(null, $id);
    $this->set(compact('supplier', 'modal'));
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
        $this->Session->setFlash(__('The vendor has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->Supplier->id));
      } else {
        $this->Session->setFlash(__('The vendor could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
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
      throw new NotFoundException(__('Invalid vendor'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      //debug($this->request->data);exit;
      if ($this->Supplier->save($this->request->data)) {
        $this->Session->setFlash(__("The vendor's data has been updated"), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->Supplier->id));
      } else {
        $this->Session->setFlash(__("The vendor's data could not be updated. Please, try again."), 'default', array('class' => 'text-error'));
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
      throw new NotFoundException(__('Invalid vendor'));
    }
    if ($this->Supplier->delete()) {
      $this->Session->setFlash(__('Vendor has been deleted successfully'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Vendor has not been deleted successfully. Please try again'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

  public function report($limit = REPORT_LIMIT) {
    $this->layoutOpt['left_nav'] = "";
    $this->layoutOpt['left_nav_selected'] = "";

    $this->Supplier->recursive = 0;
    if ($limit != 'All') {
      $this->paginate['limit'] = $limit;
      $this->Prg->commonProcess();
      $this->paginate['conditions'] = $this->Supplier->parseCriteria($this->passedArgs);
      $suppliers = $this->paginate();
    } else {
      $suppliers = $this->Supplier->find('all');
    }
    $paginate = false;
    $legend = "Vendors Report";

    $this->set(compact('suppliers', 'limit', 'paginate', 'legend'));
    //$this->render('index');
  }

  function listing_report_print($limit = REPORT_LIMIT) {
    $this->layoutOpt['layout'] = 'report';

    $this->Supplier->recursive = 0;

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
    $this->paginate['conditions'] = $this->Supplier->parseCriteria($this->passedArgs);
    $suppliers = $this->paginate();
    $paginate = false;
    $legend = "Vendors";
    $reportTitle = "General Listing Report";
    $reportDate = date('l, F d, Y');

    $this->set(compact('suppliers', 'paginate', 'legend', 'reportTitle', 'reportDate'));
  }

  public function print_detail($id = null) {
    $this->layoutOpt['layout'] = 'report';

    $this->Supplier->id = $id;
    if (!$this->Supplier->exists()) {
      throw new NotFoundException(__('Invalid vendor'));
    }
    $supplier = $this->Supplier->read(null, $id);
    $this->set(compact('supplier', 'modal', 'sales_representatives'));
  }


}
