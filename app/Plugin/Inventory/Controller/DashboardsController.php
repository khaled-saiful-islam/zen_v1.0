<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Dashboards Controller
 * 
 */
class DashboardsController extends InventoryAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();
  }

  public function index() {
    App::import('Model', 'QuoteManager.Quote');
    $quoteModel = new Quote();
    $quoteDataList = $quoteModel->find('all',array('fields'=>array('quote_number','status'),'conditions'=>array('Quote.vid'=>null, 'Quote.created_by' => $this->loginUser['id'])));
    
    App::import('Model', 'WorkOrderManager.WorkOrder');
    $workOrderModel = new WorkOrder();
    $workOrderDataList = $workOrderModel->find('all',array('fields'=>array('work_order_number','status'),'conditions'=>array('WorkOrder.created_by' => $this->loginUser['id'])));
    
    App::import('Model', 'PurchaseOrderManager.PurchaseOrder');
    $purchaseOrderModel = new PurchaseOrder();
    $purchaseOrderDataList = $purchaseOrderModel->find('all',array('fields'=>array('purchase_order_num','received'), 'conditions'=>array('PurchaseOrder.created_by' => $this->loginUser['id'])));
    
    $this->set(compact('quoteDataList','workOrderDataList','purchaseOrderDataList'));
  }

}