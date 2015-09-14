<?php

App::uses('CustomerManagerAppController', 'CustomerManager.Controller');

/**
 * Customers Controller
 *
 * @property Customer $Customer
 */
class CustomersController extends CustomerManagerAppController {

  public $helpers = array('CustomerManager.CustomerLookup');

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "customer-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_customer";
		
		$this->paginate['conditions'] = array('Customer.customer_type_id' => array('0', '1'));

    $title_prefix = __('Retail Customer');
    $customer_type = 'retail';
    $this->set(compact('title_prefix', 'customer_type'));
		
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
    $this->Customer->recursive = 1;

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
    $this->paginate['conditions'] += $this->Customer->parseCriteria($this->passedArgs);
    $name = $this->Customer->find('list', array('fields' => array('first_name', 'last_name')));
    $customers = $this->paginate();
    $customerTypes = $this->Customer->CustomerType->find('list');
    $paginate = true;
    $legend = "Retail Customers";

    $this->set(compact('customers', 'name', 'customerTypes', 'paginate', 'legend'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null, $modal = null) {
    $this->layoutOpt['left_nav_selected'] = "view_customer";
    $this->Customer->id = $id;
    if (!$this->Customer->exists()) {
      throw new NotFoundException(__('Invalid customer'));
    }
    //$this->set('customer', $this->Customer->read(null, $id));

    $customer = $this->Customer->read(null, $id);

    App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
    $sales = new CustomerSalesRepresentetives();
    $sales_representatives = $sales->find("all", array("conditions" => array("CustomerSalesRepresentetives.customer_id" => $id)));

    App::uses("Quote", "QuoteManager.Model");
    $quote = new Quote();
    $quotes = $quote->find("all", array("conditions" => array("Quote.vid" => null, 'Quote.customer_id' => $id)));
    $this->set(compact('customer', 'modal', 'sales_representatives', 'quotes'));
  }

  /**
   * view section method
   *
   * @param string $id
   * @return void
   */
  public function detail_section($customer_id = null, $section = null) {
    $this->layoutOpt['left_nav_selected'] = "view_customer";
    $this->Customer->id = $customer_id;
    if (!$this->Customer->exists()) {
      throw new NotFoundException(__('Invalid customer'));
    }
    $customer = $this->Customer->read(null, $customer_id);

    App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
    $sales = new CustomerSalesRepresentetives();
    $sales_representatives = $sales->find("all", array("conditions" => array("CustomerSalesRepresentetives.customer_id" => $customer_id)));
    $edit = 'false';
    $this->set(compact('customer', 'section', 'sales_representatives', 'edit'));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_customer";
    if ($this->request->is('post')) {			
      $this->Customer->create();
      $exit_email = $this->Customer->find('first', array('fields' => array('email'), 'conditions' => array('email' => $this->request->data['Customer']['email'])));
//      debug($exit_email);exit;
      if ($this->Customer->save($this->request->data)) {
        $msg = "";
        if ($exit_email)
          $msg = '"' . $this->request->data['Customer']['email'] . '" This email address already exist.';
        $this->Session->setFlash(__('The retail customer has been saved. ' . $msg), 'default', array('class' => 'text-success'));

        $sales_representatives = serialize($this->request->data['Customer']['sales_representative']);
        $customer_id_sales = $this->Customer->id;

        foreach ($this->request->data['Customer']['sales_representative'] as $key => $value) {
          $sales_list = array(
              'user_id' => $value,
              'customer_id' => $this->Customer->id
          );
          App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
          $user = new CustomerSalesRepresentetives();
          $user->save($sales_list);
        }
        $this->request->data['Customer']['sales_representatives'] = $sales_representatives;
        $this->request->data['id'] = $customer_id_sales;
        $this->Customer->save($this->request->data);

        $this->redirect(array('action' => DETAIL, $this->Customer->id));
      } else {
        $this->Session->setFlash(__('The retail customer could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }
    $customerTypes = $this->Customer->CustomerType->find('list');
    $this->set(compact('customerTypes'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $section = null) {
    $this->Customer->id = $id;
    if (!$this->Customer->exists()) {
      throw new NotFoundException(__('Invalid customer'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      $exit_email = $this->Customer->find('first', array('fields' => array('email'), 'conditions' => array('email' => $this->request->data['Customer']['email'])));
      if ($this->Customer->save($this->request->data)) {
        $msg = "";
        if ($exit_email)
          $msg = '"' . $this->request->data['Customer']['email'] . '" This email address already exist.';

        $this->Session->setFlash(__('The retail customer has been saved. ' . $msg));
        if ($section != 'basic') {
          $this->redirect(array('action' => 'detail_section', $this->Customer->id, $section));
        } else {
          $sales_representatives = serialize($this->request->data['Customer']['sales_representative']);
          $customer_id_sales = $this->Customer->id;

          App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
          $csr = new CustomerSalesRepresentetives();
          $csr->deleteAll(array('CustomerSalesRepresentetives.customer_id' => $this->Customer->id));
          foreach ($this->request->data['Customer']['sales_representative'] as $key => $value) {
            $sales_list = array(
                'user_id' => $value,
                'customer_id' => $this->Customer->id
            );
            $user = new CustomerSalesRepresentetives();
            $user->save($sales_list);
          }
          $this->request->data['Customer']['sales_representatives'] = $sales_representatives;
          $this->request->data['id'] = $customer_id_sales;
          $this->Customer->save($this->request->data);
          $this->redirect(array('action' => DETAIL, $this->Customer->id));
        }
      } else {
        $this->Session->setFlash(__('The retail customer could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->Customer->read(null, $id);
      $sales_data = $this->request->data['Customer']['sales_representatives'];
    }
    $customerTypes = $this->Customer->CustomerType->find('list');
    $this->set(compact('customerTypes', 'id', 'section', 'sales_data'));
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
    $this->Customer->id = $id;
    if (!$this->Customer->exists()) {
      throw new NotFoundException(__('Invalid customer'), 'default', array('class' => 'text-error'));
    }
    $customer = $this->Customer->find("first", array("conditions" => array("Customer.id" => $id)));
    $d['id'] = $id;
    $d['delete'] = 1;
    $d['customer_type_id'] = $customer['Customer']['customer_type_id'];

    if ($this->Customer->save($d)) {
      $this->Session->setFlash(__('Customer deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Customer was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

  public function report($limit = REPORT_LIMIT) {
    $this->layoutOpt['left_nav'] = "";
    $this->layoutOpt['left_nav_selected'] = "";

    $this->Customer->recursive = 0;
    if ($limit != 'All') {
      $this->paginate['limit'] = $limit;
      $this->Prg->commonProcess();
      $this->paginate['conditions'] = $this->Customer->parseCriteria($this->passedArgs);
      $customers = $this->paginate();
    } else {
      $customers = $this->Customer->find('all');
    }
    $name = $this->Customer->find('list', array('fields' => array('first_name', 'last_name')));
    $paginate = false;
    $legend = "Customers Report";
    $customerTypes = $this->Customer->CustomerType->find('list');

    $this->set(compact('customers', 'name', 'limit', 'paginate', 'legend', 'customerTypes'));
  }

  function listing_report_print($limit = REPORT_LIMIT) {
    $this->layoutOpt['layout'] = 'report';

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
    $this->paginate['conditions'] = $this->Customer->parseCriteria($this->passedArgs);
    $name = $this->Customer->find('list', array('fields' => array('first_name', 'last_name')));
    $customers = $this->paginate();
    $paginate = false;
    $legend = "Customers Report";
    $reportTitle = "General Listing Report";
    $reportDate = date('l, F d, Y');

    $this->set(compact('customers', 'name', 'paginate', 'legend', 'reportTitle', 'reportDate'));
  }

  public function print_detail($id = null) {
    $this->layoutOpt['layout'] = 'report';

    $this->Customer->id = $id;
    if (!$this->Customer->exists()) {
      throw new NotFoundException(__('Invalid item'));
    }
    $customer = $this->Customer->find("first", array("conditions" => array("Customer.id" => $id)));
    App::import('Model', 'CustomerManager.BuilderAccount');
    $this->BuilderAccount = new BuilderAccount();
    $builder_account_info = $this->BuilderAccount->find('all', array('conditions' => array('BuilderAccount.customer_id' => $id)));
    $reportTitle = "Customer Information Sheet";
    $reportDate = date('l, F d, Y');

    App::uses("CustomerSalesRepresentetives", "CustomerManager.Model");
    $sales = new CustomerSalesRepresentetives();
    $sales_representatives = $sales->find("all", array("conditions" => array("CustomerSalesRepresentetives.customer_id" => $id)));

    $this->set(compact('customer', '$builder_account_info', 'reportTitle', 'reportDate', 'sales_representatives'));
  }

}
