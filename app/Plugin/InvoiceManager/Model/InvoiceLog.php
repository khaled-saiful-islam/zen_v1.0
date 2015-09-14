<?php

App::uses('InvoiceManagerAppModel', 'InvoiceManager.Model');

/**
 * InvoiceLog Model
 *
 * @property Invoice $Invoice
 * @property InvoiceStatus $InvoiceStatus
 */
class InvoiceLog extends InvoiceManagerAppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Invoice' => array(
          'className' => 'Invoice',
          'foreignKey' => 'invoice_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'InvoiceStatus' => array(
          'className' => 'InvoiceStatus',
          'foreignKey' => 'invoice_status_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'modified_by',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

}
