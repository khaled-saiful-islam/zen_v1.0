<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ItemNote Model
 *
 * @property Item $Item
 */
class ItemNote extends InventoryAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'item_id' => array(
          'Only numbers allowed' => array(
              'rule' => 'numeric',
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'value' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Item' => array(
          'className' => 'Item',
          'foreignKey' => 'item_id',
      ),
  );

}
