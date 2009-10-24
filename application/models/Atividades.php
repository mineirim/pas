<?php

/**
 * Atividades
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Atividades extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'atividades';
	protected $_referenceMap = array (
	                     		'Operacoes' => array ( 'columns' => 'operacao_id', 
	                     							  'refTableClass' => 'Model_Operacoes', 
	                     							  'refColumns' => 'id' ) 							
								);	

	public function update($dados, $where){
		
		$auth = Zend_Auth::getInstance();
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_data']=date('Y/m/d h:i:s', time());
		return parent::update($dados,$where);
		
	}
	public function insert($dados){
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		return parent::insert($dados);
	}

}


