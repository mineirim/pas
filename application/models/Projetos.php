<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Projetos extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'projetos';
	protected $_dependentTables = array('Model_Projetos','Model_ObjetivosProjeto', 'Model_MetasProjeto', 'Model_IndicadoresProjeto');
	protected $_referenceMap = array (
	                     		'Programas' => array ( 'columns' => 'programa_id', 
	                     							  'refTableClass' => 'Model_Programas', 
	                     							  'refColumns' => 'id' ) ,
								'SubProjetos' => array ( 'columns' => 'projeto_id', 
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


