<?php

App::uses('InvoiceManagerAppController', 'InvoiceManager.Controller');

/**
 * Invoices Controller
 *
 * @property Invoice $Invoice
 */
class InvoicesController extends InvoiceManagerAppController {
  //public $components = array('InvoiceManager.Invoice');

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
//    $this->layoutOpt['left_nav'] = "invoice-left-nav";
//    $this->layoutOpt['left_nav_selected'] = "view_invoice";
  }

  /**
   * index method
   *
   * @return void
   */
  public function index($type) {
    $this->Invoice->recursive = 0;
    $invoices = array();
    if ($type == "Purchase Order") {
      $this->Prg->commonProcess();
      $this->paginate['conditions'] = $this->Invoice->parseCriteria($this->passedArgs);
      $this->paginate['conditions'] += array('Invoice.invoice_of' => $type); // skip version histories
    } elseif ($type == "Quote") {
      
    }
    $invoices = $this->paginate();

    $this->set(compact('invoices', 'type'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->Invoice->id = $id;
    $this->Invoice->recursive = 1;
    if (!$this->Invoice->exists()) {
      throw new NotFoundException(__('Invalid invoice'));
    }
    App::import('Model', 'InvoiceManager.InvoiceStatus');
    $invoiceStatus = new InvoiceStatus();
    $status_list = $invoiceStatus->find('list', array('fields' => array('id', 'name')));

    App::import('Model', 'InvoiceManager.InvoiceLog');
    $invoiceLog = new InvoiceLog();
    $status_log = $invoiceLog->find('all', array('conditions' => array('invoice_id' => $id)));

    $invoice = $this->Invoice->read(null, $id);

    $this->set(compact('invoice', 'status_list', 'status_log', 'id'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function create_invoice($id = null, $type = null) {
    $this->layoutOpt['layout'] = 'invoice';
  }

  /**
   * add method
   *
   * @return void
   */
  public function add($id = null, $type = null) {
    $data = array();
    $itemData = array();
    if ($type == 'Purchase Order') {
      App::import('Model', 'PurchaseOrderManager.PurchaseOrder');
      $purchaseOrder = new PurchaseOrder();
      $purchaseOrder->recursive = 0;
      $data = $purchaseOrder->find('first', array('conditions' => array('PurchaseOrder.id' => $id)));
      $itemData = $this->QuoteItem->listOfPoItem(null, $id);
    } elseif ($type == 'Quote') {
      App::import('Model', 'QuoteManager.Quote');
      $quote = new Quote();
      $quote->recursive = 1;
      $data = $quote->find('first', array('conditions' => array('Quote.id' => $id)));
      $itemData = $this->QuoteItem->ListQuoteItems($id);
//      debug($itemData); 
      $itemData = $this->QuoteItem->AdjustPOItem($itemData);
      $itemData['main_list'] = $itemData['name_list'];
      unset($itemData['name_list']);
      $itemData['qty_list'] = $itemData['quantity_list'];
      unset($itemData['quantity_list']);
//      debug($data); 
//      debug($itemData); 
//      
//      exit;
    }

    $invoice_no = $this->QuoteItem->auto_generate_number('Invoice');
    $invoiceFormatData = $this->InvoiceItem->formatInvoiceData($invoice_no, $type, $id, $data, $itemData);

    $invoiceCreate = $this->InvoiceItem->createInvoice($invoiceFormatData);

    if ($invoiceCreate) {
      $this->Session->setFlash(__('The invoice has been saved'));
      $this->redirect(array('action' => 'detail', $invoiceCreate['Invoice']['id']));
    } else {
      $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
    }

    $this->set(compact('invoiceStatuses', 'type'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null, $section = null) {
    $this->Invoice->id = $id;
    if (!$this->Invoice->exists()) {
      throw new NotFoundException(__('Invalid invoice'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Invoice->save($this->request->data)) {
        $this->Session->setFlash(__('The invoice has been saved'));
        $this->redirect(array('action' => 'detail_section', $id, $section));
      } else {
        $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
      }
    }
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null) {
    $this->Invoice->id = $id;
    if (!$this->Invoice->exists()) {
      throw new NotFoundException(__('Invalid invoice'));
    }
    $data = $this->Invoice->read(null, $id);
    if ($this->Invoice->save($data)) {
      $this->Session->setFlash(__('The invoice has been saved'));
      $this->redirect(array('action' => 'index'));
    } else {
      $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
    }
    $invoiceStatuses = $this->Invoice->InvoiceStatus->find('list');
    $this->redirect(array('action' => 'index'));
    /*
      if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
      }
      $this->Invoice->id = $id;
      if (!$this->Invoice->exists()) {
      throw new NotFoundException(__('Invalid invoice'));
      }
      if ($this->Invoice->delete()) {
      $this->Session->setFlash(__('Invoice deleted'));
      $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash(__('Invoice was not deleted'));
      $this->redirect(array('action' => 'index'));
     */
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail_section($id = null, $section = null) {
    $this->Invoice->id = $id;
    $this->Invoice->recursive = 1;
    if (!$this->Invoice->exists()) {
      throw new NotFoundException(__('Invalid invoice'));
    }
    App::import('Model', 'InvoiceManager.InvoiceStatus');
    $invoiceStatus = new InvoiceStatus();
    $status_list = $invoiceStatus->find('list', array('fields' => array('id', 'name')));

    App::import('Model', 'InvoiceManager.InvoiceLog');
    $invoiceLog = new InvoiceLog();
    $status_log = $invoiceLog->find('all', array('conditions' => array('invoice_id' => $id)));

    $invoice = $this->Invoice->read(null, $id);

    $this->set(compact('invoice', 'status_list', 'status_log', 'section'));
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function listing_report_print($id = null) {
    $this->layoutOpt['layout'] = 'invoice';

    $this->Invoice->id = $id;
    $this->Invoice->recursive = 1;
    if (!$this->Invoice->exists()) {
      throw new NotFoundException(__('Invalid invoice'));
    }
    App::import('Model', 'InvoiceManager.InvoiceStatus');
    $invoiceStatus = new InvoiceStatus();
    $status_list = $invoiceStatus->find('list', array('fields' => array('id', 'name')));

    App::import('Model', 'InvoiceManager.InvoiceLog');
    $invoiceLog = new InvoiceLog();
    $status_log = $invoiceLog->find('all', array('conditions' => array('invoice_id' => $id)));

    $invoice = $this->Invoice->read(null, $id);

    $reportDate = date('l, F m, Y');
//    debug($invoice);
    $this->set(compact('invoice', 'status_list', 'status_log', 'reportDate'));
  }

}
