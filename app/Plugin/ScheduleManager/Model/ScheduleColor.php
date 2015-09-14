<?php

App::uses('ScheduleManagerAppModel', 'ScheduleManager.Model');

/**
 * Installer Model
 *
 * 
 */
class ScheduleColor extends ScheduleManagerAppModel {
	
  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'bgcolor' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );  

  function beforeSave($options = array()) {
    
  }

  public function afterSave($created) {
    parent::afterSave($created);
  }

}
