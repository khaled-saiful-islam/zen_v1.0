<?php

App::uses('ContainerManagerAppModel', 'ContainerManager.Model');

/**
 * ContainerSkid Model
 *
 */
class ContainerSkid extends ContainerManagerAppModel {

  /**
   * belongsTo associations
   *
   * @var array
   */
	public $belongsTo = array(
			'Container' => array(
          'className' => 'Container',
          'foreignKey' => 'container_id',
          'dependent' => true,
          'conditions' => ''
      )
  );
}
