<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LookupHelper extends AppHelper {

	var $Lookup;

	function __construct() {
		App::uses("CustomerLookup", "Model");

		$this->CustomerLookup = new CustomerLookup();
	}

	function CustomerLookup($type) {
		return $this->CustomerLookup->find("list", array( "fields" => array( "id", "name" ), "conditions" => array( "CustomerLookup.type" => $type ) ));
	}

	function Status() {
		App::uses("WorkStatus", "Model");
		$workStatus = new WorkStatus();
		return $workStatus->find("list", array( "fields" => array( "id", "status" ) ));
	}

	function Customer() {
		App::uses("Customer", "Model");
		$customer = new Customer();
		return $customer->find("list", array( "fields" => array( "id", "first_name" ) ));
	}

	function DoorStyle() {
		App::uses("DoorStyle", "Model");
		$doorstyle = new DoorStyle();
		return $doorstyle->find("list", array( "fields" => array( "id", "door_style" ) ));
	}

	function Supplier() {
		App::uses("Supplier", "Model");
		$supplier = new Supplier();
		return $supplier->find("list", array( "fields" => array( "id", "name" ) ));
	}

	function ItemDepartment() {
		App::uses("ItemDepartment", "Model");
		$itemDepartment = new ItemDepartment();
		return $itemDepartment->find("list", array( "fields" => array( "id", "name" ) ));
	}

	function getSalesRepresentatives() {
		App::uses("User", "Model");
		$user = new User();
		return $user->find("list", array( "fields" => array( "id", "name" ),"conditions" => array( "User.role" => 96 ) ));
	}

}

?>
