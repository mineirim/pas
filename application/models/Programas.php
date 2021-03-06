<?php

/**
 * Grupos
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Programas extends App_DefaultModel {
	/**
	 * The default table name 
	 */
    	protected $_rowClass = "Model_Row_Programa";
	protected $_name = 'programas';
	protected $_dependentTables = array('Model_Projetos', 'Model_ObjetivosPrograma', 'Model_MetasPrograma', 'Model_IndicadoresPrograma');
	
	
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
