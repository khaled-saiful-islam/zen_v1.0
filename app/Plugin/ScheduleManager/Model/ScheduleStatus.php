<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * QuoteSatus Model
 *
 */
class ScheduleStatus extends ScheduleManagerAppModel {

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'foreignKey' => 'schedule_id',
          'conditions' => array('AND' => array('ScheduleStatus.type' => 'Service')),
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
      'InstallerSchedule' => array(
          'className' => 'InstallerSchedule',
          'foreignKey' => 'schedule_id',
          'conditions' => array('AND' => array('ScheduleStatus.type' => 'Installer Schedule')),
          'fields' => '',
          'order' => ''
      ),
  );

}
