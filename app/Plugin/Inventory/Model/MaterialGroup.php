<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ItemNote Model
 *
 * @property Item $Item
 */
class MaterialGroup extends InventoryAppModel {

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
      'code' => array(
          'type' => 'like'
      )
  );
	public $validate = array(        
        'code' => array(
						'isUnique' => array (
								'rule' => 'isUnique',
								'message' => 'This Code already exists.'
						)
        ),
			'name' => array(
						'isUnique' => array (
								'rule' => 'isUnique',
								'message' => 'This Name already exists.'
						)
        )
  );
}
