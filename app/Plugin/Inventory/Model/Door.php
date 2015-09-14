<?php

App::uses('InventoryAppModel', 'Inventory.Model');

/**
 * Door Model
 *
 * @property Supplier $Supplier
 */
class Door extends InventoryAppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'door_style';
  public $filterArgs = array(
      'door_style' => array(
          'type' => 'like'
      ),
      'supplier_id' => array(
          'type' => 'like'
      ),
      'wood_species' => array(
          'type' => 'like'
      ),
      'product_line' => array(
          'type' => 'like'
      ),
  );

  /**
   * file upload configuration
   * @var array
   */
  public $actsAs = array(
      'Upload.Upload' => array(
          'outside_profile_image' => array(
              'fields' => array(
                  'dir' => 'outside_profile_image_dir'
              ),
              'thumbnailSizes' => array(
                  'xvga' => '1024x768',
                  'vga' => '640x480',
                  'thumb' => '80x80'
              ),
              'thumbnailMethod' => 'php',
          ),
          'inside_profile_image' => array(
              'fields' => array(
                  'dir' => 'inside_profile_image_dir'
              ),
              'thumbnailSizes' => array(
                  'xvga' => '1024x768',
                  'vga' => '640x480',
                  'thumb' => '80x80'
              ),
              'thumbnailMethod' => 'php',
          ),
          'door_image' => array(
              'fields' => array(
                  'dir' => 'door_image_dir'
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
      'door_style' => array(
          'This door style already exist' => array(
              'rule' => 'isUnique',
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'code' => array(
          'This door code already exist' => array(
              'rule' => 'isUnique',
          ),
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'wood_species' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'cab_outside_profile' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
          /* 'wall_door_price_each' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'door_price' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'door_price_each' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'drawer_price' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'drawer_price_each' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'lower_drawer_price' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'lower_drawer_price_each' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            ),
            'door_code' => array(
            'This door style already exist' => array(
            'rule' => 'isUnique',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'wall_door_code' => array(
            'This door style already exist' => array(
            'rule' => 'isUnique',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_code' => array(
            'This door style already exist' => array(
            'rule' => 'isUnique',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'lower_drawer_code' => array(
            'This door style already exist' => array(
            'rule' => 'isUnique',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'door_rail_width' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'door_rail_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'door_stile_width' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'door_stile_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'door_panel_width_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'door_panel_height_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_rail_width' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_rail_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_stile_width' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_stile_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_panel_width_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'drawer_panel_height_offset' => array(
            'Only numbers allowed' => array(
            'rule' => 'numeric',
            ),
            'It can not be empty' => array(
            'rule' => 'notEmpty',
            ),
            ),
            'outside_profile_image' => array(
            'File exceeds upload filesize limit' => array(
            'rule' => 'isUnderPhpSizeLimit',
            ),
            ),
            'inside_profile_image' => array(
            'File exceeds upload filesize limit' => array(
            'rule' => 'isUnderPhpSizeLimit',
            ),
            ),
            'door_image' => array(
            'File exceeds upload filesize limit' => array(
            'rule' => 'isUnderPhpSizeLimit',
            ),
            ), */
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
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'InventoryLookup' => array(
          'className' => 'InventoryLookup',
          'foreignKey' => 'wood_species',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );

  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array(
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'joinTable' => 'schedule_items',
          'foreignKey' => 'door_id',
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

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
  );

  function afterSave($created) {
    parent::afterSave($created);

    //$this->insert_door_to_drupal($this->id); // add to drupal
  }

  function insert_door_to_drupal($door_id) {
    // set HTTP_HOST or drupal will refuse to bootstrap
    $_SERVER['HTTP_HOST'] = 'zl-apps';
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

    include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

    $door = new Door();
    $door_detail = $door->read(null, $door_id);
    $door_nid = null;
    $query = new EntityFieldQuery();
    $entities = $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'doors')
            ->propertyCondition('status', 1)
            ->fieldCondition('field_door_id', 'value', $door_detail['Door']['id'], '=')
            ->execute();
    foreach ($entities['node'] as $nid => $value) {
      $door_nid = $nid;
      break; // no need to loop more even if there is multiple (it is supposed to be unique
    }

    $node = null;
    if (is_null($door_nid)) {
      $node = new stdClass();
      $node->language = LANGUAGE_NONE;
    } else {
      $node = node_load($door_nid);
    }

    $node->type = 'doors';
    node_object_prepare($node);

    $node->title = $door_detail['Door']['door_style'];

    $node->field_door_id[$node->language][0]['value'] = $door_detail['Door']['id'];
    $node->sell_price = 0;
    $node->model = $door_detail['Door']['door_style'];
    $node->shippable = 1;

    $path = 'door/' . $node->title;
    $node->path = array('alias' => $path);

    node_save($node);
  }

}
