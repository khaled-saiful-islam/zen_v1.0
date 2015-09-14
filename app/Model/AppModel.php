<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

  /**
   * @desc This varaible contain all information of current login user.
   * @var type Array
   */
  public $loginUser = array();
  public $actsAs = array('Search.Searchable');
  public $filterArgs = array(
      array('name' => 'id', 'type' => 'value'),
  );

  /**
   * Default construction of App Model
   */
  function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->loginUser = AuthComponent::user();
  }

  /**
   * @desc Change date format
   */
  function formatDate($date) {

    $exp = explode("/", $date);

    $year = $month = $day = 0;

    if (isset($exp[2]))
      $year = $exp[2];
    if (isset($exp[1]))
      $month = $exp[1];
    if (isset($exp[0]))
      $day = $exp[0];

    $date = strtotime($year . "-" . $month . "-" . $day);

    return date("Y-m-d", $date);
  }

  /**
   * @desc Set the Time Format
   */
  function formatTime($time) {
    return $time['hour'] . ":" . $time['min'] . " " . $time['meridian'];
  }

  /**
   * @desc Make the Array to Serialized to insert array into database
   * @param: Array
   */
  function getSerialized($data) {
    return serialize($data);
  }

  /**
   * @desc  After fetching data using serialized we need to make it undserilazed
   * @param: Fetched string from the database or Serialize data
   */
  function getUnSerialized($data) {
    return unserialize($data);
  }

  /**
   * @desc Make array to text
   * @param: $arr contain lits of items array
   * @param: $seperator ## to put each itam
   * @return text
   * @input: array('test', 'test2, 'test3)
   * @output: test##test2##test3
   */
  function getImploade($arr, $seperator = "##") {
    if (is_array($arr))
      return implode($seperator, $arr);
    return "";
  }

  /**
   * @desc It make the array from text
   * @param 1: String
   * @param 2: Delimiter or Seperator
   */
  function getExploade($str, $delimiter = "##") {
    return explode($delimiter, $str);
  }

  /**
   * @desc Make array to text
   * @param: $array contain lits of items array
   * @param: $seperator ## to put each itam
   * @return text
   * @input: array('test', 'test2, 'test3)
   * @output: ##test##test2##test3##
   */
  function createSearchCache($array, $seperator = "##") {
    $search_cache = null;
    if (is_array($array) && !empty($array)) {
      $search_cache = $seperator;
      foreach ($array as $value) {
        $search_cache .= $value . $seperator;
      }
    }
    else{
        $search_cache = "##" . $array . "##";
    }
    return $search_cache;
  }

  function SearchCache2Array($string, $seperator = "##") {
    $data = explode($seperator, $string);
    if (count($data) > 1) {
      unset($data[count($data) - 1]);
      unset($data[0]);
    } else {
      if (empty($data[0])) {
        unset($data[0]);
      }
    }
    return $data;
  }

}
