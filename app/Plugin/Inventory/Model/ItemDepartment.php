<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ItemDepartment Model
 *
 * @property Item $Item
 */
class ItemDepartment extends InventoryAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';
  public $filterArgs = array(
      'name' => array('type' => 'like'),
      'instruction' => array('type' => 'like'),
      'qb_item_ref' => array('type' => 'like'),
      'stock_number_required' => array('type' => 'like'),
      'supplier_required' => array('type' => 'like'),
      'active' => array('type' => 'like'),
  );

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'name' => array(
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
          'foreignKey' => 'item_department_id',
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

  public function beforeFind($queryData) {
    parent::beforeFind($queryData);
    if (!isset($queryData['conditions'])) {
      $queryData['conditions'] = array();
    }
    $queryData['conditions']['ItemDepartment.delete'] = '0';
    return $queryData;
  }

}
