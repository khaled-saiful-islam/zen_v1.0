<?php
App::uses('UserManagerAppModel', 'UserManager.Model');
/**
 * Description of User
 *
 * @author Sarwar hossain
 */
class BuilderSupplyType extends CustomerManagerAppModel {

  //put your code here

  var $name = "BuilderSupplyType";

	public $hasAndBelongsToMany = array(
      'BuilderAccount' => array(
          'className' => 'BuilderAccount',
          'joinTable' => 'builder_supply_types_list',
          'foreignKey' => 'builder_supply_type_id',
          'associationForeignKey' => 'builder_account_id'
      )
  );
}

?>
