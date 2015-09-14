<?php

App::uses('CustomerManagerAppModel', 'CustomerManager.Model');

/**
 * AddressType Model
 *
 */
class AddressType extends CustomerManagerAppModel {

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'CustomerAddress' => array(
          'className' => 'CustomerAddress',
          'foreignKey' => 'address_type_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

}
