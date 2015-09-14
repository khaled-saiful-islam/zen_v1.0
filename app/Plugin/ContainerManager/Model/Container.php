<?php

App::uses('ContainerManagerAppModel', 'ContainerManager.Model');

/**
 * Container Model
 *
 * @property Container $ContainerType
 */
class Container extends ContainerManagerAppModel {
	
	public $filterArgs = array(
			'ship_company' => array(
          'type' => 'like'
      ),
			'container_no' => array(
          'type' => 'like'
      ),
			'skid_count' => array(
          'type' => 'like'
      ),
			'total_weight' => array(
          'type' => 'like'
      )

  );
	public $actsAs = array('Search.Searchable');

  public $hasMany = array(
      'ContainerSkid' => array(
          'className' => 'ContainerSkid',
          'foreignKey' => 'container_id',
          'dependent' => true,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      )
  );

  function beforeSave($options = array()) {
    if (!empty($this->data['Container']['ship_date'])) {
      $this->data['Container']['ship_date'] = $this->formatDate($this->data['Container']['ship_date']);
    }
		if (!empty($this->data['Container']['ead'])) {
      $this->data['Container']['ead'] = $this->formatDate($this->data['Container']['ead']);
    }
		if (!empty($this->data['Container']['received_date'])) {
      $this->data['Container']['received_date'] = $this->formatDate($this->data['Container']['received_date']);
    }

    if (!isset($this->data['Container']['id']) && !empty($this->loginUser['id'])) {
      $this->data['Container']['created_by_id'] = $this->loginUser['id'];
    } elseif (!isset($this->data['Container']['id']) && empty($this->loginUser['id'])) {
      $this->data['Container']['created_by_id'] = 0;
    }

    return true;
  }

}
