<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * QuoteGlassDoorShelf Model
 *
 */
class QuoteGlassDoorShelf extends QuoteManagerAppModel {
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
