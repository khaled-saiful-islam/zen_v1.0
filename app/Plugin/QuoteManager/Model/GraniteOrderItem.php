<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * CabinetOrderItem Model
 *
 * @property CabinetOrder $CabinetOrder
 * @property Item $Item
 * @property Cabinet $Cabinet
 * @property Door $Door
 */
class GraniteOrderItem extends QuoteManagerAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'code';

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'GraniteOrder' => array(
          'className' => 'GraniteOrder',
          'foreignKey' => 'granite_order_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Item' => array(
          'className' => 'Item',
          'foreignKey' => 'item_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Cabinet' => array(
          'className' => 'Cabinet',
          'foreignKey' => 'cabinet_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Door' => array(
          'className' => 'Door',
          'foreignKey' => 'door_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Quote' => array(
          'className' => 'Quote',
          'foreignKey' => 'quote_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

}
