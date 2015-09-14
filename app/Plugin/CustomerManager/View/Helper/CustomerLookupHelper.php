<?php

App::uses('AppHelper', 'View/Helper');

class CustomerLookupHelper extends AppHelper {

  function getSalesRepresentatives() {
    App::uses("User", "UserManager.Model");
    $user = new User();
    return $user->find("list", array("fields" => array("id", "first_name"), "conditions" => array("User.role" => 96)));
  }

  function showSalesRepresentatives($id) {
    App::uses("User", "UserManager.Model");
    $user = new User();
    return $user->find("first", array("conditions" => array("User.id" => $id)));
  }

  function getBuilderSupplyTypes() {
    App::uses("BuilderSupplyType", "CustomerManager.Model");
    $builder_supply_type = new BuilderSupplyType();
    return $builder_supply_type->find("list", array("fields" => array("id", "name")));
  }

  function showBuilderSupplyTypes($id) {
    App::uses("BuilderSupplyType", "CustomerManager.Model");
    $builder_supply_type = new BuilderSupplyType();
    return $builder_supply_type->find("first", array("conditions" => array("BuilderSupplyType.id" => $id)));
  }

}
