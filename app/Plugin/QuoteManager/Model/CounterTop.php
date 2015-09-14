<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * CounterTop Model
 *
 */
class CounterTop extends QuoteManagerAppModel {

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'quantity' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );

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
