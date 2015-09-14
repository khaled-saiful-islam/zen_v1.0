<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ItemAdditionDetail Model
 *
 * @property Item $Item
 */
class ItemAdditionalDetail extends InventoryAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';
	
	public $belongsTo = array(
      'Item' => array(
          'className' => 'Item',
          'foreignKey' => 'item_id',
      ),
  );
}
