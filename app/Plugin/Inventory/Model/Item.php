<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Item Model
 *
 * @property Supplier $Supplier
 * @property ItemDepartment $ItemDepartment
 * @property Cabinet $Cabinet
 */
class Item extends InventoryAppModel {

  /**
   * virtual field
   *
   * @var array
   */
  public $virtualFields = array(
      'id_plus_item' => 'CONCAT(Item.id, "|", "item")'
  );

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'number';
  public $filterArgs = array(
      'number' => array(
          'type' => 'value'
      ),
      'item_title' => array(
          'type' => 'like'
      ),
      'supplier_id' => array(
          'type' => 'value'
      ),
      'item_department_id' => array(
          'type' => 'value'
      ),
      'width' => array(
          'type' => 'value'
      ),
      'length' => array(
          'type' => 'value'
      ),
      'item_material_group' => array(
          'type' => 'value'
      )
  );

  /**
   * validation
   *
   * @var array
   */
//  public $validate = array(
//      'number' => array(
//          'This item number already exist' => array(
//              'rule' => 'isUnique',
//          ),
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'item_title' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'width' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'length' => array(
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'item_cost' => array(
//          'Only numbers allowed' => array(
//              'rule' => 'numeric',
//          ),
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'factor' => array(
//          'Only numbers allowed' => array(
//              'rule' => 'numeric',
//          ),
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'price' => array(
//          'Only numbers allowed' => array(
//              'rule' => 'numeric',
//          ),
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'current_stock' => array(
//          'Only numbers allowed' => array(
//              'rule' => 'numeric',
//          ),
//          'It can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//      'item_department_id' => array(
//          'Desciption can not be empty' => array(
//              'rule' => 'notEmpty',
//          ),
//      ),
//  );

  /**
   * file upload configuration
   * @var array
   */
  public $actsAs = array(
      'Upload.Upload' => array(
          'image' => array(
              'fields' => array(
                  'dir' => 'image_dir'
              ),
              'thumbnailSizes' => array(
                  'xvga' => '1024x768',
                  'vga' => '640x480',
                  'thumb' => '80x80'
              ),
              'thumbnailMethod' => 'php',
          ),
      )
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Supplier' => array(
          'className' => 'Supplier',
          'foreignKey' => 'supplier_id',
      ),
      'ItemDepartment' => array(
          'className' => 'ItemDepartment',
          'foreignKey' => 'item_department_id',
          'conditions' => array('AND' => array('ItemDepartment.active' => '1')),
      )
  );

  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array(
      'Cabinet' => array(
          'className' => 'Cabinet',
          'joinTable' => 'cabinets_items',
          'foreignKey' => 'item_id',
          'associationForeignKey' => 'cabinet_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
      'ItemOption' => array(
          'className' => 'InventoryLookup',
          'joinTable' => 'items_options',
          'foreignKey' => 'item_id',
          'associationForeignKey' => 'inventory_lookup_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'item_id',
          'associationForeignKey' => 'schedule_id',
          'unique' => 'keepExisting',
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
      ),
  );
  var $hasOne = array("ItemAdditionalDetail");

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'ItemNote' => array(
          'className' => 'ItemNote',
          'foreignKey' => 'item_id',
          'dependent' => true,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
      'ItemInventoryTransaction' => array(
          'className' => 'ItemInventoryTransaction',
          'foreignKey' => 'item_id',
          'dependent' => true,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
      ),
  );

  public function beforeFind($queryData) {
    parent::beforeFind($queryData);
    if (!isset($queryData['conditions'])) {
      $queryData['conditions'] = array();
    }
    $queryData['conditions']['Item.delete'] = '0';
    return $queryData;
  }

  public function beforeValidate($options = array()) {
    parent::beforeValidate($options);

    if (!$this->id) {
      if (isset($this->data['Item']['base_item'])) {
        $item = $this->data;
        $this->read(null, $this->data['Item']['base_item']);
        array_merge($this->data['Item'], $item['Item']);
        $item['Item']['item_group'] = $this->data['Item']['item_group'];
        $this->data = $item;
      }

      App::import('Model', 'Inventory.InventoryLookup');
      $inventorylookup = new InventoryLookup();
      $number = $inventorylookup->find("first", array("conditions" => array("InventoryLookup.id" => $this->data['Item']['item_group'])));

      $items = $this->find('first', array('limit' => 1, 'order' => array('Item.id DESC')));
      $item_id = $items['Item']['id'] + 1;
			
      $number['InventoryLookup']['num'] = str_pad($item_id, 6, '0', STR_PAD_LEFT);
			if($this->data['Item']['base_item'] != 0)
				$this->data['Item']['number'] = $number['InventoryLookup']['value'] . $number['InventoryLookup']['num'];
    }
  }

//  public function afterSave($created) {
//    parent::afterSave($created);
//
//    if (!isset($this->data['Item']['base_item']) || !$this->data['Item']['base_item']) {
//      $this->insert_item_to_drupal($this->id); // add to drupal (base item only)
//    }
//
//    if (isset($this->data['Item']['delete'])) {
//      return;
//    }
//
//    if (isset($this->data['ItemNote']) && is_array($this->data['ItemNote'])) {
//
//      // get current item notes
//      $validItemNote = $this->ItemNote->find('list', array('conditions' => array('item_id' => $this->id)));
//      $newItemNoteID = array();  // list of new array
//      // save/update ItemNote
//      foreach ($this->data['ItemNote'] as $itemNote) {
//        $itemNote['name'] = trim($itemNote['name']);
//        $itemNote['value'] = trim($itemNote['value']);
//        $itemNote['item_id'] = $this->id;
//
//        if (isset($itemNote['id']) && !empty($itemNote['id'])) {
//          $itemNote['id'] = trim($itemNote['id']);
//
//          if (!isset($validItemNote[$itemNote['id']])) {
//            // attempt of hacking detected... DO NOT SAVE THIS RECORD SET
//            // RUN AWAY... NEED TO NOTIFY ;(
//            continue;
//          } else {
//            $validItemNote[$itemNote['id']] = $itemNote['id']; // change it to compare with new list
//          }
//        } else {
//          $itemNote['id'] = null; // new id
//        }
//
//        if (empty($itemNote['name']) && (empty($itemNote['value']))) {
//          if (empty($itemNote['id'])) {
//            continue; //skip blank record set
//          } else {
//            $this->ItemNote->delete($itemNote['id']);  // delete if it has id but no data
//            continue;
//          }
//        }
//
//        $this->ItemNote->save($itemNote);
//        $newItemNoteID[$this->ItemNote->id] = $this->ItemNote->id;
//      }
//
//      // check for remove the old item notes
//      if (!empty($validItemNote)) {
//        $removedItemNoteID = array();
//        foreach ($validItemNote as $key => $value) {
//          if (!isset($newItemNoteID[$key])) {
//            $removedItemNoteID[$key] = $key;
//          }
//        }
//
//        // delete if it has deleted from front end
//        if (!empty($removedItemNoteID)) {
//          $this->ItemNote->delete($removedItemNoteID);
//        }
//      }
//    }
//  }

  function insert_item_to_drupal($item_id) {
    // set HTTP_HOST or drupal will refuse to bootstrap
    $_SERVER['HTTP_HOST'] = 'zl-apps';
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

    include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

    $item = new Item();
    $item_detail = $item->read(null, $item_id);
    $item_nid = null;
    $query = new EntityFieldQuery();
    $entities = $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'items')
            ->propertyCondition('status', 1)
            ->fieldCondition('field_item_id', 'value', $item_detail['Item']['id'], '=')
            ->execute();
    if (!empty($entities)) {
      foreach ($entities['node'] as $nid => $value) {
        $item_nid = $nid;
        break; // no need to loop more even if there is multiple (it is supposed to be unique
      }
    }

    $node = null;
    if (is_null($item_nid)) {
      $node = new stdClass();
      $node->language = LANGUAGE_NONE;
    } else {
      $node = node_load($item_nid);
    }

    $node->type = 'items';
    node_object_prepare($node);

    $node->title = $item_detail['Item']['item_title'];

    $node->field_item_id[$node->language][0]['value'] = $item_detail['Item']['id'];
    $node->field_item_number[$node->language][0]['value'] = $item_detail['Item']['number'];
    $node->field_item_group[$node->language][0]['value'] = $item_detail['Item']['item_group'];
    $node->field_item_width[$node->language][0]['value'] = $item_detail['Item']['width'];
    $node->field_item_length[$node->language][0]['value'] = $item_detail['Item']['length'];
    $node->field_item_price[$node->language][0]['value'] = $item_detail['Item']['price'];
    $node->field_item_description[$node->language][0]['value'] = $item_detail['Item']['description'];
    $node->sell_price = $item_detail['Item']['price'];
    $node->model = $item_detail['Item']['number'];
    $node->shippable = 1;

    $path = 'item/' . $node->title;
    $node->path = array('alias' => $path);

    node_save($node);
  }

}
