<?php

/**
 * Operacoes
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Operacoes extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'operacoes';
	// dúvida: é necessário quando eu não estou atualizando uma subpágina na mesma página?
	protected $_dependentTables = array('Model_Atividades');
	protected $_referenceMap = array (
	                     		'MetasAcao' => array ( 'columns' => 'metas_acao_id', 
	                     							  'refTableClass' => 'Model_MetasAcao', 
	                     							  'refColumns' => 'id' ) 							
								);	

	public function update($dados, $where){
		
		$auth = Zend_Auth::getInstance();
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_data']=date('Y/m/d h:i:s', time());

		// marcone, retirar as 1 linhas abaixo
		$dados['alteracao_usuario_id']= 2;
		
		
		return parent::update($dados,$where);
		
	}
	public function insert($dados){
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;

		// marcone, retirar as 2 linhas abaixo
		$dados['inclusao_usuario_id']= 2;
		$dados['alteracao_usuario_id']= 2;
		
		
		return parent::insert($dados);
	}

}


