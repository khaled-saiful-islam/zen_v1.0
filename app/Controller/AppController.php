<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @copyright     Copyright 2012, Instalogic Inc. (http://instalogic.com)
 * @package       app.Controller
 * @since         InstalogicProject 0.0.1v
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 */
class AppController extends Controller {

  /**
   * @var type Array
   * @desc Keep current Login user data
   */
	public $isAjax; 	
  public $loginUser = array();
  var $paginate = array(
      'limit' => 25,
  );

  /**
   * @desc This variable containa all the information of a layout
   * @var type Array
   * @uses $this->layoutOpt = array(
   *                           "layout" =>             "template",
   *                           "left_nav" =>           false,
   *                           "left_nav_selected" =>  false,
   *                           "top_nav" =>            "Layout/menu",
   *                           "top_nav_selected" =>   false
   *          );
   */
  public $layoutOpt = array(
      "layout" => "template",
      "left_nav" => false,
      "left_nav_selected" => false,
      "top_nav" => "menu",
      "top_nav_selected" => false
  );

  /**
   * @var type Array
   * @desc Define all components used by the system
   */
  public $components = array(
      "Auth" => array(
          'loginAction' => array('plugin' => 'user_manager', 'controller' => 'users', 'action' => 'login'),
          'loginRedirect' => array('plugin' => 'inventory', 'controller' => 'dashboards', 'action' => 'index'),
          'logoutRedirect' => array('plugin' => 'user_manager', 'controller' => 'users', 'action' => 'login')),
      "Session",
      "RequestHandler",
      'Search.Prg',
      'QuoteItem',
      'InvoiceItem',
      'Calendar',
      'PriceCalculation',
      'Email');

  /**
   * @var type
   * @desc Loading Pre defined Helpers
   */
  public $helpers = array(
      "Html",
      "Form",
      "Session",
      "Util",
      "Commonjs",
      'Js' => array('Jquery')
  );
  public $presetVars = true; // using the model configuration for search module

  /**
   * @desc Loading All predefined Searvices
   * @var type Array
   */
  public $services = array("Service");

  function beforeFilter() {
    parent::beforeFilter();

    $this->loginConfig();
    $this->setLoginData();
    $this->pluginObjtects();
  }

  function afterFilter() {
    parent::afterFilter();
  }

  /**
   * @desc This method used for configuration auth compoennts
   */
  private function loginConfig() {
    $this->Auth->authenticate = array(
        'Form' => array(
            'userModel' => 'User',
            'scope' => array(
                "User.status" => 1
            ),
            'fields' => array(
                "username" => "username",
                "password" => "screetp")
        ),
    );
    //  $this->Auth->allow("login");
  }

  /**
   * @desc Set loginUser variable to View and Controller
   */
  private function setLoginData() {
    if ($this->Auth->loggedIn()) {
      $this->loginUser = AuthComponent::user();
      $this->set("loginUser", $this->loginUser);
    } else {
      if ($this->request->isAjax() == 1) {
        $this->Auth->autoRedirect = false;
        $this->autoRender = false;
        $this->layout = "ajax";
        echo MSG_SESSION_EXPIRE;
      }
      //pr($this->request);
    }
		if($this->request->is("ajax")){
			$this->isAjax = true; 
		}else{
			$this->isAjax = false; 
		}
		
  }

  /**
   * @desc Load All services before filter
   *      This method set all servicies which is from main project and plugins
   *      To Access the server you don't need to create any object, you just
   *      access it directly
   *
   *      example 1: if service is on the main project app/Service/MyService.php
   *      Access: $this->Service->MyService
   *      and this can be access from all controllers ( main project and all
   *      plugin controller)
   *
   *      Example 2: If service is under any plugins for example Customer Manager
   *      app/Plugin/CustomerManager/Service/CustomerService.php
   *      Access: $this->PluginName->ServiceName
   *              ($this->CustomerManager->CustomerService)
   *              This can be access from all controller within this project
   *              No mater which plugin controller your user, you just can call
   *              it and access it.
   */
  private function loadServices() {

    App::uses("Service", "Service");
    $this->Service = new Service();

    foreach ($this->services as $service) {
      if ($service == "Service")
        continue;
      App::uses($service, "Service");
      $this->Service->$service = new $service;
    }

    // enable arr plugins
    $plugins = CakePlugin::loaded();
  }

  /**
   * @desc Create object under this controller for every plugins names
   */
  private function pluginObjtects() {
    $plugins = CakePlugin::loaded();
//        foreach($plugins as $plguin_name){
//            App::uses($plguin_name, "Plugin" . DS . $plguin_name);
//            $this->$plguin_name = new $plguin_name;
//        }
  }

  /**
   *
   * @param type $data Array of item
   *        -"var" => $val
   */
  public function setCustomViewItem($data) {
    foreach ($data as $key => $value) {
      $this->set($key, $value);
    }
  }

  public function beforeRender() {
    parent::beforeRender();

    $this->layout = $this->layoutOpt['layout'];
    $left_nav = "Layout/LeftNavigation/" . $this->layoutOpt['left_nav'];
    $top_nav = "Layout/" . $this->layoutOpt['top_nav'];
    $left_nav_selected = $this->layoutOpt['left_nav_selected'];
    $top_nav_selected = $this->layoutOpt['top_nav_selected'];
    $this->set(compact("left_nav", "top_nav", "left_nav_selected", "top_nav_selected", "isAjax"));
  }

  public function formatDate($date) {

    $exp = explode("/", $date);

    $year = $month = $day = 0;

    if (isset($exp[2]))
      $year = $exp[2];
    if (isset($exp[1]))
      $month = $exp[1];
    if (isset($exp[0]))
      $day = $exp[0];

    $date = strtotime($year . "-" . $month . "-" . $day);

    //date("Y-m-d", strtotime($date))
    return date("Y-m-d", $date);
  }

}
