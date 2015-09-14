<?php

App::uses('ContainerManagerAppController', 'ContainerManager.Controller');

/**
 * SkidInventory Controller
 *
 * @property WorkOrder $Container
 */
class SkidInventorysController extends ContainerManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "inventoryskid-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_skid";
		$this->paginate['conditions'] = array();
		
		if($this->isAjax){
			$this->layoutOpt['layout'] = 'ajax';
		}else{
			$this->layoutOpt['layout'] = 'left_bar_template';
		}
		
		$this->side_bar = "workorder";
		$this->set("side_bar",$this->side_bar);
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {	

    $this->Prg->commonProcess();
    $this->paginate['conditions'] += $this->SkidInventory->parseCriteria($this->passedArgs);
		$this->paginate['conditions'] += array('SkidInventory.delete !=' => 1);
    $skidinventorys = $this->paginate();
    $paginate = true;
    $legend = "Skid Inventory";
    $this->set(compact('skidinventorys', 'paginate', 'legend'));
  }
	
  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_skid";

    if ($this->request->is('post')) {
      $this->SkidInventory->create();
			
      $flag = $this->SkidInventory->save($this->request->data);
			
      if ($flag) {
        $this->Session->setFlash(__('The SkidInventory has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The SkidInventory could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }
  }	

  public function detail($id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_skid";

    $this->SkidInventory->id = $id;
    if (!$this->SkidInventory->exists()) {
      throw new NotFoundException(__('Invalid SkidInventory'));
    }
    $skidinventory = $this->SkidInventory->read(null, $id);
		
    $this->set(compact('skidinventory', 'id'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->SkidInventory->id = $id;
    if (!$this->SkidInventory->exists()) {
      throw new NotFoundException(__('Invalid SkidInventory'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SkidInventory']['id'] = $id; 			
			
      if ($this->SkidInventory->save($this->request->data)) {
        $this->Session->setFlash(__('The SkidInventory status has been saved'), 'default', array('class' => 'text-success'));

        $this->redirect(array('action' => 'detail', $this->SkidInventory->id));
      } else {
        $this->Session->setFlash(__('The SkidInventory status could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
        $this->redirect(array('action' => 'detail', $this->SkidInventory->id));
      }
    }
		$skidinventory = $this->SkidInventory->find('first', array('conditions' => array('SkidInventory.id' => $id)));		
		
		$this->set(compact('skidinventory', 'total'));
  }
	
	public function delete($id = null){
		$this->autoRender = false;
		$skid = $this->SkidInventory->find('first',array('conditions' => array('SkidInventory.id' => $id)));
		
		$data['SkidInventory']['delete'] = 1;
		$data['SkidInventory']['id'] = $id;
		
		$this->SkidInventory->save($data);
		$this->redirect(array('action' => 'index', $id));
	}
}
