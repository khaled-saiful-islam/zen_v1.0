<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Supplier Model
 *
 * @property Item $Item
 */
class Supplier extends InventoryAppModel {

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
      'email' => array(
        'type' => 'like',
      ),
      'phone' => array(
        'type' => 'like',
      ),
      'cell' => array(
        'type' => 'like',
      ),
      'gst_rate' => array(
        'type' => 'like',
      ),
      'pst_rate' => array(
        'type' => 'like',
      ),
      'supplier_type' => array('type' => 'like', 'encode' => true, 'before' => '%"', 'after' => '"%', 'field' => array('Supplier.supplier_type')),
  );

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'email' => array(
          'This item number already exist' => array(
              'rule' => 'isUnique',
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'Item' => array(
          'className' => 'Item',
          'foreignKey' => 'supplier_id',
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
      'SupplierContact' => array(
          'className' => 'SupplierContact',
          'foreignKey' => 'supplier_id',
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
          'foreignKey' => 'supplier_id',
          'dependent' => true,
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

  public function beforeSave($options = array()) {
    parent::beforeSave($options);

    if (is_array($this->data['Supplier']['supplier_type']) && !empty($this->data['Supplier']['supplier_type'])) {
      $this->data['Supplier']['supplier_type'] = serialize($this->data['Supplier']['supplier_type']);
    } else {
      $this->data['Supplier']['supplier_type'] = '';
    }

    if (is_array($this->data['Supplier']['employee_rep']) && !empty($this->data['Supplier']['employee_rep'])) {
      $this->data['Supplier']['employee_rep'] = serialize($this->data['Supplier']['employee_rep']);
    } else {
      $this->data['Supplier']['employee_rep'] = '';
    }

    return true;
  }

}
