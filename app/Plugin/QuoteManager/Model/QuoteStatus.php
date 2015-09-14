<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * QuoteSatus Model
 *
 */
class QuoteStatus extends QuoteManagerAppModel {

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
      ),
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'user_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );
}
