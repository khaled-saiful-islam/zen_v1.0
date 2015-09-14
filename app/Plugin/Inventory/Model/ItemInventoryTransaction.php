<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Item Model
 *
 * @property Supplier $Supplier
 * @property ItemDepartment $ItemDepartment
 * @property Product $Product
 */
class ItemInventoryTransaction extends InventoryAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'item_id';
  public $name = "ItemInventoryTransaction";

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
      'count' => array(
          'Only numbers allowed' => array(
              'rule' => 'numeric',
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      /*'comment' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),*/
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
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'user_id',
      ),
  );

  function beforeSave($options = array()) {

	if(!isset($this->data['ItemInventoryTransaction']['id'])){
            $this->data['ItemInventoryTransaction']['user_id'] = (int)$this->loginUser['id'];
        }

	return true;
    }

}
