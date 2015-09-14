<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * SupplierContact Model
 *
 * @property Supplier $Supplier
 * @property AddressType $AddressType
 */
class SupplierContact extends InventoryAppModel {

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
      'address' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'city' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'province' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'postal_code' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'country' => array(
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
      'Supplier' => array(
          'className' => 'Supplier',
          'foreignKey' => 'supplier_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'AddressType' => array(
          'className' => 'AddressType',
          'foreignKey' => 'address_type_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
  );

}
