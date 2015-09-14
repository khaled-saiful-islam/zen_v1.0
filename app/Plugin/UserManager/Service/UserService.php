<?php
/**
 * Description of UserService
 *
 * @author Sarwar Hossain <http://instalogic.com>
 */
App::uses('UserManagerService', 'UserManager.Service');

class UserService extends UserManagerService{
    
    private $User;
    
    function UserService() {
        APP::uses("User", "UserManager.Model");
        $this->User = new User();
    }
    
    public function add(){
        // Noting do to here 
    }
    
    /**
     * @desc ADD method used to adding new Customer 
     * @param type $data Posted Data
     * @return Ture if save success, False if not success
     */
    public function save($data){
        if(!empty($data)){
            if($this->User->save($data)){
                return $this->User->id;
            }
            
            return false;
        }else
            return false;
    }
    
    /**
     *@desc: Edit method use to Edit any customer informations
     * @param type $id
     * @return type True/False
     */
    function edit($id){
        return $this->User->find("first", array("conditions" => array("User.id" => $id)));
    }
    
    
    /**
     *@desc : Delete Any customer information 
     * @param type $id
     * @return type 
     */
    function delete($id){
        $this->User->id=$id;
        if($this->User->delete($id))
            return true;
        else
            return false;
    }
   
    /**
     *@desc : View any Customer Information
     * @param type $id
     * @return type Data Array of a customer 
     */
    function view($id){
        return $this->User->find("first", array("conditions" => array("User.id" => $id)));
    }
    
    /**
     * @desc This method display whole list of customers
     * @param type $controller This is controller objict
     * @param type isPaginate True/False 
     * @return Return detail list of customer array
     */
    function viewAll($controller, $isPaginate=false){
        if($isPaginate)
            $data = $controller->paginate('User');
        else 
            $data = $controller->find("all");
        return $data;
    }
    
}

?>
