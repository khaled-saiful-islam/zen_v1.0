<?php

App::uses('WorkOrderManagerAppModel', 'WorkOrderManager.Model');

/**
 * WorkOrder Model
 *
 * @property WorkOrder $WorkOrderType
 */
class WorkOrder extends WorkOrderManagerAppModel {
	
	public $filterArgs = array(
      'work_order_number' => array(
          'type' => 'like'
      ),
			'customer_id' => array(
          'type' => 'like'
      ),
			'sales_rep' => array('type' => 'like', 'encode' => true, 'before' => '%##', 'after' => '##%', 'field' => array('Customer.sales_rape_cache')),
      'email' => array(
          'type' => 'like',
      )
  );
	public $actsAs = array('Search.Searchable');

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Quote' => array(
          'className' => 'QuoteManager.Quote',
          'foreignKey' => 'quote_id',
          //'conditions' => array('QuoteManager.Quote.status'=>'Approve'),
          'fields' => '',
          'order' => ''
      ),
			'Customer' => array(
          'className' => 'CustomerManager.Customer',
          'foreignKey' => 'customer_id',
          'fields' => '',
          'order' => ''
      ),
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'created_by',
          'dependent' => true,
          'conditions' => ''
      ),
  );
  public $hasMany = array(
      'PurchaseOrder' => array(
          'className' => 'PurchaseOrder',
          'foreignKey' => 'work_order_id',
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
      'WorkOrderStatus' => array(
          'className' => 'WorkOrderStatus',
          'foreignKey' => 'work_order_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'foreignKey' => 'work_order_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'InstallerSchedule' => array(
          'className' => 'InstallerSchedule',
          'foreignKey' => 'work_order_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  function beforeSave($options = array()) {
//		pr($this->data);exit;
    if (!empty($this->data['WorkOrderStatus']['status_date'])) {
      $this->data['WorkOrderStatus']['status_date'] = $this->formatDate($this->data['WorkOrderStatus']['status_date']);
    }
    //$this->data['WorkOrder']['work_order_number'] = date('sih');

    if (!isset($this->data['WorkOrder']['id']) && !empty($this->loginUser['id'])) {
      $this->data['WorkOrder']['created_by'] = $this->loginUser['id'];
    } elseif (!isset($this->data['WorkOrder']['id']) && empty($this->loginUser['id'])) {
      $this->data['WorkOrder']['created_by'] = 0;
    }

    return true;
  }

  public function afterSave($created) {
    parent::afterSave($created);
		
    if (isset($this->data['WorkOrderStatus'])) {
      $workOrderStatus['work_order_id'] = $this->id;
      $workOrderStatus['user_id'] = trim($this->data['WorkOrderStatus']['user_id']);
      $workOrderStatus['status_date'] = trim($this->data['WorkOrderStatus']['status_date']);
      $workOrderStatus['status'] = trim($this->data['WorkOrderStatus']['status']);
      $workOrderStatus['comments'] = trim($this->data['WorkOrderStatus']['comment']);

      $this->WorkOrderStatus->save($workOrderStatus);
    }
  }

}
