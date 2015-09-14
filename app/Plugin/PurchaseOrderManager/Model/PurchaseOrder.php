<?php

App::uses('PurchaseOrderManagerAppModel', 'PurchaseOrderManager.Model');

/**
 * PurchaseOrder Model
 *
 * @property PurchaseOrder $PurchaseOrderType
 */
class PurchaseOrder extends PurchaseOrderManagerAppModel {

  public $displayField = 'name';
  public $filterArgs = array(
      'quote_number' => array(
          'type' => 'like',
          'field' => array(
              'Quote.quote_number',),
      ),
      'work_order_number' => array(
          'type' => 'like',
          'field' => array(
              'WorkOrder.work_order_number',),
      ),
			'purchase_order_num' => array(
          'type' => 'like',
      ),
			'supplier_id' => array(
          'type' => 'like',
      ),
			'issued_by' => array(
          'type' => 'like',
      ),
      'received' => array(
          'type' => 'like',
          'field' => array(
              'PurchaseOrder.received')
      )
  );
  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'supplier_id' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      ),
      'shipment_date' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      ),
      'payment_type' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      ),
//      'name_cc' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          )
//      ),
//      'cc_num' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          )
//      ),
//      'expiry_date' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          )
//      ),
  );

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Supplier' => array(
          'className' => 'Supplier',
          'foreignKey' => 'supplier_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Quote' => array(
          'className' => 'Quote',
          'foreignKey' => 'quote_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'WorkOrder' => array(
          'className' => 'WorkOrder',
          'foreignKey' => 'work_order_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'created_by',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  public $hasOne = array(
      'Invoice' => array(
          'className' => 'Invoice',
          'foreignKey' => 'ref_id',
          'dependent' => true,
          'conditions' => array('invoice_of'=>'Purchase Order'),
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
  );
  public $hasMany = array(
      'PurchaseOrderItem' => array(
          'className' => 'PurchaseOrderItem',
          'foreignKey' => 'purchase_order_id',
          'dependent' => true,
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

  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array(
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'purchase_order_id',
          'associationForeignKey' => 'schedule_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
  );

  function beforeSave($options = array()) {
        if(!isset($this->data['PurchaseOrder']['id'])){
            $this->data['PurchaseOrder']['created_by'] = $this->loginUser['id'];
        }

         if(!empty($this->data['PurchaseOrder']['shipment_date'])){
						$check_shipping_date = explode('-', $this->data['PurchaseOrder']['shipment_date']);
						if(!isset($check_shipping_date[1])){
							$this->data['PurchaseOrder']['shipment_date'] = $this->formatDate($this->data['PurchaseOrder']['shipment_date']);
						}
        }
				if(!empty($this->data['PurchaseOrder']['expiry_date'])){
            $this->data['PurchaseOrder']['expiry_date'] = $this->formatDate($this->data['PurchaseOrder']['expiry_date']);
        }
				if(!empty($this->data['PurchaseOrder']['issued_on'])){
            $this->data['PurchaseOrder']['issued_on'] = $this->formatDate($this->data['PurchaseOrder']['issued_on']);
        }

        return true;
    }

  public function afterSave($created) {
    parent::afterSave($created);
    if (isset($this->data['PurchaseOrderItem'])) {
      // delete CabinetOrderItem
      $this->PurchaseOrderItem->deleteAll(array('purchase_order_id' => $this->id));

      if (is_array($this->data['PurchaseOrderItem'])) {
        // save CabinetOrderItem
        $purchaseOrderItems = array();
        $index = 0;
        foreach ($this->data['PurchaseOrderItem'] as $purchaseOrderItem) {
          if (trim($purchaseOrderItem['quantity']) == '' || trim($purchaseOrderItem['code']) == '') {
            continue; // skip if no data
          }
          $purchaseOrderItems[$index]['purchase_order_id'] = $this->id;
          $purchaseOrderItems[$index]['item_id'] = trim($purchaseOrderItem['item_id']);
          $purchaseOrderItems[$index]['quantity'] = trim($purchaseOrderItem['quantity']);
          $purchaseOrderItems[$index]['code'] = trim($purchaseOrderItem['code']);
          $purchaseOrderItems[$index]['cabinet_id'] = trim($purchaseOrderItem['cabinet_id']);
          $purchaseOrderItems[$index]['door_id'] = trim($purchaseOrderItem['door_id']);

          $index++;
        }
	//pr($purchaseOrderItems);exit;
        $this->PurchaseOrderItem->saveAll($purchaseOrderItems);
      }
    }
  }
}
