<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * Installer Model
 *
 * 
 */
class Installer extends ScheduleManagerAppModel {
  //The Associations below have been created with all possible keys, those that are not needed 
  //can be removed
  public $filterArgs = array(
      'id' => array(
          'type' => 'like'
      ),
      'phone' => array(
          'type' => 'like'
      ),
      'pager' => array(
          'type' => 'like'
      ),
      'cell' => array(
          'type' => 'like'
      ),
      'rating' => array(
          'type' => 'like'
      ),
  );
  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'name_lookup_id' => array(
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
      'InventoryLookup' => array(
          'className' => 'InventoryLookup',
          'foreignKey' => 'name_lookup_id',
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
      'Holiday' => array(
          'className' => 'Holiday',
          'foreignKey' => 'type_holidays_id',
          'conditions' => array('AND' => array('Holiday.type' => 'Installer')),
          'fields' => '',
          'order' => ''
      ),
      'InstallerSchedule' => array(
          'className' => 'InstallerSchedule',
          'foreignKey' => 'installer_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  function beforeSave($options = array()) {
    
  }

  public function afterSave($created) {
    parent::afterSave($created);
  }

}
