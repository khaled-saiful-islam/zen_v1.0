<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ItemNote Model
 *
 * @property Item $Item
 */
class Material extends InventoryAppModel {

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
      ),
      'material_group_id' => array(
          'type' => 'like'
      ),
      'width' => array(
          'type' => 'like'
      ),
      'length' => array(
          'type' => 'like'
      ),
      'cost' => array(
          'type' => 'like'
      )
  );
  public $validate = array(
      'code' => array(
          'isUnique' => array(
              'rule' => 'isUnique',
              'message' => 'This Code already exists.'
          )
      ),
      'name' => array(
          'isUnique' => array(
              'rule' => 'isUnique',
              'message' => 'This Name already exists.'
          )
      )
  );

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'MaterialGroup' => array(
          'className' => 'MaterialGroup',
          'foreignKey' => 'material_group_id',
      ),
  );

}
