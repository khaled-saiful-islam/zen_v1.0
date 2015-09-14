<?php

App::uses('CustomerManagerAppController', 'CustomerManager.Controller');

/**
 * CustomerAddresses Controller
 *
 * @property CustomerAddress $CustomerAddress
 */
class CustomerAddressesController extends CustomerManagerAppController {

  /**
   * index method
   *
   * @return void
   */
  public function index($customer_id = null) {
    $this->CustomerAddress->recursive = 0;
    if (!empty($customer_id)) {
      $this->set('customer_addresses', $this->paginate(array('customer_id' => $customer_id)));
    } else {
      $this->set('customer_addresses', $this->paginate());
    }
  }

  /**
   * show_list method
   *
   * @return void
   */
  public function show_list($customer_id = null) {
    if (isset($customer_id)) {
      $customer_addresses = $this->CustomerAddress->find('all', array('conditions' => array('customer_id' => $customer_id)));
      $this->set(compact('customer_addresses', 'customer_id'));
    } else {
      throw new NotFoundException(__('Not Found'));
    }
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->CustomerAddress->id = $id;
    if (!$this->CustomerAddress->exists()) {
      throw new NotFoundException(__('Invalid address'));
    }
    $this->set('address', $this->CustomerAddress->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if ($this->request->is('post')) {
      $this->CustomerAddress->create();
      if ($this->CustomerAddress->save($this->request->data)) {
        $this->Session->setFlash(__('The address has been saved'));
        $this->redirect(array('action' => 'show_list', $this->CustomerAddress->customer_id));
      } else {
        $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
      }
    }
    $addressTypes = $this->CustomerAddress->AddressType->find('list');
    $customers = $this->CustomerAddress->Customer->find('list');
    $this->set(compact('addressTypes', 'customers'));
  }

  /**
   * add_sub method to add address for ref types
   *
   * @return void
   */
  public function add_sub($customer_id = null) {
    $this->autoRender = false;
    if (!isset($customer_id)) {
      throw new NotFoundException(__('Invalid customer'));
    }

    if ($this->request->is('post')) {
      $this->CustomerAddress->create();
      if ($this->CustomerAddress->save($this->request->data)) {
        $this->Session->setFlash(__('The address has been saved'));
        $this->redirect(array('action' => 'show_list', $this->request->data['CustomerAddress']['customer_id']));
      } else {
        $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
      }
    }
    $addressTypes = $this->CustomerAddress->AddressType->find('list');
    $customers = $this->CustomerAddress->Customer->find('list');
    $customer = $this->CustomerAddress->Customer->find('first', array('conditions' => array('Customer.id' => $customer_id)));
    $customer_type = 'Customer';
    if ($customer['Customer']['customer_type_id'] != '1') {
      $customer_type = 'Builder';
    }
    $legend = "Add {$customer_type} Address";

    $this->set(compact('addressTypes', 'customers', 'customer_addresses', 'customer_id', 'legend', 'customer'));
    $this->render('Elements/Forms/CustomerAddress/address-sub-form');
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->CustomerAddress->id = $id;
    if (!$this->CustomerAddress->exists()) {
      throw new NotFoundException(__('Invalid address'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->CustomerAddress->save($this->request->data)) {
        $this->Session->setFlash(__('The address has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->CustomerAddress->read(null, $id);
    }
    $addressTypes = $this->CustomerAddress->AddressType->find('list');
    $customers = $this->CustomerAddress->Customer->find('list');
    $customer = $this->CustomerAddress->Customer->find('first', array('conditions' => array('Customer.id' => $customer_id)));
    $customer_type = 'Customer';
    if ($customer['Customer']['customer_type_id'] != '1') {
      $customer_type = 'Builder';
    }
    $legend = "Edit {$customer_type} Address";

    $this->set(compact('addressTypes', 'customers', 'customer', 'legend'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit_sub($id = null, $customer_id = null) {
    $this->autoRender = FALSE;

    $this->CustomerAddress->id = $id;
    if (!$this->CustomerAddress->exists()) {
      throw new NotFoundException(__('Invalid address'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->CustomerAddress->save($this->request->data)) {
        $this->Session->setFlash(__('The address has been saved'));
        $this->redirect(array('action' => 'show_list', $customer_id));
      } else {
        $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->CustomerAddress->read(null, $id);
    }
    $addressTypes = $this->CustomerAddress->AddressType->find('list');
    $customers = $this->CustomerAddress->Customer->find('list');
    $customer = $this->CustomerAddress->Customer->find('first', array('conditions' => array('Customer.id' => $customer_id)));
    $customer_type = 'Customer';
    if ($customer['Customer']['customer_type_id'] != '1') {
      $customer_type = 'Builder';
    }
    $legend = "Edit {$customer_type} Address";

    $this->set(compact('addressTypes', 'customers', 'customer_id', 'legend', 'customer'));

    $this->render('Elements/Forms/CustomerAddress/address-sub-form');
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null, $customer_id = null) {
    $this->CustomerAddress->id = $id;
    if (!$this->CustomerAddress->exists()) {
      throw new NotFoundException(__('Invalid address'));
    }
    if ($this->CustomerAddress->delete()) {
      $this->Session->setFlash(__('CustomerAddress deleted'));
      $this->redirect(array('controller' => 'Customers', 'action' => 'detail', $customer_id));
    }
    $this->Session->setFlash(__('CustomerAddress was not deleted'));
    $this->redirect(array('action' => 'show_list', $customer_id));
  }

}
