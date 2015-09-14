<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Cabinet Model
 *
 * @property Item $Item
 */
class CabinetsItem extends InventoryAppModel {
//  public $table = 'cabinets_items';
  /**
   * validation
   *
   * @var array
   */
  /* public $validate = array(
    'item_quantity' => array(
    'It can not be empty' => array(
    'rule' => 'notEmpty',
    ),
    ),
    ); */

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
      'Cabinet' => array(
          'className' => 'Cabinet',
          'foreignKey' => 'cabinet_id',
      ),
  );

}
