<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Colors Controller
 *
 * @property Color $Color
 */
class ColorsController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "color-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_color";

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
        $this->Color->recursive = 1;
        $this->layoutOpt['left_nav_selected'] = "view_color";

        if( !isset($this->params['named']['limit']) ) {
            $this->paginate['limit'] = REPORT_LIMIT;
            $this->paginate['maxLimit'] = REPORT_LIMIT;
        }
        elseif( isset($this->params['named']['limit']) && $this->params['named']['limit'] != 'All' ) {
            $this->paginate['limit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
            $this->paginate['maxLimit'] = isset($this->params['named']['limit']) ? $this->params['named']['limit'] : REPORT_LIMIT;
        }
        else {
            $this->paginate['limit'] = 0;
            $this->paginate['maxLimit'] = 0;
        }
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->Color->parseCriteria($this->passedArgs);

        $colors = $this->paginate();
        $paginate = true;
        $legend = "Colors";
        //pr($colors);
        $this->set(compact('colors', 'paginate', 'legend'));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->layoutOpt['left_nav_selected'] = "view_color";
        $this->Color->id = $id;
        if( !$this->Color->exists() ) {
            throw new NotFoundException(__('Invalid color'));
        }
        $this->set('color', $this->Color->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_color";
        if( $this->request->is('post') ) {
            $this->Color->create();
            if( $this->Color->save($this->request->data) ) {
                $this->Session->setFlash(__('The color has been saved'));
                $this->redirect(array( 'action' => 'index' ));
            }
            else {
                $this->Session->setFlash(__('The color could not be saved. Please, try again.'));
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
        $this->layoutOpt['left_nav_selected'] = "view_color";
        $this->Color->id = $id;
        if( !$this->Color->exists() ) {
            throw new NotFoundException(__('Invalid color'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->Color->save($this->request->data) ) {
                $this->Session->setFlash(__('The color has been saved'));
                $this->redirect(array( 'action' => 'index' ));
            }
            else {
                $this->Session->setFlash(__('The color could not be saved. Please, try again.'));
            }
        }
        else {
            $this->request->data = $this->Color->read(null, $id);
            $datas = $this->request->data;
            $this->set(compact('datas'));
        }
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
        $this->Color->id = $id;
        if( !$this->Color->exists() ) {
            throw new NotFoundException(__('Invalid color'));
        }
        if( $this->Color->delete() ) {
            $this->Session->setFlash(__('Color deleted'));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->Session->setFlash(__('Color was not deleted'));
        $this->redirect(array( 'action' => 'index' ));
    }

}
