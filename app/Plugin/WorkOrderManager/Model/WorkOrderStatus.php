<?php

App::uses('WorkOrderManagerAppModel', 'WorkOrderManager.Model');

/**
 * QuoteSatus Model
 *
 */
class WorkOrderStatus extends WorkOrderManagerAppModel {

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'WorkOrder' => array(
          'className' => 'WorkOrder',
          'foreignKey' => 'work_order_id',
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
