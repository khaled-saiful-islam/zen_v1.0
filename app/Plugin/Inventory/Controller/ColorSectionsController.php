<?php
App::uses('InventoryAppController', 'Inventory.Controller');
/**
 * ColorSections Controller
 *
 * @property ColorSection $ColorSection
 */
class ColorSectionsController extends InventoryAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ColorSection->recursive = 0;
		$this->set('colorSections', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ColorSection->id = $id;
		if (!$this->ColorSection->exists()) {
			throw new NotFoundException(__('Invalid color section'));
		}
		$this->set('colorSection', $this->ColorSection->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ColorSection->create();
			if ($this->ColorSection->save($this->request->data)) {
				$this->Session->setFlash(__('The color section has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The color section could not be saved. Please, try again.'));
			}
		}
		$colors = $this->ColorSection->Color->find('list');
		$this->set(compact('colors'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ColorSection->id = $id;
		if (!$this->ColorSection->exists()) {
			throw new NotFoundException(__('Invalid color section'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ColorSection->save($this->request->data)) {
				$this->Session->setFlash(__('The color section has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The color section could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ColorSection->read(null, $id);
		}
		$colors = $this->ColorSection->Color->find('list');
		$this->set(compact('colors'));
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
		$this->ColorSection->id = $id;
		if (!$this->ColorSection->exists()) {
			throw new NotFoundException(__('Invalid color section'));
		}
		if ($this->ColorSection->delete()) {
			$this->Session->setFlash(__('Color section deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Color section was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
