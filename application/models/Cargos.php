<?php

/**
 * Grupos
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Cargos extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	
	protected $_name = 'cargos';
	protected $_primary='id';
	

	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
}
