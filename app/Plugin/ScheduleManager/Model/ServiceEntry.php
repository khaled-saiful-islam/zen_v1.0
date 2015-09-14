<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * ServiceEntry Model
 *
 * 
 */
class ServiceEntry extends ScheduleManagerAppModel {

  //The Associations below have been created with all possible keys, those that are not needed 
  //can be removed
  public $filterArgs = array(
      'work_order_id' => array(
          'type' => 'like'
      ),
  );

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'work_order_id' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      )
  );

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
          'foreignKey' => 'created_by',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  /**
   * hasOne associations
   * 
   * @var array
   */
  public $hasMany = array(
      'ScheduleItem' => array(
          'className' => 'ScheduleItem',
          'foreignKey' => 'schedule_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'ScheduleStatus' => array(
          'className' => 'ScheduleStatus',
          'foreignKey' => 'schedule_id',
          'conditions' => array('AND' => array('ScheduleStatus.type' => 'Service')),
          'fields' => '',
          'order' => ''
      ),
  );

  /**
   * $hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array(
      'Item' => array(
          'className' => 'Item',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'schedule_id',
          'associationForeignKey' => 'item_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
      'Cabinet' => array(
          'className' => 'Cabinet',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'schedule_id',
          'associationForeignKey' => 'cabinet_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
      'Door' => array(
          'className' => 'Door',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'schedule_id',
          'associationForeignKey' => 'door_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
      'PurchaseOrder' => array(
          'className' => 'PurchaseOrder',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'schedule_id',
          'associationForeignKey' => 'purchase_order_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
  );

  function beforeSave($options = array()) {
    if (!empty($this->data['ServiceEntry']['created'])) {
      $this->data['ServiceEntry']['created'] = $this->formatDate($this->data['ServiceEntry']['created']);
    }
    if (!empty($this->data['ServiceEntry']['booked_for'])) {
      $this->data['ServiceEntry']['booked_for'] = $this->formatDate($this->data['ServiceEntry']['booked_for']);
    }
				
		if (!empty($this->data['ServiceEntry']['booked_for']) && !empty($this->data['ServiceEntry']['booking_on_time']) && !empty($this->data['ServiceEntry']['hours'])) {
      $booking_for = trim($this->data['ServiceEntry']['booked_for']);
      $start_time = trim($this->data['ServiceEntry']['booking_on_time']);
      $total_hrs = $this->data['ServiceEntry']['hours'];
      $tmp_total_hrs = explode(':', $total_hrs);

      $this->data['ServiceEntry']['created'] = date('Y-m-d H:i:s', strtotime($booking_for . ' ' . $start_time));
      $this->data['ServiceEntry']['booked_for'] = date('Y-m-d H:i:s', strtotime("+{$tmp_total_hrs[0]} hours {$tmp_total_hrs[1]} minutes", strtotime($this->data['ServiceEntry']['created'])));
    }		
    if (!empty($this->data['ScheduleStatus']['status_date'])) {
      $this->data['ScheduleStatus']['status_date'] = $this->formatDate($this->data['ScheduleStatus']['status_date']);
    }
    if (!empty($this->data['ScheduleStatus']['status']) && $this->data['ScheduleStatus']['status'] == "Completed") {
      $this->data['ServiceEntry']['status'] = "Completed";
      $this->data['ServiceEntry']['resolved_on'] = (!empty($this->data['ScheduleStatus']['status_date'])) ? $this->data['ScheduleStatus']['status_date'] : date('Y-m-d');
    }
//debug($this->data);exit;
    return true;
  }

  public function afterSave($created) {
    parent::afterSave($created);
    if (isset($this->data['ScheduleItem'])) {

      // delete   
      App::uses("ScheduleItem", "ScheduleManager.Model");
      $scheduleItemModel = new ScheduleItem();
      //debug($this->id);
      //debug($this->data['ServiceEntry']['type']);exit;
      $scheduleItemModel->deleteAll(array('ScheduleItem.schedule_id' => $this->id, 'ScheduleItem.type' => $this->data['ServiceEntry']['type']));

      if (is_array($this->data['ScheduleItem'])) {
        // save 
        $scheduleItems = array();
        $index = -1;
        foreach ($this->data['ScheduleItem'] as $scheduleItem) {
          if (trim($scheduleItem['quantity']) == '' || $scheduleItem['quantity'] == 0 || trim($scheduleItem['code']) == '') {
            continue; // skip if no data
          }
          $index++;

          $scheduleItems[$index]['schedule_id'] = $this->id;
          $scheduleItems[$index]['purchase_order_id'] = $scheduleItem['purchase_order_id'];
          $scheduleItems[$index]['code'] = trim($scheduleItem['code']);
          $scheduleItems[$index]['quantity'] = trim($scheduleItem['quantity']);
          $scheduleItems[$index]['reason'] = trim($scheduleItem['reason']);
          $scheduleItems[$index]['type'] = trim($this->data['ServiceEntry']['type']);

          $itemType = explode('|', $scheduleItems[$index]['code']);
          if ($itemType[1] == 'item')
            $scheduleItems[$index]['item_id'] = trim($itemType[0]);
          elseif ($itemType[1] == 'cabinet')
            $scheduleItems[$index]['cabinet_id'] = trim($itemType[0]);
          elseif ($itemType[1] == 'door' || $itemType[1] == 'wall_door' || $itemType[1] == 'drawer')
            $scheduleItems[$index]['door_id'] = trim($itemType[0]);
        }
        if ($index >= 0) {
          $flag = $scheduleItemModel->saveAll($scheduleItems);
        } else {
          return false;
        }
      }
    } elseif (isset($this->data['ScheduleStatus'])) {
      $scheduleItems['schedule_id'] = $this->id;
      $scheduleItems['user_id'] = trim($this->data['ScheduleStatus']['user_id']);
      $scheduleItems['status'] = trim($this->data['ScheduleStatus']['status']);
      $scheduleItems['status_date'] = trim($this->data['ScheduleStatus']['status_date']);
      $scheduleItems['comments'] = trim($this->data['ScheduleStatus']['comment']);
      $scheduleItems['type'] = trim($this->data['ScheduleStatus']['type']);

      $this->ScheduleStatus->save($scheduleItems);
    }
  }

}
