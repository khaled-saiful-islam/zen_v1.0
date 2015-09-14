<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * InventoryLookups Controller
 *
 * @property InventoryLookup $InventoryLookup
 */
class MaterialsController extends InventoryAppController {

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
        $this->layoutOpt['left_nav_selected'] = "view_material";

        $this->Material->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Material->parseCriteria($this->passedArgs);

        $materials = $this->paginate('Material');
        $paginate = true;
        $legend = "Materials";
        $this->set(compact('materials', 'paginate', 'legend'));
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null, $type = null) {
        $this->layoutOpt['left_nav_selected'] = "view_material";

        $this->Material->id = $id;
        if( !$this->Material->exists() ) {
            throw new NotFoundException(__('Invalid item'));
        }

        $material = $this->Material->read(null, $id);

        $this->set(compact('material', 'id'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_material";

        if( $this->request->is('post') ) {
            if( $this->Material->save($this->request->data) ) {
                $this->Session->setFlash(__('The Material has been saved'));
                $this->redirect(array( 'controller' => 'materials', 'action' => DETAIL, $this->Material->id ));
            }
            else {
                $this->Session->setFlash(__('The Material could not be saved. Please, try again.'));
            }
        }
        else {
            App::import('Model', 'Inventory.MaterialGroup');
            $materialgroup = new MaterialGroup();
            $data = $materialgroup->find('first', array( 'conditions' => array( 'MaterialGroup.default' => 1 ) ));
            $this->set(compact('data'));
        }
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Material->id = $id;
        if( !$this->Material->exists() ) {
            throw new NotFoundException(__('Invalid inventory lookup'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->Material->save($this->request->data) ) {
                $this->Session->setFlash(__('The Material has been saved'));
                $this->redirect(array( 'controller' => 'materials', 'action' => DETAIL, $this->Material->id ));
            }
            else {
                $this->Session->setFlash(__('The Material could not be saved. Please, try again.'));
            }
        }
        else {
            $this->request->data = $this->Material->read(null, $id);
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
        $this->Material->id = $id;
        if( !$this->Material->exists() ) {
            throw new NotFoundException(__('Invalid Material'));
        }
        if( $this->Material->delete() ) {
            $this->Session->setFlash(__('Material deleted'));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->Session->setFlash(__('Material was not deleted'));
        $this->redirect(array( 'action' => 'index' ));
    }

    function get_material_list_by_material_group() {
        $material_group_id = $this->request->query['term'];
        App::uses("Material", "Inventory.Model");
        $material = new Material();
        $material_list = array( );
        $material_list = $material->find("all", array( 'conditions' => array( 'material_group_id' => $material_group_id ), 'order' => array( 'name' => 'asc' ) ));

        $return_data = array( );
        $index = 0;
        foreach( $material_list as $id => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val['Material']['id'];
                $return_data[$index]['text'] = $val['Material']['name'];
                $return_data[$index]['detail'] = $val['Material'];
                $index++;
            }
        }
        print json_encode($return_data);
        exit;
    }

}
