<?php

App::uses('QuoteManagerAppModel', 'QuoteManager.Model');

/**
 * CabinetOrder Model
 *
 * @property Quote $Quote
 * @property CabinetOrderItem $CabinetOrderItem
 */
class CabinetOrder extends QuoteManagerAppModel {

  //The Associations below have been created with all possible keys, those that are not needed can be removed
  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'door_species' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'door_style' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'drawer_slides' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'delivery' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
          /*
            'rush_order' => array(
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'delivery_cost' => array(
            'It can not be empty' => array(
            'rule' => 'numeric',
            ),
            ),
            'extras_glass' => array(
            'It can not be empty' => array(
            'rule' => 'numeric',
            ),
            ),
            'counter_top' => array(
            'It can not be empty' => array(
            'rule' => 'numeric',
            ),
            ),
            'installation' => array(
            'It can not be empty' => array(
            'rule' => 'numeric',
            ),
            ),
            'discount' => array(
            'It can not be empty' => array(
            'rule' => 'numeric',
            ),
            ), */
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
      'CabinetOrderItem' => array(
          'className' => 'CabinetOrderItem',
          'foreignKey' => 'cabinet_order_id',
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

    if (isset($this->data['CabinetOrder']['resource_type']) && ($this->data['CabinetOrder']['resource_type'] == 'cabinet')) {
      App::import('Model', 'Inventory.Cabinet');
      $cabinet_model = new Cabinet();
      $cabinet_model->recursive = 1;
      $cabinet_detail = $cabinet_model->find('first', array('conditions' => array('Cabinet.id' => $this->data['CabinetOrder']['resource_id'])));
      if (!empty($cabinet_detail['CabinetsItem']) && is_array($cabinet_detail['CabinetsItem'])) {
        foreach ($cabinet_detail['CabinetsItem'] as $key => $cabinet_item) {
          $this->data['CabinetOrderItem'][$key] = array(
              'cabinet_order_id' => $this->data['CabinetOrder']['id'],
              'quote_id' => $this->data['CabinetOrder']['quote_id'],
              'cabinet_id' => $this->data['CabinetOrder']['resource_id'],
              'quantity' => $this->data['CabinetOrder']['quantity'] * $cabinet_item['item_quantity'],
              'item_id' => $cabinet_item['item_id'],
              'code' => "{$cabinet_item['item_id']}|item",
              'type' => 'Cabinet Order',
          );
        }
      }
    }

    if (isset($this->data['CabinetOrderItem'])) {
      // delete CabinetOrderItem
      $this->CabinetOrderItem->deleteAll(array('cabinet_order_id' => $this->id));

      if (is_array($this->data['CabinetOrderItem'])) {
        // save CabinetOrderItem
//        $cabinetOrderItems = array();
//        $index = 0;
//        foreach ($this->data['CabinetOrderItem'] as $cabinetOrderItem) {
//          if (trim($cabinetOrderItem['quantity']) == '' || trim($cabinetOrderItem['code']) == '') {
//            continue; // skip if no data
//          }
//          $cabinetOrderItems[$index]['cabinet_order_id'] = $this->id;
//          $cabinetOrderItems[$index]['item_id'] = trim($cabinetOrderItem['item_id']);
//          $cabinetOrderItems[$index]['cabinet_id'] = trim($cabinetOrderItem['cabinet_id']);
////          $cabinetOrderItems[$index]['door_id'] = trim($cabinetOrderItem['door_id']);
////          $cabinetOrderItems[$index]['door_information'] = trim($cabinetOrderItem['door_information']);
////          $cabinetOrderItems[$index]['open_frame_door'] = trim($cabinetOrderItem['open_frame_door']);
////          $cabinetOrderItems[$index]['do_not_drill_door'] = trim($cabinetOrderItem['do_not_drill_door']);
////          $cabinetOrderItems[$index]['no_doors'] = trim($cabinetOrderItem['no_doors']);
//          $cabinetOrderItems[$index]['quantity'] = trim($cabinetOrderItem['quantity']);
//          $cabinetOrderItems[$index]['code'] = trim($cabinetOrderItem['code']);
//          $cabinetOrderItems[$index]['type'] = "Cabinet Order";
//
//          $index++;
//        }

        $this->CabinetOrderItem->saveAll($this->data['CabinetOrderItem']);
      }
    }
  }

}
