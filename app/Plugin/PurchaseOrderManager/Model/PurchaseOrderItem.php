<?php

App::uses('PurchaseOrderManagerAppModel', 'PurchaseOrderManager.Model');

/**
 * PurchaseOrder Model
 *
 * @property PurchaseOrder $PurchaseOrderType
 */
class PurchaseOrderItem extends PurchaseOrderManagerAppModel {

  public $displayField = 'code';

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'PurchaseOrder' => array(
	    'className' => 'PurchaseOrder',
	    'foreignKey' => 'purchase_order_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
    ),
    'Item' => array(
	    'className' => 'Item',
	    'foreignKey' => 'item_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
    ),
    'Cabinet' => array(
	    'className' => 'Cabinet',
	    'foreignKey' => 'cabinet_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
    ),
    'Door' => array(
	    'className' => 'Door',
	    'foreignKey' => 'door_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
    )
);

}
