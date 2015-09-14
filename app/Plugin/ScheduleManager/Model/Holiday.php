<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * Installer Model
 *
 * 
 */
class Holiday extends ScheduleManagerAppModel {  
  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Installer' => array(
          'className' => 'Installer',
          'foreignKey' => 'type_holidays_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  function beforeSave($options = array()) {
    if (!empty($this->data['Holiday']['holidays_date'])) {
      $this->data['Holiday']['holidays_date'] = date('Y-m-d',  strtotime($this->data['Holiday']['holidays_date']));
    }
    return true;
  }

  public function afterSave($created) {
    parent::afterSave($created);
  }

}
