<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_ObjetivosAcao extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'objetivos_acao';
	protected $_dependentTables = array('Model_MetasAcao','Model_EstrategiasAcao');
	protected $_referenceMap = array (
	                     		'Acoes' => array ( 'columns' => 'acao_id', 
	                     							  'refTableClass' => 'Model_Acoes', 
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


