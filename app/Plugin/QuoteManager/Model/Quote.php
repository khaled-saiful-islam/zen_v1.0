<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

// ALTER TABLE  `quotes` ADD  `vid` BIGINT( 20 ) NULL DEFAULT NULL COMMENT  'vid will null for change of version, if there is any new version it will take the parent qoute id' AFTER  `id`
// ALTER TABLE  `quote_statuses` ADD  `quote_vid` BIGINT( 20 ) NULL DEFAULT NULL AFTER  `quote_id`

/**
 * Quote Model
 *
 * @property Builder $Builder
 */
class Quote extends QuoteManagerAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'job_name';
  public $filterArgs = array(
      'customer_id' => array(
          'type' => 'like'
      ),
      'sales_person' => array(
          'type' => 'value'
      ),
      'created_by' => array(
          'type' => 'value'
      ),
      'start_date' => array(
        'type' => '>=',
        'field' => 'Quote.created'
      ),
      'end_date' => array(
        'type' => '<=',
        'field' => 'Quote.created'
      ),
  );

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
//      'est_shipping' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
      'customer_id' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
//      'address' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'city' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'province' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'postal_code' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
      'sales_person' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
//      'cabinet_cost' => array(
//          'It can not be valid cost' => array(
//              'rule' => array('money', 'left'),
//          ),
//      ),
//      'door_cost' => array(
//          'It can not be valid cost' => array(
//              'rule' => array('money', 'left'),
//          ),
//      ),
//      'drawer_cost' => array(
//          'It can not be valid cost' => array(
//              'rule' => array('money', 'left'),
//          ),
//      ),
//      'extra_doors' => array(
//          'It can not be valid cost' => array(
//              'rule' => array('money', 'left'),
//          ),
//      )
  );
