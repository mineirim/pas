<?php

/**
 * Parcerias
 *  
 * @author marcone
 * @version 
 */


class Model_Parcerias extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'parcerias';
	protected $_dependentTables = array('Model_ParceriaTipos');
	protected $_referenceMap = array (
	                     		'ObjetivosEspecificos' => array ( 'columns' => 'objetivo_especifico_id', 
	                     							  'refTableClass' => 'Model_ObjetivosEspecificos', 
	                     							  'refColumns' => 'id' ),
								'Parceiros' => array ( 'columns' => 'parceiro_id', 
	                     							  'refTableClass' => 'Model_Parceiros', 
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


