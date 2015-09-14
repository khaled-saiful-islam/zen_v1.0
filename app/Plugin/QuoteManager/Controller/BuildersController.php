<?php

App::uses('QuoteManagerAppController', 'QuoteManager.Controller');

/**
 * Builders Controller
 *
 * @property Builder $Builder
 */
class BuildersController extends QuoteManagerAppController {

  /**
   * tasks before render the output
   */
  function beforeFilter() {
    parent::beforeFilter();

    // set the layout
    $this->layoutOpt['left_nav'] = "builder-left-nav";
    $this->layoutOpt['left_nav_selected'] = "view_builder";
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->Builder->recursive = 0;
    $this->set('builders', $this->paginate());
  }

  /**
   * view method
   *
   * @param string $id
   * @return void
   */
  public function detail($id = null) {
    $this->layoutOpt['left_nav_selected'] = "view_builder";

    $this->Builder->id = $id;
    if (!$this->Builder->exists()) {
      throw new NotFoundException(__('Invalid builder'));
    }
    $this->set('builder', $this->Builder->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    $this->layoutOpt['left_nav_selected'] = "add_builder";

    if ($this->request->is('post')) {
      $this->Builder->create();
      if ($this->Builder->save($this->request->data)) {
        $this->Session->setFlash(__('The builder has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->Builder->id));
      } else {
        $this->Session->setFlash(__('The builder could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    }
    $customerTypes = $this->Builder->CustomerType->find('list');
    $this->set(compact('customerTypes'));
  }

  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    $this->Builder->id = $id;
    if (!$this->Builder->exists()) {
      throw new NotFoundException(__('Invalid builder'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Builder->save($this->request->data)) {
        $this->Session->setFlash(__('The builder has been saved'), 'default', array('class' => 'text-success'));
        $this->redirect(array('action' => DETAIL, $this->Builder->id));
      } else {
        $this->Session->setFlash(__('The builder could not be saved. Please, try again.'), 'default', array('class' => 'text-error'));
      }
    } else {
      $this->request->data = $this->Builder->read(null, $id);
    }
    $customerTypes = $this->Builder->CustomerType->find('list');
    $this->set(compact('customerTypes'));
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
    $this->Builder->id = $id;
    if (!$this->Builder->exists()) {
      throw new NotFoundException(__('Invalid builder'));
    }
    if ($this->Builder->delete()) {
      $this->Session->setFlash(__('Builder deleted'), 'default', array('class' => 'text-success'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Builder was not deleted'), 'default', array('class' => 'text-error'));
    $this->redirect(array('action' => 'index'));
  }

}
