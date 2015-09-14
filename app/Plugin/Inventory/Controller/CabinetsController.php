<?php

App::uses('InventoryAppController', 'Inventory.Controller');

/**
 * Cabinets Controller
 *
 * @property Cabinet $Cabinet
 */
class CabinetsController extends InventoryAppController {

    /**
     * tasks before render the output
     */
    private $cabinet_data_settings = array( );

    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "cabinet-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_cabinet";

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
        $this->Cabinet->recursive = 0;

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
        $this->paginate['conditions'] = $this->Cabinet->parseCriteria($this->passedArgs);
        $cabinets = $this->paginate();
        $paginate = true;
        $legend = "Cabinets";
        foreach( $cabinets as $index => $row ) {
            $cabinets[$index]['Cabinet']['product_type'] = $this->Cabinet->SearchCache2Array($row['Cabinet']['product_type']);
        }

        $this->set(compact('cabinets', 'paginate', 'legend'));
    }

    /**
     * detail method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->Cabinet->id = $id;
        if( !$this->Cabinet->exists() ) {
            throw new NotFoundException(__('Invalid cabinet'));
        }

        App::uses("CabinetsItem", "Inventory.Model");
        $cabinets_items_model = new CabinetsItem();
        $cabinets_items_model->recursive = 1;
        $cabinets_items = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $id, 'accessories' => '0' ) ));
        $cabinets_accessories = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $id, 'accessories' => '1' ) ));

        $cabinet = $this->request->data = $this->Cabinet->read(null, $id);
        $cabinet['Cabinet']['product_type'] = $this->Cabinet->SearchCache2Array($cabinet['Cabinet']['product_type']);

        $this->set('cabinet', $cabinet);
        $this->set('cabinet_id', $id);
        $this->set('edit', true);
        $this->set('cabinets_items', $cabinets_items);
        $this->set('cabinets_accessories', $cabinets_accessories);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_cabinet";
        $section = 'basic';

        if( $this->request->is('post') ) {
            $this->Cabinet->create();
            if( $this->Cabinet->save($this->request->data) ) {
                $this->Session->setFlash(__('The cabinet has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'action' => DETAIL, $this->Cabinet->id ));
            }
            else {
                $this->Session->setFlash(__('The cabinet could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        $items = $this->Cabinet->Item->find('list');
        $this->set(compact('items', 'section'));
    }

    /**
     * edit method
     *
     * @param string $cabinet_id
     * @return void
     */
    public function edit($cabinet_id = null, $section = null) {
        $this->Cabinet->id = $cabinet_id;
        if( !$this->Cabinet->exists() ) {
            throw new NotFoundException(__('Invalid cabinet'));
        }

        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->Cabinet->save($this->request->data) ) {
                //$this->Session->setFlash(__('The cabinet has been updated'), 'default', array('class' => 'text-success'));
                //$this->redirect(array('action' => 'detail_section', $cabinet_id, $section));
                if( ($section != "basic") && !is_null($section) ) {
                    $this->redirect(array( 'action' => 'detail_section', $cabinet_id, $section ));
                }
                else {
                    $this->redirect(array( 'action' => DETAIL, $cabinet_id ));
                }
            }
            else {
                //$this->Session->setFlash(__('The cabinet could not be updated. Please, try again.'), 'default', array('class' => 'text-error'));
            }
        }
        else {
            $this->request->data = $this->Cabinet->read(null, $cabinet_id);
            $this->request->data['Cabinet']['product_type'] = $this->Cabinet->SearchCache2Array($this->request->data['Cabinet']['product_type']);
        }
        $items = $this->Cabinet->Item->find('list');
        $this->set(compact('items', 'section', 'cabinet_id'));
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
        $this->Cabinet->id = $id;
        if( !$this->Cabinet->exists() ) {
            throw new NotFoundException(__('Invalid cabinet'));
        }
        if( $this->Cabinet->delete() ) {
            $this->Session->setFlash(__('Cabinet deleted'), 'default', array( 'class' => 'text-success' ));
            $this->redirect(array( 'action' => 'index' ));
        }
        $this->Session->setFlash(__('Cabinet was not deleted'), 'default', array( 'class' => 'text-error' ));
        $this->redirect(array( 'action' => 'index' ));
    }

    /**
     * detail door drawer method
     *
     * @param string $id
     * @return void
     */
    public function detail_section($cabinet_id = null, $section = null, $edit = true) {
        $this->Cabinet->id = $cabinet_id;
        if( !$this->Cabinet->exists() ) {
            throw new NotFoundException(__('Invalid cabinet'));
        }
        $cabinet = $this->Cabinet->read(null, $cabinet_id);

        App::uses("CabinetsItem", "Inventory.Model");
        $cabinets_items_model = new CabinetsItem();
        $cabinets_items_model->recursive = 1;
        $cabinets_items = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $cabinet_id, 'accessories' => '0' ) ));
        $cabinets_accessories = $cabinets_items_model->find('all', array( 'conditions' => array( 'cabinet_id' => $cabinet_id, 'accessories' => '1' ) ));

        $this->set(compact('cabinet', 'edit', 'section', 'edit', 'cabinets_items', 'cabinets_accessories'));
    }

    public function report($limit = REPORT_LIMIT) {
        $this->layoutOpt['left_nav'] = "";
        $this->layoutOpt['left_nav_selected'] = "";

        $this->Cabinet->recursive = 0;
        if( $limit != 'All' ) {
            $this->paginate['limit'] = $limit;
            $this->Prg->commonProcess();
            $this->paginate['conditions'] = $this->Cabinet->parseCriteria($this->passedArgs);
            $cabinets = $this->paginate();
        }
        else {
            $cabinets = $this->Cabinet->find('all');
        }

        $paginate = false;
        $legend = "Cabinets Report";

        $this->set(compact('cabinets', 'limit', 'paginate', 'legend'));
    }

    public function listing_report_print($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';

        $this->Cabinet->recursive = 0;

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
        $this->paginate['conditions'] = $this->Cabinet->parseCriteria($this->passedArgs);
        $cabinets = $this->paginate();
        $paginate = false;
        $legend = "Cabinets";
        $reportTitle = "General Listing Report";
        $reportDate = date('l, F d, Y');

        $this->set(compact('cabinets', 'paginate', 'legend', 'reportTitle', 'reportDate'));
    }

    /**
     * print/pdf view method
     *
     * @param string $id
     * @return void
     */
    public function print_detail($id = null) {
        $this->layoutOpt['layout'] = 'report';

        $this->Cabinet->id = $id;
        if( !$this->Cabinet->exists() ) {
            throw new NotFoundException(__('Invalid cabinet'));
        }
        $reportTitle = "Detail Report";
        $reportDate = date('l, F d, Y');
        $cabinet = $this->Cabinet->read(null, $id);

        $this->set(compact('cabinet', 'reportTitle', 'reportDate'));
    }

    function get_cabinet_list() {
        $name = $this->request->query['term'];
        App::uses("Cabinet", "Inventory.Model");
        $cabinet = new Cabinet();
        $cabinet_list = array( );
        $cabinet_list = $cabinet->find("all", array( 'conditions' => array( 'name like' => "%{$name}%" ), 'order' => array( 'Cabinet.name' => 'asc' ), 'limit' => 10 ));

        $return_data = array( );
        $index = 0;
        foreach( $cabinet_list as $id => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val['Cabinet']['id'];
                $return_data[$index]['text'] = $val['Cabinet']['name'];
                $return_data[$index]['detail'] = $val['Cabinet'];
                $index++;
            }
        }
        print json_encode($return_data);
        exit;
    }

    function cabinet_json() {
        $id = $this->request->query['term'];
        App::uses("Cabinet", "Inventory.Model");
        $cabinet = new Cabinet();
        $cabinet_list = array( );
        $cabinet_list = $cabinet->find("all", array( 'conditions' => array( 'Cabinet.id' => $id ), 'order' => array( 'Cabinet.name' => 'asc' ), 'limit' => 1 ));

        $return_data = array( );
        foreach( $cabinet_list as $id => $cabinet_detail ) {
            if( $cabinet_detail ) {
                $return_data['id'] = $cabinet_detail['Cabinet']['id'];
                $return_data['text'] = $cabinet_detail['Cabinet']['name'];
                $return_data['item_type'] = 'cabinet';
                $return_data['detail'] = $cabinet_detail['Cabinet'];
                $return_data['door_count'] = (int) $cabinet_detail['Cabinet']['top_door_count'] + (int) $cabinet_detail['Cabinet']['bottom_door_count']
                        + (int) $cabinet_detail['Cabinet']['top_drawer_front_count'] + (int) $cabinet_detail['Cabinet']['middle_drawer_front_count']
                        + (int) $cabinet_detail['Cabinet']['bottom_drawer_front_count'] + (int) $cabinet_detail['Cabinet']['dummy_drawer_front_count'];
                $return_data['quote_color_required'] = (int) $cabinet_detail['Cabinet']['quote_color_required'];
                $return_data['quote_material_required'] = (int) $cabinet_detail['Cabinet']['quote_material_required'];
                break;
            }
        }
        print json_encode($return_data);
        exit;
    }

}
