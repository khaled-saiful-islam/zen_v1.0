<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Items Controller
 *
 * @property Item $Item
 */
class ItemsController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "item-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_item";
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->layoutOpt['left_nav_selected'] = "view_item";

        $this->Item->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] =$this->Item->parseCriteria($this->passedArgs);
        $this->set('items', $this->paginate());
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->layoutOpt['left_nav_selected'] = "view_item";

        $this->Item->id = $id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }
        $this->set('item', $this->Item->read(null, $id));
    }
    
    public function add_to_inventory($id = null)
    {
	$item = $this->Item->find("first", array("conditions" => array("Item.id" => $id)));
	
	$this->layoutOpt['left_nav_selected'] = false;
	if(!empty($this->request->data))
	{   
	    $this->request->data['ItemInventoryTransaction']['direction'] = 'in';
	    $this->request->data['ItemInventoryTransaction']['item_id'] = $id;
	    $this->request->data['ItemInventoryTransaction']['type'] = "add";
	    
	    $item = $this->Item->find("first", array("conditions" => array("Item.id" => $id)));
	    
	    $item['Item']['current_stock'] = $item['Item']['current_stock'] + $this->request->data['ItemInventoryTransaction']['count'];
	    $item['Item']['id'] = $id;
	    $this->Item->save($item);
	    
	    App::import( 'Model', 'Inventory.ItemInventoryTransaction' );
	    $iteminventorytransaction = new ItemInventoryTransaction();
	    $inventory = $iteminventorytransaction->save($this->request->data);
	    
	    if($inventory['ItemInventoryTransaction']['id'])
	    {
		$this->Session->setFlash(SAVE_SUCCESS_MSG, "Messages/success");
		$this->redirect(array("controller" => "items", "action" => "detail", $id));
	    }
	    else{
		$this->Session->setFlash(SAVE_FAILED_MODAL_MSG, "Messages/failed");
		$this->redirect(array("controller" => "items", "action" => "detail", $id));
	    }
	}
	$this->set(compact('id','item'));
    }
    public function damaged($id = null)
    {
	$this->layoutOpt['left_nav_selected'] = false;
	if(!empty($this->request->data))
	{   
	    $this->request->data['ItemInventoryTransaction']['direction'] = 'out';
	    $this->request->data['ItemInventoryTransaction']['item_id'] = $id;
	    $this->request->data['ItemInventoryTransaction']['type'] = "damaged";
	    
	    $item = $this->Item->find("first", array("conditions" => array("Item.id" => $id)));
	    $item['Item']['current_stock'] = $item['Item']['current_stock'] - $this->request->data['ItemInventoryTransaction']['count'];
	    $item['Item']['id'] = $id;
	    $this->Item->save($item);
	    
	    App::import( 'Model', 'Inventory.ItemInventoryTransaction' );
	    $iteminventorytransaction = new ItemInventoryTransaction();
	    $inventory = $iteminventorytransaction->save($this->request->data);
	    
	    if($inventory['ItemInventoryTransaction']['id'])
	    {
		$this->Session->setFlash(SAVE_SUCCESS_MSG, "Messages/success");
		$this->redirect(array("controller" => "items", "action" => "detail", $id));
	    }
	    else{
		$this->Session->setFlash(SAVE_FAILED_MODAL_MSG, "Messages/failed");
		$this->redirect(array("controller" => "items", "action" => "detail", $id));
	    }
	}
	$this->set(compact('id'));
    }  

    /**
     * check item department required field
     * 
     * return boolean
     */
    private function check_item_department_required($field, $value) {
        if ($field) {
            if ($value == "" || empty($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_item";

        if ($this->request->is('post')) {
            $item_cost = trim($this->request->data['Item']['item_cost']);
            $factor = trim($this->request->data['Item']['factor']);
            $supplier_id = $this->request->data['Item']['supplier_id'];
            $stock = $this->request->data['Item']['current_stock'];
            $department_id = trim($this->request->data['Item']['item_department_id']);

            $price = round($item_cost * $factor, 2);
            $this->request->data['Item']['price'] = $price;
            $item_department = $this->Item->ItemDepartment->find('all', array('conditions' => array('id' => $department_id)));

            if (!$this->check_item_department_required($item_department[0]['ItemDepartment']['supplier_required'], $supplier_id)) {
                $this->Session->setFlash(__('Your selected item department required supplier. Please, select supplier.'), 'default', array('class' => 'text-error'));
            } elseif (!$this->check_item_department_required($item_department[0]['ItemDepartment']['stock_number_required'], $stock)) {
                $this->Session->setFlash(__('Your selected item department required stock. Please, insert current stock.'), 'default', array('class' => 'text-error'));
            } else {
                $this->Item->create();
                if ($this->Item->save($this->request->data)) {
                    $this->Session->setFlash(__('The item has been saved'), 'default', array('class' => 'text-success'));
                    $this->redirect(array('action' => DETAIL, $this->Item->id));
                } else {
                    $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
                }
            }
        }
        $suppliers = $this->Item->Supplier->find('list');
        $itemDepartments = $this->Item->ItemDepartment->find('list');
        $cabinets = $this->Item->Cabinet->find('list');
        $this->set(compact('suppliers', 'itemDepartments', 'cabinets'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($item_id = null, $section = null) {
        $this->Item->id = $item_id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!$section) {
                $item_cost = trim($this->request->data['Item']['item_cost']);
                $factor = trim($this->request->data['Item']['factor']);
                $supplier_id = $this->request->data['Item']['supplier_id'];
                $stock = $this->request->data['Item']['current_stock'];
                $department_id = trim($this->request->data['Item']['item_department_id']);

                $price = round($item_cost * $factor, 2);
                $this->request->data['Item']['price'] = $price;
                $item_department = $this->Item->ItemDepartment->find('all', array('conditions' => array('id' => $department_id)));


                if (!$this->check_item_department_required($item_department[0]['ItemDepartment']['supplier_required'], $supplier_id)) {
                    $this->Session->setFlash(__('Your selected item department required supplier. Please, select supplier.'), 'default', array('class' => 'text-error'));
                } elseif (!$this->check_item_department_required($item_department[0]['ItemDepartment']['stock_number_required'], $stock)) {
                    $this->Session->setFlash(__('Your selected item department required stock. Please, insert current stock.'), 'default', array('class' => 'text-error'));
                } else {
                    if ($this->Item->save($this->request->data)) {
                        $this->Session->setFlash(__('The item has been saved'), 'default', array('class' => 'text-success'));
                        $this->redirect(array('action' => 'detail_section', $item_id, $section));
                    } else {
                        $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
                    }
                }
            } else {
                if ($this->Item->save($this->request->data)) {
                    $this->Session->setFlash(__('The item has been saved'), 'default', array('class' => 'text-success'));
                    $this->redirect(array('action' => 'detail_section', $item_id, $section));
                } else {
                    $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
                }
            }
        } else {
            $this->request->data = $this->Item->read(null, $item_id);
        }
        $suppliers = $this->Item->Supplier->find('list');
        $itemDepartments = $this->Item->ItemDepartment->find('list');
        $cabinets = $this->Item->Cabinet->find('list');
        $this->set(compact('suppliers', 'itemDepartments', 'cabinets', 'section', 'item_id'));
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
        $this->Item->id = $id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }
        if ($this->Item->delete()) {
            $this->Session->setFlash(__('Item deleted'), 'default', array('class' => 'text-success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Item was not deleted'), 'default', array('class' => 'text-error'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * damaged_item method
     *
     * @param string $id
     * @return void
     */
    public function damaged_item($id = null) {
//    if ($this->request->is('post')) {
//      $this->Item->create();
//      if ($this->Item->save($this->request->data)) {
//        $this->Session->setFlash(__('The item has been saved'), 'default', array('class' => 'text-success'));
//        $this->redirect(array('action' => 'index'));
//      } else {
//        $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
//      }
//    }
//    $suppliers = $this->Item->Supplier->find('list');
//    $itemDepartments = $this->Item->ItemDepartment->find('list');
//    $cabinets = $this->Item->Cabinet->find('list');
//    $this->set(compact('suppliers', 'itemDepartments', 'cabinets'));
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail_section($item_id = null, $section = null) {
        $this->layoutOpt['left_nav_selected'] = "view_item";

        $this->Item->id = $item_id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }
        $item = $this->Item->read(null, $item_id);
        $this->set(compact('item', 'item_id', 'section'));
    }

}
