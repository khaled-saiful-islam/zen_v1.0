<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * CabinetOrder Model
 *
 * @property Quote $Quote
 * @property CabinetOrderItem $graniteOrderItem
 */
class GraniteOrder extends QuoteManagerAppModel {

  //The Associations below have been created with all possible keys, those that are not needed can be removed
  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      
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

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'GraniteOrderItem' => array(
          'className' => 'GraniteOrderItem',
          'foreignKey' => 'granite_order_id',
          'dependent' => true,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      )
  );

  public function afterSave($created) {
    parent::afterSave($created);    
//    debug($this->data);exit;
    if (isset($this->data['GraniteOrderItem'])) {
      // delete CabinetOrderItem      
      $this->GraniteOrderItem->deleteAll(array('granite_order_id' => $this->id));

      if (is_array($this->data['GraniteOrderItem'])) {
        // save CabinetOrderItem
        $graniteOrderItems = array();
        $index = 0;
        foreach ($this->data['GraniteOrderItem'] as $graniteOrderItem) {
          if (trim($graniteOrderItem['quantity']) == '' || trim($graniteOrderItem['code']) == '' ) {
            continue; // skip if no data
          }
          $graniteOrderItems[$index]['granite_order_id'] = $this->id;
          $graniteOrderItems[$index]['quote_id'] = $this->data['GraniteOrder']['quote_id'];
          $graniteOrderItems[$index]['item_id'] = trim($graniteOrderItem['item_id']);
          $graniteOrderItems[$index]['cabinet_id'] = trim($graniteOrderItem['cabinet_id']);
          $graniteOrderItems[$index]['door_id'] = trim($graniteOrderItem['door_id']);          
          $graniteOrderItems[$index]['quantity'] = trim($graniteOrderItem['quantity']);
          $graniteOrderItems[$index]['created_by'] = $this->loginUser['id'];;
          $graniteOrderItems[$index]['code'] = trim($graniteOrderItem['code']);
          
          $index++;
        }

        $this->GraniteOrderItem->saveAll($graniteOrderItems);
      }
    }
  }

}
