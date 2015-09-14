<?php

App::uses('UserManagerAppController', 'UserManager.Controller');

/**
 * Description of Users
 *
 * @author Sarwar hossain
 */
class UsersController extends UserManagerAppController {

    //put your code here

    public $name = "Users";
    public $uses = array( "UserManager.User" );

    /**
     * @desc: Works like a constructor
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->layoutOpt['left_nav'] = "user";
        $this->layoutOpt['left_nav_selected'] = "view_users";

        if( $this->isAjax ) {
            $this->layoutOpt['layout'] = 'ajax';
        }
        else {
            $this->layoutOpt['layout'] = 'left_bar_template';
        }

        $this->side_bar = "admin";
        $this->set("side_bar", $this->side_bar);
    }

    function beforeRender() {
        parent::beforeRender();
    }

    /**
     * @desc This method just whoing logged in user profile
     */
    function index() {
        $this->User->recursive = 0;

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
        $this->paginate['conditions'] = $this->User->parseCriteria($this->passedArgs);
        $users = $this->paginate();
        $login_user = $this->loginUser;
        $paginate = true;
        $legend = "Users";

        $this->set(compact('users', 'paginate', 'legend', 'login_user'));
    }

    function user_permission_index() {
        $this->User->recursive = 0;

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
        $this->paginate['conditions'] = $this->User->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] += array( 'User.status' => 1 );
        $users = $this->paginate();
        $login_user = $this->loginUser;
        $paginate = true;
        $legend = "Users";

        $this->set(compact('users', 'paginate', 'legend', 'login_user'));
    }

    public function add() {
        $this->layoutOpt['left_nav_selected'] = "add_user";

        if( $this->request->is('post') ) {
            $this->User->create();
            $this->request->data['User']['screetp'] = $this->Auth->password($this->request->data['User']['screetp']);
            if( $this->User->save($this->request->data) ) {
                $this->Session->setFlash(__('User has been saved'), 'default', array( 'class' => 'text-success' ));
                $this->redirect(array( 'action' => DETAIL, $this->User->id ));
            }
            else {
                $this->Session->setFlash(__('User could not be saved. Please, try again.'), 'default', array( 'class' => 'text-error' ));
            }
        }
        $this->set(compact('user_id'));
    }

    public function user_permission_detail($id = null, $modal = null) {
        $this->User->id = $id;
        if( !$this->User->exists() ) {
            throw new NotFoundException(__('Invalid User'));
        }

        $user = $this->User->read(null, $id);

        $this->set(compact('user', 'modal'));
    }

    public function detail($id = null, $modal = null) {
        $this->User->id = $id;
        if( !$this->User->exists() ) {
            throw new NotFoundException(__('Invalid User'));
        }

        $user = $this->User->read(null, $id);

        $this->set(compact('user', 'modal'));
    }

    public function edit($id = null, $section = null) {
        $this->User->id = $id;
        if( !$this->User->exists() ) {
            throw new NotFoundException(__('Invalid customer'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( $this->request->data['User']['screetp'] == "" ) {
                unset($this->request->data['User']['screetp']);
            }
            else {
                $this->request->data['User']['screetp'] = $this->Auth->password($this->request->data['User']['screetp']);
            }
            if( $this->User->save($this->request->data) ) {
                $this->Session->setFlash(__('The User has been saved'));
                $this->redirect(array( 'action' => 'detail_section', $this->User->id, $section ));
            }
            else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
            }
        }
        else {
            $this->request->data = $this->User->read(null, $id);
            $this->request->data['User']['screetp'] = null;
        }
        $this->set(compact('id', 'section'));
    }
    
    public function user_permission_edit($id = null, $section = null) {
        $this->User->id = $id;
        if( !$this->User->exists() ) {
            throw new NotFoundException(__('Invalid customer'));
        }
        if( $this->request->is('post') || $this->request->is('put') ) {
            if( isset($this->request->data['User']['screetp']) && $this->request->data['User']['screetp'] == "" ) {
                unset($this->request->data['User']['screetp']);
            }
            else {
                if(isset($this->request->data['User']['screetp'])){
                    $this->request->data['User']['screetp'] = $this->Auth->password($this->request->data['User']['screetp']);
                }
            }
            if( $this->User->save($this->request->data) ) {
                $this->Session->setFlash(__('The User has been saved'));
                $this->redirect(array( 'plugin' => 'user_manager','controller' => 'users','action' => 'user_permission_detail', $this->User->id));
            }
            else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
            }
        }
        else {
            $this->request->data = $this->User->read(null, $id);
            $this->request->data['User']['screetp'] = null;
        }
        $this->set(compact('id', 'section'));
    }

    /**
     * @desc This method just whoing logged in user profile
     */
    function my_profile() {
        $this->layoutOpt['left_nav_selected'] = "my_profile";
    }

    /**
     * @desc Login Medthod - called by user for login to system & also used for
     *       ACL checking.
     */
    function login() {
        $this->layoutOpt['layout'] = "login";
        if( $this->request->is('post') ) {
            if( $this->Auth->login() ) {
                return $this->redirect($this->Auth->loginRedirect);
            }
            else {
                $this->Session->setFlash(__('Username or password is incorrect'), 'Messages/session', array( "class" => "hello" ), 'auth');
            }
        }
    }

    /**
     * @desc Logout from the system
     */
    function logout() {
        $this->redirect($this->Auth->logout());
    }

    /**
     * view section method
     *
     * @param string $id
     * @return void
     */
    public function detail_section($id = null, $section = null, $modal = null) {
        $this->layoutOpt['left_nav_selected'] = "view_user";
        $this->User->id = $id;
        if( !$this->User->exists() ) {
            throw new NotFoundException(__('Invalid user'));
        }
        $user = $this->User->read(null, $id);
        $this->set(compact('user', 'section', 'modal'));
    }

    function listing_report_print($limit = REPORT_LIMIT) {
        $this->layoutOpt['layout'] = 'report';

        $this->User->recursive = 0;

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
        $this->paginate['conditions'] = $this->User->parseCriteria($this->passedArgs);
        $users = $this->paginate();
        $login_user = $this->loginUser;
        $paginate = false;
        $legend = "Users";

        $this->set(compact('users', 'paginate', 'legend', 'login_user'));
    }

}

?>