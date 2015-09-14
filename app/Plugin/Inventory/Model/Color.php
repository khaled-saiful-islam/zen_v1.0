<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Color Model
 *
 * @property ColorMaterial $ColorMaterial
 * @property ColorSection $ColorSection
 */
class Color extends InventoryAppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $filterArgs = array(
        'name' => array(
            'type' => 'like'
        ),
        'code' => array(
            'type' => 'like'
        ),
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'It can not be empty' => array(
                'rule' => array( 'notempty' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'This color already exist' => array(
                'rule' => array( 'isUnique' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'code' => array(
            'This color code already exist' => array(
                'rule' => array( 'isUnique' ),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'It can not be empty' => array(
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ColorMaterial' => array(
            'className' => 'ColorMaterial',
            'foreignKey' => 'color_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ColorSection' => array(
            'className' => 'ColorSection',
            'foreignKey' => 'color_id',
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

    function beforeSave($options = array( )) {
        parent::beforeSave($options);
    }

    function afterSave($created) {
        parent::afterSave($created);
        if( isset($this->data['ColorSection']) && is_array($this->data['ColorSection']) ) {
            // delete previous items
            $this->ColorSection->deleteAll(array( 'color_id' => $this->id ));
            $this->ColorMaterial->deleteAll(array( 'color_id' => $this->id ));

            App::uses('ColorSection', 'Inventory.Model');
            foreach( $this->data['ColorSection'] as $index => $colorSection ) {
                $colorSection['price'] = $colorSection['cost'] * $colorSection['markup'];
                $colorSection['type'] = ($index == 0) ? 'cabinate_material' : 'door_material';
                if( $colorSection['price'] > 0 ) {
                    $colorSections[$index]['id'] = null;
                    $colorSections[$index]['color_id'] = $this->id;
                    $colorSections[$index]['cost'] = $colorSection['cost'];
                    $colorSections[$index]['markup'] = $colorSection['markup'];
                    $colorSections[$index]['price'] = $colorSection['cost'] * $colorSection['markup'];
                    if( !empty($colorSection['edgetape_id']) )
                        $colorSections[$index]['edgetape_id'] = $colorSection['edgetape_id'];
                    else {
                        unset($colorSections[$index]['edgetape_id']);
                    }
                    $colorSections[$index]['type'] = ($index == 0) ? 'cabinate_material' : 'door_material';
                    $colorSections[$index]['ColorMaterial'] = $colorSection['ColorMaterial'];
                }
                $color = new ColorSection();
                $color->save($colorSections[$index]);
            }//pr($colorSections[$index]);exit;
        }
    }

}
