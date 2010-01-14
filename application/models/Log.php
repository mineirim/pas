<?php

/**
 * Atividades
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Log extends Zend_Db_Table_Abstract {

	
	/**
	 * The default table name 
	 */
	
	
	protected $_name = 'log';
	public function insert($dados){
		
		$auth = Zend_Auth::getInstance();
		$dados['usuario_id']= $auth->getIdentity()->id;
		return parent::insert($dados);
	}

}


