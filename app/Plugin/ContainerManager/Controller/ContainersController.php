<?php

App::uses('ContainerManagerAppController', 'ContainerManager.Controller');

/**
 * Container Controller
 *
 * @property WorkOrder $Container
 */
class ContainersController extends ContainerManagerAppController {

    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "container-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_load_container";
        $this->paginate['conditions'] = array( );

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "workorder";
        $this->set("side_bar", $this->side_bar);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $this->layoutOpt['left_nav'] = "container-inventoryskid-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_load_container";

        if( !empty($this->passedArgs['ead']) ) {
            $date = empty($this->passedArgs['ead']) ? "" : date("Y-m-d", strtotime($this->passedArgs['ead']));
            $this->paginate['conditions'] += array( 'Container.ead' => $date );
        }
        if( !empty($this->passedArgs['ship_date']) ) {
            $date = empty($this->passedArgs['ship_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['ship_date']));
            $this->paginate['conditions'] += array( 'Container.ship_date' => $date );
        }
        if( !empty($this->passedArgs['received_date']) ) {
            $date = empty($this->passedArgs['received_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['received_date']));
            $this->paginate['conditions'] += array( 'Container.received_date' => $date );
        }

        $this->Prg->commonProcess();
        $this->paginate['conditions'] += $this->Container->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Container.delete !=' => 1 );
        $containers = $this->paginate();
        $paginate = true;
        $legend = "Containers";
        $this->set(compact('containers', 'paginate', 'legend'));
    }

    public function container_index() {

        if( !empty($this->passedArgs['ead']) ) {
            $date = empty($this->passedArgs['ead']) ? "" : date("Y-m-d", strtotime($this->passedArgs['ead']));
            $this->paginate['conditions'] += array( 'Container.ead' => $date );
        }
        if( !empty($this->passedArgs['ship_date']) ) {
            $date = empty($this->passedArgs['ship_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['ship_date']));
            $this->paginate['conditions'] += array( 'Container.ship_date' => $date );
        }
        if( !empty($this->passedArgs['received_date']) ) {
            $date = empty($this->passedArgs['received_date']) ? "" : date("Y-m-d", strtotime($this->passedArgs['received_date']));
            $this->paginate['conditions'] += array( 'Container.received_date' => $date );
        }

        $this->Prg->commonProcess();
        $this->paginate['conditions'] += $this->Container->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'Container.delete !=' => 1 );
        $containers = $this->paginate();
        $paginate = true;
        $legend = "Containers";
        $this->set(compact('containers', 'paginate', 'legend'));
    }

    public function inventory_skid_index() {
        $this->layoutOpt['left_nav'] = "container-inventoryskid-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_inventory_skid";

        $this->Prg->commonProcess();
        $this->paginate['conditions'] += $this->SkidInventory->parseCriteria($this->passedArgs);
        $skidinventorys = $this->paginate();
        $paginate = true;
        $legend = "Skid Inventory";
        $this->set(compact('skidinventorys', 'paginate', 'legend'));
    }

    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_load_container";

        if( $this->request->is('post') ) {
            $this->Container->create();

            $flag = $this->Container->save($this->request->data);

            App::import('Model', 'ContainerManager.ContainerSkid');
            foreach( $this->request->data['ContainerSkid'] as $skid ) {
                $ContainerSkid_Model = new ContainerSkid();
                $skid_data['skid_no'] = $skid['skid_no'];
                $skid_data['work_order_number'] = $skid['work_order_number'];
                $skid_data['work_order_id'] = $skid['work_order_id'];
                $skid_data['weight'] = $skid['weight'];
                $skid_data['container_id'] = $this->Container->id;
                $ContainerSkid_Model->save($skid_data);
            }
            if( $flag ) {
                $this->Session->setFlash(__('The Container has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'action' => 'container_index' ));
            }
            else {
                $this->Session->setFlash(__('The Container could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
    }

    public function dynamic_skid() {
        $this->autoRender = false;
        $this->render("../Elements/Forms/Container/new_skid_row_dynamic");
    }

    public function getWOSkid($skid_no = null) {
        $this->autoRender = false;
        App::import('Model', 'WorkOrderManager.WorkOrder');
        $WorkOrder_Model = new WorkOrder();
        $WorkOrder_data = $WorkOrder_Model->find('first', array( 'conditions' => array( 'WorkOrder.skid_number' => $skid_no ) ));

        if( !empty($WorkOrder_data) ) {
            $WO_datas = $WorkOrder_Model->find('all', array( 'conditions' => array( 'WorkOrder.skid_number' => $skid_no ), "recursive" => -1 ));

            $wo_number = "";
            $wo_id = "";
            $cnt = count($WO_datas);
            foreach( $WO_datas as $WO_data ) {
                $wo_number .= $WO_data['WorkOrder']['work_order_number'];
                $wo_id .= $WO_data['WorkOrder']['id'];
                if( $cnt > 1 ) {
                    $wo_number .=",";
                    $wo_id .=",";
                }

                $cnt--;
            }
            $data['skid_number'] = $WorkOrder_data['WorkOrder']['skid_number'];
            $data['skid_weight'] = $WorkOrder_data['WorkOrder']['skid_weight'];
            $data['wo_number'] = $wo_number;
            $data['wo_id'] = $wo_id;

            echo json_encode($data);
        }
        else {
            App::import('Model', 'ContainerManager.SkidInventory');
            $SkidInventory_Model = new SkidInventory();
            $SkidInventory_data = $SkidInventory_Model->find('first', array( 'conditions' => array( 'SkidInventory.skid_no' => $skid_no ) ));

            if( !empty($SkidInventory_data) ) {
                $data['skid_number'] = $SkidInventory_data['SkidInventory']['skid_no'];
                $data['skid_weight'] = $SkidInventory_data['SkidInventory']['weight'];
                $data['wo_number'] = null;
                $data['wo_id'] = null;
            }
            else {
                $data['skid_number'] = '';
                $data['skid_weight'] = "0.00";
                $data['wo_number'] = null;
                $data['wo_id'] = null;
            }

            echo json_encode($data);
        }
        exit;
    }

    public function detail($id = null) {
        $this->layoutOpt['left_nav_selected'] = "view_load_container";

        $this->Container->id = $id;
        if( !$this->Container->exists() ) {
            throw new NotFoundException(__('Invalid Container'));
        }
        $container = $this->Container->read(null, $id);

        $this->set(compact('container', 'id'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Container->id = $id;
        if( !$this->Container->exists() ) {
            throw new NotFoundException(__('Invalid Container'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            $this->request->data['Container']['id'] = $id;

            if( $this->Container->save($this->request->data) ) {

                App::import('Model', 'ContainerManager.ContainerSkid');

                foreach( $this->request->data['ContainerSkid'] as $skid ) {
                    $ContainerSkid_Model = new ContainerSkid();
                    $skid_data['skid_no'] = $skid['skid_no'];
                    $skid_data['work_order_number'] = $skid['work_order_number'];
                    $skid_data['work_order_id'] = $skid['work_order_id'];
                    $skid_data['weight'] = $skid['weight'];
                    $skid_data['container_id'] = $this->Container->id;
                    $skid_data['id'] = $skid['id'];
                    $ContainerSkid_Model->save($skid_data);
                }
                $this->Session->setFlash(__('The Container status has been saved'), 'default', array( 'class' => 'text-success' ));

                $this->redirect(array( 'action' => 'detail', $this->Container->id ));
            }
            else {
                $this->Session->setFlash(__('The Container status could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
                $this->redirect(array( 'action' => 'detail', $this->Container->id ));
            }
        }
        $container = $this->Container->find('first', array( 'conditions' => array( 'Container.id' => $id ) ));

        $total = 0;
        foreach( $container['ContainerSkid'] as $c ) {
            $total += $c['weight'];
        }

        $this->set(compact('container', 'total'));
    }

    public function delete($id = null) {
        $this->autoRender = false;
        $container = $this->Container->find('first', array( 'conditions' => array( 'Container.id' => $id ) ));

        $data['Container']['delete'] = 1;
        $data['Container']['id'] = $id;

        $this->Container->save($data);
        $this->redirect(array( 'action' => 'index', $id ));
    }

    public function container_delete($id = null) {
        $this->autoRender = false;
        $container = $this->Container->find('first', array( 'conditions' => array( 'Container.id' => $id ) ));

        $data['Container']['delete'] = 1;
        $data['Container']['id'] = $id;

        $this->Container->save($data);
        $this->redirect(array( 'action' => 'container_index', $id ));
    }

    public function print_detail($id = null) {
        $this->layoutOpt['layout'] = 'report_container';
        $container = $this->Container->find('first', array( 'conditions' => array( 'Container.id' => $id ) ));

        $cnt_skid = count($container['ContainerSkid']);

        $check = array( );
        foreach( $container['ContainerSkid'] as $skid ) {
            $coma = explode(',', $skid['work_order_number']);

            foreach( $coma as $key => $value ) {
                array_push($check, $value);
            }
        }
        $final_array = array_unique($check);
        $wo_cnt = count(array_filter($final_array));

        $reportDate = time();
        $this->set(compact('container', 'id', 'reportDate', 'cnt_skid', 'wo_cnt'));
    }
    
    public function print_skid_label($skid_no = null){
        $this->layoutOpt['layout'] = 'print_skid_label';
        
        App::import('Model', 'ContainerManager.ContainerSkid');
        $ContainerSkid_Model = new ContainerSkid();
        $data = $ContainerSkid_Model->find('first', array( 'conditions' => array( 'ContainerSkid.skid_no' => $skid_no ) ));
        
        $wo = explode(',', $data['ContainerSkid']['work_order_id']);

        $this->set(compact('data', 'skid_no', 'wo'));
    }

}
