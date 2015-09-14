<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * QuoteReportsSetting Model
 *
 */
class QuoteReportsSetting extends QuoteManagerAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'report_name';
//  public $filterArgs = array(
//      'customer_id' => array(
//          'type' => 'like'
//      ),
//      'sales_person' => array(
//          'type' => 'like'
//      ),
////      'start_date' => array(
////        'type' => '>=',
////        'field' => 'Quote.created'
////      ),
////      'end_date' => array(
////        'type' => '<=',
////        'field' => 'Quote.created'
////      ),
//  );

  /**
   * Validation rules
   *
   * @var array
   */
  public $validate = array(
      'report_name' => array(
          'notempty' => array(
              'rule' => array('notempty'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
          'uuid' => array(
              'rule' => array('uuid'),
              //'message' => 'Your custom message here',
              //'allowEmpty' => false,
              //'required' => false,
              //'last' => false, // Stop validation after this rule
              'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
      ),
      'report_function' => array(
          'notempty' => array(
              'rule' => array('notempty'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
          'uuid' => array(
              'rule' => array('uuid'),
              //'message' => 'Your custom message here',
              //'allowEmpty' => false,
              //'required' => false,
              //'last' => false, // Stop validation after this rule
              'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
      ),
  );

  public function beforeSave($options = array()) {
    parent::beforeSave($options);

    $this->data['QuoteReportsSetting']['departments'] = serialize($this->data['QuoteReportsSetting']['departments']);
  }

}
