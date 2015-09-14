<?php

App::uses('CustomerManagerAppModel', 'CustomerManager.Model');

/**
 * CustomerAddress Model
 *
 * @property AddressType $AddressType
 * @property Customer $Customer
 */
class CustomerSalesRepresentetives extends CustomerManagerAppModel {

  //The Associations below have been created with all possible keys, those that are not needed can be removed
  var $actsAs = array('Containable');

  /**
   * belongsTo associations
   *
   * @var array
   */
//  var $hasAndBelongsToMany = array('Customer');

}
