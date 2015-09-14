<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ColorMaterial Model
 *
 * @property Color $Color
 * @property Material $Material
 * @property ColorMaterial $ColorMaterial
 * @property InventoryLookup $InventoryLookup
 */
class ColorMaterial extends InventoryAppModel {

  /**
   * Validation rules
   *
   * @var array
   */
  public $validate = array(
      'color_id' => array(
          'numeric' => array(
              'rule' => array('numeric'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
      ),
      'material_id' => array(
          'numeric' => array(
              'rule' => array('numeric'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
      ),
      'edgetape_id' => array(
          'numeric' => array(
              'rule' => array('numeric'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
      ),
      'color_section_id' => array(
          'numeric' => array(
              'rule' => array('numeric'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
      ),
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Color' => array(
          'className' => 'Color',
          'foreignKey' => 'color_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'Material' => array(
          'className' => 'Material',
          'foreignKey' => 'material_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'ColorMaterial' => array(
          'className' => 'ColorMaterial',
          'foreignKey' => 'color_section_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'InventoryLookup' => array(
          'className' => 'InventoryLookup',
          'foreignKey' => 'edgetape_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
  );
}
