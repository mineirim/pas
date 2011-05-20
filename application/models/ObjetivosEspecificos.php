<?php

/**
 * ObjetivosEspecificos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_ObjetivosEspecificos extends App_DefaultModel {
	/**
	 * The default table name 
	 */
        protected $_rowClass = "Model_Row_Objetivo";
	protected $_name = 'objetivos_especificos';
	protected $_dependentTables = array('Model_Metas',
										'Model_Estrategias', 
										'Model_Parcerias');
	protected $_referenceMap = array (
	                     		'Projetos' => array ( 'columns' => 'projeto_id', 
	                     							  'refTableClass' => 'Model_Projetos', 
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


