<?php

App::uses('QuoteManagerAppController', 'QuoteManager.Controller');

/**
 * QuoteReportsSettings Controller
 *
 * @property QuoteReportsSetting $QuoteReportsSetting
 */
class QuoteReportsSettingsController extends QuoteManagerAppController {

//  public $presetVars = array(
//      'job_name' => array('type' => 'like'),
//      'customer_id' => array('type' => 'lookup', 'modelField' => 'name', 'model' => 'Customer')
//  );
    /**
     * tasks before render the output
     */
    function beforeFilter() {
        parent::beforeFilter();

        // set the layout
        $this->layoutOpt['left_nav'] = "quote-reports-settings-left-nav";
        $this->layoutOpt['left_nav_selected'] = "view_quote-reports-settings";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->QuoteReportsSetting->recursive = 0;
        $this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->QuoteReportsSetting->parseCriteria($this->passedArgs);
        $quoteReportsSettings = $this->paginate();
        $paginate = true;
        $legend = "Quote Reports Settings";

        $this->set(compact('quoteReportsSettings', 'paginate', 'legend'));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function detail($id = null) {
        $this->QuoteReportsSetting->id = $id;
        if( !$this->QuoteReportsSetting->exists() ) {
            throw new NotFoundException(__('Invalid quote reports setting'));
        }
        $this->set('quoteReportsSetting', $this->QuoteReportsSetting->read(null, $id));
        $this->set('edit', true);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if( $this->request->is('post') ) {
            $this->QuoteReportsSetting->create();
            if( $this->QuoteReportsSetting->save($this->request->data) ) {
                $this->flash(__('Quotereportssetting saved.'), array( 'action' => 'index' ));
            }
            else {
                
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
        $this->QuoteReportsSetting->id = $id;
        if( !$this->QuoteReportsSetting->exists() ) {
            throw new NotFoundException(__('Invalid quote reports setting'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->QuoteReportsSetting->save($this->request->data) ) {
//				$this->flash(__('The quote reports setting has been saved.'), array('action' => 'index'));
                $this->redirect(array( 'action' => 'detail', $id ));
            }
            else {
                
            }
        }
        else {
            $this->request->data = $this->QuoteReportsSetting->read(null, $id);
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
        $this->QuoteReportsSetting->id = $id;
        if( !$this->QuoteReportsSetting->exists() ) {
            throw new NotFoundException(__('Invalid quote reports setting'));
        }
        if( $this->QuoteReportsSetting->delete() ) {
            $this->flash(__('Quote reports setting deleted'), array( 'action' => 'index' ));
        }
        $this->flash(__('Quote reports setting was not deleted'), array( 'action' => 'index' ));
        $this->redirect(array( 'action' => 'index' ));
    }

}
