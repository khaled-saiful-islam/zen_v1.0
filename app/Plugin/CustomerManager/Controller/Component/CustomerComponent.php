<?php

App::uses('Component', 'Controller');

class CustomerComponent extends Component {

  public function listAddresses($ref_id, $ref_type) {
    App::uses("Address", "Model");
    $address = new Address();
    return $address->find("all", array('conditions' => array('id !=' => $current_item_id)));
  }

}
