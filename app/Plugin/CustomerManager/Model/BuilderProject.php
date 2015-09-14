<?php

App::uses('CustomerManagerAppModel', 'CustomerManager.Model');

/**
 * CustomerAddress Model
 *
 * @property BuilderProject $BuilderProject
 * @property Customer $Customer
 */
class BuilderProject extends CustomerManagerAppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'project_name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      ),
      'site_address' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      ),
			'contact_person' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      ),
			'contact_person_phone' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          )
      )
  );

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Customer' => array(
          'className' => 'Customer',
          'foreignKey' => 'customer_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );
	
	public $hasMany = array(
      'Quote' => array(
          'className' => 'QuoteManager.Quote',
          'foreignKey' => 'project_id',
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

    if (!isset($this->data['BuilderProject']['id'])) {
      $this->data['BuilderProject']['created_by_id'] = $this->loginUser['id'];
    }
    return true;
  }
}
