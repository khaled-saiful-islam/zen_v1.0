<?php

App::uses('CustomerManagerAppModel', 'CustomerManager.Model');

/**
 * BuilderAccount Model
 *
 */
class BuilderAccount extends CustomerManagerAppModel {

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Customer' => array(
          'className' => 'Customer',
          'foreignKey' => 'customer_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'inventory_lookups' => array(
          'className' => 'CustomerType',
          'foreignKey' => 'builder_type',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  public $hasAndBelongsToMany = array(
      'BuilderSupplyType' => array(
          'className' => 'Inventory.InventoryLookup',
          'joinTable' => 'builder_supply_types_list',
          'foreignKey' => 'builder_account_id',
          'associationForeignKey' => 'inventory_lookup_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
  );

}
