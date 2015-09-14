<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * InstallerSchedule Model
 *
 * 
 */
class InstallerSchedule extends ScheduleManagerAppModel {
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
      'name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'start_install' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'number_of_days' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'installer_id' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
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
      'Installer' => array(
          'className' => 'Installer',
          'foreignKey' => 'installer_id',
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
      'ScheduleStatus' => array(
          'className' => 'ScheduleStatus',
          'foreignKey' => 'schedule_id',
          'conditions' => array('AND' => array('ScheduleStatus.type' => 'Installer Schedule')),
          'fields' => '',
          'order' => ''
      ),
  );
  
  function beforeSave($options = array()) {    
    if(!empty($this->data['InstallerSchedule']['start_install'])){
      $this->data['InstallerSchedule']['start_install'] = $this->formatDate($this->data['InstallerSchedule']['start_install']);      
    }
    if (!empty($this->data['ScheduleStatus']['status_date'])) {
      $this->data['ScheduleStatus']['status_date'] = $this->formatDate($this->data['ScheduleStatus']['status_date']);
    }
    if (!empty($this->data['ScheduleStatus']['status']) && $this->data['ScheduleStatus']['status'] == "Installed") {
      $this->data['InstallerSchedule']['status'] = "Installed";
    }
    return true;
  }

  public function afterSave($created) {
    parent::afterSave($created);
    if (isset($this->data['ScheduleStatus'])) {
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
