<?php

App::uses('AppModel', 'Model');

/**
 * Upload Model
 *
 */
class UploadPayment extends AppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'payment_method';
	
	public function beforeSave($options = array()) {
    if(!empty($this->data['UploadPayment']['payment_date'])){
			$this->data['UploadPayment']['payment_date'] = $this->formatDate($this->data['UploadPayment']['payment_date']);
    }
    return true;
  }
}
