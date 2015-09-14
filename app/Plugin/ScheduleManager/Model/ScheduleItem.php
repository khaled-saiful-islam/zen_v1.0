<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * ScheduleItem Model
 *
 *
 */
class ScheduleItem extends ScheduleManagerAppModel {

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
  /*public $belongsTo = array(
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'foreignKey' => 'schedule_id',
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
      'PurchaseOrder' => array(
          'className' => 'PurchaseOrder',
          'foreignKey' => 'purchase_order_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );*/

}
