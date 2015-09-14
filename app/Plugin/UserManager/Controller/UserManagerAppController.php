<?php
App::uses("AppController", "Controller");

class UserManagerAppController extends AppController {
  public $helpers = array('Inventory.InventoryLookup');
  
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['layout'] = $this->request->isAjax() == 1 ? 'ajax' : 'template';
  }
}

