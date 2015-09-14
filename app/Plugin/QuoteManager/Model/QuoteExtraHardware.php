<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * QuoteExtraHardware Model
 *
 */
class QuoteExtraHardware extends QuoteManagerAppModel {
  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Quote' => array(
          'className' => 'Quote',
          'foreignKey' => 'quote_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
  );

}
