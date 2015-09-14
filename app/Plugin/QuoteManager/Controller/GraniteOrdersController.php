<?php

App::uses('QuoteManagerAppController', 'QuoteManager.Controller');

/**
 * CabinetOrders Controller
 *
 * @property CabinetOrder $CabinetOrder
 */
class GraniteOrdersController extends QuoteManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "quote-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_quote";
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->CabinetOrder->recursive = 0;
    $this->set('cabinetOrders', $this->paginate());
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->CabinetOrder->id = $id;
    if (!$this->CabinetOrder->exists()) {
      throw new NotFoundException(__('Invalid cabinet order'));
    }
    $this->set('cabinetOrder', $this->CabinetOrder->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if ($this->request->is('post')) {
      $this->CabinetOrder->create();
      if ($this->CabinetOrder->save($this->request->data)) {
        $this->Session->setFlash(__('The cabinet order has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The cabinet order could not be saved. Please, try again.'));
      }
    }
    $pog = $this->CabinetOrder->find('list', array('fields' => 'pog'));
    $edgetape = $this->CabinetOrder->find('list', array('fields' => 'edgetape'));
    $stain_color = $this->CabinetOrder->find('list', array('fields' => 'stain_color'));
    $drawers = $this->CabinetOrder->find('list', array('fields' => 'drawers'));
    $quotes = $this->CabinetOrder->Quote->find('list');
    $this->set(compact('quotes', 'pog', 'edgetape', 'stain_color', 'drawers'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->CabinetOrder->id = $id;
    if (!$this->CabinetOrder->exists()) {
      throw new NotFoundException(__('Invalid cabinet order'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->CabinetOrder->save($this->request->data)) {
        $this->Session->setFlash(__('The cabinet order has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The cabinet order could not be saved. Please, try again.'));
      }
    }
    $pog = $this->CabinetOrder->find('list', array('fields' => 'pog'));
    $edgetape = $this->CabinetOrder->find('list', array('fields' => 'edgetape'));
    $stain_color = $this->CabinetOrder->find('list', array('fields' => 'stain_color'));
    $drawers = $this->CabinetOrder->find('list', array('fields' => 'drawers'));
    $this->request->data = $this->CabinetOrder->read(null, $id);
    $quotes = $this->CabinetOrder->Quote->find('list');
    $this->set(compact('quotes', 'pog', 'edgetape', 'stain_color', 'drawers'));
  }

  /**
   * edit_order method
   *
   * @param string $id
   * @return void
   */
  public function edit_order($quote_id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_quote";

    $this->quote_id = $quote_id;
    $this->GraniteOrder->quote_id = $quote_id;

    if ($this->request->is('post') || $this->request->is('put')) {
      $this->request->data['GraniteOrder']['quote_id'] = $quote_id;
      if ($this->GraniteOrder->save($this->request->data)) {
        $this->Session->setFlash(__('The granite order has been saved'));
        $this->redirect(array('controller' => 'quotes', 'action' => DETAIL, $quote_id));
      } else {
        $this->Session->setFlash(__('The granite order could not be saved. Please, try again.'));
      }
    }
    $this->request->data = $this->GraniteOrder->find('first', array(
        'conditions' => array('quote_id' => $quote_id)
            ));
    
    App::import('Model', 'QuoteManager.Quote');
    $quoteModel = new Quote();
    $quoteModel->recursive = 2;
    $quotes = $quoteModel->find('first', array(
        'conditions' => array('Quote.id' => $quote_id)
            ));
    
    App::import('Model', 'CustomerManager.Customer');
    $customerModel = new Customer();
    $customerModel->recursive =0;
    $customerTypes = $customerModel->CustomerType->find('list');
    
    $this->set(compact('quotes', 'quote_id','customerTypes'));
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
    $this->CabinetOrder->id = $id;
    if (!$this->CabinetOrder->exists()) {
      throw new NotFoundException(__('Invalid cabinet order'));
    }
    if ($this->CabinetOrder->delete()) {
      $this->Session->setFlash(__('Cabinet order deleted'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Cabinet order was not deleted'));
    $this->redirect(array('action' => 'index'));
  }

}
