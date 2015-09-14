<?php
App::uses('InventoryAppController', 'Inventory.Controller');
/**
 * ColorMaterials Controller
 *
 * @property ColorMaterial $ColorMaterial
 */
class ColorMaterialsController extends InventoryAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ColorMaterial->recursive = 0;
		$this->set('colorMaterials', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ColorMaterial->id = $id;
		if (!$this->ColorMaterial->exists()) {
			throw new NotFoundException(__('Invalid color material'));
		}
		$this->set('colorMaterial', $this->ColorMaterial->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ColorMaterial->create();
			if ($this->ColorMaterial->save($this->request->data)) {
				$this->Session->setFlash(__('The color material has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The color material could not be saved. Please, try again.'));
			}
		}
		$colors = $this->ColorMaterial->Color->find('list');
		$materials = $this->ColorMaterial->Material->find('list');
		$colorSections = $this->ColorMaterial->ColorSection->find('list');
		$inventoryLookups = $this->ColorMaterial->InventoryLookup->find('list');
		$this->set(compact('colors', 'materials', 'colorSections', 'inventoryLookups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ColorMaterial->id = $id;
		if (!$this->ColorMaterial->exists()) {
			throw new NotFoundException(__('Invalid color material'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ColorMaterial->save($this->request->data)) {
				$this->Session->setFlash(__('The color material has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The color material could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ColorMaterial->read(null, $id);
		}
		$colors = $this->ColorMaterial->Color->find('list');
		$materials = $this->ColorMaterial->Material->find('list');
		$colorSections = $this->ColorMaterial->ColorSection->find('list');
		$inventoryLookups = $this->ColorMaterial->InventoryLookup->find('list');
		$this->set(compact('colors', 'materials', 'colorSections', 'inventoryLookups'));
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
		$this->ColorMaterial->id = $id;
		if (!$this->ColorMaterial->exists()) {
			throw new NotFoundException(__('Invalid color material'));
		}
		if ($this->ColorMaterial->delete()) {
			$this->Session->setFlash(__('Color material deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Color material was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
