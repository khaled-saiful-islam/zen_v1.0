<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * InventoryLookups Controller
 *
 * @property InventoryLookup $InventoryLookup
 */
class MaterialGroupsController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "material-group-nav";
        $this->layoutOpt['left_nav_selected'] = "view_material_group";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'item_template';
        }

        $this->side_bar = "item";
        $this->set("side_bar", $this->side_bar);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->layoutOpt['left_nav_selected'] = "view_material_group";

        $this->MaterialGroup->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->MaterialGroup->parseCriteria($this->passedArgs);

        $materialgroups = $this->paginate('MaterialGroup');
        $paginate = true;
        $legend = "Material Groups";
        $this->set(compact('materialgroups', 'paginate', 'legend'));
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null, $type = null) {
        $this->layoutOpt['left_nav_selected'] = "view_material_group";

        $this->MaterialGroup->id = $id;
        if( !$this->MaterialGroup->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }

        $material_group = $this->MaterialGroup->read(null, $id);

        $this->set(compact('material_group', 'id'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_material_group";

        if( $this->request->is('post') ) {
            if( $this->request->data['MaterialGroup']['default'] == 1 ) {
                $data = $this->MaterialGroup->save($this->request->data);
                $all_datas = $this->MaterialGroup->find("all");
                foreach( $all_datas as $all_data ) {
                    if( $all_data['MaterialGroup']['id'] != $data['MaterialGroup']['id'] ) {
                        $d['MaterialGroup']['id'] = $all_data['MaterialGroup']['id'];
                        $d['MaterialGroup']['default'] = 0;
                        $this->MaterialGroup->save($d);
                    }
                }
                if( $data ) {
                    $this->Session->setFlash(__('The Material group has been saved'));
                    $this->redirect(array( 'controller' => 'material_groups', 'action' => DETAIL, $data['MaterialGroup']['id'] ));
                }
                else {
                    $this->Session->setFlash(__('The Material group could not be saved. Please, try again.'));
                }
            }
            else {
                if( $this->MaterialGroup->save($this->request->data) ) {
                    $this->Session->setFlash(__('The Material group has been saved'));
                    $this->redirect(array( 'controller' => 'material_groups', 'action' => DETAIL, $this->MaterialGroup->id ));
                }
                else {
                    $this->Session->setFlash(__('The Material group could not be saved. Please, try again.'));
                }
            }
        }
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->MaterialGroup->id = $id;
        if( !$this->MaterialGroup->exists() ) {
            throw new NotFoundException(__('Invalid inventory lookup'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->request->data['MaterialGroup']['default'] == 1 ) {
                $data = $this->MaterialGroup->save($this->request->data);
                $all_datas = $this->MaterialGroup->find("all");

                foreach( $all_datas as $all_data ) {
                    if( $all_data['MaterialGroup']['id'] != $id ) {
                        $d['MaterialGroup']['id'] = $all_data['MaterialGroup']['id'];
                        $d['MaterialGroup']['default'] = 0;
                        $this->MaterialGroup->save($d);
                    }
                }
                if( $data ) {
                    $this->Session->setFlash(__('The Material group has been saved'));
                    $this->redirect(array( 'controller' => 'material_groups', 'action' => DETAIL, $id ));
                }
                else {
                    $this->Session->setFlash(__('The Material group could not be saved. Please, try again.'));
                }
            }
            else {
                if( $this->MaterialGroup->save($this->request->data) ) {
                    $this->Session->setFlash(__('The Material Group has been saved'));
                    $this->redirect(array( 'controller' => 'material_groups', 'action' => DETAIL, $this->MaterialGroup->id ));
                }
                else {
                    $this->Session->setFlash(__('The Material Group could not be saved. Please, try again.'));
                }
            }
        }
        else {
            $this->request->data = $this->MaterialGroup->read(null, $id);
        }
        $this->set(compact('id'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if( !$this->request->is('post') ) {
            throw new MethodNotAllowedException();
        }
        $this->MaterialGroup->id = $id;
        if( !$this->MaterialGroup->exists() ) {
            throw new NotFoundException(__('Invalid Material Group'));
        }
        if( $this->MaterialGroup->delete() ) {
            $this->Session->setFlash(__('Material Group deleted'));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->Session->setFlash(__('Material Group was not deleted'));
        $this->redirect(array( 'action' => 'index' ));
    }

}
