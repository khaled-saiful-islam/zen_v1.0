<?php

App::uses('CustomerManagerAppModel', 'CustomerManager.Model');

/**
 * Customer Model
 *
 * @property CustomerType $CustomerType
 * @property SalesRepresentetive $SalesRepresentetive
 */
class Customer extends CustomerManagerAppModel {

  //The Associations below have been created with all possible keys, those that are not needed
  //can be removed
  public $filterArgs = array(
      'enhanced_search' => array(
          'type' => 'like',
          'encode' => true,
          'field' => array(
              'Customer.first_name',
              'Customer.last_name'),
      ),
//      'sales_rep' => array(
//          'type' => 'like',
//          'encode' => true,
//          'field' => array('User.name'),
//      ),
//      'sales_rep' => array('type' => 'like', 'field' => array('SalesRepresentetive.id')),
//      'sales_rep' => array('type' => 'subquery', 'method' => 'findBySalesRepresentetive', 'field' => 'Customer.id'),
      'sales_rep' => array('type' => 'like', 'encode' => true, 'before' => '%##', 'after' => '##%', 'field' => array('Customer.sales_rape_cache')),
      'email' => array(
          'type' => 'like',
      ),
      'customer_type_id' => array(
          'type' => 'like',
      ),
      'status' => array(
          'type' => 'like',
      ),
      'phone' => array(
          'type' => 'like',
      ),
      'cell' => array(
          'type' => 'like',
      ),
      'fax' => array(
          'type' => 'like',
      ),
      'city' => array(
          'type' => 'like',
      ),
  );
//  public $presetVars = array(
//      array('field' => 'sales_rep', 'type' => 'checkbox', 'model' => 'UserManager.User'),
//  );
  public $actsAs = array('Search.Searchable');

  /**
   * virtual field
   *
   * @var array
   */
  public $virtualFields = array(
      'name' => 'CONCAT(Customer.last_name, ", ", Customer.first_name)'
  );

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'first_name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'last_name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'customer_type_id' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'status' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'phone' => array(
          'Phone number can not be empty' => array(
              'rule' => 'notEmpty',
          ),
          'The phone no already exist' => array(
              'rule' => 'isUnique',
          ),
      ),
  );

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'CustomerType' => array(
          'className' => 'CustomerType',
          'foreignKey' => 'customer_type_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'inventory_lookups' => array(
          'className' => 'CustomerType',
          'foreignKey' => 'referral',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  /**
   * hasOne associations
   *
   * @var array
   */
  public $hasOne = array(
      'BuilderAccount' => array(
          'className' => 'BuilderAccount',
          'foreignKey' => 'customer_id',
          'conditions' => ''
      ),
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'CustomerSalesRepresentetives' => array(
          'className' => 'SalesRepresentetive',
          'foreignKey' => 'customer_id',
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
      'CustomerAddress' => array(
          'className' => 'CustomerAddress',
          'foreignKey' => 'customer_id',
          'dependent' => false,
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
      'Quote' => array(
          'className' => 'QuoteManager.Quote',
          'foreignKey' => 'customer_id',
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
			'BuilderProject' => array(
          'className' => 'CustomerManager.BuilderProject',
          'foreignKey' => 'customer_id',
          'dependent' => false,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      )
  );
  public $hasAndBelongsToMany = array(
      'User' => array(
          'className' => 'UserManager.User',
          'joinTable' => 'customer_sales_representetives',
          'foreignKey' => 'customer_id',
          'associationForeignKey' => 'user_id'
      )
  );

  public function beforeFind($queryData) {
    parent::beforeFind($queryData);
//    debug($queryData);
//    debug($_REQUEST);
//    exit;
    if (!isset($queryData['conditions'])) {
      $queryData['conditions'] = array();
    }

//    if (!isset($queryData['conditions']['Customer.customer_type_id'])) {
//      $queryData['conditions']['Customer.customer_type_id'] = '1';
//    }
    $queryData['conditions']['Customer.delete'] = '0';
    return $queryData;
  }

  public function afterSave($created) {
    parent::afterSave($created);

    if (isset($this->data['Customer']['customer_type_id']) && (@$this->data['Customer']['customer_type_id'] == 2 || @$this->data['Customer']['customer_type_id'] == 3)) {
      if (!empty($this->data['BuilderAccount']['effective_date'])) {
        $this->data['BuilderAccount']['effective_date'] = $this->formatDate($this->data['BuilderAccount']['effective_date']);
      }
      $this->data['BuilderAccount']['customer_id'] = $this->id;
      $this->BuilderAccount->deleteAll(array('BuilderAccount.customer_id' => $this->id));
      $this->BuilderAccount->save($this->data['BuilderAccount']);
    } else {
      $this->BuilderAccount->deleteAll(array('BuilderAccount.customer_id' => $this->id));
    }
  }

  public function beforeSave($options = array()) {
    parent::beforeSave($options);
    $this->data['Customer']['sales_rape_cache'] = '';

		if(isset($this->data['Customer']['sales_representatives'])){
			if (is_array($this->data['Customer']['sales_representatives']) && !empty($this->data['Customer']['sales_representatives'])) {
				$this->data['Customer']['sales_rape_cache'] = $this->createSearchCache($this->data['Customer']['sales_representatives']);
				$this->data['Customer']['sales_representatives'] = serialize($this->data['Customer']['sales_representatives']);
			}
		}
		if(isset($this->data['Customer']['sales_representative'])){
			if (is_array($this->data['Customer']['sales_representative']) && !empty($this->data['Customer']['sales_representative'])) {
				$this->data['Customer']['sales_rape_cache'] = $this->createSearchCache($this->data['Customer']['sales_representative']);
				$this->data['Customer']['sales_representatives'] = serialize($this->data['Customer']['sales_representative']);
			}
		}

    return true;
  }

}
