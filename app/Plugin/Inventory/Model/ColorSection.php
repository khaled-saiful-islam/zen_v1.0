<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * ColorSection Model
 *
 * @property Color $Color
 * @property ColorMaterial $ColorMaterial
 */
class ColorSection extends InventoryAppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'color_id' => array(
            'numeric' => array(
                'rule' => array( 'numeric' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'cost' => array(
            'decimal' => array(
                'rule' => array( 'decimal' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'markup' => array(
            'decimal' => array(
                'rule' => array( 'decimal' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'price' => array(
            'decimal' => array(
                'rule' => array( 'decimal' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'type' => array(
            'notempty' => array(
                'rule' => array( 'notempty' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'edgetape_id' => array(
            'numeric' => array(
                'rule' => array( 'numeric' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notempty' => array(
                'rule' => array( 'notempty' ),
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
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ColorMaterial' => array(
            'className' => 'ColorMaterial',
            'foreignKey' => 'color_section_id',
            'dependent' => false,
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

    function afterSave($created) {
        parent::afterSave($created);
        if( isset($this->data['ColorMaterial'][0]['material_id']) && is_array($this->data['ColorMaterial'][0]['material_id']) ) {
            foreach( $this->data['ColorMaterial'][0]['material_id'] as $index => $material_id ) {
                $colorMaterials[$index]['color_id'] = $this->data['ColorSection']['color_id'];
                $colorMaterials[$index]['material_id'] = $material_id;
                if( !empty($colorSection['edgetape_id']) )
                    $colorMaterials[$index]['edgetape_id'] = $this->data['ColorSection']['edgetape_id'];
                else {
                    unset($colorMaterials[$index]['edgetape_id']);
                }
                $colorMaterials[$index]['color_section_id'] = $this->data['ColorSection']['id'];
            }
            $this->ColorMaterial->saveAll($colorMaterials);
        }
    }

}
