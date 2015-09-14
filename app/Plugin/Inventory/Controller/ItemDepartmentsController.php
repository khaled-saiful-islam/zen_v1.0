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
		
		$this->layoutOpt['layout'] = 'item_template';
		$this->side_bar = "item";
		$this->set("side_bar",$this->side_bar);
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->layoutOpt['left_nav_selected'] = "view_item_department";

    $this->ItemDepartment->recursive = 0;

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
    $this->paginate['conditions'] = $this->ItemDepartment->parseCriteria($this->passedArgs);

    if ((isset($this->data['ItemDepartment']['active'])) && ($this->data['ItemDepartment']['active'] === '0')) {
      $this->paginate['conditions'] += array('active' => $this->data['ItemDepartment']['active']);
    }
    if ((isset($this->data['ItemDepartment']['supplier_required'])) && ($this->data['ItemDepartment']['supplier_required'] === '0')) {
      $this->paginate['conditions'] += array('supplier_required' => $this->data['ItemDepartment']['supplier_required']);
    }
    if ((isset($this->data['ItemDepartment']['stock_number_required'])) && ($this->data['ItemDepartment']['stock_number_required'] === '0')) {
      $this->paginate['conditions'] += array('stock_number_required' => $this->data['ItemDepartment']['stock_number_required']);
    }

    $itemDepartments = $this->paginate();
    $paginate = true;
    $legend = "Item Departments";

    $this->set(compact('itemDepartments', 'paginate', 'legend'));
  }

  /**
   * detail method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null, $modal = null) {
    $this->layoutOpt['left_nav_selected'] = "view_item_department";

    $this->ItemDepartment->id = $id;
    if (!$this->ItemDepartment->exists()) {
      throw new NotFoundException(__('Invalid item department'));
    }
    $this->set('itemDepartment', $this->ItemDepartment->read(null, $id));
    $this->set('modal', $modal);
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
    $item_department['id'] = $id;
    $item_department['delete'] = 1;
    $data = $this->ItemDepartment->save($item_department);

    if ($data) {
      $this->Session->setFlash(__('Item department has been deleted.'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Item department has not been deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

  public function listing_report_print($limit = REPORT_LIMIT) {
    $this->layoutOpt['layout'] = 'report';

    $this->ItemDepartment->recursive = 0;

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
    $this->paginate['conditions'] = $this->ItemDepartment->parseCriteria($this->passedArgs);

    if ((isset($this->data['ItemDepartment']['active'])) && ($this->data['ItemDepartment']['active'] === '0')) {
      $this->paginate['conditions'] += array('active' => $this->data['ItemDepartment']['active']);
    }
    if ((isset($this->data['ItemDepartment']['supplier_required'])) && ($this->data['ItemDepartment']['supplier_required'] === '0')) {
      $this->paginate['conditions'] += array('supplier_required' => $this->data['ItemDepartment']['supplier_required']);
    }
    if ((isset($this->data['ItemDepartment']['stock_number_required'])) && ($this->data['ItemDepartment']['stock_number_required'] === '0')) {
      $this->paginate['conditions'] += array('stock_number_required' => $this->data['ItemDepartment']['stock_number_required']);
    }

    $itemDepartments = $this->paginate();
    $paginate = false;
    $legend = "Item Departments";
    $reportTitle = "General Listing Report";
    $reportDate = date('l, F d, Y');

    $this->set(compact('itemDepartments', 'paginate', 'legend', 'reportTitle', 'reportDate'));
  }

}
