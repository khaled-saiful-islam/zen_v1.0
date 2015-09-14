<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Cabinet Model
 *
 * @property Item $Item
 */
class Cabinet extends InventoryAppModel {

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
      'product_type' => array(
          'type' => 'value'
      ),
      'actual_dimensions_width' => array(
          'type' => 'value'
      ),
      'actual_dimensions_height' => array(
          'type' => 'value'
      ),
      'actual_dimensions_depth' => array(
          'type' => 'value'
      ),
  );

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

  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'name' => array(
          'This item number already exist' => array(
              'rule' => 'isUnique',
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'product_type' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array(
      'Item' => array(
          'className' => 'Item',
          'joinTable' => 'cabinets_items',
          'foreignKey' => 'cabinet_id',
          'associationForeignKey' => 'item_id',
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
          'foreignKey' => 'cabinet_id',
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
      'CabinetInstallation' => array(
          'className' => 'InventoryLookup',
          'joinTable' => 'cabinets_installations',
          'foreignKey' => 'cabinet_id',
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
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'CabinetsItem' => array(
          'className' => 'CabinetsItem',
          'foreignKey' => 'cabinet_id',
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

  public function beforeValidate($options = array()) {
    parent::beforeValidate($options);
    if (isset($this->data['Cabinet']['product_type'])) {
      $this->data['Cabinet']['product_type'] = $this->createSearchCache($this->data['Cabinet']['product_type']);
    }
  }

  public function afterSave($created) {
    parent::afterSave($created);

    if (isset($this->data['CabinetsItem'])) {
      // delete CabinetsItem
      if ($this->data['CabinetsItem'][-1]['accessories'] == 1) {
        $this->CabinetsItem->deleteAll(array('cabinet_id' => $this->id, 'accessories' => '1'));
      } else {
        $this->CabinetsItem->deleteAll(array('cabinet_id' => $this->id, 'accessories' => '0'));
        $this->CabinetsItem->deleteAll(array('cabinet_id' => $this->id, 'accessories' => null));
      }
      //debug($this->data['CabinetsItem']);
      if (is_array($this->data['CabinetsItem'])) {
        // save CabinetsItem
        $cabinetItems = array();
        $index = 0;
        foreach ($this->data['CabinetsItem'] as $index => $cabinetItem) {
          if ($index == '-1') {
            continue; // skip the first entry as it will be invalid
          }

          $cabinetItems[$index]['item_id'] = trim($cabinetItem['item_id']);
          $cabinetItems[$index]['item_quantity'] = trim($cabinetItem['item_quantity']);
          $cabinetItems[$index]['accessories'] = (int) trim($cabinetItem['accessories']);
          $cabinetItems[$index]['cabinet_id'] = $this->id;
          $index++;
        }

        $this->CabinetsItem->saveAll($cabinetItems);
      }
    }


    if (isset($this->data['Cabinet']['CabinetsInstallation'])) {
      // delete CabinetsItem
      $this->CabinetsInstallation->deleteAll(array('cabinet_id' => $this->id));
      //debug($this->data['CabinetsItem']);
      if (is_array($this->data['Cabinet']['CabinetsInstallation'])) {
        // save CabinetsItem
        $cabinetInstallations = array();

        foreach ($this->data['Cabinet']['CabinetsInstallation'] as $index => $cabinetInstallation) {
          if ($index == -1)
            continue; // skip invalid one

          $cabinetInstallation['inventory_lookup_id'] = (int) trim($cabinetInstallation['inventory_lookup_id']);
          $cabinetInstallations[$cabinetInstallation['inventory_lookup_id']]['inventory_lookup_id'] = $cabinetInstallation['inventory_lookup_id'];
          $cabinetInstallations[$cabinetInstallation['inventory_lookup_id']]['cabinet_id'] = $this->id;
        }

        $this->CabinetsInstallation->saveAll($cabinetInstallations);
      }
    }

    //$this->insert_cabinet_to_drupal($this->id); // add to drupal
  }

  function insert_cabinet_to_drupal($cabinet_id) {
    // set HTTP_HOST or drupal will refuse to bootstrap
    $_SERVER['HTTP_HOST'] = 'zl-apps';
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

    include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

    $cabinet = new Cabinet();
    $cabinet_detail = $cabinet->read(null, $cabinet_id);
    $cabinet_nid = null;
    $query = new EntityFieldQuery();
    $entities = $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'cabinet')
            ->propertyCondition('status', 1)
            ->fieldCondition('field_cabinet_id', 'value', $cabinet_detail['Cabinet']['id'], '=')
            ->execute();
    if (!empty($entities)) {
      foreach ($entities['node'] as $nid => $value) {
        $cabinet_nid = $nid;
        break; // no need to loop more even if there is multiple (it is supposed to be unique
      }
    }

    $node = null;
    if (is_null($cabinet_nid)) {
      $node = new stdClass();
      $node->language = LANGUAGE_NONE;
    } else {
      $node = node_load($cabinet_nid);
    }

    $node->type = 'cabinet';
    node_object_prepare($node);

    $node->title = $cabinet_detail['Cabinet']['name'];

    $node->field_cabinet_id[$node->language][0]['value'] = $cabinet_detail['Cabinet']['id'];
    $node->field_product_type_id[$node->language][0]['value'] = $cabinet_detail['Cabinet']['product_type'];
    $node->sell_price = 0;
    $node->model = $cabinet_detail['Cabinet']['name'];
    $node->shippable = 1;

    $path = 'cabinet/' . $node->title;
    $node->path = array('alias' => $path);

    node_save($node);
  }

}
