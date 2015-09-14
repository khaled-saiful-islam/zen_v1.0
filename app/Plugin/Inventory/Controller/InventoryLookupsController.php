<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * InventoryLookups Controller
 *
 * @property InventoryLookup $InventoryLookup
 */
class InventoryLookupsController extends InventoryAppController {

  private $editable_system_data = array('drawer');
  private $cabinet_data_settings = array(
      'cabinet_item_category', 'cabinet_type', 'product_line'
  );
  private $door_data_settings = array(
      'doors_product_line', 'doors_rounding_method', 'wood_species'
  );
  private $item_data_settings = array(
      'item_option'
  );
  private $item_data_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
  );
  private $quote_data_settings = array(
      'drawer_slide', 'order_delivery_option', 'order_door_information'
  );
  private $schedule_data_settings = array(
      'service_techs', 'installer_name'
  );
  private $user_data_settings = array(
      'user_role'
  );
  private $customer_data_settings = array(
      'referral',
      'builder_supply_type',
      'builder_type',
  );
  private $supplier_data_settings = array(
      'supplier_type',
  );
  private $item_color_data_settings = array(
      'item_color',
  );
  private $item_color_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'value' => array(
          'label' => 'Color Code',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'price' => array(
          'label' => 'Rate (Cost) per SQFT',
          'unique' => false,
          'hidden' => false,
          'required' => true,
      ),
      'parent_lookup' => array(
          'label' => 'Material',
          'unique' => false,
          'hidden' => false,
          'required' => true,
          'lookup_type' => 'item_material',
      ),
  );
  private $item_material_data_settings = array(
      'item_material',
  );
  private $item_material_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'value' => array(
          'label' => 'Material Code',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $item_group_data_settings = array(
      'item_group',
  );
  private $item_group_config = array(
      'lookup_type' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
      ),
      'value' => array(
          'label' => 'Group Code',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $drawer_data_settings = array(
      'drawer',
  );
  private $drawer_config = array(
      'lookup_type' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
      ),
      'value' => array(
          'label' => 'Code',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'price' => array(
          'label' => 'Price',
          'unique' => false,
          'hidden' => false,
          'required' => true,
      ),
      'department_id' => array(
          'label' => 'Department',
          'unique' => false,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $door_drawer_width_code_settings = array(
      'door_drawer_width',
  );
  private $door_drawer_width_code_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'name' => array(
          'label' => 'Width',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'value' => array(
          'label' => 'Door/Drawer Width',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $door_height_code_settings = array(
      'door_height',
  );
  private $door_height_code_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'name' => array(
          'label' => 'Height',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'value' => array(
          'label' => 'Door Height',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $door_width_code_settings = array(
      'door_width',
  );
  private $door_width_code_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'name' => array(
          'label' => 'Width',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'value' => array(
          'label' => 'Door Width',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $drawer_height_code_settings = array(
      'drawer_height',
  );
  private $drawer_height_code_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'name' => array(
          'label' => 'Height',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'value' => array(
          'label' => 'Drawer Height',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $item_edge_tap_data_settings = array(
      'edge_tap',
  );
  private $installation_data_settings = array(
      'installation_type',
  );
  private $installation_config = array(
      'lookup_type' => array(
          'hidden' => true,
      ),
      'name' => array(
          'label' => 'Code',
          'unique' => true,
          'hidden' => false,
          'required' => true,
      ),
      'value' => array(
          'label' => 'Description',
          'unique' => false,
          'hidden' => false,
          'required' => true,
      ),
      'price' => array(
          'label' => 'Price',
          'unique' => false,
          'hidden' => false,
          'required' => true,
      ),
      'price_unit' => array(
          'label' => 'Price Unit',
          'unique' => false,
          'hidden' => false,
          'required' => true,
      ),
  );
  private $item_default_config = array(
      'name' => array(
          'label' => null,
          'unique' => true,
          'hidden' => false,
      ),
      'lookup_type' => array(
          'label' => null,
          'unique' => false,
          'hidden' => false,
      ),
      'value' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
      ),
      'price' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
      ),
      'price_unit' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
      ),
      'parent_lookup' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
          'lookup_type' => null,
      ),
      'department_id' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
          'lookup_type' => null,
      ),
  );

  private function get_type_values($type) {
    $type_value = array();
    switch ($type) {
      case 'Cabinet':
        $type_value = $this->cabinet_data_settings;
        break;
      case 'Door':
        $type_value = $this->door_data_settings;
        break;
      case 'Drawer':
        $type_value = $this->drawer_data_settings;
        break;
      case 'Door_Drawer_Width':
        $type_value = $this->door_drawer_width_code_settings;
        break;
      case 'Door_Width':
        $type_value = $this->door_width_code_settings;
        break;
      case 'Door_Height':
        $type_value = $this->door_height_code_settings;
        break;
      case 'Drawer_Height':
        $type_value = $this->drawer_height_code_settings;
        break;
      case 'Item':
        $type_value = $this->item_data_settings;
        break;
      case 'Item_Color':
        $type_value = $this->item_color_data_settings;
        break;
      case 'Item_Material':
        $type_value = $this->item_material_data_settings;
        break;
      case 'Item_Group':
        $type_value = $this->item_group_data_settings;
        break;
      case 'Installation':
        $type_value = $this->installation_data_settings;
        break;
      case 'edge_tap':
        $type_value = $this->item_edge_tap_data_settings;
        break;
      case 'Quote':
        $type_value = $this->quote_data_settings;
        break;
      case 'Schedule':
        $type_value = $this->schedule_data_settings;
        break;
      case 'User':
        $type_value = $this->user_data_settings;
        break;
      case 'Customer':
        $type_value = $this->customer_data_settings;
        break;
      case 'Supplier':
        $type_value = $this->supplier_data_settings;
        break;
    }

    return $type_value;
  }

  private function get_type_config($type) {
    $type_config = $this->item_default_config;
    switch ($type) {
      case 'Drawer':
        $type_config = array_merge($type_config, $this->drawer_config);
        break;
      case 'Door_Drawer_Width':
        $type_config = array_merge($type_config, $this->door_drawer_width_code_config);
        break;
      case 'Door_Width':
        $type_config = array_merge($type_config, $this->door_width_code_config);
        break;
      case 'Door_Height':
        $type_config = array_merge($type_config, $this->door_height_code_config);
        break;
      case 'Drawer_Height':
        $type_config = array_merge($type_config, $this->drawer_height_code_config);
        break;
      case 'Item':
        $type_config = array_merge($type_config, $this->item_data_config);
        break;
      case 'Item_Group':
        $type_config = array_merge($type_config, $this->item_group_config);
        break;
      case 'Item_Color':
        $type_config = array_merge($type_config, $this->item_color_config);
        break;
      case 'Item_Material':
        $type_config = array_merge($type_config, $this->item_material_config);
        break;
      case 'Installation':
        $type_config = array_merge($type_config, $this->installation_config);
        break;
    }

    return $type_config;
  }

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
  public function index($type = null) {		
		if($type == "Drawer" || $type == "Door" || $type == "Cabinet" || $type == "Installation"){
			if($this->isAjax){
				$this->layoutOpt['layout'] = 'ajax';
			}else{
				$this->layoutOpt['layout'] = 'item_template';
			}

			$this->side_bar = "item";
			$this->set("side_bar",$this->side_bar);
		}
		
		if($type == "User" || $type == "Supplier" || $type == "Door_Drawer_Width" || $type == "Door_Height" || $type == "Door_Width" || $type == "Drawer_Height" || $type == "Customer"){
			if($this->isAjax){
				$this->layoutOpt['layout'] = 'ajax';
			}else{
				$this->layoutOpt['layout'] = 'left_bar_template';
			}

			$this->side_bar = "admin";
			$this->set("side_bar",$this->side_bar);
		}
		
    $this->InventoryLookup->recursive = 0;
    $this->Prg->commonProcess();
    $this->paginate['conditions'] = $this->InventoryLookup->parseCriteria($this->passedArgs);

    $type_value = $this->get_type_values($type);
    $type_config = $this->get_type_config($type);

    $inventoryLookups = $this->paginate('InventoryLookup', array("lookup_type" => $type_value));
    foreach($inventoryLookups as $index => $row) {
      $inventoryLookups[$index]['InventoryLookup']['department_id'] = $this->InventoryLookup->SearchCache2Array($row['InventoryLookup']['department_id']);
    }
		$friendly_type = $type;
		if($type == 'Supplier'){
			$friendly_type = 'Vendor';
		}
    $this->set(compact('inventoryLookups', 'type', 'type_config', 'friendly_type'));
  }

  /**
   * detail method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null, $type = null) {
		
		if($type == "Drawer" || $type == "Door" || $type == "Cabinet" || $type == "Installation"){
			if($this->isAjax){
				$this->layoutOpt['layout'] = 'ajax';
			}else{
				$this->layoutOpt['layout'] = 'item_template';
			}

			$this->side_bar = "item";
			$this->set("side_bar",$this->side_bar);
		}
		
		if($type == "User" || $type == "Supplier" || $type == "Door_Drawer_Width" || $type == "Door_Height" || $type == "Door_Width" || $type == "Drawer_Height" || $type == "Customer"){
			if($this->isAjax){
				$this->layoutOpt['layout'] = 'ajax';
			}else{
				$this->layoutOpt['layout'] = 'left_bar_template';
			}

			$this->side_bar = "admin";
			$this->set("side_bar",$this->side_bar);
		}
		
    $this->InventoryLookup->id = $id;
    if (!$this->InventoryLookup->exists()) {
      throw new NotFoundException(__('Invalid inventory lookup'));
    }
    $inventoryLookup = $this->InventoryLookup->read(null, $id);
    $inventoryLookup['InventoryLookup']['department_id'] = $this->InventoryLookup->SearchCache2Array($inventoryLookup['InventoryLookup']['department_id']);
    $type_config = $this->get_type_config($type);
    $editable_system_data = $this->editable_system_data;
    $this->set(compact('inventoryLookup', 'type', 'type_config', 'editable_system_data'));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add($type = null) {
    $type_config = $this->get_type_config($type);

    if ($this->request->is('post')) {
      $this->request->data['type_config'] = $type_config;
      $this->InventoryLookup->create();
      if ($this->InventoryLookup->save($this->request->data)) {
        $this->Session->setFlash(__('The inventory lookup has been saved'));
        $this->redirect(array('action' => DETAIL, $this->InventoryLookup->id, $type));
      } else {
        $this->Session->setFlash(__('The inventory lookup could not be saved. Please, try again.'));
      }
    }
    $type_value = $this->get_type_values($type);

    $this->set(compact('type', 'type_value', 'type_config'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $type = null) {
		
		if($type == "Drawer" || $type == "Door" || $type == "Cabinet" || $type == "Installation"){
			if($this->isAjax){
				$this->layoutOpt['layout'] = 'ajax';
			}else{
				$this->layoutOpt['layout'] = 'item_template';
			}

			$this->side_bar = "item";
			$this->set("side_bar",$this->side_bar);
		}
		
		if($type == "User" || $type == "Supplier" || $type == "Door_Drawer_Width" || $type == "Door_Height" || $type == "Door_Width" || $type == "Drawer_Height" || $type == "Customer"){
			if($this->isAjax){
				$this->layoutOpt['layout'] = 'ajax';
			}else{
				$this->layoutOpt['layout'] = 'left_bar_template';
			}

			$this->side_bar = "admin";
			$this->set("side_bar",$this->side_bar);
		}
		
    $this->InventoryLookup->id = $id;
    $type_config = $this->get_type_config($type);
    if (!$this->InventoryLookup->exists()) {
      throw new NotFoundException(__('Invalid inventory lookup'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      $this->request->data['type_config'] = $type_config;
      if ($this->InventoryLookup->save($this->request->data)) {
        $this->Session->setFlash(__('The inventory lookup has been saved'));
        $this->redirect(array('action' => DETAIL, $this->InventoryLookup->id, $type));
      } else {
        $this->Session->setFlash(__('The inventory lookup could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->InventoryLookup->read(null, $id);
      $this->request->data['InventoryLookup']['department_id'] = $this->InventoryLookup->SearchCache2Array($this->request->data['InventoryLookup']['department_id']);
    }

    $type_value = $this->get_type_values($type);

    $this->set(compact('type', 'type_value', 'type_config'));
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null, $type = null) {
    //return 0; // disable delete
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->InventoryLookup->id = $id;
    if (!$this->InventoryLookup->exists()) {
      throw new NotFoundException(__('Invalid inventory lookup'), 'default', array('class' => 'text-error'));
    }
    $inventory_lookup['id'] = $id;
    $inventory_lookup['delete'] = 1;
    $data = $this->InventoryLookup->save($inventory_lookup);

    if ($data) {
      $this->Session->setFlash(__('Inventory lookup deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index', $type));
    }
    $this->Session->setFlash(__('Inventory lookup was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index', $type));
  }

}
