<?php

class ContainerManagerAppController extends AppController {
    
    public $helpers = array('Inventory.InventoryLookup');
  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['layout'] = $this->request->isAjax() == 1 ? 'ajax' : 'template';
  }

}

