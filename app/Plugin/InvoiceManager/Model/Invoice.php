<?php

App::uses('InvoiceManagerAppModel', 'InvoiceManager.Model');

/**
 * Invoice Model
 *
 * @property InvoiceStatus $InvoiceStatus
 * @property InvoiceLog $InvoiceLog
 */
class Invoice extends InvoiceManagerAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'invoice_no';

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'InvoiceStatus' => array(
          'className' => 'InvoiceStatus',
          'foreignKey' => 'invoice_status_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Quote' => array(
          'className' => 'Quote',
          'foreignKey' => 'ref_id',
          'dependent' => true,
          'conditions' => array('invoice_of' => 'Quote'),
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
      'PurchaseOrder' => array(
          'className' => 'PurchaseOrder',
          'foreignKey' => 'ref_id',
          'dependent' => true,
          'conditions' => array('invoice_of' => 'Purchase Order'),
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'InvoiceLog' => array(
          'className' => 'InvoiceLog',
          'foreignKey' => 'invoice_id',
          'dependent' => false,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
  );

  function beforeSave($options = array()) {
    parent::beforeSave($options);

    if (!isset($this->data['Invoice']['created_by'])) {
      $this->data['Invoice']['created_by'] = $this->loginUser['id'];
    }
    if (!isset($this->data['Invoice']['modified_by'])) {
      $this->data['Invoice']['modified_by'] = $this->loginUser['id'];
    }
    
    if (!empty($this->data['InvoiceLog']['invoice_status_id'])) {
      $this->data['Invoice']['invoice_status_id'] = $this->data['InvoiceLog']['invoice_status_id'];
    }
//    debug($this->data);
//    exit;
  }
  function afterSave($created) {
    parent::afterSave($created);
    
    if (isset($this->data['InvoiceLog'])) {
      $invoiceLog = array();
      $invoiceLog['invoice_id'] = $this->id;
      $invoiceLog['invoice_status_id'] = $this->data['InvoiceLog']['invoice_status_id'];
      $invoiceLog['modified_by'] = $this->loginUser['id'];
      $invoiceLog['comments'] = isset($this->data['InvoiceLog']["comments"])?$this->data['InvoiceLog']["comments"]:"";
      $invoiceLog['status_date'] = date('Y-m-d');

      $this->InvoiceLog->save($invoiceLog);
    }
  }
}
