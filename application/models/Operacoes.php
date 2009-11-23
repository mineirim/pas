<?php

/**
 * Operacoes
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Operacoes extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'operacoes';
	// dúvida: é necessário quando eu não estou atualizando uma subpágina na mesma página?
	protected $_dependentTables = array('Model_Atividades');
	protected $_referenceMap = array (
	                     		'Model_Metas' => array ( 'columns' => 'meta_id', 
	                     							  'refTableClass' => 'Model_Metas', 
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


