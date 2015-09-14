<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Doors Controller
 *
 * @property Door $Door
 */
class DoorsController extends InventoryAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "door-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_door";
		
		if($this->isAjax){
			$this->layoutOpt['layout'] = 'ajax';
		}else{
			$this->layoutOpt['layout'] = 'item_template';
		}
		
		$this->side_bar = "item";
		$this->set("side_bar",$this->side_bar);
	}

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->layoutOpt['left_nav_selected'] = "view_door";

    $this->Door->recursive = 0;
    
    if(!isset($this->params['named']['limit'])){
      $this->paginate['limit'] = REPORT_LIMIT;
      $this->paginate['maxLimit'] = REPORT_LIMIT;     
    }elseif (isset($this->params['named']['limit']) && $this->params['named']['limit']!='All') {
      $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
      $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
    }else{
      $this->paginate['limit'] = 0;
      $this->paginate['maxLimit'] = 0;
    }
    
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->Door->parseCriteria($this->passedArgs);
    $doors = $this->paginate();
    $paginate = true;
    $legend = "Doors";
    
    $this->set(compact('doors','paginate','legend'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_door";

    $this->Door->id = $id;
    if (!$this->Door->exists()) {
      throw new NotFoundException(__('Invalid door'));
    }
    $this->set('door', $this->Door->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_door";

    if ($this->request->is('post')) {
      $this->Door->create();
      if ($this->Door->save($this->request->data)) {
        $this->Session->setFlash(__('The door has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->Door->id));
      } else {
        $this->Session->setFlash(__('The door could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }
    $suppliers = $this->Door->Supplier->find('list');
    $this->set(compact('suppliers'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($door_id = null, $section = null) {
    $this->Door->id = $door_id;
    if (!$this->Door->exists()) {
      throw new NotFoundException(__('Invalid door'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Door->save($this->request->data)) {
        $this->Session->setFlash(__('The door has been saved'), 'default', array('class' => 'text-success'));
        if ($section != "images")
          $this->redirect(array('action' => 'detail_section', $door_id, $section));
        else {
          $this->redirect(array('action' => DETAIL, $door_id));
        }
      } else {
        $this->Session->setFlash(__('The door could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    } else {
      if ($section == "factory") {
//        $view = new View($this);
//        $lookup = $view->loadHelper('InventoryLookupHelper');
//        debug($lookup->Customer());
        $factory = $this->Door->find('list', array('fields' => 'factory_mode'));
        $saw_metarial = $this->Door->find('list',array('fields'=>'saw_metarial'));        
      }
      $this->request->data = $this->Door->read(null, $door_id);
    }
    //debug($factory);exit;
    $suppliers = $this->Door->Supplier->find('list');
    $this->set(compact('suppliers', 'section', 'door_id', 'factory', 'saw_metarial'));
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
    $this->Door->id = $id;
    if (!$this->Door->exists()) {
      throw new NotFoundException(__('Invalid door'));
    }
    if ($this->Door->delete()) {
      $this->Session->setFlash(__('Door deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Door was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail_section($door_id = null, $section = null) {
    $this->layoutOpt['left_nav_selected'] = "view_door";

    $this->Door->id = $door_id;
    if (!$this->Door->exists()) {
      throw new NotFoundException(__('Invalid door'));
    }
    $door = $this->Door->read(null, $door_id);
    $this->set(compact('door', 'door_id', 'section'));
  }
  public function report($limit = REPORT_LIMIT) {
    $this->layoutOpt['left_nav'] = "";
    $this->layoutOpt['left_nav_selected'] = "";

    $this->Door->recursive = 0;
    if ($limit != 'All') {
      $this->paginate['limit'] = $limit;
      $this->Prg->commonProcess();
      $this->paginate['conditions'] = $this->Door->parseCriteria($this->passedArgs);
      $doors = $this->paginate();
    } else {
      $doors = $this->Door->find('all');
    }

    $paginate = false;
    $legend = "Doors Report";

    $this->set(compact('doors', 'limit', 'paginate', 'legend'));
  }
  public function listing_report_print($limit = REPORT_LIMIT) {
    $this->layoutOpt['layout'] = 'report';

    $this->Door->recursive = 0;
    
    if(!isset($this->params['named']['limit'])){
      $this->paginate['limit'] = REPORT_LIMIT;
      $this->paginate['maxLimit'] = REPORT_LIMIT;     
    }elseif (isset($this->params['named']['limit']) && $this->params['named']['limit']!='All') {
      $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
      $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
    }else{
      $this->paginate['limit'] = 0;
      $this->paginate['maxLimit'] = 0;
    }
    
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->Door->parseCriteria($this->passedArgs);
    $doors = $this->paginate();
    $paginate = false;
    $legend = "Doors";
    $reportTitle = "General Listing Report";
    $reportDate = date('l, F d, Y');
    
    $this->set(compact('doors','paginate','legend','reportTitle','reportDate'));
  }
  
  /**
   * print/pdf view method
   *
   * @param string $id
   * @return void
   */
  public function print_detail($id = null) {
    $this->layoutOpt['layout'] = 'report';

    $this->Door->id = $id;
    if (!$this->Door->exists()) {
      throw new NotFoundException(__('Invalid door'));
    }
    $reportTitle = "Detail Report";
    $reportDate = date('l, F d, Y');
    $door = $this->Door->read(null, $id);
    
    $this->set(compact('door','reportTitle','reportDate'));
  }
}
