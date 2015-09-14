<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * ServiceEntry Model
 *
 * 
 */
class Appointment extends ScheduleManagerAppModel {
  //The Associations below have been created with all possible keys, those that are not needed 
  //can be removed

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
      ),
      'job_name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'booking_on' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'booking_on_time' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'hours' => array(
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
  );

  function beforeSave($options = array()) {
    //debug($this->start_date);
    if (!empty($this->data['Appointment']['booking_on']) && !empty($this->data['Appointment']['booking_on_time']) && !empty($this->data['Appointment']['hours'])) {
      $booking_on = trim($this->data['Appointment']['booking_on']);
      $start_time = trim($this->data['Appointment']['booking_on_time']);
      $total_hrs = $this->data['Appointment']['hours'];
      $tmp_total_hrs = explode(':', $total_hrs);
      //debug($tmp_total_hrs);
      $this->data['Appointment']['start_date'] = date('Y-m-d H:i:s', strtotime($booking_on . ' ' . $start_time));
      //debug(date('Y-m-d H:i:s', strtotime("+{$tmp_total_hrs[0]} hours {$tmp_total_hrs[1]} minutes", strtotime($this->data['Appointment']['start_date']))));
      $this->data['Appointment']['end_date'] = date('Y-m-d H:i:s', strtotime("+{$tmp_total_hrs[0]} hours {$tmp_total_hrs[1]} minutes", strtotime($this->data['Appointment']['start_date'])));
      //$this->data['Appointment']['start_date'] = strtotime($booking_on . ' ' . $start_time);
      //$this->data['Appointment']['end_date'] = strtotime("+{$tmp_total_hrs[0]} hours {$tmp_total_hrs[1]} minutes", strtotime($booking_on . ' ' . $start_time));
    }
    if(!empty($this->data['Appointment']['event_type']) && $this->data['Appointment']['event_type']=="edit" && !empty($this->data['Appointment']['start_date']) && !empty($this->data['Appointment']['end_date'])){
      $this->data['Appointment']['start_date'] = date('Y-m-d H:i:s',strtotime($this->data['Appointment']['start_date']));
      $this->data['Appointment']['end_date'] = date('Y-m-d H:i:s',strtotime($this->data['Appointment']['end_date']));
    }
    //debug($this->data);
    //exit;
    return true;
  }
  public function afterFind($results, $primary = false) {
    parent::afterFind($results, $primary);
    
    foreach ($results as $index=>$result){
      $results[$index]['Appointment']['start_date'] = date('c',strtotime($result['Appointment']['start_date']));
      $results[$index]['Appointment']['end_date'] = date('c',strtotime($result['Appointment']['end_date']));
    }
    //debug($results);
    return $results;
  }
  public function afterSave($created) {
    parent::afterSave($created);
  }

}
