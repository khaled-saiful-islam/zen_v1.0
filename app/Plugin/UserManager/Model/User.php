<?php
App::uses('UserManagerAppModel', 'UserManager.Model');
/**
 * Description of User
 *
 * @author Sarwar hossain
 */
class User extends AppModel {

  //put your code here

  var $name = "User";
	/*public $virtualFields = array(
    'name' => 'CONCAT(User.first_name, " ", User.last_name)'
);*/
  public $filterArgs = array(
      'enhanced_search' => array(
          'type' => 'like',
          'encode' => true,
          'field' => array(
              'User.first_name',
              'User.last_name'),
      ),
      'username' => array(
          'type' => 'like',
      ),
      'title' => array(
          'type' => 'like',
      ),
      'email1' => array(
          'type' => 'like',
      ),
      'role' => array(
          'type' => 'like',
      ),
  );
  
  /**
   * validation
   *
   * @var array
   */
  public $validate = array(
      'first_name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),      
      'last_name' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'empid' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
          'The employee number already exist' => array(
              'rule' => 'isUnique',
          ),
      ),
      'title' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'email1' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
          'The email already exist' => array(
              'rule' => 'isUnique',
          ),
      ),
      'username' => array(
          'Phone number can not be empty' => array(
              'rule' => 'notEmpty',
          ),
          'The phone no already exist' => array(
              'rule' => 'isUnique',
          ),
      ),
      'screetp' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'role' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
      'status' => array(
          'It can not be empty' => array(
              'rule' => 'notEmpty',
          ),
      ),
  );
  public $belongsTo = array(
		'InventoryLookup' => array(
          'className' => 'InventoryLookup',
          'foreignKey' => 'role',
          'dependent' => true,
          'conditions' => ''
      ),
  );
  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
      'QuoteStatus' => array(
          'className' => 'QuoteStatus',
          'foreignKey' => 'user_id',
          'dependent' => true,
          'conditions' => ''
      ),
      'Quote' => array(
          'className' => 'Quote',
          'foreignKey' => 'sales_person',
          'dependent' => true,
          'conditions' => ''
      ),
      'WorkOrder' => array(
          'className' => 'WorkOrder',
          'foreignKey' => 'created_by',
          'dependent' => true,
          'conditions' => ''
      ),
      'QuoteCreated' => array(
          'className' => 'Quote',
          'foreignKey' => 'created_by',
          'dependent' => true,
          'conditions' => ''
      ),
      'WorkOrderStatus' => array(
          'className' => 'WorkOrderStatus',
          'foreignKey' => 'user_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'ServiceEntry' => array(
          'className' => 'ServiceEntry',
          'foreignKey' => 'created_by',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'ScheduleStatus' => array(
          'className' => 'ScheduleStatus',
          'foreignKey' => 'user_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'ItemInventoryTransaction' => array(
          'className' => 'ItemInventoryTransaction',
          'foreignKey' => 'user_id',
      ),
      'InvoiceLog' => array(
          'className' => 'InvoiceLog',
          'foreignKey' => 'modified_by',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
      'PurchaseOrder' => array(
          'className' => 'PurchaseOrder',
          'foreignKey' => 'created_by',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      ),
  );
	public $hasAndBelongsToMany = array(
      'Customer' => array(
          'className' => 'Customer',
          'joinTable' => 'customer_sales_representetives',
          'foreignKey' => 'user_id',
          'associationForeignKey' => 'customer_id'
      )
  );

  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
//  public $hasAndBelongsToMany = array(
//      'Quote' => array(
//          'className' => 'Quote',
//          'joinTable' => ' quote_statuses',
//          'foreignKey' => 'user_id',
//          'associationForeignKey' => 'quote_id',
//          'unique' => 'keepExisting',
//          'conditions' => '',
//          'fields' => '',
//          'order' => '',
//          'limit' => '',
//          'offset' => '',
//          'finderQuery' => '',
//          'deleteQuery' => '',
//          'insertQuery' => ''
//      ),
//  );
  
  public function beforeSave($options = array()) {
    parent::beforeSave($options);
    $this->data['User']['created_by_user_id']=  $this->loginUser['id']; 
    
    //debug($this->data);
    //exit;
    return true;
  }
}

?>
