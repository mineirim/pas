<?php

/**
 * Favoritos
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Favoritos extends App_DefaultModel {

	
	/**
	 * The default table name 
	 */
	
	
	protected $_name = 'favoritos';

	/*
	 * função insert
	 * 
	 * @param string $caminho caminho url da página.
	 */
	public function insert($caminho){
		
		$auth = Zend_Auth::getInstance();
		$dados = array('usuario_id' => $auth->getIdentity()->id,
						'caminho' => $caminho);
		return parent::insert($dados);
	}

}


