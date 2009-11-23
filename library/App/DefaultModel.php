<?php

/**
 * DefaultModel
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class App_DefaultModel extends Zend_Db_Table_Abstract {

	public function init(){
		parent::init();
		$this->_schema = Zend_Registry::get('schema');
	}
}

