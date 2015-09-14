<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * InventoryLookup Model
 *
 * @property Item $Item
 */
class InventoryLookup extends InventoryAppModel {

  private $type_config = array(
      'name' => array(
          'label' => null,
          'unique' => true,
          'hidden' => false,
      ),
      'lookup_type' => array(
          'label' => null,
          'unique' => false,
          'hidden' => false,
      ),
      'value' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
      ),
      'price' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
      ),
      'parent_lookup' => array(
          'label' => null,
          'unique' => false,
          'hidden' => true,
          'required' => false,
      ),
  ); // default type config

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';
  public $filterArgs = array(
      'name' => array(
          'type' => 'like'
      ),
      'lookup_type' => array(
          'type' => 'like'
      ),
      'value' => array(
          'type' => 'like'
      ),
  );

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'name' => array(
          'It is already exist' => array(
              'rule' => array('uniqueName', 'lookup_type'),
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'lookup_type' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );
  public $hasMany = array(
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'role',
          'dependent' => true,
          'conditions' => ''
      ),
  );

  public function beforeFind($queryData) {
    parent::beforeFind($queryData);
    if (!isset($queryData['conditions'])) {
      $queryData['conditions'] = array();
    }
    $queryData['conditions']['InventoryLookup.delete'] = '0';
    return $queryData;
  }

  public function beforeValidate($options = array()) {
    parent::beforeValidate($options);

    //get type config
    if (isset($this->data['type_config'])) {
      $this->type_config = array_merge($this->type_config, $this->data['type_config']);
      unset($this->data['type_config']);
    }
    // check for price as required
    if ($this->type_config['price']['required']) {
      $this->validate['price']['It can not be empty'] = array(
          'rule' => 'notEmpty'
      );
    }

    // check for parent_lookup as required
    if ($this->type_config['parent_lookup']['required']) {
      $this->validate['parent_lookup']['It can not be empty'] = array(
          'rule' => 'notEmpty'
      );
    }

    // check for value as required
    if ($this->type_config['value']['required']) {
      $this->validate['value']['It can not be empty'] = array(
          'rule' => 'notEmpty'
      );
    }

    // check for value as unique
    if ($this->type_config['value']['unique']) {
      //debug($this->id);exit;
      $this->validate['value']['It is already exist'] = array(
          'rule' => array('uniqueValue', 'lookup_type'),
      );
    }

    $this->data['InventoryLookup']['department_id'] = $this->createSearchCache($this->data['InventoryLookup']['department_id']);
  }

  public function uniqueValue($value, $lookup_type) {
    $count = $this->find('count', array(
        'conditions' => array(
            'value' => $value,
            'lookup_type' => $this->data[$this->alias]['lookup_type'],
            'id <>' => $this->id)
            ));
    return $count == 0;
  }

  public function uniqueName($name, $lookup_type) {
    $count = $this->find('count', array(
        'conditions' => array(
            'name' => $name,
            'lookup_type' => $this->data[$this->alias]['lookup_type'],
            'id <>' => $this->id)
            ));
    return $count == 0;
  }

  function checkUnique($data, $fields) {
// check if the param contains multiple columns or a single one
    if (!is_array($fields)) {
      $fields = array($fields);
    }

// go trough all columns and get their values from the parameters
    foreach ($fields as $key) {
      $unique[$key] = $this->data[$this->name][$key];
    }

// primary key value must be different from the posted value
    if (isset($this->data[$this->name][$this->primaryKey])) {
      $unique[$this->primaryKey] = "<>" . $this->data[$this->name][$this->primaryKey];
    }

// use the model's isUnique function to check the unique rule
    return $this->isUnique($unique, false);
  }

}
