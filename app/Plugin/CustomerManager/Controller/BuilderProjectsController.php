<?php

App::uses('CustomerManagerAppController', 'CustomerManager.Controller');

/**
 * Customers Controller
 *
 * @property Customer $Customer
 */
class BuilderProjectsController extends CustomerManagerAppController {

  public $helpers = array('CustomerManager.CustomerLookup');
  public $uses = array('CustomerManager.Customer');

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "builder-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_builder";
		
		if($this->isAjax){
			$this->layoutOpt['layout'] = 'ajax';
		}else{
			$this->layoutOpt['layout'] = 'left_bar_template';
		}
		
		$this->side_bar = "customer";
		$this->set("side_bar",$this->side_bar);
  }

  /**
   * index method
   *
   * @return void
   */
	public function index() {			

    $builderproject_data = $this->BuilderProject->find("all");
    $paginate = true;
    $legend = "All Builder Projects";

    $this->set(compact("legend", "builderproject_data", "paginate"));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_builder";
    $this->BuilderProject->id = $id;
    if (!$this->BuilderProject->exists()) {
      throw new NotFoundException(__('Invalid Projects'));
    }

    $builderproject_data = $this->BuilderProject->find('first', array('conditions' => array('BuilderProject.id' => $id)));

    $this->set(compact('id', 'builderproject_data'));
		
		$this->render('Elements/Detail/BuilderProject/project');
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
		$this->autoRender = false;
		
		$this->request->data['BuilderProject']['project_name'] = $this->request->data['project_name'];
		$this->request->data['BuilderProject']['site_address'] = $this->request->data['site_address'];
		$this->request->data['BuilderProject']['city'] = $this->request->data['city'];
		$this->request->data['BuilderProject']['province'] = $this->request->data['province'];
		$this->request->data['BuilderProject']['postal_code'] = $this->request->data['postal_code'];
		$this->request->data['BuilderProject']['country'] = $this->request->data['country'];
		$this->request->data['BuilderProject']['contact_person'] = $this->request->data['contact_person'];
		$this->request->data['BuilderProject']['contact_person_phone'] = $this->request->data['phone'];
		$this->request->data['BuilderProject']['contact_person_cell'] = $this->request->data['cell'];
		$this->request->data['BuilderProject']['multi_family_pricing'] = $this->request->data['m_f_p'];
		$this->request->data['BuilderProject']['customer_id'] = $this->request->data['customer_id'];
		$this->request->data['BuilderProject']['comment'] = $this->request->data['comment'];
		
    if ($this->request->is('post')) {
      $this->BuilderProject->create();
      if ($this->BuilderProject->save($this->request->data['BuilderProject'])) {
				$data['value'] = $this->BuilderProject->id;
				$b = $this->BuilderProject->find("first", array("conditions" => array("BuilderProject.id" => $data['value'])));
				$data['title'] = $b['BuilderProject']['project_name'];
      }
			echo json_encode($data);
    }
		exit;
  }
	
	public function addProject($customer_id = null){
    if ($this->request->is('post') || $this->request->is('put')) {      
      if ($this->BuilderProject->save($this->request->data)) {
				$id = $this->BuilderProject->id;
				$builderproject_data = $this->BuilderProject->find('first', array('conditions' => array('BuilderProject.id' => $id)));
				$this->set(compact('id', 'builderproject_data'));

				$this->render('Elements/Detail/BuilderProject/project');
      }
    } else {
			$this->set(compact('customer_id'));
			$this->render('Elements/Forms/BuilderProject/addForm');
    }
    $this->set(compact('data', 'id'));
	}
	
	public function getProjectSection($id = null){
		$this->autoRender = false;
		
		$customer = $this->Customer->find("first", array("conditions" => array("Customer.id" => $id)));
		
		if($customer['Customer']['customer_type_id'] == 2){
			$builder_project = 1;
		}
		else {
			$builder_project = 0;
		}
		echo $builder_project;
	}
  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
		
    $this->BuilderProject->id = $id;
    if (!$this->BuilderProject->exists()) {
      throw new NotFoundException(__('Invalid customer'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {      

      if ($this->BuilderProject->save($this->request->data)) {
				$builderproject_data = $this->BuilderProject->find('first', array('conditions' => array('BuilderProject.id' => $id)));
				$this->set(compact('id', 'builderproject_data'));

				$this->render('Elements/Detail/BuilderProject/project');
      }
    } else {
      $data = $this->BuilderProject->find('first', array('conditions' => array('BuilderProject.id' => $id)));
			$this->request->data = $data;
			$this->set(compact('data', 'id'));
			$this->render('Elements/Forms/BuilderProject/project');
    }
    $this->set(compact('data', 'id'));
  }
	
	public function getList($id = null){
    $project_list = $this->BuilderProject->find("all", array("conditions" => array('BuilderProject.customer_id' => $id)));

		$this->set(compact('project_list', 'id'));
		$this->render('Elements/PartialData/get_list');
	}

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null, $customer_id = null) {
		$this->autoRender = false;
		
    $this->BuilderProject->id = $id;
    if ($this->BuilderProject->delete()) {
      $this->Session->setFlash(__('BuilderProject deleted'), 'default', array('class' => 'text-success'));
			$this->redirect("http://{$_SERVER['SERVER_NAME']}{$this->webroot}customer_manager/builders/detail/{$customer_id}#project");
    }
  }
	
	public function getQuoteAndWO($id = null, $customer_id = null){
		App::import("Model", "QuoteManager.Quote");
    $Quote_model = new Quote();
    $Quote_data = $Quote_model->find("all", array("conditions" => array("Quote.project_id" => $id, 'Quote.vid' => null, 'Quote.status !=' => 'Approve')));
		
		App::import("Model", "WorkOrderManager.WorkOrder");
    $WorkOrder_model = new WorkOrder();
    $WorkOrder_data = $WorkOrder_model->find("all", array("conditions" => array("WorkOrder.project_id" => $id)));
		
		$this->set(compact('id', 'Quote_data', 'WorkOrder_data', "customer_id"));
		$this->render('Elements/PartialData/project_quote_list');
	}
	
	public function getQuote($id = null, $customer_id){
		App::import("Model", "QuoteManager.Quote");
    $Quote_model = new Quote();
    $quote = $Quote_model->find("first", array("conditions" => array("Quote.id" => $id)));	
		
		$this->set(compact('id', 'quote', "customer_id"));
		$this->render('Elements/PartialData/getQuote');
	}
	
	public function getWorkOrder($id = null, $customer_id){
		App::import("Model", "WorkOrderManager.WorkOrder");
    $WorkOrder_model = new WorkOrder();
    $work_order = $WorkOrder_model->find("first", array("conditions" => array("WorkOrder.id" => $id)));	
		
		$this->set(compact('id', 'work_order', "customer_id"));
		$this->render('Elements/PartialData/getWorkOrder');
	}

}
