<?php

App::uses('CustomerManagerAppModel', 'CustomerManager.Model');

/**
 * CustomerAddress Model
 *
 * @property AddressType $AddressType
 * @property Customer $Customer
 */
class CustomerAddress extends CustomerManagerAppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

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
      'address_type_id' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'AddressType' => array(
          'className' => 'AddressType',
          'foreignKey' => 'address_type_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Customer' => array(
          'className' => 'Customer',
          'foreignKey' => 'customer_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

}
