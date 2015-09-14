<?php

App::uses('ContainerManagerAppModel', 'ContainerManager.Model');

/**
 * SkidInventory Model
 *
 */
class SkidInventory extends ContainerManagerAppModel {

  /**
   * belongsTo associations
   *
   * @var array
   */
	public $filterArgs = array(
			'skid_no' => array(
          'type' => 'like'
      ),
			'weight' => array(
          'type' => 'like'
      )
  );
	public $actsAs = array('Search.Searchable');

}
