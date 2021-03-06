<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Metas extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'metas';
	protected $_referenceMap = array (
	                     		'Model_ObjetivosEspecificos' => array ( 'columns' => 'objetivo_especifico_id', 
	                     							  'refTableClass' => 'Model_ObjetivosEspecificos', 
	                     							  'refColumns' => 'id' )
								);	
 	protected $_dependentTables = array('Model_Operacoes', 'Model_IndicadoresMeta');
 	
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