//The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Customer' => array(
          'className' => 'CustomerManager.Customer',
          'foreignKey' => 'customer_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'sales_person',
          'dependent' => true,
          'conditions' => ''
      ),
      'UserCreated' => array(
          'className' => 'User',
          'foreignKey' => 'created_by',
          'dependent' => true,
          'conditions' => ''
      ),
			'BuilderProject' => array(
          'className' => 'BuilderProject',
          'foreignKey' => 'project_id',
          'dependent' => true,
          'conditions' => ''
      )
  );

  /**
   * hasOne associations
   *
   * @var array
   */
  public $hasOne = array(
      'WorkOrder' => array(
          'className' => 'WorkOrderManager.WorkOrder',
          'foreignKey' => 'quote_id',
          'dependent' => true,
          //'conditions' => array('QuoteManager.Quote.status'=>'Approve'),
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
      'Invoice' => array(
          'className' => 'Invoice',
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
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'CabinetOrder' => array(
          'className' => 'CabinetOrder',
          'foreignKey' => 'quote_id',
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
      'PurchaseOrder' => array(
          'className' => 'PurchaseOrder',
          'foreignKey' => 'quote_id',
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
      'CabinetOrderItem' => array(
          'className' => 'CabinetOrderItem',
          'foreignKey' => 'quote_id',
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
      'QuoteInstallerPaysheet' => array(
          'className' => 'QuoteInstallerPaysheet',
          'foreignKey' => 'quote_id',
          'dependent' => true,
          'conditions' => ''
      ),
      'QuoteStatus' => array(
          'className' => 'QuoteStatus',
          'foreignKey' => 'quote_id',
          'dependent' => true,
          'conditions' => ''
      ),
      'GraniteOrderItem' => array(
          'className' => 'GraniteOrderItem',
          'foreignKey' => 'quote_id',
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
      'GraniteOrder' => array(
          'className' => 'GraniteOrder',
          'foreignKey' => 'quote_id',
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
//  public $hasAndBelongsToMany = array(
//      'User' => array(
//          'className' => 'User',
//          'joinTable' => ' quote_statuses',
//          'foreignKey' => 'quote_id',
//          'associationForeignKey' => 'user_id',
//          'unique' => 'keepExisting',
//          'conditions' => '',
//          'fields' => '',
//          'order' => '',
//          'limit' => '',
//          'offset' => '',
//          'finderQuery' => '',
//          'deleteQuery' => '',
//          'insertQuery' => ''
//      ),
//  );



  function beforeFind($queryData) {
    parent::beforeFind($queryData);
    $queryData['conditions'] = array('Quote.vid' => null);
  }

  function beforeSave($options = array()) {
    parent::beforeSave($options);

    if (!empty($this->data['Quote']['est_shipping'])) {
			$check_est_date = explode('-', $this->data['Quote']['est_shipping']);
//			pr($check_est_date);exit;
			if(!isset($check_est_date[1])){
				$this->data['Quote']['est_shipping'] = $this->formatDate($this->data['Quote']['est_shipping']);
			}
    }
		if (!empty($this->data['Quote']['first_date_measure'])) {
      $this->data['Quote']['first_date_measure'] = $this->formatDate($this->data['Quote']['first_date_measure']);
    }
		if (!empty($this->data['Quote']['second_date_measure'])) {
      $this->data['Quote']['second_date_measure'] = $this->formatDate($this->data['Quote']['second_date_measure']);
    }
    if (!empty($this->data['QuoteStatus']['status_date'])) {
      $this->data['QuoteStatus']['status_date'] = $this->formatDate($this->data['QuoteStatus']['status_date']);
    }
    if (!empty($this->data['QuoteStatus']['status'])) {
      $this->data['Quote']['status'] = $this->data['QuoteStatus']['status'];
    }
    if (!isset($this->data['Quote']['id'])) {
      $this->data['Quote']['created_by'] = $this->loginUser['id'];
    }

//    cake_debug($this->data['Quote']); exit;
    return true;
  }

  public function afterSave($created) {
    parent::afterSave($created);
//    cake_debug($this->data['Quote']); exit;

    //get source
    App::uses("CabinetOrderItem", "QuoteManager.Model");
    $cabinet_order = new CabinetOrderItem();

    if (isset($this->data['CabinetOrderItem'])) {
      // delete
//      $cabinet_order->deleteAll(array('CabinetOrderItem.quote_id' => $this->id, 'CabinetOrderItem.type' => $this->data['Quote']['type']));
//
//      if (is_array($this->data['CabinetOrderItem'])) {
      // save
//        $couterTopItems = array();
//        $index = -1;
//        foreach ($this->data['CabinetOrderItem'] as $couterTopItem) {
//          if (trim($couterTopItem['quantity']) == '' || $couterTopItem['quantity'] == 0 || trim($couterTopItem['code']) == '') {
//            continue; // skip if no data
//          }
//          $index++;
//
//          $couterTopItems[$index]['quote_id'] = $couterTopItem['quote_id'];
//          $couterTopItems[$index]['used_in'] = isset($couterTopItem['used_in']) ? trim($couterTopItem['used_in']) : "";
//          $couterTopItems[$index]['optional_color'] = isset($couterTopItem['optional_color']) ? trim($couterTopItem['optional_color']) : "";
//          $couterTopItems[$index]['code'] = trim($couterTopItem['code']);
//          $couterTopItems[$index]['quantity'] = trim($couterTopItem['quantity']);
//          $couterTopItems[$index]['order_number'] = trim($couterTopItem['order_number']);
//          $couterTopItems[$index]['type'] = trim($this->data['Quote']['type']);
//
//          $itemType = explode('|', $couterTopItems[$index]['code']);
//          if ($itemType[1] == 'item')
//            $couterTopItems[$index]['item_id'] = trim($itemType[0]);
//          elseif ($itemType[1] == 'cabinet')
//            $couterTopItems[$index]['cabinet_id'] = trim($itemType[0]);
//          elseif ($itemType[1] == 'door' || $itemType[1] == 'wall_door' || $itemType[1] == 'drawer')
//            $couterTopItems[$index]['door_id'] = trim($itemType[0]);
//        }
//        if ($index >= 0) {
//          $flag = $cabinet_order->saveAll($couterTopItems);
//        } else {
//          return false;
//        }
//      }
    } elseif (isset($this->data['QuoteInstallerPaysheet'])) {
      //get source
      $this->QuoteInstallerPaysheet->begin();
      // delete
      $this->QuoteInstallerPaysheet->deleteAll(array('quote_id' => $this->id));

      if (is_array($this->data['QuoteInstallerPaysheet'])) {
        // save
        $couterTopItems = array();
        $index = 0;
        foreach ($this->data['QuoteInstallerPaysheet'] as $couterTopItem) {
          if (trim($couterTopItem['quantity']) == '' || trim($couterTopItem['task_description']) == '' || trim($couterTopItem['unit']) == '' || trim($couterTopItem['price_each']) == '') {
            continue; // skip if no data
          }

          $couterTopItems[$index]['quote_id'] = $couterTopItem['quote_id'];
          $couterTopItems[$index]['quantity'] = trim($couterTopItem['quantity']);
          $couterTopItems[$index]['task_description'] = trim($couterTopItem['task_description']);
          $couterTopItems[$index]['unit'] = trim($couterTopItem['unit']);
          $couterTopItems[$index]['price_each'] = trim($couterTopItem['price_each']);
          $couterTopItems[$index]['total'] = trim($couterTopItem['total']);

          $index++;
        }
        $this->QuoteInstallerPaysheet->saveAll($couterTopItems);
      }
    } elseif (isset($this->data['QuoteStatus'])) {
//      debug($this->data['QuoteStatus']); exit;
      $couterTopItems['quote_id'] = $this->id;
      $couterTopItems['user_id'] = trim($this->data['QuoteStatus']['user_id']);
      $couterTopItems['quote_vid'] = trim($this->data['QuoteStatus']['quote_vid']);
      $couterTopItems['status'] = trim($this->data['QuoteStatus']['status']);
      $couterTopItems['status_date'] = trim($this->data['QuoteStatus']['status_date']);
      $couterTopItems['comments'] = trim($this->data['QuoteStatus']['comment']);

      $this->QuoteStatus->save($couterTopItems);
    }
  }

}
