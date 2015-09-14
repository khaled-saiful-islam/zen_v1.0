<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * SupplierContacts Controller
 *
 * @property SupplierContact $SupplierContact
 */
class SupplierContactsController extends InventoryAppController {

    /**
     * show_list method
     *
     * @return void
     */
    public function show_list($supplier_id = null) {
        if (isset($supplier_id)) {
            $this->set('supplier_contacts', $this->SupplierContact->find('all', array('conditions'=>array('supplier_id' => $supplier_id))));
            $this->set(compact('supplier_contacts', 'supplier_id'));
        } else {
            throw new NotFoundException(__('Not Found'));
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->SupplierContact->recursive = 0;
        $this->set('supplierContacts', $this->paginate());
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->SupplierContact->id = $id;
        if (!$this->SupplierContact->exists()) {
            throw new NotFoundException(__('Invalid supplier contact'));
        }
        $this->set('supplierContact', $this->SupplierContact->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($id=null) {
        $this->SupplierContact->id = $id;
        if (!$this->SupplierContact->exists()) {
            throw new NotFoundException(__('Invalid supplier contact'));
        }
        if ($this->request->is('post')) {
            $this->SupplierContact->create();
            if ($this->SupplierContact->save($this->request->data)) {
                $this->Session->setFlash(__('The supplier contact has been saved'));
                $this->redirect(array('action' => 'show_list',$id));
            } else {
                $this->Session->setFlash(__('The supplier contact could not be saved. Please, try again.'));
            }
        }
        $suppliers = $this->SupplierContact->Supplier->find('list');
        $addressTypes = $this->SupplierContact->AddressType->find('list');
        $this->set(compact('suppliers', 'addressTypes'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add_sub($supplier_id = null) {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->SupplierContact->create();
            if ($this->SupplierContact->save($this->request->data)) {
                $this->Session->setFlash(__('The supplier contact has been saved'));
                $this->redirect(array('action' => 'show_list', $supplier_id));
            } else {
                $this->Session->setFlash(__('The supplier contact could not be saved. Please, try again.'));
            }
        }
        $suppliers = $this->SupplierContact->Supplier->find('list');
        $addressTypes = $this->SupplierContact->AddressType->find('list');
        $this->request->data = array('SupplierContact' => array('supplier_id' => $supplier_id));
        $legend = "Add Contact Address";
        $this->set(compact('suppliers', 'addressTypes', 'supplier_contact', 'supplier_id','legend'));
        $this->render('Elements/Forms/SupplierContact/supplier-contact-sub-form');
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit_sub($id = null, $supplier_id = null) {
        $this->autoRender = FALSE;

        $this->SupplierContact->id = $id;
        if (!$this->SupplierContact->exists()) {
            throw new NotFoundException(__('Invalid address'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SupplierContact->save($this->request->data)) {
                $this->Session->setFlash(__('The address has been updated'));
                $this->redirect(array('action' => 'show_list', $supplier_id));
            } else {
                $this->Session->setFlash(__('The address could not be updated. Please, try again.'));
            }
        } else {
            $this->request->data = $this->SupplierContact->read(null, $id);
        }
        $addressTypes = $this->SupplierContact->AddressType->find('list');
        $suppliers = $this->SupplierContact->Supplier->find('list');
        $legend = "Edit Contact Address";
        $this->set(compact('addressTypes', 'suppliers','supplier_id','legend'));

        $this->render('Elements/Forms/SupplierContact/supplier-contact-sub-form');
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->SupplierContact->id = $id;
        if (!$this->SupplierContact->exists()) {
            throw new NotFoundException(__('Invalid supplier contact'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SupplierContact->save($this->request->data)) {
                $this->Session->setFlash(__('The supplier contact has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The supplier contact could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->SupplierContact->read(null, $id);
        }
        $suppliers = $this->SupplierContact->Supplier->find('list');
        $addressTypes = $this->SupplierContact->AddressType->find('list');
        $this->set(compact('suppliers', 'addressTypes'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null,$supplier_id=null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->SupplierContact->id = $id;
        if (!$this->SupplierContact->exists()) {
            throw new NotFoundException(__('Invalid supplier contact'));
        }
        if ($this->SupplierContact->delete()) {
            $this->Session->setFlash(__("Supplier's contact has been deleted."));
            $this->redirect(array('controller'=>'suppliers','action' => 'detail',$supplier_id));
        }
        $this->Session->setFlash(__("Supplier's contact has not been deleted."));
        $this->redirect(array('controller'=>'suppliers','action' => 'index'));
    }

}
