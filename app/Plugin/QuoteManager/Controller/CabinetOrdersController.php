<?php

App::uses('QuoteManagerAppController', 'QuoteManager.Controller');

/**
 * CabinetOrders Controller
 *
 * @property CabinetOrder $CabinetOrder
 */
class CabinetOrdersController extends QuoteManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "quote-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_quote";
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->CabinetOrder->recursive = 0;
    $this->set('cabinetOrders', $this->paginate());
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->CabinetOrder->id = $id;
    if (!$this->CabinetOrder->exists()) {
      throw new NotFoundException(__('Invalid cabinet order'));
    }
    $this->set('cabinetOrder', $this->CabinetOrder->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function save_quote_cabinets($quote_id) {
    if(isset($this->data['reset']) && ($this->data['reset'] == 'Reset')) {
      $this->reset_quote_cabinets($quote_id);
      return;
    }
		//pr($this->request->data);exit;
    App::import("Controller", "QuoteManager.Quotes");
    $quote_controller = new QuotesController();
    $quote_controller->create_history($quote_id);

    $quote_cabinets = array();

    App::import("Model", "QuoteManager.Quote");
    $quote_model = new Quote();
    $quote = $quote_model->read(null, $quote_id);

    $drawer = $this->request['data']['Global']['drawer'];
    $drawer_slide = $this->request['data']['Global']['drawer_slide'];
    $delivery = $this->request['data']['Global']['delivery'];
    $installation = $this->request['data']['Global']['installation'];
		$is_interior_melamine = $this->request['data']['Global']['is_interior_melamine'];


    $quote['Quote']['drawer'] = $drawer;
    $quote['Quote']['drawer_slide'] = $drawer_slide;
    $quote['Quote']['delivery'] = $delivery;
    $quote['Quote']['installation'] = $installation;
		$quote['Quote']['is_interior_melamine'] = $is_interior_melamine;

    $quote_model->save($quote, false);

    $this->CabinetOrder->deleteAll(array('quote_id' => $quote_id));
    if (isset($this->request['data']['CabinetOrder']) && is_array($this->request['data']['CabinetOrder']) && !empty($this->request['data']['CabinetOrder'])) {
      foreach ($this->request['data']['CabinetOrder'] as $cabinet) {
				
//        cake_debug($this->request['data']['CabinetOrder']);exit;
//        cake_debug($cabinet);exit;
        if($cabinet['temporary_delete']) {
          continue; // skip the deleted one
        }
        if($cabinet['temporary']) {
          $cabinet['temporary'] = 0;
        }
        $cabinet['quote_id'] = $quote_id;

        switch ($cabinet['resource_type']) {
          case 'cabinet':
            $resource_id = $cabinet['resource_id'];
//            $resource_type = $cabinet['resource_type'];
            $cabinet_color = $cabinet['cabinet_color'];
            $material_id = $cabinet['material_id'];
						$door_side = $cabinet['door_side'];
            $door_id = $cabinet['door_id'];
            $door_color = $cabinet['door_color'];
            $quantity = $cabinet['quantity'];
            $calculateCabinetPrice = $this->PriceCalculation->calculateCabinetPrice($resource_id, $cabinet_color, $material_id, $door_id, $door_color, $drawer, $drawer_slide, $quantity);

            $quote_cabinets[] = $cabinet + array(
                'quote_id' => $quote_id,
                'total_cost' => $calculateCabinetPrice['total_price'],
                'cost_calculation' => $calculateCabinetPrice['debug_calculation'],
            );
            break;
          case 'custom_panel':
          case 'custom_door':
            $cabinet['resource_id'] = '0';
            $quote_cabinets[] = $cabinet;
            break;
          default:
            $quote_cabinets[] = $cabinet;
            break;
        }
      }
      $this->CabinetOrder->saveAll($quote_cabinets);
    }
    $this->redirect(FULL_BASE_URL . $this->webroot . 'quote_manager/quotes/detail/' . $quote_id . '#quote-detail');
  }

  /**
   * add method
   *
   * @return void
   */
  public function reset_quote_cabinets($quote_id) {
    $quote_cabinets = array();

    App::import("Model", "QuoteManager.Quote");
    $quote_model = new Quote();
    $quote = $quote_model->read(null, $quote_id);

    $drawer = $this->request['data']['Global']['drawer'];
    $drawer_slide = $this->request['data']['Global']['drawer_slide'];
    $delivery = $this->request['data']['Global']['delivery'];
    $installation = $this->request['data']['Global']['installation'];
		$is_interior_melamine = $this->request['data']['Global']['is_interior_melamine'];

    $quote['Quote']['drawer'] = $drawer;
    $quote['Quote']['drawer_slide'] = $drawer_slide;
    $quote['Quote']['delivery'] = $delivery;
    $quote['Quote']['installation'] = $installation;
		$quote['Quote']['is_interior_melamine'] = $is_interior_melamine;

    $quote_model->save($quote);

    $this->CabinetOrder->deleteAll(array('quote_id' => $quote_id));
    if (isset($this->request['data']['CabinetOrder']) && is_array($this->request['data']['CabinetOrder']) && !empty($this->request['data']['CabinetOrder'])) {
      foreach ($this->request['data']['CabinetOrder'] as $cabinet) {
        if($cabinet['temporary']) {
          continue; // skip the not saved one
        }
        if($cabinet['temporary_delete']) {
          unset($cabinet['temporary_delete']);
        }
        $cabinet['quote_id'] = $quote_id;

        switch ($cabinet['resource_type']) {
          case 'cabinet':
            $resource_id = $cabinet['resource_id'];
//            $resource_type = $cabinet['resource_type'];
            $cabinet_color = $cabinet['cabinet_color'];
            $material_id = $cabinet['material_id'];
            $door_id = $cabinet['door_id'];
            $door_color = $cabinet['door_color'];
            $quote_cabinets[] = $cabinet + array(
                'quote_id' => $quote_id,
            );
            break;
          case 'custom_panel':
          case 'custom_door':
            $cabinet['resource_id'] = '0';
            $quote_cabinets[] = $cabinet;
            break;
          default:
            $quote_cabinets[] = $cabinet;
            break;
        }
      }

      $this->CabinetOrder->saveAll($quote_cabinets);
    }
    $this->redirect(FULL_BASE_URL . $this->webroot . 'quote_manager/quotes/detail/' . $quote_id . '#quote-detail');
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if ($this->request->is('post')) {
      $this->CabinetOrder->create();
      if ($this->CabinetOrder->save($this->request->data)) {
        $this->Session->setFlash(__('The cabinet order has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The cabinet order could not be saved. Please, try again.'));
      }
    }
    $pog = $this->CabinetOrder->find('list', array('fields' => 'pog'));
    $edgetape = $this->CabinetOrder->find('list', array('fields' => 'edgetape'));
    $stain_color = $this->CabinetOrder->find('list', array('fields' => 'stain_color'));
    $drawers = $this->CabinetOrder->find('list', array('fields' => 'drawers'));
    $quotes = $this->CabinetOrder->Quote->find('list');
    $this->set(compact('quotes', 'pog', 'edgetape', 'stain_color', 'drawers'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->CabinetOrder->id = $id;
    if (!$this->CabinetOrder->exists()) {
      throw new NotFoundException(__('Invalid cabinet order'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->CabinetOrder->save($this->request->data)) {
        $this->Session->setFlash(__('The cabinet order has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The cabinet order could not be saved. Please, try again.'));
      }
    }
    $pog = $this->CabinetOrder->find('list', array('fields' => 'pog'));
    $edgetape = $this->CabinetOrder->find('list', array('fields' => 'edgetape'));
    $stain_color = $this->CabinetOrder->find('list', array('fields' => 'stain_color'));
    $drawers = $this->CabinetOrder->find('list', array('fields' => 'drawers'));
    $this->request->data = $this->CabinetOrder->read(null, $id);
    $quotes = $this->CabinetOrder->Quote->find('list');
    $this->set(compact('quotes', 'pog', 'edgetape', 'stain_color', 'drawers'));
  }

  /**
   * edit_order method
   *
   * @param string $id
   * @return void
   */
  public function edit_order($quote_id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_quote";

    $this->quote_id = $quote_id;
    $this->CabinetOrder->quote_id = $quote_id;

    if ($this->request->is('post') || $this->request->is('put')) {
      $this->request->data['CabinetOrder']['quote_id'] = $quote_id;
      if ($this->CabinetOrder->save($this->request->data)) {
        $this->Session->setFlash(__('The cabinet order has been saved'));
        $this->redirect(array('controller' => 'quotes', 'action' => DETAIL, $quote_id));
      } else {
        $this->Session->setFlash(__('The cabinet order could not be saved. Please, try again.'));
      }
    }
    $pog = $this->CabinetOrder->find('list', array('fields' => 'pog'));
    $edgetape = $this->CabinetOrder->find('list', array('fields' => 'edgetape'));
    $stain_color = $this->CabinetOrder->find('list', array('fields' => 'stain_color'));
    $drawers = $this->CabinetOrder->find('list', array('fields' => 'drawers'));
    $this->request->data = $this->CabinetOrder->find('first', array(
        'conditions' => array('quote_id' => $quote_id)
            ));
    $quotes = $this->CabinetOrder->Quote->find('list');
    $this->set(compact('quotes', 'quote_id', 'pog', 'edgetape', 'stain_color', 'drawers'));
  }

  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function delete($id = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->CabinetOrder->id = $id;
    if (!$this->CabinetOrder->exists()) {
      throw new NotFoundException(__('Invalid cabinet order'));
    }
    if ($this->CabinetOrder->delete()) {
      $this->Session->setFlash(__('Cabinet order deleted'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Cabinet order was not deleted'));
    $this->redirect(array('action' => 'index'));
  }

}
