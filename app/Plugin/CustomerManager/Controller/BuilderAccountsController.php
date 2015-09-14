<?php

App::uses('CustomerManagerAppController', 'CustomerManager.Controller');

/**
 * CustomerAddresses Controller
 *
 * @property CustomerAddress $CustomerAddress
 */
class BuilderAccountsController extends CustomerManagerAppController {

    /**
     * add method
     *
     * @return void
     */
    public function edit($customer_id=null,$section=null) {       
        
        if ($this->request->is('post') || $this->request->is('put')) {            
            if ($this->BuilderAccount->save($this->request->data)) {
                $this->Session->setFlash(__('The customer has been saved'),'default',array('class'=>'text-success'));
                $this->redirect(array('controller'=>'customers','action' => 'detail_section', $customer_id,$section));
            } else {
                $this->Session->setFlash(__('The customer could not be saved. Please, try again.'), 'default', array('class'=>'text-error'));
                
            }
        }else{
            $this->redirect(array('controller'=>'customers','action' => EDIT, $customer_id,$section));
        }
    }
}
